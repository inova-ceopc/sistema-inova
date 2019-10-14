<?php

namespace App\Classes\Comex\Contratacao;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\Models\Comex\Contratacao\ContratacaoDadosContrato;

class MensageriasFaseLiquidacaoOperacao
{

    public static function originalSemRetorno($objContratacaoDemanda, $arrayDadosEmailUnidade, $mail, $objDadosContrato)
    {
        
        // dd($objContratacaoDemanda, $arrayDadosEmailUnidade, $mail, $objDadosContrato);

        if ($objContratacaoDemanda->tipoOperacao == 'Pronto Importação Antecipado' || $objContratacaoDemanda->tipoOperacao == 'Pronto Importação') {
            $tipoOperacao = 'importação';
            $manualOperacao = 'CO309';
        } else {
            $tipoOperacao = 'exportação';
            $manualOperacao = 'CO308';
        }
        
        $mail->Subject = "*** TESTE PILOTO ***#CONFIDENCIAL 10 - Envio de contrato(s) de câmbio $tipoOperacao nº $objDadosContrato->numeroContrato | $objContratacaoDemanda->nomeCliente";
        $mail->Body .= "<h3 class='head_msg gray'>MENSAGEM AUTOMÁTICA. FAVOR NÃO RESPONDER.</h3>
                        <p>Prezado(a) Senhor(a) Gerente</p>
                        <ol>
                            <li>Segue abaixo link para download do contrato de câmbio tipo exportação nº $objDadosContrato->numeroContrato, celebrado em " . $objDadosContrato->dataEnvioContrato. ", do cliente $objContratacaoDemanda->nomeCliente.</li><br>
                            <br><a href='" . env('APP_URL') . "/esteiracomex/contratacao/consultar/$objContratacaoDemanda->idDemanda'>Clique aqui para consultar a demanda e baixar o contrato.</a><br>
                            <li>Segundo a circular BACEN Nº 3.691, de 16 de dezembro 2013 e MN $manualOperacao, os contratos até USD 10.000,00 ou equivalente em outras moedas, não necessitam da formalização do contrato assinado.</li><br>
                            <li>Em caso de dúvidas entrar em contato com a Célula do Middle Office pelo telefone (11)3053.0602 ou ceopa07@caixa.gov.br.</li><br>
                        </ol>
                        <br>
                        <p>Atenciosamente,</p>
                        <br>
                        <p>CEOPA - CN Operações do Atacado</p>";
        return $mail;
    }

