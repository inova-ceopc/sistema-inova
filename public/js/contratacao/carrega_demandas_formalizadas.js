$(document).ready(function() { 

    $.ajax({
        type: 'GET',
        url: '../esteiracomex/contratacao/formalizar',
        // url: '../../js/contratacao/tabela_minhas_demandas_contratacao.json',
        data: 'value',
        dataType: 'json',
        success: function (dados) {

            // captura os arrays de demandas do json
            $.each(dados.demandasEsteira[0].contratacao, function(key, item) {

            // monta a linha com o array de cada demanda
                var linha = 
                    '<tr>' +
                        '<td>' + item.idDemanda + '</td>' +
                        '<td>' + item.nomeCliente + '</td>' +
                        '<td>' + item.cpfCnpj + '</td>' +
                        '<td>' + item.tipoOperacao + '</td>' +
                        '<td class="mascaradinheiro">' + item.valorOperacao + '</td>' +
                        '<td>' + item.unidadeDemandante + '</td>' +
                        '<td>' + item.statusAtual + '</td>' +
                        '<td class="padding5">' +
                            '<a href="../contratacao/formalizar/' + item.idDemanda + '" rel="tooltip" class="btn btn-success margin05 inline formalizar" id="btnFormalizar' + item.idDemanda + '" title="Formalizar demanda">' + 
                            '<span> <i class="glyphicon glyphicon-open-file"> </i></span>' + 
                            '</a>' +
                            '<a href="../contratacao/verificar/' + item.idDemanda + '" rel="tooltip" class="btn btn-info margin05 inline verificar" id="btnVerificar' + item.idDemanda + '" title="Verificar assinatura do contrato">' + 
                            '<span> <i class="fa fa-pencil"> </i></span>' + 
                            '</a>' +
                        '</td>' +
                    '</tr>';



                // popula a linha na tabela
                $(linha).appendTo('#tabelaContratacoesFormalizadas>tbody');


                // if (item.statusAtual == 'DISTRIBUIDA' || item.statusAtual == 'EM ANALISE'){
                //     $('#btnAnalisar' + item.idDemanda).removeClass('hidden');
                // };

                // if (item.statusAtual == 'INCONFORME'){
                //     $('#btnComplementar' + item.idDemanda).removeClass('hidden');
                // };

                // if (item.statusAtual == 'CONFORME'){  //FORMALIZADO
                //     $('#btnFormalizar' + item.idDemanda).removeClass('hidden');
                // };
            
            });

            //Função global que formata dinheiro para valor humano do arquivo formata_data.js.
            _formataValores();


            $('#tabelaContratacoesFormalizadas').DataTable({
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