<?php

namespace App\Classes\Comex\Contratacao;

use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\RelacaoAgSrComEmail;

class ContratacaoPhpMailer
{
    protected $urlSiteEsteiraComexContratacao = '';

    public function getUrlSiteEsteiraComexContratacao()
    {
        $this->urlSiteEsteiraComexContratacao;
    }

    function enviarMensageria($objEsteiraContratacao, $tipoEmail){
        $mail = new PHPMailer(true);
        $objRelacaoEmailUnidades = $this->validaUnidadeDemandanteEmail($objEsteiraContratacao);
        $this->carregarDadosEmail($objEsteiraContratacao, $objRelacaoEmailUnidades, $mail);
        $this->carregarConteudoEmail($objEsteiraContratacao, $objRelacaoEmailUnidades, $mail, $tipoEmail);
        $this->enviarEmail($mail);
    }

    function validaUnidadeDemandanteEmail($objEsteiraContratacao) 
    {
        if ($objEsteiraContratacao->agResponsavel == null || $objEsteiraContratacao->agResponsavel === "NULL") {
            $objRelacaoEmailUnidades = RelacaoAgSrComEmail::where('codigoSr', $objEsteiraContratacao->srResponsavel);
        } else {
            $objRelacaoEmailUnidades = RelacaoAgSrComEmail::where('codigoAgencia', $objEsteiraContratacao->agResponsavel);
        }
        return $objRelacaoEmailUnidades;
    }

    function carregarDadosEmail(Request $request, $objEsteiraContratacao, $objRelacaoEmailUnidades, $mail)
    {
        //Server settings
        $mail->isSMTP();  
        $mail->CharSet = 'UTF-8';                                          
        $mail->Host = 'sistemas.correiolivre.caixa';  
        $mail->SMTPAuth = false;                                  
        $mail->Port = 25;                                    

        //Recipients
        $mail->setFrom('ceopc04@caixa.gov.br', 'CEOPC04 - COMEX Contratação');
        $mail->addAddress($request->session()->get('matricula') . '@mail.caixa');
        // $mail->addAddress($$objRelacaoEmailUnidades->emailAgencia);
        // $mail->addCC($objEsteiraContratacao->emailsr);

        $mail->addBCC('c111710@mail.caixa');    
        $mail->addBCC('c095060@mail.caixa');
        $mail->addBCC('c142765@mail.caixa');
        $mail->addBCC('c079436@mail.caixa');
        // $mail->addBCC('c063809@mail.caixa');
        // $mail->addBCC('c084941@mail.caixa');
        // $mail->addAddress('c079436@mail.caixa');    
        $mail->addReplyTo('ceopc04@caixa.gov.br');
        return $mail; 
    }

    function carregarConteudoEmail($objEsteiraContratacao, $objRelacaoEmailUnidades, $mail, $etapaDoProcesso)
    {
        switch ($etapaDoProcesso) {
            case 'demandaCadastrada':
                return $this->demandaCadastrada($objEsteiraContratacao, $objRelacaoEmailUnidades, $mail);
            break;
            case 'demandaInconforme':
                return $this->demandaInconforme($objEsteiraContratacao, $objRelacaoEmailUnidades, $mail);
            break;
            case 'envioContratoParaAssinatura':
                return $this->envioContratoParaAssinatura($objEsteiraContratacao, $objRelacaoEmailUnidades, $mail);
            break;
            case 'reiteracaoEnvioContratoParaAssinatura':
                return $this->reiteracaoEnvioContratoParaAssinatura($objEsteiraContratacao, $objRelacaoEmailUnidades, $mail);
            break;
        }
    }

    function enviarEmail($mail) 
    {
        try {
            $mail->send();
            // echo 'Mensagem enviada com sucesso';
        } catch (Exception $e) {
            // echo "Mensagem não pode ser enviada. Erro: {$mail->ErrorInfo}";
        }
    }

