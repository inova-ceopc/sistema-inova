<?php

namespace App\Http\Controllers\Comex\Contratacao;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Exceptions\Handler;
use App\Http\Controllers\Comex\Contratacao\Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;
use App\Models\Comex\Contratacao\ContratacaoDemanda;
use App\Models\Comex\Contratacao\ContratacaoConfereConformidade;
use App\Models\Comex\Contratacao\ContratacaoContaImportador;
use App\Models\Comex\Contratacao\ContratacaoHistorico;
use App\Models\Comex\Contratacao\ContratacaoUpload;
use App\Classes\Comex\Contratacao\ContratacaoPhpMailer;
use App\RelacaoAgSrComEmail;

class ContratacaoController extends Controller
{
    public $pastaPrimeiroNivel = 'EsteiraContratacao';
    public $pastaSegundoNivel;
    public $pastaTerceiroNivel;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Comex.Contratacao.index');   
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('esteiracomex/contratacao/');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {         
        // dd($request->all());     
        if ($request->session()->get('codigoLotacaoFisica') == null || $request->session()->get('codigoLotacaoFisica') === "NULL") {
            $lotacao = $request->session()->get('codigoLotacaoAdministrativa');
        } 
        else {
            $lotacao = $request->session()->get('codigoLotacaoFisica');
        }
        
        try {
            DB::beginTransaction();
            // REALIZA O INSERT NA TABELA DE DEMANDA
            $demanda = new ContratacaoDemanda;
            $demanda->tipoPessoa = $request->tipoPessoa;
            if ($request->tipoPessoa === "PF") {
                $demanda->cpf = $request->cpf;
            } 
            else {
                $demanda->cnpj = $request->cnpj;
            }
            
            $demanda->nomeCliente = $request->nomeCliente;
            $demanda->dadosContaCliente = $request->dadosContaCliente;
            $demanda->tipoOperacao = $request->tipoOperacao;
            $demanda->tipoMoeda = $request->tipoMoeda;
            $demanda->valorOperacao = str_replace(",",".", str_replace(".", "", $request->valorOperacao));
            
            if ($request->tipoOperacao == "Pronto Exportação Antecipado" || $request->tipoOperacao == "Pronto Importação Antecipado") {
                $demanda->dataPrevistaEmbarque = date("Y-m-d", strtotime(str_replace('/', '-', $request->dataPrevistaEmbarque)));
            }
            
            $demanda->statusAtual = "CADASTRADA";
            $demanda->responsavelAtual = $request->session()->get('matricula');
            
            if ($request->session()->get('acessoEmpregadoEsteiraComex') == "SR") {
                $demanda->agResponsavel = null;
                $demanda->srResponsavel = $lotacao;
            } 
            else {
                // CAPTURA A SR RESPONSÁVEL PELA AGÊNCIA
                // dd($lotacao);
                $objRelacaoEmailUnidades = RelacaoAgSrComEmail::where('codigoAgencia', $lotacao)->first();
                // dd($objRelacaoEmailUnidades);
                $demanda->agResponsavel = $lotacao;
                $demanda->srResponsavel = $objRelacaoEmailUnidades->codigoSr;
            }
            
            $demanda->analiseAg = $request->analiseAg;
            $demanda->save();

            // VALIDA SE É OPERACAO DE IMPORTAÇÃO PARA CADASTRO DO DADOS DO BENEFICIARIO E INTERMEDIARIO (SE HOUVER)
            if ($request->tipoOperacao == 'Pronto Importação Antecipado' || $request->tipoOperacao == 'Pronto Importação') {
                $dadosContaImportador = new ContratacaoContaImportador;
                $dadosContaImportador->idDemanda  = $demanda->idDemanda;
                $dadosContaImportador->nomeBeneficiario = $request->nomeBeneficiario;
                $dadosContaImportador->enderecoBeneficiario = $request->enderecoBeneficiario;
                $dadosContaImportador->cidadeBeneficiario = $request->cidadeBeneficiario;
                $dadosContaImportador->paisBeneficiario = $request->paisBeneficiario;
                $dadosContaImportador->nomeBancoBeneficiario = $request->nomeBancoBeneficiario;
                $dadosContaImportador->ibanBancoBeneficiario = $request->ibanBancoBeneficiario;
                $dadosContaImportador->swiftAbaBancoBeneficiario = $request->swiftAbaBancoBeneficiario;
                $dadosContaImportador->numeroContaBeneficiario = $request->numeroContaBeneficiario;
                // VALIDA SE EXITE BANCO INTERMADIARIO
                if ($request->has('temBancoIntermediario')) {
                    $dadosContaImportador->nomeBancoIntermediario = $request->nomeBancoIntermediario;
                    $dadosContaImportador->ibanBancoIntermediario = $request->ibanBancoIntermediario;
                    $dadosContaImportador->contaBancoIntermediario = $request->contaBancoIntermediario;
                    $dadosContaImportador->swiftAbaBancoIntermediario = $request->swiftAbaBancoIntermediario;
                }
                $dadosContaImportador->save();
            }

            // CRIA O DIRETÓRIO PARA UPLOAD DOS ARQUIVOS
            $this->criaDiretorioUploadArquivo($request, $demanda->idDemanda);

            // REALIZA O UPLOAD DOS ARQUIVOS E FAZ O INSERT NAS TABELAS TBL_EST_CONTRATACAO_LINK_UPLOADS E TBL_EST_CONTRATACAO_CONFERE_CONFORMIDADE
            switch ($request->tipoOperacao) {
                case 'Pronto Importação Antecipado':
                    $this->uploadArquivo($request, "uploadInvoice", "INVOICE", $demanda->idDemanda);
                    $this->cadastraChecklist($request, "INVOICE", $demanda->idDemanda);
                    $this->cadastraChecklist($request, "DADOS_CONTA_DO_BENEFICIARIO", $demanda->idDemanda);
                    break;
                case 'Pronto Importação':
                    $this->uploadArquivo($request, "uploadInvoice", "INVOICE", $demanda->idDemanda);
                    $this->cadastraChecklist($request, "INVOICE", $demanda->idDemanda);
                    $this->uploadArquivo($request, "uploadConhecimento", "CONHECIMENTO_DE_EMBARQUE", $demanda->idDemanda);
                    $this->cadastraChecklist($request, "CONHECIMENTO_DE_EMBARQUE", $demanda->idDemanda);
                    $this->uploadArquivo($request, "uploadDi", "DI", $demanda->idDemanda);
                    $this->cadastraChecklist($request, "DI", $demanda->idDemanda);
                    $this->cadastraChecklist($request, "DADOS_CONTA_DO_BENEFICIARIO", $demanda->idDemanda);
                    break;
                case 'Pronto Exportação Antecipado':
                    $this->uploadArquivo($request, "uploadInvoice", "INVOICE", $demanda->idDemanda);
                    $this->cadastraChecklist($request, "INVOICE", $demanda->idDemanda);
                    break;
                case 'Pronto Exportação':
                    $this->uploadArquivo($request, "uploadInvoice", "INVOICE", $demanda->idDemanda);
                    $this->cadastraChecklist($request, "INVOICE", $demanda->idDemanda);
                    $this->uploadArquivo($request, "uploadConhecimento", "CONHECIMENTO_DE_EMBARQUE", $demanda->idDemanda);
                    $this->cadastraChecklist($request, "CONHECIMENTO_DE_EMBARQUE", $demanda->idDemanda);
                    $this->uploadArquivo($request, "uploadDue", "DUE", $demanda->idDemanda);
                    $this->cadastraChecklist($request, "DUE", $demanda->idDemanda);
                    break;
            }
            // DOCUMENTOS DIVERSOS
            if ($request->has('uploadDocumentosDiversos')) {
                $this->uploadArquivo($request, "uploadDocumentosDiversos", "DOCUMENTOS_DIVERSOS", $demanda->idDemanda);
                $this->cadastraChecklist($request, "DOCUMENTOS_DIVERSOS", $demanda->idDemanda);
            }

            // REALIZA O INSERT NA TABELA DE HISTORICO
            $historico = new ContratacaoHistorico;
            $historico->idDemanda = $demanda->idDemanda;
            $historico->tipoStatus = "CADASTRO";
            $historico->dataStatus = date("Y-m-d H:i:s", time());
            $historico->responsavelStatus = $request->session()->get('matricula');
            $historico->area = $lotacao;
            $historico->analiseHistorico = $request->analiseAg;
            $historico->save();
            
            // ENVIA E-MAIL PARA A AGÊNCIA
            if (env('DB_CONNECTION') === 'sqlsrv') {
                $dadosDemandaCadastrada = ContratacaoDemanda::find($demanda->idDemanda);
                $email = new ContratacaoPhpMailer;
                $email->enviarMensageria($request, $dadosDemandaCadastrada, 'demandaCadastrada');
            }
                
            $request->session()->flash('corMensagem', 'success');
            $request->session()->flash('tituloMensagem', "Protocolo #" . str_pad($demanda->idDemanda, 4, '0', STR_PAD_LEFT) . " | Cadastro Realizado com Sucesso!");
            $request->session()->flash('corpoMensagem', "Sua demanda  foi cadastrada com sucesso! para acompanhar todas suas demandas já cadastradas ");
            DB::commit();
            return redirect('esteiracomex/contratacao');
        } catch (\Exception $e) {
            DB::rollback();
            // throw $e;
            $request->session()->flash('corMensagemErroCadastro', 'danger');
            $request->session()->flash('tituloMensagemErroCadastro', "Protocolo não foi cadastrado");
            $request->session()->flash('corpoMensagemErroCadastro', "Aconteceu algum erro durante o cadastro, tente novamente.");
            return redirect('esteiracomex/contratacao');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comex\Contratacao\ContratacaoDemanda $demandaContratacao
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(ContratacaoDemanda $demandaContratacao, $id)
    {       
        $dadosRelacionamentoDemanda = $demandaContratacao->with([
            'EsteiraContratacaoHistorico',
            'EsteiraContratacaoConfereConformidade',
            'EsteiraContratacaoUpload' => function($query) { $query->where('TBL_EST_CONTRATACAO_LINK_UPLOADS.excluido', 'NAO'); },
            'EsteiraContratacaoContaImportador'
        ])->where('TBL_EST_CONTRATACAO_DEMANDAS.idDemanda', $id)
        ->get();

        // dd($dadosRelacionamentoDemanda);
        return json_encode($dadosRelacionamentoDemanda); 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comex\Contratacao\ContratacaoDemanda $demandaContratacao
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showComplemento(Request $request, ContratacaoDemanda $demandaContratacao, $id)
    {
        $dadosRelacionamentoDemanda = $demandaContratacao->with([
            'EsteiraContratacaoHistorico',
            'EsteiraContratacaoConfereConformidade',
            'EsteiraContratacaoUpload',
            'EsteiraContratacaoContaImportador'
        ])->where('TBL_EST_CONTRATACAO_DEMANDAS.idDemanda', $id)->get();

        return json_encode($dadosRelacionamentoDemanda);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // $dadosDemanda = ContratacaoDemanda::find($id);
        // $dadosImportador = ContratacaoContaImportador::where('idDemanda', $dadosDemanda->idDemanda)->get();
        // $dadosUpload = ContratacaoUpload::where('idDemanda', $dadosDemanda->idDemanda)->get();
        // $dadosConformidade = ContratacaoConfereConformidade::where('idDemanda', $dadosDemanda->idDemanda)->get();
        // $dadosHistorico = ContratacaoHistorico::where('idDemanda', $dadosDemanda->idDemanda)->get();

        // return view('Comex.Contratacao.analiseComBlade', compact('dadosDemanda', 'dadosImportador', 'dadosUpload', 'dadosConformidade', 'dadosHistorico'));
        $demanda = $id;
        return view('Comex.Contratacao.analise', compact('demanda'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function update(Request $request, $id)
    {       
        if ($request->session()->get('codigoLotacaoFisica') == null || $request->session()->get('codigoLotacaoFisica') === "NULL") {
            $lotacao = $request->session()->get('codigoLotacaoAdministrativa');
        } else {
            $lotacao = $request->session()->get('codigoLotacaoFisica');
        }
        try {
            // REALIZA O UPDATE DA TABELA DE DEMANDAS
            $demanda = ContratacaoDemanda::find($id);
            // dd($demanda);
            // $demanda->tipoPessoa = $request->tipoPessoa;
            // $demanda->cpf = $request->cpf;
            // $demanda->cnpj = $request->cnpj;
            // $demanda->nomeCliente = $request->nomeCliente;
            // $demanda->tipoOperacao = $request->tipoOperacao;
            // $demanda->tipoMoeda = $request->tipoMoeda;
            // $demanda->valorOperacao = $request->valorOperacao;
            // $demanda->dataPrevistaEmbarque = $request->dataPrevistaEmbarque;
            $demanda->dataLiquidacao = date("Y-m-d", strtotime(str_replace('/', '-', $request->input('data.dataLiquidacao'))));
            $demanda->numeroBoleto = $request->input('data.numeroBoleto');
            $demanda->statusAtual = $request->input('data.statusGeral');
            // $demanda->responsavelAtual = $request->session()->get('matricula');
            // $demanda->agResponsavel = $request->agResponsavel;
            // $demanda->srResponsavel = $request->srResponsavel;
            $demanda->analiseCeopc = $request->input('data.observacoesCeopc');
            // $demanda->analiseAg = $request->analiseAg;
            $demanda->responsavelCeopc =  $request->session()->get('matricula');
            $demanda->save();

            // VALIDA SE É OPERACAO DE IMPORTAÇÃO PARA CADASTRO DO DADOS DO BENEFICIARIO E INTERMEDIARIO (SE HOUVER)
            if ($request->tipoOperacao == 'Pronto Importação Antecipado' || $request->tipoOperacao == 'Pronto Importação') {
                $dadosContaImportador = ContratacaoContaImportador::find($id);
                $dadosContaImportador->nomeBeneficiario = $request->nomeBeneficiario;
                $dadosContaImportador->enderecoBeneficiario = $request->enderecoBeneficiario;
                $dadosContaImportador->cidadeBeneficiario = $request->cidadeBeneficiario;
                $dadosContaImportador->paisBeneficiario = $request->paisBeneficiario;
                $dadosContaImportador->nomeBancoBeneficiario = $request->nomeBancoBeneficiario;
                $dadosContaImportador->ibanBancoBeneficiario = $request->ibanBancoBeneficiario;
                $dadosContaImportador->swiftAbaBancoBeneficiario = $request->swiftAbaBancoBeneficiario;
                $dadosContaImportador->numeroContaBeneficiario = $request->numeroContaBeneficiario;
                // VALIDA SE EXITE BANCO INTERMADIARIO
                if ($request->has('nomeBancoIntermediario')) {
                    $dadosContaImportador->nomeBancoIntermediario = $request->nomeBancoIntermediario;
                    $dadosContaImportador->ibanBancoIntermediario = $request->ibanBancoIntermediario;
                    $dadosContaImportador->contaBancoIntermediario = $request->contaBancoIntermediario;
                    $dadosContaImportador->swiftAbaBancoIntermediario = $request->swiftAbaBancoIntermediario;
                }
                $dadosContaImportador->save();
            }

            // REALIZA O UPDATE DA TABELA DE UPLOAD
            for ($i = 0; $i < sizeof($request->excluirDocumentos); $i++) { 
                $upload = ContratacaoUpload::find($request->input('excluirDocumentos.' . $i . '.idUploadLink'));
                $upload->excluido = $request->input('excluirDocumentos.' . $i . '.excluir');
                $upload->dataExcluido = date("Y-m-d H:i:s", time());
                $upload->save();
            }
            
            // REALIZA O UPDATE DA TABELA CONFORMIDADE
            if ($request->input('data.idINVOICE') != '') {
                $conformidade = ContratacaoConfereConformidade::find($request->input('data.idINVOICE'));
                $conformidade->statusDocumento = $request->input('data.statusInvoice');
                $conformidade->dataConferencia = date("Y-m-d H:i:s", time());
                $conformidade->save();
            }
            if ($request->input('data.idCONHECIMENTO_DE_EMBARQUE') != '') {
                $conformidade = ContratacaoConfereConformidade::find($request->input('data.idCONHECIMENTO_DE_EMBARQUE'));
                $conformidade->statusDocumento = $request->input('data.statusConhecimento');
                $conformidade->dataConferencia = date("Y-m-d H:i:s", time());
                $conformidade->save();
            }
            if ($request->input('data.idDI') != '') {
                $conformidade = ContratacaoConfereConformidade::find($request->input('data.idDI'));
                $conformidade->statusDocumento = $request->input('data.statusDi');
                $conformidade->dataConferencia = date("Y-m-d H:i:s", time());
                $conformidade->save();
            }
            if ($request->input('data.idDUE') != '') {
                $conformidade = ContratacaoConfereConformidade::find($request->input('data.idDUE'));
                $conformidade->statusDocumento = $request->input('data.statusDue');
                $conformidade->dataConferencia = date("Y-m-d H:i:s", time());
                $conformidade->save();
            }
            if ($request->input('data.idDADOS_CONTA_DO_BENEFICIARIO') != '') {
                $conformidade = ContratacaoConfereConformidade::find($request->input('data.idDADOS_CONTA_DO_BENEFICIARIO'));
                $conformidade->statusDocumento = $request->input('data.statusDadosBancarios');
                $conformidade->dataConferencia = date("Y-m-d H:i:s", time());
                $conformidade->save();
            }
            if ($request->input('data.idDOCUMENTOS_DIVERSOS') != '') {
                $conformidade = ContratacaoConfereConformidade::find($request->input('data.idDOCUMENTOS_DIVERSOS'));
                $conformidade->statusDocumento = $request->input('data.statusDocumentosDiversos');
                $conformidade->dataConferencia = date("Y-m-d H:i:s", time());
                $conformidade->save();
            }

            // REALIZA O INSERT NA TABELA HISTORICO
            $historico = new ContratacaoHistorico;
            $historico->idDemanda = $id;
            $historico->tipoStatus = $request->input('data.statusGeral');
            $historico->dataStatus = date("Y-m-d H:i:s", time());
            $historico->responsavelStatus = $request->session()->get('matricula');
            $historico->area = $lotacao;
            $historico->analiseHistorico = $request->input('data.observacoesCeopc');
            $historico->save();

            // ENVIA MENSAGERIA (SE FOR O CASO)
            if (env('DB_CONNECTION') === 'sqlsrv') {
                if ($request->input('data.statusGeral') == 'INCONFORME') {
                    $dadosDemandaCadastrada = ContratacaoDemanda::find($id);
                    $email = new ContratacaoPhpMailer;
                    $email->enviarMensageria($request, $dadosDemandaCadastrada, 'demandaInconforme');
                }
            }

            $request->session()->flash('corMensagem', 'success');
            $request->session()->flash('tituloMensagem', "Protocolo #" . str_pad($demanda->idDemanda, 4, '0', STR_PAD_LEFT) . " | Analisada com sucesso!");
            $request->session()->flash('corpoMensagem', "A análise do protocolo " . session('analiseConcluida') . " foi finalizada.");
            
            return 'deu certo';
        } catch (Exception $e) {
            echo 'Exceção capturada: ',  $e->getMessage(), "\n";
        }
    }

    public function criaDiretorioUploadArquivo($request, $demandaId)
    {
        if (!file_exists($this->pastaPrimeiroNivel)) {
            Storage::makeDirectory($this->pastaPrimeiroNivel, $mode = 0777, true, true);
        }
        if ($request->tipoPessoa === "PF") {
            $this->pastaSegundoNivel = $this->pastaPrimeiroNivel . "/CPF_" . str_replace(".","", str_replace("-", "", $request->cpf));
        } else {
            $this->pastaSegundoNivel = $this->pastaPrimeiroNivel . "/CNPJ_" . str_replace(".","", str_replace("/", "", str_replace("-", "", $request->cnpj)));
        }
        $this->pastaTerceiroNivel = $this->pastaSegundoNivel . '/PROTOCOLO_' . $demandaId;
        if (!file_exists($this->pastaSegundoNivel)) {
            Storage::makeDirectory($this->pastaSegundoNivel, $mode = 0777, true, true);
        }
        if (!file_exists($this->pastaTerceiroNivel)) {
            Storage::makeDirectory($this->pastaTerceiroNivel, $mode = 0777, true, true);
        }
    }

    public function criaDiretorioUploadArquivoComplemento($demandaId)
    {
        $demanda = ContratacaoDemanda::find($demandaId);
        
        if (!file_exists($this->pastaPrimeiroNivel)) {
            Storage::makeDirectory($this->pastaPrimeiroNivel, $mode = 0777, true, true);
        }
        if ($demanda->tipoPessoa === "PF") {
            $this->pastaSegundoNivel = $this->pastaPrimeiroNivel . "/CPF_" . str_replace(".","", str_replace("-", "", $demanda->cpf));
        } else {
            $this->pastaSegundoNivel = $this->pastaPrimeiroNivel . "/CNPJ_" . str_replace(".","", str_replace("/", "", str_replace("-", "", $demanda->cnpj)));
        }
        $this->pastaTerceiroNivel = $this->pastaSegundoNivel . '/PROTOCOLO_' . $demandaId;
        if (!file_exists($this->pastaSegundoNivel)) {
            Storage::makeDirectory($this->pastaSegundoNivel, $mode = 0777, true, true);
        }
        if (!file_exists($this->pastaTerceiroNivel)) {
            Storage::makeDirectory($this->pastaTerceiroNivel, $mode = 0777, true, true);
        }
    }

    public function uploadArquivo($request, $nameArquivoRequest, $tipoArquivo, $demandaId)
    {
        $arquivo = $request->file($nameArquivoRequest);
        for ($i = 0; $i < sizeof($arquivo); $i++) { 
            $timestampUpload = date("_YmdHis", time());

            // MOVE O ARQUIVO TEMPORÁRIO PARA O SERVIDOR DE ARQUIVOS
            $arquivo[$i]->storeAs($this->pastaTerceiroNivel, $tipoArquivo . $timestampUpload . '.' . $arquivo[$i]->getClientOriginalExtension());
            
            // REALIZA O INSERT NA TABELA TBL_EST_CONTRATACAO_LINK_UPLOADS
            $upload = new ContratacaoUpload;
            $upload->dataInclusao = date("Y-m-d H:i:s", time());
            $upload->idDemanda = $demandaId;
            
            if ($request->tipoPessoa === "PF") {
                $upload->cpf = $request->cpf;
            } else {
                $upload->cnpj = $request->cnpj;
            }
            
            $upload->tipoDoDocumento = $tipoArquivo;
            $upload->nomeDoDocumento = $tipoArquivo . $timestampUpload . '.' . $arquivo[$i]->getClientOriginalExtension();
            $upload->caminhoDoDocumento = $this->pastaTerceiroNivel . '/' . $tipoArquivo . $timestampUpload . '.' . $arquivo[$i]->getClientOriginalExtension();
            $upload->excluido = "NAO";
            $upload->save();        
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function cadastraChecklist(Request $request, $tipoArquivo, $demandaId)
    {
        // REALIZA O INSERT NA TABELA TBL_EST_CONTRATACAO_CONFERE_CONFORMIDADE
        $tabelaConformidade = new ContratacaoConfereConformidade;
        $tabelaConformidade->idDemanda = $demandaId;
        $tabelaConformidade->tipoDocumento = $tipoArquivo;
        $tabelaConformidade->tipoOperacao = $request->tipoOperacao;
        $tabelaConformidade->statusDocumento = "PENDENTE";
        $tabelaConformidade->save();
    }

    public function atualizaChecklist($idDocumento)
    {
        // REALIZA O UPDATE NA TABELA TBL_EST_CONTRATACAO_CONFERE_CONFORMIDADE
        $tabelaConformidade = ContratacaoConfereConformidade::find($idDocumento);
        $tabelaConformidade->statusDocumento = "PENDENTE";
        $tabelaConformidade->save();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function complementaConformidadeContratacao(Request  $request, $id)
    {
        // dd($request->all());
        if ($request->session()->get('codigoLotacaoFisica') == null || $request->session()->get('codigoLotacaoFisica') === "NULL") {
            $lotacao = $request->session()->get('codigoLotacaoAdministrativa');
        } 
        else {
            $lotacao = $request->session()->get('codigoLotacaoFisica');
        }
        try {
            // ATUALIZA DADOS DA DEMANDA
            $demanda = ContratacaoDemanda::find($id);
            // $demanda->tipoPessoa = $request->tipoPessoa;
            // $demanda->cpf = $request->cpf;
            // $demanda->cnpj = $request->cnpj;
            // $demanda->nomeCliente = $request->nomeCliente;
            // $demanda->tipoOperacao = $request->tipoOperacao;
            // $demanda->tipoMoeda = $request->tipoMoeda;
            // $demanda->valorOperacao = $request->valorOperacao;
            // $demanda->dataPrevistaEmbarque = $request->dataPrevistaEmbarque;
            // $demanda->dataLiquidacao = date("Y-m-d", strtotime(str_replace('/', '-', $request->dataLiquidacao)));
            // $demanda->numeroBoleto = $request->numeroBoleto;
            $demanda->statusAtual = 'DISTRIBUIDA';
            $demanda->responsavelAtual = $request->session()->get('matricula');
            // $demanda->agResponsavel = $request->agResponsavel;
            // $demanda->srResponsavel = $request->srResponsavel;
            $demanda->analiseCeopc = $request->analiseAg;
            // $demanda->analiseAg = $request->analiseAg;
            // $demanda->responsavelCeopc =  $request->session()->get('matricula');
            $demanda->save();

            // REALIZA O UPDATE DA TABELA CONTA IMPORTADOR (SE HOUVER)
            if ($request->tipoOperacao == 'Pronto Importação Antecipado' || $request->tipoOperacao == 'Pronto Importação') {
                $dadosContaImportador = ContratacaoContaImportador::find($id);
                $dadosContaImportador->nomeBeneficiario = $request->nomeBeneficiario;
                $dadosContaImportador->enderecoBeneficiario = $request->enderecoBeneficiario;
                $dadosContaImportador->cidadeBeneficiario = $request->cidadeBeneficiario;
                $dadosContaImportador->paisBeneficiario = $request->paisBeneficiario;
                $dadosContaImportador->nomeBancoBeneficiario = $request->nomeBancoBeneficiario;
                $dadosContaImportador->ibanBancoBeneficiario = $request->ibanBancoBeneficiario;
                $dadosContaImportador->swiftAbaBancoBeneficiario = $request->swiftAbaBancoBeneficiario;
                $dadosContaImportador->numeroContaBeneficiario = $request->numeroContaBeneficiario;
                // VALIDA SE EXITE BANCO INTERMADIARIO
                if ($request->has('nomeBancoIntermediario')) {
                    $dadosContaImportador->nomeBancoIntermediario = $request->nomeBancoIntermediario;
                    $dadosContaImportador->ibanBancoIntermediario = $request->ibanBancoIntermediario;
                    $dadosContaImportador->contaBancoIntermediario = $request->contaBancoIntermediario;
                    $dadosContaImportador->swiftAbaBancoIntermediario = $request->swiftAbaBancoIntermediario;
                }
                $dadosContaImportador->save();
            }

            // CRIA O DIRETÓRIO PARA UPLOAD DOS ARQUIVOS
            $this->criaDiretorioUploadArquivoComplemento($id);
            
            // REALIZA O UPLOAD DOS ARQUIVOS E FAZ O INSERT NAS TABELAS TBL_EST_CONTRATACAO_LINK_UPLOADS E TBL_EST_CONTRATACAO_CONFERE_CONFORMIDADE
            if ($request->has('uploadInvoice')) {
                $this->uploadArquivo($request, "uploadInvoice", "INVOICE", $id);
                // $this->atualizaChecklist($request->idINVOICE);
            }
            if ($request->has('uploadDadosBancarios')) {
                $this->uploadArquivo($request, "uploadDadosBancarios", "DADOS_CONTA_DO_BENEFICIARIO", $id);
                // $this->atualizaChecklist($request->idDADOS_CONTA_DO_BENEFICIARIO);
            }
            if ($request->has('uploadConhecimento')) {
                $this->uploadArquivo($request, "uploadConhecimento", "CONHECIMENTO_DE_EMBARQUE", $id);
                // $this->atualizaChecklist($request->idCONHECIMENTO_DE_EMBARQUE);
            }
            if ($request->has('uploadDi')) {
                $this->uploadArquivo($request, "uploadDi", "DI", $id);
                // $this->atualizaChecklist($request->idDI);
            }
            if ($request->has('uploadDue')) {
                $this->uploadArquivo($request, "uploadDue", "DUE", $id);
                // $this->atualizaChecklist($request->idDUE);
            }
            if ($request->has('uploadDocumentosDiversos')) {
                $this->uploadArquivo($request, "uploadDocumentosDiversos", "DOCUMENTOS_DIVERSOS", $id);
                // $this->atualizaChecklist($request->idDOCUMENTOS_DIVERSOS);
            }   

            // REALIZA O INSERT NA TABELA HISTORICO
            $historico = new ContratacaoHistorico;
            $historico->idDemanda = $id;
            $historico->tipoStatus = 'CORRIGIDA';
            $historico->dataStatus = date("Y-m-d H:i:s", time());
            $historico->responsavelStatus = $request->session()->get('matricula');
            $historico->area = $lotacao;
            $historico->analiseHistorico = $request->analiseAg;
            $historico->save();

            $request->session()->flash('corMensagem', 'success');
            $request->session()->flash('tituloMensagem', "Protocolo #" . str_pad($id, 4, '0', STR_PAD_LEFT) . " | corrigido!");
            $request->session()->flash('corpoMensagem', "A demanda foi devolvida para tratamento com sucesso. Aguarde a conformidade.");
            
            return redirect('esteiracomex/contratacao/consulta/' . $id);
        } catch (Exception $e) {
            echo 'Exceção capturada: ',  $e->getMessage(), "\n";
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function enviaContratoRede(Request  $request, $id)
    {
        // dd($request->all());
        if ($request->session()->get('codigoLotacaoFisica') == null || $request->session()->get('codigoLotacaoFisica') === "NULL") {
            $lotacao = $request->session()->get('codigoLotacaoAdministrativa');
        } 
        else {
            $lotacao = $request->session()->get('codigoLotacaoFisica');
        }
        try {
            // ATUALIZA DADOS DA DEMANDA
            $demanda = ContratacaoDemanda::find($id);
            // $demanda->tipoPessoa = $request->tipoPessoa;
            // $demanda->cpf = $request->cpf;
            // $demanda->cnpj = $request->cnpj;
            // $demanda->nomeCliente = $request->nomeCliente;
            // $demanda->tipoOperacao = $request->tipoOperacao;
            // $demanda->tipoMoeda = $request->tipoMoeda;
            // $demanda->valorOperacao = $request->valorOperacao;
            // $demanda->dataPrevistaEmbarque = $request->dataPrevistaEmbarque;
            // $demanda->dataLiquidacao = date("Y-m-d", strtotime(str_replace('/', '-', $request->dataLiquidacao)));
            // $demanda->numeroBoleto = $request->numeroBoleto;
            $demanda->statusAtual = 'CONTRATO ENVIADO';
            // $demanda->responsavelAtual = $request->session()->get('matricula');
            // $demanda->agResponsavel = $request->agResponsavel;
            // $demanda->srResponsavel = $request->srResponsavel;
            $demanda->analiseCeopc = $request->analiseAg;
            // $demanda->analiseAg = $request->analiseAg;
            $demanda->responsavelCeopc =  $request->session()->get('matricula');
            $demanda->save();

            // CRIA O DIRETÓRIO PARA UPLOAD DOS ARQUIVOS
            $this->criaDiretorioUploadArquivoComplemento($id);
            
            // REALIZA O UPLOAD DO CONTRATO E FAZ O INSERT NAS TABELAS TBL_EST_CONTRATACAO_LINK_UPLOADS E TBL_EST_CONTRATACAO_CONFERE_CONFORMIDADE
            if ($request->has('minutaContrato')) {
                $this->uploadArquivo($request, "minutaContrato", "CONTRATO_" . $request->tipoContrato, $id);
                $this->cadastraChecklist($request, "CONTRATO " . $request->tipoContrato, $demanda->idDemanda);
            }      

            // REALIZA O INSERT NA TABELA HISTORICO
            $historico = new ContratacaoHistorico;
            $historico->idDemanda = $id;
            $historico->tipoStatus = 'CONTRATO ENVIADO';
            $historico->dataStatus = date("Y-m-d H:i:s", time());
            $historico->responsavelStatus = $request->session()->get('matricula');
            $historico->area = $lotacao;
            $historico->analiseHistorico = $request->analiseAg;
            $historico->save();

            // ENVIA MENSAGERIA
            $dadosDemanda = ContratacaoDemanda::find($id);
            $email = new ContratacaoPhpMailer;
            // $email->enviarMensageria($dadosDemanda, 'demandaInconforme');

            $request->session()->flash('corMensagem', 'success');
            $request->session()->flash('tituloMensagem', "Protocolo #" . str_pad($id, 4, '0', STR_PAD_LEFT) . " | corrigido!");
            $request->session()->flash('corpoMensagem', "A demanda foi devolvida para tratamento com sucesso. Aguarde a conformidade.");
            
            return redirect('esteiracomex/contratacao/consulta/' . $id);
        } catch (Exception $e) {
            echo 'Exceção capturada: ',  $e->getMessage(), "\n";
        }
    }
}
