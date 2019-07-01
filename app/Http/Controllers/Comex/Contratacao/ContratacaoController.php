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
            $demanda->agResponsavel = $lotacao;
            $demanda->srResponsavel = null;
        }
        
        $demanda->analiseAg = $request->analiseAg;
        $demanda->save();

        // VALIDA SE É OPERACAO ANTECIPADA E COM DADOS BANCÁRIOS NO FORM DE CADASTRO
        // CASO POSITIVO: REALIZA INSERT NA TABELA TBL_EST_CONTRATACAO_CONTA_IMPORTADOR COM OS DADOS DO FORM
        // CASO NEGATIVO: PASSA EM BRANCO POIS OS DADOS BANCÁRIOS SUBIRÃO VIA UPLOAD DE ARQUIVO
        if ($request->nomeBeneficiario != null) {
            $dadosContaImportador = new ContratacaoContaImportador;
            $dadosContaImportador->tipoPessoa = $request->tipoPessoa;
            $dadosContaImportador->idDemanda = $demanda->idDemanda;
            $dadosContaImportador->nomeBeneficiario = $request->nomeBeneficiario;
            $dadosContaImportador->nomeBanco = $request->nomeBanco;
            $dadosContaImportador->iban = $request->iban;
            $dadosContaImportador->agContaBeneficiario = $request->agContaBeneficiario;
            $dadosContaImportador->save();
        }

        // CRIA O DIRETÓRIO PARA UPLOAD DOS ARQUIVOS
        $this->criaDiretorioUploadArquivo($request, $demanda->idDemanda);

        // REALIZA O UPLOAD DOS ARQUIVOS E FAZ O INSERT NAS TABELAS TBL_EST_CONTRATACAO_LINK_UPLOADS E TBL_EST_CONTRATACAO_CONFERE_CONFORMIDADE
        switch ($request->tipoOperacao) {
            case 'Pronto Importação Antecipado':
                $this->uploadArquivo($request, "uploadInvoice", "INVOICE", $demanda->idDemanda);
                $this->uploadArquivo($request, "uploadAutorizacaoSr", "AUTORIZACAO_SR", $demanda->idDemanda);
                if ($request->temDadosBancarios === "2") {
                    $this->uploadArquivo($request, "uploadDadosBancarios", "DADOS_BANCARIOS", $demanda->idDemanda);
                }
                break;
            case 'Pronto Importação':
                $this->uploadArquivo($request, "uploadInvoice", "INVOICE", $demanda->idDemanda);
                $this->uploadArquivo($request, "uploadAutorizacaoSr", "AUTORIZACAO_SR", $demanda->idDemanda);
                $this->uploadArquivo($request, "uploadConhecimento", "CONHECIMENTO_EMBARQUE", $demanda->idDemanda);
                $this->uploadArquivo($request, "uploadDi", "DI", $demanda->idDemanda);
                if ($request->temDadosBancarios === "2") {
                    $this->uploadArquivo($request, "uploadDadosBancarios", "DADOS_BANCARIOS", $demanda->idDemanda);
                }
                break;
            case 'Pronto Exportação Antecipado':
                $this->uploadArquivo($request, "uploadInvoice", "INVOICE", $demanda->idDemanda);
                $this->uploadArquivo($request, "uploadAutorizacaoSr", "AUTORIZACAO_SR", $demanda->idDemanda);
                break;
            case 'Pronto Exportação':
                $this->uploadArquivo($request, "uploadInvoice", "INVOICE", $demanda->idDemanda);
                $this->uploadArquivo($request, "uploadAutorizacaoSr", "AUTORIZACAO_SR", $demanda->id);
                $this->uploadArquivo($request, "uploadConhecimento", "CONHECIMENTO_EMBARQUE", $demanda->id);
                $this->uploadArquivo($request, "uploadDue", "DUE", $demanda->id);
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
        
                
        $request->session()
        ->flash(
            'message', 
            "Protocolo #00$demanda->idDemanda"); 
        
  

        return redirect('esteiracomex/contratacao');

      
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
            'EsteiraContratacaoUpload',
            'EsteiraContratacaoContaImportador'
        ])->where('TBL_EST_CONTRATACAO_DEMANDAS.idDemanda', $id)->get();

        // dd($dadosRelacionamentoDemanda);
        return json_encode($dadosRelacionamentoDemanda); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comex\Contratacao\ContratacaoDemanda $demandaContratacao
     * @return \Illuminate\Http\Response
     */
    public function edit(ContratacaoDemanda $demandaContratacao)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comex\Contratacao\ContratacaoDemanda $demandaContratacao
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ContratacaoDemanda $demandaContratacao)
    {
        //
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

    public function uploadArquivo($request, $nameArquivoRequest, $tipoArquivo, $demandaId)
    {
        $arquivo = $request->file($nameArquivoRequest);
        for ($i = 0; $i < sizeof($arquivo); $i++) { 
            // MOVE O ARQUIVO TEMPORÁRIO PARA O SERVIDOR DE ARQUIVOS
            $arquivo[$i]->storeAs($this->pastaTerceiroNivel, $tipoArquivo . date("_YmdHis", time()) . '.' . $arquivo[$i]->getClientOriginalExtension());
            
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
            $upload->nomeDoDocumento = $tipoArquivo . date("_YmdHis", time()) . '.' . $arquivo[$i]->getClientOriginalExtension();
            $upload->caminhoDoDocumento = $this->pastaTerceiroNivel . '/' . $tipoArquivo . date("_YmdHis", time()) . '.' . $arquivo[$i]->getClientOriginalExtension();
            $upload->excluido = "NAO";
            $upload->save();        
        }
        // REALIZA O INSERT NA TABELA TBL_EST_CONTRATACAO_CONFERE_CONFORMIDADE
        $tabelaConformidade = new ContratacaoConfereConformidade;
        $tabelaConformidade->idDemanda = $demandaId;
        $tabelaConformidade->tipoDocumento = $tipoArquivo;
        $tabelaConformidade->tipoOperacao = $request->tipoOperacao;
        $tabelaConformidade->statusDocumento = "PENDENTE";
        $tabelaConformidade->save();
    }
}
