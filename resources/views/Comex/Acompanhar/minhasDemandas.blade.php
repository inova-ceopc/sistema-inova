@extends('adminlte::page')

@section('title', 'Esteira Comex')


@section('content_header')
    
<div class="panel-body padding015">
    <h4 class="animated bounceInLeft pull-left">
        Minhas Demandas | 
        <small>Demandas cadastradas para análise CEOPC</small>
    </h4>
    
    <ol class="breadcrumb pull-right">
            <li><a href="#"><i class="fa fa-map-signs"></i>Acompanhamentos</a></li>
            <li><a href="#"></i>Minhas Demandas</a></li>
    </ol>
</div>

@stop


@section('content')

<div class="container-fluid">

<div class="panel panel-default">

<div class="panel-body">

    @if (session('tituloMensagem'))
    <div class="box box-solid box-{{ session('corMensagem') }}">
            <div class="box-header">
                <h3 class="box-title"><strong>{{ session('tituloMensagem') }}</strong> </h3>
            </div><!-- /.box-header -->
            <div class="box-body">
                {{ session('corpoMensagem') }}
            </div><!-- /.box-body -->
    </div>
    @endif

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

<h4>Pedidos de Contratação <button type='' id="countPedidosContratacao" class='btn btn-primary margin20'>{{ session()->get('contagemDemandasDistribuidasContratacao', 0) }}</button></h4>

<div class="table-responsive">

    <table id="tabelaPedidosContratacao" class="table table-striped table-condensed hover dataTable pointer">
        <thead class="thead-dark">
            <tr>
                <th class="col-xs">ID</th>
                <th class="col-xs">Nome</th>
                <th class="col-xs-2">CNPJ / CPF</th>
                <th class="col-xs-2">Operação</th>
                <th class="col-xs">Valor</th>
                <th class="col-xs">Área</th>
                <th class="col-xs">Status</th>
                <th class="col-xs">Ação</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
        <tfoot class="thead-dark">
            <tr>
                <th class="col-xs">ID</th>
                <th class="col-xs">Nome</th>
                <th class="col-xs-2">CNPJ / CPF</th>
                <th class="col-xs-2">Operação</th>
                <th class="col-xs">Valor</th>
                <th class="col-xs">Área</th>
                <th class="col-xs">Status</th>
                <th class="col-xs">Ação</th>
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
    <link href="{{ asset('css/contratacao/cadastro.css') }}" rel="stylesheet">
@stop


@section('js')
<script src="{{ asset('js/plugins/numeral/numeral.min.js') }}"></script>
    <script src="{{ asset('js/plugins/numeral/locales/pt-br.min.js') }}"></script>
    <script src="{{ asset('js/global/formata_data.js') }}"></script>   <!--Função global que formata a data para valor humano br.-->
    <script src="{{ asset('js/contratacao/carrega_json_minhas_demandas.js') }}"></script>
    <script> x =  '{{session()->get('acessoEmpregadoEsteiraComex')}}'; 
@stop