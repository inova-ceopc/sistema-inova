@extends('adminlte::page')

@section('title', 'Esteira Comex')


@section('content_header')
    
    <h4 class="animated bounceInLeft">
        Minhas Demandas | 
        <small>Demandas cadastradas para análise CEOPC</small>
    </h4>
    
    <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i>Acompanhamentos</a></li>
            <li><a href="#"></i>Minhas Demandas</a></li>
    </ol>

@stop


@section('content')

<div class="container-fluid">

<div class="panel panel-default">

<div class="panel-body">


    <div class="page-bar">
        <h3>Um Título</h3>
    </div>
<br>


    <!-- ########################################## QUADRO Pedidos de Liquidação ################################################ -->
        
        <!-- SELECT COUNT. QTDE DEMANDAS DISTRIBUIDAS -->

        <h4>Pedidos de Liquidação <button type='' id="countPedidosLiquidacao" class='btn btn-primary margin20'>0</button></h4>

<div class="table-responsive">
    <table id="tabelaPedidosLiquidacao" class="table table-striped table-condensed dataTable">
        <thead class="thead-dark">
            <tr>
                <th>Protocolo</th>
                <th>Nome</th>
                <th>CNPJ / CPF</th>
                <th>Operação</th>
                <th>Valor</th>
                <th>Código do PV</th>
                <th>Status</th>
            </tr>
        </thead>
       
        <tfoot class="thead-dark">
            <tr>
                <th>Protocolo</th>
                <th>Nome</th>
                <th>CNPJ / CPF</th>
                <th>Operação</th>
                <th>Valor</th>
                <th>Código do PV</th>
                <th>Status</th>
            </tr>
        </tfoot>
    </table>
</div> <!--/table-responsive-->

<hr>

<!-- ########################################## QUADRO Pedidos de Conformidade ################################################ -->

<h4>Pedidos de Conformidade (Antecipados) <button type='' id="countPedidosConformidade" class='btn btn-primary margin20'>0</button></h4>

<div class="table-responsive">

    <table id="tabelaPedidosConformidade" class="table table-striped table-condensed dataTable">
        <thead class="thead-dark">
            <tr>
                <th>Protocolo</th>
                <th>Nome</th>
                <th>CNPJ / CPF</th>
                <th>Operação</th>
                <th>Valor</th>
                <th>Código do PV</th>
                <th>Status</th>
            </tr>
        </thead>
    
        <tfoot class="thead-dark">
            <tr>
                <th>Protocolo</th>
                <th>Nome</th>
                <th>CNPJ / CPF</th>
                <th>Operação</th>
                <th>Valor</th>
                <th>Código do PV</th>
                <th>Status</th>
            </tr>
        </tfoot>
    </table>

</div> <!--/table-responsive-->

<hr>

    <!-- ########################################## QUADRO Pedidos de Contratação ################################################ -->

<h4>Pedidos de Contratação <button type='' id="countPedidosContratacao" class='btn btn-primary margin20'>0</button></h4>

<div class="table-responsive">

    <table id="tabelaPedidosContratacao" class="table table-striped table-condensed hover dataTable pointer">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>ID do Cliente</th>
                <th>Tipo de Cliente</th>
                <th>Nome</th>
                <th>CNPJ / CPF</th>
                <th>Operação</th>
                <th>Valor</th>
                <th>Data de Embarque</th>
                <th>#PV</th>
                <th>Nome do PV</th>
                <th>Status</th>
            </tr>
        </thead>
    
        <tfoot class="thead-dark">
            <tr>
                <th>ID</th>
                <th>ID do Cliente</th>
                <th>Tipo de Cliente</th>
                <th>Nome</th>
                <th>CNPJ / CPF</th>
                <th>Operação</th>
                <th>Valor</th>
                <th>Data de Embarque</th>
                <th>#PV</th>
                <th>Nome do PV</th>
                <th>Status</th>
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
    <script src="{{ asset('js/plugins/jquery/jquery-1.12.1.min.js') }}"></script>
    <script src="{{ asset('js/plugins/jquery/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('js/plugins/numeral/numeral.min.js') }}"></script>
    <script src="{{ asset('js/plugins/masks/jquery.mask.min.js') }}"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js" type="text/javascript" charset="utf8"></script>
    <script src="{{ asset('js/contratacao/carrega_json_minhas_demandas.js') }}"></script>

@stop