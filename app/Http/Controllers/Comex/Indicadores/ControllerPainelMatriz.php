<?php

namespace App\Http\Controllers\Comex\Indicadores;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

    public function resumoAccAceMensal ()
    {
        if (env('DB_CONNECTION') === 'sqlsrv') {
            $resumo = DB::select('exec sp_painel_matriz_indicadores_acc_ace_liquidacao_geral');
            return json_encode(['resumoAccAceMensal' => $resumo]);
        } else {
            $resumo = array(
                
                ['mes' => '01', 'ano' => '2019', 'cadastradas' => '243', 'liquidadas' => '213', 'canceladas' => '15'],
                ['mes' => '02', 'ano' => '2019', 'cadastradas' => '256', 'liquidadas' => '230', 'canceladas' => '18'],
                ['mes' => '03', 'ano' => '2019', 'cadastradas' => '150', 'liquidadas' => '140', 'canceladas' => '12'],
                ['mes' => '04', 'ano' => '2019', 'cadastradas' => '473', 'liquidadas' => '391', 'canceladas' => '33'],
                ['mes' => '05', 'ano' => '2019', 'cadastradas' => '403', 'liquidadas' => '415', 'canceladas' => '24'],
                ['mes' => '06', 'ano' => '2019', 'cadastradas' => '220', 'liquidadas' => '184', 'canceladas' => '28'],
                ['mes' => '07', 'ano' => '2019', 'cadastradas' => '335', 'liquidadas' => '329', 'canceladas' => '26'],
                ['mes' => '08', 'ano' => '2019', 'cadastradas' => '11', 'liquidadas' => '19', 'canceladas' => '2'],
                
            );
            return json_encode(['resumoAccAceMensal' => $resumo]);
        }
    }


    public function resumoAccAceUltimos30dias ()
    {
        if (env('DB_CONNECTION') === 'sqlsrv') {
            $resumo = DB::select('exec sp_painel_matriz_indicadores_acc_ace_liquidacao_ultimo_mes');
            return json_encode(['resumoAccAceUltimos30dias' => $resumo]);
        } else {
            $resumo = array(
                ['data'=>'2019-07-05','cadastradas'=>'2','liquidadas'=>'7','canceladas'=>'0'],
                ['data'=>'2019-07-08','cadastradas'=>'9','liquidadas'=>'6','canceladas'=>'0'],
                ['data'=>'2019-07-09','cadastradas'=>'15','liquidadas'=>'1','canceladas'=>'0'],
                ['data'=>'2019-07-10','cadastradas'=>'33','liquidadas'=>'7','canceladas'=>'7'],
                ['data'=>'2019-07-11','cadastradas'=>'31','liquidadas'=>'10','canceladas'=>'4'],
                ['data'=>'2019-07-12','cadastradas'=>'11','liquidadas'=>'9','canceladas'=>'3'],
                ['data'=>'2019-07-15','cadastradas'=>'28','liquidadas'=>'36','canceladas'=>'0'],
                ['data'=>'2019-07-16','cadastradas'=>'12','liquidadas'=>'10','canceladas'=>'0'],
                ['data'=>'2019-07-17','cadastradas'=>'11','liquidadas'=>'36','canceladas'=>'0'],
                ['data'=>'2019-07-18','cadastradas'=>'30','liquidadas'=>'7','canceladas'=>'2'],
                ['data'=>'2019-07-19','cadastradas'=>'14','liquidadas'=>'17','canceladas'=>'0'],
                ['data'=>'2019-07-22','cadastradas'=>'9','liquidadas'=>'10','canceladas'=>'2'],
                ['data'=>'2019-07-23','cadastradas'=>'4','liquidadas'=>'24','canceladas'=>'1'],
                ['data'=>'2019-07-24','cadastradas'=>'18','liquidadas'=>'14','canceladas'=>'0'],
                ['data'=>'2019-07-25','cadastradas'=>'8','liquidadas'=>'8','canceladas'=>'2'],
                ['data'=>'2019-07-26','cadastradas'=>'21','liquidadas'=>'8','canceladas'=>'0'],
                ['data'=>'2019-07-29','cadastradas'=>'35','liquidadas'=>'11','canceladas'=>'0'],
                ['data'=>'2019-07-30','cadastradas'=>'5','liquidadas'=>'33','canceladas'=>'0'],
                ['data'=>'2019-07-31','cadastradas'=>'8','liquidadas'=>'30','canceladas'=>'0'],
                ['data'=>'2019-08-01','cadastradas'=>'11','liquidadas'=>'7','canceladas'=>'0'],
                ['data'=>'2019-08-02','cadastradas'=>'0','liquidadas'=>'12','canceladas'=>'1'],
                ['data'=>'2019-08-03','cadastradas'=>'0','liquidadas'=>'0','canceladas'=>'1'],
               
            );
            return json_encode(['resumoAccAceUltimos30dias' => $resumo]);
        }
    }



}
