
@extends('adminlte::page')

@section('title', 'EsteiraComex - Solicitar Contratação')

@section('content_header')
    
<div class="panel-body padding015">
    <h4 class="animated bounceInLeft pull-left">
        Esteira de Contratação de Câmbio Pronto | 
        <small>Cadastrar nova demanda</small>
    </h4>
    
    <ol class="breadcrumb pull-right">
            <li><a href="/esteiracomex"><i class="fa fa-map-signs"></i>Solicitar Atendimento </a></li>
            <li><a href="/esteiracomex/contratacao"></i>Contratação</a></li>
    </ol>
</div>

@stop

@section('content')


<div class="container-fluid">
    <div class="panel panel-default box box-primary">
        <div class="panel-body  with-border">

            @if (session('tituloMensagem'))
            <div class="box box-solid box-{{ session('corMensagem') }}">
                    <div class="box-header">
                        <h3 class="box-title"><strong>{{ session('tituloMensagem') }}</strong> </h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        {{ session('corpoMensagem') }}<a href='/esteiracomex/distribuir/demandas' class='alert-link'><strong>clique aqui</strong></a>
                    </div><!-- /.box-body -->
            </div>
            @endif
            @if (session('tituloMensagemErroCadastro'))
            <div class="box box-solid box-{{ session('corMensagemErroCadastro') }}">
                    <div class="box-header">
                        <h3 class="box-title"><strong>{{ session('tituloMensagemErroCadastro') }}</strong> </h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        {{ session('corpoMensagemErroCadastro') }} <br/><br/> Caso persista o erro entre em contato conosco:<br/><br/>
                        <h5>Equipe de Desenvolvimento</h5>
                        <ul class="list-inline">
                            <li><a href="sip:C142765@corp.caixa.gov.br"> Carlos </a></li>
                            <li><a href="sip:c095060@corp.caixa.gov.br"> Denise </a></li>
                            <li><a href="sip:c111710@corp.caixa.gov.br"> Chuman </a></li>
                            <li><a href="sip:C079436@corp.caixa.gov.br"> Vladimir </a></li>
                            <li><a href="mailto:ceopa01@caixa.gov.br?cc=c095060@mail.caixa;c079436@mail.caixa;c111710@mail.caixa;c142765@mail.caixa&amp;subject=Sobre%20o%20Projeto%20Esteira%20de%20contratação&amp;body=Deixe%20seu%20recado!">#Fale conosco!</a></li>
                        </ul>
                    </div><!-- /.box-body -->
            </div>
            @endif

   <div class="page-bar with-border">
        <h3 class="box-title">Dados do Cliente CAIXA</h3>
    </div>
    <br>

    <form method="POST" action="/esteiracomex/contratacao" enctype="multipart/form-data" id="formCadastroContratacao_">
        
        {{ csrf_field() }}
        
        <fieldset class="form-group row">

                <label class="col-sm-2 control-label" for="tipoPessoa">Tipo de Cliente:</label>
                <div class="col-sm-10">
                    <label class="radio-inline">PF</label>
                    <input class="radio-inline" name="tipoPessoa" id="radioCpf" type="radio" value="PF" required>

                    <label class="radio-inline">PJ</label>
                    <input class="radio-inline" name="tipoPessoa" id="radioCnpj" type="radio" value="PJ">
                </div>  <!--/col-->
        </fieldset>

        <div id="cpfCnpj2" class="form-group row" style="display: none;">
            <label for ="cpf" class="col-sm-2 control-label">CPF:</label>
            <div class="col-sm-3">
                <input class="form-control validarCpf" name="cpf" id="cpf" placeholder="CPF" maxlength="11" type="text">
                <div id="spanCpf"></div>
            </div>
        </div>  <!--/cpfCnpj2-->

        <div id="cpfCnpj3" class="form-group row" style="display: none;">
            <label class="col-sm-2 control-label" for="cnpj">CNPJ:</label>
            <div class="col-sm-3">
                <input class="form-control validarCnpj" name="cnpj" id="cnpj" placeholder="CNPJ" maxlength="18" type="text">
                <div id="spanCnpj"></div>
            </div>
        </div>  <!--/cpfCnpj3-->

        <div class="form-group row">
            <label class="col-sm-2 control-label" for="nomeCliente">Nome:</label>
            <div class="col-sm-6">
                <input class="form-control" name="nomeCliente" id="nomeCliente" placeholder="Nome" type="text" required>
            </div>
        </div>  <!--/form-group row-->

        <div class="form-group row">    
            <label class="col-sm-2 control-label">Conta do Cliente na Caixa:</label>
            <div class="col-sm-3">
                <input class="form-control mascaraconta" id="dadosContaCliente" name="dadosContaCliente" placeholder="0000.000.0000000-00" maxlength="16" type="text">
            </div>
        </div>  


    <hr>

    <div class="page-bar with-border">
        <h3 class="box-title">Dados da Operação</h3>
    </div>
    <br>

        <div class="row">
            <div class="form-group col-sm-6">

                <div class="form-group row">
                    <label class="col-sm-4 control-label">Tipo de Operação:</label>
                    <div class="col-sm-8">
                        <select class="form-control" id="tipoOperacao" name="tipoOperacao" placeholder="Selecione uma modalidade" required>
                            <option value="">Nenhum</option>
                            <option value="Pronto Importação Antecipado">Pronto Importação Antecipado</option>
                            <option value="Pronto Importação">Pronto Importação</option>
                            <option value="Pronto Exportação Antecipado">Pronto Exportação Antecipado</option>
                            <option value="Pronto Exportação">Pronto Exportação</option>
                        </select>
                    </div>
                </div>
            
                <div class="form-group row">
                    <label class="col-sm-4 control-label">Tipo de Moeda:</label>
                    <div class="col-sm-8">
                        <select class="form-control" id="tipoMoeda" name="tipoMoeda" placeholder="Selecione uma moeda">
                            <option value="DKK">Coroa Dinamarquesa - DKK</option>
                            <option value="NOK">Coroa Norueguesa - NOK</option>
                            <option value="SEK">Coroa Sueca - SEK</option>
                            <option value="USD" selected="selected">Dólar Americano - USD</option>
                            <option value="AUD">Dólar Australiano - AUD</option>
                            <option value="CAD">Dólar Canadense - CAD</option>
                            <option value="NZD">Dólar Neozelandês - NZD</option>
                            <option value="EUR">Euro - EUR</option>
                            <option value="CHF">Franco Suíço - CHF</option>
                            <option value="JPY">Iene - JPY</option>
                            <option value="GBP">Libra Esterlina - GBP</option>
                            <option value="ARS">Peso Argentino - ARS</option>
                            <option value="ZAR">Rand Sul-Africano - ZAR</option>
                            <option value="BRL">Real Brasileiro - BRL</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for ="valorOperacao" class="col-sm-4 control-label">Valor em Moeda Estrangeira:</label>
                    <div class="col-sm-8">
                        <input class="form-control mascaradinheiro" name="valorOperacao" id="valorOperacao" placeholder="$ 0,00" maxlength="22" type="text" required>
                    </div>
                </div>

                <div class="form-group row" id="divDataPrevistaEmbarque" hidden>
                    <label for="dataPrevistaEmbarque" class="col-sm-4 control-label">Data Prevista de Embarque:</label>
                    <div class="col-sm-8">
                        <input class="form-control mascaradata" 
                        name="dataPrevistaEmbarque" 
                        id="dataPrevistaEmbarque" 
                        placeholder="DD/MM/AAAA" 
                        maxlength="10" 
                        type="text"
                        pattern="^(?:(?:31(\/|-|\.)(?:0?[13578]|1[02]))\1|(?:(?:29|30)(\/|-|\.)(?:0?[13-9]|1[0-2])\2))(?:(?:1[6-9]|[2-9]\d)?\d{2})$|^(?:29(\/|-|\.)0?2\3(?:(?:(?:1[6-9]|[2-9]\d)?(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00))))$|^(?:0?[1-9]|1\d|2[0-8])(\/|-|\.)(?:(?:0?[1-9])|(?:1[0-2]))\4(?:(?:1[6-9]|[2-9]\d)?\d{2})$"
                        title="Ex: 10/04/2020">
                    </div>
                </div>
                
            </div> <!-- /form-group col-sm-6 padding0 -->

            <div class="form-group col-sm-6 padding0">
                    <label for="observacoesAgencia" class="col-sm-3 control-label">Observações:</label>

                    <div class="col-sm-9">
                        <textarea class="form-control" rows="9" name="analiseAg" id="observacoesAgencia" placeholder="Preencha informações complementares."></textarea>
                    </div>
            </div> <!-- /form-group col-sm-6 padding0 -->

        </div> <!-- /row-->
        
        <div id="divRadioDadosBancarios" class="form-group" style="display: none;"> 

        <hr>

            <div class="page-bar">
                <h3 class="box-title">Dados Bancários do Beneficiário no Exterior</h3>
            </div>
            <br>

            <div class="form-group row">    
                <label class="col-sm-2 control-label">Nome Completo / Razão Social:</label>
                <div class="col-sm-4">
                    <input class="form-control iban" id="nomeBeneficiario" name="nomeBeneficiario" type="text">
                </div>
            </div>

            <div class="form-group row">  

                <label class="col-sm-2 control-label">Endereço Completo:</label>
                <div class="col-sm-4">
                    <input class="form-control iban" id="enderecoBeneficiario" name="enderecoBeneficiario" type="text">
                </div>

                <label class="col-sm-1 control-label">Cidade:</label>
                <div class="col-sm-2">
                    <input class="form-control iban" id="cidadeBeneficiario" name="cidadeBeneficiario" type="text">
                </div>

                <label class="col-sm-1 control-label">País:</label>
                <div class="col-sm-2">
                    <input class="form-control iban" id="paisBeneficiario" name="paisBeneficiario" type="text">
                </div>

            </div>  

            <div class="form-group row">

                <label class="col-sm-2 control-label">Nome do Banco Beneficiário no Exterior:</label>
                <div class="col-sm-4">
                    <input class="form-control iban" id="nomeBancoBeneficiario" name="nomeBancoBeneficiario" type="text">
                </div>

                <label class="col-sm-2 control-label">Código SWIFT ou ABA:</label>
                <div class="col-sm-4">
                    <input class="form-control iban valida-swift" id="swiftAbaBancoBeneficiario" name="swiftAbaBancoBeneficiario" type="text">
                    <!-- <div id="retornoBene"></div> -->
                </div>

            </div>

            <div class="form-group row">
                
                <label class="col-sm-2 control-label">Código IBAN no Banco Beneficiário:</label>
                <div class="col-sm-4">
                    <input class="form-control iban valida-iban" id="ibanBancoBeneficiario" name="ibanBancoBeneficiario" type="text">
                    <!-- <div id="spanIbanBeneficiario"></div> -->
                </div>

                <label class="col-sm-2 control-label">Conta no Banco Beneficiário <small>(Caso não possua o IBAN)</small>:</label>
                <div class="col-sm-4">
                    <input class="form-control iban" id="numeroContaBeneficiario" name="numeroContaBeneficiario" type="text">
                </div>

            </div>

        <br>
            <div class="panel-group" role="tablist" aria-multiselectable="true">
                <div class="panel panel-default">

                    <div class="panel-heading" role="tab" id="headingTwo">
                    <h4 class="panel-title ">
                        Possui Banco Intermediário? - 
                        <!-- <input data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" type="checkbox" class="collapsed" id="checkbox" name="temBancoIntermediario"> -->
                        <!-- <div class="radio"> -->
                             <label class="radio-inline margin05"> 
                                 <input data-toggle="collapse" data-target=".collapseTwo.in" type="radio" class="collapsed" name="temBancoIntermediario" value="NAO" id="radioNao" checked> Não 
                            </label>
                        <!-- </div> -->
                        <!-- <div class="radio"> -->
                            <label class="radio-inline margin05"> 
                                <input data-toggle="collapse" data-target=".collapseTwo:not(.in)" type="radio" class="collapsed" name="temBancoIntermediario" value="SIM" id="radioSim"> Sim 
                            </label>
                        <!-- </div> -->
                    </h4>
                    </div>

                    <div id="collapseTwo" class="collapseTwo panel-collapse collapse in" aria-labelledby="headingTwo">
                        <div class="panel-body">

                            <div class="form-group row">

                                <label class="col-sm-2 control-label">Nome do Banco Intermediário:</label>
                                <div class="col-sm-4">
                                    <input class="form-control" id="nomeBancoIntermediario" name="nomeBancoIntermediario" type="text">
                                </div>

                                <label class="col-sm-2 control-label">Código SWIFT ou ABA:</label>
                                <div class="col-sm-4">
                                    <input class="form-control valida-swift" id="swiftAbaBancoIntermediario" name="swiftAbaBancoIntermediario" type="text">
                                    <!-- <div id="retornoInte"></div> -->

                                </div>

                            </div>

                            <div class="form-group row"> 

                                <label class="col-sm-2 control-label">Código IBAN no banco Intermediário:</label>
                                <div class="col-sm-4">
                                    <input class="form-control valida-iban" id="ibanBancoIntermediario" name="ibanBancoIntermediario" type="text">
                                    <!-- <div id="spanIbanIntermediario"></div> -->

                                </div>

                                <label class="col-sm-2 control-label">Conta no Banco Intermediário <small>(Caso não possua o IBAN)</small>:</label>
                                <div class="col-sm-4">
                                    <input class="form-control" id="contaBancoIntermediario" name="contaBancoIntermediario" type="text">
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
                        
        </div>  <!--/#divRadioDadosBancarios-->

        <hr>

        <div class="page-bar">
            <h3 class="box-title">Carregar Documentos</h3>
        </div>

        <label class="control-label" id='labelLimiteArquivos'>
            O limite de tamanho entre todos os arquivos é de <span></span> Mb.
        </label>

        <br>

        <div class="form-group">

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
                            <input type="file" accept=".pdf,.jpg,.jpeg,.png,.7z,.zip,.rar,.doc,.docx" style="display: none;" name="uploadInvoice[]" id="uploadInvoice" multiple>
                            </span>
                        </label>
                        <input type="text" class="form-control previewNomeArquivo" readonly>
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
                            <input type="file" accept=".pdf,.jpg,.jpeg,.png,.7z,.zip,.rar,.doc,.docx" style="display: none;" name="uploadConhecimento[]" id="uploadConhecimento" multiple>
                            </span>
                        </label>
                        <input type="text" class="form-control previewNomeArquivo" readonly>
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
                            <input type="file" accept=".pdf,.jpg,.jpeg,.png,.7z,.zip,.rar,.doc,.docx" style="display: none;" name="uploadDi[]" id="uploadDi" multiple>
                            </span>
                        </label>
                        <input type="text" class="form-control previewNomeArquivo" readonly>
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
                            <input type="file" accept=".pdf,.jpg,.jpeg,.png,.7z,.zip,.rar,.doc,.docx" style="display: none;" name="uploadDue[]" id="uploadDue" multiple>
                            </span>
                        </label>
                        <input type="text" class="form-control previewNomeArquivo" readonly>
                    </div>  <!--/col-->
                </div>  <!--/col-->
            </div><!--/form-group-->

            <div class="form-group row" id="divDocumentosDiversos" hidden>
                <div class="col-sm-4">
                    <p class="form-control">Outros</p>
                </div>
                <div class="col-sm-7">
                    <div class="input-group">
                        <label class="input-group-btn">
                            <span class="btn btn-primary">
                            <i class="fa fa-lg fa-cloud-upload"></i>
                            Carregar arquivo&hellip; 
                            <input type="file" accept=".pdf,.jpg,.jpeg,.png,.7z,.zip,.rar,.doc,.docx" style="display: none;" name="uploadDocumentosDiversos[]" id="uploadDocumentosDiversos" multiple>
                            </span>
                        </label>
                        <input type="text" class="form-control previewNomeArquivo" readonly>
                    </div>  <!--/col-->
                </div>  <!--/col-->
            </div><!--/form-group-->

        </div><!--/form-group-->
        
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <br>
            
        <br>


        <div class="form-group">
            <div class="col-sm-2 col-md-6">
                <button type="submit" id="submitBtn" class="btn btn-primary btn-lg center">Cadastrar</button>
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
    <script src="{{ asset('js/plugins/masks/jquery.mask.min.js') }}"></script>
    <script src="{{ asset('js/plugins/jQuery-CPF-CNPJ-Validator-plugin-master/jquery.cpfcnpj.js') }}"></script>
    <script src="{{ asset('js/plugins/iban/iban.js') }}"></script>
    <script src="{{ asset('js/contratacao/anima_loading_submit.js') }}"></script>
    <script src="{{ asset('js/contratacao/anima_input_file.js') }}"></script>
    <script src="{{ asset('js/contratacao/valida_swift_iban.js') }}"></script>
    <script src="{{ asset('js/contratacao/funcoes_cadastro.js') }}"></script>
   

@stop