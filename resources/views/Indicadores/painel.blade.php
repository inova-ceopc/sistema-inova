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
    <link href="{{ asset('css/indicadores/painel.css') }}" rel="stylesheet">

    <!-- HTML5 shim e Respond.js para suporte no IE8 de elementos HTML5 e media queries -->
    <!-- ALERTA: Respond.js não funciona se você visualizar uma página file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="container-fluid">
    <nav class="navbar navbar-default">
      <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <img alt="Brand" class="navbar-brand" src="/images/logo-caixa.png">
          
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
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
           
          </div><!-- /Slide1 --> 


          <div class="item">
            <div class="col-md-3 col-sm-6 col-xs-12">

              <div onclick="displayDialog(this.id)" class="info-box escolha" id="boxOrdens">

                <span class="info-box-icon bg-aqua"><i class="fa fa-exchange"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">outros indicadores</span>
                  <span class="info-box-number">resultados<small></small></span>
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
      <!-- conteudo -->
      <div class="panel panel-default">
        <div class="panel-body" align="center">
          <!-- valores do indicador -->
          <!-- <div class="col-md-12"> -->
            <div id="op">
              <!-- <div class="box-header with-border"> -->
                <h3>ORDENS DE PAGAMENTO</h3>
              <!-- </div> -->
              <div class="box-body">
          
                  <div class="chart-container" style="position: relative; width:85%">
                      <canvas id="graficoOP" ></canvas>
                  </div>
              </div>
              <!-- /.box-body -->
            <!-- </div> -->
            </div>

            <div id="accAce" style="display: none;">
              <!-- <div class="box-header with-border"> -->
                <h3>ACC/ACE</h3>
                <h5>Analises das solicitações de liquidação ACC/ACE</h5>
              <!-- </div> -->
              <div class="box-body">
                <div class="tabbable page-tabs">
                  <ul class="nav nav-tabs" id="abas">
                      <li class="active" id="abaAccDia">
                      <a  href="#liquidacaoDia" data-toggle="tab"><i class="icon-paragraph-justify2"></i> Liquidadas Dia </a></li>
                      <li id="abaAccMes"><a href="#liquidacaoMes" data-toggle="tab"><i class="icon-exit4"></i> Liquidadas Mês </a></li>                </ul>    
                  </ul>
                  <div class="tab-content">
          
                      <div class="tab-pane active fade in" id="liquidacaoDia">
                          <div class="chart-container" style="position: relative; width:75%">
                          <canvas id="analisesAccAce30dias"></canvas>
                          </div>
                      </div>
                        
                      <div class="tab-pane" id="liquidacaoMes">
                          <div class="chart-container" style="position: relative; width:75%">
                          <canvas id="analisesAccAceMensal"></canvas>
                          </div>
                      </div>
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
            </div>


            <div id="antecipados" style="display: none;">
              <!-- <div class="box-header with-border"> -->
                <h3>ANTECIPADOS</h3>
                <h5>Conformidade Pronto/Importação/Exportação</h5>
              <!-- </div> -->
              <div class="box-body">
          
              <div class="row">
                <div class="col-md-2" ></div>
                <div class="col-md-3 col-sm-6 col-xs-12">   
                    <div class="info-box bg-green">
                    <span class="info-box-icon"><i class="fa fa-pencil"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Contratados/Mês</span>
                            <span id= "contratado" class="text-center" class="info-box-number"></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </div>
    
      
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-green">
                    <span class="info-box-icon"><i class="fa fa-check"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Conforme/Mês</span>
                            <span id="conforme" class="text-center" class="info-box-number"></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </div> 
                
  
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-green">
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
                   <!-- /row -->

              <div class ="row">
                <div class="col-md-2" ></div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-green">
                    <span class="info-box-icon"><i class="fa fa-exclamation-circle"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Reiterado/Mês</span>
                            <span id="reiterado" class="text-center" class="info-box-number"></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </div> 
            
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-green">
                    <span class="info-box-icon"><i class="fa fa-external-link"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Cobrados/Mês</span>
                            <span id="cobrado" class="text-center" class="info-box-number"></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </div> 
              </div>
              <!-- /row -->
              </div>
              <!-- /.box-body -->
            <!-- </div> -->
            </div>

            
            <div id="atendimento" style="display: none;">
              <!-- <div class="box-header with-border"> -->
              <h3 class="box-title">ATENDIMENTO MIDDLE</h3>
              <h5>Resultados referentes aos atendimentos prestados pelo Middle Office</h5>
              <h5>Para mais informações<a href="http://www.ceopc.hom.sp.caixa/atendimento_web/view/indicadores_atendimento_middle.php"> Clique Aqui</a></h5>
              <!-- </div> -->
              <div class="box-body">
                <div class="col-md-3 col-sm-6 col-xs-12">
                  <div class="info-box">
                    <span class="info-box-icon bg-yellow"><i class="fa fa-star-o"></i></span>

                    <div class="info-box-content">
                    <span class="info-box-text">Média Nota/Mês</span>
                    <span class="info-box-number">4</span>
                    </div>
                    
                  </div>
                </div>

                <div class="col-md-3 col-sm-6 col-xs-12">
                  <div class="info-box">
                    <span class="info-box-icon bg-yellow"><i class="fa fa-user-o"></i></span>

                    <div class="info-box-content">
                    <span class="info-box-text text-center">Rotina/</span>
                    <span class="info-box-text text-center">Consultoria</span>
                    <span class="info-box-number text-center">162</span>
                    </div>
                  </div>
                </div>

                <div class="col-md-6 col-sm-6 col-xs-12">
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
              <!-- /.box-body -->
            <!-- </div> -->
            </div>


          <!-- /final valores do indicador -->
        </div>
        <!-- /panel body -->
      </div>
      <!-- /panel default -->
    </div>
    <footer class="footer mt-auto py-3">
      <div class="container">
        <strong>&copy; 2019 - {{ env('NOME_NOSSA_UNIDADE') }} | </strong> Equipe de Desenvolvimento de Melhorias.
      </div>
    </footer>

    <!-- Inclui todos os plugins compilados (abaixo), ou inclua arquivos separadados se necessário -->
    <script src="{{ asset('vendor/adminlte/vendor/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/adminlte/vendor/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0/dist/Chart.min.js"></script>
    <script src="{{asset('js/indicadores/indicadores-comex.js')}}"></script>
    <script src="{{ asset('js/telaCheia.js') }}"></script>
  </body>
</html>