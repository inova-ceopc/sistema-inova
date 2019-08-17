<?php

namespace App\Http\Controllers\Siorm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Excel;

class HistoricoExportadorController extends Controller
{
    public $dadosdHistoricoExportador;


    function setDadosHistoricoExportador($value){
        $this->dadosHistoricoExportador = $value;
    }

    function getDadosHistoricoExportador(){
        return $this->dadosHistoricoExportador;        
    }


    function index(){
        
        return view('Siorm.index')->with('historicoExportador');
   
    }

    function emiteHistoricoExportador(Request $request)
    {

        try{

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

            //setDadosHistoricoExportador($historicoExportador);
            $this->dadosdHistoricoExportador = $historicoExportador;
            dd($this->dadosdHistoricoExportador);
        //    $historicoExportador = $historicoExportador;
        //    dd($historicoExportador);
            // return json_encode($historicoExportador);
        return view('Siorm.index', compact('historicoExportador'));
            
        }catch(\Exception $e){
            // echo "</h1>Atenção<h1>";
            echo "</h3>Por favor mande apenas o conteúdo da tag XML da página do SIORM<h3>";
            

        }
    }

    function exportaExcel()
    {
        $dadosHistoricos = $this->dadosdHistoricoExportador;
        $cabecalhoPlanilha[] = array(
            'Ano/Mês Competência',
            'Valor Total Contratado',
            'Valor Total Liquidado',
            'Valor Total Cancelado',
            'Valor Total Baixado',
            'Valor Total ACC'
        );

        foreach ($dadosHistoricos as $dadoHistorico)
        {
            $dadoHistorico[] = array(
                'Ano/Mês Competência' => $dadoHistorico->mesCompetencia,
                'Valor Total Contratado' => $dadoHistorico->mesCompetencia,
                'Valor Total Liquidado'=> $dadoHistorico->mesCompetencia,
                'Valor Total Cancelado'=> $dadoHistorico->mesCompetencia,
                'Valor Total Baixado'=> $dadoHistorico->mesCompetencia,
                'Valor Total ACC' => $dadoHistorico->mesCompetencia
            );
        }
        Excel::create('dados', 
            function($excel) use($dadoHistorico){
                $excel->setTitle('Histórico de Exportador');
                $excel->sheet('Dados Históricos do Exportador', function($sheet) 
                use($dadoHistorico){
                    $sheet->fromArray($dadoHistorico, null, 'A1', false, false);
                });
            })->download('xlsx');
    }

}





