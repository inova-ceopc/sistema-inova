<!DOCTYPE html>
    <html lang="pt">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1"> 
    
    <title>SUPOC - SN Produtos Corporativos</title>
    <link rel="icon" href="{{ asset('images/favicon.ico') }}" /> 
  
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"> 
    <link href="{{ asset('css/template.css') }}" rel="stylesheet" type="text/css">  
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/icons.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/font-awesome-4.5.0/font-awesome-4.5.0/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/Bndes/NovoSiaf/index.css') }}" rel="stylesheet" type="text/css">
    
    <script src="{{ asset('js/plugins/jquery/jquery-1.12.1.min.js')}}"></script>
    <script src="{{ asset('js/plugins/jquery/jquery-ui.min.js')}}"></script>
    <script src="{{ asset('js/plugins/forms/jquery.maskMoney.min.js')}}"></script>
    


</head>

<body>

	<!-- Navbar cabeçalho -->
	<div class="navbar navbar-inverse" role="navigation">
		<div class="navbar-header">
			<a class="navbar-brand" href="#">SUPOC</a>
			<a class="sidebar-toggle"><i class="icon-paragraph-justify2"></i></a>
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-icons">
				<span class="sr-only">Toggle navbar</span>
				<i class="icon-grid3"></i>
			</button>
			<button type="button" class="navbar-toggle offcanvas">
				<span class="sr-only">Toggle navigation</span>
				<i class="icon-paragraph-justify2"></i>
			</button>
		</div>

        	<ul class="nav navbar-nav navbar-right collapse" id="navbar-icons">
		
			<li class="user dropdown">
				<a class="dropdown-toggle" data-toggle="dropdown"><span id="nomeEmpregado"></span><i class="caret"></i></a>
				<ul class="dropdown-menu dropdown-menu-right">
					<li><a href="#">Nome: <span id="nomeSessao"></span> </a></li>
					<li><a href="#">Matrícula: <span id="matriculaSessao"></span></a></li>
					<li><a href="#">Função: <span id="funcaoSessao"></span></a></li>
					<li><a href="#">Lotação: <span id="lotacaoSessao"></span></a></li>
					<li><a href="#">Perfil: <span  id="perfilSessao"></span>  </a></li>
				</ul>
			</li>
		</ul>
	</div>


<!-- Page container -->
<div class="page-container">


<!-- Sidebar -->
<div class="sidebar">
    <div class="sidebar-content">

        <!-- User dropdown -->
        
        <div class="user-menu dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <div class="user-info"><b>SIAF - Sistema de Acompanhamento de Fluxo</b></div>
        </a>
        <div class="popup dropdown-menu dropdown-menu-right">
            <ul class="list-group">
                <li class="list-group-item">
                    <i class="icon-pencil3 text-muted"></i><a href="/novosiaf/documentos"><span>Lista de Documentos</span></a>
                </li>
            </ul>
        </div>

    </div>
        
        <!-- /user dropdown -->


        <!-- Main navigation menu lateral -->
        <ul id="menu-principal" class="navigation">
        <li id="menu-dashboard"><a href="http://www.sumep.mz.caixa/novosiaf/"><span>Dashboard</span><i class="icon-screen2"></i></a></li>
        <li id="menu-documentos"><a href="http://www.sumep.mz.caixa/novosiaf/documentos"><span>Documentos</span><i class="icon-pencil3"></i></a></li>     
        <li id="menu-digitalizacao"><a href="#" class="expand"><span>Digitalização</span><i class="icon-upload3"></i></a>
            <ul>
                <li id="menu-digitalizacao-avalop"><a href="http://www.sumep.mz.caixa/novosiaf/digitalizacao">Inserir AVALOP</a></li>
                <li id="menu-digitalizacao-sict2"><a href="http://sistemas.retaguarda.caixa/filaunica/" target="_blank">SICT2 (Digitalização dos Documentos)</a></li>
            </ul>
        </li>
        <li id="menu-contratos"><a href="#" class="expand"><span>Contratos</span><i class="icon-paragraph-justify2"></i></a>
            <ul>
                <li id="menu-contratos-buscar"><a href="http://www.sumep.mz.caixa/novosiaf/contrato/buscar">Buscar Contrato</a></li>
                <li id="menu-contratos-inserir"><a href="http://www.sumep.mz.caixa/novosiaf/contrato/inserir">Inserir Contrato</a></li>
                <li id="menu-contratos-minha-fila"><a href="http://www.sumep.mz.caixa/novosiaf/contrato/fila_analista">Minha Fila de Atendimento</a></li>
                <li id="menu-contratos-refinanciamento"><a href="http://www.sumep.mz.caixa/novosiaf/refinanciamento/index">Refinanciamento de Contratos</a></li>
            </ul>
        </li>
        <li id="menu-indicadores"><a href="#" class="expand"><span>Indicadores</span><i class="icon-bars"></i></a>
            <ul>
                <li id="menu-indicadores-prazo-medio"><a href="http://www.sumep.mz.caixa/novosiaf/indicador/prazo_medio">Prazo Médio das Etapas do Processo</a></li>
                <li id="menu-indicadores-analise-esteiras"><a href="http://www.sumep.mz.caixa/novosiaf/indicador/analise_esteiras">Prazo de Análise das Esteiras</a></li>
                <li id="menu-indicadores-evolucao"><a href="http://www.sumep.mz.caixa/novosiaf/indicador/evolucao">Evolução</a></li>
            </ul>
        </li>
        <li id="menu-relatorios-sr"><a href="#" class="expand"><span>Relatórios SR</span><i class="icon-bars"></i></a>
            <ul>
                <li id="menu-relatorios-sr-movimentacao"><a href="http://www.sumep.mz.caixa/novosiaf/relatoriossr/relatorio_movimentos">Relatório de Movimentação</a></li>
                <li id="menu-relatorios-sr-correcao"><a href="http://www.sumep.mz.caixa/novosiaf/relatoriossr/relatorio_correcao_sr">Relatório de Dias para Correção</a></li>
                <li id="menu-relatorios-sr-pacsempl"><a href="http://www.sumep.mz.caixa/novosiaf/relatoriossr/relatorio_pac_sem_pl">Relatório PAC/FRO Aprovadas sem PL</a></li>
            </ul>
        </li>
        <li id="menu-relatorios-cnbndes"><a href="#" class="expand"><span>Relatórios CNBNDES</span><i class="icon-bars"></i></a>
            <ul>
                <li id="menu-relatorios-cnbndes-incluidos"><a href="http://www.sumep.mz.caixa/novosiaf/relatorioscnbndes/relatorio_incluidos">Incluídos</a></li>
                <li id="menu-relatorios-cnbndes-aprov-lib"><a href="http://www.sumep.mz.caixa/novosiaf/relatorioscnbndes/relatorio_aprov_lib">Aprovados e Liberados</a></li>
                <li id="menu-relatorios-cnbndes-aguardando"><a href="http://www.sumep.mz.caixa/novosiaf/relatorioscnbndes/relatorio_aguardando">Aguardando Aprovação/Liberação</a></li>
                <li id="menu-relatorios-cnbndes-recusas"><a href="http://www.sumep.mz.caixa/novosiaf/relatoriosconsolidado/relatorio_recusas">PAC/FRO e PLs Recusados</a></li>
                <li id="menu-relatorios-cnbndes-abaixo100k"><a href="http://www.sumep.mz.caixa/novosiaf/relatoriosconsolidado/relatorio_abaixo100k">Contratos Abaixo de R$ 100 Mil</a></li>
                <li id="menu-relatorios-cnbndes-pendencias"><a href="http://www.sumep.mz.caixa/novosiaf/relatoriosconsolidado/relatorio_pendencias">Pendências</a></li>
                <li id="menu-relatorios-cnbndes-indicador"><a href="http://www.sumep.mz.caixa/novosiaf/relatorioscnbndes/relatorio_indicador_demandas">Indicador de Tratamento de Demandas</a></li>
            </ul>
        </li>
        <li id="menu-simulador"><a href="http://www.sumep.mz.caixa/novosiaf/simulador"><span>Simulador BNDES</span><i class="icon-settings"></i></a></li>
        <li id="menu-convenios"><a href="http://www.sumep.mz.caixa/convenios/"><span>Acompanhamento de Convênios</span><i class="icon-truck"></i></a></li>
        <li id="menu-amortizacao"><a href="http://www.geopc.mz.caixa/sumep.mz.caixa/novosiaf/"><span>Amortização \ Liquidação</span><i class="icon-stackoverflow"></i></a></li>
    </ul>
    <!-- /main navigation -->
        
    </div>
