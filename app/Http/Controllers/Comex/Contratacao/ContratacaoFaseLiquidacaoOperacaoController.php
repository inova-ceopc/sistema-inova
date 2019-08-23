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
// use App\Models\Comex\Contratacao\ContratacaoConfereConformidade;
use App\Models\Comex\Contratacao\ContratacaoContaImportador;
use App\Models\Comex\Contratacao\ContratacaoHistorico;
use App\Models\Comex\Contratacao\ContratacaoUpload;
use App\Http\Controllers\Comex\Contratacao\ContratacaoFaseConformidadeDocumentalController;

class ContratacaoFaseLiquidacaoOperacaoController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $objContratacaoDemanda = ContratacaoDemanda::with(['EsteiraContratacaoUpload', 'EsteiraContratacaoUpload.EsteiraDadosContrato'])->where('TBL_EST_CONTRATACAO_DEMANDAS.idDemanda', 1)->get();
       
        // dd($objContratacaoDemanda);
        
        $relacaoFinalContratosParaFormalizar = [];
        // $listaInicialContratosParaFormalizar = ContratacaoDemanda::with(['EsteiraContratacaoUpload', 'EsteiraContratacaoUpload.EsteiraDadosContrato'])->whereIn('TBL_EST_CONTRATACAO_DEMANDAS.statusAtual', ['CONFORME', 'CONTRATO ENVIADO', 'REITERADO'])->get();
        // return json_encode(array('demandasFormalizadas' => $listaInicialContratosParaFormalizar), JSON_UNESCAPED_SLASHES);
        
        $listaInicialContratosParaFormalizar = ContratacaoDemanda::whereIn('statusAtual', ['CONFORME', 'CONTRATO ENVIADO', 'REITERADO', 'ASSINATURA CONFIRMADA'])->get();
        
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
    public function store(Request $request)
    { 
        // dd($request);
        try {
            DB::beginTransaction();
            // CAPTURA A UNIDADE DE LOTAÇÃO (FISICA OU ADMINISTRATIVA)
            if ($request->session()->get('codigoLotacaoFisica') == null || $request->session()->get('codigoLotacaoFisica') === "NULL") {
                $lotacao = $request->session()->get('codigoLotacaoAdministrativa');
            } 
            else {
                $lotacao = $request->session()->get('codigoLotacaoFisica');
            }

            // CRIA O DIRETÓRIO PARA UPLOAD DOS ARQUIVOS
            ContratacaoFaseConformidadeDocumentalController::criaDiretorioUploadArquivoComplemento($request->idDemanda);
            
            // REALIZA O UPLOAD DO CONTRATO
            switch ($request->tipoContrato) {
                case 'CONTRATACAO':
                    $uploadContrato = ContratacaoFaseConformidadeDocumentalController::uploadArquivo($request, "uploadContrato", "CONTRATACAO", $request->idDemanda);
                    break;
                case 'ALTERACAO':
                    $uploadContrato = ContratacaoFaseConformidadeDocumentalController::uploadArquivo($request, "uploadContrato", "ALTERACAO", $request->idDemanda);
                    break;
                case 'CANCELAMENTO':
                    $uploadContrato = ContratacaoFaseConformidadeDocumentalController::uploadArquivo($request, "uploadContrato", "CANCELAMENTO", $request->idDemanda);
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
            // dd(['objetoDemanda' => $objContratacaoDemanda, 'objDadosContrato' =>$objDadosContrato]);
            $objContratacaoDemanda->statusAtual = 'CONTRATO ENVIADO';
            
            // CADASTRO DE CHECKLIST
            if ($objDadosContrato->temRetornoRede == 'SIM') {
                $objDadosContrato->statusContrato = 'APRESENTAR CONTRATO';
                $objContratacaoDemanda->liberadoLiquidacao = 'NAO';
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
     * Display the specified resource.
     *
     * @param  \App\Models\Comex\Contratacao\ContratacaoDadosContrato $contratacaoDadosContrato
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public static function show(ContratacaoDadosContrato $contratacaoDadosContrato, $id)
    {
        $arrayContratosDemanda = [];
        $demandaFormalizacao = ContratacaoDemanda::with(['EsteiraContratacaoUpload', 'EsteiraContratacaoUpload.EsteiraDadosContrato'])->where('TBL_EST_CONTRATACAO_DEMANDAS.idDemanda', $id)->get();

        for ($i=0; $i < sizeof($demandaFormalizacao[0]->EsteiraContratacaoUpload); $i++) { 
            switch ($demandaFormalizacao[0]->EsteiraContratacaoUpload[$i]->tipoDoDocumento) {
                case 'CONTRATACAO':
                case 'ALTERACAO':
                case 'CANCELAMENTO':
                    array_push($arrayContratosDemanda, $demandaFormalizacao[0]->EsteiraContratacaoUpload[$i]->EsteiraDadosContrato);
                    break;  
            }
        }
        
        return json_encode(array('listaContratosDemanda' => $arrayContratosDemanda), JSON_UNESCAPED_SLASHES);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function update(Request $request, $id)
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
            // CARREGA A DEMANDA QUE SERÁ ATUALIZADA
            $objContratacaoDemanda = ContratacaoDemanda::find($id);

            for ($i = 0; $i < sizeof($request->confirmaAssinatura); $i++) { 
                // CARREGA OS DADOS DO CONTRATO E ATUALIZA COM OS DADOS DA CONFIRMAÇÃO
                $objDadosContrato = ContratacaoDadosContrato::find($request->input('confirmaAssinatura.' . $i . '.idContrato'));
                $objDadosContrato->dataConfirmacaoAssinatura = date("Y-m-d H:i:s", time());;
                $objDadosContrato->matriculaResponsavelConfirmacao = $request->session()->get('matricula');
                $objDadosContrato->save();
            }

            // REGISTRO DE HISTORICO
            $historico = new ContratacaoHistorico;
            $historico->idDemanda = $id;
            $historico->tipoStatus = "CONTRATO CONFIRMADO";
            $historico->dataStatus = date("Y-m-d H:i:s", time());
            $historico->responsavelStatus = $request->session()->get('matricula');
            $historico->area = $lotacao;
            $historico->analiseHistorico = "Assinatura(s) de contrato(s) confirmada(s)";
            $historico->save();

            // VALIDA SE A DEMANDA PODE SER ENVIADA PARA LIQUIDAÇÃO
            self::validaEnvioContratoParaLiquidacao($objDadosContrato);

            // ATUALIZA A DEMANDA
            $objContratacaoDemanda->statusAtual = 'ASSINATURA CONFIRMADA';
            $objContratacaoDemanda->save();

            // RETORNA A FLASH MESSAGE
            $request->session()->flash('corMensagem', 'success');
            $request->session()->flash('tituloMensagem', "Contrato(s) confirmado(s) com sucesso!");
            $request->session()->flash('corpoMensagem', "A confirmação de assinatura do contrato foi realizada com sucesso.");
            DB::commit();
            return $request;
        } catch (\Exception $e) {
            DB::rollback();
            return $e;
            $request->session()->flash('corMensagem', 'danger');
            $request->session()->flash('tituloMensagem', "Contrato não foi confirmado");
            $request->session()->flash('corpoMensagem', "Aconteceu algum erro durante a confirmação de assinatura do contrato, tente novamente.");
            return $request;
        }
    }

    public static function validaEnvioContratoParaLiquidacao($objDadosContrato)
    {       
        // MONTA O UNIVERSO DE CONTRATOS DA DEMANDA
        $demandaParaLiquidar = ContratacaoUpload::with(['EsteiraContratacaoDemanda', 'EsteiraDadosContrato'])->where('TBL_EST_CONTRATACAO_LINK_UPLOADS.idUploadLink', $objDadosContrato->idUploadContratoSemAssinatura)->get();
        $objContratacaoDemanda = ContratacaoDemanda::with(['EsteiraContratacaoUpload', 'EsteiraContratacaoUpload.EsteiraDadosContrato'])->where('TBL_EST_CONTRATACAO_DEMANDAS.idDemanda', $demandaParaLiquidar[0]->EsteiraContratacaoDemanda->idDemanda)->get();

        // CONTABILIZA SE TODOS OS CONTRATOS QUE DEVE RETORNAR FORAM CONFIRMADOS
        for ($i = 0; $i < sizeof($objContratacaoDemanda[0]->EsteiraContratacaoUpload); $i++) { 
            $naoPodeLiquidar = 0;
            switch ($objContratacaoDemanda[0]->EsteiraContratacaoUpload[$i]->tipoDoDocumento) {
                case 'CONTRATACAO':
                case 'ALTERACAO':
                case 'CANCELAMENTO':
                    if ($objContratacaoDemanda[0]->EsteiraContratacaoUpload[$i]->EsteiraDadosContrato->temRetornoRede == 'SIM' and is_null($objContratacaoDemanda[0]->EsteiraContratacaoUpload[$i]->EsteiraDadosContrato->dataConfirmacaoAssinatura)) {
                        $naoPodeLiquidar++;      
                    }
                    break;  
            }
        }

        // ATUALIZA OU NÃO O MODEL DE CONTRATACAO DEMANDA PARA HABILITAR O ENVIO PARA LIQUIDAÇÃO
        if ($naoPodeLiquidar == 0) {
            $contratacaoDemanda = ContratacaoDemanda::find($demandaParaLiquidar[0]->EsteiraContratacaoDemanda->idDemanda);
            $contratacaoDemanda->liberadoLiquidacao = 'SIM';
            $contratacaoDemanda->save();
        }
    }

    public function listagemDemandasControleDeRetorno()
    {
        $listagemDemandasPendentesretorno = [];

        $demandaContratacao = ContratacaoDemanda::with(['EsteiraContratacaoUpload', 'EsteiraContratacaoUpload.EsteiraDadosContrato'])->whereIn('statusAtual', ['CONTRATO ENVIADO', 'REITERADO', 'ASSINATURA CONFIRMADA'])->get();

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
                        if ($demandaContratacao[$i]->EsteiraContratacaoUpload[$j]->EsteiraDadosContrato->temRetornoRede == 'SIM') {
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function liquidarDemanda(Request $request, $id)
    {
        // dd($request);
        try {
            // CAPTURA A UNIDADE DE LOTAÇÃO (FISICA OU ADMINISTRATIVA)
            if ($request->session()->get('codigoLotacaoFisica') == null || $request->session()->get('codigoLotacaoFisica') === "NULL") {
                $lotacao = $request->session()->get('codigoLotacaoAdministrativa');
            } 
            else {
                $lotacao = $request->session()->get('codigoLotacaoFisica');
            }
            DB::beginTransaction();

            // ATUALIZA A DEMANDA
            $objContratacaoDemanda = ContratacaoDemanda::find($id);
            $objContratacaoDemanda->statusAtual = $request->statusAtual;
            $objContratacaoDemanda->save();
            
            if ($request->statusAtual == 'LIQUIDADA') {

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

                // RETORNA A FLASH MESSAGE
                $request->session()->flash('corMensagem', 'success');
                $request->session()->flash('tituloMensagem', "Demanda liquidada!");
                $request->session()->flash('corpoMensagem', "A demanda #" . str_pad($id, 4, '0', STR_PAD_LEFT) . " foi liquidada com sucesso.");
            } else {
                // REGISTRO DE HISTORICO
                $historico = new ContratacaoHistorico;
                $historico->idDemanda = $id;
                $historico->tipoStatus = "DEMANDA NÃO LIQUIDADA";
                $historico->dataStatus = date("Y-m-d H:i:s", time());
                $historico->responsavelStatus = $request->session()->get('matricula');
                $historico->area = $lotacao;               
                $historico->analiseHistorico = "A liquidação da operação não foi efetuada.";                
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
            return $e;
            $request->session()->flash('corMensagem', 'danger');
            $request->session()->flash('tituloMensagem', "A demanda #" . str_pad($id, 4, '0', STR_PAD_LEFT) . " não foi liquidada.");
            $request->session()->flash('corpoMensagem', "Ocorreu um erro durante a operação. Tente novamente");
            return redirect('esteiracomex/acompanhar/liquidar');
        }
    }

    public function listagemDemandasParaLiquidar()
    {
        $listagemDemandasParaLiquidar = [];

        $demandaContratacao = ContratacaoDemanda::with(['EsteiraContratacaoUpload', 'EsteiraContratacaoUpload.EsteiraDadosContrato'])->whereIn('statusAtual', ['CONTRATO ENVIADO', 'REITERADO', 'ASSINATURA CONFIRMADA'])->get();

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
}
