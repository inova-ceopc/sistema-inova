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

$(document).ready(function() {
    var table = $('#tabelaPedidosContratacao').DataTable( {
        "ajax": "../../js/contratacao/tabela_minhas_demandas_contratacao.json",
        "columns": [
            { data: "protocolo", width: "5%" },
            { data: "idCliente", class: "escondido" },
            { data: "tipoPessoa", class: "escondido"  },
            { data: "nomeCliente", width: "30%" },
            { data: "cpfCnpj", width: "15%" },
            { data: "tipoOperacao", width: "15%" },
            { data: "valorOperacao", width: "10%" },
            { data: "dataPrevistaEmbarque", class: "escondido" },
            { data: "codigoPv", width: "5%" },
            { data: "numeroPv", width: "15%" },
            { data: "status", width: "8%" },          
        ]
    } );
    $('#tabelaPedidosContratacao tbody').on('click', 'tr', function () {
        var protocolo = $(this).find('td:first').text()
        document.location.href = '/esteiracomex/contratacao/consulta/' + protocolo
    } );
} );