</div>
<!-- /sidebar -->


<!-- Page content -->
 <div class="page-content">
<!----------------------CONTRUÇÃO DE MODAL--------------
###################################################################################################
###################################################################################################
####################################################################################################

-->
<!-- Large modal -->
<!-- modal de solicitação de cadastro -->
<div id="modalCadastramento" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static" >
        
    <div class="modal-dialog modal-danger modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="icon-file-plus"></i>Solicitação de Amortização \ Liquidação  <span id="nome_cliente"></span>  <span id="cnpj_cliente"></span></h4>
            </div>
                
               
            <div class="modal-body with-padding">
                <div class="tabbable">
                    <ul class="nav nav-tabs">
                        <li class="active" id="modalCadastrar"><a href="#tabSelecionar" data-toggle="tab"><i class="icon-checkbox-checked"></i>Selecionar Contratos</a></li>
                        <li id="modalInstrucoes"><a href="#tabInstrucoes" data-toggle="tab"><i class="icon-book"></i>Instruções </a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade in active" id="tabSelecionar">
                            <div class="row"><small class="display-block " id="avisoAgencia"><strong> RATIFICAR AS INFORMAÇÕES CARREGADAS! No caso de dúvidas consulte as instruções de preenchimento no menu acima ! &nbsp &nbsp &nbsp </small></div></strong>
                            
                            <div class="row"><small class="display-block text-danger active avisoAgencia" id ="avisoAgencia"> Para solicitar, Informe abaixo o nº BNDES, valor, confirme a conta, contrato e o tipo de comando dos contratos desejados e envie à CEOPC!  </small></div>

                            <div class="row"><small class="display-block" id="contratoBNDESnumero">O nº BNDES pode ser verificado no SIFBN/SIBAN > funções > Consulta de Número do BNDES</small></div>
                            <br>
                            <form class="form-group has-feedback" action="" method="post" role="form" id="formulario_pedido_amortizacao">
                                                        
                            <div class="form-group">
                        
                                <table id ="tabCadastrar" class="table table-bordered table-striped datatable">
                                    <thead>
                                        <tr>
                                            <th>N Contrato BNDES</th>
                                            <th>N Contrato CAIXA</th>
                                            <th>Conta para Débito</th>
                                            <th>Valor (Valor amortização)</th>
                                            <th>Tipo de Comando</th>
                                        </tr>
                                    </thead>
                                    <tbody> </tbody>
                                </table>
                            
                                <br>
                           
                                <label>Observações</label>
                                <textarea class="form-control co_observacoes" rows="3" name="co_observacoes" placeholder="Digite as observações da solicitação aqui...."></textarea>  
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-danger pull-left" data-dismiss="modal">Fechar</button>
                                <button class="btn btn-success pull-right cadAmortizacao" type="submit" value="submit">Enviar à CEOPC</button>
                            </div>

                            </form>
                        </div>
                        
                        <div class="tab-pane body fade" id="tabInstrucoes">
                            <div class="row">
                                <div class="col-sm-12">
                                    <h5 class="text-error">Passo a passo</h5>
                                    <p> - Certifique-se que a amortização é referente ao cliente selecionado.</p>
                                    <p> - Selecione o contrato que deseja solicitar amortização ou liquidação.</p>
                                    <p> - <strong>Não é necessário preencher nada nos contratos que não serão amortizados/liquidados</strong>.</p>
                                    <p> - <strong>Verifique se os dados dos contratos selecionados estão corretos, ajuste se necessário.</strong></p>
                                    <p> - <strong>Informe o nº do contrato BNDES, você pode vericar esse nº no SIFBN/SIBAN > funções > Consulta de Número do BNDES.</strong></p>
                                    <p> - Informe o valor a amortizar.</p>
                                    <p> - Ao valor da liquidação não deve ser somado a prestação do dia.</p>
                                    <p> - Selecione o tipo de comando.</p>
                                    <p> - Preencha as observações pertinentes.</p>
                                    <p> - Envie o pedido à CEOPC.</p>
                                    <hr>
                                </div>
                            </div>
                        </div>                       
                    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <!-- /large modal -->
    
