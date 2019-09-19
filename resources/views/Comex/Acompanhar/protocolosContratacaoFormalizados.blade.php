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
            <li><a href="#"></i>Demandas Formalizadas</a></li>
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


    <!-- ########## QUADRO Pedidos de Contratação ########## -->

    <h4>Contratações Formalizadas</h4>

    <!-- <h4>Resumo do dia</h4> -->

    <div>
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="col-md-4 padding05 active">
                <a href="#formalizar" class="btn btn-default" aria-controls="home" role="tab" data-toggle="tab">
                    <h4 class="panel-title"><b>Conformes e Formalizados</b></h4>
                </a>
            </li>
            <li role="presentation" class="col-md-4 padding05">
                <a href="#controlar" class="btn btn-default" aria-controls="profile" role="tab" data-toggle="tab">
                    <h4 class="panel-title"><b>Controle de Retornos</b></h4>
                </a>
            </li>
            <li role="presentation" class="col-md-4 padding05">
                <a href="#analisar" class="btn btn-default" aria-controls="messages" role="tab" data-toggle="tab">
                    <h4 class="panel-title"><b>Conformidade de Contrato</b></h4>
                </a>
            </li>
        </ul>

        <div class="tab-content">
            <div role="tabpanel" class="tab-pane fade in active" id="formalizar">
                <br>

                <div class="table-responsive">
                    <table id="tabelaContratacoesFormalizadas" class="table table-striped table-condensed hover dataTable pointer">
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

            </div>

            <div role="tabpanel" class="tab-pane fade" id="controlar">
                <br>

                <div class="table-responsive">
                    <table id="tabelaControleRetornos" class="table table-striped table-condensed hover dataTable pointer">
                        <thead class="thead-dark">
                            <tr>
                                <th class="col-xs">#Contrato</th>
                                <!-- <th class="col-xs">ID</th> -->
                                <th class="col-xs">Nome</th>
                                <th class="col-xs">CNPJ / CPF</th>
                                <th class="col-xs">Operação</th>
                                <th class="col-xs">Valor</th>
                                <th class="col-xs">Área</th>
                                <th class="col-xs">Liquidação</th>
                                <th class="col-xs">Data de Envio</th>
                                <th class="col-xs">Data Limite de Retorno</th>

                                <!-- <th class="col-xs">Status</th> -->
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot class="thead-dark">
                            <tr>
                                <th class="col-xs">#Contrato</th>
                                <!-- <th class="col-xs">ID</th> -->
                                <th class="col-xs">Nome</th>
                                <th class="col-xs">CNPJ / CPF</th>
                                <th class="col-xs">Operação</th>
                                <th class="col-xs">Valor</th>
                                <th class="col-xs">Área</th>
                                <th class="col-xs">Liquidação</th>
                                <th class="col-xs">Data de Envio</th>
                                <th class="col-xs">Data Limite de Retorno</th>

                                <!-- <th class="col-xs">Status</th> -->
                            </tr>
                        </tfoot>
                    </table>
                </div> <!--/table-responsive-->

            </div>

            <div role="tabpanel" class="tab-pane fade" id="analisar">
                <br>

                <div class="table-responsive">
                    <table id="tabelaVerificacaoAssinatura" class="table table-striped table-condensed hover dataTable pointer">
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

            </div>

        </div><!-- tab content -->

    </div>


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
    <script src="{{ asset('js/global/formata_data.js') }}"></script>   <!--Função global que formata a data para valor humano br.-->
    <script src="{{ asset('js/global/formata_datatable.js') }}"></script>
    <script src="{{ asset('js/contratacao/carrega_demandas_formalizadas.js') }}"></script>
    
@stop