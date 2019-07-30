<?php


// use Carbon\Carbon;
use Illuminate\Support\Carbon;
use Cmixin\BusinessDay;
use App\Classes\Comex\ValidaData;

$diaLiquidacao = Carbon::parse('2018-04-03');

// $dataEnvioContrato = Carbon::now();
$dataEnvioContrato = Carbon::parse('2018-03-29');
// $dataEnvioContratoEditado = Carbon::now();

$dataRetornoResposta = ValidaData::verificaDataRetorno($diaLiquidacao, $dataEnvioContrato);

echo "VALIDAÇÃO <hr>";
echo "Data Liquidação: $diaLiquidacao <br>";
echo "Data Envio Contrato: $dataEnvioContrato <br>";
echo "Data Retorno Resposta: $dataRetornoResposta <br>";