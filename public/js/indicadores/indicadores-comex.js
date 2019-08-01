var cliente, email, accCadastradas, accCanceladas, accLiquidadas; 
var opQuantidade = [], opDia = [];
var agora = new Date;

  /* Começo: Esta função altera dinamicamente o mês na página de indicadores */
    
function DataAtual(){
   
    var meses = ['Janeiro', 'Fevereiro', 'Março','Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro','Novembro','Dezembro'];
    let hoje = agora.getMonth();
        return meses[hoje];
}

var mesAtual = document.querySelector("#mes-atual");
mesAtual.textContent = DataAtual();



var mes = DataAtual();

/* FIM: Esta função altera dinamicamente o mês na página de indicadores */

// função para carregar os dados do painel


$(document).ready(function(){
    carrega_painel();
    });
    

    $(document).ready(function(){
        carrega_painel();
        carrega_opEnviada();
        });
        
        function carrega_opEnviada(){
        
          $.ajax({
        
            type:'GET',
            url: '../indicadores/painel-matriz/ordens-recebidas',
            dataType: 'JSON',
        
            success: function(data){
           
                // $.each(data, function(key, item){
                    for (var i = 0; i < data.opesEnviadas.length; i++){
                    opQuantidade = (data.opesEnviadas[i].quantidade);
                    opDia = (data.opesEnviadas[i].dia);
                    }
                   
                // });
                console.log(opQuantidade);
            }
            
            
        });
    }
    
    var chart2 = document.getElementById('opDia')
      var chartOpDia = new Chart(chart2, {
        type: 'bar',
        data: {
            labels: [mes],
            datasets: [{
                label: '#Op recebidas dia',
                data: [opQuantidade],
                backgroundColor: 
                '#B0C4DE',
                    
                borderColor: 'black',
                borderWidth: 1,
                fontColor: 'black'
            
        }],
        labels: [opDia]
    },
      
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
 
    function carrega_painel(){
    
      $.ajax({
    
        type:'GET',
        url: '../../js/indicadores/painel.json',
        dataType: 'JSON',
    
        success: function(data){
       
            $.each(data, function(key, item){
           switch (key) {
                case 0:
                $('#op-recebida').html(item.op.opRecebidasMes);
                   break;
                // case 1:
                //     cliente = item.clientesEmail.clientesComex;
                //     email = item.clientesEmail.emailCadastrado;
                // break; 
                case 2:
                    accCadastradas = item.analisesAccAce.cadastradas;
                    accCanceladas = item.analisesAccAce.canceladas;
                    accLiquidadas = item.analisesAccAce.liquidadas;
                    break; 
                case 3:
                    antecipadosCadastradas = item.antecipados.cadastradas;
                    antecipadosAnalisadas = item.antecipados.analisadas;
                    antecipadosInconforme = item.antecipados.inconformeCanceladas;
                    break;
                case 4:
                    $('#contratado').html(item.antecipadosCobranca.contratado);
                    $('#bloqueado').html(item.antecipadosCobranca.bloqueado);
                    $('#conforme').html(item.antecipadosCobranca.conforme);
                    $('#reiterado').html(item.antecipadosCobranca.reiterado);
                    $('#cobrado').html(item.antecipadosCobranca.cobrado);
                    break; 
            }

          });  
          
          carregaGraficoClienteEmail(cliente,email);
          carregaGraficoAccAce( accCadastradas, accCanceladas, accLiquidadas);
          carregaGraficoAentecipados( antecipadosCadastradas, antecipadosAnalisadas, antecipadosInconforme);
   
        }  
       })
   
    }      
    
// carregar grafico clientes x email
 
function carregaGraficoClienteEmail(){          
    var ctx = document.getElementById("clientesComEmail").getContext('2d');
    var chartPie = new Chart(ctx, {
      type: 'pie',
      data: {
        labels: ["Clientes", "Emails Cadastrados"],
        datasets: [{
          backgroundColor: [
            "#3c8dbc",
            "#f39c12"
          ],
          data: [cliente, email]
        }]
      }
    });   
 
}  

function carregaGraficoAccAce(){
var ctx = document.getElementById('analisesAccAce').getContext('2d');
var myChart = new Chart(ctx, {
  type: 'bar',
    data: {
        labels: [mes],
        datasets: [{
            label: '#Cadastradas',
            data: [accCadastradas],
            backgroundColor: 
                "#3c8dbc",
                
            borderColor: 'black',
            borderWidth: 1
        }, {
        label: '#Canceladas',
            data: [accCanceladas],
            backgroundColor: 
                "#f39c12",
                
            borderColor: 'black',
            borderWidth: 1,
            type: 'bar',
        }, {
            label: '#Liquidadas',
                data: [accLiquidadas],
                backgroundColor: 
                    '#B0C4DE',
                    
                borderColor: 'black',
                borderWidth: 1,
                type: 'bar',
            }],
    },
 
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});
}

function carregaGraficoAentecipados(){
  var ctx = document.getElementById('antecipados').getContext('2d');
  var myChart = new Chart(ctx, {
    type: 'bar',
      data: {
          labels: [mes],
          datasets: [{
              label: '#Cadastradas',
              data: [antecipadosCadastradas],
              backgroundColor: 
              "#3c8dbc",
                  
              borderColor: 'black',
              borderWidth: 1
          }, {
          label: '#Analisadas',
              data: [antecipadosAnalisadas],
              backgroundColor: 
              "#f39c12",
                  
              borderColor: 'black',
              borderWidth: 1,
              type: 'bar',
          }, {
            label: '#Inconforme/Canceladas',
                data: [antecipadosInconforme],
                backgroundColor: 
                    '#B0C4DE',
                    
                borderColor: 'black',
                borderWidth: 1,
                type: 'bar',
            }],
      },
   
      options: {
          scales: {
              yAxes: [{
                  ticks: {
                      beginAtZero: true
                  }
              }]
          }
      }
  });
}



 

   

