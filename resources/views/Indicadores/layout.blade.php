<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Painel Indicadores</title>

    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/vendor/bootstrap/dist/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/vendor/font-awesome/css/font-awesome.min.css') }}">
  
    @yield('css')
   

</head>
  <body id="tudo">

    <nav class="navbar navbar-default navbar-static-top">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand navbar-brand-img" href="#">
                <img src="/images/logo-caixa.png">
            </a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li><a href="#contact">@yield('titulo-pagina')</a></li>
            </ul>
            <form class="navbar-right">
            <ul class="nav navbar-nav">
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
            
            </form>
        </div>
    </nav>
    
 
    @yield('body')
    <section >
    <div class="container-fluid">
  

        @yield('cabecalho')

        <div class="panel panel-default">
                 
        @yield('conteudo')

         
        </div>
    </div> 

    
    </section>

        <footer class="navbar-bottom">
        <strong>&copy; 2019 - {{ env('NOME_NOSSA_UNIDADE') }} | </strong> Equipe de Desenvolvimento de Melhorias.
        </footer>
    
     
<script src="{{ asset('vendor/adminlte/vendor/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/adminlte/vendor/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/telaCheia.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0/dist/Chart.min.js"></script>

@yield('js')


</body>
</html>
