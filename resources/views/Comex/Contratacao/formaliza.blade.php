@extends('adminlte::page')

@section('title', 'EsteiraComex - Análise Contratação')

@section('content_header')
    
<div class="panel-body padding015">
    <h4 class="animated bounceInLeft pull-left">
        Esteira de Contratação | 
        <small>Contratação - Formalização de Contrato </small>
    </h4>

    <ol class="breadcrumb pull-right"> 
            <li><a href="/esteiracomex"><i class="fa fa-map-signs"></i>Solicitar Atendimento </a></li>
            <li><a href=""></i>Contratação</a></li>
    </ol>
</div>

@stop

@section('content')


                <!-- ########################################## CONTEÚDO ÚNICO ################################################ -->



<div class="container-fluid">

<div class="panel panel-default">

<div class="panel-body">


    <div class="page-bar">
        <h3>Contratação - Formalização de Contrato - Protocolo # <p class="inline" name="idDemanda"></p>{{ $demanda }}</h3>
        <input type="text" id="idDemanda" value="{{ $demanda }}" hidden disabled>
    </div>

<br>
         <!-- /esteiracomex/contratacao/complemento/{{ $demanda }} -->
    <form method="POST" action="" enctype="multipart/form-data" class="form-horizontal" id="formUploadComplemento">
    
    {{ method_field('PUT') }}
    
    {{ csrf_field() }}

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
                <p class="form-control" name="valorOperacao" id="valorOperacao"></p>
            </div>

            <div id="divDataPrevistaEmbarque" hidden>
                <label class="col-sm-1 control-label">Data de Embarque:</label>
                <div class="col-sm-2">
                    <p class="form-control" name="dataPrevistaEmbarque" id="dataPrevistaEmbarque"></p>
                </div>
            </div>
    
        </div>  <!--/form-group-->

        <div class="form-group" id="groupIban" hidden>

            <label class="col-sm-1 control-label">Dados do Beneficiário:</label>
            <div class="col-sm-3">
                <input class="form-control iban" id="iban1" name="nomeBeneficiario" placeholder="Nome do Beneficiário" type="text">
            </div>
            <div class="col-sm-3">
                <input class="form-control iban" id="iban2" name="nomeBanco" placeholder="Nome do Banco Beneficiário" type="text">
            </div>
            <div class="col-sm-3">
                <input class="form-control iban" id="iban3" name="iban" placeholder="IBAN" type="text">
            </div>
            <div class="col-sm-2">
                <input class="form-control iban" id="iban4" name="agContaBeneficiario" placeholder="Conta" type="text">
            </div>
        </div>  <!--/form-row-->

    <hr>

        <div class="form-group">

            <label class="col-sm-2 control-label">Data de Liquidação:</label>
            <div class="col-sm-2">
                <p class="form-control" name="dataLiquidacao" id="dataLiquidacao"></p>
            </div>

            <label class="col-sm-2 control-label">Número do Boleto:</label>
            <div class="col-sm-2">
                <p class="form-control" name="numeroBoleto" id="numeroBoleto"></p>
            </div>

            <label class="col-sm-1 control-label">Status:</label>
            <div class="col-sm-3">
                <p class="form-control" name="statusGeral" id="statusGeral"></p>
            </div>

        </div>  <!--/form-group-->

    <hr>




        <div class="page-bar">
                <h3>Digitalizar contrato</h3>
        </div>


<br>
    <div class="page-bar">

        <div class="form-group row" id="divContratoUpload">
            <div class="col-sm-2">
                <p class="form-control">Contrato de Câmbio</p>
            </div>
            <div class="col-sm-5">
                <div class="input-group">
                    <label class="input-group-btn">
                        <span class="btn btn-primary">
                        <i class="fa fa-lg fa-cloud-upload"></i>
                        Carregar arquivo&hellip; 
                        <input type="file" accept=".pdf" style="display: none;" name="uploadInvoice[]" multiple>
                        </span>
                    </label>
                    <input type="text" class="form-control" readonly>
                </div>  <!--/col-->
            </div>  <!--/col-->
        </div><!--/form-group-->

    </div><!--/form-group-->


        <hr>

    <div class="page-bar">
            <h3>Histórico</h3>
        </div>

        <div class="form-group padding015">
            <div class="col-sm-12 panel panel-default">
                <table class="table table-striped" id="historico">
                <thead>
                    <tr>
                        <th class="col-sm-1">ID Hist.</th>
                        <th class="col-sm-1">Data</th> 
                        <th class="col-sm-1">Status</th>                         
                        <th class="col-sm-1">Responsável</th> 
                        <th class="col-sm-1">Área</th>
                        <th class="col-sm-7">Mensagem</th>
                    </tr>

                </thead>
        
                <tbody>
                </tbody>
                
                </table>
            </div>
        </div>

        
            <br>

        <div class="form-group row">
            <div class="col-sm-1">
            <button type="submit" id="submitBtn" class="btn btn-primary">Gravar</button>
            </div>
        </div>


    </form>

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
    <script src="{{ asset('js/contratacao/post_envio_contrato.js') }}"></script>









@stop