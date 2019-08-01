<?php

namespace App\Classes\Comex\Contratacao;

use Illuminate\Support\Carbon;
use Cmixin\BusinessDay;

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

    public static $motivosAlteracao = array(
        'ALTERAÇÃO DE MOEDA', 
        'ALTERAÇÃO DE BENEFICIARIO'
    );

    public static function validaFeriado($data) 
    {
        BusinessDay::enable('Illuminate\Support\Carbon', 'br-national', static::$feriados);
        Carbon::setHolidaysRegion('br-national');
        if ($data->isHoliday()) {
            Carbon::getHolidaysRegion();
            return $data->addDay()
                        ->setUnitNoOverflow('hour', 12, 'day')
                        ->setUnitNoOverflow('minute', 0, 'day')
                        ->setUnitNoOverflow('second', 0, 'day');
        } else {
            Carbon::getHolidaysRegion();
            return $data;
        }
    }

    public static function validaFimSemana($data) 
    {
        if ($data->isSunday()) {
            return $data->addDay()
                        ->setUnitNoOverflow('hour', 12, 'day')
                        ->setUnitNoOverflow('minute', 0, 'day')
                        ->setUnitNoOverflow('second', 0, 'day');
        } elseif ($data->isSaturday()) {
            return $data->addDays(2)
                        ->setUnitNoOverflow('hour', 12, 'day')
                        ->setUnitNoOverflow('minute', 0, 'day')
                        ->setUnitNoOverflow('second', 0, 'day');
        } else {
            return $data;
        }
    }

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

    public static function verificaDataRetorno ($dataLiquidacaoOperacao, $dataEnvioContrato, $dataEnvioContratoEditavel)
    {
        if ($dataLiquidacaoOperacao->startOfDay()->eq($dataEnvioContratoEditavel->startOfDay())) {
            return $dataEnvioContrato->addHours(1);
        } elseif ($dataLiquidacaoOperacao->gt($dataEnvioContrato)) {
            $dataRetornoResposta = $dataEnvioContrato
                                        ->addDay()
                                        ->setUnitNoOverflow('hour', 12, 'day')
                                        ->setUnitNoOverflow('minute', 0, 'day')
                                        ->setUnitNoOverflow('second', 0, 'day');
            return ValidaMensageriaContratacao::proximoDiaUtil($dataRetornoResposta);
        } else {
            return $dataEnvioContrato->addHours(1);
        }
    }

    public static function defineTipoMensageria ($tipoContrato, $motivoAlteracao, $equivalenciaDolar)
    {
        switch ($tipoContrato) {
            case 'CONTRATACAO':
                if ($equivalenciaDolar >= 10000) {
                    $maiorDezMil = 'SIM';
                    $vaiDiretoGelit = 'NÃO';
                    $dataRetornoResposta = ValidaMensageriaContratacao::verificaDataRetorno($dataLiquidacao, $dataEnvioContrato, $dataEnvioContratoEditado);
                } else {
                    $maiorDezMil = 'NÃO';
                    $vaiDiretoGelit = 'SIM';
                }
                break;
            case 'ALTERACAO':
                if ($equivalenciaDolar >= 10000) {
                    if(in_array($motivoAlteracao, static::$motivosAlteracao)) {
                        $maiorDezMil = 'SIM';
                        $vaiDiretoGelit = 'NÃO';
                        $dataRetornoResposta = ValidaMensageriaContratacao::verificaDataRetorno($dataLiquidacao, $dataEnvioContrato, $dataEnvioContratoEditado);
                    } else {
                        $maiorDezMil = 'NÃO';
                        $vaiDiretoGelit = 'SIM';
                    }
                } else {
                    $maiorDezMil = 'NÃO';
                    $vaiDiretoGelit = 'SIM';
                } 
                break;
            case 'CANCELAMENTO':
                $maiorDezMil = 'NÃO';
                break;
        }
    }
}