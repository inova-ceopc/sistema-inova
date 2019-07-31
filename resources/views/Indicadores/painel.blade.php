@extends('adminlte::page')

@section('title', 'EsteiraComex - Painel de Indicadores')

@section('content_header')
<div class="panel-body padding015">
    <h4 class="animated bounceInLeft pull-left">
        Indicadores | 
        <small> Relatórios de Operações CEOPA </small>
    </h4>
    
    <ol class="breadcrumb pull-right">
        <li><a href="#"><i class="fa fa-dashboard"></i> Indicadores</a></li>
        <li><a href="#"></i> Painel de Indicadores</a></li>
    </ol>
</div>

@stop

@section('content')

<div class="container-fluid">

<div class="panel panel-default">

<div class="panel-body">
    
    <div class="page-bar">
        <h3>Posição de <span id="mes-atual"></span>
            <br>
                <small class="text-left">Resultados das Operações de Comércio Exterior
            <br>
        </h3>
    </div>

<br>

<!-- primeiro box com as informações das op -->
<div class="row">
    <div class="col-md-6">
        <div class="box box-warning ">
            <div class="box-header with-border">
            <h3 class="box-title">COMEX</h3>
                <h5 class="text-left">Ordens de pagamento</h5>
         
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
                <!-- /.box-header -->
            <div class="box-body">

                <div class="col-6 col-md-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-yellow">OP</span>

                        <div class="info-box-content">
                        <span class="info-box-text">OP Recebidas/mês</span>
                        <span id="op-recebida"class="info-box-number text-center"></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </div>
                <div class="col-6 col-md-6">    
                    <canvas id="clientesComEmail" height="155" width="222" style="width: 222px; height: 155px;"></canvas>
                </div>
            </div>
            <!-- /.box-body -->
           
        </div>
    </div>

    <div class="col-md-6">
        <div class="box box-warning ">
            <div class="box-header with-border">
            <h3 class="box-title">ACC/ACE</h3>
            <h5 class="text-left">Analises/Mês</h5>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
                <!-- /.box-header -->
            <div class="box-body">

                <div class="chart">
                <canvas id="analisesAccAce" style="height: 180px; width: 752px;" width="752" height="180"></canvas>
                </div>

            </div>
            <!-- /.box-body -->
           
        </div>
    </div>
</div>

 <!-- segunda linha -->

 <div class="box box-warning">
    <div class="box-header with-border">
        <h3 class="box-title">ANTECIPADOS</h3>
 
        <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
        </button>
        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
    </div>
  <!-- sessão comex op --> 
    <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="box-body" style="">

            <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="fa fa-pencil "></i></span>

                <div class="info-box-content">
                <span class="info-box-text">Contratadas</span>
                <span id="contratado"class="info-box-number"></span>
                </div>
                <!-- /.info-box-content -->
            </div>

        </div>
    </div>

    <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="box-body" style="">

            <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="fa fa-times"></i></span>

                <div class="info-box-content">
                <span class="info-box-text">Bloqueado</span>
                <span id ="bloqueado"class="info-box-number"></span>
                </div>
                <!-- /.info-box-content -->
            </div>
        </div>
    </div>

    <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="box-body" style="">

            <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="fa fa-check"></i></span>

                <div class="info-box-content">
                <span class="info-box-text">Conforme</span>
                <span id="conforme" class="info-box-number"></span>
                </div>
                <!-- /.info-box-content -->
            </div>

        </div>
    </div>

    <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="box-body" style="">

            <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="fa fa-exclamation-circle "></i></span>

                <div class="info-box-content">
                <span class="info-box-text">Reiterado</span>
                <span id="reiterado" class="info-box-number"></span>
                </div>
                <!-- /.info-box-content -->
            </div>

        </div>
    </div>

    <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="box-body" style="">

            <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="fa fa-external-link "></i></span>

                <div class="info-box-content">
                <span class="info-box-text">Cobrado</span>
                <span id="cobrado" class="info-box-number"></span>
                </div>
                <!-- /.info-box-content -->
            </div>

        </div>
    </div>

    <!-- <div class="col-md-12 col-sm-6 col-xs-12"> -->
    <div class="box-body" style="">
        <div class="chart">
            <canvas id="antecipados" style="height: 180px; width: 752px;" width="752" height="180"></canvas>
        </div>
    </div>
         
        <!-- </div> -->

