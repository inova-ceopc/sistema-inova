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
                    'dataRetornoContrato' => $dataEnvioContrato->addHours(1),
                    'prazo' => 'EmUmaHora'
            );
        } elseif ($dataLiquidacaoOperacao->gt($dataEnvioContrato)) {
            $dataLimiteRetorno = $dataEnvioContrato
                                        ->addDay()
                                        ->setUnitNoOverflow('hour', 12, 'day')
                                        ->setUnitNoOverflow('minute', 0, 'day')
                                        ->setUnitNoOverflow('second', 0, 'day');
            return array(
                'dataRetornoContrato' => ValidaMensageriaContratacao::proximoDiaUtil($dataLimiteRetorno),
                'prazo' => 'ProximoDiaUtil'
            );
        } else {
            return array(
                'dataRetornoContrato' => $dataEnvioContrato->addHours(1),
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
                    $objDadosContrato->dataEnvioContrato = Carbon::now();
                    $objDadosContrato->dataEnvioContratoEditavel = Carbon::now();
                    $objDadosContrato->dataLimiteRetorno = ValidaMensageriaContratacao::verificaDataRetorno($dataLiquidacao, $dataEnvioContrato, $dataEnvioContratoEditavel);
                    $objDadosContrato->save();
                } else {
                    $temRetornoRede = 'NÃO';
                    $dataEnvioContrato = Carbon::now();
                }
                break;
            case 'ALTERACAO':
                if ($objDadosContrato->temRetornoRede = 'SIM') {
                    $dataEnvioContrato = Carbon::now();
                    $dataEnvioContratoEditavel = Carbon::now();
                    $dataLimiteRetorno = ValidaMensageriaContratacao::verificaDataRetorno($dataLiquidacao, $dataEnvioContrato, $dataEnvioContratoEditavel);
                } else {
                    $dataEnvioContrato = Carbon::now();
                } 
                break;
            case 'CANCELAMENTO':
                $temRetornoRede = 'NÃO';
                $dataEnvioContrato = Carbon::now();
                break;
        }
    }
}