<?php

namespace App\Classes\Comex\Contratacao;

use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\RelacaoAgSrComEmail;

class ContratacaoPhpMailer
{
    protected $urlSiteEsteiraComexContratacao;

    public function getUrlSiteEsteiraComexContratacao()
    {
        return $this->urlSiteEsteiraComexContratacao;
    }
    public function setUrlSiteEsteiraComexContratacao()
    {
        $this->urlSiteEsteiraComexContratacao = env('APP_URL') . "/esteiracomex/distribuir/demandas";
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    function enviarMensageria(Request $request, $objEsteiraContratacao, $tipoEmail){
        $mail = new PHPMailer(true);
        $this->setUrlSiteEsteiraComexContratacao();
        $objRelacaoEmailUnidades = $this->validaUnidadeDemandanteEmail($objEsteiraContratacao);
        $this->carregarDadosEmail($request, $objEsteiraContratacao, $objRelacaoEmailUnidades, $mail);
        $this->carregarConteudoEmail($objEsteiraContratacao, $objRelacaoEmailUnidades, $mail, $tipoEmail);
        $this->enviarEmail($mail);
    }

    function validaUnidadeDemandanteEmail($objEsteiraContratacao) 
    {
        if ($objEsteiraContratacao->agResponsavel == null || $objEsteiraContratacao->agResponsavel === "NULL") {
            $objRelacaoEmailUnidades = RelacaoAgSrComEmail::where('codigoSr', $objEsteiraContratacao->srResponsavel)->first();
            $arrayDadosEmailUnidade = [
                'nomeSr' => $objRelacaoEmailUnidades->nomeSr,
                'emailSr' => $objRelacaoEmailUnidades->emailsr
            ];
        } else {
            $objRelacaoEmailUnidades = RelacaoAgSrComEmail::where('codigoAgencia', $objEsteiraContratacao->agResponsavel)->first();
            $arrayDadosEmailUnidade = [
                'nomeAgencia' => $objRelacaoEmailUnidades->nomeAgencia,
                'emailAgencia' => $objRelacaoEmailUnidades->emailAgencia,
                'nomeSr' => $objRelacaoEmailUnidades->nomeSr,
                'emailSr' => $objRelacaoEmailUnidades->emailsr
            ];
        }
        return json_decode(json_encode($arrayDadosEmailUnidade), FALSE);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    function carregarDadosEmail(Request $request, $objEsteiraContratacao, $arrayDadosEmailUnidade, $mail)
    {
        //Server settings
        $mail->isSMTP();  
        $mail->CharSet = 'UTF-8';                                          
        $mail->Host = 'sistemas.correiolivre.caixa';  
        $mail->SMTPAuth = false;                                  
        $mail->Port = 25;
        // $mail->SMTPDebug = 2;                                         

        //Recipients
        $mail->setFrom('ceopa08@mail.caixa', 'CEOPA08 - Rotinas Automáticas');
        
        if (session()->get('codigoLotacaoAdministrativa') == '5459' || session()->get('codigoLotacaoFisica') == '5459') {
            $mail->addAddress($objEsteiraContratacao->responsavelAtual . '@mail.caixa');
        } else {
            $mail->addAddress(session()->get('matricula') . '@mail.caixa');
        }
        // $mail->addAddress($objEsteiraContratacao->responsavelAtual . '@mail.caixa');
        // $mail->addCC($objEsteiraContratacao->emailsr);

        $mail->addBCC('c111710@mail.caixa');    
        // $mail->addBCC('c095060@mail.caixa')
        $mail->addBCC('c142765@mail.caixa');
        $mail->addBCC('c079436@mail.caixa');
        // $mail->addBCC('c084941@mail.caixa');
        // $mail->addAddress('c079436@mail.caixa');    
        // $mail->addReplyTo('ceopa04@mail.caixa');
        return $mail; 
    }

    function carregarConteudoEmail($objEsteiraContratacao, $arrayDadosEmailUnidade, $mail, $etapaDoProcesso)
    {
        switch ($etapaDoProcesso) {
            case 'demandaCadastrada':
                return $this->demandaCadastrada($objEsteiraContratacao, $arrayDadosEmailUnidade, $mail);
            break;
            case 'demandaInconforme':
                return $this->demandaInconforme($objEsteiraContratacao, $arrayDadosEmailUnidade, $mail);
            break;
            case 'envioContratoParaAssinatura':
                return $this->envioContratoParaAssinatura($objEsteiraContratacao, $arrayDadosEmailUnidade, $mail);
            break;
            case 'reiteracaoEnvioContratoParaAssinatura':
                return $this->reiteracaoEnvioContratoParaAssinatura($objEsteiraContratacao, $arrayDadosEmailUnidade, $mail);
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

    function demandaCadastrada($objEsteiraContratacao, $arrayDadosEmailUnidade, $mail) 
    {        
        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = "*** TESTE PILOTO ***#CONFIDENCIAL10 - Câmbio Pronto - $objEsteiraContratacao->nomeCliente - Esteira COMEX - Protocolo #$objEsteiraContratacao->idDemanda";
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
                    .head_msg{
                        font-weight: bold;
                        text-align: center;
                    }
                    .gray{
                        color: #808080;
                    }
                </style>
            </head>
            <p>À<br>";
            if (isset($arrayDadosEmailUnidade->nomeAgencia)) {
                $mail->Body .= "
                    AG $arrayDadosEmailUnidade->nomeAgencia<br/>
                    C/c<br>
                    SR $arrayDadosEmailUnidade->nomeSr</p>";
            } else {
                $mail->Body .= "
                SR $arrayDadosEmailUnidade->nomeSr</p>";
            }
            $mail->Body .= "
          
            <h3 class='head_msg gray'>MENSAGEM AUTOMÁTICA. FAVOR NÃO RESPONDER.</h3>

            <p>Prezado(a) Senhor(a) Gerente</p>

            <p class='referencia'>REF. PROTOCOLO #$objEsteiraContratacao->idDemanda - Empresa: $objEsteiraContratacao->nomeCliente<p>

            <ol>
                <li>Informamos que a solicitação referente à contratação de câmbio pronto do cliente <b>$objEsteiraContratacao->nomeCliente</b> foi cadastrada com sucesso e o número do seu protocolo é : <b>#$objEsteiraContratacao->idDemanda</b>.</li>  
                <li>Disponibilizamos o link para o acompanhamento da sua solicitação: <a href='" . $this->getUrlSiteEsteiraComexContratacao() . "'>link</a>.</li>  
                <li>As dúvidas operacionais podem ser consultadas na cartilha ESTEIRA CONTRATAÇÃO, através do <a href=''>link</a>.</li>   
            </ol>

            <p>Atenciosamente,</p>
   
            <p>CEOPA - CN Operações do Atacado</p>";
        
        $mail->AltBody = "
            À
            $arrayDadosEmailUnidade->nomeAgencia
            C/c
            $arrayDadosEmailUnidade->nomeSr\n 

            Prezado(a) Gerente\n

            REF. DEMANDA #$objEsteiraContratacao->codigoDemanda - Empresa: $objEsteiraContratacao->nomeCliente - Contrato Caixa: $objEsteiraContratacao->contratoCaixa\n
            
            1. Informamos que a solicitação referente à contratação de câmbio pronto do cliente $objEsteiraContratacao->nomeCliente foi cadastrada com sucesso e o número do seu protocolo é : #$objEsteiraContratacao->idDemanda.\n
            2. Disponibilizamos o link para o acompanhamento da sua solicitação: <a href='" . $this->getUrlSiteEsteiraComexContratacao() . "'.\n  
            3. As dúvidas operacionais podem ser consultadas na cartilha ESTEIRA CONTRATAÇÃO, através do *LINK*.\n

            Atenciosamente,\n

            CEOPA - CN Operações do Atacado";
        return $mail;
    }

    function demandaInconforme($objEsteiraContratacao, $arrayDadosEmailUnidade, $mail) 
    {        
        // Content
        $mail->addBCC('ceopa07@mail.caixa');
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = "*** TESTE PILOTO ***#CONFIDENCIAL10 - Inconformidade - $objEsteiraContratacao->nomeCliente - Esteira COMEX - Protocolo #$objEsteiraContratacao->idDemanda";
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
                      .head_msg{
                        font-weight: bold;
                        text-align: center;
                    }
                    .gray{
                        color: #808080;
                    }
                </style>
            </head>
            <p>À<br>";
            if (isset($arrayDadosEmailUnidade->nomeAgencia)) {
                $mail->Body .= "
                    AG $arrayDadosEmailUnidade->nomeAgencia<br/>
                    C/c<br>
                    SR $arrayDadosEmailUnidade->nomeSr</p>";
            } else {
                $mail->Body .= "
                SR $arrayDadosEmailUnidade->nomeSr</p>";
            }
            $mail->Body .= "
          
            <h3 class='head_msg gray'>MENSAGEM AUTOMÁTICA. FAVOR NÃO RESPONDER.</h3>
          
            <p>Prezado(a) Senhor(a) Gerente</p>

            <p class='referencia'>REF. PROTOCOLO <b>#$objEsteiraContratacao->idDemanda</b> - Empresa: <b>$objEsteiraContratacao->nomeCliente</b><p>

            <ol>
                <li>Recebemos nesta data os documentos para contratação do câmbio pronto referente ao protocolo <b>#$objEsteiraContratacao->idDemanda</b>.</li>  
                <li>Informamos que a documentação apresentada está <b>inconforme</b>.</li>  
                <li>Para que possamos continuar com a análise, solicitamos que a agência regularize a(s) pendência(s) assinalada(s) abaixo:</li>
                <ul>
                    <li>
                        <b>$objEsteiraContratacao->analiseCeopc</b>
                    </li>
                </ul>
                <li>A inconformidade deverá ser regularizada até às 15h (horário de Brasília).</li>
                <li>Ressaltamos que a operação será cancelada após o horário informado.</li>
            </ol>

            <p>Atenciosamente,</p>
   
            <p>CEOPA - CN Operações do Atacado</p>";
        
        $mail->AltBody = "
            À
            $arrayDadosEmailUnidade->nomeAgencia
            C/c
            $arrayDadosEmailUnidade->nomeSr\n 

            Prezado(a) Gerente\n

            REF. DEMANDA #$objEsteiraContratacao->codigoDemanda - Empresa: $objEsteiraContratacao->nomeCliente - Contrato Caixa: $objEsteiraContratacao->contratoCaixa\n
            
            1. Recebemos nesta data os documentos para contratação do câmbio pronto referente ao protocolo #$objEsteiraContratacao->idDemanda.\n
            2. Informamos que a documentação apresentada está inconforme.\n  
            3.	Para que possamos continuar com a análise, solicitamos que a agência regularize a(s) pendência(s) assinalada(s) abaixo:\n
            \n
            $objEsteiraContratacao->analiseCeopc\n
            4.	A inconformidade deverá ser regularizada até às *HORÁRIO*h (horário de Brasília).
            4.1	Ressaltamos que a operação será cancelada após o horário informado.

            Atenciosamente,\n

            CEOPA - CN Operações do Atacado";
        return $mail;
    }
}