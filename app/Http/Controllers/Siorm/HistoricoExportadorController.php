<?php

namespace App\Http\Controllers\Siorm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HistoricoExportadorController extends Controller
{
    function index(){
        
        return view('Siorm.index')->with('historicoExportador');
   
    }

    function emiteHistoricoExportador(Request $request){

        $xmlTratado = trim(str_replace('IBM500','UTF-8', $request->xml)); 

        $xml = simplexml_load_string($xmlTratado);
        // dd($xml);

        $chaveAnoMes = $xml->SISMSG->CAM0057R1;
        // dd($chaveAnoMes);

        $competencia = $chaveAnoMes->Grupo_CAM0057R1_AnoMesComptc;
        
        $VlrTotContrd = 0;
        $VlrTotLiqdd = 0;
        $VlrTotCancel = 0;
        $VlrTotBaixd = 0;
        $VlrTotACC = 0;


        


        $historicoExportador = [];

        for ( $i = 0; $i < count($competencia); $i++){
            // dd($competencia[$i]->AnoMesComptc[0]);
            $mesCompetencia = $competencia[$i]->AnoMesComptc[0];
            // dd(count($competencia[$i]->Grupo_CAM0057R1_TpContrtoCAM));
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
    //    $historicoExportador = $historicoExportador;
    //    dd($historicoExportador);
        // return json_encode($historicoExportador);
       return view('Siorm.index', compact('historicoExportador'));
        
    }



}





