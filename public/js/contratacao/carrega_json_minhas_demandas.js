
// $(document).ready(function() {


//     $.ajax({
//         type: 'GET',
//         url: '../../api/esteiracomex/distribuicao',
//         // url: '../../js/contratacao/tabela_minhas_demandas_contratacao.json',
//         data: 'value',
//         dataType: 'json',
//         success: function (data) {
//             var items = data.demandasEsteira[0].contratacao;
//             console.log(items);

//             $('#tabelaPedidosContratacao').DataTable({
//                 data: items,
//                 columns: [
//                     { data: "idDemanda", title : "Protocolo" },
//                     { data: "nomeCliente", title : "Nome" },
//                     { data: "cpfCnpj", title : "CNPJ / CPF" },
//                     { data: "tipoOperacao", title : "Operação" },
//                     { data: "valorOperacao", title : "Valor" },
//                     { data: "unidadeDemandante", title : "Demandante" },
//                     { data: "statusAtual", title : "Status" },          
//                  ]
//             });

//         }
//     });



// });
// $('#tabelaPedidosContratacao tbody').on('click', 'tr', function () {
//     var protocolo = $(this).find('td:first').text()
//     document.location.href = '/esteiracomex/contratacao/consulta/' + protocolo
// } );


$(document).ready(function() {


    $.ajax({
        type: 'GET',
        url: '../../api/esteiracomex/distribuicao',
        // url: '../../js/contratacao/tabela_minhas_demandas_contratacao.json',
        data: 'value',
        dataType: 'json',
        success: function (dados) {

            console.log(dados); //array completo do json

            // captura os arrays de demandas do json
            $.each(dados.demandasEsteira[0].contratacao, function(key, item) {

                console.log(item);

            // monta a linha com o array de cada demanda
                var linha = 
                    '<tr>' +
                        '<td>' + item.idDemanda + '</td>' +
                        '<td>' + item.nomeCliente + '</td>' +
                        '<td>' + item.cpfCnpj + '</td>' +
                        '<td>' + item.tipoOperacao + '</td>' +
                        '<td>' + item.valorOperacao + '</td>' +
                        '<td>' + item.unidadeDemandante + '</td>' +
                        '<td>' + item.statusAtual + '</td>' +
                        '<td class="padding5">' +
                            '<a href="../contratacao/consulta/' + item.idDemanda + '" rel="tooltip" class="btn btn-primary inline" title="Consultar demanda">' + 
                            '<span> <i class="fa fa-binoculars"> </i></span>' + 
                            '</a>' +
                            '&emsp;' +
                            '<a href="../contratacao/complemento/' + item.idDemanda + '" rel="tooltip" class="btn btn-warning inline" title="Complementar demanda">' + 
                            '<span> <i class="fa fa-edit"> </i></span>' + 
                            '</a>' +
                            '&emsp;' +
                            '<a href="../contratacao/analise/' + item.idDemanda + '" rel="tooltip" class="btn btn-success inline" title="Analisar demanda">' + 
                            '<span> <i class="glyphicon glyphicon-list-alt"> </i></span>' + 
                            '</a>' +
                        '</td>' +
                    '</tr>';

                // popula a linha na tabela
                $(linha).appendTo('#tabelaPedidosContratacao>tbody');

            });

        }
    });

});


// $(document).ready(function() {
//     $('#tabelaPedidosContratacao').DataTable( {
//         processing: true,
//         ajax: {
//             url: "../../js/contratacao/tabela_minhas_demandas_contratacao.json",
//             dataSrc: function(dados){
//                 var data = [];
//                 console.log(dados);

//                 $.each(dados.demandasEsteira[0].contratacao, function(key, data) {

//                 console.log(data);
//                 });
//                 return data
//             },
            
//         },

//         columns: [
//             { data: "idDemanda", title : "Protocolo" },
//             { data: "nomeCliente", title : "Nome" },
//             { data: "cpfCnpj", title : "CNPJ / CPF" },
//             { data: "tipoOperacao", title : "Operação" },
//             { data: "valorOperacao", title : "Valor" },
//             { data: "unidadeDemandante", title : "Demandante" },
//             { data: "statusAtual", title : "Status" },          
//         ],
//     });
    
//     $('#tabelaPedidosContratacao tbody').on('click', 'tr', function () {
//         var protocolo = $(this).find('td:first').text()
//         document.location.href = '/esteiracomex/contratacao/consulta/' + protocolo
//     } );
// });




// $(document).ready(function() {
//     $('#tabelaResumo').DataTable( {
//         "ajax": "tabela_resumo.json",
//         "columns": [
//             { data: "matricula" },
//             { data: "nome" },
//             { data: "qtdProntoImp" },
//             { data: "qtdProntoExp" },
//             { data: "qtdProntoImpAnt" },
//             { data: "qtdProntoExpAnt" },
//             { data: "total" }
//         ]
//     } );
// } );

// $(document).ready(function() {
//     $('#tabelaPedidosContratacao').DataTable( {
//         ajax: "../../js/contratacao/tabela_minhas_demandas_contratacao.json",
//         columns: [
//             { data: "protocolo", width: "5%" },
//             { data: "idCliente", class: "escondido" },
//             { data: "tipoPessoa", class: "escondido"  },
//             { data: "nomeCliente", width: "30%" },
//             { data: "cpfCnpj", width: "15%" },
//             { data: "tipoOperacao", width: "15%" },
//             { data: "valorOperacao", width: "10%" },
//             { data: "dataPrevistaEmbarque", class: "escondido" },
//             { data: "codigoPv", width: "5%" },
//             { data: "numeroPv", width: "15%" },
//             { data: "status", width: "8%" },          
//         ]
//     } );
//     $('#tabelaPedidosContratacao tbody').on('click', 'tr', function () {
//         var protocolo = $(this).find('td:first').text()
//         document.location.href = '/esteiracomex/contratacao/consulta/' + protocolo
//     } );
// } );