    public static function originalComRetornoUmaHora($objContratacaoDemanda, $arrayDadosEmailUnidade, $mail, $objDadosContrato)
    {
        if ($objContratacaoDemanda->tipoOperacao == 'Pronto Importação Antecipado' || $objContratacaoDemanda->tipoOperacao == 'Pronto Importação') {
            $tipoOperacao = 'importação';
        } else {
            $tipoOperacao = 'exportação';
        }
        $mail->Subject = "*** TESTE PILOTO ***#CONFIDENCIAL 10 - Envio de contrato de câmbio $tipoOperacao nº $objDadosContrato->numeroContrato | $objContratacaoDemanda->nomeCliente";
        $mail->Body .= "<h3 class='head_msg gray'>MENSAGEM AUTOMÁTICA. FAVOR NÃO RESPONDER.</h3>
                        <p>Prezado(a) Senhor(a) Gerente</p>
                        <ol>
                            <li>Segue abaixo link para download do contrato de câmbio tipo $tipoOperacao nº $objDadosContrato->numeroContrato, celebrado em " . $objDadosContrato->dataEnvioContrato . ", do cliente $objContratacaoDemanda->nomeCliente.</li><br>
                            <br><a href='" . env('APP_URL') . "/esteiracomex/contratacao/consultar/$objContratacaoDemanda->idDemanda'>Clique aqui para consultar a demanda e baixar o contrato.</a><br>
                            <li>O contrato deverá ser impresso em papel, em 02 (duas) vias, que deverão ser assinadas e rubricadas conforme itens 2.1 e 2.2 abaixo. A primeira via deverá ser arquivada no cofre da Agência, Plataforma ou SGE Corporativo e a segunda via deverá ser entregue ao cliente.</li><br>
                                <ul>
                                    <li>O(s) responsável(is) legal(is) da empresa deverá(ão) rubricar todas as páginas e assinar a última página no campo \"Cliente\", conforme poderes previstos nos atos constitutivos e/ou na procuração. Deverá constar também o nome e o  CPF do(s) representante(s) legal(is) com abono da(s) assinatura(s) por  empregado CAIXA habilitado. É necessário assinar sob carimbo o campo “PODERES E ASSINATURA(S) CONFERIDOS”.</li><br>
                                    <li>O gerente responsável deverá assinar e carimbar o campo “Instituição autorizada a operar no mercado de câmbio”.</li><br>
                                </ul>
                            <li>Após assinaturas e abonos pelas partes, clicar no <a href='" . env('APP_URL') . "/esteiracomex/contratacao/carregar-contrato-assinado/$objContratacaoDemanda->idDemanda'>link</a> para comunicar a devida assinatura no contrato de câmbio, até as " . $objDadosContrato->dataLimiteRetorno . " (horário de Brasília) de " . $objDadosContrato->dataEnvioContrato . ".</li><br>
                            <li>Ressaltamos que a não confirmação da assinatura impossibilita finalizar a operação no Sistema de Câmbio do BACEN.</li><br>
                            <li>Em caso de dúvidas entrar em contato com a Célula do Middle Office pelo telefone (11)3053-0602 ou ceopa07@caixa.gov.br. </li><br>
                        </ol>
                        <br>
                        <p>Atenciosamente,</p>
                        <br>
                        <p>CEOPA - CN Operações do Atacado</p>";
        return $mail;
    }

    public static function originalComRetornoProximoDiaUtil($objContratacaoDemanda, $arrayDadosEmailUnidade, $mail, $objDadosContrato)
    {
        if ($objContratacaoDemanda->tipoOperacao == 'Pronto Importação Antecipado' || $objContratacaoDemanda->tipoOperacao == 'Pronto Importação') {
            $tipoOperacao = 'importação';
        } else {
            $tipoOperacao = 'exportação';
        }
        $mail->Subject = "*** TESTE PILOTO ***#CONFIDENCIAL 10 - Envio de contrato de câmbio $tipoOperacao nº $objDadosContrato->numeroContrato | $objContratacaoDemanda->nomeCliente";
        $mail->Body .= "<h3 class='head_msg gray'>MENSAGEM AUTOMÁTICA. FAVOR NÃO RESPONDER.</h3>
                        <p>Prezado(a) Senhor(a) Gerente</p>
                        <ol>
                            <li>Segue abaixo link para download do contrato de câmbio tipo $tipoOperacao nº $objDadosContrato->numeroContrato, celebrado em " . $objDadosContrato->dataEnvioContrato . ", do cliente $objContratacaoDemanda->nomeCliente.</li><br>
                            <br><a href='" . env('APP_URL') . "/esteiracomex/contratacao/consultar/$objContratacaoDemanda->idDemanda'>Clique aqui para consultar a demanda e baixar o contrato.</a><br>
                            <li>O contrato deverá ser impresso em papel, em 02 (duas) vias, que deverão ser assinadas e rubricadas conforme itens 2.1 e 2.2 abaixo. A primeira via deverá ser arquivada no cofre da Agência, Plataforma ou SGE Corporativo e a segunda via deverá ser entregue ao cliente.</li><br>
                                <ul>
                                    <li>O(s) responsável(is) legal(is) da empresa deverá(ão) rubricar todas as páginas e assinar a última página no campo \"Cliente\", conforme poderes previstos nos atos constitutivos e/ou na procuração. Deverá constar também o nome e o  CPF do(s) representante(s) legal(is) com abono da(s) assinatura(s) por  empregado CAIXA habilitado. É necessário assinar sob carimbo o campo “PODERES E ASSINATURA(S) CONFERIDOS”.</li><br>
                                    <li>O gerente responsável deverá assinar e carimbar o campo “Instituição autorizada a operar no mercado de câmbio”.</li><br>
                                </ul>
                            <li>Após assinaturas e abonos pelas partes, clicar no <a href='" . env('APP_URL') . "/esteiracomex/contratacao/carregar-contrato-assinado/$objContratacaoDemanda->idDemanda'>link</a> para comunicar a devida assinatura no contrato de câmbio, até as " . $objDadosContrato->dataLimiteRetorno . " (horário de Brasília) de " . $objDadosContrato->dataEnvioContrato . ".</li><br>
                            <li>Ressaltamos que a não confirmação da assinatura impossibilita finalizar a operação no Sistema de Câmbio do BACEN.</li><br>
                            <li>Em caso de dúvidas entrar em contato com a Célula do Middle Office pelo telefone (11)3053.0602 ou ceopa07@caixa.gov.br. </li><br>
                        </ol>
                        <br>
                        <p>Atenciosamente,</p>
                        <br>
                        <p>CEOPA - CN Operações do Atacado</p>";
        return $mail;
    }

