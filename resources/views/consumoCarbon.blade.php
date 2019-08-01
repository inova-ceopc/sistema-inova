<?php


// use Carbon\Carbon;
use Illuminate\Support\Carbon;
use Cmixin\BusinessDay;
use App\Classes\Comex\ValidaData;


$motivosAlteracao = array('alteracaoMoeda', 'alteracaoBeneficiario');


$dataLiquidacao = Carbon::parse('2018-04-03');

// DADOS DO CONTRATO
$tipoContrato = 'CONTRATACAO';
$equivalenciaDolar = '11000.15';

// $dataEnvioContrato = Carbon::now();
$dataEnvioContrato = Carbon::parse('2018-03-29');
$dataEnvioContratoEditado = Carbon::parse('2018-03-29');


/* VALIDAÇÃO DE MENSAGERIA */

// VALIDA TIPO CONTRATO
switch ($tipoContrato) {
    case 'CONTRATACAO':
        if ($equivalenciaDolar >= 10000) {
            $maiorDezMil = 'SIM';
        } else {
            $maiorDezMil = 'NAO';
        }
        break;
    case 'ALTERACAO':
        if ($equivalenciaDolar >= 10000) {
            $maiorDezMil = 'SIM';
        } else {
            $maiorDezMil = 'NAO';
        } if(in_array($motivoAlteracao, $motivosAlteracao)) {
            
        } else {
            
        }
        break;
    case 'CANCELAMENTO':
        # code...
        break;
}


// VALIDA PRAZO
$dataRetornoResposta = ValidaData::verificaDataRetorno($dataLiquidacao, $dataEnvioContrato);

// RESULTADO DE MENSAGEIRIA




echo "<hr>";
echo "<h1>RESULTADO DA MENSAGERIA</h1>";
echo "<hr>";
echo "<h2>DADOS DA OPERAÇÃO:</h2>";
echo "<p><b>Liquidação:</b> $dataLiquidacao</p>";
echo "<p><b>Equivalencia USD:</b>  $equivalenciaDolar</p>";
echo "<hr>";
echo "<h2>DADOS ENVIO CONTRATO:</h2>";
echo "<p><b>Tipo de Contrato:</b>  $tipoContrato</p>";
echo "<p><b>Data Envio Contrato:</b>  $dataEnvioContratoEditado</p>";
echo "<hr>";
echo "<h2>RESULTADO:</h2>";
echo "<p><b>Retorno Rede:</b>  $maiorDezMil</p>";
echo "<p><b>Limite Resposta:</b>  $dataRetornoResposta</p>";
echo "<hr>";

