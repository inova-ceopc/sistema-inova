<div class="box box-danger ">
    <div class="box-header with-border">
    <h3 class="box-title">ACC/ACE</h3>

    <h5 class="text-left">Analises das solicitações de liquidação ACC/ACE</h5>

    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. 
        A consectetur neque cumque cupiditate voluptates quaerat ut delectus mollitia nemo, 
        blanditiis exercitationem maiores error. Nobis perferendis autem magnam itaque consequatur earum.
    </p>

    </div>
    <div class="box-body">
        <div class="tabbable page-tabs">
            <ul class="nav nav-tabs" id="abas">
                <li class="active" id="abaAccDia">
                <a  href="#liquidacaoDia" data-toggle="tab"><i class="icon-paragraph-justify2"></i> Liquidadas Dia </a></li>
                <li id="abaAccMes"><a href="#liquidacaoMes" data-toggle="tab"><i class="icon-exit4"></i> Liquidadas Mês </a></li>                </ul>    
            </ul>
            <div class="tab-content">
    
                <div class="tab-pane active fade in" id="liquidacaoDia">
                    <div class="box chart-container ">
                    <canvas id="analisesAccAce30dias" style="position: relative; width=750px; height=250px;"></canvas>
                    </div>
                </div>
                  
                <div class="tab-pane" id="liquidacaoMes">
                    <div class="box chart-container ">
                    <canvas id="analisesAccAceMensal" style="position: relative; width=750px; height=250px;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>         
</div>