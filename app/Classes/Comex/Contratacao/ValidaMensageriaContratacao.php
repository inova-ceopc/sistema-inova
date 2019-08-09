<?php

namespace App\Classes\Comex\Contratacao;

use Illuminate\Support\Carbon;
use Cmixin\BusinessDay;
use App\Models\Comex\Contratacao\ContratacaoDadosContrato;

class ValidaMensageriaContratacao 
{
    public static $feriados = array(
        'dia-mundial-da-paz' => '01-01',
        'terca-carnaval' => '= easter -47',
        'segunda-carnaval' => '= easter -48',
        'sexta-feira-da-paixao' => '= easter -2',
        'tirandentes' => '04-21',
        'trabalho' => '05-01',
        'corpus-christi' => '= easter 60',
        'independencia-do-brasil' => '09-07',
        'nossa-sra-aparecida' => '10-12',
        'finados' => '11-02',
        'proclamacao-republica' => '11-15',
        'natal' => '12-25',
        'ultimo-dia-util' => '12-31',
    );

    public static function proximoDiaUtil($data) 
    {
        BusinessDay::enable('Illuminate\Support\Carbon', 'br-national', static::$feriados);
        Carbon::setHolidaysRegion('br-national');
        if ($data->isBusinessDay()) {
            Carbon::getHolidaysRegion();
            return $data;
        } else {
            $data->nextBusinessDay();
            Carbon::getHolidaysRegion();
            return $data;
        }
    }

    public static function verificaDataRetorno($dataLiquidacaoOperacao, $dataEnvioContrato, $dataEnvioContratoEditavel)
    {
        if ($dataLiquidacaoOperacao->startOfDay()->eq($dataEnvioContratoEditavel->startOfDay())) {
            return array(
                    'dataRetornoContrato' => $dataEnvioContrato->addHours(1)->format('Y-m-d H:i:s'),
                    'prazo' => 'EmUmaHora'
            );
        } elseif ($dataLiquidacaoOperacao->gt($dataEnvioContrato)) {
            $dataLimiteRetorno = $dataEnvioContrato
                                        ->addDay()
                                        ->setUnitNoOverflow('hour', 12, 'day')
                                        ->setUnitNoOverflow('minute', 0, 'day')
                                        ->setUnitNoOverflow('second', 0, 'day')
                                        ->format('Y-m-d H:i:s');
            return array(
                'dataRetornoContrato' => ValidaMensageriaContratacao::proximoDiaUtil($dataLimiteRetorno),
                'prazo' => 'ProximoDiaUtil'
            );
        } else {
            return array(
                'dataRetornoContrato' => $dataEnvioContrato->addHours(1)->format('Y-m-d H:i:s'),
                'prazo' => 'EmUmaHora'
            );
        }
    }

    public static function defineTipoMensageria($objContratacaoDemanda, $objDadosContrato)
    {
        switch ($objDadosContrato->tipoContrato) {
            case 'CONTRATACAO':
                if ($objContratacaoDemanda->equivalenciaDolar >= 10000) {
                    $objDadosContrato->temRetornoRede = 'SIM';
                    $objDadosContrato->dataEnvioContrato = Carbon::now()->format('Y-m-d H:i:s');
                    $arrayDadosValidados = json_decode(json_encode(ValidaMensageriaContratacao::verificaDataRetorno(Carbon::parse($objContratacaoDemanda->dataLiquidacao), Carbon::now(), Carbon::now())));
                    $objDadosContrato->dataLimiteRetorno = $arrayDadosValidados->dataRetornoContrato;
                    if ($arrayDadosValidados->prazo === 'EmUmaHora') {
                        if (env('DB_CONNECTION') === 'sqlsrv') {
                            ContratacaoPhpMailer::enviarMensageria($request, $contrato, 'originalComRetornoEmUmaHora', 'faseLiquidacaoOperacao', $objDadosContrato);
                        }
                    } else {
                        if (env('DB_CONNECTION') === 'sqlsrv') {
                            ContratacaoPhpMailer::enviarMensageria($request, $contrato, 'originalComRetornoProximoDiaUtil', 'faseLiquidacaoOperacao', $objDadosContrato);
                        }
                    }
                    $objDadosContrato->save();
                } else {
                    $objDadosContrato->temRetornoRede = 'NÃO';
                    $objDadosContrato->dataEnvioContrato = Carbon::now()->format('Y-m-d H:i:s');
                    if (env('DB_CONNECTION') === 'sqlsrv') {
                        ContratacaoPhpMailer::enviarMensageria($request, $contrato, 'originalSemRetorno', 'faseLiquidacaoOperacao', $objDadosContrato);
                    }
                    $objDadosContrato->save();
                }
                break;
            case 'ALTERACAO':
                if ($objDadosContrato->temRetornoRede == 'SIM') {
                    if ($objContratacaoDemanda->equivalenciaDolar >= 10000) {
                        $objDadosContrato->dataEnvioContrato = Carbon::now()->format('Y-m-d H:i:s');
                        $arrayDadosValidados = json_decode(json_encode(ValidaMensageriaContratacao::verificaDataRetorno(Carbon::parse($objContratacaoDemanda->dataLiquidacao), Carbon::now(), Carbon::now())));
                        $objDadosContrato->dataLimiteRetorno = $arrayDadosValidados->dataRetornoContrato;
                        if ($arrayDadosValidados->prazo === 'EmUmaHora') {
                            if (env('DB_CONNECTION') === 'sqlsrv') {
                                ContratacaoPhpMailer::enviarMensageria($request, $contrato, 'alteracaoComRetornoEmUmaHora', 'faseLiquidacaoOperacao', $objDadosContrato);
                            }
                        } else {
                            if (env('DB_CONNECTION') === 'sqlsrv') {
                                ContratacaoPhpMailer::enviarMensageria($request, $contrato, 'alteracaoComRetornoProximoDiaUtil', 'faseLiquidacaoOperacao', $objDadosContrato);
                            }
                        }
                        $objDadosContrato->save();
                    } else {
                        $objDadosContrato->dataEnvioContrato = Carbon::now()->format('Y-m-d H:i:s');
                        if (env('DB_CONNECTION') === 'sqlsrv') {
                            ContratacaoPhpMailer::enviarMensageria($request, $contrato, 'alteracaoComRetornoProximoDiaUtil', 'faseLiquidacaoOperacao', $objDadosContrato);
                        }
                        $objDadosContrato->save();
                    }
                } else {
                    $objDadosContrato->dataEnvioContrato = Carbon::now()->format('Y-m-d H:i:s');
                    if (env('DB_CONNECTION') === 'sqlsrv') {
                        ContratacaoPhpMailer::enviarMensageria($request, $contrato, 'alteracaoSemRetorno', 'faseLiquidacaoOperacao', $objDadosContrato);
                    }
                    $objDadosContrato->save();
                } 
                break;
            case 'CANCELAMENTO':
                $temRetornoRede = 'NÃO';
                $objDadosContrato->dataEnvioContrato = Carbon::now()->format('Y-m-d H:i:s');
                if (env('DB_CONNECTION') === 'sqlsrv') {
                    ContratacaoPhpMailer::enviarMensageria($request, $contrato, 'cancelamento', 'faseLiquidacaoOperacao', $objDadosContrato);
                }
                $objDadosContrato->save();
                break;
        }
    }
}