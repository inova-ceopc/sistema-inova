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
        <div id="msgmCancelamento"></div>
        <h3>Contratação - Consulta de Demanda - Protocolo # <p class="inline" name="idDemanda"></p>{{ $demanda }}</h3>
        <input type="text" id="idDemanda" value="{{ $demanda }}" hidden disabled>
    </div>

    <!-- CADASTRADA -->
    <div id="animacaoBarraDeProgresso">
        <div class="progress skill-bar">
            <div id='progressBar' class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="" aria-valuemin="0" aria-valuemax="100" >
                <span class="skill"><i class="val"><i class="fa fa-handshake-o fa-2x"></i></i></span>
            </div>
        </div>
        
        <div class="form-group">
            <div class="centerh" >
                <hr class="pontilhado3">
            </div>
            <div class="righth">
                <div class="width12 inline  righth"> <span class="dot"> </span> </div>
                <div class="width12 inline  righth"> <span class="dot"> </span> </div>
                <div class="width12 inline  righth"> <span class="dot"> </span> </div>
                <div class="width12 inline  righth"> <span class="dot"> </span> </div>
                <div class="width12 inline  righth"> <span class="dot"> </span> </div>
                <div class="width12 inline  righth"> <span class="dot"> </span> </div>
                <div class="width12 inline  righth"> <span class="dot"> </span> </div>
                <div class="width12 inline  righth"> <span class="dot"> </span> </div>
            </div>

            <div class="righth">
                <div class="width12 inline righth">
                    <div class="box2 sb10 overflow margin1rem border-default" id="Cadastrada">Cadastrada</div>
                </div>
                <div class="width12 inline righth">
                    <div class="box2 sb10 overflow margin1rem border-default" id="emAnalise">Em Análise</div>
                </div>
                <div class="width12 inline righth">
                    <div class="box2 sb10 overflow margin1rem border-default" id="Inconforme">Inconforme</div>
                </div>
                <div class="width12 inline righth">
                    <div class="box2 sb10 overflow margin1rem border-default" id="Conforme">Conforme</div>
                </div>
                <div class="width12 inline righth">
                    <div class="box2 sb10 overflow margin1rem border-default" id="Enviado">Contr. Enviado</div>
                </div>
                <div class="width12 inline righth">
                    <div class="box2 sb10 overflow margin1rem border-default" id="Pendente">Contr. Pendente</div>
                </div>
                <div class="width12 inline righth">
                    <div class="box2 sb10 overflow margin1rem border-default" id="Assinado">Contr. Assinado</div>
                </div>
                <div class="width12 inline righth">
                    <div class="box2 sb10 overflow margin1rem border-default" id="Liquidada">Liquidada</div>
                </div>
            </div>
        </div>
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
                <p class="form-control mascaradinheiro" name="valorOperacao" id="valorOperacao"></p>
            </div>

            <div id="divDataPrevistaEmbarque" hidden>
                <label class="col-sm-1 control-label">Data de Embarque:</label>
                <div class="col-sm-2">
                    <p class="form-control" name="dataPrevistaEmbarque" id="dataPrevistaEmbarque"></p>
                </div>
            </div>
    
        </div>  <!--/form-group-->

        <!-- <div id="divHideDadosBancarios" hidden>
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
            
            </div>   

        </div>       -->

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
<br>

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

                <div class="form-group" id="divCONHECIMENTO_DE_EMBARQUE" hidden>
                    <label class="col-sm-4 control-label">Conhecimento:</label>
                    <div class="col-sm-4">
                            <select class="form-control col-sm-3" name="statusConhecimento" id="CONHECIMENTO_DE_EMBARQUE" disabled>
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

                <div class="form-group" id="divDADOS_CONTA_DO_BENEFICIARIO" hidden>
                    <label class="col-sm-4 control-label">Dados Bancários:</label>
                    <div class="col-sm-4">
                        <select class="form-control" name="statusDadosBancarios" id="DADOS_CONTA_DO_BENEFICIARIO" disabled>
                            <option value= null >Selecione</option>
                            <option value="CONFORME">Conforme</option>
                            <option value="INCONFORME">Inconforme</option>
                            <option value="N/A">N/A</option>
                            <option value="PENDENTE">Pendente</option>
                        </select>
                    </div>
                </div>

                <div class="form-group" id="divDOCUMENTOS_DIVERSOS" hidden>
                    <label class="col-sm-4 control-label">Outros Documentos:</label>
                    <div class="col-sm-4">
                            <select class="form-control" name="statusDocumentosDiversos" id="DOCUMENTOS_DIVERSOS" disabled>
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

        <!-- <div id="divModais">

        </div> -->

        <div class="form-group padding015">
            <div class="col-sm panel panel-default">
                <table class="table table-striped" id="documentacao">
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




<hr>

        <div class="page-bar">
            <h3>Histórico</h3>
        </div>

<br>

        <div class="form-group padding015">
            <div class="col-sm panel panel-default">
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
    <script src="{{ asset('js/plugins/masks/jquery.mask.min.js') }}"></script>
    <script src="{{ asset('js/global/anima_progress_bar.js') }}"></script>
    <script src="{{ asset('js/global/formata_tabela_historico.js') }}"></script>
    <script src="{{ asset('js/global/formata_tabela_documentos.js') }}"></script>
    <script src="{{ asset('js/plugins/moment/moment-with-locales.min.js') }}"></script>
    <script src="{{ asset('js/global/formata_data.js') }}"></script>   <!--Função global que formata a data para valor humano br.-->
    <script src="{{ asset('js/global/formata_datatable.js') }}"></script>
    <script src="{{ asset('js/contratacao/consulta_demanda_contratacao.js') }}"></script>
@stop