    public static function alteracaoInferior($objContratacaoDemanda, $arrayDadosEmailUnidade, $mail, $objDadosContrato)
    {
        if ($objContratacaoDemanda->tipoOperacao == 'Pronto Importação Antecipado' || $objContratacaoDemanda->tipoOperacao == 'Pronto Importação') {
            $tipoOperacao = 'importação';
            $manualOperacao = 'CO309';
        } else {
            $tipoOperacao = 'exportação';
            $manualOperacao = 'CO308';
        }
        
        $mail->Subject = "*** TESTE PILOTO ***#CONFIDENCIAL 10 - Envio de Contrato de Câmbio Pronto - ALTERAÇÃO nº $objDadosContrato->numeroContrato | $objContratacaoDemanda->nomeCliente";
        $mail->Body .= "<h3 class='head_msg gray'>MENSAGEM AUTOMÁTICA. FAVOR NÃO RESPONDER.</h3>
                        <p>Prezado(a) Senhor(a) Gerente</p> 
                        <ol>
                            <li>Segue abaixo link para download do contrato de câmbio tipo $tipoOperacao nº $objDadosContrato->numeroContrato, celebrado em " . $objDadosContrato->dataEnvioContrato . ", do cliente $objContratacaoDemanda->nomeCliente.</li><br>
                            <br><a href='" . env('APP_URL') . "/esteiracomex/contratacao/consultar/$objContratacaoDemanda->idDemanda'>Clique aqui para consultar a demanda e baixar o contrato.</a><br>
                            <li>Segundo a circular BACEN Nº 3.691, de 16 de dezembro 2013 e MN $manualOperacao, os contratos até USD 10.000,00 ou equivalente em outras moedas, não necessitam mais da formalização do contrato assinado, enviamos caso o cliente necessite de comprovante da operação.</li><br>
                            <li>Em caso de dúvidas entrar em contato com a Célula do Middle Office pelo telefone (11)3053.0602 ou ceopa07@caixa.gov.br. </li><br>
                        </ol>
                        <br>
                        <p>Atenciosamente,</p>
                        <br>
                        <p>CEOPA - CN Operações do Atacado</p>";
        return $mail;
    }

