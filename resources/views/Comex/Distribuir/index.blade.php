@extends('adminlte::page')

@section('title', 'Esteira Comex')


@section('content_header')

<div class="panel-body padding015">
    <h4 class="animated bounceInLeft pull-left">
        Distribuição de Demandas | 
        <small>Painel de controle demandas COMEX </small>
    </h4>
    
    <ol class="breadcrumb pull-right">
            <li><a href="#"><i class="fa fa-dashboard"></i>Gerencial</a></li>
            <li><a href="#"></i>Distribuição de Demandas</a></li>
    </ol>
</div>

@stop


@section('content')


<div class="container-fluid">

<div class="panel panel-default">

<div class="panel-body" id="accordion">

    <div class="panel-group row margin0" role="tablist" aria-multiselectable="true">

        <div class="col-md-4 padding05">

            <div class="panel panel-default">

                <div class="panel-heading" role="tab" id="headingOne">
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                        <h4 class="panel-title">
                            <b>Liquidação -  ACC / ACE &nbsp; </b>
                            <b>&nbsp; &nbsp;  &nbsp;  &nbsp; 0 &nbsp; </b>
                            <span class="pull-right active animated pulse infinite glyphicon fa fa-chevron-right">&nbsp; </span> &nbsp; 
                        </h4>
                    </a>
                </div>

            </div>

        </div>

        <div class="col-md-4 padding05">

            <div class="panel panel-default">

                <div class="panel-heading" role="tab" id="headingTwo">
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        <h4 class="panel-title">
                            <b>Comprovação de Embarque &nbsp; </b>
                            <b>&nbsp; &nbsp;  &nbsp;  &nbsp; 0 &nbsp; </b>
                            <span class="pull-right active animated pulse infinite fa fa-chevron-right">&nbsp; </span> &nbsp; 
                        </h4>
                    </a>
                </div>

            </div>
        
        </div>

        <div class="col-md-4 padding05">

            <div class="panel panel-default">

                <div class="panel-heading" role="tab" id="headingThree">
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        <h4 class="panel-title">
                            <b>Contratação - Pronto &nbsp; </b>
                            <b>&nbsp; &nbsp;  &nbsp;  &nbsp; 0 &nbsp; </b>
                            <span class="pull-right active animated pulse infinite fa fa-chevron-right">&nbsp; </span> &nbsp; 
                        </h4>
                    </a>
                </div>

            </div>

        </div>

    </div>   <!--panel-group row-->

    <br>

    <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">

        <div class="page-bar">
            <h3>Liquidação - ACC / ACE</h3>
        </div>

        <hr>


    </div> <!--#collapseOne-->

    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">

        <div class="page-bar">
            <h3>Comprovação de Embarque</h3>
        </div>

        <hr>

        
    </div> <!--#collapseTwo-->

    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">



        <div class="page-bar">
            <h3>Contratação - Pronto</h3>
        </div>
    
        <hr>

        <!-- ########################################## QUADRO RESUMO DO DIA ################################################ -->
            
    <!-- SELECT COUNT. QTDE DEMANDAS DISTRIBUIDAS -->

        <h4>Resumo do dia</h4>


        <div class="table-responsive">
            <table id="tabelaResumo" class="table table-striped compact dataTable">
                <thead class="thead-dark">
                    <tr>
                        <th>Matrícula</th>
                        <th>Nome</th>
                        <th>Pronto IMP</th>
                        <th>Pronto IMP Antec.</th>
                        <th>Pronto EXP</th>
                        <th>Pronto EXP Antec.</th>
                        <th>Total</th>
                    </tr>
                </thead>
            
                <tfoot class="thead-dark">
                    <tr>
                        <th>Matrícula</th>
                        <th>Nome</th>
                        <th>Pronto IMP</th>
                        <th>Pronto IMP Antec.</th>
                        <th>Pronto EXP</th>
                        <th>Pronto EXP Antec.</th>
                        <th>Total</th>
                    </tr>
                </tfoot>
            </table>
        </div> <!--/table-responsive-->




        <hr>

        <!-- ########################################## QUADRO DE DISTRIBUIR DEMANDAS ################################################ -->

        <h4>Novas demandas</h4>
        <form method="post" action="1" onsubmit="return validation();"  enctype="multipart/form-data">

@csrf


        <div class="table-responsive">

            <table id="tabelaContratacoes" class="table table-striped compact dataTable">
                <thead class="thead-dark">
                    <tr>
                        <th class="col-sm-1">Protocolo</th>
                        <th class="col-sm-3">Nome</th>
                        <th class="col-sm-2">CNPJ / CPF</th>
                        <th class="col-sm-1">Operação</th>
                        <th class="col-sm-1">Valor</th>
                        <th class="col-sm-1">Demandante</th>
                        <th class="col-sm-1">Status</th>
                        <th class="col-sm-2">Distribuir</th>
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
                        <th class="col-sm-2">Distribuir</th>
                    </tr>
                </tfoot>
            </table>

        </div> <!--/table-responsive-->

                            </form>


        <hr>

        <h4>Status</h4>

        <div class="form-group">          
            <ul class="list-group col-sm-3">
                <li class="list-group-item">1 - Cadastrada</li>
                <li class="list-group-item">2 - Em análise</li>
                <li class="list-group-item">3 - Conforme / Conferência</li>
                <li class="list-group-item">4 - Conta OK</li>
                <li class="list-group-item">5 - Inconforme</li>
                <li class="list-group-item">6 - Cancelado</li>
            </ul>
        </div>  <!--/form-group row-->

    </div> <!--#collapseThree-->

</div>  <!--panel-body-->

</div>  <!--panel panel-default-->

</div>  <!--container-fluid-->


@stop


@section('css')
    <link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/contratacao/cadastro.css') }}" rel="stylesheet">
@stop


@section('js')
    <script src="{{ asset('js/plugins/jquery/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('js/plugins/numeral/numeral.min.js') }}"></script>
    <script src="{{ asset('js/plugins/masks/jquery.mask.min.js') }}"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js" type="text/javascript" charset="utf8"></script>
        
    <script src="{{ asset('js/contratacao/distribuir_demandas_contratacao.js') }}"></script>
    <script>

                $('.collapse').on('show.bs.collapse', function () {
                $('.collapse.in').collapse('hide'); 
                });

                // ajax get http://127.0.0.1:8000/api/esteiracomex/distribuicao
                // ajax post http://127.0.0.1:8000/api/esteiracomex/distribuicao

    </script>
    

@stop