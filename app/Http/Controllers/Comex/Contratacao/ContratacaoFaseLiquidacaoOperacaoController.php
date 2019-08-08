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
use App\Models\Comex\Contratacao\ContratacaoConfereConformidade;
use App\Models\Comex\Contratacao\ContratacaoContaImportador;
use App\Models\Comex\Contratacao\ContratacaoHistorico;
use App\Models\Comex\Contratacao\ContratacaoUpload;
use App\Http\Controllers\Comex\Contratacao\ContratacaoController;

class ContratacaoFaseLiquidacaoOperacaoController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index()
   {

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
            
            // REALIZA O UPLOAD DO CONTRATO
            switch ($request->tipoContrato) {
                case 'PRINCIPAL':
                    $uploadContrato = ContratacaoController::uploadArquivo($request, "uploadContrato", "PRINCIPAL", $request->idDemanda);
                    break;
                case 'ALTERACAO':
                    $uploadContrato = ContratacaoController::uploadArquivo($request, "uploadContrato", "ALTERACAO", $request->idDemanda);
                    break;
                case 'CANCELAMENTO':
                    $uploadContrato = ContratacaoController::uploadArquivo($request, "uploadContrato", "CANCELAMENTO", $request->idDemanda);
                    break;
            }
            
            // CADASTRA OS DADOS DO CONTRATO
            $objDadosContrato = new ContratacaoDadosContrato;
            $objDadosContrato->tipoContrato = $request->tipoContrato;
            $objDadosContrato->numeroContrato = $request->numeroContrato;
            $objDadosContrato->idUploadContrato = $uploadContrato->idUploadLink;
            $objDadosContrato->temRetornoRede = $request->temRetornoRede;

            // ENVIA MENSAGERIA
            $objContratacaoDemanda = ContratacaoDemanda::find($request->idDemanda);
            ValidaMensageriaContratacao::defineTipoMensageria($objContratacaoDemanda, $objDadosContrato);

            // CADASTRO DE CHECKLIST
            if ($objDadosContrato->temRetornoRede == 'SIM') {
                switch ($objDadosContrato->tipoContrato) {
                    case 'PRINCIPAL':
                        ContratacaoController::cadastraChecklist($request, "CONTRATO_PRINCIPAL", $request->idDemanda);
                        break;
                    case 'ALTERACAO':
                        ContratacaoController::cadastraChecklist($request, "CONTRATO_DE_ALTERACAO", $request->idDemanda);
                        break;
                    case 'CANCELAMENTO':
                        ContratacaoController::cadastraChecklist($request, "CONTRATO_DE_CANCELAMENTO", $request->idDemanda);
                        break;
                }
            } 
            
            // REGISTRO DE HISTORICO
            $historico = new ContratacaoHistorico;
            $historico->idDemanda = $request->idDemanda;
            $historico->tipoStatus = "ENVIO DE CONTRATO";
            $historico->dataStatus = date("Y-m-d H:i:s", time());
            $historico->responsavelStatus = $request->session()->get('matricula');
            $historico->area = $lotacao;
            $historico->analiseHistorico = "Envio de contrato - Tipo: $request->tipoContrato";
            $historico->save();
            
            // RETORNA A FLASH MESSAGE
            $request->session()->flash('corMensagem', 'success');
            $request->session()->flash('tituloMensagem', "Contrato nº " . $request->numeroContrato . " | Enviado com Sucesso!");
            $request->session()->flash('corpoMensagem', "O contrato foi enviado para a unidade demandante.");
            DB::commit();
            return redirect('esteiracomex/acompanhar/formalizados');
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            $request->session()->flash('corMensagemErroCadastro', 'danger');
            $request->session()->flash('tituloMensagemErroCadastro', "Contrato não foi enviado");
            $request->session()->flash('corpoMensagemErroCadastro', "Aconteceu algum erro durante o envio do contrato, tente novamente.");
            return redirect('esteiracomex/acompanhar/formalizados');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comex\Contratacao\ContratacaoDadosContrato $contratacaoDadosContrato
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(ContratacaoDadosContrato $contratacaoDadosContrato, $id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function update(Request $request, $id)
    {

    }
}
