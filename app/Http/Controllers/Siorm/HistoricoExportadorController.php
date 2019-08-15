<?php

namespace App\Http\Controllers\Siorm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HistoricoExportadorController extends Controller
{
    function index(){
        //
    }

    function emiteHistoricoExportador(Request $request){

        $xmlTratado = str_replace('IBM500','UTF-8', $request->xml); 
        $xml = simplexml_load_string($xmlTratado);

        // dd($xml);

        $chaveAnoMes = $xml->SISMSG->CAM0057R1;


// peguei todos os anos;

        // for ($ano=0; $ano < count($chaveAnoMes->Grupo_CAM0057R1_AnoMesComptc); $i++) 
        // {
        //     echo $chaveAnoMes->Grupo_CAM0057R1_AnoMesComptc[$ano]->AnoMesComptc."<br>";


        // }



        //  dd(count($chaveAnoMes->Grupo_CAM0057R1_AnoMesComptc));

        //  dd($chaveAnoMes->Grupo_CAM0057R1_AnoMesComptc);



        // echo ($chaveAnoMes->Grupo_CAM0057R1_AnoMesComptc[3]->AnoMesComptc);

        // $json = json_encode($chaveAnoMes);

        // $array = json_decode($json,TRUE);


        for ($ano=0; $ano < count($chaveAnoMes->Grupo_CAM0057R1_AnoMesComptc); $ano++) 
        {
            echo $chaveAnoMes->Grupo_CAM0057R1_AnoMesComptc[$ano]->AnoMesComptc."<br>";
           
        }
     

    }

}





