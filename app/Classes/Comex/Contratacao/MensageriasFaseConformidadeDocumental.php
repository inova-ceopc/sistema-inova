<?php

namespace App\Classes\Comex\Contratacao;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\Classes\Comex\Contratacao\ContratacaoPhpMailer;
use App\Models\Comex\Contratacao\ContratacaoDadosContrato;

class MensageriasFaseConformidadeDocumental
{
    public static function demandaCadastrada($objEsteiraContratacao, $arrayDadosEmailUnidade, $mail) 
    {    //dd($objEsteiraContratacao);    

        // Content
        $mail->Subject = "*** TESTE PILOTO ***#CONFIDENCIAL10 - Câmbio Pronto - $objEsteiraContratacao->nomeCliente - Esteira COMEX - Protocolo #$objEsteiraContratacao->idDemanda";
        $mail->Body .= "      
            <h3 class='head_msg gray'>MENSAGEM AUTOMÁTICA. FAVOR NÃO RESPONDER.</h3>

            <p>Prezado(a) Senhor(a) Gerente</p>

            <p class='referencia'>REF. PROTOCOLO #$objEsteiraContratacao->idDemanda - Empresa: $objEsteiraContratacao->nomeCliente<p>

            <ol>
                <li>Informamos que a solicitação referente à contratação de câmbio pronto do cliente <b>$objEsteiraContratacao->nomeCliente</b> foi cadastrada com sucesso e o número do seu protocolo é : <b>#$objEsteiraContratacao->idDemanda</b>.</li>  
                <li>Disponibilizamos o link para o acompanhamento da sua solicitação: <a href='" . ContratacaoPhpMailer::getUrlSiteEsteiraComexContratacao() . "'>link</a>.</li>  
                <li>As dúvidas operacionais podem ser consultadas na cartilha ESTEIRA CONTRATAÇÃO, através do <a href=''>link</a>.</li>   
            </ol>

            <p>Atenciosamente,</p>

            <p>CEOPA - CN Operações do Atacado</p>";
        return $mail;
    }

    public static function demandaInconforme($objEsteiraContratacao, $arrayDadosEmailUnidade, $mail) 
    {        
        // Content
        $mail->addBCC('ceopa07@mail.caixa');
        $mail->Subject = "*** TESTE PILOTO ***#CONFIDENCIAL10 - Inconformidade - $objEsteiraContratacao->nomeCliente - Esteira COMEX - Protocolo #$objEsteiraContratacao->idDemanda";
        $mail->Body .= "     
            <h3 class='head_msg gray'>MENSAGEM AUTOMÁTICA. FAVOR NÃO RESPONDER.</h3>
            
            <p>Prezado(a) Senhor(a) Gerente</p>

            <p class='referencia'>REF. PROTOCOLO <b>#$objEsteiraContratacao->idDemanda</b> - Empresa: <b>$objEsteiraContratacao->nomeCliente</b><p>

            <ol>
                <li>Recebemos nesta data os documentos para contratação do câmbio pronto referente ao protocolo <b>#$objEsteiraContratacao->idDemanda</b>.</li>  
                <li>Informamos que a documentação apresentada está <b>inconforme</b>.</li>  
                <li>Para que possamos continuar com a análise, solicitamos que a agência regularize a(s) pendência(s) assinalada(s) abaixo:</li>
                <br/>
                <ul>
                    <li>
                        <b>" . nl2br($objEsteiraContratacao->analiseCeopc) . "</b>
                    </li>
                </ul>
                <br/>
                <li>A inconformidade tem 30 minutos para ser regularizada.</li>
                <li>Ressaltamos que a operação será cancelada após o horário informado.</li>
            </ol>

            <p>Atenciosamente,</p>

            <p>CEOPA - CN Operações do Atacado</p>";
        return $mail;
    }
}