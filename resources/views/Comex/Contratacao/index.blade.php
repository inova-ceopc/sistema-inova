
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

        @if (session('message'))
        <div class="box box-solid box-success">
                <div class="box-header">
                    <h3 class="box-title"><strong>{{ session('message') }} | Cadastro Realizado com Sucesso!</strong> </h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                        Sua demanda  foi cadastrada com sucesso! para acompanhar todas suas demandas já cadastradas <a href="/esteiracomex/acompanhamentos/minhasdemandas/" class="alert-link">  <strong>clique aqui</strong></a>
                </div><!-- /.box-body -->
        </div>
        @endif

   <div class="page-bar  with-border">
        <h3 class="box-title">Contratação - Cadastro de Demanda</h3>
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
            </div>
        </div>  <!--/cpfCnpj2-->

        <div id="cpfCnpj3" class="form-group row" style="display: none;">
            <label class="col-sm-2 control-label" for="cnpj">CNPJ:</label>
            <div class="col-sm-3">
                <input class="form-control validarCnpj" name="cnpj" id="cnpj" placeholder="CNPJ" maxlength="18" type="text">
            </div>
        </div>  <!--/cpfCnpj3-->

        <div class="form-group row">
            <label class="col-sm-2 control-label" for="nomeCliente">Nome:</label>
            <div class="col-sm-6">
                <input class="form-control" name="nomeCliente" id="nomeCliente" placeholder="Nome" type="text" required>
            </div>
        </div>  <!--/form-group row-->

    <hr>

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

                <div class="form-group row">
                    <label for="dataPrevistaEmbarque" class="col-sm-4 control-label">Data Prevista de Embarque:</label>
                    <div class="col-sm-8">
                        <input class="form-control mascaradata" 
                        name="dataPrevistaEmbarque" 
                        id="dataPrevistaEmbarque" 
                        placeholder="DD/MM/AAAA" 
                        maxlength="10" 
                        type="text" required
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
        
        <div id="divRadioDadosBancarios" class="form-group" style="display: none;"> <!-- -->

        <hr>

            <div class="form-group">
                <fieldset class="form-group row">
                   
                    <label class="col-sm-2 control-label">Os dados da conta do destinatário estão no documento enviado?</label>
                    <div class="col-sm-10">
                        <label class="radio-inline">Sim</label>
                        <input class="radio-inline radio-conta" name="temDadosBancarios" id="temDadosBancariosSim" value="2" type="radio">
                        
                        <label class="radio-inline">Não</label>
                        <input class="radio-inline radio-conta" name="temDadosBancarios" id="temDadosBancariosNao" value="3" type="radio">
                    </div>  <!--/col-->
                </fieldset>
    
                <div id="divInformaDadosBancarios3" class="form-group row desc2" hidden> <!---->
                    <label class="col-sm-2 control-label">Informe os dados bancários do beneficiário:</label>
                    <div class="col-sm-6">
                        <input class="form-control iban" id="iban1" name="nomeBeneficiario" placeholder="Nome do Beneficiário" type="text">
                        <input class="form-control iban" id="iban2" name="nomeBanco" placeholder="Nome do Banco Beneficiário" type="text">
                        <input class="form-control iban" id="iban3" name="iban" placeholder="IBAN" type="text">
                        <input class="form-control iban" id="iban4" name="agContaBeneficiario" placeholder="Conta" type="text">
                    </div>
                </div>  <!--/contaBeneficiarioAnt-->
            </div>  <!--/form-group-->
                        
        </div>  <!--/#divRadioDadosBancarios-->

        <hr>

        <div class="form-group">

            <div class="form-group row" id="documentacao">
                <label class="col-sm-2 control-label">Documentação Necessária:</label>
            </div><!--/form-group row-->
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
                            <input type="file" accept=".pdf,.jpg,.jpeg,.png,.7z,.zip,.rar,.doc,.docx" style="display: none;" name="uploadConhecimento[]" id="uploadConhecimento" multiple>
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
                            <input type="file" accept=".pdf,.jpg,.jpeg,.png,.7z,.zip,.rar,.doc,.docx" style="display: none;" name="uploadDi[]" id="uploadDi" multiple>
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
                            <input type="file" accept=".pdf,.jpg,.jpeg,.png,.7z,.zip,.rar,.doc,.docx" style="display: none;" name="uploadDue[]" id="uploadDue" multiple>
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
                            <input type="file" accept=".pdf,.jpg,.jpeg,.png,.7z,.zip,.rar,.doc,.docx" style="display: none;" name="uploadDadosBancarios[]" id="uploadDadosBancarios" multiple>
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
                            <input type="file" accept=".pdf,.jpg,.jpeg,.png,.7z,.zip,.rar,.doc,.docx" style="display: none;" name="uploadAutorizacaoSr[]" id="uploadAutorizacaoSr" multiple>
                            </span>
                        </label>
                        <input type="text" class="form-control" readonly>
                    </div>  <!--/col-->
                </div>  <!--/col-->
            </div><!--/form-group-->

        </div><!--/form-group-->

            <br>

            
        
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <br>
            
        <br>


        <div class="form-group">
            <div class="col-sm-2 col-md-6">
                <button type="submit" id="submitBtn" class="btn btn-primary btn-lg">Cadastrar Contratação </button>
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
    
    <script src="{{ asset('js/contratacao/funcoes_cadastro.js') }}"></script>
   

@stop