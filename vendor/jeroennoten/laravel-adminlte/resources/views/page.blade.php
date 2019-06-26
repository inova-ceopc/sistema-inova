@extends('adminlte::master')

@section('adminlte_css')
    <link rel="stylesheet"
          href="{{ asset('vendor/adminlte/dist/css/skins/skin-' . config('adminlte.skin', 'blue') . '.min.css')}} ">
    @stack('css')
    @yield('css')
@stop

@section('body_class', 'skin-' . config('adminlte.skin', 'blue') . ' sidebar-mini ' . (config('adminlte.layout') ? [
    'boxed' => 'layout-boxed',
    'fixed' => 'fixed',
    'top-nav' => 'layout-top-nav'
][config('adminlte.layout')] : '') . (config('adminlte.collapse_sidebar') ? ' sidebar-collapse ' : ''))

@section('body')
    <div class="wrapper">

        <!-- Main Header -->
        <header class="main-header">
            @if(config('adminlte.layout') == 'top-nav')
            <nav class="navbar navbar-static-top">
                <div class="container">
                    <div class="navbar-header">
                        <a href="{{ url(config('adminlte.dashboard_url', 'home')) }}" class="navbar-brand">
                            {!! config('adminlte.logo', '<b>Admin</b>LTE') !!}
                        </a>
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                            <i class="fa fa-bars"></i>
                        </button>
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
                        <ul class="nav navbar-nav">
                            @each('adminlte::partials.menu-item-top-nav', $adminlte->menu(), 'item')
                        </ul>
                    </div>
                    <!-- /.navbar-collapse -->
            @else
            <!-- Logo -->
            <a href="{{ url(config('adminlte.dashboard_url', 'home')) }}" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini">{!! config('adminlte.logo_mini', '<b>A</b>LT') !!}</span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg">{!! config('adminlte.logo', '<b>Admin</b>LTE') !!}</span>
            </a>

            <!-- Header Navbar -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <span class="sr-only">{{ trans('adminlte::adminlte.toggle_navigation') }}</span>
                </a>
            @endif
                <!-- Navbar Right Menu -->
                <div class="navbar-custom-menu">

<<<<<<< HEAD
                    <ul class="nav navbar-nav">
                        <li>
                            @if(config('adminlte.logout_method') == 'GET' || !config('adminlte.logout_method') && version_compare(\Illuminate\Foundation\Application::VERSION, '5.3.0', '<'))
                                <a href="{{ url(config('adminlte.logout_url', 'auth/logout')) }}">
                                    <i class="fa fa-fw fa-power-off"></i> {{ trans('adminlte::adminlte.log_out') }}
                                </a>
                            @else
                                <a href="#"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                >
                                    <i class="fa fa-fw fa-power-off"></i> {{ trans('adminlte::adminlte.log_out') }}
                                </a>
                                <form id="logout-form" action="{{ url(config('adminlte.logout_url', 'auth/logout')) }}" method="POST" style="display: none;">
                                    @if(config('adminlte.logout_method'))
                                        {{ method_field(config('adminlte.logout_method')) }}
                                    @endif
                                    {{ csrf_field() }}
                                </form>
                            @endif
