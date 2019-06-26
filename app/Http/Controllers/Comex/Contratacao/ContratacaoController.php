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
    public $pastaPrimeiroNivel;
    public $pastaSegundoNivel;
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->session()->get('codigoLotacaoFisica') != null || $request->session()->get('codigoLotacaoFisica') != "null") {
            $lotacao = $request->session()->get('codigoLotacaoFisica');
        } else {
            $lotacao = $request->session()->get('codigoLotacaoAdministrativa');
        }
        
        
        // REALIZA O INSERT NA TABELA DE DEMANDA
        $demanda = new ContratacaoDemanda;
        $demanda->tipoPessoa = $request->tipoPessoa;
        if ($request->tipoPessoa === "PF") {
            $demanda->cpf = $request->cpf;
        } else {
            $demanda->cnpj = $request->cnpj;
        }
        $demanda->nomeCliente = $request->nomeCliente;
        $demanda->tipoOperacao = $request->tipoOperacao;
        $demanda->tipoMoeda = $request->tipoMoeda;
        $demanda->valorOperacao = $request->valorOperacao;
        if ($request->tipoOperacao == "Pronto Exportação Antecipado" || $request->tipoOperacao == "Pronto Importação Antecipado") {
            $demanda->dataPrevistaEmbarque = $request->dataPrevistaEmbarque;
        }
        $demanda->statusAtual = "CADASTRADA";
        $demanda->responsavelAtual = $request->session()->get('matricula');
        if ($request->session()->get('acessoEmpregado') == "AGÊNCIA") {
            $demanda->agResponsavel = $lotacao;
        } else {
            $demanda->srResponsavel = $lotacao;
        }
        $demanda->analiseAg = $request->analiseAg;
        $demanda->save();

        // VALIDA SE É OPERACAO ANTECIPADA E COM DADOS BANCÁRIOS NO FORM DE CADASTRO
        // CASO POSITIVO: REALIZA INSERT NA TABELA TBL_EST_CONTRATACAO_CONTA_IMPORTADOR COM OS DADOS DO FORM
        // CASO NEGATIVO: PASSA EM BRANCO POIS OS DADOS BANCÁRIOS SUBIRÃO VIA UPLOAD DE ARQUIVO
        if ($request->nomeBeneficiario != null) {
            $dadosContaImportador = new ContratacaoContaImportador;
            $dadosContaImportador->tipoPessoa = $request->tipoPessoa;
            $dadosContaImportador->idDemanda = $demanda->id;
            $dadosContaImportador->nomeBeneficiario = $request->nomeBeneficiario;
            $dadosContaImportador->nomeBanco = $request->nomeBanco;
            $dadosContaImportador->iban = $request->iban;
            $dadosContaImportador->agContaBeneficiario = $request->agContaBeneficiario;
            $dadosContaImportador->save();
        }

        // CRIA O DIRETÓRIO PARA UPLOAD DOS ARQUIVOS
        $this->criaDiretorioUploadArquivo($request, $demanda->id);

        // REALIZA O UPLOAD DOS ARQUIVOS E FAZ O INSERT NAS TABELAS TBL_EST_CONTRATACAO_LINK_UPLOADS E TBL_EST_CONTRATACAO_CONFERE_CONFORMIDADE
        switch ($request->tipoOperacao) {
            case 'Pronto Importação Antecipado':
                $this->uploadArquivo($request, "uploadInvoice", "INVOICE", $demanda->id);
                $this->uploadArquivo($request, "uploadAutorizacaoSr", "AUTORIZACAO_SR", $demanda->id);
                if ($request->temDadosBancarios === "2") {
                    $this->uploadArquivo($request, "uploadDadosBancarios", "DADOS_BANCARIOS", $demanda->id);
                }
                break;
            case 'Pronto Importação':
                $this->uploadArquivo($request, "uploadInvoice", "INVOICE", $demanda->id);
                $this->uploadArquivo($request, "uploadAutorizacaoSr", "AUTORIZACAO_SR", $demanda->id);
                $this->uploadArquivo($request, "uploadConhecimento", "CONHECIMENTO_EMBARQUE", $demanda->id);
                $this->uploadArquivo($request, "uploadDi", "DI", $demanda->id);
                if ($request->temDadosBancarios === "2") {
                    $this->uploadArquivo($request, "uploadDadosBancarios", "DADOS_BANCARIOS", $demanda->id);
                }
                break;
            case 'Pronto Exportação Antecipado':
                $this->uploadArquivo($request, "uploadInvoice", "INVOICE", $demanda->id);
                $this->uploadArquivo($request, "uploadAutorizacaoSr", "AUTORIZACAO_SR", $demanda->id);
                break;
            case 'Pronto Exportação':
                $this->uploadArquivo($request, "uploadInvoice", "INVOICE", $demanda->id);
                $this->uploadArquivo($request, "uploadAutorizacaoSr", "AUTORIZACAO_SR", $demanda->id);
                $this->uploadArquivo($request, "uploadConhecimento", "CONHECIMENTO_EMBARQUE", $demanda->id);
                $this->uploadArquivo($request, "uploadDue", "DUE", $demanda->id);
                break;
        }

        // REALIZA O INSERT NA TABELA DE HISTORICO
        $historico = new ContratacaoHistorico;
        $historico->idDemanda = $demanda->id;
        $historico->tipoStatus = "CADASTRO";
        $historico->dataStatus = date("Y-m-d H:i:s", time());
        $historico->responsavelStatus = $request->session()->get('matricula');
        $historico->area = $lotacao;
        $historico->analiseHistorico = $request->analiseAg;
        $historico->save();
        
        return $request->session()->flash('messagem', 'demanda cadastrada com sucesso');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Contratacao  $contratacao
     * @return \Illuminate\Http\Response
     */
    public function show(Contratacao $contratacao)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Contratacao  $contratacao
     * @return \Illuminate\Http\Response
     */
    public function edit(Contratacao $contratacao)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contratacao  $contratacao
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contratacao $contratacao)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contratacao  $contratacao
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contratacao $contratacao)
    {
        //
    }

    public function criaDiretorioUploadArquivo($request, $demandaId)
    {
        if ($request->tipoPessoa === "PF") {
            $this->pastaPrimeiroNivel = "/CPF" . str_replace(".","", str_replace("-", "", $request->cpf));
        } else {
            $this->pastaPrimeiroNivel = "/CNPJ" . str_replace(".","", str_replace("/", "", $request->cnpj));
        }
        $this->pastaSegundoNivel = $this->pastaPrimeiroNivel . '/PROTOCOLO_' . $demandaId;
        if (!file_exists($this->pastaPrimeiroNivel)) {
            Storage::makeDirectory($this->pastaPrimeiroNivel, $mode = 0777, true, true);
        }
        if (!file_exists($this->pastaSegundoNivel)) {
            Storage::makeDirectory($this->pastaSegundoNivel, $mode = 0777, true, true);
        }
    }

    public function uploadArquivo($request, $nameArquivoRequest, $tipoArquivo, $demandaId)
    {
        $arquivo = $request->file($nameArquivoRequest);
        for ($i = 0; $i < sizeof($arquivo); $i++) { 
            // MOVE O ARQUIVO TEMPORÁRIO PARA O SERVIDOR DE ARQUIVOS
            $arquivo[$i]->storeAs($this->pastaSegundoNivel, $tipoArquivo . $i . '.' . $arquivo[$i]->getClientOriginalExtension());
            
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
            $upload->nomeDoDocumento = $tipoArquivo . '_' . $i . '.' . $arquivo[$i]->getClientOriginalExtension();
            $upload->caminhoDoDocumento = $this->pastaSegundoNivel;
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
