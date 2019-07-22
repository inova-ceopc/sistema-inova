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

  <div class="col-md-12">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Chamados SIGCB - Controle de Garantias </h3>

        <div class="box-tools pull-right">
          
          <button type="button" class="btn btn-box-tool" data-widget="collapse">
            <i class="fa fa-minus"></i>
          </button>
          
          <button type="button" class="btn btn-box-tool" data-widget="remove">
            <i class="fa fa-times"></i>
          </button>

        </div>
      </div>

      <!-- /.box-header -->
      <div class="box-body">
        <div class="row">
          <div class="col-md-8">

            <p class="text-center">
              <strong>  Posição de <span id="dia-atual"></span>  </strong>
            </p>

            <div class="chart">
              <!-- Sales Chart Canvas -->
              <canvas id="myChart" style="height: 180px; width: 752px;" width="752" height="180"></canvas>
            </div>
            <!-- /.chart-responsive -->
          </div>
         
         
          <!-- /.col -->
          <div class="col-md-4">
            <p class="text-center">
              <strong> Resumo Atendimentos SIGCB</strong>
            </p>

            {{-- Componente Resumo lateral repete 4x --}}
            <div class="progress-group">
              <span class="progress-text">Recusados</span>
              <span class="progress-number"><b>100</b>/926</span>

              <div class="progress sm">
                {{-- Aqui precisa vir dinamicamente --}}
                <div class="progress-bar progress-bar-aqua" style="width: 12%"></div> 
              </div>
            </div>
            <!-- /.progress-group -->

            <div class="progress-group">
              <span class="progress-text">Tratados em D+0</span>
              <span class="progress-number"><b>542 </b>/926</span>

              <div class="progress sm">
                <div class="progress-bar progress-bar-red" style="width: 60%"></div>
              </div>
            </div>
            
            <!-- /.progress-group -->
            <div class="progress-group">
              <span class="progress-text">Tratados em D+1 </span>
              <span class="progress-number"><b>474 </b>/926</span>

              <div class="progress sm">
                <div class="progress-bar progress-bar-green" style="width: 45%"></div>
              </div>
            </div>
            <!-- /.progress-group -->
            <div class="progress-group">
              <span class="progress-text">Tratado em D + 2 ou mais </span>
              <span class="progress-number"><b>15</b>/926</span>

              <div class="progress sm">
                <div class="progress-bar progress-bar-yellow" style="width: 12%"></div>
              </div>
            </div>
            <!-- /.progress-group -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
     
      <!-- ./box-body -->
      <div class="box-footer">
     
        <div class="row">
          <div class="col-sm-3 col-xs-6">
            <div class="description-block border-right">
              <span class="description-percentage text-green"><i class="fa fa-caret-up"></i> 17%</span>
              <h5 class="description-header">$35,210.43</h5>
              <span class="description-text">Recusados</span>
            </div>
            <!-- /.description-block -->
          </div>
          <!-- /.col -->
          <div class="col-sm-3 col-xs-6">
            <div class="description-block border-right">
              <span class="description-percentage text-yellow"><i class="fa fa-caret-left"></i> 0%</span>
              <h5 class="description-header">$10,390.90</h5>
              <span class="description-text">Tratados em D+0</span>
            </div>
            <!-- /.description-block -->
          </div>
          <!-- /.col -->
          <div class="col-sm-3 col-xs-6">
            <div class="description-block border-right">
              <span class="description-percentage text-green"><i class="fa fa-caret-up"></i> 20%</span>
              <h5 class="description-header">$24,813.53</h5>
              <span class="description-text">Tratados em D + 1</span>
            </div>
            <!-- /.description-block -->
          </div>
          <!-- /.col -->
          <div class="col-sm-3 col-xs-6">
            <div class="description-block">
              <span class="description-percentage text-red"><i class="fa fa-caret-down"></i> 18%</span>
              <h5 class="description-header">1200</h5>
              <span class="description-text">Tratados em D+2 ou mais</span>
            </div>
            <!-- /.description-block -->
          </div>
        </div>
        <!-- /.row -->
      </div>
      <!-- /.box-footer -->
    </div>
    <!-- /.box -->
  </div>
  <!-- /.col -->





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
          labels: ['primary', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
          datasets: [{
              label: '# of Votes',
              data: [12, 19, 3, 5, 2, 3],
              backgroundColor: [
                  'rgba(255, 99, 132, 0.2)',
                  'rgba(54, 162, 235, 0.2)',
                  'rgba(255, 206, 86, 0.2)',
                  'rgba(75, 192, 192, 0.2)',
                  'rgba(153, 102, 255, 0.2)',
                  'rgba(255, 159, 64, 0.2)'
              ],
              borderColor: [
                  'rgba(255, 99, 132, 1)',
                  'rgba(54, 162, 235, 1)',
                  'rgba(255, 206, 86, 1)',
                  'rgba(75, 192, 192, 1)',
                  'rgba(153, 102, 255, 1)',
                  'rgba(255, 159, 64, 1)'
              ],
              borderWidth: 1
          }]
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

<script>

    
/* Começo: Esta função altera dinamicamente o mês na página de indicadores */
    
    function DataAtual(){
          var agora = new Date;
          var meses = ['Janeiro', 'Fevereiro', 'Março','Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro','Novembro','Dezembro'];
          let hoje = agora.getMonth();
          return agora.getDate() + ' ' +    meses[hoje] + ' de ' + agora.getFullYear();
      }
      
      var diaAtual = document.querySelector("#dia-atual");
      diaAtual.textContent = DataAtual();

  /* FIM: Esta função altera dinamicamente o mês na página de indicadores */

</script>

  <script src="{{ asset('vendor/adminlte/vendor/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('vendor/adminlte/dist/js/chartjs1.0.2.js') }}"></script>
@stop