<!-- </div> -->
    
    <div class="box-footer text-center" style="">
        
    </div>
            <!-- /.box-footer -->
</div>

<!-- terceira linha -->

<div class="box box-warning">
    <div class="box-header with-border">
        <h3 class="box-title">ANTECIPADOS</h3>
 
        <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
        </button>
        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
    </div>
  <!-- sessão comex op --> 
    <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="box-body" style="">

            <div class="info-box">
                <span class="info-box-icon bg-yellow"><i class="fa fa-money"></i></span>

                <div class="info-box-content">
                <span class="info-box-text">Cadastradas/Mês</span>
                <span class="info-box-number">50</span>
                </div>
                <!-- /.info-box-content -->
            </div>

        </div>
    <!-- </div> -->

    <!-- <div class="col-md-4 col-sm-6 col-xs-12"> -->
        <div class="box-body" style="">

            <div class="info-box">
                <span class="info-box-icon bg-yellow"><i class="fa fa-money"></i></span>

                <div class="info-box-content">
                <span class="info-box-text">Analisadas/Mês</span>
                <span class="info-box-number">50</span>
                </div>
                <!-- /.info-box-content -->
            </div>

        </div>
    <!-- </div> -->

    <!-- <div class="col-md-4 col-sm-6 col-xs-12"> -->
        <div class="box-body" style="">

            <div class="info-box">
                <span class="info-box-icon bg-yellow"><i class="fa fa-money"></i></span>

                <div class="info-box-content">
                <span class="info-box-text">Inconforme/Canceladas(Mês)</span>
                <span class="info-box-number">50</span>
                </div>
                <!-- /.info-box-content -->
            </div>

        </div>
    </div>

    <div class="box-footer text-center" style="">
        
    </div>
            <!-- /.box-footer -->
</div>

<!-- quarta linha -->

<div class="box box-warning">
    <div class="box-header with-border">
        <h3 class="box-title">Atendimento Middle</h3>
 
        <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
        </button>
        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
    </div>

    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="box-body" style="">

            <div class="info-box">
                <span class="info-box-icon bg-yellow"><i class="fa fa-money"></i></span>

                <div class="info-box-content">
                <span class="info-box-text">Média Nota</span>
                <span class="info-box-number">4</span>
                </div>
                <!-- /.info-box-content -->
            </div>

        </div>
    </div>

    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="box-body" style="">

            <div class="info-box">
                <span class="info-box-icon bg-yellow"><i class="fa fa-money"></i></span>

                <div class="info-box-content">
                <span class="info-box-text">Rotina/Consultoria</span>
                <span class="info-box-number">800</span>
                </div>
                <!-- /.info-box-content -->
            </div>

        </div>
    </div>

    <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="box-body" style="">

            <div class="info-box">
                <span class="info-box-icon bg-yellow"><i class="fa fa-money"></i></span>

                <div class="info-box-content">
                <span class="info-box-text text-center"><strong>Canal Atendimento</strong></span>
                <div class="col-md-4 col-sm-6 col-xs-12">
                <span class="info-box-text">Email</span>
                <span class="info-box-number">450</span> 
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12"> 
                <span class="info-box-text">Lync</span>
                <span class="info-box-number">250</span>  
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12">
                <span class="info-box-text">Telefone</span>
                <span class="info-box-number">100</span>
                </div>
                </div>
                <!-- /.info-box-content -->
            </div>

        </div>
    </div>
    
    <div class="box-footer text-center" style="">
        
    </div>
</div>  <!--panel-body-->

</div>  <!--panel panel-default-->

</div>  <!--container-fluid-->



@stop

@section('css')

  <link href="{{ asset('vendor/adminlte/dist/css/AdminLTE.min.css') }}" rel="stylesheet">
  <link href="{{ asset('css/contratacao/cadastro.css') }}" rel="stylesheet">

@stop

@section('js')
<script src="{{ asset('vendor/adminlte/vendor/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('vendor/adminlte/dist/js/chartjs1.0.2.js') }}"></script>
  <!-- <script src="{{asset('js/app.js')}}"></script> -->
  <script src="{{asset('js/indicadores/indicadores-comex.js')}}"></script>

 
@stop