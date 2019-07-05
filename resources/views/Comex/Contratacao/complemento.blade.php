@extends('adminlte::page')

@section('title', 'EsteiraComex - Análise Contratação')

@section('content_header')
    
<div class="panel-body padding015">
    <h4 class="animated bounceInLeft pull-left">
        Esteira de Contratação | 
        <small>Contratação - Complemento de demandas </small>
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
    
            <label class="col-sm-1 control-label">Data de Embarque:</label>
            <div class="col-sm-2">
                <p class="form-control" name="dataPrevistaEmbarque" id="dataPrevistaEmbarque"></p>
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

            <div class="col-md-7">
                <div class="form-group">
                    <label class="col-sm-2 control-label">Observações:</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" rows="13" name="observacoesCeopc" id="observacoesCeopc" placeholder="Preencha informações complementares."></textarea>
                    </div>
                </div>
            </div>  <!--/col-md-7-->

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
                <h3>Digitalizar complemento</h3>
        </div>


<br>
    <div class="page-bar">

        <div class="form-group row" id="divInvoice" hidden>
            <div class="col-sm-4">
                <p class="form-control">Invoice</p>
            </div>
            <div class="col-sm-7">
                <div class="input-group">
                    <label class="input-group-btn">
                        <span class="btn btn-primary">
                        <i class="fa fa-lg fa-cloud-upload"></i>
                        Carregar arquivo&hellip; 
                        <input type="file" accept=".pdf,.jpg,.jpeg,.png" style="display: none;" name="uploadInvoice[]" id="uploadInvoice" multiple>
                        </span>
                    </label>
                    <input type="text" class="form-control" readonly>
                </div>  <!--/col-->
            </div>  <!--/col-->
        </div><!--/form-group-->

        <div class="form-group row" id="divConhecimento" hidden>
            <div class="col-sm-4">
                <p class="form-control">Conhecimento de Embarque</p>
            </div>
            <div class="col-sm-7">
                <div class="input-group">
                    <label class="input-group-btn">
                        <span class="btn btn-primary">
                        <i class="fa fa-lg fa-cloud-upload"></i>
                        Carregar arquivo&hellip; 
                        <input type="file" accept=".pdf,.jpg,.jpeg,.png" style="display: none;" name="uploadConhecimento[]" id="uploadConhecimento" multiple>
                        </span>
                    </label>
                    <input type="text" class="form-control" readonly>
                </div>  <!--/col-->
            </div>  <!--/col-->
        </div><!--/form-group-->

        <div class="form-group row" id="divDi" hidden>
            <div class="col-sm-4">
                <p class="form-control">Declaração de Importação (DI)</p>
            </div>
            <div class="col-sm-7">
                <div class="input-group">
                    <label class="input-group-btn">
                        <span class="btn btn-primary">
                        <i class="fa fa-lg fa-cloud-upload"></i>
                        Carregar arquivo&hellip; 
                        <input type="file" accept=".pdf,.jpg,.jpeg,.png" style="display: none;" name="uploadDi[]" id="uploadDi" multiple>
                        </span>
                    </label>
                    <input type="text" class="form-control" readonly>
                </div>  <!--/col-->
            </div>  <!--/col-->
        </div><!--/form-group-->

        <div class="form-group row" id="divDue" hidden>
            <div class="col-sm-4">
                <p class="form-control">Declaração Única de Exportação (DU-E)</p>
            </div>
            <div class="col-sm-7">
                <div class="input-group">
                    <label class="input-group-btn">
                        <span class="btn btn-primary">
                        <i class="fa fa-lg fa-cloud-upload"></i>
                        Carregar arquivo&hellip; 
                        <input type="file" accept=".pdf,.jpg,.jpeg,.png" style="display: none;" name="uploadDue[]" id="uploadDue" multiple>
                        </span>
                    </label>
                    <input type="text" class="form-control" readonly>
                </div>  <!--/col-->
            </div>  <!--/col-->
        </div><!--/form-group-->

        <div class="form-group row" id="divDados" hidden>
            <div class="col-sm-4">
                <p class="form-control">Dados bancários</p>
            </div>
            <div class="col-sm-7">
                <div class="input-group">
                    <label class="input-group-btn">
                        <span class="btn btn-primary">
                        <i class="fa fa-lg fa-cloud-upload"></i>
                        Carregar arquivo&hellip; 
                        <input type="file" accept=".pdf,.jpg,.jpeg,.png" style="display: none;" name="uploadDadosBancarios[]" id="uploadDadosBancarios" multiple>
                        </span>
                    </label>
                    <input type="text" class="form-control" readonly>
                </div>  <!--/col-->
            </div>  <!--/col-->
        </div><!--/form-group-->

        <div class="form-group row" id="divAutorizacao" hidden>
            <div class="col-sm-4">
                <p class="form-control">Autorização SR</p>
            </div>
            <div class="col-sm-7">
                <div class="input-group">
                    <label class="input-group-btn">
                        <span class="btn btn-primary">
                        <i class="fa fa-lg fa-cloud-upload"></i>
                        Carregar arquivo&hellip; 
                        <input type="file" accept=".pdf,.jpg,.jpeg,.png" style="display: none;" name="uploadAutorizacaoSr[]" id="uploadAutorizacaoSr" multiple>
                        </span>
                    </label>
                    <input type="text" class="form-control" readonly>
                </div>  <!--/col-->
            </div>  <!--/col-->
        </div><!--/form-group-->

    </div><!--/form-group-->

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
    <script src="{{ asset('js/contratacao/post_upload_complemento.js') }}"></script>









@stop