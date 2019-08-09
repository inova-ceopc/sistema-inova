<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('tituloIndicadores')</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/vendor/bootstrap/dist/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/vendor/font-awesome/css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/vendor/Ionicons/css/ionicons.min.css') }}">
    <link href="{{ asset('css/indicadores/indicadores.css') }}" rel="stylesheet">
   <!-- Select2 -->
    <!-- <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css"> -->
     <!-- Theme style -->
    <!-- <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/AdminLTE.min.css') }}"> -->
    @yield('css')
    <!-- DataTables with bootstrap 3 style -->
    <!-- <link rel="stylesheet" href="//cdn.datatables.net/v/bs/dt-1.10.18/datatables.min.css"> -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body>
<header>
<nav class="navbar navbar-default">  
<div class="container-fluid">
    <!-- Logo -->
    <a href="#" class="logo">
        <span class="logo-lg navbar-left"><p ><img src="/images/logo-caixa.png" height="25px" width="30px" alt="X"></p></span>
    </a> 
    <!-- Navbar Right Menu -->
    <div class="nav navbar-nav navbar-right">
        <ul class="nav navbar-nav">
            <li class="dropdown messages-menu">
                <a class="dropdown-toggle">
                    <i>CONFIDENCIAL #20</i>
                </a>
            </li>


    <!-- tela cheia -->
        <li class="dropdown dropdown-extended requestfullscreen" data-toggle="tooltip" title="Visualização em Tela cheia">
            <a href="#" onclick="toggleFullScreen()">
                <i class="fa fa-arrows-alt"></i>
            </a>
        </li>
    
                  
        <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" >
                          
                <img src="http://www.sr2576.sp.caixa/2017/foto.asp?matricula={{ session()->get('matricula') }}" class="user-image" alt="User Image" onerror="this.src='{{ asset('images/userSemFoto.jpg') }}';" >
                                <!-- {{-- backup <img src="http://tedx.caixa/lib/asp/foto.asp?Matricula={{session()->get('matricula')}}" class="user-image" alt="User Image" onerror="this.src='{{ asset('images/userSemFoto.jpg') }}';">  --}} -->
                <span class="hidden-xs">{{ session()->get('primeiroNome') }}</span>
            </a>
                <ul class="dropdown-menu">

                    <!-- User image -->
                    <li class="user-header">
                        <p>
                            <small>
                                {{ session()->get('nomeCompleto') }}<br/>
                                {{ session()->get('matricula') }}<br/>												
                                {{ session()->get('codigoLotacaoAdministrativa') }}<br/>
                                {{ session()->get('acessoEmpregadoEsteiraComex') }}<br/>
                                {{ session()->get('nomeFuncao') }}<br/>											
                            </small>
                        </p>
                    </li>

                    <!-- Menu Body -->

                    <!-- Menu Footer-->
                    <li class="user-footer divider">
                        <div class="pull-right">
                            <a href="#" class="btn btn-default btn-flat">Sair</a>
                        </div>
                    </li>
                </ul>
        </li>
        </ul>
    </div>
 </div>               
</nav>
</header>



@yield('body')

<script src="{{ asset('vendor/adminlte/vendor/jquery/dist/jquery.min.js') }}"></script>
<!-- <script src="{{ asset('vendor/adminlte/vendor/jquery/dist/jquery.slimscroll.min.js') }}"></script> -->
<script src="{{ asset('vendor/adminlte/vendor/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/telaCheia.js') }}"></script>


@yield('js')

</body>
</html>
