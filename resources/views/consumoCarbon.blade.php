<?php

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Cmixin\BusinessDay;
use App\Classes\Comex\Contratacao\ValidaMensageriaContratacao;
use App\Classes\Comex\Contratacao\ContratacaoPhpMailer;
use App\Models\Comex\Contratacao\ContratacaoDadosContrato;

// dd($contrato->dataLiquidacao);

// if(isset($_GET['numeroContrato'])) {
//     $dataLiquidacao = $contrato->dataLiquidacao;
//     $objDadosContrato = new ContratacaoDadosContrato;
//     $objDadosContrato->tipoContrato = $_GET['tipoContrato'];
//     $objDadosContrato->numeroContrato = $_GET['numeroContrato'];
//     $objDadosContrato->idUploadContrato = $_GET['idUploadContrato'];
//     $objDadosContrato->temRetornoRede = $_GET['temRetornoRede'];
//     ValidaMensageriaContratacao::defineTipoMensageria($contrato, $objDadosContrato);
//     echo json_encode(['dados contrato' => $objDadosContrato, 'dados demanda' => $contrato]);
// }

use App\Http\Controllers\Comex\Contratacao\ContratacaoFaseLiquidacaoOperacaoController;
echo ContratacaoFaseLiquidacaoOperacaoController::validaEnvioContratoParaLiquidacao($contrato);

?>

{{-- <!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Validação Regra de Mensageria</title>
</head>
<body>
    <form action="" method="GET">
        Número Contrato: <input type="number" name="numeroContrato" required><br>
        ID Contrato (Tab Upload): <input type="number" name="idUploadContrato" placeholder="é número fake msm" required><br>
        Tipo Contrato: <select name="tipoContrato" required>
                            <option disabled selected>Selecione</option>
                            <option value="CONTRATACAO">Contratação</option>
                            <option value="ALTERACAO">Alteração</option>
                            <option value="CANCELAMENTO">Cancelamento</option>
                        </select><br>
        Tem retorno rede? <input type="radio" name="temRetornoRede" value="SIM" required>Sim
        <input type="radio" name="temRetornoRede" value="NÃO">Não<br>
        <button type="submit">Enviar</button>
        <hr>
    </form>
</body>
</html> --}}