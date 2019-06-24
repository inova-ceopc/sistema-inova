@extends('adminlte::page')

@section('title', 'Esteira Comex - Cadastro Email Op')


@section('content_header')
    
<div class="panel-body padding015">
    <h4 class="animated bounceInLeft pull-left">
        Gerenciador de email externos | 
        <small>Lista de emails externos cadastrados na esteira</small>
    </h4>
    
    <ol class="breadcrumb pull-right">
            <li><a href="#"><i class="fa fa-map-signs"></i>Acompanhamentos</a></li>
            <li><a href="#"></i>Envio de Ordens</a></li>
    </ol>
</div>

@stop


@section('content')

<div class="container-fluid">
    <div class ="panel panel-default">
        <div class="panel-body">
        
            <div>
                <h3>Atualização de e-mails Corporativo</h3>
                <p>O propósito desta página é o de agilizar a comunicação entre a CAIXA e o cliente corporativo (COMEX).</p>
            </div>
            <div class="alert bg-warning" role="alert" id>
                <p class="text-danger">## ATENÇÃO ##</p>
                <p>Declaro estar ciente de que a inclusão ou alteração do e-mail precede a expressa manifestação do cliente para recepção de avisos de ordens de pagamento recebidas pela CAIXA através deste canal de comunicação. 
                A não observância deste procedimento pode ocasionar em risco de imagem para CAIXA e apuração de responsabilidade nos moldes do AE079.</p>
            </div>
            <div class="table-responsive">
                <table id="tabelaEmail"class="table table-striped display">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>CNPJ</th>
                            <th>Email Principal</th>
                            <th>Agência</th>
                            <th align="center">Ação</th>
                            
                        </tr>
                    </thead>

                    <tbody> 
                   
                    <tr>

                        <td>Cliente</td>
                        <td>CNPJ</td>
                        <td>xxx@hotmail.com</td>
                        <td>0267</td>
                        <td align="center">
                        <button type="button" class="btn btn-default glyphicon glyphicon-search" rel="tooltip" title="Visualizar" onclick ="visualizaModal()"></button>
                        <button type="button" class="btn btn-default glyphicon glyphicon-pencil" rel="tooltip" title="Editar" onclick ="editaModal()"></button>
                        <button type="button" class="btn btn-default glyphicon glyphicon-book" rel="tooltip" title="Historico" onclick ="historicoModal()"></button></td>    
                    
                    </tr>
                    </tbody>

                </table>
            </div>
            
                @component('Componentes.modal')

                    @section('cabecalhoModalVisualizar')
                    Visualizar Informações - Dados Cadastrados
                    @endsection
                    @section('conteudoModalVisualizar')

                    <form method="post" action="email_cliente_esteira/altera_cadastro.php" name="formCadastro">         
                    <div class="row">  
                        <div id="modalEmail"></div>
							   
                        <div class="col-sm-12">
                                <label class="control-label">Nome da Empresa</label>
                                <input placeholder="..." name="nomeEmpresa" id="nomeEmpresa" class="form-control" type="text" readonly>
                        </div>

                        <div class="col-sm-6">
                            <label class="control-label">CNPJ</label>
                            <input placeholder="..." name="cnpjEmpresa" id="cnpjEmpresa" class="form-control" type="text" readonly >
                        </div>
																	
                        <div class="col-sm-2">
                            <label class="control-label">Agencia</label>
                            <input placeholder="..." id="pvEmpresa" class="form-control" type="text" readonly >
                        </div>

                        <div class="col-sm-4">
                            <label class="control-label">Nome da Agencia</label>
                            <input placeholder="..."  id="nomeAgencia"class="form-control" type="text" readonly >
                        </div>

                    </div> <!--fecha div row -->
							<br>

                        <div class="row">    
                        <div class="col-sm-12">
                            <label class="control-label">Email Principal</label>
                            <input placeholder="..." name="emailPrincipal" id="emailPrincipal"class="form-control" type="email" readonly>
                        </div>
                        <div class="col-sm-12">
                            <label class="control-label">Email Secundário</label>
                            <input placeholder="..." name="emailSecundario" id="emailSecundario"class="form-control" type="email" readonly>
                        </div>
                        <div class="col-sm-12">
                            <label class="control-label">Email Reserva</label>
                            <input placeholder="..." name="emailReserva" id="emailReserva"class="form-control" type="email" readonly>
                        </div> <!--fecha div row -->
                    </div>
                    </form>

                    @endsection

                    @section('cabecalhoModalEditar')
                    Alterar Emails Cadastrados
                    @endsection

                    @section('conteudoModalEditar')

                    <form method="post" action="email_cliente_esteira/altera_cadastro.php" name="formCadastro">         
                    <div class="row">  
                        <div id="modalEmail"></div>
							   
                        <div class="col-sm-12">
                                <label class="control-label">Nome da Empresa</label>
                                <input placeholder="..." name="nomeEmpresa" id="nomeEmpresa" class="form-control" type="text" readonly>
                        </div>

                        <div class="col-sm-6">
                            <label class="control-label">CNPJ</label>
                            <input placeholder="..." name="cnpjEmpresa" id="cnpjEmpresa" class="form-control" type="text" readonly >
                        </div>
																	
                        <div class="col-sm-2">
                            <label class="control-label">Agencia</label>
                            <input placeholder="..." id="pvEmpresa" class="form-control" type="text" readonly >
                        </div>

                        <div class="col-sm-4">
                            <label class="control-label">Nome da Agencia</label>
                            <input placeholder="..."  id="nomeAgencia"class="form-control" type="text" readonly >
                        </div>

                    </div> <!--fecha div row -->
							<br>

                        <div class="row">    
                        <div class="col-sm-12">
                            <label class="control-label">Email Principal</label>

                            <input placeholder="..." name="emailPrincipal" id="emailPrincipal"class="form-control" type="email">

                        </div>
                        <div class="col-sm-12">
                            <label class="control-label">Email Secundário</label>
                            <input placeholder="..." name="emailSecundario" id="emailSecundario"class="form-control" type="email" >
                        </div>
                        <div class="col-sm-12">
                            <label class="control-label">Email Reserva</label>
                            <input placeholder="..." name="emailReserva" id="emailReserva"class="form-control" type="email" >
                        </div> <!--fecha div row -->
                    </div>
                    </form>

                    @endsection

                    @section('cabecalhoModalHistorico')
                    Histórico de alterações
                    @endsection
                    @section('conteudoModalHistorico')
                    <p>Estão listadas abaixo cinco últimas alterações realizadas</p>
                        <div class="row">  
                                
                            <div class="col-sm-12">
                                <label class="control-label">Nome da Empresa</label>
                                <input placeholder="..." name="nomeEmpresaHistorico" id="nomeEmpresaHistorico" class="form-control" type="text" readonly>
                            </div>                            
                            <br>                            
                            <div class="panel-body">
                                <table id="tabelaHistorico" class="table table-bordered table-striped datatable">
                                    <thead>
                                        <tr>
                                            <th> Data e Hora </th>
                                            <th> Ação </th>
                                            <th> Histórico </th>
                                            <th> Alterado Por </th>			
                                        </tr>
                                    </thead>
                                    <tbody> </tbody>
                                    
                                </table>
                            </div>                        

                        </div> <!--fecha div row -->


                    <p>Estão listadas abaixo cinco últimas alterações realizadas</p>
                        <div class="row">  
                                
                            <div class="col-sm-12">
                                <label class="control-label">Nome da Empresa</label>
                                <input placeholder="..." name="nomeEmpresaHistorico" id="nomeEmpresaHistorico" class="form-control" type="text" readonly>
                            </div>
                            
                            <br>
                            
                                    <div class="panel-body">
                                        <table id="tabelaHistorico" class="table table-bordered table-striped datatable">
                                            <thead>
                                                <tr>
                                                    <th>Data e Hora</th>
                                                    <th> Ação </th>
                                                    <th> Histórico </th>
                                                    <th> Alterado Por </th>			
                                                </tr>
                                            </thead>
                                            <tbody> </tbody>
                                            
                                        </table>
                                    </div>
                        </div> <!--fecha div row -->

                    @endsection
                   
                @endcomponent
        </div>
    </div>
</div>
@stop


@section('css')
   
    <link href="{{ asset('css/comex/index.css') }}" rel="stylesheet" type="text/css"> 
    <link href="{{ asset('css/contratacao/cadastro.css') }}" rel="stylesheet">

   
@stop


@section('js')

    <script src="{{ asset('js/Comex/index.js')}}"></script>

@stop