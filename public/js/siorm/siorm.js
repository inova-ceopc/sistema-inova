// $.ajax({
//     type: 'GET',
//     url: 'siorm/emite-historico',
//     data: 'value',
//     dataType: 'json',
//     success: function (dados) {

//         console.log(dados);
//         // captura os arrays de demandas do json
//             $.each(dados, function(key, item) {

//                 console.log(item);
         
//         // monta a linha com o array de cada demanda
//             var linha = 
//                 '<tr>' +
//                     '<td>' + item.mesCompetencia[0] + '</td>' +
//                     '<td>' + item.VlrTotContrd.toFixed(2) + '</td>' +
//                     '<td>' + item.VlrTotLiqdado.toFixed(2) + '</td>' +
//                     '<td>' + item.VlrTotCancel.toFixed(2) + '</td>' +
//                     '<td>' + item.VlrTotBaixd.toFixed(2) + '</td>' +
//                     '<td>' + item.VlrTotACC.toFixed(2) + '</td>' +
//                 '</tr>';

//             // popula a linha na tabela
//             $(linha).appendTo('#tabelaResultado>tbody');
//         });

//         //Função global que formata a data para valor humano do arquivo formata_data.js
//         // _formataData();

//         //Função global que formata dinheiro para valor humano do arquivo formata_data.js.
//         // _formataValores();

//         //Função global que formata DataTable para portugues do arquivo formata_datatable.js.
//         // _formataDatatable();

//     }
// });

//                     // '<td class="formata-data">' + item.dataCadastro + '</td>' +
//                     // '<td>' + item.nomeCliente + '</td>' +
//                     // '<td>' + item.cpfCnpj + '</td>' +
//                     // '<td>' + item.tipoOperacao + '</td>' +
//                     // '<td class="mascaradinheiro">' + item.valorOperacao + '</td>' +
//                     // '<td>' + item.unidadeDemandante + '</td>' +
//                     // '<td>' + item.statusAtual + '</td>' +
