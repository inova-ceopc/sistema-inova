@extends('adminlte::page')

@section('title', 'EsteiraComex - Painel de Indicadores')

@section('content_header')

<div class="panel-body ">
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

<p class="text-center">
    <strong> Posição de Julho</span>  </strong>
</p>
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">COMEX</h3>
 
        <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
        </button>
        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
    </div>
  <!-- sessão comex op --> 
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="box-body" style="">

            <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="fa fa-money"></i></span>

                <div class="info-box-content">
                <span class="info-box-text">OP Recebidas/mês</span>
                <span class="info-box-number">50</span>
                </div>
                <!-- /.info-box-content -->
            </div>

        </div>
    </div>

    <div class="col-md-9 col-sm-6 col-xs-12">
        <!-- <div class="box box-info"> -->
            
              <!-- <h3>Clientes x Emails Cadastrados</h3> -->
           
            <div class="box-body">
              <div class="chart">
              <canvas id="myChart" style="height: 180px; width: 752px;" width="752" height="180"></canvas>
              </div>
            </div>
         
        <!-- </div> -->

    </div>
            <!-- /.box-body -->
    <div class="box-footer text-center" style="">
        
    </div>
            <!-- /.box-footer -->
</div>
 
 <!-- segunda linha -->

 <div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">ACC/ACE</h3>
 
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
                <span class="info-box-icon bg-aqua"><i class="fa fa-money"></i></span>

                <div class="info-box-content">
                <span class="info-box-text">Demandas Cadastradas/Mês</span>
                <span class="info-box-number">50</span>
                </div>
                <!-- /.info-box-content -->
            </div>

        </div>
    </div>

    <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="box-body" style="">

            <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="fa fa-money"></i></span>

                <div class="info-box-content">
                <span class="info-box-text">Demandas Canceladas/Mês</span>
                <span class="info-box-number">50</span>
                </div>
                <!-- /.info-box-content -->
            </div>

        </div>
    </div>

    <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="box-body" style="">

            <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="fa fa-money"></i></span>

                <div class="info-box-content">
                <span class="info-box-text">Demandas Liquidadas/Mês</span>
                <span class="info-box-number">50</span>
                </div>
                <!-- /.info-box-content -->
            </div>

        </div>
    </div>

    <!-- <div class="col-md-12 col-sm-6 col-xs-12"> -->
    <div class="box-body" style="">
        <div class="chart">
            <canvas id="acc-ace" style="height: 180px; width: 752px;" width="752" height="180"></canvas>
        </div>
    </div>
         
        <!-- </div> -->

<!-- </div> -->
    
    <div class="box-footer text-center" style="">
        
    </div>
            <!-- /.box-footer -->
</div>

<!-- terceira linha -->

<div class="box box-primary">
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
                <span class="info-box-icon bg-aqua"><i class="fa fa-money"></i></span>

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
                <span class="info-box-icon bg-aqua"><i class="fa fa-money"></i></span>

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
                <span class="info-box-icon bg-aqua"><i class="fa fa-money"></i></span>

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

<div class="box box-primary">
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
                <span class="info-box-icon bg-aqua"><i class="fa fa-money"></i></span>

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
                <span class="info-box-icon bg-aqua"><i class="fa fa-money"></i></span>

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
                <span class="info-box-icon bg-aqua"><i class="fa fa-money"></i></span>

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
            <!-- /.box-footer -->
</div>
@stop





@section('css')

  <link href="{{ asset('vendor/adminlte/dist/css/AdminLTE.min.css') }}" rel="stylesheet">

@stop

@section('js')

<script>
  var ctx = document.getElementById('myChart').getContext('2d');
  var myChart = new Chart(ctx, {
    type: 'bar',
      data: {
          labels: ['01/07', '02/07', '03/07', '04/07','05/07', '08/07','09/07', '10/07','11/07', '12/07' ],
          datasets: [{
              label: '# Clientes',
              data: [12, 19, 3, 5, 2, 3],
              backgroundColor: 
                  'darkblue',
                  
              borderColor: 'black',
              borderWidth: 1
          }, {
          label: '# Cadastrados',
              data: [12, 19, 3, 5, 2, 3],
              backgroundColor: 
                  'Blue',
                  
              borderColor: 'black',
              borderWidth: 1,
              type: 'bar',
          }],
      },
   
      options: {
          scales: {
              yAxes: [{
                  ticks: {
                      beginAtZero: true
                  }
              }]
          }
      }
  });

  var ctx = document.getElementById('acc-ace').getContext('2d');
  var myChart = new Chart(ctx, {
    type: 'bar',
      data: {
          labels: ['01/07', '02/07', '03/07', '04/07','05/07', '08/07','09/07', '10/07','11/07', '12/07' ],
          datasets: [{
              label: '# Clientes',
              data: [12, 19, 3, 5, 2, 3],
              backgroundColor: 
                  'darkblue',
                  
              borderColor: 'black',
              borderWidth: 1
          }, {
          label: '# Cadastrados',
              data: [12, 19, 3, 5, 2, 3],
              backgroundColor: 
                  'Blue',
                  
              borderColor: 'black',
              borderWidth: 1,
              type: 'bar',
          }],
      },
   
      options: {
          scales: {
              yAxes: [{
                  ticks: {
                      beginAtZero: true
                  }
              }]
          }
      }
  });
  </script>

  <script src="{{ asset('vendor/adminlte/vendor/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('vendor/adminlte/dist/js/chartjs1.0.2.js') }}"></script>
@stop