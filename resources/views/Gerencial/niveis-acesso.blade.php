@extends('adminlte::page')

@section('title', 'Esteira Comex')


@section('content_header')

<div class="panel-body padding015">
    <h4 class="animated bounceInLeft pull-left">
        Controle de Níveis de Acesso | 
        <small>Painel de controle demandas COMEX </small>
    </h4>
    <ol class="breadcrumb pull-right">
        <li><a href="#"><i class="fa fa-dashboard"></i>Gerencial</a></li>
        <li><a href="#"></i>Níveis de Acesso</a></li>
    </ol>
</div>

@stop

@section('content')

<!-- <div class="container-fluid row">

    <div class="panel-default col-md-6">

        <div class="panel-body col-md-12 padding0">

        
                


                    <div id="div1" class="form-control" ondrop="drop(event)" ondragover="allowDrop(event)">
                    

                    
                    </div>




        </div> 

    </div> 

    <div class="panel-default col-md-6">

        <div class="panel-body col-md-12 padding0">



            <div id="div2" class="form-control" ondrop="drop(event)" ondragover="allowDrop(event)">

                <img id="drag1" src="https://www.w3schools.com/html/img_w3slogo.gif" draggable="true" ondragstart="drag(event)">
                <img id="drag2" src="https://www.w3schools.com/html/img_w3slogo.gif" draggable="true" ondragstart="drag(event)">
                <img id="drag3" src="https://www.w3schools.com/html/img_w3slogo.gif" draggable="true" ondragstart="drag(event)">
                <img id="drag4" src="https://www.w3schools.com/html/img_w3slogo.gif" draggable="true" ondragstart="drag(event)">


            </div>


        </div> 

    </div> 
    






</div>  -->

<div class="container-fluid">
<div class="panel panel-default box box-primary">
<div class="panel-body  with-border"> 

<form method="POST" action="/esteiracomex/contratacao/cadastrar" enctype="multipart/form-data" id="formCadastroContratacao_">

    <div class="form-group row">

        <div id="div1" class="col-md-6 inline card" ondrop="drop(event)" ondragover="allowDrop(event)">
        
                
            <div id="drag1" class="media col-md-6 btn margin0 padding510" draggable="true" ondragstart="drag(event)">
                <div class="media-left padding0">
                    <a href="#">
                        <img src="http://www.sr2576.sp.caixa/2017/foto.asp?matricula=c142765" class="card-user-image" alt="User Image" onerror="this.src='http://127.0.0.1:8000/images/userSemFoto.jpg';">
                    </a>
                </div>
                <div class="media-body">
                    <h4 class="media-heading">Carlos Alberto Dalcin David</h4>
                    C142765 <br>
                    Assistente Júnior
                </div>
            </div>


            <div id="drag2" class="media col-md-6 btn margin0 padding510" draggable="true" ondragstart="drag(event)">
                <div class="media-left padding0">
                    <a href="#">
                        <img src="http://www.sr2576.sp.caixa/2017/foto.asp?matricula=c142765" class="card-user-image" alt="User Image" onerror="this.src='http://127.0.0.1:8000/images/userSemFoto.jpg';">
                    </a>
                </div>
                <div class="media-body">
                    <h4 class="media-heading">Carlos Alberto Dalcin David</h4>
                    C142765 <br>
                    Assistente Júnior
                </div>
            </div>



            <div id="drag3" class="media col-md-6 btn margin0 padding510" draggable="true" ondragstart="drag(event)">
                <div class="media-left padding0">
                    <a href="#">
                        <img src="http://www.sr2576.sp.caixa/2017/foto.asp?matricula=c142765" class="card-user-image" alt="User Image" onerror="this.src='http://127.0.0.1:8000/images/userSemFoto.jpg';">
                    </a>
                </div>
                <div class="media-body">
                    <h4 class="media-heading">Carlos Alberto Dalcin David</h4>
                    C142765 <br>
                    Assistente Júnior
                </div>
            </div>




        
        </div>

        <div id="div2" class="col-md-6 inline card" ondrop="drop(event)" ondragover="allowDrop(event)">
        
                
            <div id="drag4" class="media col-md-6 btn margin0 padding510" draggable="true" ondragstart="drag(event)">
                <div class="media-left padding0">
                    <a href="#">
                        <img src="http://www.sr2576.sp.caixa/2017/foto.asp?matricula=c142765" class="card-user-image" alt="User Image" onerror="this.src='http://127.0.0.1:8000/images/userSemFoto.jpg';">
                    </a>
                </div>
                <div class="media-body">
                    <h4 class="media-heading">Carlos Alberto Dalcin David</h4>
                    C142765 <br>
                    Assistente Júnior
                </div>
            </div>

            <div id="drag5" class="media col-md-6 btn margin0 padding510" draggable="true" ondragstart="drag(event)">
                <div class="media-left padding0">
                    <a href="#">
                        <img src="http://www.sr2576.sp.caixa/2017/foto.asp?matricula=c142765" class="card-user-image" alt="User Image" onerror="this.src='http://127.0.0.1:8000/images/userSemFoto.jpg';">
                    </a>
                </div>
                <div class="media-body">
                    <h4 class="media-heading">Carlos Alberto Dalcin David</h4>
                    C142765 <br>
                    Assistente Júnior
                </div>
            </div>


            <div id="drag6" class="media col-md-6 btn margin0 padding510" draggable="true" ondragstart="drag(event)">
                <div class="media-left padding0">
                    <a href="#">
                        <img src="http://www.sr2576.sp.caixa/2017/foto.asp?matricula=c142765" class="card-user-image" alt="User Image" onerror="this.src='http://127.0.0.1:8000/images/userSemFoto.jpg';">
                    </a>
                </div>
                <div class="media-body">
                    <h4 class="media-heading">Carlos Alberto Dalcin David</h4>
                    C142765 <br>
                    Assistente Júnior
                </div>
            </div>




        
        </div>

    </div>




    <div class="form-group">
        <div class="col-sm-2 col-md-6">
            <button type="submit" id="submitBtn" class="btn btn-primary btn-lg center">Gravar</button>
        </div>
    </div>
    

</form>

</div>  <!--panel-body-->
</div>  <!--panel panel-default-->
</div>  <!--container-fluid-->

            @if (session('mensagem'))
            <div class="box box-solid box-success">
                <div class="box-header">
                    <h3 class="box-title"><strong>{{ session('mensagem') }}</strong> </h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    Acessos atualizados com sucesso!
                </div><!-- /.box-body -->
            </div>
            @endif


@stop

@section('css')
    <link href="{{ asset('css/Gerencial/niveis-acesso.css') }}" rel="stylesheet">
@stop

@section('js')
    <script src="{{ asset('js/plugins/jquery/jquery-ui.min.js') }}"></script>

    <script>
        function allowDrop(ev) {
        ev.preventDefault();
        }

        function drag(ev) {
        ev.dataTransfer.setData("text", ev.target.id);
        }

        function drop(ev) {
        ev.preventDefault();
        var data = ev.dataTransfer.getData("text");
        ev.target.appendChild(document.getElementById(data));
        }
    </script>
@stop