<!-- Modal para visualizar contrato -->

<div id="visualizarcontrato" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static" >
    
    <div class="modal-dialog modal-danger modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="icon-file-plus"></i>Visualizar Contrato  <span id="nome_cliente_modal"></span>  <span id="cnpj_cliente_modal"></span></h4>
            </div>
                            
            <div class="modal-body with-padding">
                <div class="tabbable page-tabs">
                    <ul class="nav nav-tabs">
                
                        <li id="abaTabVisualizar"class="active"><a href="#tabVisualizar" data-toggle="tab"><i class="icon-eye"></i>Visualizar Contrato</a></li>
                        <li id ="abaTabHistorico"><a href="#tabHistorico" data-toggle="tab"><i class="icon-book"></i>Histórico do contrato </a></li>
                        
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade in active" id="tabVisualizar">

                        <form class="form-group has-feedback" action="" method="post" role="form" id="formulario_visualiza_pedido">
                                                                
                            <div class="form-group">
                                <div class="row">  
                                <div id="conteudoModal"></div>
                                    <div class="col-sm-3">
                                        <label class="control-label">N Contrato BNDES</label>
                                            <input placeholder="..."  id="contrato_bndes_modal"class="form-control" type="text" disabled>
                                    </div>
                                    <div class="col-sm-3">
                                        <label class="control-label">N Contrato CAIXA</label>
                                            <input placeholder="..." id="contrato_caixa_modal" class="form-control" type="text" disabled>
                                    </div>
                                    
                                    <div class="col-sm-3">
                                        <label class="control-label">Conta para Débito</label>
                                            <input placeholder="..." id="conta_corrente_modal"class="form-control" type="text" disabled>
                                    </div>
                                    <div class="col-sm-3">
                                        <label class="control-label">Valor da Amortização</label>
                                            <input placeholder="..." id="valor_modal" class="form-control dinheiro" type="text" disabled>
                                    </div>
                                </div>
                                <br>
                                <div class="row">    
                                    <div class="col-sm-3">
                                        <label class="control-label">Tipo de Comando</label>
                            
                                        <select data-placeholder="Selecione o tipo.." id="tipo_modal" class=" tipoAmortizacao form-control" disabled>
                                            <option value="">-</option> 
                                            <option value="A">AMORTIZAÇÃO</option> 
                                            <option value="L">LIQUIDAÇÃO</option> 
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <label class="control-label">STATUS</label>
                                        <input placeholder="..." id="status_modal" class="form-control" type="text" disabled>
                                    </div>
                                    <div class="col-sm-1">
                                        <label class="control-label">PA</label>
                                            <input placeholder="..." id="pv_modal" class="form-control" type="text" disabled>
                                    </div>
                                    <div class="col-sm-1">
                                        <label class="control-label">SR</label>
                                            <input placeholder="..." id="sr_modal" class="form-control" type="text" disabled>
                                    </div>
                                    <div class="col-sm-1">
                                        <label class="control-label">GIGAD</label>
                                        <input placeholder="..." id="gigad_modal" class="form-control" type="text" disabled>
                                    </div>
                                </div>
                                            
                                <br>
                            
                                <label>Observações</label>
                                    <textarea class="form-control" id="obs_modal" disabled></textarea>
                                
                                <br>

                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h6 class="panel-title"><i class="icon-coin"></i> Histórico de saldo</h6>
                                    </div>
                                    
                                    <div class="panel-body tabResponsiva" >
                                    
                                        <table id="tabHistoricoSaldo"class="table table-bordered table-striped datatable">
                                        <thead>
                                            <tr>
                                                <th hidden> consulta </th>
                                                <th> Data e Hora</th>
                                                <th> Status </th>
                                                <th> Saldo Disponível </th>
                                                <th> Saldo Bloqueado </th>
                                                <th> Limite Cheque Azul </th>
                                                <th> Limite GIM </th>
                                                <th> Saldo considerado </th>  
                                                
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                        </table>
                                    
                                    
                                    </div>
                                </div>
                            </div>
                        </form>
                                
                        </div>

                            <div class="tab-pane body fade" id="tabHistorico">
                                <div class="row">
                                    <div class="panel-heading">
                                        <h6 class="panel-title"><i class="icon-vcard"></i> Histórico do contrato</h6>
                                    </div>
                                    
                                    <div class="panel-body tabResponsiva">
                                    
                                    <table id= "tabHistoricoContrato" class="table table-bordered table-striped table-responsive datatable">
                                        <thead>
                                            <tr>
                                                <th> Pedido </th>
                                                <th> Data e Hora</th>
                                                <th> Status </th>
                                                <th> Observações </th>
                                                <th> Responsável </th>
                                                <th> Unidade </th>
                                                                                        
                                            </tr>
                                        </thead>
                                        <tbody ></tbody>
                                    </table>
                                    </div>
                                </div>
                            </div>
                                
                        </div>                       
                    </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger pull-right" data-dismiss="modal">Fechar</button>
                                    
                        </div>
            </div>                
        </div>
    </div>
