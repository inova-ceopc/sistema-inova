<?php

namespace App\Http\Controllers\Comex\Contratacao;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Cmixin\BusinessDay;
use App\Http\Controllers\Controller;
use App\Classes\Comex\Contratacao\ContratacaoPhpMailer;
use App\Classes\Comex\Contratacao\ValidaMensageriaContratacao;
use App\Models\Comex\Contratacao\ContratacaoDadosContrato;
use App\Models\Comex\Contratacao\ContratacaoDemanda;
use App\Models\Comex\Contratacao\ContratacaoContaImportador;
use App\Models\Comex\Contratacao\ContratacaoHistorico;
use App\Models\Comex\Contratacao\ContratacaoUpload;
use App\Http\Controllers\Comex\Contratacao\ContratacaoFaseConformidadeDocumentalController;
use App\Http\Controllers\Comex\Contratacao\ContratacaoFaseVerificaContratoController;

class ContratacaoFaseLiquidacaoOperacaoController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $relacaoFinalContratosParaFormalizar = [];
        
        $listaInicialContratosParaFormalizar = ContratacaoDemanda::whereIn('statusAtual', ['CONFORME', 'CONTRATO ENVIADO', 'CONTRATO ASSINADO', 'REITERADO', 'NÃO LIQUIDADA'])->get();
        
        for ($i = 0; $i < sizeof($listaInicialContratosParaFormalizar); $i++) {   
            if ($listaInicialContratosParaFormalizar[$i]->cpf === null) {
                $cpfCnpj = $listaInicialContratosParaFormalizar[$i]->cnpj;
            } else {
                $cpfCnpj = $listaInicialContratosParaFormalizar[$i]->cpf;
            }
            if ($listaInicialContratosParaFormalizar[$i]->agResponsavel === null) {
                $unidadeDemandante = $listaInicialContratosParaFormalizar[$i]->srResponsavel;
            } else {
                $unidadeDemandante = $listaInicialContratosParaFormalizar[$i]->agResponsavel;
            }

            $contratoFormalizado = array(
                'idDemanda' => $listaInicialContratosParaFormalizar[$i]->idDemanda,
                'nomeCliente' => $listaInicialContratosParaFormalizar[$i]->nomeCliente,
                'cpfCnpj' => $cpfCnpj,
                'tipoOperacao' => $listaInicialContratosParaFormalizar[$i]->tipoOperacao,
                'valorOperacao' => $listaInicialContratosParaFormalizar[$i]->valorOperacao,
                'statusAtual' => $listaInicialContratosParaFormalizar[$i]->statusAtual,
                'unidadeDemandante' => $unidadeDemandante
            );

            array_push($relacaoFinalContratosParaFormalizar, $contratoFormalizado);
        }
       
        return json_encode(array('demandasFormalizadas' => $relacaoFinalContratosParaFormalizar), JSON_UNESCAPED_SLASHES);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            // CAPTURA A UNIDADE DE LOTAÇÃO (FISICA OU ADMINISTRATIVA)
            if ($request->session()->get('codigoLotacaoFisica') == null || $request->session()->get('codigoLotacaoFisica') === "NULL") {
                $lotacao = $request->session()->get('codigoLotacaoAdministrativa');
            } 
            else {
                $lotacao = $request->session()->get('codigoLotacaoFisica');
            }
            
            if ($request->has('statusAtual')) {
                if ($request->statusAtual == 'CANCELADA') {
                    // CAPTURA A DEMANDA E ATUALIZA O STATUS ATUAL
                    $objContratacaoDemanda = ContratacaoDemanda::find($id);
                    $objContratacaoDemanda->statusAtual = $request->statusAtual;
                    $objContratacaoDemanda->save();
                    
                    // REGISTRO DE HISTORICO
                    $historico = new ContratacaoHistorico;
                    $historico->idDemanda = $id;
                    $historico->tipoStatus = "CANCELADA";
                    $historico->dataStatus = date("Y-m-d H:i:s", time());
                    $historico->responsavelStatus = $request->session()->get('matricula');
                    $historico->area = $lotacao;
                    $historico->analiseHistorico = "A demanda foi cancelada";
                    $historico->save();
                    
                    // RETORNA A FLASH MESSAGE
                    $request->session()->flash('corMensagem', 'success');
                    $request->session()->flash('tituloMensagem', "Demanda cancelada!");
                    $request->session()->flash('corpoMensagem', "A demanda foi cancelada com sucesso.");
                } else {
                    // CAPTURA A DEMANDA E ATUALIZA O STATUS ATUAL
                    $objContratacaoDemanda = ContratacaoDemanda::find($id);
                    $objContratacaoDemanda->statusAtual = $request->statusAtual;
                    $objContratacaoDemanda->save();
                    
                    // REGISTRO DE HISTORICO
                    $historico = new ContratacaoHistorico;
                    $historico->idDemanda = $id;
                    $historico->tipoStatus = "REENVIADA LIQUIDAÇÃO";
                    $historico->dataStatus = date("Y-m-d H:i:s", time());
                    $historico->responsavelStatus = $request->session()->get('matricula');
                    $historico->area = $lotacao;
                    $historico->analiseHistorico = "A demanda foi devolvida para liquidação";
                    $historico->save();
                    
                    // RETORNA A FLASH MESSAGE
                    $request->session()->flash('corMensagem', 'success');
                    $request->session()->flash('tituloMensagem', "Demanda devolvida");
                    $request->session()->flash('corpoMensagem', "A demanda foi devolvida para a CELIT com sucesso.");
                }
            } else {
                // CRIA O DIRETÓRIO PARA UPLOAD DOS ARQUIVOS
                ContratacaoFaseConformidadeDocumentalController::criaDiretorioUploadArquivoComplemento($request->idDemanda);

                // REALIZA O UPLOAD DO CONTRATO
                switch ($request->tipoContrato) {
                    case 'CONTRATACAO':
                        $uploadContrato = ContratacaoFaseConformidadeDocumentalController::uploadArquivoContrato($request, "uploadContrato", "CONTRATACAO", $request->idDemanda);
                        break;
                    case 'ALTERACAO':
                        $uploadContrato = ContratacaoFaseConformidadeDocumentalController::uploadArquivoContrato($request, "uploadContrato", "ALTERACAO", $request->idDemanda);
                        break;
                    case 'CANCELAMENTO':
                        $uploadContrato = ContratacaoFaseConformidadeDocumentalController::uploadArquivoContrato($request, "uploadContrato", "CANCELAMENTO", $request->idDemanda);
                        break;
                }

                // CADASTRA OS DADOS DO CONTRATO
                $objDadosContrato = new ContratacaoDadosContrato;
                $objDadosContrato->tipoContrato = $request->tipoContrato;
                $objDadosContrato->numeroContrato = $request->numeroContrato;
                $objDadosContrato->idUploadContratoSemAssinatura = $uploadContrato->idUploadLink;
                $objDadosContrato->temRetornoRede = $request->temRetornoRede;

                // ENVIA MENSAGERIA
                $objContratacaoDemanda = ContratacaoDemanda::find($request->idDemanda);
                ValidaMensageriaContratacao::defineTipoMensageria($objContratacaoDemanda, $objDadosContrato);
                // // dd(['objetoDemanda' => $objContratacaoDemanda, 'objDadosContrato' =>$objDadosContrato]);
                // $objContratacaoDemanda->statusAtual = 'CONTRATO ENVIADO';
                
                // CADASTRO DE CHECKLIST
                if ($objDadosContrato->temRetornoRede == 'SIM') {
                    // $objDadosContrato->statusContrato = 'CONTRATO ENVIADO';
                    $objContratacaoDemanda->liberadoLiquidacao = 'NAO';
                } else {
                    $objContratacaoDemanda->liberadoLiquidacao = 'SIM';
                    $objContratacaoDemanda->statusAtual = 'ASSINATURA CONFORME';
                }
                $objContratacaoDemanda->save();
                
                // REGISTRO DE HISTORICO
                $historico = new ContratacaoHistorico;
                $historico->idDemanda = $request->idDemanda;
                $historico->tipoStatus = "ENVIO DE CONTRATO";
                $historico->dataStatus = date("Y-m-d H:i:s", time());
                $historico->responsavelStatus = $request->session()->get('matricula');
                $historico->area = $lotacao;
                $historico->analiseHistorico = "Envio de contrato nº $request->numeroContrato - Tipo: $request->tipoContrato";
                $historico->save();
                
                // RETORNA A FLASH MESSAGE
                $request->session()->flash('corMensagem', 'success');
                $request->session()->flash('tituloMensagem', "Contrato nº " . $request->numeroContrato . " | Enviado com Sucesso!");
                $request->session()->flash('corpoMensagem', "O contrato foi enviado para a unidade demandante.");
            }            
            DB::commit();
            return redirect('esteiracomex/acompanhar/formalizadas');
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            $request->session()->flash('corMensagem', 'danger');
            $request->session()->flash('tituloMensagem', "Contrato não foi enviado");
            $request->session()->flash('corpoMensagem', "Aconteceu algum erro durante o envio do contrato, tente novamente.");
            return redirect('esteiracomex/acompanhar/formalizadas');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function rotinaReiterarContrato(Request  $request)
    {
        $contratosSemRetorno = ContratacaoDadosContrato::where('temRetornoRede', 'SIM')->whereNull('dataEnvioContratoAssinado')->get();
        for ($i=0; $i < sizeof($contratosSemRetorno); $i++) { 
            $objUploadContrato = ContratacaoUpload::find($contratosSemRetorno[$i]->idUploadContratoSemAssinatura);
            $objContratacaoDemanda = ContratacaoDemanda::find($objUploadContrato->idDemanda);
            dd($objContratacaoDemanda);
            // ENVIA E-MAIL PARA A AGÊNCIA
            if (env('DB_CONNECTION') === 'sqlsrv') {
                $email = new ContratacaoPhpMailer;
                $email->enviarMensageria($request, $objContratacaoDemanda, 'reiteracao', 'faseLiquidacaoOperacao');
            }
        }
        dd($contratosSemRetorno);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listagemDemandasComContratosAssinadosPendentesDeEnvio()
    {
        $listagemDemandasParaConformidadeContrato = [];

        $demandaContratacao = ContratacaoDemanda::with(['EsteiraContratacaoUpload', 'EsteiraContratacaoUpload.EsteiraDadosContrato'])->whereIn('statusAtual', ['CONTRATO ENVIADO', 'CONTRATO PENDENTE'])->get();

        for ($i = 0; $i < sizeof($demandaContratacao); $i++) {
            if ($demandaContratacao[$i]->cpf === null) {
                $cpfCnpj = $demandaContratacao[$i]->cnpj;
            } else {
                $cpfCnpj = $demandaContratacao[$i]->cpf;
            }
            if ($demandaContratacao[$i]->agResponsavel === null) {
                $unidadeDemandante = $demandaContratacao[$i]->srResponsavel;
            } else {
                $unidadeDemandante = $demandaContratacao[$i]->agResponsavel;
            }
            
            // CAPTURA DADOS DA DEMANDA
            $idDemanda = $demandaContratacao[$i]->idDemanda;
            $nomeCliente = $demandaContratacao[$i]->nomeCliente;
            $tipoOperacao = $demandaContratacao[$i]->tipoOperacao;
            $valorOperacao = $demandaContratacao[$i]->valorOperacao;
            $dataLiquidacao = $demandaContratacao[$i]->dataLiquidacao;
            $statusAtual = $demandaContratacao[$i]->statusAtual;

            // CAPTURA DA DADOS DO CONTRATO 
            for ($j = 0; $j < sizeof($demandaContratacao[$i]->EsteiraContratacaoUpload); $j++) { 
                $naoPodeAnalisarContrato = 0;
                switch ($demandaContratacao[$i]->EsteiraContratacaoUpload[$j]->tipoDoDocumento) {
                    case 'CONTRATACAO':
                    case 'ALTERACAO':
                    case 'CANCELAMENTO':
                        if ($demandaContratacao[$i]->EsteiraContratacaoUpload[$j]->EsteiraDadosContrato->temRetornoRede == 'SIM' and $demandaContratacao[$i]->EsteiraContratacaoUpload[$j]->EsteiraDadosContrato->statusContrato != 'CONTRATO ASSINADO') {
                            $naoPodeAnalisarContrato++;
                        }
                        break;
                }
            }
            if ($naoPodeAnalisarContrato == 0) {
                $demandaPendente = array(
                    'idDemanda' => $idDemanda,
                    'nomeCliente' => $nomeCliente,
                    'cpfCnpj' => $cpfCnpj,
                    'tipoOperacao' => $tipoOperacao,
                    'valorOperacao' => $valorOperacao,
                    'dataLiquidacao' => $dataLiquidacao,
                    'unidadeDemandante' => $unidadeDemandante,
                    'statusAtual' => $statusAtual
                );
                array_push($listagemDemandasParaConformidadeContrato, $demandaPendente);
            }
        }
        return json_encode(array('demandasParaConformidadeContrato' => $listagemDemandasParaConformidadeContrato), JSON_UNESCAPED_SLASHES);
    }

    public function listagemContratosPendentesUpload($id)
    {
        $arrayContratosPendentes = [];

        // CAPTURA DOS DADOS DA DEMANDA, COM DOCUMENTOS DE UPLOAD E DADOS CONTRATOS
        $objContratacaoDemanda = ContratacaoDemanda::with(['EsteiraContratacaoUpload', 'EsteiraContratacaoUpload.EsteiraDadosContrato'])->where('TBL_EST_CONTRATACAO_DEMANDAS.idDemanda', $id)->get();
    
        for ($i=0; $i < sizeof($objContratacaoDemanda[0]->EsteiraContratacaoUpload); $i++) { 
            switch ($objContratacaoDemanda[0]->EsteiraContratacaoUpload[$i]->tipoDoDocumento) {
                case 'CONTRATACAO':
                case 'ALTERACAO':
                case 'CANCELAMENTO':
                    if($objContratacaoDemanda[0]->EsteiraContratacaoUpload[$i]->EsteiraDadosContrato->statusContrato == 'CONTRATO PENDENTE'){
                        array_push($arrayContratosPendentes, $objContratacaoDemanda[0]->EsteiraContratacaoUpload[$i]->EsteiraDadosContrato);
                    }
                    break;  
            }
        }

        return json_encode(array('listaContratosPendentesUpload' => $arrayContratosPendentes), JSON_UNESCAPED_SLASHES);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function uploadDeContratoAssinado(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            // CAPTURA A UNIDADE DE LOTAÇÃO (FISICA OU ADMINISTRATIVA)
            if ($request->session()->get('codigoLotacaoFisica') == null || $request->session()->get('codigoLotacaoFisica') === "NULL") {
                $lotacao = $request->session()->get('codigoLotacaoAdministrativa');
            } else {
                $lotacao = $request->session()->get('codigoLotacaoFisica');
            }

            // RESGATA O ID DO CHECKLIST DADOS CONTRATO
            $objUploadContrato = ContratacaoUpload::find($request->idUploadContratoSemAssinatura);
            // dd($objUploadContrato);
            // CRIA O DIRETÓRIO PARA UPLOAD DOS ARQUIVOS
            ContratacaoFaseConformidadeDocumentalController::criaDiretorioUploadArquivoComplemento($objUploadContrato->idDemanda);

            // REALIZAR O UPLOAD DO CONTRATO ASSINADO
            $uploadContrato = ContratacaoFaseConformidadeDocumentalController::uploadArquivoContrato($request, "uploadContratoAssinado", $request->tipoContrato . "_ASSINADO", $objUploadContrato->idDemanda);

            // REALIZA UPDATE NO OBJETO DE DADOS CONTRATOS
            $objDadosContrato = ContratacaoDadosContrato::find($id);
            $objDadosContrato->idUploadContratoAssinado = $uploadContrato->idUploadLink;
            $objDadosContrato->statusContrato = 'CONTRATO ASSINADO';
            $objDadosContrato->dataEnvioContratoAssinado = date("Y-m-d H:i:s", time());
            $objDadosContrato->save();

            // REGISTRO DE HISTORICO
            $historico = new ContratacaoHistorico;
            $historico->idDemanda = $objUploadContrato->idDemanda;
            $historico->tipoStatus = "ENVIO DE CONTRATO ASSINADO";
            $historico->dataStatus = date("Y-m-d H:i:s", time());
            $historico->responsavelStatus = $request->session()->get('matricula');
            $historico->area = $lotacao;
            $historico->analiseHistorico = "Envio de contrato assinado nº $objDadosContrato->numeroContrato - Tipo: $request->tipoContrato";
            $historico->save();
        
            DB::commit();

            // VALIDA SE AINDA EXISTEM CONTRATOS PARA ENVIAR PARA DEFINIR O REDIRECT
            $objContratacaoDemanda = ContratacaoDemanda::with(['EsteiraContratacaoUpload', 'EsteiraContratacaoUpload.EsteiraDadosContrato'])->where('TBL_EST_CONTRATACAO_DEMANDAS.idDemanda', $objUploadContrato->idDemanda)->get();
            $contagemUploadContratoAssinado = 0;
            for ($i = 0; $i < sizeof($objContratacaoDemanda[0]->EsteiraContratacaoUpload); $i++) { 
                switch ($objContratacaoDemanda[0]->EsteiraContratacaoUpload[$i]->tipoDoDocumento) {
                    case 'CONTRATACAO':
                    case 'ALTERACAO':
                    case 'CANCELAMENTO':
                        if ($objContratacaoDemanda[0]->EsteiraContratacaoUpload[$i]->EsteiraDadosContrato->statusContrato == 'CONTRATO PENDENTE') {
                            $contagemUploadContratoAssinado++;
                        }
                        break;
                }
            }
        
            if($contagemUploadContratoAssinado > 0) {
                $request->session()->flash('corMensagem', 'success');
                $request->session()->flash('tituloMensagem', 'Upload realizado com sucesso');
                $request->session()->flash('corpoMensagem', 'Ainda existe(m) contrato(s) assinado(s) pendente(s) de envio');
                return redirect('esteiracomex/contratacao/carregar-contrato-assinado/' . $objUploadContrato->idDemanda);
            } else {
                // ATUALIZA O STATUS DA DEMANDA
                $objContratacaoDemanda[0]->statusAtual = 'CONTRATO ASSINADO';
                $objContratacaoDemanda[0]->save();

                // FLASH MESSAGE
                $request->session()->flash('corMensagem', 'success');
                $request->session()->flash('tituloMensagem', 'Todos os contratos assinados foram enviados');
                $request->session()->flash('corpoMensagem', 'A demanda foi encaminhada para conformidade.');
                return redirect('esteiracomex/acompanhar/minhas-demandas');
            }            
        } catch (\Exception $e) {
            DB::rollback();
            // dd($e);

            // FLASH MESSAGE
            $request->session()->flash('corMensagem', 'danger');
            $request->session()->flash('tituloMensagem', "Contrato não foi enviado");
            $request->session()->flash('corpoMensagem', "Aconteceu algum erro durante o envio do contrato, tente novamente.");
            return redirect('esteiracomex/contratacao/carregar-contrato-assinado/' . $objUploadContrato->idDemanda);
        }
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listagemDemandasDisponiveisParaConformidadeContratoAssinado()
    {      
        $arrayDemandaDisponiveis = [];
        $demandaFormalizacao = ContratacaoDemanda::where('statusAtual', 'CONTRATO ASSINADO')->orWhere('statusAtual', 'CONTRATO PENDENTE')->get();
        
        for ($i = 0; $i < sizeof($demandaFormalizacao); $i++) { 
            if ($demandaFormalizacao[$i]->agResponsavel === null) {
                $unidadeDemandante = $demandaFormalizacao[$i]->srResponsavel;
            } else {
                $unidadeDemandante = $demandaFormalizacao[$i]->agResponsavel;
            }
            if ($demandaFormalizacao[$i]->cpf === null) {
                $cpfCnpj = $demandaFormalizacao[$i]->cnpj;
            } else {
                $cpfCnpj = $demandaFormalizacao[$i]->cpf;
            }

            $dadosDemanda = array(
                'idDemanda' => $demandaFormalizacao[$i]->idDemanda,
                'nomeCliente' => $demandaFormalizacao[$i]->nomeCliente,
                'cpfCnpj' => $cpfCnpj,
                'tipoOperacao' => $demandaFormalizacao[$i]->tipoOperacao,
                'valorOperacao' => $demandaFormalizacao[$i]->valorOperacao,
                'unidadeDemandante' => $unidadeDemandante,
                'statusAtual' => $demandaFormalizacao[$i]->statusAtual,
            );
            array_push($arrayDemandaDisponiveis, $dadosDemanda);
        }
        
        return json_encode(array('listaDemandasSemConformidade' => $arrayDemandaDisponiveis), JSON_UNESCAPED_SLASHES);
    }

    public function listagemContratosParaConformidade($id)
    {
        $arrayContratosDisponiveis = [];

        // CAPTURA OS DADOS DA DEMANDA
        $objContratacaoDemanda = ContratacaoDemanda::with(['EsteiraContratacaoUpload', 'EsteiraContratacaoUpload.EsteiraDadosContrato'])->where('TBL_EST_CONTRATACAO_DEMANDAS.idDemanda', $id)->first();
        // dd($objContratacaoDemanda);
        // PERCORRE TODOS OS CONTRATOS PARA CAPTURAR OS QUE PODEM SER ANALISADOS
        for ($i = 0; $i < sizeof($objContratacaoDemanda->EsteiraContratacaoUpload) ; $i++) { 
            switch ($objContratacaoDemanda->EsteiraContratacaoUpload[$i]->tipoDoDocumento) {
                case 'CONTRATACAO_ASSINADO':
                case 'ALTERACAO_ASSINADO':
                case 'CANCELAMENTO_ASSINADO':
                    if ($objContratacaoDemanda->EsteiraContratacaoUpload[$i]->excluido == 'NAO') {
                        array_push($arrayContratosDisponiveis, $objContratacaoDemanda->EsteiraContratacaoUpload[$i]);
                    }
                    break;
            }
        }
        return json_encode(array('listaContratosDisponiveisConformidade' => $arrayContratosDisponiveis), JSON_UNESCAPED_SLASHES);
    }

    public function listagemContratosParaConformidadeBotoesAcao($id)
    {
        $arrayContratosDisponiveis = [];

        // CAPTURA OS DADOS DA DEMANDA
        $objContratacaoDemanda = ContratacaoDemanda::with(['EsteiraContratacaoUpload', 'EsteiraContratacaoUpload.EsteiraDadosContrato'])->where('TBL_EST_CONTRATACAO_DEMANDAS.idDemanda', $id)->first();
        // dd($objContratacaoDemanda);
        // PERCORRE TODOS OS CONTRATOS PARA CAPTURAR OS QUE PODEM SER ANALISADOS
        for ($i = 0; $i < sizeof($objContratacaoDemanda->EsteiraContratacaoUpload) ; $i++) { 
            switch ($objContratacaoDemanda->EsteiraContratacaoUpload[$i]->tipoDoDocumento) {
                case 'CONTRATACAO':
                case 'ALTERACAO':
                case 'CANCELAMENTO':
                    if ($objContratacaoDemanda->EsteiraContratacaoUpload[$i]->EsteiraDadosContrato->temRetornoRede == 'SIM' && $objContratacaoDemanda->EsteiraContratacaoUpload[$i]->EsteiraDadosContrato->statusContrato == 'CONTRATO ASSINADO' || $objContratacaoDemanda->EsteiraContratacaoUpload[$i]->EsteiraDadosContrato->statusContrato == 'CONTRATO PENDENTE' || $objContratacaoDemanda->EsteiraContratacaoUpload[$i]->EsteiraDadosContrato->statusContrato == 'ASSINATURA CONFORME') {
                        array_push($arrayContratosDisponiveis, $objContratacaoDemanda->EsteiraContratacaoUpload[$i]->EsteiraDadosContrato);
                    }
                    break;
            }
        }
        return json_encode(array('listaContratosDisponiveisConformidade' => $arrayContratosDisponiveis), JSON_UNESCAPED_SLASHES);
    }

    public function listagemDemandasControleDeRetorno()
    {
        $listagemDemandasPendentesretorno = [];

        $demandaContratacao = ContratacaoDemanda::with(['EsteiraContratacaoUpload', 'EsteiraContratacaoUpload.EsteiraDadosContrato'])->whereIn('statusAtual', ['CONTRATO ENVIADO', 'REITERADO'])->get();

        for ($i = 0; $i < sizeof($demandaContratacao); $i++) {
            if ($demandaContratacao[$i]->cpf === null) {
                $cpfCnpj = $demandaContratacao[$i]->cnpj;
            } else {
                $cpfCnpj = $demandaContratacao[$i]->cpf;
            }
            if ($demandaContratacao[$i]->agResponsavel === null) {
                $unidadeDemandante = $demandaContratacao[$i]->srResponsavel;
            } else {
                $unidadeDemandante = $demandaContratacao[$i]->agResponsavel;
            }
            
            // CAPTURA DADOS DA DEMANDA
            $idDemanda = $demandaContratacao[$i]->idDemanda;
            $nomeCliente = $demandaContratacao[$i]->nomeCliente;
            $tipoOperacao = $demandaContratacao[$i]->tipoOperacao;
            $valorOperacao = $demandaContratacao[$i]->valorOperacao;
            $dataLiquidacao = $demandaContratacao[$i]->dataLiquidacao;

            // CAPTURA DA DADOS DO CONTRATO 
            for ($j = 0; $j < sizeof($demandaContratacao[$i]->EsteiraContratacaoUpload); $j++) { 
                switch ($demandaContratacao[$i]->EsteiraContratacaoUpload[$j]->tipoDoDocumento) {
                    case 'CONTRATACAO':
                    case 'ALTERACAO':
                    case 'CANCELAMENTO':
                        if ($demandaContratacao[$i]->EsteiraContratacaoUpload[$j]->EsteiraDadosContrato->temRetornoRede == 'SIM' && $demandaContratacao[$i]->EsteiraContratacaoUpload[$j]->EsteiraDadosContrato->statusContrato == 'CONTRATO PENDENTE') {
                            //dd($demandaContratacao[$i]->EsteiraContratacaoUpload[$j]->EsteiraDadosContrato);
                            $numeroContrato = $demandaContratacao[$i]->EsteiraContratacaoUpload[$j]->EsteiraDadosContrato->numeroContrato;
                            $dataEnvioContrato = $demandaContratacao[$i]->EsteiraContratacaoUpload[$j]->EsteiraDadosContrato->dataEnvioContrato;
                            $dataLimiteRetorno = $demandaContratacao[$i]->EsteiraContratacaoUpload[$j]->EsteiraDadosContrato->dataLimiteRetorno;
                            $dataReiteracao = $demandaContratacao[$i]->EsteiraContratacaoUpload[$j]->EsteiraDadosContrato->dataReiteracao;
                            $demandaPendente = array(
                                'idDemanda' => $idDemanda,
                                'nomeCliente' => $nomeCliente,
                                'cpfCnpj' => $cpfCnpj,
                                'tipoOperacao' => $tipoOperacao,
                                'numeroContrato' => $numeroContrato,
                                'valorOperacao' => $valorOperacao,
                                'dataLiquidacao' => $dataLiquidacao,
                                'dataEnvioContrato' => $dataEnvioContrato,
                                'dataLimiteRetorno' => $dataLimiteRetorno,
                                'dataReiteracao' => $dataReiteracao,
                                'unidadeDemandante' => $unidadeDemandante
                            );
                            array_push($listagemDemandasPendentesretorno, $demandaPendente);
                        }
                        break;
                }
            }
        }
        return json_encode(array('demandasPendentesRetorno' => $listagemDemandasPendentesretorno), JSON_UNESCAPED_SLASHES);
    }

    public function listagemDemandasParaLiquidar()
    {
        $listagemDemandasParaLiquidar = [];

        $demandaContratacao = ContratacaoDemanda::with(['EsteiraContratacaoUpload', 'EsteiraContratacaoUpload.EsteiraDadosContrato'])->whereIn('statusAtual', ['ASSINATURA CONFORME'])->get(); // 'CONTRATO ENVIADO', 'REITERADO', 

        for ($i = 0; $i < sizeof($demandaContratacao); $i++) {
            if ($demandaContratacao[$i]->cpf === null) {
                $cpfCnpj = $demandaContratacao[$i]->cnpj;
            } else {
                $cpfCnpj = $demandaContratacao[$i]->cpf;
            }
            if ($demandaContratacao[$i]->agResponsavel === null) {
                $unidadeDemandante = $demandaContratacao[$i]->srResponsavel;
            } else {
                $unidadeDemandante = $demandaContratacao[$i]->agResponsavel;
            }

            // CAPTURA DADOS DA DEMANDA
            $idDemanda = $demandaContratacao[$i]->idDemanda;
            $nomeCliente = $demandaContratacao[$i]->nomeCliente;
            $tipoOperacao = $demandaContratacao[$i]->tipoOperacao;
            $valorOperacao = $demandaContratacao[$i]->valorOperacao;
            $dadosContaCliente = $demandaContratacao[$i]->dadosContaCliente;

            if ($demandaContratacao[$i]->liberadoLiquidacao == 'SIM') {
                $demandaPendente = array(
                    'idDemanda' => $idDemanda,
                    'nomeCliente' => $nomeCliente,
                    'cpfCnpj' => $cpfCnpj,
                    'tipoOperacao' => $tipoOperacao,
                    'valorOperacao' => $valorOperacao,
                    'unidadeDemandante' => $unidadeDemandante,
                    'dadosContaCliente' => $dadosContaCliente
                );
                array_push($listagemDemandasParaLiquidar, $demandaPendente);
            }
        }
        return json_encode(array('demandasParaLiquidar' => $listagemDemandasParaLiquidar), JSON_UNESCAPED_SLASHES);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     */
    public function conformidadeContratoAssinado(Request $request, $id)
    {
        // dd($request);
        try {
            DB::beginTransaction();
            // CAPTURA A UNIDADE DE LOTAÇÃO (FISICA OU ADMINISTRATIVA)
            if ($request->session()->get('codigoLotacaoFisica') == null || $request->session()->get('codigoLotacaoFisica') === "NULL") {
                $lotacao = $request->session()->get('codigoLotacaoAdministrativa');
            } else {
                $lotacao = $request->session()->get('codigoLotacaoFisica');
            } 

            // CAPTURA OS DADOS DO CONTRATO ANALISADO
            $verificaContratoAssinado = ContratacaoDadosContrato::with('EsteiraContratacaoUploadConsulta')->where('TBL_EST_CONTRATACAO_CONFORMIDADE_CONTRATO.idUploadContratoAssinado', $id)->first();
            
            $verificaContratoAssinado->dataAnaliseContratoAssinado = date("Y-m-d H:i:s", time());
            $verificaContratoAssinado->matriculaResponsavelAnalise = $request->session()->get('matricula');

            if ($request->aprovarContrato == 'SIM') {
                $verificaContratoAssinado->statusContrato = 'ASSINATURA CONFORME';
                $verificaContratoAssinado->dataArquivoContratoConforme = date("Y-m-d H:i:s", time());

                // REGISTRO DE HISTORICO
                $historico = new ContratacaoHistorico;
                $historico->idDemanda = $verificaContratoAssinado->EsteiraContratacaoUploadConsulta->idDemanda;
                $historico->tipoStatus = "CONTRATO CONFORME";
                $historico->dataStatus = date("Y-m-d H:i:s", time());
                $historico->responsavelStatus = $request->session()->get('matricula');
                $historico->area = $lotacao;
                $historico->analiseHistorico = "O contrato nº " . $verificaContratoAssinado->numeroContrato . " - Tipo: " . $verificaContratoAssinado->tipoContrato . " está conforme.";
                $historico->save();
            } else {
                $verificaContratoAssinado->statusContrato = 'CONTRATO PENDENTE';
                $verificaContratoAssinado->motivoInconformidade = $request->motivoInconformidade;
                
                $objUploadContrato = ContratacaoUpload::find($id);
                $objUploadContrato->excluido = 'SIM';
                $objUploadContrato->dataExcluido = date("Y-m-d H:i:s", time());
                $objUploadContrato->responsavelExclusao = $request->session()->get('matricula');
                $objUploadContrato->save();

                // ALTERA O STATUS DA DEMANDA
                $objContratacaoDemanda = ContratacaoDemanda::find($verificaContratoAssinado->EsteiraContratacaoUploadConsulta->idDemanda);
                $objContratacaoDemanda->statusAtual = 'CONTRATO PENDENTE';
                $objContratacaoDemanda->save();

                // REGISTRO DE HISTORICO
                $historico = new ContratacaoHistorico;
                $historico->idDemanda = $verificaContratoAssinado->EsteiraContratacaoUploadConsulta->idDemanda;
                $historico->tipoStatus = "CONTRATO INCONFORME";
                $historico->dataStatus = date("Y-m-d H:i:s", time());
                $historico->responsavelStatus = $request->session()->get('matricula');
                $historico->area = $lotacao;
                $historico->analiseHistorico = "O contrato nº " . $verificaContratoAssinado->numeroContrato . " está inconforme. Motivo: " . $verificaContratoAssinado->motivoInconformidade;
                $historico->save();
            }
            $verificaContratoAssinado->save();
            // dd($verificaContratoAssinado);
            
            // VERIFICA SE TODOS OS CONTRATOS DA DEMANDA ESTÃO CONFORMES
            $contadorDemandasPendentes = ContratacaoFaseLiquidacaoOperacaoController::liberaLiquidacao((array) $verificaContratoAssinado->EsteiraContratacaoUploadConsulta->idDemanda);
            
            if ($contadorDemandasPendentes == 0) {
                
                // REGISTRO DE HISTORICO
                $historico = new ContratacaoHistorico;
                $historico->idDemanda = $verificaContratoAssinado->EsteiraContratacaoUploadConsulta->idDemanda;
                $historico->tipoStatus = "DEMANDA CONFORME";
                $historico->dataStatus = date("Y-m-d H:i:s", time());
                $historico->responsavelStatus = $request->session()->get('matricula');
                $historico->area = $lotacao;
                $historico->analiseHistorico = "A demanda foi enviada para liquidação.";
                $historico->save();
                
                // FLASH MESSAGE
                $request->session()->flash('corMensagem', 'success');
                $request->session()->flash('tituloMensagem', 'Demanda analisada com sucesso');
                $request->session()->flash('corpoMensagem', 'Todos os contratos assinados estão conformes. A foi enviada para liquidação.'); 
                
                DB::commit();
                return redirect('esteiracomex/acompanhar/formalizadas');   
            } else {
                // FLASH MESSAGE
                $request->session()->flash('corMensagem', 'success');
                $request->session()->flash('tituloMensagem', 'Contrato analisado com sucesso');
                $request->session()->flash('corpoMensagem', 'Ainda existem contratos pendentes neste contrato. A demanda ainda não pode ser liberada para liquidação.'); 
                
                DB::commit();
                // dd($objUploadContrato);
                return redirect('esteiracomex/contratacao/verificar-contrato-assinado/' . $verificaContratoAssinado->EsteiraContratacaoUploadConsulta->idDemanda);
            }                  
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);

            // FLASH MESSAGE
            $request->session()->flash('corMensagem', 'danger');
            $request->session()->flash('tituloMensagem', "Análise do contrato não foi finalizada");
            $request->session()->flash('corpoMensagem', "Aconteceu algum erro durante a análise do contrato, tente novamente.");
            return redirect('esteiracomex/contratacao/verificar-contrato-assinado/' . $verificaContratoAssinado->EsteiraContratacaoUploadConsulta->idDemanda);
        }
    }

    public static function liberaLiquidacao($demanda) 
    {
        $demandaContratacao = ContratacaoDemanda::with(['EsteiraContratacaoUpload', 'EsteiraContratacaoUpload.EsteiraDadosContrato'])->whereIn('idDemanda', $demanda)->get();

        $contadorDemandasPendentes = 0;
        for ($i = 0; $i < sizeof($demandaContratacao[0]->EsteiraContratacaoUpload); $i++) { 
            switch ($demandaContratacao[0]->EsteiraContratacaoUpload[$i]->tipoDoDocumento) {
                case 'CONTRATACAO':
                case 'ALTERACAO':
                case 'CANCELAMENTO':
                    if($demandaContratacao[0]->EsteiraContratacaoUpload[$i]->EsteiraDadosContrato->statusContrato == 'CONTRATO PENDENTE' || $demandaContratacao[0]->EsteiraContratacaoUpload[$i]->EsteiraDadosContrato->statusContrato == 'CONTRATO ASSINADO'){
                        $contadorDemandasPendentes++;
                    }
                    break;  
            }
        }

        if($contadorDemandasPendentes == 0) {
            $demandaContratacao[0]->statusAtual = 'ASSINATURA CONFORME';
            $demandaContratacao[0]->liberadoLiquidacao = 'SIM';
            $demandaContratacao[0]->save();
        }
        
        return $contadorDemandasPendentes;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function liquidarDemanda(Request $request, $id)
    {
        try {
            // CAPTURA A UNIDADE DE LOTAÇÃO (FISICA OU ADMINISTRATIVA)
            if ($request->session()->get('codigoLotacaoFisica') == null || $request->session()->get('codigoLotacaoFisica') === "NULL") {
                $lotacao = $request->session()->get('codigoLotacaoAdministrativa');
            } 
            else {
                $lotacao = $request->session()->get('codigoLotacaoFisica');
            }
            DB::beginTransaction();

            // CAPTURA OS DADOS DA DEMANDA
            $objContratacaoDemanda = ContratacaoDemanda::find($id);
            
            if ($request->statusAtual == 'LIQUIDADA') {
                // ATUALIZA A DEMANDA
                $objContratacaoDemanda->statusAtual = $request->statusAtual;
                $objContratacaoDemanda->save();

                // REGISTRO DE HISTORICO
                $historico = new ContratacaoHistorico;
                $historico->idDemanda = $id;
                $historico->tipoStatus = "DEMANDA LIQUIDADA";
                $historico->dataStatus = date("Y-m-d H:i:s", time());
                $historico->responsavelStatus = $request->session()->get('matricula');
                $historico->area = $lotacao;
                if ($objContratacaoDemanda->tipoOperacao == 'Pronto Importação Antecipado' || $objContratacaoDemanda->tipoOperacao == 'Pronto Importação') {
                    $historico->analiseHistorico = "O débito em conta ocorreu com sucesso.";
                } else {
                    $historico->analiseHistorico = "O crédito em conta ocorreu com sucesso.";
                }
                $historico->save();
  
                // REGISTRO DE HISTORICO
                $historico = new ContratacaoHistorico;
                $historico->idDemanda = $id;
                $historico->tipoStatus = "DEMANDA ARQUIVADA";
                $historico->dataStatus = date("Y-m-d H:i:s", time());
                $historico->responsavelStatus = $request->session()->get('matricula');
                $historico->area = $lotacao;
                $historico->analiseHistorico = "A demanda foi arquivada.";
                $historico->save();

                // RETORNA A FLASH MESSAGE
                $request->session()->flash('corMensagem', 'success');
                $request->session()->flash('tituloMensagem', "Demanda liquidada!");
                $request->session()->flash('corpoMensagem', "A demanda #" . str_pad($id, 4, '0', STR_PAD_LEFT) . " foi liquidada com sucesso.");
            
            } else {

                // ATUALIZA A DEMANDA
                $objContratacaoDemanda->statusAtual = $request->statusAtual;
                $objContratacaoDemanda->motivoDevolucaoLiquidacao = $request->motivoDevolucaoLiquidacao;
                $objContratacaoDemanda->save();

                // REGISTRO DE HISTORICO
                $historico = new ContratacaoHistorico;
                $historico->idDemanda = $id;
                $historico->tipoStatus = "DEMANDA NÃO LIQUIDADA";
                $historico->dataStatus = date("Y-m-d H:i:s", time());
                $historico->responsavelStatus = $request->session()->get('matricula');
                $historico->area = $lotacao;               
                $historico->analiseHistorico = "A liquidação da operação não foi efetuada. Motivo: " . $request->motivoDevolucaoLiquidacao;                
                $historico->save();

                // RETORNA A FLASH MESSAGE
                $request->session()->flash('corMensagem', 'warning');
                $request->session()->flash('tituloMensagem', "A demanda #" . str_pad($id, 4, '0', STR_PAD_LEFT) . " não foi liquidada.");
                $request->session()->flash('corpoMensagem', "Demanda devolvida para a " . env('NOME_NOSSA_UNIDADE') . ".");
            }
            DB::commit();
            return redirect('esteiracomex/acompanhar/liquidar');
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            $request->session()->flash('corMensagem', 'danger');
            $request->session()->flash('tituloMensagem', "A demanda #" . str_pad($id, 4, '0', STR_PAD_LEFT) . " não foi liquidada.");
            $request->session()->flash('corpoMensagem', "Ocorreu um erro durante a operação. Tente novamente");
            return redirect('esteiracomex/acompanhar/liquidar');
        }
    }
}
