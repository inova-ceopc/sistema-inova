
@extends('adminlte::page')

@section('title', 'Esteira Comex')

@section('content_header')
    
    <h4 class="animated bounceInLeft">
        Introdução | 
        <small>Workflow para rotinas de comércio exterior </small>
    </h4>
    
    <ol class="breadcrumb">
            <li><a href="/esteiracomex"><i class="fa fa-map-signs"></i>Introdução</a></li>
    </ol>

@stop


@section('content')

<div class="container-fluid">

<div class="panel panel-default">

<div class="panel-body">


    <div class="page-bar">
        <h3>Mapa do site - Esteira Comex
            <br>
            <small class="text-left">Prezado colega, seja bem vindo à Esteira Comex! No Menu lateral você pode encontrar os itens abaixo em destaque:</small>
        </h3>
    </div>

<br>

    <!-- <div class="page-bar col-md-6">
        <h4> 
            <i class="fa fa-sign-in"></i> Solicitar Atendimento
            <br>
            <small class="text-left">Cadastrar novas demandas dos serviços abaixo:</small>
        </h4>

        <ul class="list-group">
            <li class="list-group-item"><h4><a href="/solicitacoes/cadastraemailop" class="fa fa-circle-o">     Atualizar e-mail cliente</a></h4></li>
            <li class="list-group-item"></li>
            <li class="list-group-item"></li>
            <li class="list-group-item"></li>
        </ul>
    </div>

    <div class="page-bar col-md-6">
        <h4> 
            <i class="fa fa-files-o"></i> Acompanhamentos
            <br>
            <small class="text-left">Acompanhe as demandas dos serviços abaixo:</small>
        </h4>

        <ul class="list-group">
            <li class="list-group-item"><h4><a href="/solicitacoes/cadastraemailop" class="fa fa-circle-o">     Atualizar e-mail cliente</a></h4></li>
            <li class="list-group-item"></li>
            <li class="list-group-item"></li>
            <li class="list-group-item"></li>
            <li class="list-group-item"></li>
            <li class="list-group-item"></li>
            <li class="list-group-item"></li>
        </ul>
    </div> -->

<div class="row">
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4> 
                    <i class="fa fa-sign-in"> </i> Solicitar Atendimento
                    <br>
                    <small class="text-left">Cadastrar novas demandas dos serviços abaixo:</small>
                </h4>
            </div>
            <div class="panel-body">
                <h4> <a href="/solicitacoes/cadastraemailop"><i  class="fa fa-circle-o"></i>     Atualizar e-mail cliente</a> </h4> <hr>
                <h4> <a href="/solicitacoes/cadastraemailop"><i  class="fa fa-circle-o"></i>     Liquidação ACC/ACE</a> </h4> <hr>
                <h4> <a href="/solicitacoes/cadastraemailop"><i  class="fa fa-circle-o"></i>     Contratação - Pronto</a> </h4> <hr>
                <h4> <a href="/solicitacoes/cadastraemailop"><i  class="fa fa-circle-o"></i>     Conformidade Antecipados</a> </h4>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4> 
                    <i class="fa fa-files-o"></i> Acompanhamentos
                    <br>
                    <small class="text-left">Cadastrar novas demandas dos serviços abaixo:</small>
                </h4>
            </div>
            <div class="panel-body">
                <h4> <a href="/solicitacoes/cadastraemailop"><i  class="fa fa-ship"></i>     ACC/ACE</a> </h4> <hr>
                <h4> <a href="/solicitacoes/cadastraemailop"><i  class="fa fa-ship"></i>     ACC/ACE - Liquidadas</a> </h4> <hr>
                <h4> <a href="/solicitacoes/cadastraemailop"><i  class="fa fa-file"></i>     Contratação</a> </h4> <hr>
                <h4> <a href="/solicitacoes/cadastraemailop"><i  class="fa fa-fast-forward"></i>     Operações Antecipadas</a> </h4> <hr>
                <h4> <a href="/solicitacoes/cadastraemailop"><i  class="fa fa-envelope-o"></i>     Minhas Demandas</a> </h4> <hr>
                <h4> <a href="/solicitacoes/cadastraemailop"><i  class="fa fa-money"></i>     Ordens de Pagamento</a> </h4> <hr>
                <h4> <a href="/solicitacoes/cadastraemailop"><i  class="fa fa-circle-o"></i>     GECAM</a> </h4> 
            </div>
        </div>
    </div>
</div>

 
 
 
 





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