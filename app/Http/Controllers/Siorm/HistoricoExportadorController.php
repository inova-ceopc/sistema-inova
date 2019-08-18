<?php

namespace App\Http\Controllers\Siorm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Exports\UsersExport;
use App\Exports\Siorm\HistoricoExportadorExport;
use Maatwebsite\Excel\Facades\Excel;

class HistoricoExportadorController extends Controller
{

    function index(){
        
        return view('Siorm.index')->with('historicoExportador');
   
    }

    function emiteHistoricoExportador(Request $request)
    {

        try{

            $xmlTratado = trim(str_replace('IBM500','UTF-8', $request->xml)); 
            $xml = simplexml_load_string($xmlTratado);
            $chaveAnoMes = $xml->SISMSG->CAM0057R1;
     

            $competencia = $chaveAnoMes->Grupo_CAM0057R1_AnoMesComptc;
            
            $VlrTotContrd = 0;
            $VlrTotLiqdd = 0;
            $VlrTotCancel = 0;
            $VlrTotBaixd = 0;
            $VlrTotACC = 0;

            $historicoExportador = [];

            for ( $i = 0; $i < count($competencia); $i++){
             
                $mesCompetencia = $competencia[$i]->AnoMesComptc[0];
             
                for ($j=0; $j < count($competencia[$i]->Grupo_CAM0057R1_TpContrtoCAM); $j++) { 
                    $VlrTotContrd += floatval($competencia[$i]->Grupo_CAM0057R1_TpContrtoCAM[$j]->VlrTotContrd);
                    $VlrTotLiqdd += floatval($competencia[$i]->Grupo_CAM0057R1_TpContrtoCAM[$j]->VlrTotLiqdd);
                    $VlrTotCancel += floatval($competencia[$i]->Grupo_CAM0057R1_TpContrtoCAM[$j]->VlrTotCancel);
                    $VlrTotBaixd += floatval($competencia[$i]->Grupo_CAM0057R1_TpContrtoCAM[$j]->VlrTotBaixd);
                    $VlrTotACC += floatval($competencia[$i]->Grupo_CAM0057R1_TpContrtoCAM[$j]->VlrTotACC);
                }
                array_push($historicoExportador, [
                    'mesCompetencia' => $mesCompetencia,
                    'VlrTotContrd' => $VlrTotContrd,
                    'VlrTotLiqdado' => $VlrTotLiqdd,
                    'VlrTotCancel' => $VlrTotCancel,
                    'VlrTotBaixd' => $VlrTotBaixd,
                    'VlrTotACC' => $VlrTotACC
                ]);            
            }

  
        return view('Siorm.index', compact('historicoExportador'));
            
        }catch(\Exception $e){
            
            return view('Siorm.error');
            // echo "</h3>Por favor mande apenas o conteúdo da tag XML da página do SIORM<h3>";
            
            // dd($e);
        }
    }

     

}

