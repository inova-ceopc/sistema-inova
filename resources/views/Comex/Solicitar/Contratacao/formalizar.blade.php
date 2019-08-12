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
<input id="unidade" hidden value="{{session()->get('codigoLotacaoAdministrativa')}}">


<div class="container-fluid">

<div class="panel panel-default">

<div class="panel-body">


    <div class="page-bar">
        <h3>Contratação - Formalização de Contrato - Protocolo # <p class="inline" name="idDemanda"></p>{{ $demanda }}</h3>
        <input type="text" id="idDemanda" value="{{ $demanda }}" hidden disabled>
    </div>

<br>
         <!-- /esteiracomex/contratacao/complemento/{{ $demanda }} -->
    <form method="POST" action="/esteiracomex/contratacao/formalizar" enctype="multipart/form-data" class="form-horizontal" id="formUploadFormaliza">
    
    {{ csrf_field() }}
        <input type="text" name="idDemanda" value="{{ $demanda }}" hidden>

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

        <div id="divHideDadosBancarios" hidden>

<hr>
            <div class="page-bar">
                <h3 class="box-title">Dados Bancários do Beneficiário no Exterior</h3>
            </div>


<br>

            <div class="form-group">  
                <label class="col-sm-2 control-label">Nome Completo / Razão Social:</label>
                <div class="col-sm-4">
                    <p class="form-control" id="nomeBeneficiario" name="nomeBeneficiario"></p>
                </div>
            </div>

            <div class="form-group">  

                <label class="col-sm-2 control-label">Endereço Completo:</label>
                <div class="col-sm-4">
                    <p class="form-control" id="enderecoBeneficiario" name="enderecoBeneficiario"></p>
                </div>

                <label class="col-sm-1 control-label">Cidade:</label>
                <div class="col-sm-2">
                    <p class="form-control" id="cidadeBeneficiario" name="cidadeBeneficiario"></p>
                </div>

                <label class="col-sm-1 control-label">País:</label>
                <div class="col-sm-2">
                    <p class="form-control" id="paisBeneficiario" name="paisBeneficiario"></p>
                </div>

            </div>  

            <div class="form-group">

                <label class="col-sm-2 control-label">Nome do Banco Beneficiário no Exterior:</label>
                <div class="col-sm-4">
                    <p class="form-control iban" id="nomeBancoBeneficiario" name="nomeBancoBeneficiario"></p>
                </div>

                <label class="col-sm-2 control-label">Código SWIFT ou ABA:</label>
                <div class="col-sm-4">
                    <p class="form-control iban" id="swiftAbaBancoBeneficiario" name="swiftAbaBancoBeneficiario"></p>
                    <div id="retorno"></div>
                </div>

            </div>

            <div class="form-group">
                
                <label class="col-sm-2 control-label">Código IBAN no Banco Beneficiário:</label>
                <div class="col-sm-4">
                    <p type="text" class="form-control" id="ibanBancoBeneficiario" name="ibanBancoBeneficiario"></p>
                    <div id="results"></div>
                </div>

                <label class="col-sm-2 control-label">Conta no Banco Beneficiário <small>(Caso não possua o IBAN)</small>:</label>
                <div class="col-sm-4">
                    <p class="form-control" id="numeroContaBeneficiario" name="numeroContaBeneficiario"></p>
                </div>

            </div>

            <div id="divHideDadosIntermediario" hidden>

                <h4 class="panel-title">
                    Dados do Banco Intermediário 
                </h4>
                <br>
                <div class="form-group">

                    <label class="col-sm-2 control-label">Nome do Banco Intermediário:</label>
                    <div class="col-sm-4">
                        <p class="form-control iban" id="nomeBancoIntermediario" name="nomeBancoIntermediario"></p>
                    </div>

                    <label class="col-sm-2 control-label">Código SWIFT ou ABA:</label>
                    <div class="col-sm-4">
                        <p class="form-control iban" id="swiftAbaBancoIntermediario" name="swiftAbaBancoIntermediario"></p>
                        <div id="retornoInte"></div>
                    </div>

                </div>

                <div class="form-group"> 

                    <label class="col-sm-2 control-label">Código IBAN no banco Intermediário:</label>
                        <div class="col-sm-4">
                            <p class="form-control iban" id="ibanBancoIntermediario" name="ibanBancoIntermediario"></p>
                            <div id="spanIbanIntermediario"></div>
                        </div>

                    <label class="col-sm-2 control-label">Conta no Banco Intermediário <small>(Caso não possua o IBAN)</small>:</label>
                        <div class="col-sm-4">
                            <p class="form-control iban" id="contaBancoIntermediario" name="contaBancoIntermediario"></p>
                        </div>

                </div>
                
            </div>   <!-- divHideDadosIntermediario hidden-->

        </div>       <!-- divHideDadosBancarios hidden-->

