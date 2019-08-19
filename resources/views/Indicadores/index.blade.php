@extends('Indicadores.layout')


@section('tituloIndicadores', 'Painel de Indicadores')


@section('body')
<div class="topo">
    <h4 class="animated bounceInLeft pull-left">
        Indicadores | 
        <small> Relatórios de Operações {{ env('NOME_NOSSA_UNIDADE') }} </small>
    </h4>
    
    <ol class="breadcrumb pull-right">
        <li><a href="#"><i class="fa fa-dashboard"></i> Indicadores</a></li>
        <li><a href="#"></i> Painel de Indicadores Comex</a></li>
    </ol>
</div>
<!-- conteudo acima do painel -->
@section('cabecalho')
<div class="page-bar text-center">
    <h3>Posição de <span id="mes-atual"></span>
        <br>            
    </h3>
</div>
<div class="container-fluid">

            <div id= "escolherView" class="row">
                <div class="col-md-3 col-sm-6 col-xs-12">

                  <div onclick="displayDialog(this.id)" class="info-box escolha active" id="boxOrdens">

                    <span class="info-box-icon bg-aqua"><i class="fa fa-exchange"></i></span>
        
                    <div class="info-box-content">
                      <span class="info-box-text">Ordens de Pagamento </span>
                      <span class="info-box-number">Hoje: 27<small></small></span>
                    </div>
                    <!-- /.info-box-content -->
                  </div>
                  <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-md-3 col-sm-6 col-xs-12">
                  <div onclick="displayDialog(this.id)" class="info-box escolha" id="liquidacao">

                        <span class="info-box-icon bg-red"><i class="fa fa-download"></i></span>
        
                    <div class="info-box-content">
                      <span class="info-box-text">Liquidação ACC/ACE</span>
                      <span class="info-box-number">Hoje: 01 </span>
                    </div>
                    <!-- /.info-box-content -->
                  </div>
                  <!-- /.info-box -->
                </div>
                <!-- /.col -->
        
                <!-- fix for small devices only -->
                <div class="clearfix visible-sm-block"></div>
        
                <div class="col-md-3 col-sm-6 col-xs-12">

                  <div onclick="displayDialog(this.id)" class="info-box escolha" id="antecipado">

                    <span class="info-box-icon bg-green"><i class="fa fa-ship"></i></span>
        
                    <div class="info-box-content">
                      <span class="info-box-text">Importação/Exportação <br> - Antecipados</span>
                      <span class="info-box-number">Hoje: 05</span>
                    </div>
                    <!-- /.info-box-content -->
                  </div>
                  <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-md-3 col-sm-6 col-xs-12">

                  <div onclick="displayDialog(this.id)" class="info-box escolha" id="qualidade"> 
                    <span class="info-box-icon bg-yellow"><i class="fa fa-users"></i></span>

        
                    <div class="info-box-content">
                      <span class="info-box-text">Qualidade Atendimento </span>
                      <span class="info-box-number">Nota 4.97</span>
                    </div>
                    <!-- /.info-box-content -->
                  </div>
                  <!-- /.info-box -->
                </div>
                <!-- /.col -->
            </div>

 @endsection   
 <!-- conteudo do painel -->
<!-- linha -->
@section('conteudo')
<div class="row">

    <div id="mapa" class="col-md-6 col-sm-12" style="display: none;">
       
                    @component('Componentes.mapa')
                    @section('tituloBoxMapa')
                    Contratos ACC/ACE por Região
                    @endsection
                    @section('subtituloBoxMapa')
                    Quantidade de contratos por região do Brasil
                    @endsection
                    @endcomponent
         
    </div>

    <div class="col-md-2" ></div>
    <div id="graficoOp" class="col-md-8" >
        @component('Indicadores.componentes.grafico-ordens-pagamento')
                    
        @endcomponent
       

    </div>
    <div class="col-md-2" ></div>

</div>

<!-- linha -->
<div class = "row">

    <div class="col-md-1" ></div>
    <div id="accAce" class="col-md-08 col-sm-12" style="display: none;">

        @component('Indicadores.componentes.grafico-accace')
                    
        @endcomponent

    </div>
    <div class="col-md-1" ></div>
</div> 
<!--/.row -->

 <!-- segunda linha -->

<div id="antecipados" style="display: none;">
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">ANTECIPADOS</h3>
        <h5 class="text-left">Conformidade Pronto/Importação/Exportação</h5>
 
       
    </div>
    
<div class="row">
    <div class="col-md-1" ></div>
    <div class="col-md-3 col-sm-6 col-xs-12">   
        <div class="info-box bg-blue">
        <span class="info-box-icon"><i class="fa fa-pencil"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Contratados/Mês</span>
                <span id= "contratado" class="text-center" class="info-box-number"></span>
            </div>
            <!-- /.info-box-content -->
        </div>
    </div>
    
      
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-blue">
        <span class="info-box-icon"><i class="fa fa-check"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Conforme/Mês</span>
                <span id="conforme" class="text-center" class="info-box-number"></span>
            </div>
            <!-- /.info-box-content -->
        </div>
    </div> 
    
  
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-blue">
        <span class="info-box-icon"><i class="fa fa-times"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Bloqueado/Mês</span>
                <span id="bloqueado" class="text-center" class="info-box-number"></span>
            </div>
            <!-- /.info-box-content -->
        </div>
    </div> 
    <div class="col-md-1" ></div>