</div>

<!-- /Modal para visualizar contrato -->

    <!-- /Modal para editar status -->
    <div id="editarcontrato" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static" >
        
        <div class="modal-dialog modal-danger modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                   
                    <h4 class="modal-title"><i class="icon-eye"></i>Editar Contrato  <span id="nome_cliente_editar"></span>  <span id="cnpj_cliente_editar"></span></h4>
                </div>
                               
                <div class="modal-body with-padding">
                <div class="tabbable">
                    <ul class="nav nav-tabs">
                
                        <li id="abaTabEditar"class="active"><a href="#tabEditar" data-toggle="tab"><i class="icon-eye"></i>Editar Contrato</a></li>
                        <li id="abaTabHistoricoEditar"><a href="#tabHistoricoEditar" data-toggle="tab"><i class="icon-book"></i>Histórico do contrato </a></li>
                        
                    </ul>
                <div class="tab-content">

                    <div class="tab-pane fade in active" id="tabEditar">
                    <span id="codDemanda"></span>

                    <form class="form-group has-feedback" action="" method="post" role="form" id="formulario_editar_amortizacao">
                                                                                   
                        <div class="form-group">
                            
                        <br>             
                        <div class="row">  
                        <div id="conteudoModal"></div>
                        
                            <div class="col-sm-3">
                                <label class="control-label">N Contrato BNDES</label>
                                 <input placeholder="..."  data-mask="99999999999" name="contrato_bndes_editar" id="contrato_bndes_editar"class="form-control" type="text" >
                            </div>
                            <div class="col-sm-3">
                                <label class="control-label">N Contrato CAIXA</label>
                                 <input placeholder="..." name="contrato_caixa_editar" id="contrato_caixa_editar" data-mask="9999.999.9999999-99" class="form-control" type="text" disabled>
                            </div>
                           
                            <input id="lote" hidden>
                            
                            <div class="col-sm-3">
                                <label class="control-label">Conta para Débito</label>
                                 <input placeholder="..." data-mask="9999.999.99999999-9" name="conta_corrente_editar" id="conta_corrente_editar"class="form-control" type="text" >
                            </div>
                            <div class="col-sm-3">
                                <label class="control-label">Valor</label>
                                 <input placeholder="..." name="valor_editar" id="valor_editar" valoreditar class="form-control dinheiro" type="text" >
                            </div>
                            </div>
                            <br>
                            <div class="row">    
                            <div class="col-sm-3">
                                <label class="control-label">Tipo de Comando</label>
                               
                                <select data-placeholder="Selecione o tipo.." id="tipo_editar" class=" tipoAmortizacao form-control">
                                    <option value="">-</option> 
                                    <option value="A">AMORTIZAÇÃO</option> 
                                    <option value="L">LIQUIDAÇÃO</option> 
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <label class="control-label">STATUS</label>
                                                             
                               
                            <div id="editarCEOPC">
                                <select data-placeholder="Selecione o tipo.."  id="status_editar" class="form-control">
								<option value=""> - </option> 
                                <option value="CADASTRADO" style="display: none">CADASTRADO</option>
                                <option value="RECEBIDO">RECEBIDO</option>
                                <option value="SIFBN OK">SIFBN OK</option>
                                <option value="SEM COMANDO SIFBN">SEM COMANDO SIFBN</option>
                                <option value="CANCELADO">CANCELADO</option>
                                <option value="CONTA DIVERGENTE">CONTA DIVERGENTE</option>
                                <option value="VALOR DIVERGENTE">VALOR DIVERGENTE </option>
                                <option value="CONTA PF">CONTA PF</option>
                                <option value="CONTRATO EM CA">CONTRATO EM CA</option>
                                <option value="GESTOR RESIDUO SIFBN">RESIDUO SIFBN</option>
                                <option value="GESTOR">GESTOR</option>
                                <option value="SEM SALDO">SEM SALDO</option>
                                <option value="CONCLUIDO">CONCLUIDO</option>
                                <option value="CORRIGIDO" style="display: none">CORRIGIDO</option>
							    </select>

                            </div>

                            <div id="editarAg">
                                <select data-placeholder="Selecione o tipo.."  id="status_editar" class="form-control">
								<option value=""> - </option> 
                                <option value="CADASTRADO" style="display: none">CADASTRADO</option>
                                <option value="RECEBIDO" style="display: none">RECEBIDO</option>
                                <option value="SIFBN OK" style="display: none">SIFBN OK</option>
                                <option value="SEM COMANDO SIFBN" style="display: none">SEM COMANDO SIFBN</option>
                                <option value="CANCELADO">CANCELADO</option>
                                <option value="CONTA DIVERGENTE" style="display: none">CONTA DIVERGENTE</option>
                                <option value="VALOR DIVERGENTE" style="display: none">VALOR DIVERGENTE </option>
                                <option value="CONTA PF" style="display: none">CONTA PF</option>
                                <option value="CONTRATO EM CA" style="display: none">CONTRATO EM CA</option>
                                <option value="GESTOR RESIDUO SIFBN" style="display: none">RESIDUO SIFBN</option>
                                <option value="GESTOR" style="display: none">GESTOR</option>
                                <option value="SEM SALDO" style="display: none">SEM SALDO</option>
                                <option value="CONCLUIDO" style="display: none">CONCLUIDO</option>
                                <option value="CORRIGIDO">CORRIGIDO</option>
							    </select>

                            </div>
                                
                            </div>
                             <div class="col-sm-2">
                                <label class="control-label">PV</label>
                                <input placeholder="..." id="pv_editar" class="form-control" type="text" disabled>
                            </div>
                              <div class="col-sm-2">
                                <label class="control-label">SR</label>
                                 <input placeholder="..." id="sr_editar" class="form-control" type="text" disabled>
                            </div>
                              <div class="col-sm-2">
                                <label class="control-label">GIGAD</label>
                                 <input placeholder="..." id="gigad_editar" class="form-control" type="text" disabled>
                            </div>
                            </div>
                            
                        <br>
                            
                            <label>Observações</label>
                            <textarea class="form-control" rows="3" name="co_observacoes" id="observacaoContrato" placeholder="Digite as observações da solicitação aqui...."></textarea> 
                              <br>
                              <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h6 class="panel-title"><i class="icon-coin"></i> Histórico de saldo</h6>
                                </div>
                                
                                <div class="panel-body tabResponsiva">
                                
                                <table id= "tabConsultaSaldoEditar"class="table table-bordered table-striped datatable">
                                    <thead>
                                        <tr>
                                            <th hidden> Consulta </th>
                                            <th> Data e Hora</th>
                                            <th> Status </th>
                                            <th> Saldo Disponível </th>
                                            <th> Saldo Bloqueado </th>
                                            <th> Limite Cheque Azul </th>
                                            <th> Limite GIM </th>
                                            <th> Saldo considerado </th>                                          
                                        </tr>
                                    </thead>
                                    <tbody>  </tbody>
                                </table>
                                
                                
                                </div>
                                </div>
                            </div>
            
                        
                    </form>
                            
                    </div>
                            
                        <div class="tab-pane body fade" id="tabHistoricoEditar">
                            <div class="row">
                                <div class="panel-heading">
                                   <h6 class="panel-title"><i class="icon-vcard"></i> Histórico do contrato</h6>
                                </div>
                               
                               <div class="panel-body tabResponsiva">
                               
                                <table id= "tabConsultaHistoricoEditar" class="table table-bordered table-striped datatable">
                                   <thead>
                                       <tr>
                                            <th> Pedido </th>
                                            <th> Data e Hora</th>
                                            <th> Status </th>
                                            <th> Observações </th>
                                            <th> Responsável </th>
                                            <th> Unidade </th>
                                                                                    
                                       </tr>
                                   </thead>
                                   <tbody ></tbody>
								</table>
                               
                                </div>
                            </div>
                          
                        </div>
  
                </div>                       
                      
            </div>
                <div class="modal-footer">
                   
                    <button class="btn btn-default btn-success pull-right botaoModal" data-dismiss="modal" onclick= enviarSolicitacao()> Enviar </button>
                    <span class="pull-right"> </span>
                    <button class="btn btn-default btn-danger pull-right botaoModal" data-dismiss="modal">Fechar</button> 
                            
            </div>
                </div>                
            </div>
        </div>
    </div>
    <!-- /Modal para editar status -->
    
     
    <!-- Modal para confirmar cadastro-->
    
    <div id="confirmacao" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><i class="icon-checkmark"></i>Dados Cadastrados com sucesso!!</h4>
                </div>

                <div class="modal-body with-padding">
                    <p>Consulte em seus pedidos os protocolos gerados e acompanhe o processo de amortização na aba pedidos.</p>
                </div>

                <div class="modal-footer">
                    
                    <button class="btn btn-success" data-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /Modal para confirmar cadastro-->

         <!-- /Modal confimar edição-->
    
         <div id="modalErro" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-sm alert">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                     <h4 class="modal-title"><i class="icon-checkmark"></i>Cadastro não efetuado.</h4>
                </div>
                <div class="modal-body with-padding">
                    <p>Não foi possível efetuar o cadastro, favor tentar novamente!</p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success center" data-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /Modal confimar edição-->

    
     
    
