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

    <!-- ########################################## QUADRO Pedidos de Contratação ################################################ -->

    <h4>Demandas de Contratação <button type='' id="countPedidosContratacao" class='btn btn-primary margin20'>{{ session()->get('contagemDemandasDistribuidasContratacao', 0) }}</button></h4>

    <div class="table-responsive">

        <table id="tabelaPedidosContratacao" class="table table-striped table-condensed hover dataTable pointer">
            <thead class="thead-dark">
                <tr>
                    <th class="col-xs">ID</th>
                    <th class="col-xs">Nome</th>
                    <th class="col-xs">CNPJ / CPF</th>
                    <th class="col-xs">Operação</th>
                    <th class="col-xs">Contrato</th>
                    <th class="col-xs">Dt. Liq.</th>
                    <th class="col-xs">Valor</th>
                    <th class="col-xs">Conta</th>
                    <th class="col-xs">Ação</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
            <tfoot class="thead-dark">
                <tr>
                    <th class="col-xs">ID</th>
                    <th class="col-xs">Nome</th>
                    <th class="col-xs">CNPJ / CPF</th>
                    <th class="col-xs">Operação</th>
                    <th class="col-xs">Contrato</th>
                    <th class="col-xs">Dt. Liq.</th>
                    <th class="col-xs">Valor</th>
                    <th class="col-xs">Conta</th>
                    <th class="col-xs">Ação</th>
                </tr>
            </tfoot>
        </table>

    </div> <!--/table-responsive-->

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
    <script src="{{ asset('js/plugins/moment/moment-with-locales.min.js') }}"></script>
    <script src="{{ asset('js/global/formata_data.js') }}"></script>   <!-- Função global que formata a data para valor humano br. -->
    <script src="{{ asset('js/global/formata_datatable.js') }}"></script>
    <script src="{{ asset('js/contratacao/carrega_demandas_liquidacao.js') }}"></script>
@stop