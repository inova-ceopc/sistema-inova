$(document).ready(function() { 

    $.ajax({
        type: 'GET',
        url: '../../esteiracomex/contratacao/resumo/conformidade',
        // url: '../../js/contratacao/tabela_minhas_demandas_contratacao.json',
        data: 'value',
        dataType: 'json',
        success: function (dados) {

            // captura os arrays de demandas do json
            $.each(dados, function(key, item) {

            // monta a linha
                var linha = 
                    '<tr>' +
                        '<td>' + item.responsavelCeopc + '</td>' +
                        '<td>' + item.nomeCompleto + '</td>' +
                        '<td>' + item.prontoImportacao + '</td>' +
                        '<td>' + item.prontoImportacaoAntecipado + '</td>' +
                        '<td>' + item.prontoExportacao + '</td>' +
                        '<td>' + item.prontoExportacaoAntecipado + '</td>' +
                        '<td>' + item.total + '</td>' +
                    '</tr>';

                // popula a linha na tabela
                $(linha).appendTo('#tabelaDistribuidasAnalistas>tbody');
            });          
            
            $('table').DataTable({
                "order": [[ 0, "desc" ]],
                "language": {
                    "sEmptyTable": "Nenhum registro encontrado",
                    "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                    "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
                    "sInfoFiltered": "(Filtrados de _MAX_ registros)",
                    "sInfoPostFix": "",
                    "sInfoThousands": ".",
                    "sLengthMenu": "Mostrar _MENU_ resultados por página",
                    "sLoadingRecords": "Carregando...",
                    "sProcessing": "Processando...",
                    "sZeroRecords": "Nenhum registro encontrado",
                    "sSearch": "Pesquisar",
                    "oPaginate": {
                        "sNext": "Próximo",
                        "sPrevious": "Anterior",
                        "sFirst": "Primeiro",
                        "sLast": "Último"
                    },
                    "oAria": {
                        "sSortAscending": ": Ordenar colunas de forma ascendente",
                        "sSortDescending": ": Ordenar colunas de forma descendente"
                    }
                }
            });
        
        
        }
    });


});