<!-- --------------------FIM CONTRUÇÃO DE MODAL--------------
###################################################################################################
###################################################################################################
#################################################################################################### -->



    <!-- Page header -->
    <div class="page-header">
        <div class="page-title">
            <h3 >Amortização \ Liquidação <small>Bem Vindo <span id="nomeSessaoBemVindo"></span> </small></h3>
        </div>

    </div>
    <!-- /page header -->


    <!-- Breadcrumbs line -->
    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="index.html">Amortização - Liquidação </a></li>
            <li class="active perfilVisualizacao"></li>
        </ul>
    </div>
    
   
    <div class="tabbable page-tabs">
        <ul class="nav nav-tabs" id="abasDasTabelas">
            <li class="active" id="abaContratosLiquidar">
            <a  href="#contratosliquidar" data-toggle="tab"><i class="icon-paragraph-justify2"></i> Solicitar Liquidação/Amortização  </a></li>
            <li id="abaLoteAtual"><a href="#loteAtual" data-toggle="tab"><i class="icon-exit4"></i> Pedidos lote dia <span id="dataLoteAtual"></span>  </a></li>
            <li id="abaAmortizaant"><a href="#amortizaant" data-toggle="tab"><i class="icon-exit3"></i> Pedidos Lote dia <span id="dataLoteAnterior"></span></a></li>
            <li id="abaGestor"><a href="#GESTOR" data-toggle="tab"><i class="icon-hammer"></i>Contratos no GESTOR</a></li>
            <li id="abaAmortizaTodas"><a href="#amortizatodas" data-toggle="tab"><i class="icon-file4"></i>Pedidos Anteriores </a></li>
        </ul>

    <!-- conteudo tabelas -->

    
        <!-- tabela contratos agência -->
        <div class="tab-content">
        
            <div class="tab-pane active fade in" id="contratosliquidar">

            
                <!-- Default datatable inside panel -->
                <div class="panel panel-default">
                <div class="panel-heading"><h6 class="panel-title"><i class="icon-table"></i> Contratos da <span id="agenciaContrato"></span> </h6></div>
                    
                    <div class="tabResponsiva">
                    <h6 class="panel-title">Data limite para solicitação <span class="dataLimite" id="dataLimiteCadastro"></span></h6>
                    
                        <table id="tabelaContratosLiquidar" class="table table-striped table-hover">
                            <thead>
                                <tr>
                                   
                                    <th>Tomador</th>                             
                                    <th>CNPJ</th>
                                    <th class= "text-center">Solicitar liquidação/amortização</th>
                                   
                                </tr>
                                        
                            </thead>

                                <tbody></tbody>
                        </table>
                     </div>
                </div>
                    
            </div>

     <!-- tabela contratos tratamento ceopc -->
        
            <div class="tab-pane" id="loteAtual">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h6 class="panel-title"><i class="icon-table"></i> Lista de solicitações referentes ao lote : <span id ="proxLote"></span></h6>
                    </div>
                    <div class="tabResponsiva">
                        <table id="tabelaLoteAtual" class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Pedido</th>
                                    <th>Tomador</th>
                                    <th>Ctr CAIXA</th>
                                    <th>Ctr BNDES</th>
                                    <th>Conta</th>
                                    <th class="dinheiro">Valor</th>
                                    <th>Comando</th>
                                    <th>Status</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                                <tbody> </tbody>
                        </table>
                    </div>
                </div>
                    
            </div>
            

            <!-- contratos lote anterior -->
            <div class="tab-pane" id="amortizaant">
            
                    <!-- Default datatable inside panel -->
                    <div class="panel panel-default">
                            <div class="panel-heading">
                                <h6 class="panel-title">
                                <i class="icon-table"></i>  Lista de solicitações referentes ao lote : <span id ="loteAnt"></span></h6>
                            </div>

                            <div class="tabResponsiva">
                                    <table id="tabelaLoteAnterior" class="table table-striped table-hover ">
                                        <thead>
                                            <tr>
                                                <th>Pedido</th>
                                                <th>Tomador</th>
                                                <th>Ctr CAIXA</th>
                                                <th>Ctr BNDES</th>
                                                <th>Conta</th>
                                                <th>Valor</th>
                                                <th>Comando</th>
                                                <th>Status</th>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                            </div>
                    </div>
                    
            </div>
            

