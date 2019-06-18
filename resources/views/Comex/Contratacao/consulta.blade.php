@extends('adminlte::page')

@section('title', 'EsteiraComex - Análise Contratação')

@section('content_header')
    
    <h4 class="animated bounceInLeft">
        Esteira de Contratação | 
        <small>Contratação - Análise de demandas </small>
    </h4>
    
<!-- arrumar -->

    <ol class="breadcrumb"> 
            <li><a href="#"><i class="fa fa-dashboard"></i>Solicitar Atendimento </a></li>
            <li><a href="#"></i>Contratação</a></li>
    </ol>

@stop

@section('content')


                <!-- ########################################## CONTEÚDO ÚNICO ################################################ -->



<div class="container-fluid">

<div class="panel panel-default">

<div class="panel-body">


    <div class="page-bar">
        <h3>Contratação - Consulta de Demanda - Protocolo #  <p class="inline" name="id_demanda" id="idDemanda">546654</p></h3>
    </div>

<br>

    <form method="POST" action="" enctype="multipart/form-data" class="form-horizontal" id="formUploadComplemento">

        <div class="form-group">

            <label class="col-sm-1 control-label">CNPJ:</label>
            <div class="col-sm-2">
                <p class="form-control mascaracnpj" name="cnpj" id="cpfCnpj">10222222000188</p>
            </div>

            <label class="col-sm-1 control-label">Nome:</label>
            <div class="col-sm-4">
                <p class="form-control" name="nomeCliente" id="nomeCliente">empresa empresa empresa ltda</p>
            </div>
    
            <label class="col-sm-1 control-label">Agência:</label>
            <div class="col-sm-1">
                <p class="form-control" name="agResponsavel" id="agResponsavel">2728</p>
            </div>

            <label class="col-sm-1 control-label">SR:</label>
            <div class="col-sm-1">
                <p class="form-control" name="srResponsavel" id="srResponsavel">4040</p>
            </div>

        </div>  <!--/form-group-->


        <div class="form-group">

            <label class="col-sm-1 control-label">Operação:</label>
            <div class="col-sm-2">
                <p class="form-control" name="tipoOperacao" id="tipoOperacao">Pronto Importação</p>
            </div>

            <label class="col-sm-1 control-label">Moeda:</label>
            <div class="col-sm-1">
                <p class="form-control" name="tipoMoeda" id="tipoMoeda">USD</p>
            </div>

            <label class="col-sm-1 control-label">Valor:</label>
            <div class="col-sm-2">
                <p class="form-control" name="valorOperacao" id="valorOperacao">66.666,66</p>
            </div>
    
            <label class="col-sm-1 control-label">Data de Embarque:</label>
            <div class="col-sm-2">
                <p class="form-control" name="dataPrevistaEmbarque" id="dataPrevistaEmbarque">12/12/1212</p>
            </div>
    
        </div>  <!--/form-group-->

        <div class="form-group">

            <label class="col-sm-1 control-label">Dados do Beneficiário:</label>
            <div class="col-sm-3">
                <p class="form-control" name="dadosContaBeneficiario1" id="dadosContaBeneficiario1">Nome do Beneficiário</p>
            </div>
            <div class="col-sm-3">
                <p class="form-control" name="dadosContaBeneficiario2" id="dadosContaBeneficiario2">Banco Beneficiário</p>
            </div>
            <div class="col-sm-3">
                <p class="form-control" name="dadosContaBeneficiario3" id="dadosContaBeneficiario3">IBAN IBAN IBAN 00000</p>
            </div>
            <div class="col-sm-2">
                <p class="form-control" name="dadosContaBeneficiario4" id="dadosContaBeneficiario4">Conta</p>
            </div>
        </div>  <!--/form-row-->

    <hr>

        <div class="form-group">

            <label class="col-sm-1 control-label">Data de Liquidação:</label>
            <div class="col-sm-2">
                <p class="form-control" name="dataLiquidacao" id="dataLiquidacao">10/10/1010</p>
            </div>

            <label class="col-sm-1 control-label">Número do Boleto:</label>
            <div class="col-sm-2">
                <p class="form-control" name="numeroBoleto" id="numeroBoleto">10101010</p>
            </div>

            <label class="col-sm-1 control-label">Status:</label>
            <div class="col-sm-3">
                <p class="form-control" name="statusGeral" id="statusGeral">Inconforme</p>
            </div>

        </div>  <!--/form-group-->

    <hr>

        <div class="page-bar">
            <h3>Check-list</h3>
        </div>

        <div class="row">

<div class="col-md-6">

    <div class="form-group">
        <label class="col-md-3 control-label">Invoice:</label>
        <div class="col-md-3">
                <select class="form-control" name="statusInvoice" id="statusInvoice" disabled>
                    <option value="">Selecione</option>
                    <option value="Conforme" selected>Conforme</option>
                    <option value="Inconforme">Inconforme</option>
                    <option value="N/A">N/A</option>
                </select>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label">Conhecimento:</label>
        <div class="col-sm-3">
                <select class="form-control col-sm-3" name="statusConhecimento" id="statusConhecimento" disabled>
                    <option value="">Selecione</option>
                    <option value="Conforme">Conforme</option>
                    <option value="Inconforme" selected>Inconforme</option>
                    <option value="N/A">N/A</option>
                </select>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label">DI:</label>
        <div class="col-sm-3">
                <select class="form-control" name="statusDi" id="statusDi" disabled>
                    <option value="">Selecione</option>
                    <option value="Conforme" selected>Conforme</option>
                    <option value="Inconforme">Inconforme</option>
                    <option value="N/A">N/A</option>
                </select>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label">DU-E:</label>
        <div class="col-sm-3">
                <select class="form-control" name="statusDue" id="statusDue" disabled>
                    <option value="">Selecione</option>
                    <option value="Conforme" selected>Conforme</option>
                    <option value="Inconforme">Inconforme</option>
                    <option value="N/A">N/A</option>
                </select>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label">Dados Bancários:</label>
        <div class="col-sm-3">
                <select class="form-control" name="statusDadosBancarios" id="statusDadosBancarios" disabled>
                    <option value="">Selecione</option>
                    <option value="Conforme" selected>Conforme</option>
                    <option value="Inconforme">Inconforme</option>
                    <option value="N/A">N/A</option>
                </select>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label">Autorização SR:</label>
        <div class="col-sm-3">
                <select class="form-control" name="statusAutorizacaoSr" id="statusAutorizacaoSr" disabled>
                    <option value="">Selecione</option>
                    <option value="Conforme" selected>Conforme</option>
                    <option value="Inconforme">Inconforme</option>
                    <option value="N/A">N/A</option>
                </select>
        </div>
    </div>

</div>  <!--/col-md-6-->

<div class="col-md-6">
    <div class="form-group">
        <label class="col-sm-2 control-label">Observações:</label>
        <div class="col-sm-10">
            <textarea class="form-control" rows="10" name="observacoesCeopc" id="observacoesCeopc">Justificativa do analista aqui.</textarea>
        </div>
    </div>
</div>  <!--/col-md-6-->

</div> <!--/row-->

<hr>

        <div class="page-bar">
            <h3>Histórico</h3>
        </div>

        <div class="form-group">
            <div class="col-sm-12">
                <p class="form-control" id="historico">c142765 - Status: Inconforme - 14/06 - Observação: Campo X do documento Y inconforme.</p>
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