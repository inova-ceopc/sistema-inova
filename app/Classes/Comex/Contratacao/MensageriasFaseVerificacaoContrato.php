<?php

namespace App\Classes\Comex\Contratacao;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\Classes\Comex\Contratacao\ContratacaoPhpMailer;
// use App\Models\Comex\Contratacao\ContratacaoDadosContrato;

class MensageriasFaseConformidadeDocumental
{
    public static function contratoConforme($objContratacaoDemanda, $arrayDadosEmailUnidade, $mail, $objDadosContrato)
    {        
        // Content
        $mail->Subject = "*** TESTE PILOTO ***#CONFIDENCIAL10 - ";
        $mail->Body .= "      
            <h3 class='head_msg gray'>MENSAGEM AUTOMÁTICA. FAVOR NÃO RESPONDER.</h3>

            <p>Prezado(a) Senhor(a) Gerente</p>

            <p class='referencia'>REF. PROTOCOLO #$objEsteiraContratacao->idDemanda - Empresa: $objEsteiraContratacao->nomeCliente<p>

            <ol>
                <li></li>   
            </ol>

            <p>Atenciosamente,</p>

            <p>CELIT - CN Liquidação de Títulos e Tesouraria</p>";
        return $mail;
    }

    public static function contratoInconforme($objContratacaoDemanda, $arrayDadosEmailUnidade, $mail, $objDadosContrato)
    {        
        // Content
        $mail->addBCC('ceopa07@mail.caixa');
        $mail->Subject = "*** TESTE PILOTO ***#CONFIDENCIAL10 - ";
        $mail->Body .= "     
            <h3 class='head_msg gray'>MENSAGEM AUTOMÁTICA. FAVOR NÃO RESPONDER.</h3>
            
            <p>Prezado(a) Senhor(a) Gerente</p>

            <p class='referencia'>REF. PROTOCOLO <b>#$objEsteiraContratacao->idDemanda</b> - Empresa: <b>$objEsteiraContratacao->nomeCliente</b><p>

            <ol>
                <li></li>
            </ol>

            <p>Atenciosamente,</p>

            <p>CELIT - CN Liquidação de Títulos e Tesouraria</p>";
        return $mail;
    }
}