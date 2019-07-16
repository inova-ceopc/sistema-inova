<?php

namespace App\Http\Controllers\Comex\Contratacao;

use Illuminate\Http\Request;
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
        if ($request->session()->get('codigoLotacaoFisica') == null || $request->session()->get('codigoLotacaoFisica') === "NULL") {
            $lotacao = $request->session()->get('codigoLotacaoAdministrativa');
        } 
        else {
            $lotacao = $request->session()->get('codigoLotacaoFisica');
        }
        try {
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
                $dadosContaImportador->nomeBeneficiario = $request->nomeBeneficiario;
                $dadosContaImportador->enderecoBeneficiario = $request->enderecoBeneficiario;
                $dadosContaImportador->cidadeBeneficiario = $request->cidadeBeneficiario;
                $dadosContaImportador->paisBeneficiario = $request->paisBeneficiario;
                $dadosContaImportador->nomeBancoBeneficiario = $request->nomeBancoBeneficiario;
                $dadosContaImportador->ibanBancoBeneficiario = $request->ibanBancoBeneficiario;
                $dadosContaImportador->swiftAbaBancoBeneficiario = $request->swiftAbaBancoBeneficiario;
                $dadosContaImportador->numeroContaBeneficiario = $request->numeroContaBeneficiario;
                // VALIDA SE EXITE BANCO INTERMADIARIO
                if ($request->temBancoIntermediario == true) {
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
                    $this->uploadArquivo($request, "uploadDocumentosDiversos", "DOCUMENTOS_DIVERSOS", $demanda->idDemanda);
                    $this->cadastraChecklist($request, "DADOS_CONTA_BENEFICIARIO", $demanda->idDemanda);
                    // $this->cadastraChecklist($request, "AUTORIZACAO_SR", $demanda->idDemanda);
                    // if ($request->temDadosBancarios === "2") {
                    //     $this->uploadArquivo($request, "uploadDadosBancarios", "DADOS_BANCARIOS", $demanda->idDemanda);
                    //     $this->cadastraChecklist($request, "DADOS_BANCARIOS", $demanda->idDemanda);
                    // }
                    break;
                case 'Pronto Importação':
                    $this->uploadArquivo($request, "uploadInvoice", "INVOICE", $demanda->idDemanda);
                    $this->cadastraChecklist($request, "INVOICE", $demanda->idDemanda);
                    $this->uploadArquivo($request, "uploadDocumentosDiversos", "DOCUMENTOS_DIVERSOS", $demanda->idDemanda);
                    // $this->cadastraChecklist($request, "AUTORIZACAO_SR", $demanda->idDemanda);
                    $this->uploadArquivo($request, "uploadConhecimento", "CONHECIMENTO_EMBARQUE", $demanda->idDemanda);
                    $this->cadastraChecklist($request, "CONHECIMENTO_EMBARQUE", $demanda->idDemanda);
                    $this->uploadArquivo($request, "uploadDi", "DI", $demanda->idDemanda);
                    $this->cadastraChecklist($request, "DI", $demanda->idDemanda);
                    $this->cadastraChecklist($request, "DADOS_CONTA_BENEFICIARIO", $demanda->idDemanda);
                    // if ($request->temDadosBancarios === "2") {
                    //     $this->uploadArquivo($request, "uploadDadosBancarios", "DADOS_BANCARIOS", $demanda->idDemanda);
                    //     $this->cadastraChecklist($request, "DADOS_BANCARIOS", $demanda->idDemanda);
                    // }
                    break;
                case 'Pronto Exportação Antecipado':
                    $this->uploadArquivo($request, "uploadInvoice", "INVOICE", $demanda->idDemanda);
                    $this->cadastraChecklist($request, "INVOICE", $demanda->idDemanda);
                    $this->uploadArquivo($request, "uploadDocumentosDiversos", "DOCUMENTOS_DIVERSOS", $demanda->idDemanda);
                    // $this->cadastraChecklist($request, "AUTORIZACAO_SR", $demanda->idDemanda);
                    break;
                case 'Pronto Exportação':
                    $this->uploadArquivo($request, "uploadInvoice", "INVOICE", $demanda->idDemanda);
                    $this->cadastraChecklist($request, "INVOICE", $demanda->idDemanda);
                    $this->uploadArquivo($request, "uploadDocumentosDiversos", "DOCUMENTOS_DIVERSOS", $demanda->idDemanda);
                    // $this->cadastraChecklist($request, "AUTORIZACAO_SR", $demanda->idDemanda);
                    $this->uploadArquivo($request, "uploadConhecimento", "CONHECIMENTO_EMBARQUE", $demanda->idDemanda);
                    $this->cadastraChecklist($request, "CONHECIMENTO_EMBARQUE", $demanda->idDemanda);
                    $this->uploadArquivo($request, "uploadDue", "DUE", $demanda->idDemanda);
                    $this->cadastraChecklist($request, "DUE", $demanda->idDemanda);
                    break;
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
            $dadosDemandaCadastrada = ContratacaoDemanda::find($demanda->idDemanda);
            $email = new ContratacaoPhpMailer;
            $email->enviarMensageria($dadosDemandaCadastrada, 'demandaCadastrada');
                    
            $request->session()->flash(
                'message', 
                "Protocolo #" . str_pad($demanda->idDemanda, 4, '0', STR_PAD_LEFT)
            ); 
            
            return redirect('esteiracomex/contratacao');
        } catch (Exception $e) {
            echo 'Exceção capturada: ',  $e->getMessage(), "\n";
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
        // dd(ContratacaoConfereConformidade::find($request->input('data.idINVOICE')));
        // dd($request->input('data.statusInvoice'));
        // dd(ContratacaoConfereConformidade::where('idDemanda', $id)->where('tipoDocumento', 'INVOICE')->get());
        // dd($request->input('excluirDocumentos.' . $i . '.idUploadLink'));
        // dd(sizeof($request->excluirDocumentos));
        // dd($request->input('excluirDocumentos.0.idUploadLink'));
        // dd($request->input('data.dataLiquidacao'));
        // dd($request->all());
        
        if ($request->session()->get('codigoLotacaoFisica') == null || $request->session()->get('codigoLotacaoFisica') === "NULL") {
            $lotacao = $request->session()->get('codigoLotacaoAdministrativa');
        } 
        else {
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
            if ($request->input('data.statusInvoice')  != 'PENDENTE') {
                $conformidade = ContratacaoConfereConformidade::find($request->input('data.idINVOICE'));
                $conformidade->statusDocumento = $request->input('data.statusInvoice');
                $conformidade->dataConferencia = date("Y-m-d H:i:s", time());
                $conformidade->save();
            }
            if ($request->input('data.statusConhecimento')  != 'PENDENTE') {
                $conformidade = ContratacaoConfereConformidade::find($request->input('data.idCONHECIMENTO_EMBARQUE'));
                $conformidade->statusDocumento = $request->input('data.statusConhecimento');
                $conformidade->dataConferencia = date("Y-m-d H:i:s", time());
                $conformidade->save();
            }
            if ($request->input('data.statusDi')  != 'PENDENTE') {
                $conformidade = ContratacaoConfereConformidade::find($request->input('data.idDI'));
                $conformidade->statusDocumento = $request->input('data.statusDi');
                $conformidade->dataConferencia = date("Y-m-d H:i:s", time());
                $conformidade->save();
            }
            if ($request->input('data.statusDue')  != 'PENDENTE') {
                $conformidade = ContratacaoConfereConformidade::find($request->input('data.idDUE'));
                $conformidade->statusDocumento = $request->input('data.statusDue');
                $conformidade->dataConferencia = date("Y-m-d H:i:s", time());
                $conformidade->save();
            }
            if ($request->input('data.statusDadosBancarios')  != 'PENDENTE') {
                $conformidade = ContratacaoConfereConformidade::find($request->input('data.idDADOS_BANCARIOS'));
                $conformidade->statusDocumento = $request->input('data.statusDadosBancarios');
                $conformidade->dataConferencia = date("Y-m-d H:i:s", time());
                $conformidade->save();
            }
            // if ($request->input('data.statusAutorizacaoSr')  != 'PENDENTE') {
            //     $conformidade = ContratacaoConfereConformidade::find($request->input('data.idAUTORIZACAO_SR'));
            //     $conformidade->statusDocumento = $request->input('data.statusAutorizacaoSr');
            //     $conformidade->dataConferencia = date("Y-m-d H:i:s", time());
            //     $conformidade->save();
            // }

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
            // if ($request->input('data.statusAtual') == 'INCONFORME') {
            //     $dadosDemandaCadastrada = ContratacaoDemanda::find($demanda->idDemanda);
            //     $email = new ContratacaoPhpMailer;
            //     $email->enviarMensageria($dadosDemandaCadastrada, 'demandaInconforme');
            // }

            $request->session()->put(
                'analiseConcluida', 
                "Protocolo #" . str_pad($id, 4, '0', STR_PAD_LEFT)
            ); 
            // dd('chegou no fim');
            // return redirect()->route('minhasDemandas');
            // return redirect('/esteiracomex/distribuir/demandas');
            return 'deu certo';
        } catch (Exception $e) {
            echo 'Exceção capturada: ',  $e->getMessage(), "\n";
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comex\Contratacao\ContratacaoDemanda $demandaContratacao
     * @return \Illuminate\Http\Response
     */
    public function destroy(ContratacaoDemanda $demandaContratacao)
    {
        //
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
            } 
            else {
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
            // if ($request->nomeBeneficiario != null) {
            //     $dadosContaImportador = ContratacaoContaImportador::where('idDemanda', $demanda->idDemanda);
            //     $dadosContaImportador->tipoPessoa = $request->tipoPessoa;
            //     $dadosContaImportador->nomeBeneficiario = $request->nomeBeneficiario;
            //     $dadosContaImportador->nomeBanco = $request->nomeBanco;
            //     $dadosContaImportador->iban = $request->iban;
            //     $dadosContaImportador->agContaBeneficiario = $request->agContaBeneficiario;
            //     $dadosContaImportador->save();
            // }

            // CRIA O DIRETÓRIO PARA UPLOAD DOS ARQUIVOS
            $this->criaDiretorioUploadArquivoComplemento($id);
            
            // REALIZA O UPLOAD DOS ARQUIVOS E FAZ O INSERT NAS TABELAS TBL_EST_CONTRATACAO_LINK_UPLOADS E TBL_EST_CONTRATACAO_CONFERE_CONFORMIDADE
            if ($request->has('uploadInvoice')) {
                $this->uploadArquivo($request, "uploadInvoice", "INVOICE", $id);
            }
            if ($request->has('uploadAutorizacaoSr')) {
                $this->uploadArquivo($request, "uploadAutorizacaoSr", "AUTORIZACAO_SR", $id);
            }
            if ($request->has('uploadDadosBancarios')) {
                $this->uploadArquivo($request, "uploadDadosBancarios", "DADOS_BANCARIOS", $id);
            }
            if ($request->has('uploadConhecimento')) {
                $this->uploadArquivo($request, "uploadConhecimento", "CONHECIMENTO_EMBARQUE", $id);
            }
            if ($request->has('uploadDi')) {
                $this->uploadArquivo($request, "uploadDi", "DI", $id);
            }
            if ($request->has('uploadDue')) {
                $this->uploadArquivo($request, "uploadDue", "DUE", $id);
            }  
            // switch ($request->tipoOperacao) {
            //     case 'Pronto Importação Antecipado':
            //         $this->uploadArquivo($request, "uploadInvoice", "INVOICE", $demanda->idDemanda);
            //         $this->uploadArquivo($request, "uploadAutorizacaoSr", "AUTORIZACAO_SR", $demanda->idDemanda);
            //         if ($request->temDadosBancarios === "2") {
            //             $this->uploadArquivo($request, "uploadDadosBancarios", "DADOS_BANCARIOS", $demanda->idDemanda);
            //         }
            //         break;
            //     case 'Pronto Importação':
            //         $this->uploadArquivo($request, "uploadInvoice", "INVOICE", $demanda->idDemanda);
            //         $this->uploadArquivo($request, "uploadAutorizacaoSr", "AUTORIZACAO_SR", $demanda->idDemanda);
            //         $this->uploadArquivo($request, "uploadConhecimento", "CONHECIMENTO_EMBARQUE", $demanda->idDemanda);
            //         $this->uploadArquivo($request, "uploadDi", "DI", $demanda->idDemanda);
            //         if ($request->temDadosBancarios === "2") {
            //             $this->uploadArquivo($request, "uploadDadosBancarios", "DADOS_BANCARIOS", $demanda->idDemanda);
            //         }
            //         break;
            //     case 'Pronto Exportação Antecipado':
            //         $this->uploadArquivo($request, "uploadInvoice", "INVOICE", $demanda->idDemanda);
            //         $this->uploadArquivo($request, "uploadAutorizacaoSr", "AUTORIZACAO_SR", $demanda->idDemanda);
            //         break;
            //     case 'Pronto Exportação':
            //         $this->uploadArquivo($request, "uploadInvoice", "INVOICE", $demanda->idDemanda);
            //         $this->uploadArquivo($request, "uploadAutorizacaoSr", "AUTORIZACAO_SR", $demanda->idDemanda);
            //         $this->uploadArquivo($request, "uploadConhecimento", "CONHECIMENTO_EMBARQUE", $demanda->idDemanda);
            //         $this->uploadArquivo($request, "uploadDue", "DUE", $demanda->idDemanda);
            //         break;
            // }

            // REALIZA O INSERT NA TABELA HISTORICO
            $historico = new ContratacaoHistorico;
            $historico->idDemanda = $id;
            $historico->tipoStatus = 'CORRIGIDA';
            $historico->dataStatus = date("Y-m-d H:i:s", time());
            $historico->responsavelStatus = $request->session()->get('matricula');
            $historico->area = $lotacao;
            $historico->analiseHistorico = $request->analiseAg;
            $historico->save();

            $request->session()->put(
                'complementoConcluido', 
                "Protocolo #" . str_pad($id, 4, '0', STR_PAD_LEFT)
            ); 

            return redirect('esteiracomex/contratacao/consulta/' . $id);
        } catch (Exception $e) {
            echo 'Exceção capturada: ',  $e->getMessage(), "\n";
        }
    }
}