<!-- inicio teste de inclusão da aba do gestor -->

        <div class="tab-pane" id="GESTOR">

                    <!-- Default datatable inside panel -->
                    <div class="panel panel-default">
                            <div class="panel-heading">
                                <h6 class="panel-title">
                                <i class="icon-table"></i>  Lista de solicitações com análise Pendente pelo GESTOR:</h6>
                            </div>

                            <div class="tabResponsiva">
                                    <table id="tabelaGestor" class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Pedido</th>
                                                <th>Tomador</th>
                                                <th>Ctr CAIXA</th>
                                                <th>Ctr BNDES</th>
                                                <th>Lote</th>
                                                <th>Valor</th>
                                                <th>Comando</th>
                                                <th>Status</th>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody> </tbody>
                                    </table>
                            </div>
                    </div>
                    
            </div>
            
<!-- fim da aba do GESTOR -->


    <!-- tabela onde constam todas as solicitações         -->
    <div class="tab-pane" id="amortizatodas">

    <div class="tabbable page-tabs">
        <ul class="nav nav-pills" id="tabela-pesquisa">
            <li class="nav-item active">
            <a class="nav-link active" href="#listasolicitacoes" data-toggle="tab"><i class="icon-table"></i>Lista de solicitações por Lote</a></li>
            <li class="nav-item"><a class="nav-link" href="#pesquisasolicitacoes" data-toggle="tab"><i class="icon-table"></i>Pesquisa liquidação/amortização</a></li>
                      
        </ul>

        <div class="tab-content">
        
            <div class="tab-pane fade active in" id="listasolicitacoes">

            <!-- Default datatable inside panel -->
                <div class="panel panel-default">
                
                <div class="tabResponsiva">
                        <table id="tabelaListaSolicitacoes" class="table table-striped table-hover">
                            <thead>
                                <tr>
                                <th align="center">Lote</th>
                                <th align="center">Quantidade Solicitada</th>
                                <th align="center">Quantidade Acatada</th>
                                <th align="center">Quantidade Cancelada</th>
                                <th align="center">Quantidade outros Status</th>
                                <th align="center" class="dinheiro">Valor do Lote</th>
                                <th></th>
                                </tr>
                                        
                            </thead>

                                <tbody> </tbody>
                        </table>
                    </div>
                </div>
                
            </div>

            <div class="tab-pane fade" id="pesquisasolicitacoes">

                        <!-- Default datatable inside panel -->
                        <div class="panel panel-default">
                        
                            <div class="tabResponsiva">
                                    <table id="tabelaPesquisaSolicitacoes" class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th align="center">Pedido</th>
                                                <th align="center">CNPJ</th>
                                                <th align="center">Contrato Caixa</th>
                                                <th align="center">Tomador</th>
                                                <th align="center" class="dinheiro">Valor</th>
                                                <th align="center">Lote</th>
                                                <th></th>                                           
                                            </tr>
                                        </thead>
                                        <tbody> </tbody>
                                    </table>
                            </div>
                        </div>
                        
            </div>
         
        </div> 
    </div>

        </div>
    </div>
    
    
    
    <!--DUVIDAS FREQUENTES-->
     <div class="row">
     <br>
     <br>
     <br>
        <div class="col-md-6">

            <!-- Questions -->
            <h6><i class="icon-question5"></i> Dúvidas Frequentes na Amortização \ Liquidação</h6>
            <div class="panel-group block">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h6 class="panel-title panel-trigger">
                            <a data-toggle="collapse" href="#question1">1. O que mudou na Amortização?</a>
                        </h6>
                    </div>
                    <div id="question1" class="panel-collapse collapse">
                        <div class="panel-body">
                            <p class="alert alert-success fade in text-center">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                Mudamos a forma de atuar com intuito de proporcionar a melhor experiência ao usuário.
                            </p>		
                            <hr>							
                            <p><strong>Agora as solicitações de amortização geram um protocolo de pedido que pode ser facilmente acompanhado.</strong></p>
                            Você pode clicar no botão para visualização de pedidos e lá tem o histórico de atuação na demanda.
                        </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h6 class="panel-title panel-trigger">
                            <a data-toggle="collapse" href="#question2">2. O que eu devo fazer para amortizar ou liquidar um contrato?</a>
                        </h6>
                    </div>
                    <div id="question2" class="panel-collapse collapse">
                        <div class="panel-body">
                            <p class="alert alert-success fade in text-center">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                É facil, no menu de amortização você deve escolher a empresa e clicar em solicitar amortização/liquidação.
                            </p>		
                            <hr>							
                            <p><strong>Ao clicar no botão de solicitação você deve prosseguir preenchendo os campos solicitados.</strong></p>
                            Os campos solicitados são Contrato CAIXA, Contrato BNDES, Nome do Tomador, Conta para débito, valor de amortização e o tipo de comando(amortização/liquidação).
                            Ficou mais facil né!
                        </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h6 class="panel-title panel-trigger">
                            <a data-toggle="collapse" href="#question3">3. Como era solicitada uma amortização BNDES e como é agora?</a>
                        </h6>
                    </div>
                    <div id="question3" class="panel-collapse collapse">
                        <div class="panel-body">
                            <p class="alert alert-success fade in text-center">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                Antes a amortização era tratada pela GEMCO e agora é pela CEOPC!
                            </p>		
                            <hr>							
                            <p><strong>...mas efetivamente o que mudou?</strong></p>
                            Agora o processo cadastrado terá mais transparência pois poderá ser acompanhado pelo SIAF neste módulo.<br>
                        </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h6 class="panel-title panel-trigger">
                            <a data-toggle="collapse" href="#question4">4. Como acompanho a minha solicitação?</a>
                        </h6>
                    </div>
                    <div id="question4" class="panel-collapse collapse">
                        <div class="panel-body">
                            <p class="alert alert-success fade in text-center">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                Essa é facil.
                            </p>		
                            <hr>							
                            <p><strong>Ali em cima , clique na aba corresponde ao mês da liquidação.</strong></p>
                            Você pode visualizar o histórico do pedido, as datas das verificações de saldo, a conclusão do processo, além de verificar possíveis pendências e corrigi-las.
                        </div>
                    </div>
                </div>
                    <div class="panel panel-default">
                    <div class="panel-heading">
                        <h6 class="panel-title panel-trigger">
                            <a data-toggle="collapse" href="#question5">5. O que significa cada STATUS?</a>
                        </h6>
                    </div>
                    <div id="question5" class="panel-collapse collapse">
                        <div class="panel-body">
                            <p class="alert alert-success fade in text-center">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                É simples, veja a legenda abaixo.
                            </p>		
                            <hr>	
                            <p><strong>CADASTRADO - </strong> Demanda cadastrada pela AG, SR ou GIGAD.</p>
                            <p><strong>CANCELADO - </strong> Demanda cancelada pela AG, SR, GIGAD ou CEOPC.</p>
                            <p><strong>RECEBIDO - </strong> Demanda em processamento aguardando dia de débito (dia 15).</p>
                            <p><strong>SIFBN OK - </strong> Demanda comandada no SIFBN/SIBAN, pronta para verificação automática de saldo.</p>
                            <p><strong>GESTOR - </strong> Demanda enviada à GESTOR para tratamento .</p>
                            <p><strong>CONTA DIVERGENTE - </strong> Demanda com pendência. </p>
                            <p><strong>VALOR DIVERGENTE - </strong> Demanda com pendência.</p>
                            <p><strong>CONTA PF - </strong> Demanda com pendência.</p>
                            <p><strong>CONTRATO EM CA - </strong> Demanda cancelada pela CEOPC.</p>
                            <p><strong>CONCLUIDO - </strong> Demanda de amortização\liquidação efetivada.</p>
                            <p><strong>RESÍDUO SIFBN - </strong> Demanda liquidada com pendência no SIFBN enviada para GESTOR para tratamento.</p>
                            <p><strong>SEM SALDO - </strong> Demanda cancelada pela CEOPC por falta de saldo na conta de débito.</p>
                            <p><strong>SEM COMANDO SIFBN - </strong> Demanda cancelada pela CEOPC por falta de comando por parte da agência.</p>
						
                        </div>
                    </div>
                </div>

                
            </div>
            <!-- Questions -->


        </div>
        <!--DUVIDAS FREQUENTES-->
        
        
                            <div class="col-md-6">
                            <div class="thumbnail thumbnail-boxed">
                                <div class="thumb">
                                    <img alt="" src="../images/Bndes/NovoSiaf/decop.jpg">
                                    <div class="thumb-options">
                                        <span>
                                            <a href="#" onclick=" window.open('http://www.ceopc.sp.caixa/novosiaf/padrao/geopc/sumep/ceopc/modulosiaf.php')" class="btn tip" title="Clique aqui e navegue pela video apresentação de slides!"><img alt="" src="../images/Bndes/NovoSiaf/decop6.png"></a>
                                            
                                        </span>
                                    </div>
                                </div>
                                <div class="caption">
                                    <a href="#" onclick=" window.open('http://www.ceopc.sp.caixa/novosiaf/padrao/geopc/sumep/ceopc/modulosiaf.php')"title="" class="caption-title">Novo Módulo SIAF Amortização - Apresentação </a>
                                    Clique no logo apresentado sobre a imagem para ser direcionado à video apresentação de divulgação deste módulo, navegue pelos slides, no menu a esquerda você encontra alguns esclarecimentos adicionais.
                                </div>
                            </div>
                            </div>
  
        </div>
   
    </div>
    
    <!-- Footer -->
    <div class="footer clearfix">
        <div class="pull-left">&copy; 2019. Equipe TI CEOPC </div>
    </div>
    <!-- /footer -->


