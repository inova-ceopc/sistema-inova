@extends('adminlte::page')

@section('title', 'EsteiraComex - Análise Contratação')

@section('content_header')
    
<div class="panel-body padding015">
    <h4 class="animated bounceInLeft pull-left">
        Esteira de Contratação | 
        <small>Contratação - Consulta de demandas </small>
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

    @if (session('complementoConcluido'))
    <div class="box box-solid box-success">
            <div class="box-header">
                <h3 class="box-title"><strong>{{ session('complementoConcluido') }} | corrigido!</strong> </h3>
            </div><!-- /.box-header -->
            <div class="box-body">
                A demanda foi devolvida para tratamento com sucesso. Aguarde a conformidade.<a href="/esteiracomex/distribuir/demandas" class="alert-link">  <strong>clique aqui</strong></a>
            </div><!-- /.box-body -->
    </div>
    @endif
    @if (session('complementoAcessoNegado'))
    <div class="box box-solid box-warning">
            <div class="box-header">
                <h3 class="box-title"><strong>{{ session('complementoAcessoNegado') }} | não pode ser modificado!</strong> </h3>
            </div><!-- /.box-header -->
            <div class="box-body">
                A demanda ainda está em tratamento. Aguarde a finalização da análise.
            </div><!-- /.box-body -->
    </div>
    @endif

    <div class="page-bar">
        <h3>Contratação - Consulta de Demanda - Protocolo # <p class="inline" name="idDemanda"></p>{{ $demanda }}</h3>
        <input type="text" id="idDemanda" value="{{ $demanda }}" hidden disabled>
    </div>

<br>

    <form method="put" action="" enctype="multipart/form-data" class="form-horizontal" id="formUploadComplemento">
    
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
                <p class="form-control" name="nomeBeneficiario" id="iban1"></p>
            </div>
            <div class="col-sm-3">
                <p class="form-control" name="nomeBanco" id="iban2"></p>
            </div>
            <div class="col-sm-3">
                <p class="form-control" name="iban" id="iban3"></p>
            </div>
            <div class="col-sm-2">
                <p class="form-control" name="agContaBeneficiario" id="iban4"></p>
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


        <div class="page-bar">
            <h3>Check-list</h3>
        </div>

        <div class="row">

            <div class="col-md-5">

                <div class="form-group" id="divINVOICE" hidden>
                    <label class="col-md-4 control-label">Invoice:</label>
                    <div class="col-md-4">
                            <select class="form-control" name="statusInvoice" id="INVOICE" disabled>
                                <option value= null >Selecione</option>
                                <option value="CONFORME">Conforme</option>
                                <option value="INCONFORME">Inconforme</option>
                                <option value="N/A">N/A</option>
                                <option value="PENDENTE">Pendente</option>
                            </select>
                    </div>
                </div>

                <div class="form-group" id="divCONHECIMENTO_EMBARQUE" hidden>
                    <label class="col-sm-4 control-label">Conhecimento:</label>
                    <div class="col-sm-4">
                            <select class="form-control col-sm-3" name="statusConhecimento" id="CONHECIMENTO_EMBARQUE" disabled>
                                <option value= null >Selecione</option>
                                <option value="CONFORME">Conforme</option>
                                <option value="INCONFORME">Inconforme</option>
                                <option value="N/A">N/A</option>
                                <option value="PENDENTE">Pendente</option>
                            </select>
                    </div>
                </div>

                <div class="form-group" id="divDI" hidden>
                    <label class="col-sm-4 control-label">DI:</label>
                    <div class="col-sm-4">
                            <select class="form-control" name="statusDi" id="DI" disabled>
                                <option value= null >Selecione</option>
                                <option value="CONFORME">Conforme</option>
                                <option value="INCONFORME">Inconforme</option>
                                <option value="N/A">N/A</option>
                                <option value="PENDENTE">Pendente</option>
                            </select>
                    </div>
                </div>

                <div class="form-group" id="divDUE" hidden>
                    <label class="col-sm-4 control-label">DU-E:</label>
                    <div class="col-sm-4">
                            <select class="form-control" name="statusDue" id="DUE" disabled>
                                <option value= null >Selecione</option>
                                <option value="CONFORME">Conforme</option>
                                <option value="INCONFORME">Inconforme</option>
                                <option value="N/A">N/A</option>
                                <option value="PENDENTE">Pendente</option>
                            </select>
                    </div>
                </div>

                <div class="form-group" id="divDADOS_BANCARIOS" hidden>
                    <label class="col-sm-4 control-label">Dados Bancários:</label>
                    <div class="col-sm-4">
                            <select class="form-control" name="statusDadosBancarios" id="DADOS_BANCARIOS" disabled>
                                <option value= null >Selecione</option>
                                <option value="CONFORME">Conforme</option>
                                <option value="INCONFORME">Inconforme</option>
                                <option value="N/A">N/A</option>
                                <option value="PENDENTE">Pendente</option>
                            </select>
                    </div>
                </div>

                <div class="form-group" id="divAUTORIZACAO_SR" hidden>
                    <label class="col-sm-4 control-label">Autorização SR:</label>
                    <div class="col-sm-4">
                            <select class="form-control" name="statusAutorizacaoSr" id="AUTORIZACAO_SR" disabled>
                                <option value= null >Selecione</option>
                                <option value="CONFORME">Conforme</option>
                                <option value="INCONFORME">Inconforme</option>
                                <option value="N/A">N/A</option>
                                <option value="PENDENTE">Pendente</option>
                            </select>
                    </div>
                </div>

            </div>  <!--/col-md-5-->


        </div> <!--/row-->

<hr>


        <div class="page-bar">
            <h3>Documentação digitalizada</h3>
        </div>
        <br>

        <div id="divModais">

        </div>

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
                        <th class="col-sm-1">Área</th>
                        <th class="col-sm-7">Mensagem</th>
                    </tr>

                </thead>
        
                <tbody>
                </tbody>
                
                </table>
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
    <script src="{{ asset('js/contratacao/consulta_demanda_contratacao.js') }}"></script>









@stop