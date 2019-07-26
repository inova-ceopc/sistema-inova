$(document).ready(function() { 

    $.ajax({
        type: 'GET',
        url: '../../api/esteiracomex//contratacao/resumo/conformidade',
        // url: '../../js/contratacao/tabela_minhas_demandas_contratacao.json',
        data: 'value',
        dataType: 'json',
        success: function (dados) {

            // captura os arrays de demandas do json
            $.each(dados.demandasEsteira[0].contratacao, function(key, item) {

            // monta a linha
                var linha = 
                    '<tr>' +
                        '<td>' + item.idDemanda + '</td>' +
                        '<td>' + item.nomeCliente + '</td>' +
                        '<td>' + item.cpfCnpj + '</td>' +
                        '<td>' + item.tipoOperacao + '</td>' +
                        '<td class="mascaradinheiro">' + item.valorOperacao + '</td>' +
                        '<td>' + item.unidadeDemandante + '</td>' +
                        '<td>' + item.statusAtual + '</td>' +
                    '</tr>';

                // popula a linha na tabela
                $(linha).appendTo('#tabelaDistribuidasAnalistas>tbody');
            });          
        }
    });

});
