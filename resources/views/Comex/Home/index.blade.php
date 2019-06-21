
@extends('adminlte::page')

@section('title', 'Esteira Comex')

@section('content_header')

<div class="panel-body padding015">
    <h4 class="animated bounceInLeft pull-left">
        Introdução | 
        <small>Workflow para rotinas de comércio exterior </small>
    </h4>
    
    <ol class="breadcrumb pull-right">
            <li><a href="/esteiracomex"><i class="fa fa-map-signs"></i>     Introdução</a></li>
    </ol>
</div>

@stop


@section('content')

<div class="container-fluid">

<div class="panel panel-default">

<div class="panel-body">


    <div class="page-bar">
        <h3>Mapa do site - Esteira Comex
            <br>
            <br>
            <small class="text-left">Prezado colega, seja bem vindo à Esteira Comex! Acesse o FAQ e tire suas dúvidas no link:
            <a href="https://wiki.caixa/wiki/index.php/FAQ_liquida%C3%A7%C3%A3o_Comex" class="text-left">wiki.caixa</a>.
            <br>
            Navegue pelo site através do menu lateral ou dos links abaixo:</small>
            <!-- No Menu lateral você pode encontrar os itens abaixo em destaque: -->
        </h3>
    </div>

<br>

<div class="row">

    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4> 
                    <i class="fa fa-sign-in"> </i> Solicitar Atendimento
                    <br>
                    <small>Cadastrar novas demandas dos serviços abaixo:</small>
                </h4>
            </div>
            <div class="panel-body">
                <h4> 
                    <a href="/solicitacoes/cadastraemailop"><i  class="fa fa-circle-o"></i>     Atualizar e-mail cliente</a>
                    <br>
                    <small>Aviso automático de chegada de OP diretamente para o cliente. </small>
                </h4> 
                <hr class="pontilhado">
                <h4> 
                    <a href="#"><i  class="fa fa-circle-o"></i>     Liquidação ACC/ACE</a> 
                    <br>
                    <small>Solicitar liquidação de contrato. </small>
                </h4> 
                <hr class="pontilhado">
                <h4> 
                    <a href="/esteiracomex/contratacao"><i  class="fa fa-circle-o"></i>     Contratação - Pronto</a> 
                    <br>
                    <small>Cadastrar nova contratação de câmbio pronto. </small>
                </h4> 
                <hr class="pontilhado">
                <h4> 
                    <a href="#"><i  class="fa fa-circle-o"></i>     Conformidade Antecipados</a> 
                    <br>
                    <small>Envio de comprovação de embarque de contrato antecipado. </small>
                </h4>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4> 
                    <i class="fa fa-files-o"></i> Acompanhamentos
                    <br>
                    <small>Cadastrar novas demandas dos serviços abaixo:</small>
                </h4>
            </div>
            <div class="panel-body">
                <h4> 
                    <a href="/solicitacoes/cadastraemailop"><i  class="fa fa-ship"></i>     ACC/ACE</a> 
                    <br>
                    <small>Acompanhar as liquidações de cambiais. </small>
                </h4> 
                <hr class="pontilhado">
                <h4> 
                    <a href="/solicitacoes/cadastraemailop"><i  class="fa fa-ship"></i>     ACC/ACE - Liquidadas</a> 
                    <br>
                    <small>Consultar as cambiais liquidadas. </small>
                </h4> 
                <hr class="pontilhado">
                <h4> 
                    <a href="/solicitacoes/cadastraemailop"><i  class="fa fa-file"></i>     Contratação</a> 
                    <br>
                    <small>Acompanhar as demandas de contratação de câmbio pronto. </small>
                </h4> 
                <hr class="pontilhado">
                <h4> 
                    <a href="/solicitacoes/cadastraemailop"><i  class="fa fa-fast-forward"></i>     Operações Antecipadas</a> 
                    <br>
                    <small>Acompanhar status de comprovação de embarque ou alteração de data prevista de embarque. </small>
                </h4> 
                <hr class="pontilhado">
                <h4> 
                    <a href="/esteiracomex/distribuir/demandas"><i  class="fa fa-envelope"></i>     Minhas Demandas</a> 
                    <br>
                    <small>Consultar demandas de todos os serviços abertas pela sua unidade. </small>
                </h4> 
                <hr class="pontilhado">
                <h4> 
                    <a href="/solicitacoes/cadastraemailop"><i  class="fa fa-money"></i>     Ordens de Pagamento</a> 
                    <br>
                    <small>Consultar ordens de pagamento do exterior. </small>
                </h4> 
                <hr class="pontilhado">
                <h4>
                    <a href="/solicitacoes/cadastraemailop"><i  class="fa fa-gavel"></i>     GECAM</a> 
                    <br>
                    <small>Acompanhar contratos com status de Cliente Suspenso ou Bloqueados. </small>
                </h4> 
            </div>
        </div>
    </div>  

</div>  <!--row-->

 
<!-- <div class="page-bar">

        <h3>Acesse o FAQ e tire suas dúvidas no link:
            <a href="http://wiki.caixa" class="text-left">wiki.caixa</a>
        </h3>

</div>  -->
 





</div>  <!--panel-body-->

</div>  <!--panel panel-default-->

</div>  <!--container-fluid-->

@stop


@section('css')
    <!-- <link rel="stylesheet" href="/css/admin_custom.css"> -->
    <link href="{{ asset('css/contratacao/cadastro.css') }}" rel="stylesheet">
@stop


@section('js')

@stop