    public static function alteracaoSuperiorSemRetorno($objContratacaoDemanda, $arrayDadosEmailUnidade, $mail, $objDadosContrato)
    {
        if ($objContratacaoDemanda->tipoOperacao == 'Pronto Importação Antecipado' || $objContratacaoDemanda->tipoOperacao == 'Pronto Importação') {
            $tipoOperacao = 'importação';
        } else {
            $tipoOperacao = 'exportação';
        }
        $mail->Subject = "*** TESTE PILOTO ***#CONFIDENCIAL 10 - Envio de Contrato de Câmbio Pronto - ALTERAÇÃO nº $objDadosContrato->numeroContrato | $objContratacaoDemanda->nomeCliente";
        $mail->Body .= "<h3 class='head_msg gray'>MENSAGEM AUTOMÁTICA. FAVOR NÃO RESPONDER.</h3>
                        <p>Prezado(a) Senhor(a) Gerente</p> 
                        <ol>
                            <li>Segue abaixo link para download do contrato de câmbio tipo $tipoOperacao nº $objDadosContrato->numeroContrato, celebrado em " . $objDadosContrato->dataEnvioContrato . ", do cliente $objContratacaoDemanda->nomeCliente.</li><br>
                            <br><a href='" . env('APP_URL') . "/esteiracomex/contratacao/consultar/$objContratacaoDemanda->idDemanda'>Clique aqui para consultar a demanda e baixar o contrato.</a><br>
                            <li>O contrato deverá ser impresso em papel, em 02 (duas) vias, que deverão ser assinadas e rubricadas conforme itens 2.1 e 2.2 abaixo. A primeira via deverá ser arquivada no cofre da Agência, Plataforma ou SGE Corporativo e a segunda via deverá ser entregue ao cliente.</li><br>
                            <ul>
                                <li>O(s) responsável(is) legal(is) da empresa deverá(ão) rubricar todas as páginas e assinar a última página no campo \"Cliente\", conforme poderes previstos nos atos constitutivos e/ou na procuração. Deverá constar também o nome e o  CPF do(s) representante(s) legal(is) com abono da(s) assinatura(s) por  empregado CAIXA habilitado. É necessário assinar sob carimbo o campo “PODERES E ASSINATURA(S) CONFERIDOS”.</li><br>
                                <li>Solicitamos ainda que o gerente responsável assine e carimbe no campo “Instituição autorizada a operar no mercado de câmbio”.</li><br>
                            <ul>
                            <li>Em caso de dúvidas entrar em contato com a Célula do Middle Office pelo telefone (11)3053.0602 ou ceopa07@caixa.gov.br. </li><br>
                        </ol>
                        <br>
                        <p>Atenciosamente,</p>
                        <br>
                        <p>CEOPA - CN Operações do Atacado</p>";
        return $mail;
    }

    public static function alteracaoComRetornoEmUmaHora($objContratacaoDemanda, $arrayDadosEmailUnidade, $mail, $objDadosContrato)
    {
        if ($objContratacaoDemanda->tipoOperacao == 'Pronto Importação Antecipado' || $objContratacaoDemanda->tipoOperacao == 'Pronto Importação') {
            $tipoOperacao = 'importação';
        } else {
            $tipoOperacao = 'exportação';
        }
        $mail->Subject = "*** TESTE PILOTO ***#CONFIDENCIAL 10 - Envio de Contrato de Câmbio Pronto - ALTERAÇÃO nº $objDadosContrato->numeroContrato | $objContratacaoDemanda->nomeCliente";
        $mail->Body .= "<h3 class='head_msg gray'>MENSAGEM AUTOMÁTICA. FAVOR NÃO RESPONDER.</h3>
                        <p>Prezado(a) Senhor(a) Gerente</p> 
                        <ol>
                            <li>Segue abaixo link para download do contrato de câmbio tipo $tipoOperacao nº $objDadosContrato->numeroContrato, celebrado em " . $objDadosContrato->dataEnvioContrato . ", do cliente $objContratacaoDemanda->nomeCliente.</li><br>
                            <br><a href='" . env('APP_URL') . "/esteiracomex/contratacao/consultar/$objContratacaoDemanda->idDemanda'>Clique aqui para consultar a demanda e baixar o contrato.</a><br>
                            <li>O contrato deverá ser impresso em papel, em 02 (duas) vias, que deverão ser assinadas e rubricadas conforme itens 2.1 e 2.2 abaixo. A primeira via deverá ser arquivada no cofre da Agência, Plataforma ou SGE Corporativo e a segunda via deverá ser entregue ao cliente.</li><br>
                            <ul>
                                <li>O(s) responsável(is) legal(is) da empresa deverá(ão) rubricar todas as páginas e assinar a última página no campo \"Cliente\", conforme poderes previstos nos atos constitutivos e/ou na procuração. Deverá constar também o nome e o  CPF do(s) representante(s) legal(is) com abono da(s) assinatura(s) por  empregado CAIXA habilitado. É necessário assinar sob carimbo o campo “PODERES E ASSINATURA(S) CONFERIDOS”.</li><br>
                                <li>O gerente responsável deverá assinar e carimbar o campo “Instituição autorizada a operar no mercado de câmbio”.</li><br>
                            </ul>
                            <li>Após assinaturas e abonos pelas partes, clicar no <a href='" . env('APP_URL') . "/esteiracomex/contratacao/carregar-contrato-assinado/$objContratacaoDemanda->idDemanda'>link</a> para comunicar a devida assinatura no contrato de câmbio, até as " . $objDadosContrato->dataLimiteRetorno . " (horário de Brasília) de " . $objDadosContrato->dataEnvioContrato . ".</li><br>
                            <li>Ressaltamos que a não confirmação da assinatura impossibilita finalizar a operação no Sistema de Câmbio do BACEN.</li><br>
                            <li>Em caso de dúvidas entrar em contato com a Célula do Middle Office pelo telefone (11)3053.0602 ou ceopa07@caixa.gov.br.</li><br>
                        </ol>
                        <br>
                        <p>Atenciosamente,</p>
                        <br>
                        <p>CEOPA - CN Operações do Atacado</p>";
        return $mail;
    }