<hr>

        <div class="page-bar">
                <h3>Digitalizar contrato</h3>
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
                <p class="form-control" name="statusGeral" id="statusGeral"></p>
            </div>

        </div>  <!--/form-group-->


    <div class="form-group row">

        <label class="col-sm-2 control-label">Número do Contrato:</label>
        <div class="col-sm-3">
            <input type="text" class="form-control" id="numeroContrato" name="numeroContrato" required>
        </div>

        <label class="col-sm-2 control-label">Contrato de Câmbio:</label>
        <div class="col-sm-5">
            <div class="input-group">
                <label class="input-group-btn">
                    <span class="btn btn-primary front">
                    <i class="fa fa-lg fa-cloud-upload"></i>
                    Carregar arquivo&hellip; 
                    </span>
                    <input type="file" class="behind" accept=".pdf" name="uploadContrato[]" id="uploadContrato" required>
                </label>
                <input type="text" class="form-control previewNomeArquivo" readonly>
            </div>  <!--/col-->
        </div>  <!--/col-->

    </div><!--/form-group row-->

    <div class="form-group row">

        <label class="col-sm-2 control-label">Tipo de Contrato:</label>
        <div class="col-sm-3">
            <select class="form-control" id="tipoContrato" name="tipoContrato" required>
                <option value="">Selecione</option>
                <option value="PRINCIPAL">Principal</option>
                <option value="ALTERACAO">Alteração</option>
                <option value="CANCELAMENTO">Cancelamento</option>
            </select>
        </div>

        <div id="divRadioRetorno" hidden>
            <label class="col-sm-2 control-label">Tem retorno:</label>
            <div class="col-sm-3">
                <input type="radio" class="radio-inline temRetornoRede" id="temRetornoRedeSim" name="temRetornoRede" value="SIM"> <span class="margin10"> Sim </span>
                <input type="radio" class="radio-inline temRetornoRede" id="temRetornoRedeNao" name="temRetornoRede" value="NAO"> <span class="margin10"> Não </span>
            </div>
        </div>

    </div><!--/form-group row-->

    <div class="form-group">
        <div class="col-sm-2 col-md-6">
            <button type="submit" id="submitBtn" class="btn btn-primary btn-lg center">Gravar</button>
        </div>
    </div>

        <hr>

    <div class="page-bar">
        <h3>Histórico</h3>
    </div>
<br>

    <div class="form-group padding015">
        <div class="col-sm-12 panel panel-default">
            <table class="table table-striped" id="historico">
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
    <script src="{{ asset('js/global/formata_tabela_historico.js') }}"></script>
    <script src="{{ asset('js/global/anima_loading_submit.js') }}"></script>
    <script src="{{ asset('js/global/anima_input_file.js') }}"></script>
    <script src="{{ asset('js/plugins/moment/moment-with-locales.min.js') }}"></script>
    <script src="{{ asset('js/global/formata_data.js') }}"></script>   <!--Função global que formata a data para valor humano br.-->
    <script src="{{ asset('js/contratacao/post_formaliza_contrato.js') }}"></script>
@stop