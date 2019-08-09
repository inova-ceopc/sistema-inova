var cliente, email; 
var opQuantidade = [], opDia = [],accData = [], accCadastradas = [], accCanceladas=[], accLiquidadas=[],
accDataMes = [], accCadastradasMes = [], accCanceladasMes=[], accLiquidadasMes=[];
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

// funções para carregar os dados do painel

$(document).ready(function(){
    carrega_painel();
    carrega_opEnviada();
    carrega_accAce();
    // carregaGraficoAccAceMensal()
    });
        
function carrega_opEnviada(){
        
    $.ajax({
    
        type:'GET',
        url: '../indicadores/painel-matriz/ordens-recebidas',
        dataType: 'JSON',
    
        success: function(data){
         
            for (var i = 0; i < data.opesEnviadas.length; i++){
            opQuantidade.push(data.opesEnviadas[i].quantidade);
            opDia.push(data.opesEnviadas[i].dia.split(/\-/).reverse().join('-').substring(0, 5));
            }
         

        var chart2 = document.getElementById('graficoOP');
        var chartOpDia = new Chart(chart2, {
            type: 'bar',
            data: {
            
                labels: opDia,
                datasets: [{
                    label: 'Op Recebida' ,
                    data: opQuantidade,
                    
                    backgroundColor: 
                    '#B0C4DE',
                        
                    borderColor: 'black',
                    borderWidth: 1
                    // fontColor: 'black'
                
            }]
            
        },
      
        options: {
            title: {
                display: true,
                text: 'OP recebidas nos últimos 30 dias',
            },
            legend: {
                position: 'bottom',
                labels: {
                    fontColor: 'black',
                }
            },
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
    });
}
 
// carrega graficos resultados acc
function carrega_accAce(){
        
    $.ajax({
    
        type:'GET',
        url: '../indicadores/painel-matriz/resumo-acc-ace-30dias',
        dataType: 'JSON',
    
        success: function(acc){
         
            for (var i = 0; i < acc.resumoAccAceUltimos30dias.length; i++){
                accData.push(acc.resumoAccAceUltimos30dias[i].data.split(/\-/).reverse().join('-').substring(0, 5));
                accCadastradas.push(acc.resumoAccAceUltimos30dias[i].cadastradas);
                accLiquidadas.push(acc.resumoAccAceUltimos30dias[i].liquidadas);
                accCanceladas.push(acc.resumoAccAceUltimos30dias[i].canceladas);
           
            }

            var ctx = document.getElementById('analisesAccAce30dias').getContext('2d');
            var myChart = new Chart(ctx, {
              type: 'bar',
                data: {
                    labels:accData,
                    datasets: [{
                        label: '#Cadastradas',
                        data: accCadastradas,
                        backgroundColor: 
                            "#3c8dbc",
                            
                        borderColor: 'black',
                        borderWidth: 1
                    }, {
                    label: '#Liquidadas',
                        data: accLiquidadas,
                        backgroundColor: 
                            "#f39c12",
                            
                        borderColor: 'black',
                        borderWidth: 1,
                        type: 'bar',
                    }, {
                        label: '#Canceladas',
                            data: accCanceladas,
                            backgroundColor: 
                                '#B0C4DE',
                                
                            borderColor: 'black',
                            borderWidth: 1,
                            type: 'bar',
                        }],
                },            
      
        options: {
            title: {
                display: true,
                text: 'Análises ACC/ACE Dia'
            },
            legend: {
                position: 'right',
                labels: {
                    fontColor: 'black',
                }
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
        });
        // }
    // });
// }
// function carregaGraficoAccAceMensal(){
    $.ajax({
    
        type:'GET',
        url: '../indicadores/painel-matriz/resumo-acc-ace-mensal',
        dataType: 'JSON',
    
        success: function(accMes){
         
            for (var i = 0; i < accMes.resumoAccAceMensal.length; i++){
                accDataMes.push((accMes.resumoAccAceMensal[i].mes)+"-"+(accMes.resumoAccAceMensal[i].ano));
                accCadastradasMes.push(accMes.resumoAccAceMensal[i].cadastradas);
                accLiquidadasMes.push(accMes.resumoAccAceMensal[i].liquidadas);
                accCanceladasMes.push(accMes.resumoAccAceMensal[i].canceladas);
           
            }
  console.log(accCadastradasMes,accCanceladasMes,accLiquidadasMes,accDataMes)

            var ctx1 = document.getElementById('analisesAccAceMensal').getContext('2d');
            var myChart1 = new Chart(ctx1, {
              type: 'bar',
                data: {
                    labels: accDataMes,
                    datasets: [{
                        label: '#Cadastradas',
                        data: accCadastradasMes,
                        backgroundColor: 
                            "#3c8dbc",
                            
                        borderColor: 'black',
                        borderWidth: 1
                    }, {
                    label: '#Liquidadas',
                        data: accLiquidadasMes,
                        backgroundColor: 
                            "#f39c12",
                            
                        borderColor: 'black',
                        borderWidth: 1,
                        type: 'bar',
                    }, {
                        label: '#Canceladas',
                        data: accCanceladasMes,
                        backgroundColor: 
                            '#B0C4DE',
                            
                        borderColor: 'black',
                        borderWidth: 1,
                        type: 'bar',
                        }],
                },            
      
        options: {
            title: {
                display: true,
                text: 'Análises ACC/ACE Mês'
            },
            legend: {
                position: 'right',
                labels: {
                    fontColor: 'black',
                }
            },
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
    });
    }
    });
}
   
 
// até aqui ok

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
                case 1:
                    cliente = item.clientesEmail.clientesComex;
                    email = item.clientesEmail.emailCadastrado;
                break; 
                // case 2:
                //     accCadastradas = item.analisesAccAce.cadastradas;
                //     accCanceladas = item.analisesAccAce.canceladas;
                //     accLiquidadas = item.analisesAccAce.liquidadas;
                //     break; 
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
        //   console.log(antecipadosCadastradas);
          
          carregaGraficoClienteEmail(cliente,email);
        //   carregaGraficoAccAce( accCadastradas, accCanceladas, accLiquidadas);
          carregaGraficoAentecipados( antecipadosCadastradas, antecipadosAnalisadas, antecipadosInconforme);
   
        }  
       })
   
    }      
   
// carregar grafico clientes x email
 
function carregaGraficoClienteEmail(){          
    var ctx = document.getElementById("clientesComEmail");
    var chartPie = new Chart(ctx, {
      type: 'pie',
      data: {
        labels: ["Clientes", "Emails Cadastrados"],
        datasets: [{
          backgroundColor: [
            "#3c8dbc",
            "#f39c12"
          ],
        //   borderColor: [
        //     "#3c8dbc",
        //     "#f39c12"
        //   ],
          data: [cliente, email]
        }]
      },
      options: {
        legend: {
            position: 'bottom',
            labels: {
                fontColor: 'black'
            }
        },
    }
    });   
 
}  

// function carregaGraficoAccAce(){
// var ctx = document.getElementById('analisesAccAce').getContext('2d');
// var myChart = new Chart(ctx, {
//   type: 'bar',
//     data: {
//         labels: [mes],
//         datasets: [{
//             label: '#Cadastradas',
//             data: [accCadastradas],
//             backgroundColor: 
//                 "#3c8dbc",
                
//             borderColor: 'black',
//             borderWidth: 1
//         }, {
//         label: '#Canceladas',
//             data: [accCanceladas],
//             backgroundColor: 
//                 "#f39c12",
                
//             borderColor: 'black',
//             borderWidth: 1,
//             type: 'bar',
//         }, {
//             label: '#Liquidadas',
//                 data: [accLiquidadas],
//                 backgroundColor: 
//                     '#B0C4DE',
                    
//                 borderColor: 'black',
//                 borderWidth: 1,
//                 type: 'bar',
//             }],
//     },

//     options: {
//         legend: {
//             labels: {
//                 fontColor: 'black'
//             }
//         },
//         scales: {
//             yAxes: [{
//                 ticks: {
//                     beginAtZero: true
//                 }
//             }]
//         }
//     }
// });
// }

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



 

   

