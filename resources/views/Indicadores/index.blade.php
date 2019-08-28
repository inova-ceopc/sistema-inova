@extends('Indicadores.layout')


    @section('css')
    <link href="{{ asset('css/indicadores/painel.css') }}" rel="stylesheet">

    @endsection
   <!-- o conteudo do carrossel está no arquivo layout.blade -->

    <!--resultados indicadores  -->
    <!-- nesta sessão estão os conteudos referentes aos cards que constam no carrossel sendo que todos os dysplays estão escondidos(none) 
    e tratados no arquivo js mudando a propriedade -->
    @section('conteudo')
    <!-- item -->
        <div id="op">
            <h3>ORDENS DE PAGAMENTO</h3>
            
            <div class="box-body">
        
                <div class="chart-container" style="position: relative; width:85%">
                    <canvas id="graficoOP" ></canvas>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
    <!-- item -->
        <div id="accAce" style="display: none;">
            <!-- <div class="box-header with-border"> -->
            <h3>ACC/ACE</h3>
            <h5>Analises das solicitações de liquidação ACC/ACE</h5>
            <!-- </div> -->
            <div class="box-body">
                <div class="tabbable page-tabs">
                    <ul class="nav nav-tabs" id="abas">
                        <li class="active" id="abaAccDia">
                        <a  href="#liquidacaoDia" data-toggle="tab"><i class="icon-paragraph-justify2"></i> Liquidadas Dia </a></li>
                        <li id="abaAccMes"><a href="#liquidacaoMes" data-toggle="tab"><i class="icon-exit4"></i> Liquidadas Mês </a></li>                </ul>    
                    </ul>
                    <div class="tab-content">
            
                        <div class="tab-pane active fade in" id="liquidacaoDia">
                            <div class="chart-container" style="position: relative; width:75%">
                            <canvas id="analisesAccAce30dias"></canvas>
                            </div>
                        </div>
                        
                        <div class="tab-pane" id="liquidacaoMes">
                            <div class="chart-container" style="position: relative; width:75%">
                            <canvas id="analisesAccAceMensal"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
        </div>

<!-- item -->
        <div id="antecipados" style="display: none;">
        
            <h3>ANTECIPADOS</h3>
            <h5>Conformidade Pronto/Importação/Exportação</h5>
            
            <div class="box-body">
        
                <div class="row">
                    <div class="col-md-2" ></div>
                    <div class="col-md-3 col-sm-6 col-xs-12">  
                        <div class="info-box">   
                        <span class="info-box-icon bg-green"><i class="fa fa-pencil"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Contratados/Mês</span>
                                <span id= "contratado" class="info-box-number text-center"></span>
                            </div>
                        <!-- /.info-box-content -->
                        </div>
                    </div>
                    
        
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="info-box">
                        <span class="info-box-icon bg-green"><i class="fa fa-check"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Conforme/Mês</span>
                                <span id="conforme" class="info-box-number text-center"></span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                    </div> 
                

                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="info-box">
                        <span class="info-box-icon bg-green"><i class="fa fa-times"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Bloqueado/Mês</span>
                            <span id="bloqueado" class="info-box-number text-center"></span>
                        </div>
                        <!-- /.info-box-content -->
                        </div>
                    </div> 
                    <div class="col-md-1" ></div>
                </div> 
                <!-- /row -->
                <br>
                <div class ="row">
                    <div class="col-md-2" ></div>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="info-box">
                        <span class="info-box-icon bg-green"><i class="fa fa-exclamation-circle"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Reiterado/Mês</span>
                                <span id="reiterado" class="info-box-number text-center"></span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                    </div> 
            
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="info-box">
                        <span class="info-box-icon bg-green"><i class="fa fa-external-link"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Cobrados/Mês</span>
                                <span id="cobrado" class="info-box-number text-center"></span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                    </div> 
                </div>
                <!-- /row -->
            </div>
            <!-- /.box-body -->
        </div>

    <!--item-->
            <div id="atendimento" style="display: none;">
              <!-- <div class="box-header with-border"> -->
              <h3 class="box-title">ATENDIMENTO MIDDLE</h3>
              <h5>Resultados referentes aos atendimentos prestados pelo Middle Office</h5>
              <h5>Para mais informações<a href="http://www.ceopc.hom.sp.caixa/atendimento_web/view/indicadores_atendimento_middle.php"> Clique Aqui</a></h5>
              <!-- </div> -->
              <div class="box-body">
                <div class="col-md-3 col-sm-6 col-xs-12">
                  <div class="info-box">
                    <span class="info-box-icon bg-yellow"><i class="fa fa-star-o"></i></span>

                    <div class="info-box-content">
                    <span class="info-box-text">Média Nota/Mês</span>
                    <span class="info-box-number">4</span>
                    </div>
                    
                  </div>
                </div>

                <div class="col-md-3 col-sm-6 col-xs-12">
                  <div class="info-box">
                    <span class="info-box-icon bg-yellow"><i class="fa fa-user-o"></i></span>

                    <div class="info-box-content">
                    <span class="info-box-text text-center">Rotina/</span>
                    <span class="info-box-text text-center">Consultoria</span>
                    <span class="info-box-number text-center">162</span>
                    </div>
                  </div>
                </div>

                <div class="col-md-6 col-sm-6 col-xs-12">
                  <div class="info-box">
                    <span class="info-box-icon bg-yellow"><i class="fa fa-phone"></i>
                    </span>

                    <div class="info-box-content">
                    <span class="info-box-text text-center"><strong>Canal Atendimento</strong></span>
                    <div class="col-md-4 col-sm-4 col-xs-6">
                    <span class="info-box-text">Email</span>
                    <span class="info-box-number">107</span> 
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-6"> 
                    <span class="info-box-text">Lync</span>
                    <span class="info-box-number">44</span>  
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-6">
                    <span class="info-box-text">Telefone</span>
                    <span class="info-box-number">11</span>
                    </div>
                    </div>
                    
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
            <!-- </div> -->
            </div>

            <!--item-->
            <div id="quantidadeContratacao" style="display: none;">
              <!-- <div class="box-header with-border"> -->
              <h3 class="box-title">Contratações</h3>
              <h5>Quantidade de contratações</h5>
              <!-- </div> -->
              <div class="box-body">
                <div class="col-md-3 col-sm-6 col-xs-12">
                  <div class="info-box">
                    <span class="info-box-icon bg-blue"><i class="fa fa-star-o"></i></span>

                    <div class="info-box-content">
                    <span class="info-box-text">Quantidade</span>
                    <span class="info-box-text text-center">Contratos</span>
                    <span class="info-box-number">4</span>
                    </div>
                    
                  </div>
                </div>

                <div class="col-md-3 col-sm-6 col-xs-12">
                  <div class="info-box">
                    <span class="info-box-icon bg-blue"><i class="fa fa-user-o"></i></span>

                    <div class="info-box-content">
                    <span class="info-box-text text-center">valor</span>
                    <span class="info-box-text text-center">MN</span>
                    <span class="info-box-number text-center">R$ 2.080.270,00</span>
                    </div>
                  </div>
                </div>

                <div class="chart-container" style="position: relative; width:65%">
                    <canvas id="contratacoes" ></canvas>
                </div>
            </div>
              <!-- /.box-body -->
            </div>

            @endsection
          <!-- /final valores do indicador -->
 
   


   
    @section('js')
    <script src="{{asset('js/indicadores/indicadores-comex.js')}}"></script>
    @endsection