    public static function alteracaoComRetornoProximoDiaUtil($objContratacaoDemanda, $arrayDadosEmailUnidade, $mail, $objDadosContrato)
    {
        if ($objContratacaoDemanda->tipoOperacao == 'Pronto Importação Antecipado' || $objContratacaoDemanda->tipoOperacao == 'Pronto Importação') {
            $tipoOperacao = 'importação';
        } else {
            $tipoOperacao = 'exportação';
        }
        $mail->Subject = "*** TESTE PILOTO ***#CONFIDENCIAL 10 - Envio de Contrato de Câmbio Pronto - ALTERAÇÃO nº $objDadosContrato->numeroContrato | $objContratacaoDemanda->nomeCliente";
        $mail->Body .= "<h3 class='head_msg gray'>MENSAGEM AUTOMÁTICA. FAVOR NÃO RESPONDER.</h3>
                        <p>Prezado(a) Senhor(a) Gerente</p> 
                        <ol>
                            <li>Segue abaixo link para download do contrato de câmbio tipo $tipoOperacao nº $objDadosContrato->numeroContrato, celebrado em " . $objDadosContrato->dataEnvioContrato . ", do cliente $objContratacaoDemanda->nomeCliente.</li><br>
                            <br><a href='" . env('APP_URL') . "/esteiracomex/contratacao/consultar/$objContratacaoDemanda->idDemanda'>Clique aqui para consultar a demanda e baixar o contrato.</a><br>
                            <li>O contrato deverá ser impresso em papel, em 02 (duas) vias, que deverão ser assinadas e rubricadas conforme itens 2.1 e 2.2 abaixo. A primeira via deverá ser arquivada no cofre da Agência, Plataforma ou SGE Corporativo e a segunda via deverá ser entregue ao cliente.</li><br>
                            <ul>
                                <li>O(s) responsável(is) legal(is) da empresa deverá(ão) rubricar todas as páginas e assinar a última página no campo \"Cliente\", conforme poderes previstos nos atos constitutivos e/ou na procuração. Deverá constar também o nome e o  CPF do(s) representante(s) legal(is) com abono da(s) assinatura(s) por  empregado CAIXA habilitado. É necessário assinar sob carimbo o campo “PODERES E ASSINATURA(S) CONFERIDOS”.</li><br>
                                <li>O gerente responsável deverá assinar e carimbar o campo “Instituição autorizada a operar no mercado de câmbio”.</li><br>
                            </ul>
                            <li>Após assinaturas e abonos pelas partes, clicar no <a href='" . env('APP_URL') . "/esteiracomex/contratacao/carregar-contrato-assinado/$objContratacaoDemanda->idDemanda'>link</a> para comunicar a devida assinatura no contrato de câmbio, até as " . $objDadosContrato->dataLimiteRetorno . " (horário de Brasília) de " . $objDadosContrato->dataEnvioContrato . ".</li><br>
                            <li>Ressaltamos que a não confirmação da assinatura impossibilita finalizar a operação no Sistema de Câmbio do BACEN.</li><br>
                            <li>Em caso de dúvidas entrar em contato com a Célula do Middle Office pelo telefone (11)3053.0602 ou ceopa07@caixa.gov.br.</li><br>
                        </ol>
                        <br>
                        <p>Atenciosamente,</p>
                        <br>
                        <p>CEOPA - CN Operações do Atacado</p>";
        return $mail;
    }

