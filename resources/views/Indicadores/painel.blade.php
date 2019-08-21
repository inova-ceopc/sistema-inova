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
            <span class="icon-bar"></span>
          </button>
          <img alt="Brand" class="navbar-brand" src="/images/logo-caixa.png">
          
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav">
         
            <li><a href="#">Painel de Indicadores</a></li>
  
          </ul>
        
          <ul class="nav navbar-nav navbar-right">
           
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="#">Action</a></li>
                <li><a href="#">Another action</a></li>
                <li><a href="#">Something else here</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="#">Separated link</a></li>
              </ul>
            </li>
          </ul>
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
    </nav>
    </div>
    <!-- /container-fluid -->
    <div class="page-header">
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

  </div>

    
    <div class="container">
      <div class="panel panel-default">
        <div class="panel-body">
          Basic panel example
        </div>
      </div>
    </div>
    <footer class="footer mt-auto py-3">
      <div class="container">
        <strong>&copy; 2019 - {{ env('NOME_NOSSA_UNIDADE') }} | </strong> Equipe de Desenvolvimento de Melhorias.
      </div>
    </footer>

    <!-- Inclui todos os plugins compilados (abaixo), ou inclua arquivos separadados se necessário -->
    <script src="{{ asset('vendor/adminlte/vendor/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/adminlte/vendor/bootstrap/dist/js/bootstrap.min.js') }}"></script>
  </body>
</html>