    function demandaCadastrada($objEsteiraContratacao, $objRelacaoEmailUnidades, $mail) 
    {        
        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = "#CONFIDENCIAL10 - Câmbio Pronto - $objEsteiraContratacao->nome - Esteira COMEX - Protocolo #$objEsteiraContratacao->idDemanda";
        $mail->Body = "
            <head>
                <meta charset=\"UTF-8\">
                <style>
                    body {
                        font-family: arial,verdana,sans serif;
                    }
                    p {
                        line-height: 1.0;
                    }
                    ol {
                        counter-reset: item;
                    }
                    li {
                        display: block;
                        padding: 0 0 5px;
                    }
                    li:before {
                        content: counters(item, '.') ' ';
                        counter-increment: item
                    }
                    .referencia {
                        font-size: 15px;
                        font-weight: bold;
                      }
                </style>
            </head>
            <p>À<br>
            $objRelacaoEmailUnidades->nomeAgencia<br/>
            C/c<br>
            $objRelacaoEmailUnidades->nomeSr</p>
          
            <p>Prezado(a) Senhor(a) Gerente</p>

            <p class='referencia'>REF. PROTOCOLO #$objEsteiraContratacao->idDemanda - Empresa: $objEsteiraContratacao->nome<p>

            <ol>
                <li>Informamos que a solicitação referente à contratação de câmbio pronto do cliente <b>$objEsteiraContratacao->nome</b> foi cadastrada com sucesso e o número do seu protocolo é : <b>#$objEsteiraContratacao->idDemanda</b>.</li>  
                <li>Disponibilizamos o link para o acompanhamento da sua solicitação: <a href='" . $this->getUrlSiteEsteiraComexContratacao() . "'>link</a>.</li>  
                <li>As dúvidas operacionais podem ser consultadas na cartilha ESTEIRA CONTRATAÇÃO, através do <a href='"  "'>link</a>.</li>   
            </ol>

            <p>Atenciosamente,</p>
   
            <p>CEOPC - CN Operações do Corporativo</p>";
        
        $mail->AltBody = "
            À
            $objEsteiraContratacao->nomePa
            C/c
            $objEsteiraContratacao->nomeSr\n 

            Prezado(a) Gerente\n

            REF. DEMANDA #$objEsteiraContratacao->codigoDemanda - Empresa: $objEsteiraContratacao->nomeCliente - Contrato Caixa: $objEsteiraContratacao->contratoCaixa\n
            
            1. Informamos que a solicitação referente à contratação de câmbio pronto do cliente $objEsteiraContratacao->nome foi cadastrada com sucesso e o número do seu protocolo é : #$objEsteiraContratacao->idDemanda.\n
            2. Disponibilizamos o link para o acompanhamento da sua solicitação: <a href='" . $this->getUrlSiteEsteiraComexContratacao() . "'.\n  
            3. As dúvidas operacionais podem ser consultadas na cartilha ESTEIRA CONTRATAÇÃO, através do *LINK*.\n

            Atenciosamente,\n

            CEOPC - CN Operações do Corporativo";
        return $mail;
    }

    function demandaInconforme($objEsteiraContratacao, $objRelacaoEmailUnidades, $mail) 
    {        
        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = "#CONFIDENCIAL10 - Inconformidade - $objEsteiraContratacao->nome - Esteira COMEX - Protocolo #$objEsteiraContratacao->idDemanda";
        $mail->Body = "
            <head>
                <meta charset=\"UTF-8\">
                <style>
                    body {
                        font-family: arial,verdana,sans serif;
                    }
                    p {
                        line-height: 1.0;
                    }
                    ol {
                        counter-reset: item;
                    }
                    li {
                        display: block;
                        padding: 0 0 5px;
                    }
                    li:before {
                        content: counters(item, '.') ' ';
                        counter-increment: item
                    }
                    .referencia {
                        font-size: 15px;
                        font-weight: bold;
                      }
                </style>
            </head>
            <p>À<br>
            $objRelacaoEmailUnidades->nomeAgencia<br/>
            C/c<br>
            $objRelacaoEmailUnidades->nomeSr</p>
          
            <p>Prezado(a) Senhor(a) Gerente</p>

            <p class='referencia'>REF. PROTOCOLO <b>#$objEsteiraContratacao->idDemanda</b> - Empresa: <b>$objEsteiraContratacao->nome</b><p>

            <ol>
                <li>Recebemos nesta data os documentos para contratação do câmbio pronto referente ao protocolo <b>#$objEsteiraContratacao->idDemanda</b>.</li>  
                <li>Informamos que a documentação apresentada está <b>inconforme</b>.</li>  
                <li>Para que possamos continuar com a análise, solicitamos que a agência regularize a(s) pendência(s) assinalada(s) abaixo:</li>
                <ul>
                    <li>
                        $objEsteiraContratacao->analiseCeopc
                    </li>
                </ul>
                <li>A inconformidade deverá ser regularizada até às 15h (horário de Brasília).</li>
                <ol>
                    <li>Ressaltamos que a operação será cancelada após o horário informado.</li>
                <ol>
            </ol>

            <p>Atenciosamente,</p>
   
            <p>CEOPC - CN Operações do Corporativo</p>";
        
        $mail->AltBody = "
            À
            $objEsteiraContratacao->nomePa
            C/c
            $objEsteiraContratacao->nomeSr\n 

            Prezado(a) Gerente\n

            REF. DEMANDA #$objEsteiraContratacao->codigoDemanda - Empresa: $objEsteiraContratacao->nomeCliente - Contrato Caixa: $objEsteiraContratacao->contratoCaixa\n
            
            1. Recebemos nesta data os documentos para contratação do câmbio pronto referente ao protocolo #$objEsteiraContratacao->nome foi cadastrada com sucesso e o número do seu protocolo é : #$objEsteiraContratacao->idDemanda.\n
            2. Informamos que a documentação apresentada está inconforme.\n  
            3.	Para que possamos continuar com a análise, solicitamos que a agência regularize a(s) pendência(s) assinalada(s) abaixo:\n
            \n
            $objEsteiraContratacao->analiseCeopc\n
            4.	A inconformidade deverá ser regularizada até às *HORÁRIO*h (horário de Brasília).
            4.1	Ressaltamos que a operação será cancelada após o horário informado.

            Atenciosamente,\n

            CEOPC - CN Operações do Corporativo";
        return $mail;
    }
    
}