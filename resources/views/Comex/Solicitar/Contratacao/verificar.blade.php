@extends('adminlte::page')

@section('title', 'EsteiraComex - Análise Contratação')

@section('content_header')
    
<div class="panel-body padding015">
    <h4 class="animated bounceInLeft pull-left">
        Esteira de Contratação | 
        <small>Verificação de Assinatura</small>
    </h4>

    <ol class="breadcrumb pull-right"> 
        <li><a href="/esteiracomex"><i class="fa fa-map-signs"></i>Solicitar Atendimento </a></li>
        <li><a href=""></i>Contratação</a></li>
    </ol>
</div>

@stop

@section('content')


                <!-- ########################################## CONTEÚDO ÚNICO ################################################ -->
<input id="unidade" hidden value="{{session()->get('codigoLotacaoAdministrativa')}}">


<div class="container-fluid">

<div class="panel panel-default">

<div class="panel-body">
    @if (session('tituloMensagem'))
        <div class="box box-solid box-{{ session('corMensagem') }}">
                <div class="box-header">
                    <h3 class="box-title"><strong>{{ session('tituloMensagem') }}</strong> </h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    {{ session('corpoMensagem') }}
                </div><!-- /.box-body -->
        </div>
    @endif


    <div class="page-bar">
        <h3>Contratação - Verificação de Assinatura - Protocolo # <p class="inline" name="idDemanda"></p>{{ $demanda }}</h3>
        <input type="text" id="idDemanda" value="{{ $demanda }}" hidden disabled>
    </div>

<br>
         <!-- /esteiracomex/contratacao/complemento/{{ $demanda }} -->
    <div class="form-horizontal" id="formVerificaAssinatura">
    
        <div class="form-group">

            <label class="col-sm-1 control-label">CPF / CNPJ:</label>
            <div class="col-sm-2">
                <p class="form-control mascaracnpj" name="cnpj" id="cpfCnpj"></p>
            </div>

            <label class="col-sm-1 control-label">Nome:</label>
            <div class="col-sm-4">
                <p class="form-control" name="nomeCliente" id="nomeCliente"></p>
            </div>
    
            <label class="col-sm-1 control-label">Agência:</label>
            <div class="col-sm-1">
                <p class="form-control" name="agResponsavel" id="agResponsavel"></p>
            </div>

            <label class="col-sm-1 control-label">SR:</label>
            <div class="col-sm-1">
                <p class="form-control" name="srResponsavel" id="srResponsavel"></p>
            </div>

        </div>  <!--/form-group-->


        <div class="form-group">

            <label class="col-sm-1 control-label">Operação:</label>
            <div class="col-sm-3">
                <p class="form-control" name="tipoOperacao" id="tipoOperacao"></p>
            </div>

            <label class="col-sm-1 control-label">Moeda:</label>
            <div class="col-sm-1">
                <p class="form-control" name="tipoMoeda" id="tipoMoeda"></p>
            </div>

            <label class="col-sm-1 control-label">Valor:</label>
            <div class="col-sm-2">
                <p class="form-control mascaradinheiro" name="valorOperacao" id="valorOperacao"></p>
            </div>

            <div id="divDataPrevistaEmbarque" hidden>
                <label class="col-sm-1 control-label">Data de Embarque:</label>
                <div class="col-sm-2">
                    <p class="form-control" name="dataPrevistaEmbarque" id="dataPrevistaEmbarque"></p>
                </div>
            </div>
    
        </div>  <!--/form-group-->
<hr>

        <div class="page-bar">
                <h3>Check-list</h3>
        </div>

<br>


        <div class="form-group">

            <label class="col-sm-1 control-label">Data de Liquidação:</label>
            <div class="col-sm-2">
                <p class="form-control" name="dataLiquidacao" id="dataLiquidacao"></p>
            </div>

            <label class="col-sm-1 control-label">Número do Boleto:</label>
            <div class="col-sm-2">
                <p class="form-control" name="numeroBoleto" id="numeroBoleto"></p>
            </div>

            <label class="col-sm-1 control-label">Equivalência em Dolar:</label>
            <div class="col-sm-2">
                <p class="form-control mascaradinheiro" name="equivalenciaDolar" id="equivalenciaDolar"></p>
            </div>

            <label class="col-sm-1 control-label">Status:</label>
            <div class="col-sm-2">
                <p class="form-control overflow" name="statusGeral" id="statusGeral"></p>
            </div>

        </div>  <!--/form-group-->



        <div class="form-group padding015">
            <div class="col-sm-12 panel panel-default">
                <table class="table table-striped" id="contratos">
                <thead>
                    <tr>
                        <th class="col-sm">Ação</th>
                        <th class="col-sm">ID do Arquivo</th>
                        <th class="col-sm">Nome do Arquivo</th>
                        <th class="col-sm">Tipo de Arquivo</th>                          
                        <th class="col-sm">Data de Inclusão</th> 
                    </tr>

                </thead>

                <tbody>
                </tbody>
                
                </table>
            </div>
        </div>



        <!-- <div class="form-group">
            <div class="col-sm-2 col-md-6">
                <button type="submit" id="submitBtn" class="btn btn-primary btn-lg center">Gravar</button>
            </div>
        </div> -->

        <hr>

        <div class="page-bar">
            <h3>Histórico</h3>
        </div>
<br>

        <div class="form-group padding015">
            <div class="col-sm-12 panel panel-default">
                <table class="table table-striped dataTable" id="historico">
                <thead>
                    <tr>
                        <th class="col-sm-1">ID Hist.</th>
                        <th class="col-sm-1">Data</th> 
                        <th class="col-sm-1">Status</th>                         
                        <th class="col-sm-1 responsavel">Responsável</th> 
                        <th class="col-sm-1">Área</th>
                        <th class="col-sm-7">Mensagem</th>
                    </tr>
                </thead>
        
                <tbody>
                </tbody>
                
                </table>
            </div>
        </div>

    </div>

</div>  <!--panel-body-->

</div>  <!--panel panel-default-->

</div>  <!--container-fluid-->



@stop



@section('css')
    <link href="{{ asset('css/contratacao/cadastro.css') }}" rel="stylesheet">
     


@stop

@section('js')
    <script src="{{ asset('js/plugins/numeral/numeral.min.js') }}"></script>
    <script src="{{ asset('js/plugins/numeral/locales/pt-br.min.js') }}"></script>
    <script src="{{ asset('js/global/formata_tabela_historico.js') }}"></script>
    <script src="{{ asset('js/global/formata_tabela_documentos.js') }}"></script>
    <script src="{{ asset('js/global/anima_loading_submit.js') }}"></script>
    <script src="{{ asset('js/plugins/moment/moment-with-locales.min.js') }}"></script>
    <script src="{{ asset('js/global/formata_data.js') }}"></script>   <!--Função global que formata a data para valor humano br.-->
    <script src="{{ asset('js/global/formata_datatable.js') }}"></script>
    <script src="{{ asset('js/contratacao/post_verifica_assinatura.js') }}"></script>
@stop