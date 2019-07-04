@extends('adminlte::page')

@section('title', 'EsteiraComex - Demandas de Contratação - Pronto')

@section('content_header')

<div class="panel-body padding015">
    <h4 class="animated bounceInLeft pull-left">
        Acompanhamentos | 
        <small>Demandas de Contratação - Pronto</small>
    </h4>
    <ol class="breadcrumb pull-right">
        <li><a href="#"><i class="fa fa-dashboard"></i>Acompanhamentos</a></li>
        <li><a href="#"></i>Contratação - Pronto</a></li>
    </ol>
</div>

@stop

@section('content')

<div class="container-fluid">

<div class="panel panel-default">

<div class="panel-body">

    <!-- ########################################## QUADRO Pedidos de Contratação ################################################ -->

<h4>Demandas de Contratação <button type='' id="countPedidosContratacao" class='btn btn-primary margin20'>0</button></h4>

<div class="table-responsive">

    <table id="tabelaPedidosContratacao" class="table table-striped table-condensed hover dataTable pointer">
        <thead class="thead-dark">
            <tr>
                <th class="col-sm-1">Protocolo</th>
                <th class="col-sm-3">Nome</th>
                <th class="col-sm-2">CNPJ / CPF</th>
                <th class="col-sm-1">Operação</th>
                <th class="col-sm-1">Valor</th>
                <th class="col-sm-1">Demandante</th>
                <th class="col-sm-1">Status</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
        <tfoot class="thead-dark">
            <tr>
                <th class="col-sm-1">Protocolo</th>
                <th class="col-sm-3">Nome</th>
                <th class="col-sm-2">CNPJ / CPF</th>
                <th class="col-sm-1">Operação</th>
                <th class="col-sm-1">Valor</th>
                <th class="col-sm-1">Demandante</th>
                <th class="col-sm-1">Status</th>
            </tr>
        </tfoot>
    </table>

</div> <!--/table-responsive-->

<hr>

<a class="btn btn-primary" href="/esteiracomex/contratacao">Cadastrar nova demanda</a>



</div>  <!--panel-body-->

</div>  <!--panel panel-default-->

</div>  <!--container-fluid-->

@stop

@section('css')
    <link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/contratacao/cadastro.css') }}" rel="stylesheet">
@stop

@section('js')
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js" type="text/javascript" charset="utf8"></script>
    <script src="{{ asset('js/contratacao/carrega_todas_demandas.js') }}"></script>
@stop