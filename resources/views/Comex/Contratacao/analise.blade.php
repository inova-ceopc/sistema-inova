@extends('adminlte::page')

@section('title', 'EsteiraComex - Análise Contratação')

@section('content_header')
    
<div class="panel-body padding015">
    <h4 class="animated bounceInLeft pull-left">
        Esteira de Contratação | 
        <small>Contratação - Análise de demandas </small>
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
        <h3>Contratação - Análise de Demanda - Protocolo #  <p class="inline" name="idDemanda"></p>{{ $demanda }}</h3>
        <input type="text" id="idDemanda" value="{{ $demanda }}" hidden disabled>
    </div>

<br>

    <form method="put" action="" enctype="multipart/form-data" class="form-horizontal" id="formAnaliseDemanda">
    
    {{ csrf_field() }}
    
        <div class="form-group">

            <label class="col-sm-1 control-label">CPF/CNPJ:</label>
            <div class="col-sm-2">
                <p class="form-control mascaracnpj" name="cpfCnpj" id="cpfCnpj"></p>
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
    
            <label class="col-sm-1 control-label">Data de Embarque:</label>
            <div class="col-sm-2">
                <p class="form-control" name="dataPrevistaEmbarque" id="dataPrevistaEmbarque"></p>
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

            <label class="col-sm-1 control-label">Data de Liquidação:</label>
            <div class="col-sm-2">
                <input class="form-control" name="dataLiquidacao" id="dataLiquidacao" type="text" required>
            </div>

            <label class="col-sm-1 control-label">Número do Boleto:</label>
            <div class="col-sm-2">
                <input class="form-control" name="numeroBoleto" id="numeroBoleto" type="number" required>
            </div>

            <label class="col-sm-1 control-label">Status:</label>
            <div class="col-sm-3">
                    <select class="form-control" name="statusGeral" id="statusGeral" required>
                        <option value="DISTRIBUIDA">Selecione</option>
                        <option value="INCONFORME">Inconforme</option>
                        <option value="CONFORME">Conforme</option>
                        <option value="CONTA_OK">Conta OK</option>
                        <option value="CONFERIDO">Conferido</option>
                        <option value="CANCELAR">Cancelar</option>
                    </select>
            </div>

        </div>  <!--/form-group-->

    <hr>

        <div class="page-bar">
            <h3>Check-list</h3>
        </div>

        <div class="row">

        <div class="col-md-5">

            <div class="form-group" id="divINVOICE" hidden>
                <label class="col-sm-4 control-label">Invoice:</label>
                <div class="col-sm-4">
                        <select class="form-control" name="statusInvoice" id="INVOICE">
                            <option value="PENDENTE" >Selecione</option>
                            <option value="CONFORME">Conforme</option>
                            <option value="INCONFORME">Inconforme</option>
                            <option value="N/A">N/A</option>
                        </select>
                </div>
            </div>

            <div class="form-group" id="divCONHECIMENTO_EMBARQUE" hidden>
                <label class="col-sm-4 control-label">Conhecimento:</label>
                <div class="col-sm-4">
                        <select class="form-control" name="statusConhecimento" id="CONHECIMENTO_EMBARQUE">
                            <option value="PENDENTE" >Selecione</option>
                            <option value="CONFORME">Conforme</option>
                            <option value="INCONFORME">Inconforme</option>
                            <option value="N/A">N/A</option>
                        </select>
                </div>
            </div>

            <div class="form-group" id="divDI" hidden>
                <label class="col-sm-4 control-label">DI:</label>
                <div class="col-sm-4">
                        <select class="form-control" name="statusDi" id="DI">
                            <option value="PENDENTE" >Selecione</option>
                            <option value="CONFORME">Conforme</option>
                            <option value="INCONFORME">Inconforme</option>
                            <option value="N/A">N/A</option>
                        </select>
                </div>
            </div>

            <div class="form-group" id="divDUE" hidden>
                <label class="col-sm-4 control-label">DU-E:</label>
                <div class="col-sm-4">
                        <select class="form-control" name="statusDue" id="DUE">
                            <option value="PENDENTE" >Selecione</option>
                            <option value="CONFORME">Conforme</option>
                            <option value="INCONFORME">Inconforme</option>
                            <option value="N/A">N/A</option>
                        </select>
                </div>
            </div>

            <div class="form-group" id="divDADOS_BANCARIOS" hidden>
                <label class="col-sm-4 control-label">Dados Bancários:</label>
                <div class="col-sm-4">
                        <select class="form-control" name="statusDadosBancarios" id="DADOS_BANCARIOS">
                            <option value="PENDENTE" >Selecione</option>
                            <option value="CONFORME">Conforme</option>
                            <option value="INCONFORME">Inconforme</option>
                            <option value="N/A">N/A</option>
                        </select>
                </div>
            </div>

            <div class="form-group" id="divAUTORIZACAO_SR" hidden>
                <label class="col-sm-4 control-label">Autorização SR:</label>
                <div class="col-sm-4">
                        <select class="form-control" name="statusAutorizacaoSr" id="AUTORIZACAO_SR" required>
                            <option value="PENDENTE" >Selecione</option>
                            <option value="CONFORME">Conforme</option>
                            <option value="INCONFORME">Inconforme</option>
                            <option value="N/A">N/A</option>
                        </select>
                </div>
            </div>

        </div>  <!--/col-md-6-->

        <div class="col-md-7">
            <div class="form-group">
                <label class="col-sm-2 control-label">Observações:</label>
                <div class="col-sm-10">
                    <textarea class="form-control" rows="13" name="observacoesCeopc" id="observacoesCeopc" placeholder="Preencha informações complementares."></textarea>
                </div>
            </div>
        </div>  <!--/col-md-6-->

        </div> <!--/row-->

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

    
    <hr>

        <div class="page-bar">
            <h3>Documentação digitalizada</h3>
        </div>
<br>

    <div id="divModais">

    </div>

<hr>

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
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link href="{{ asset('css/contratacao/cadastro.css') }}" rel="stylesheet">
     
@stop

@section('js')
    <!-- <script src="{{ asset('js/plugins/jquery/jquery-1.12.1.min.js') }}"></script> -->
    <!-- <script src="{{ asset('js/contratacao/jquery-3.4.1.min.js') }}"></script> -->
    <script src="{{ asset('js/plugins/jquery/jquery-ui.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="{{ asset('js/plugins/numeral/numeral.min.js') }}"></script>
    <script src="{{ asset('js/contratacao/post_analise_demanda3.js') }}"></script>

@stop