    public static function cancelamentoInterior($objContratacaoDemanda, $arrayDadosEmailUnidade, $mail, $objDadosContrato)
    {
        if ($objContratacaoDemanda->tipoOperacao == 'Pronto Importação Antecipado' || $objContratacaoDemanda->tipoOperacao == 'Pronto Importação') {
            $tipoOperacao = 'importação';
            $manualOperacao = 'CO309';
        } else {
            $tipoOperacao = 'exportação';
            $manualOperacao = 'CO308';
        }
        $mail->Subject = "*** TESTE PILOTO ***#CONFIDENCIAL 10 - Envio de Contrato de Câmbio Pronto - CANCELAMENTO nº $objDadosContrato->numeroContrato | $objContratacaoDemanda->nomeCliente";
        $mail->Body .= "<h3 class='head_msg gray'>MENSAGEM AUTOMÁTICA. FAVOR NÃO RESPONDER.</h3>
                        <p>Prezado(a) Senhor(a) Gerente</p>
                        <ol>
                            <li>Segue abaixo link para download do contrato de câmbio tipo $tipoOperacao nº $objDadosContrato->numeroContrato, celebrado em " . $objDadosContrato->dataEnvioContrato . ", do cliente $objContratacaoDemanda->nomeCliente.</li><br>
                            <br><a href='" . env('APP_URL') . "/esteiracomex/contratacao/consultar/$objContratacaoDemanda->idDemanda'>Clique aqui para consultar a demanda e baixar o contrato.</a><br>
                            <li>Segundo a circular BACEN Nº 3.691, de 16 de dezembro 2013 e MN $manualOperacao, os contratos até USD 10.000,00 ou equivalente em outras moedas, não necessitam mais da formalização do contrato assinado, enviamos caso o cliente necessite de comprovante da operação.</li><br>
                            <li>Em caso de dúvidas entrar em contato com a Célula do Middle Office pelo telefone (11)3053.0602 ou ceopa07@caixa.gov.br.</li><br>
                        </ol>
                        <br>
                        <p>Atenciosamente,</p>
                        <br>
                        <p>CEOPA - CN Operações do Atacado</p>";
        return $mail;
    }

