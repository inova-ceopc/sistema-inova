<?php

namespace App\Http\Controllers\Comex\Indicadores;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Comex\OrdensDePagamento\OrdensDePagamentoEnviadas;

class ControllerPainelMatriz extends Controller
{
    //
    public function index(){

        $ordensDePagamento30dias = OrdensDePagamentoEnviadas::select('quantidade','dia')->get();

        $opesEnviadas= array('opesEnviadas'=>$ordensDePagamento30dias);

        return json_encode($opesEnviadas, JSON_UNESCAPED_SLASHES);
    }




}