</div>            
<div class ="row">
    <div class="col-md-1" ></div>
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-blue">
        <span class="info-box-icon"><i class="fa fa-exclamation-circle"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Reiterado/Mês</span>
                <span id="reiterado" class="text-center" class="info-box-number"></span>
            </div>
            <!-- /.info-box-content -->
        </div>
    </div> 
            
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-blue">
        <span class="info-box-icon"><i class="fa fa-external-link"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Cobrados/Mês</span>
                <span id="cobrado" class="text-center" class="info-box-number"></span>
            </div>
            <!-- /.info-box-content -->
        </div>
    </div> 
    <div class="col-md-1" ></div>
       
</div><!--/row-->

    <div class="row">
        <div class="col-md-1 "></div>
        <div class="col-md-10 col-sm-12 col-xs-12">
            @component('Indicadores.componentes.grafico-antecipados')
                    
            @endcomponent
        </div>
        <div class="col-md-1"></div>
    </div><!--/row-->
    
    <div class="box-footer text-center" style="">
        
    </div><!--/footer-->
           
</div> <!--/box-->
</div>

<!-- terceira linha -->
<div id="atendimento" class="box box-warning" style="display: none;">
    <div class="box-header with-border">
        <h3 class="box-title">ATENDIMENTO MIDDLE</h3>
        <h5 class="text-left">Resultados referentes aos atendimentos prestados pelo Middle Office</h5>
        <h5 class="text-left">Para mais informações<a href="http://www.ceopc.hom.sp.caixa/atendimento_web/view/indicadores_atendimento_middle.php"> Clique Aqui</a></h5>
        
    </div>

    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="box-body" style="">

            <div class="info-box">
                <span class="info-box-icon bg-yellow"><i class="fa fa-star-o"></i></span>

                <div class="info-box-content">
                <span class="info-box-text">Média Nota/Mês</span>
                <span class="info-box-number">4</span>
                </div>
                
            </div>

        </div>
    </div>

    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="box-body" style="">

            <div class="info-box">
                <span class="info-box-icon bg-yellow"><i class="fa fa-user-o"></i></span>

                <div class="info-box-content">
                <span class="info-box-text text-center">Rotina/</span>
                <span class="info-box-text text-center">Consultoria</span>
                <span class="info-box-number text-center">162</span>
                </div>
               
            </div>

        </div>
    </div>

    <div class="col-md-6 col-sm-12 col-xs-12">
        <div class="box-body" style="">

            <div class="info-box">
                <span class="info-box-icon bg-yellow"><i class="fa fa-phone"></i>
                </span>

                <div class="info-box-content">
                <span class="info-box-text text-center"><strong>Canal Atendimento</strong></span>
                <div class="col-md-4 col-sm-4 col-xs-6">
                <span class="info-box-text">Email</span>
                <span class="info-box-number">107</span> 
                </div>
                <div class="col-md-4 col-sm-4 col-xs-6"> 
                <span class="info-box-text">Lync</span>
                <span class="info-box-number">44</span>  
                </div>
                <div class="col-md-4 col-sm-4 col-xs-6">
                <span class="info-box-text">Telefone</span>
                <span class="info-box-number">11</span>
                </div>
                </div>
               
            </div>

        </div>
    </div>
    
    <div class="box-footer text-center" style="">
        
    </div>

</div><!--/box-->

<!-- quarta linha -->

<div id="notasConquiste" class="box box-info" style="display: none;">
    <div class="box-header with-border">
        <h3 class="box-title">CONQUISTE</h3>
 
    </div>
 
    <!-- <div class="col-md-2 col-sm-6 col-xs-12"></div> -->
    <div class="col-md-4 col-sm-6 col-xs-12 align-center">
        <div class="box-body" style="">

            <div class="info-box">
                <span class="info-box-icon bg-blue"><i class="fa fa-hourglass"></i></span>

                <div class="info-box-content">
                <span class="info-box-text">Tempo Médio de Atendimento</span>
                <span class="info-box-number">0</span>
                <span class="info-box-text">Mês</span>
                </div>
             
            </div>

        </div>
    </div>

    <div class="col-md-4 col-sm-6 col-xs-12 align-center">
        <div class="box-body" style="">

            <div class="info-box">
                <span class="info-box-icon bg-blue"><i class="fa fa-hourglass-o"></i></span>

                <div class="info-box-content">
                <span class="info-box-text">Tempo Médio de Atendimento</span>
                <span class="info-box-number">0</span>
                <span class="info-box-text">Dia</span>
                </div>
                
            </div>

        </div>
    </div>
    <!-- <div class="col-md-2 col-sm-6 col-xs-12"></div> -->

    <!-- <div class="box-footer text-center" style="">
        
    </div> -->
        
</div> <!--/box-->

<!-- </div>  /panel-body -->

<!-- </div>  /panel panel-default -->

</div>  
<!--/container-fluid-->

@stop

@stop

@section('css')

  <link href="{{ asset('vendor/adminlte/dist/css/AdminLTE.min.css') }}" rel="stylesheet">

  <!-- <link href="{{ asset('css/contratacao/cadastro.css') }}" rel="stylesheet"> -->
  <link href="{{ asset('css/mapa.css') }}" rel="stylesheet">
  <link href="{{ asset('css/indicadores/indicadores.css') }}" rel="stylesheet">


@stop

@section('js')
<script src="{{ asset('vendor/adminlte/vendor/jquery/dist/jquery.min.js') }}"></script>
  <!-- <script src="{{ asset('js/echarts.all.js') }}"></script> -->
  <!-- <script src="{{asset('js/app.js')}}"></script> -->
  <script src="{{asset('js/indicadores/indicadores-comex.js')}}"></script>

 
@stop