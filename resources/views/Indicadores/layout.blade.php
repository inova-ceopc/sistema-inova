<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- As 3 meta tags acima *devem* vir em primeiro lugar dentro do `head`; qualquer outro conteúdo deve vir *após* essas tags -->
    <title>Painel Indicadores</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/vendor/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/vendor/font-awesome/css/font-awesome.min.css') }}">
    <link href="{{ asset('vendor/adminlte/dist/css/AdminLTE.min.css') }}" rel="stylesheet">
    
    @yield('css')
 
  </head>
  <body>
    <div class="container-fluid">
    <nav class="navbar navbar-default">
      <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <img alt="Brand" class="navbar-brand" src="/images/logo-caixa.png">
          
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li><a href="#"> Painel de Indicadores</a></li>
                <li><a href="#"> Relatórios de Operações {{ env('NOME_NOSSA_UNIDADE') }} </a></li>
            </ul>
        
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown dropdown-extended requestfullscreen" data-toggle="tooltip" title="Visualização em Tela cheia">
                <a href="#" onclick="toggleFullScreen()">
                    <i class="fa fa-arrows-alt"></i>
                </a>
                </li>

           
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="http://www.sr2576.sp.caixa/2017/foto.asp?matricula={{ session()->get('matricula') }}" class="user-image" alt="User Image" onerror="this.src='{{ asset('images/userSemFoto.jpg') }}';">
                        <span class="hidden-xs">{{ session()->get('primeiroNome') }}</span>
                    </a>
                    <ul class="dropdown-menu">

                        <!-- User image -->
                        <li class="user-header">
                            <small style="color: black">
                                {{ session()->get('nomeCompleto') }}<br/>
                                {{ session()->get('matricula') }}<br/>												
                                {{ session()->get('codigoLotacaoAdministrativa') }}<br/>
                                {{ session()->get('acessoEmpregadoEsteiraComex') }}<br/>
                                {{ session()->get('nomeFuncao') }}<br/>											
                            </small>
                        </li>

                        <!-- Menu Body -->

                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-right">
                                <a href="#" class="btn btn-default btn-flat">Sair</a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
    </nav>
    </div>
    <!-- /container-fluid -->
      
<div class="page-header">
    <div class="container">
    <!-- carrossel com o resumo dos indicadores -->
         
        <div id="myCarousel" class="row carousel slide" data-ride="carousel">

            <!-- Wrapper for slides -->
            <div class="carousel-inner">

            <div class="item active">

                <div class="col-md-3 col-sm-6 col-xs-12">

                    <div onclick="displayDialog(this.id)" class="info-box escolha" id="boxOrdens">

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

                <div class="col-md-3 col-sm-6 col-xs-12">

                    <div onclick="displayDialog(this.id)" class="info-box escolha" id="antecipado">

                    <span class="info-box-icon bg-green"><i class="fa fa-ship"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Importação/<br>Exportação<br> - Antecipados</span>
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
                            <span class="info-box-text">Qualidade<br> Atendimento </span>
                            <span class="info-box-number">Nota 4.97</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
            
            </div><!-- /Slide1 --> 


            <div class="item">
                <div class="col-md-3 col-sm-12 col-xs-12">

                <div onclick="displayDialog(this.id)" class="info-box escolha" id="contratos">

                <span class="info-box-icon bg-aqua"><i class="fa fa-exchange"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Contratações</span>
                        <span class="info-box-number">Hoje:<small></small></span>
                    </div>
                    <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
            </div><!-- /Slide2 --> 

        </div><!-- /Wrapper for slides .carousel-inner -->

        <!-- Control box -->
            <div class="control-box">                            
            <a data-slide="prev" href="#myCarousel" class="carousel-control left">‹</a>
            <a data-slide="next" href="#myCarousel" class="carousel-control right">›</a>
            </div><!-- /.control-box -->   

        </div>
        <!-- /#myCarousel -->
    </div>
    <!-- /.container -->
</div>  
    <!--resultados indicadores  -->
    <div class="container">
     
      <div class="panel panel-default">
        <div class="panel-body" align="center">
          <!-- valores do indicador -->
          
          @yield('conteudo')

          <!-- fim valores indicadores -->
        </div>
        <!-- /panel body -->
      </div>
      <!-- /panel default -->
    </div>
    <!-- /container -->
   
    <footer class="footer mt-auto py-3">
      <div class="container">
        <strong>&copy; 2019 - {{ env('NOME_NOSSA_UNIDADE') }} | </strong> Equipe de Desenvolvimento de Melhorias.
      </div>
    </footer>

    <!-- Inclui todos os plugins compilados (abaixo), ou inclua arquivos separadados se necessário -->
    <script src="{{ asset('vendor/adminlte/vendor/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/adminlte/vendor/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0/dist/Chart.min.js"></script>
    <script src="{{ asset('js/telaCheia.js') }}"></script>

    @yield('js')
  
    </body>
</html>

