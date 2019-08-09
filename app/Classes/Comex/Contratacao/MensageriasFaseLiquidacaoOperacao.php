<?php

namespace App\Classes\Comex\Contratacao;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\Models\Comex\Contratacao\ContratacaoDadosContrato;

class MensageriasFaseLiquidacaoOperacao
{
    public static function originalSemRetorno($objContratacaoDemanda, $arrayDadosEmailUnidade, $mail, $objDadosContrato)
    {
        if ($objContratacaoDemanda->tipoOperacao == 'Pronto Importação Antecipado' || $objContratacaoDemanda->tipoOperacao == 'Pronto Importação') {
            $tipoOperacao = 'importação';
            $manualOperacao = 'CO309';
        } else {
            $tipoOperacao = 'exportação';
            $manualOperacao = 'CO308';
        }
        
        $mail->Subject = "*** TESTE PILOTO ***#CONFIDENCIAL 10 - Envio de contrato(s) de câmbio $tipoOperacao nº $objDadosContrato->numeroContrato | $objContratacaoDemanda->nomeCliente";
        $mail->Body .= "<ol>
                            <li>Segue abaixo link para download do contrato de câmbio tipo exportação nº $objDadosContrato->numeroContrato, celebrado em " . $objDadosContrato->dataEnvioContrato->format('d/m/Y') . ", do cliente $objContratacaoDemanda->nomeCliente.<li><br>
                            <br><a href='" . env('APP_URL') . "/esteiracomex/acompanhar/minhas-demandas'>link</a><br>
                            <li>Segundo a circular BACEN Nº 3.691, de 16 de dezembro 2013 e MN $manualOperacao, os contratos até USD 10.000,00 ou equivalente em outras moedas, não necessitam da formalização do contrato assinado.</li><br>
                            <li>Em caso de dúvidas entrar em contato com a Célula do Middle Office pelo telefone (11)3053.0602 ou ceopa07@caixa.gov.br.</li><br>
                        </ol>
                        <br>
                        <p>Atenciosamente,</p>
                        <br>
                        <p>CEOPA -  CN Operações do Atacado</p>
                        ";
    }

    public static function originalComRetornoUmaHora($objContratacaoDemanda, $arrayDadosEmailUnidade, $mail, $objDadosContrato)
    {
        $mail->Subject = "*** TESTE PILOTO ***#CONFIDENCIAL10 - Câmbio Pronto - $objContratacaoDemanda->nomeCliente - Esteira COMEX - Protocolo #$objContratacaoDemanda->idDemanda";
        $mail->Body .= " ";
    }

    public static function originalComRetornoProximoDiaUtil($objContratacaoDemanda, $arrayDadosEmailUnidade, $mail, $objDadosContrato)
    {
        $mail->Subject = "*** TESTE PILOTO ***#CONFIDENCIAL10 - Câmbio Pronto - $objContratacaoDemanda->nomeCliente - Esteira COMEX - Protocolo #$objContratacaoDemanda->idDemanda";
        $mail->Body .= " ";
    }

    public static function alteracaoSemRetorno($objContratacaoDemanda, $arrayDadosEmailUnidade, $mail, $objDadosContrato)
    {
        $mail->Subject = "*** TESTE PILOTO ***#CONFIDENCIAL10 - Câmbio Pronto - $objContratacaoDemanda->nomeCliente - Esteira COMEX - Protocolo #$objContratacaoDemanda->idDemanda";
        $mail->Body .= " ";
    }

    public static function alteracaoComRetornoEmUmaHora($objContratacaoDemanda, $arrayDadosEmailUnidade, $mail, $objDadosContrato)
    {
        $mail->Subject = "*** TESTE PILOTO ***#CONFIDENCIAL10 - Câmbio Pronto - $objContratacaoDemanda->nomeCliente - Esteira COMEX - Protocolo #$objContratacaoDemanda->idDemanda";
        $mail->Body .= " ";
    }

    public static function alteracaoComRetornoProximoDiaUtil($objContratacaoDemanda, $arrayDadosEmailUnidade, $mail, $objDadosContrato)
    {
        $mail->Subject = "*** TESTE PILOTO ***#CONFIDENCIAL10 - Câmbio Pronto - $objContratacaoDemanda->nomeCliente - Esteira COMEX - Protocolo #$objContratacaoDemanda->idDemanda";
        $mail->Body .= " ";
    }

    public static function cancelamento($objContratacaoDemanda, $arrayDadosEmailUnidade, $mail, $objDadosContrato)
    {
        $mail->Subject = "*** TESTE PILOTO ***#CONFIDENCIAL10 - Câmbio Pronto - $objContratacaoDemanda->nomeCliente - Esteira COMEX - Protocolo #$objContratacaoDemanda->idDemanda";
        $mail->Body .= " ";
    }

    public static function reiteracao($objContratacaoDemanda, $arrayDadosEmailUnidade, $mail, $objDadosContrato)
    {
        $mail->Subject = "*** TESTE PILOTO ***#CONFIDENCIAL10 - Câmbio Pronto - $objContratacaoDemanda->nomeCliente - Esteira COMEX - Protocolo #$objContratacaoDemanda->idDemanda";
        $mail->Body .= " ";
    }
}