    public static function cancelamentoSuperior($objContratacaoDemanda, $arrayDadosEmailUnidade, $mail, $objDadosContrato)
    {
        if ($objContratacaoDemanda->tipoOperacao == 'Pronto Importação Antecipado' || $objContratacaoDemanda->tipoOperacao == 'Pronto Importação') {
            $tipoOperacao = 'importação';
        } else {
            $tipoOperacao = 'exportação';
        }
        $mail->Subject = "*** TESTE PILOTO ***#CONFIDENCIAL 10 - Envio de Contrato de Câmbio Pronto - CANCELAMENTO nº $objDadosContrato->numeroContrato | $objContratacaoDemanda->nomeCliente";
        $mail->Body .= "<h3 class='head_msg gray'>MENSAGEM AUTOMÁTICA. FAVOR NÃO RESPONDER.</h3>
                        <p>Prezado(a) Senhor(a) Gerente</p>
                        <ol>
                            <li>Segue abaixo link para download do contrato de câmbio tipo $tipoOperacao nº $objDadosContrato->numeroContrato, celebrado em " . $objDadosContrato->dataEnvioContrato . ", do cliente $objContratacaoDemanda->nomeCliente.</li><br>
                            <br><a href='" . env('APP_URL') . "/esteiracomex/contratacao/consultar/$objContratacaoDemanda->idDemanda'>Clique aqui para consultar a demanda e baixar o contrato.</a><br>
                            <li>O contrato deverá ser impresso em papel, em 02 (duas) vias, que deverão ser assinadas e rubricadas conforme itens 2.1 e 2.2 abaixo. A primeira via deverá ser arquivada no cofre da Agência, Plataforma ou SGE Corporativo e a segunda via deverá ser entregue ao cliente.</li><br>
                            <ul>
                                <li>O(s) responsável(is) legal(is) da empresa deverá(ão) rubricar todas as páginas e assinar a última página no campo \"Cliente\", conforme poderes previstos nos atos constitutivos e/ou na procuração. Deverá constar também o nome e o  CPF do(s) representante(s) legal(is) com abono da(s) assinatura(s) por  empregado CAIXA habilitado. É necessário assinar sob carimbo o campo “PODERES E ASSINATURA(S) CONFERIDOS”.</li><br>
                                <li>Solicitamos ainda que o gerente responsável assine e carimbe no campo “Instituição autorizada a operar no mercado de câmbio”.</li><br>
                            </ul>
                            <li>Em caso de dúvidas entrar em contato com a Célula do Middle Office pelo telefone (11)3053.0602 ou ceopa07@caixa.gov.br.</li><br>
                        </ol>
                        <br>
                        <p>Atenciosamente,</p>
                        <br>
                        <p>CEOPA - CN Operações do Atacado</p>";
        return $mail;
    }

    public static function reiteracao($objContratacaoDemanda, $arrayDadosEmailUnidade, $mail, $objDadosContrato)
    {
        if ($objContratacaoDemanda->tipoOperacao == 'Pronto Importação Antecipado' || $objContratacaoDemanda->tipoOperacao == 'Pronto Importação') {
            $tipoOperacao = 'importação';
            $acaoNaConta = 'débito';
        } else {
            $tipoOperacao = 'exportação';
            $acaoNaConta = 'crédito';
        }
        $mail->Subject = "*** TESTE PILOTO ***#CONFIDENCIAL 10 - REITERAÇÃO - Envio de contrato(s) de câmbio $tipoOperacao nº $objDadosContrato->numeroContrato | $objContratacaoDemanda->nomeCliente";
        $mail->Body .= "<h3 class='head_msg gray'>MENSAGEM AUTOMÁTICA. FAVOR NÃO RESPONDER.</h3>
                        <p>Prezado(a) Senhor(a) Gerente</p>
                        <ol>
                            <li>Reiteramos a necessidade da confirmação da assinatura no contrato de câmbio $tipoOperacaoo nº $objDadosContrato->numeroContrato, celebrado em XX/XX/2019, do cliente $objContratacaoDemanda->nomeCliente até as  " . $objDadosContrato->dataLimiteRetorno . " (horário de Brasília) de " . $objDadosContrato->dataEnvioContrato . ".</li><br>
                            <li>Segue abaixo link para confirmação da devida assinatura.</li><br>
                            <br><a href='" . env('APP_URL') . "/esteiracomex/acompanhar/minhas-demandas'>link</a><br>                            
                            <li>Ressaltamos que a não confirmação da assinatura impossibilita finalizar a operação no Sistema de Câmbio do BACEN e consequente cancelamento da operação.</li><br>
                            <li>Em caso de dúvidas entrar em contato com a Célula do Middle Office pelo telefone (11)3053.0602 ou ceopa07@caixa.gov.br.</li><br>
                        </ol>
                        <br>
                        <p>Atenciosamente,</p>
                        <br>
                        <p>CEOPA - CN Operações do Atacado</p>";
        return $mail;
    }
}