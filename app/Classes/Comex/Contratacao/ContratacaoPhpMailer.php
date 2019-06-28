<?php

namespace App\Classes\Comex\Contratacao;

use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class ContratacaoPhpMailer
{
    protected $urlSiteEsteiraComexContratacao = '';

    public function getUrlSiteEsteiraComexContratacao()
    {
        $this->urlSiteEsteiraComexContratacao;
    }

    function enviarMensageria($objEsteiraContratacao, $tipoEmail){
        $mail = new PHPMailer(true);
        $this->carregarDadosEmail($objEsteiraContratacao, $mail);
        $this->carregarConteudoEmail($objEsteiraContratacao, $mail, $tipoEmail);
        $this->enviarEmail($mail);
    }

    function carregarDadosEmail(Request $request, $objEsteiraContratacao, $mail){
        //Server settings
        $mail->isSMTP();  
        $mail->CharSet = 'UTF-8';                                          
        $mail->Host = 'sistemas.correiolivre.caixa';  
        $mail->SMTPAuth = false;                                  
        $mail->Port = 25;                                    

        //Recipients
        $mail->setFrom('ceopc04@caixa.gov.br', 'CEOPC04 - COMEX Contratação');
        $mail->addAddress($request->session()->get('matricula') . '@mail.caixa');
        // $mail->addAddress($objEsteiraContratacao->emailPa);
        // $mail->addAddress($objEsteiraContratacao->emailSr);
        // $mail->addAddress($objEsteiraContratacao->emailGigad);
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

    function carregarConteudoEmail($objEsteiraContratacao, $mail, $etapaDoProcesso){
        switch ($etapaDoProcesso) {
            case 'demandaCadastrada':
                return $this->demandaCadastrada($objEsteiraContratacao, $mail);
            break;
            case 'demandaInconforme':
                return $this->demandaInconforme($objEsteiraContratacao, $mail);
            break;
            case 'envioContratoParaAssinatura':
                return $this->envioContratoParaAssinatura($objEsteiraContratacao, $mail);
            break;
            case 'reiteracaoEnvioContratoParaAssinatura':
                return $this->reiteracaoEnvioContratoParaAssinatura($objEsteiraContratacao, $mail);
            break;
        }
    }

    function enviarEmail($mail) {
        try {
            $mail->send();
            // echo 'Mensagem enviada com sucesso';
        } catch (Exception $e) {
            // echo "Mensagem não pode ser enviada. Erro: {$mail->ErrorInfo}";
        }
    }

    function demandaCadastrada($objEsteiraContratacao, $mail) {
        if ($objEsteiraContratacao->agResponsavel == null || $objEsteiraContratacao->agResponsavel === "NULL") {
            
        } else {
            # code...
        }
        
        
        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = "#CONFIDENCIAL10 - Câmbio Pronto - $objEsteiraContratacao->nome - Esteira COMEX - Protocolo $objEsteiraContratacao->idDemanda";
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
            $objEsteiraContratacao->nomePa<br/>
            $objEsteiraContratacao->nomeSr<br/>
            $objEsteiraContratacao->nomeGigad</p>
          
            <p>Prezado(a) Gerente</p>

            <p class='referencia'>REF. DEMANDA #$objEsteiraContratacao->codigoDemanda - Empresa: $objEsteiraContratacao->nomeCliente - Contrato Caixa: $objEsteiraContratacao->contratoCaixa<p>

            <ol>
                <li>Comunicamos que recebemos o pedido de liquidação e/ou amortização e informamos que será processado no próximo dia 15 ou no 1º dia útil seguinte.</li>  
                <li>Orientamos realizar no SIBAN o comando de liquidação/amortização conforme descrito na norma do produto.</li>  
                <li>Considerando que a posição de dívida dos contratos com custo SELIC só é verificada na data do vencimento, o comando de amortização/liquidação é realizado pela agência no dia 15, impreterivelmente <u>até às 11hs</u>.</li>   
                <li>A conferência da liquidação poderá ser realizada pela agência no dia útil posterior a liquidação conforme procedimento descrito, na norma do produto, para verificação do saldo devedor.</li>  
                <li>Em caso de não liquidação por ausência de saldo em conta do cliente, a agência deverá efetuar nova solicitação de liquidação no mês subsequente.</li>   
                <li>Dúvidas sobre o procedimento de liquidação/amortização devem ser encaminhadas para a Caixa postal CEOPC10.</li>  
                <li>Dúvidas sobre a evolução ou cobrança dos contratos no SIBAN devem ser enviadas para o Gestor do produto (Caixa Postal GEPOD01).</li>  
            </ol>

            <p>Atenciosamente,</p>
   
            <p>CEOPC - CN Operações do Corporativo</p>";
        
        $mail->AltBody = "
            À
            $objEsteiraContratacao->nomePa
            $objEsteiraContratacao->nomeSr
            $objEsteiraContratacao->nomeGigad\n 

            Prezado(a) Gerente\n

            REF. DEMANDA #$objEsteiraContratacao->codigoDemanda - Empresa: $objEsteiraContratacao->nomeCliente - Contrato Caixa: $objEsteiraContratacao->contratoCaixa\n
            
            1. Comunicamos que recebemos o pedido de liquidação e/ou amortização e informamos que será processado no próximo dia 15 ou no 1º dia útil seguinte.\n
            2. Orientamos realizar no SIBAN o comando de liquidação/amortização conforme descrito na norma do produto.\n  
            3. Considerando que a posição de dívida dos contratos com custo SELIC só é verificada na data do vencimento, o comando de amortização/liquidação é realizado pela agência no dia 15, impreterivelmente até às 11hs.\n
            4. A conferência da liquidação poderá ser realizada pela agência no dia útil posterior a liquidação conforme procedimento descrito, na norma do produto, para verificação do saldo devedor.\n
            5. Em caso de não liquidação por ausência de saldo em conta do cliente, a agência deverá efetuar nova solicitação de liquidação no mês subsequente.\n
            6. Dúvidas sobre o procedimento de liquidação/amortização devem ser encaminhadas para a Caixa postal CEOPC10.\n
            7. Dúvidas sobre a evolução ou cobrança dos contratos no SIBAN devem ser enviadas para o Gestor do produto (Caixa Postal GEPOD01).\n

            Atenciosamente,\n

            CEOPC - CN Operações do Corporativo";
        return $mail;
    }
}