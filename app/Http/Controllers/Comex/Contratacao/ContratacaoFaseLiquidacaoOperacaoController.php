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
        // CAPTURA A UNIDADE DE LOTAÇÃO (FISICA OU ADMINISTRATIVA)
        if ($request->session()->get('codigoLotacaoFisica') == null || $request->session()->get('codigoLotacaoFisica') === "NULL") {
            $lotacao = $request->session()->get('codigoLotacaoAdministrativa');
        } 
        else {
            $lotacao = $request->session()->get('codigoLotacaoFisica');
        }
        
        
        // REALIZA O UPLOAD DO CONTRATO
        
        
        
        // CADASTRA OS DADOS DO CONTRATO
        $objContratacaoDemanda = ContratacaoDemanda::find($request->idDemanda);
        $objDadosContrato = new ContratacaoDadosContrato;
        $objDadosContrato->tipoContrato = $request->tipoContrato;
        $objDadosContrato->numeroContrato = $request->numeroContrato;
        $objDadosContrato->idUploadContrato = $request->idUploadContrato;
        $objDadosContrato->temRetornoRede = $request->temRetornoRede;

        // ENVIA MENSAGERIA
        ValidaMensageriaContratacao::defineTipoMensageria($objContratacaoDemanda, $objDadosContrato);
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
