<?php

namespace App\Classes\Comex\Contratacao;

use Illuminate\Http\Request;

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
        if (Carbon::parse($data)->isBusinessDay()) {
            Carbon::getHolidaysRegion();
            return $data;
        } else {
            Carbon::parse($data)->nextBusinessDay();
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

    /**
     * Update the specified user.
     *
     * @param  Request  $request
     */

    public static function defineTipoMensageria(Request $request, $objContratacaoDemanda, $objDadosContrato)
    {
        $objDadosContrato->statusContrato = 'CONTRATO PENDENTE';
        $objContratacaoDemanda->statusAtual = 'CONTRATO ENVIADO';
        $objDadosContrato->dataEnvioContrato = Carbon::now()->format('Y-m-d H:i:s');
        switch ($objDadosContrato->tipoContrato) {
            case 'CONTRATACAO':
                if ($objContratacaoDemanda->equivalenciaDolar >= 10000) {
                    $objDadosContrato->temRetornoRede = 'SIM';                  
                    $arrayDadosValidados = json_decode(json_encode(ValidaMensageriaContratacao::verificaDataRetorno(Carbon::parse($objContratacaoDemanda->dataLiquidacao), Carbon::now(), Carbon::now())));
                    $objDadosContrato->dataLimiteRetorno = $arrayDadosValidados->dataRetornoContrato;
                    if ($arrayDadosValidados->prazo === 'EmUmaHora') {
                        if (env('DB_CONNECTION') === 'sqlsrv') {
                            ContratacaoPhpMailer::enviarMensageria($request, $objContratacaoDemanda, 'originalComRetornoEmUmaHora', 'faseLiquidacaoOperacao', $objDadosContrato);
                        }
                    } else {
                        if (env('DB_CONNECTION') === 'sqlsrv') {
                            ContratacaoPhpMailer::enviarMensageria($request, $objContratacaoDemanda, 'originalComRetornoProximoDiaUtil', 'faseLiquidacaoOperacao', $objDadosContrato);
                        }
                    }
                    $objDadosContrato->save();
                } else {
                    $objDadosContrato->statusContrato = 'DISPENSA CONFORMIDADE';
                    $objContratacaoDemanda->liberadoLiquidacao = 'SIM';
                    $objDadosContrato->temRetornoRede = 'NAO';
                    if (env('DB_CONNECTION') === 'sqlsrv') {
                        ContratacaoPhpMailer::enviarMensageria($request, $objContratacaoDemanda, 'originalSemRetorno', 'faseLiquidacaoOperacao', $objDadosContrato);
                    }
                    $objDadosContrato->save();
                }
                break;
            case 'ALTERACAO':
                if ($objContratacaoDemanda->equivalenciaDolar >= 10000) {
                    if ($objDadosContrato->temRetornoRede == 'SIM') {
                        $arrayDadosValidados = json_decode(json_encode(ValidaMensageriaContratacao::verificaDataRetorno(Carbon::parse($objContratacaoDemanda->dataLiquidacao), Carbon::now(), Carbon::now())));
                        $objDadosContrato->dataLimiteRetorno = $arrayDadosValidados->dataRetornoContrato;
                        if ($arrayDadosValidados->prazo === 'EmUmaHora') {
                            if (env('DB_CONNECTION') === 'sqlsrv') {
                                ContratacaoPhpMailer::enviarMensageria($request, $objContratacaoDemanda, 'alteracaoComRetornoEmUmaHora', 'faseLiquidacaoOperacao', $objDadosContrato);
                            }
                        } else {
                            if (env('DB_CONNECTION') === 'sqlsrv') {
                                ContratacaoPhpMailer::enviarMensageria($request, $objContratacaoDemanda, 'alteracaoComRetornoProximoDiaUtil', 'faseLiquidacaoOperacao', $objDadosContrato);
                            }
                        }
                        $objDadosContrato->save();
                    } else {
                        $objDadosContrato->statusContrato = 'DISPENSA CONFORMIDADE';
                        if (env('DB_CONNECTION') === 'sqlsrv') {
                            ContratacaoPhpMailer::enviarMensageria($request, $objContratacaoDemanda, 'alteracaoSuperiorSemRetorno', 'faseLiquidacaoOperacao', $objDadosContrato);
                        }
                        $objDadosContrato->save();
                    }
                } else {
                    if ($objDadosContrato->temRetornoRede == 'SIM') {
                        $arrayDadosValidados = json_decode(json_encode(ValidaMensageriaContratacao::verificaDataRetorno(Carbon::parse($objContratacaoDemanda->dataLiquidacao), Carbon::now(), Carbon::now())));
                        $objDadosContrato->dataLimiteRetorno = $arrayDadosValidados->dataRetornoContrato;
                        if ($arrayDadosValidados->prazo === 'EmUmaHora') {
                            if (env('DB_CONNECTION') === 'sqlsrv') {
                                ContratacaoPhpMailer::enviarMensageria($request, $objContratacaoDemanda, 'alteracaoComRetornoEmUmaHora', 'faseLiquidacaoOperacao', $objDadosContrato);
                            }
                        } else {
                            if (env('DB_CONNECTION') === 'sqlsrv') {
                                ContratacaoPhpMailer::enviarMensageria($request, $objContratacaoDemanda, 'alteracaoComRetornoProximoDiaUtil', 'faseLiquidacaoOperacao', $objDadosContrato);
                            }
                        }
                        $objDadosContrato->save();
                    } else {
                        $objDadosContrato->statusContrato = 'DISPENSA CONFORMIDADE';
                        $objContratacaoDemanda->liberadoLiquidacao = 'SIM';
                    }
                    if (env('DB_CONNECTION') === 'sqlsrv') {
                        ContratacaoPhpMailer::enviarMensageria($request, $objContratacaoDemanda, 'alteracaoInferior', 'faseLiquidacaoOperacao', $objDadosContrato);
                    }
                    $objDadosContrato->save();
                } 
                break;
            case 'CANCELAMENTO':
                if ($objContratacaoDemanda->equivalenciaDolar >= 10000) {
                    if (env('DB_CONNECTION') === 'sqlsrv') {                       
                        ContratacaoPhpMailer::enviarMensageria($request, $objContratacaoDemanda, 'cancelamentoSuperior', 'faseLiquidacaoOperacao', $objDadosContrato);
                    }
                } else {
                    if (env('DB_CONNECTION') === 'sqlsrv') {
                        $objContratacaoDemanda->statusAtual = 'CANCELADA';
                        $objDadosContrato->statusContrato = 'DISPENSA CONFORMIDADE';
                        ContratacaoPhpMailer::enviarMensageria($request, $objContratacaoDemanda, 'cancelamentoInferior', 'faseLiquidacaoOperacao', $objDadosContrato);
                    }
                }
                $objDadosContrato->save();
                break;
            case 'REITERACAO':
                $objDadosContrato->dataReiteracao = Carbon::now()->format('Y-m-d H:i:s');
                $arrayDadosValidados = json_decode(json_encode(ValidaMensageriaContratacao::verificaDataRetorno(Carbon::parse($objContratacaoDemanda->dataLiquidacao), Carbon::now(), Carbon::now())));
                $objDadosContrato->dataLimiteRetorno = $arrayDadosValidados->dataRetornoContrato;
                $objDadosContrato->save();
                if (env('DB_CONNECTION') === 'sqlsrv') {
                    ContratacaoPhpMailer::enviarMensageria($request, $objContratacaoDemanda, 'reiteracao', 'faseLiquidacaoOperacao', $objDadosContrato);
                }
                break;
        }
    }
}