=======
                        <!-- PESQUISA MIDDLE-->
                        <li class="dropdown messages-menu" data-toggle="tooltip" title="Pesquisa Middle">
                            <a href="#" onclick="MyWindow=window.open('http://www.ceopc.hom.sp.caixa/atendimento_web/view/registro_atendimento.html','','scrollbars=no,resizable=yes,width=550,height=680'); return false;">
                                <i class="fa fa-comment-o"></i>
                            </a>
                        </li>
                        <!-- /PESQUISA MIDDLE-->
                        
                        <!-- Messages: style can be found in dropdown.less MINHAS DEMANDAS-->
                        <li class="dropdown messages-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-envelope-o"></i>
                                <b class="label label-success">0</b>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header text-center bg-gray-light">Olá, você possui nova(s) demanda(s):</li>
                                <li class="header text-center bg-gray-light"> {{session()->get('contagemDemandasDistribuidasLiquidacao')}} pedido(s) de liquidação</li>
                                <li class="header text-center bg-gray-light"> {{session()->get('contademDemandasDistribuidasAntecipadoCambioPronto')}} pedido(s) de conformidade</li>
                                <li class="footer"><a href="minhasdemandas.php">Visualizar Minha(s) Demanda(s)</a></li>
                            </ul>
                        </li>
                        <!--/MINHAS DEMANDAS-->

                        <!--DISTRIBUIR-->
                        <li class="dropdown messages-menu">
                            <a href="distribuir.php" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-bell-o"></i>
                                <span class="label label-danger">{{session()->get('contagemDemandasCadastradasLiquidacao') + session()->get('contagemDemandasCadastradasAntecipadosCambioPronto')}}</span> &nbsp;
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header text-center bg-gray-light">Gestor, você deve designar:</li>
                                <li class="header text-center bg-gray-light"> {{session()->get('contagemDemandasCadastradasLiquidacao')}} demanda(s) de liquidação.</li>
                                <li class="header text-center bg-gray-light"> {{session()->get('contagemDemandasCadastradasAntecipadosCambioPronto')}} demanda(s) de conformidade.</li>
                                <li class="footer"><a href="distribuir.php">Distribuir Demandas à Equipe</a></li>
                            </ul>
                        </li>
                        <!--/DISTRIBUIR-->

                                                    <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <!-- <img src="dist/img/user2-160x160.jpg" class="user-image" alt="User Image"> -->
                            <!-- <img src="https://permissoes.correio.corp.caixa.gov.br/ThumbPhoto/C079436_AD.jpg" class="user-image" alt="User Image" onError="this.src='dist/img/user2-160x160.jpg';"> -->
                             
                                <img src="http://www.sr2576.sp.caixa/2017/foto.asp?matricula={{session()->get('matricula')}}" class="user-image" alt="User Image" onerror="this.src='dist/img/user2-160x160.jpg';">
                                <span class="hidden-xs">{{session()->get('primeiroNome')}}</span>
                            </a>
                            <ul class="dropdown-menu">

                                <!-- User image -->
                                <li class="user-header">
                                    <p>
                                        <small>
                                            {{session()->get('nomeCompleto')}}<br/>
                                            {{session()->get('matricula')}}<br/>												
                                            {{session()->get('codigoLotacaoAdministrativa')}}<br/>												
                                            {{session()->get('acessoEmpregado')}}<br/>												
                                            {{session()->get('nomeFuncao')}}<br/>											
                                        </small>
                                    </p>
                                </li>

                                <!-- Menu Body -->

                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-right">
                                        <a href="#" class="btn btn-default btn-flat">Sair</a>
                                    </div>
                                </li>
                            </ul>
>>>>>>> a60e54d9510a740d18aea6d897b1b172d63b1178
                        </li>
                    </ul>
                </div>
                @if(config('adminlte.layout') == 'top-nav')
                </div>
                @endif
            </nav>
        </header>

        @if(config('adminlte.layout') != 'top-nav')
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">

            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">

                <!-- Sidebar Menu -->
                <ul class="sidebar-menu" data-widget="tree">
                    @each('adminlte::partials.menu-item', $adminlte->menu(), 'item')
                </ul>
                <!-- /.sidebar-menu -->
            </section>
            <!-- /.sidebar -->
        </aside>
        @endif

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @if(config('adminlte.layout') == 'top-nav')
            <div class="container">
            @endif

            <!-- Content Header (Page header) -->
            <section class="content-header">
                @yield('content_header')
            </section>

            <!-- Main content -->
            <section class="content">

                @yield('content')

            </section>
            <!-- /.content -->
            @if(config('adminlte.layout') == 'top-nav')
            </div>
            <!-- /.container -->
            @endif
        </div>
        <!-- /.content-wrapper -->

    </div>
    <!-- ./wrapper -->
@stop

@section('adminlte_js')
    <script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
    @stack('js')
    @yield('js')
@stop