</div>
<!-- /page content -->


</div>
<!-- /page container -->

</body>
</html>

        <script src="{{ asset('js/Bndes/NovoSiaf/carrega.perfil.js')}}"></script>
        <script src="{{ asset('js/plugins/forms/wysihtml5/wysihtml5.min.js')}}"></script>
        <script src="{{ asset('js/plugins/forms/wysihtml5/toolbar.js')}}"></script>
        <script src="{{ asset('js/plugins/charts/sparkline.min.js')}}"></script>
        <script src="{{ asset('js/plugins/forms/uniform.min.js')}}"></script>
        <script src="{{ asset('js/plugins/forms/select2.min.js')}}"></script>
        <script src="{{ asset('js/plugins/forms/inputmask.js')}}"></script>
        <script src="{{ asset('js/plugins/forms/inputlimit.min.js')}}"></script>
        <script src="{{ asset('js/plugins/forms/listbox.js')}}"></script>
        <script src="{{ asset('js/plugins/forms/multiselect.js')}}"></script>
        <script src="{{ asset('js/plugins/forms/validate.min.js')}}"></script>
        <script src="{{ asset('js/plugins/forms/tags.min.js')}}"></script>
        <script src="{{ asset('js/plugins/forms/switch.min.js')}}"></script>
        <script src="{{ asset('js/plugins/forms/uploader/plupload.full.min.js')}}"></script>
        <script src="{{ asset('js/plugins/forms/uploader/plupload.queue.min.js')}}"></script>       
        <script src="{{ asset('js/plugins/interface/daterangepicker.js')}}"></script>
        <script src="{{ asset('js/plugins/interface/fancybox.min.js')}}"></script>
        <script src="{{ asset('js/plugins/interface/moment.js')}}"></script>
        <script src="{{ asset('js/plugins/interface/jgrowl.min.js')}}"></script>
        <script src="{{ asset('js/plugins/interface/datatables.min.js')}}"></script>
        <script src="{{ asset('js/plugins/interface/colorpicker.js')}}"></script>
        <script src="{{ asset('js/plugins/interface/fullcalendar.min.js')}}"></script>
        <script src="{{ asset('js/plugins/interface/timepicker.min.js')}}"></script>    
        <script src="{{ asset('js/plugins/forms/autosize.js')}}"></script>
        <script src="{{ asset('js/bootstrap.min.js')}}"></script>
        <script src="{{ asset('js/application.js')}}"></script>
        <script src="{{ asset('js/Bndes/NovoSiaf/data.lote.js')}}"></script>
        <script src="{{ asset('js/Bndes/NovoSiaf/dados.contratos.Ag.js')}}"></script>
        <script src="{{ asset('js/Bndes/NovoSiaf/dados.amortizacao.loteAtual.js')}}"></script>
        <script src="{{ asset('js/Bndes/NovoSiaf/dados.amortizacao.loteAnterior.js')}}"></script>
        <script src="{{ asset('js/Bndes/NovoSiaf/dados.contratoGestor.js')}}"></script>
        <script src="{{ asset('js/Bndes/NovoSiaf/valida.cadastroAmortizacao.js')}}"></script>
        <script src="{{ asset('js/Bndes/NovoSiaf/dados.pesquisaLote.js')}}"></script>
        <script src="{{ asset('js/Bndes/NovoSiaf/dados.pesquisa12meses.js')}}"></script>
        <script src="{{ asset('js/Bndes/NovoSiaf/dados.editarContrato.js')}}"></script>
        <script src="{{ asset('js/Bndes/NovoSiaf/carrega.idTabela.js')}}"></script>
        <script src="{{ asset('js/Bndes/NovoSiaf/funcoesModal.js')}}"></script>
        <script src="{{ asset('js/Bndes/NovoSiaf/atualiza.tabelas.js')}}"></script>
</body>

</html>
