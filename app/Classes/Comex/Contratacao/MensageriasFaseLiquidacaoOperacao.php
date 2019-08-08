<?php

namespace App\Classes\Comex\Contratacao;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\Models\Comex\Contratacao\ContratacaoDadosContrato;

class MensageriasFaseLiquidacaoOperacao
{
    public static function originalSemRetorno($objEsteiraContratacao, $arrayDadosEmailUnidade, $mail)
    {
        $mail->Subject = "*** TESTE PILOTO ***#CONFIDENCIAL10 - Câmbio Pronto - $objEsteiraContratacao->nomeCliente - Esteira COMEX - Protocolo #$objEsteiraContratacao->idDemanda";
        $mail->Body .= " ";
    }

    public static function originalComRetornoUmaHora($objEsteiraContratacao, $arrayDadosEmailUnidade, $mail)
    {
        $mail->Subject = "*** TESTE PILOTO ***#CONFIDENCIAL10 - Câmbio Pronto - $objEsteiraContratacao->nomeCliente - Esteira COMEX - Protocolo #$objEsteiraContratacao->idDemanda";
        $mail->Body .= " ";
    }

    public static function originalComRetornoProximoDiaUtil($objEsteiraContratacao, $arrayDadosEmailUnidade, $mail)
    {
        $mail->Subject = "*** TESTE PILOTO ***#CONFIDENCIAL10 - Câmbio Pronto - $objEsteiraContratacao->nomeCliente - Esteira COMEX - Protocolo #$objEsteiraContratacao->idDemanda";
        $mail->Body .= " ";
    }

    public static function alteracaoSemRetorno($objEsteiraContratacao, $arrayDadosEmailUnidade, $mail)
    {
        $mail->Subject = "*** TESTE PILOTO ***#CONFIDENCIAL10 - Câmbio Pronto - $objEsteiraContratacao->nomeCliente - Esteira COMEX - Protocolo #$objEsteiraContratacao->idDemanda";
        $mail->Body .= " ";
    }

    public static function alteracaoComRetornoEmUmaHora($objEsteiraContratacao, $arrayDadosEmailUnidade, $mail)
    {
        $mail->Subject = "*** TESTE PILOTO ***#CONFIDENCIAL10 - Câmbio Pronto - $objEsteiraContratacao->nomeCliente - Esteira COMEX - Protocolo #$objEsteiraContratacao->idDemanda";
        $mail->Body .= " ";
    }

    public static function alteracaoComRetornoProximoDiaUtil($objEsteiraContratacao, $arrayDadosEmailUnidade, $mail)
    {
        $mail->Subject = "*** TESTE PILOTO ***#CONFIDENCIAL10 - Câmbio Pronto - $objEsteiraContratacao->nomeCliente - Esteira COMEX - Protocolo #$objEsteiraContratacao->idDemanda";
        $mail->Body .= " ";
    }

    public static function cancelamento($objEsteiraContratacao, $arrayDadosEmailUnidade, $mail)
    {
        $mail->Subject = "*** TESTE PILOTO ***#CONFIDENCIAL10 - Câmbio Pronto - $objEsteiraContratacao->nomeCliente - Esteira COMEX - Protocolo #$objEsteiraContratacao->idDemanda";
        $mail->Body .= " ";
    }

    public static function reiteracao($objEsteiraContratacao, $arrayDadosEmailUnidade, $mail)
    {
        $mail->Subject = "*** TESTE PILOTO ***#CONFIDENCIAL10 - Câmbio Pronto - $objEsteiraContratacao->nomeCliente - Esteira COMEX - Protocolo #$objEsteiraContratacao->idDemanda";
        $mail->Body .= " ";
    }
}