@extends('adminlte::page')

@section('title', 'Esteira Comex')


@section('content_header')

<div class="panel-body padding015">
    <h4 class="animated bounceInLeft pull-left">
        Distribuição de Demandas | 
        <small>Painel de controle demandas COMEX </small>
    </h4>
    <ol class="breadcrumb pull-right">
        <li><a href="#"><i class="fa fa-dashboard"></i>Gerencial</a></li>
        <li><a href="#"></i>Distribuição de Demandas</a></li>
    </ol>
</div>

@stop

@section('content')

<div class="container-fluid">
    <div class="panel panel-default">
        <div class="panel-body" id="accordion">
            @if (session('mensagem'))
            <div class="box box-solid box-success">
                <div class="box-header">
                    <h3 class="box-title"><strong>{{ session('mensagem') }}</strong> </h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    A demanda foi distribuída com sucesso!
                </div><!-- /.box-body -->
            </div>
            @endif
            <div class="panel-group row margin0" role="tablist" aria-multiselectable="true">
                <div class="col-md-4 padding05">
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingOne">
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                <h4 class="panel-title">
                                    <b>Liquidação -  ACC / ACE &nbsp; </b>
                                    <b>&nbsp; &nbsp;  &nbsp;  &nbsp; {{ session()->get('contagemDemandasCadastradasLiquidacao', 0) }} &nbsp; </b>
                                    <span class="pull-right active animated pulse infinite glyphicon fa fa-chevron-right">&nbsp; </span> &nbsp; 
                                </h4>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 padding05">
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingTwo">
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                <h4 class="panel-title">
                                    <b>Comprovação de Embarque &nbsp; </b>
                                    <b>&nbsp; &nbsp;  &nbsp;  &nbsp; {{ session()->get('contagemDemandasCadastradasAntecipadosCambioPronto', 0) }} &nbsp; </b>
                                    <span class="pull-right active animated pulse infinite fa fa-chevron-right">&nbsp; </span> &nbsp; 
                                </h4>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 padding05">
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingThree">
                            <a class="" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                                <h4 class="panel-title">
                                    <b>Contratação - Pronto &nbsp; </b>
                                    <b>&nbsp; &nbsp;  &nbsp;  &nbsp; {{ session()->get('contagemDemandasCadastradasContratacao', 0) }} &nbsp; </b>
                                    <span class="pull-right active animated pulse infinite fa fa-chevron-right">&nbsp; </span> &nbsp; 
                                </h4>
                            </a>
                        </div>
                    </div>
                </div>
            </div>   <!--panel-group row-->
            <br>
            <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                <div class="page-bar">
                    <h3>Liquidação - ACC / ACE</h3>
                </div>
                <hr>
            </div> <!--#collapseOne-->
            <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                <div class="page-bar">
                    <h3>Comprovação de Embarque</h3>
                </div>
                <hr>
            </div> <!--#collapseTwo-->
            <div id="collapseThree" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingThree" aria-expanded="true">
                <div class="page-bar">
                    <h3>Contratação - Pronto</h3>
                </div>
                <hr>
                <!-- ########################################## QUADRO RESUMO DO DIA ################################################ -->
                <!-- SELECT COUNT. QTDE DEMANDAS DISTRIBUIDAS -->

                <!-- <h4>Resumo do dia</h4> -->

                <div>
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="col-md-4 padding05 active">
                            <a href="#contratacao" class="btn btn-default" aria-controls="home" role="tab" data-toggle="tab">
                                <h4 class="panel-title">
                                    <b>Conformidade da Contratação</b>
                                </h4>
                            </a>
                        </li>
                        <li role="presentation" class="col-md-4 padding05">
                            <a href="#envio" class="btn btn-default" aria-controls="profile" role="tab" data-toggle="tab">
                                <h4 class="panel-title">
                                    <b>Envio de Contrato</b>
                                </h4>
                            </a>
                        </li>
                        <li role="presentation" class="col-md-4 padding05">
                            <a href="#assinatura" class="btn btn-default" aria-controls="messages" role="tab" data-toggle="tab">
                                <h4 class="panel-title">
                                    <b>Conformidade de Assinatura</b>
                                </h4>
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane fade in active" id="contratacao">
                        <br>
                        <h4>Distribuição de demandas por analista</h4>
                            <div class="table-responsive">
                                <table id="tabelaDistribuidasAnalistas" class="table table-striped compact dataTable">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th class="col-xs-1">Matrícula</th>
                                            <th class="col-xs-3">Nome</th>
                                            <th>Pronto IMP</th>
                                            <th>Pronto IMP Antec.</th>
                                            <th>Pronto EXP</th>
                                            <th>Pronto EXP Antec.</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot class="thead-dark">
                                        <tr>
                                            <th class="col-xs-1">Matrícula</th>
                                            <th class="col-xs-3">Nome</th>
                                            <th>Pronto IMP</th>
                                            <th>Pronto IMP Antec.</th>
                                            <th>Pronto EXP</th>
                                            <th>Pronto EXP Antec.</th>
                                            <th>Total</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div> <!-- table-responsive -->
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="envio">
                        <br>
                        <h4>Controle de contratos enviados</h4>
                        <br>
                            <div class="table-responsive">
                                <table id="tabelaResumo" class="table table-striped compact dataTable">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Matrícula</th>
                                            <th>Nome</th>
                                            <th>Pronto IMP</th>
                                            <th>Pronto IMP Antec.</th>
                                            <th>Pronto EXP</th>
                                            <th>Pronto EXP Antec.</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tfoot class="thead-dark">
                                        <tr>
                                            <th>Matrícula</th>
                                            <th>Nome</th>
                                            <th>Pronto IMP</th>
                                            <th>Pronto IMP Antec.</th>
                                            <th>Pronto EXP</th>
                                            <th>Pronto EXP Antec.</th>
                                            <th>Total</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div> <!-- table-responsive -->                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="assinatura">
                        <br>
                        <h4>Demandas de conferência contratual</h4>
                        <br>
                            <div class="table-responsive">
                                <table id="tabelaResumo" class="table table-striped compact dataTable">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Matrícula</th>
                                            <th>Nome</th>
                                            <th>Pronto IMP</th>
                                            <th>Pronto IMP Antec.</th>
                                            <th>Pronto EXP</th>
                                            <th>Pronto EXP Antec.</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tfoot class="thead-dark">
                                        <tr>
                                            <th>Matrícula</th>
                                            <th>Nome</th>
                                            <th>Pronto IMP</th>
                                            <th>Pronto IMP Antec.</th>
                                            <th>Pronto EXP</th>
                                            <th>Pronto EXP Antec.</th>
                                            <th>Total</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div> <!-- table-responsive -->                        </div>
                    </div>

                </div>

                <hr>
                
                <!-- ########################################## QUADRO DE DISTRIBUIR DEMANDAS ################################################ -->
                <h4>Novas demandas</h4>
                <div class="table-responsive">
                    <table id="tabelaContratacoes" class="table table-striped compact hover">
                        <thead class="thead-dark">
                            <tr>
                                <th class="col-xs">ID</th>
                                <th class="col-xs-1">Data</th>
                                <th class="col-xs-2">Nome</th>
                                <th class="col-xs-2">CNPJ / CPF</th>
                                <th class="col-xs-1">Operação</th>
                                <th class="col-xs">Valor</th>
                                <th class="col-xs">Área</th>
                                <th class="col-xs">Status</th>
                                <th class="col-xs">Distribuir</th>
                            </tr>
                        </thead>
                        <tbody> 
                            @foreach($demandasContratacao as $demanda)
                            <tr>
                                <td>{{ $demanda->idDemanda }}</td>
                                <td>{{ $demanda->dataCadastro }}</td>
                                <td>{{ $demanda->nomeCliente }}</td>
                                <td>{{ $demanda->cpf === null ? $demanda->cnpj : $demanda->cpf }}</td>
                                <td>{{ $demanda->tipoOperacao }}</td>
                                <td>{{ number_format($demanda->valorOperacao, 2, ',', '.') }}</td>
                                <td>{{ $demanda->agResponsavel === null ? $demanda->srResponsavel : $demanda->agResponsavel }}</td>
                                <td>{{ $demanda->statusAtual }}</td>
                                <td>
                                    <form method="POST" action="/esteiracomex/distribuir/{{ $demanda->idDemanda }}">
                                        {{ csrf_field() }}
                                        {{ method_field('PUT') }}
                                        <input type="hidden" name="protocolo" value="{{ $demanda->idDemanda }}">
                                        <input type="hidden" name="tipoDemanda" value="contratacao">
                                        <select name="analista" class="selectDistribuir margin05 inline"  required>
                                            <option value="">Distribuir</option>   
                                            @foreach($arrayEmpregados as $empregados)
                                                @if($demanda->responsavelCeopc != null)
                                                    @if($demanda->responsavelCeopc == $empregados->matricula)
                                                <option class="matricula" value="{{ $empregados->matricula }}" selected="selected">{{ $empregados->nome . ' - ' .  $empregados->matricula }}</option>
                                                    @else
                                                <option class="matricula" value="{{ $empregados->matricula }}">{{ $empregados->nome . ' - ' .  $empregados->matricula }}</option> 
                                                    @endif
                                                @else
                                            <option class="matricula" value="{{ $empregados->matricula }}">{{ $empregados->nome . ' - ' .  $empregados->matricula }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        <button type="submit" rel="tooltip" class="btn btn-primary margin05 inline gravaDistribuicao" title="Gravar distribuição">
                                            <span> <i class="glyphicon glyphicon-floppy-disk"></i> </span>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="thead-dark">
                            <tr>
                                <th class="col-xs">ID</th>
                                <th class="col-xs-1">Data</th>
                                <th class="col-xs-2">Nome</th>
                                <th class="col-xs-2">CNPJ / CPF</th>
                                <th class="col-xs-1">Operação</th>
                                <th class="col-xs">Valor</th>
                                <th class="col-xs">Área</th>
                                <th class="col-xs">Status</th>
                                <th class="col-xs">Distribuir</th>
                            </tr>
                        </tfoot>
                    </table>
                </div> <!--/table-responsive-->
                <hr>
                <h4>Status</h4>
                <div class="form-group">          
                    <ul class="list-group col-sm">
                        <li class="list-group-item inline">1 - Cadastrada</li>
                        <li class="list-group-item inline">2 - Em análise</li>
                        <li class="list-group-item inline">3 - Conforme / Conferência</li>
                        <li class="list-group-item inline">4 - Conta OK</li>
                        <li class="list-group-item inline">5 - Inconforme</li>
                        <li class="list-group-item inline">6 - Cancelado</li>
                    </ul>
                </div>  <!--/form-group row-->
            </div> <!--#collapseThree-->
        </div>  <!--panel-body-->
    </div>  <!--panel panel-default-->
</div>  <!--container-fluid-->

@stop

@section('css')
    <link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/contratacao/cadastro.css') }}" rel="stylesheet">
@stop

@section('js')
    <script src="{{ asset('js/plugins/jquery/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('js/plugins/numeral/numeral.min.js') }}"></script>
    <script src="{{ asset('js/contratacao/distribuir_demandas_contratacao.js') }}"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js" type="text/javascript" charset="utf8"></script>
    <script>
        $('.collapse').on('show.bs.collapse', function () {
            $('.collapse.in').collapse('hide'); 
        });

        $('#myTabs a').click(function (e) {
            e.preventDefault()
            $(this).tab('show')
        })

    </script>
@stop