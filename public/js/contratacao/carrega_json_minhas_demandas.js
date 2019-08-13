$(document).ready(function() { 

    $.ajax({
        type: 'GET',
        url: '../../esteiracomex/contratacao/demandas-usuario',
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
                            '<a href="../contratacao/consultar/' + item.idDemanda + '" rel="tooltip" class="btn btn-primary margin05 inline consultar" id="btnConsultar' + item.idDemanda + '" title="Consultar demanda">' + 
                            '<span> <i class="fa fa-binoculars"> </i></span>' + 
                            '</a>' +
                            '<a href="../contratacao/complementar/' + item.idDemanda + '" rel="tooltip" class="btn btn-warning margin05 inline complementar hidden" id="btnComplementar' + item.idDemanda + '" title="Complementar demanda">' + 
                            '<span> <i class="fa fa-repeat"> </i></span>' + 
                            '</a>' +
                            '<a href="../contratacao/analisar/' + item.idDemanda + '" rel="tooltip" class="btn btn-warning margin05 inline analisar hidden" id="btnAnalisar' + item.idDemanda + '" title="Analisar demanda">' + 
                            '<span> <i class="glyphicon glyphicon-list-alt"> </i></span>' + 
                            '</a>' +
                            '<a href="../contratacao/confirmar/' + item.idDemanda + '" rel="tooltip" class="btn btn-success margin05 inline confirmar hidden" id="btnConfirmar' + item.idDemanda + '" title="Confirmar assinatura">' + 
                            '<span> <i class="fa fa-check-square-o"> </i></span>' + 
                            '</a>' +
                            '<a href="../contratacao/carregar-contrato-assinado/' + item.idDemanda + '" rel="tooltip" class="btn btn-info margin05 inline assinar hidden" id="btnAssinar' + item.idDemanda + '" title="Carregar contrato assinado">' + 
                            '<span> <i class="fa fa-pencil"> </i></span>' + 
                            '</a>' +
                        '</td>' +
                    '</tr>';



                // popula a linha na tabela
                $(linha).appendTo('#tabelaPedidosContratacao>tbody');

                //Função global que formata dinheiro para valor humano do arquivo formata_data.js.
                _formataValores();


                if (item.statusAtual == 'DISTRIBUIDA' || item.statusAtual == 'EM ANALISE'){
                    $('#btnAnalisar' + item.idDemanda).removeClass('hidden');
                };

                if (item.statusAtual == 'INCONFORME'){
                    $('#btnComplementar' + item.idDemanda).removeClass('hidden');
                };

                if (item.statusAtual == 'CONFORME'){  //FORMALIZADO
                    $('#btnFormalizar' + item.idDemanda).removeClass('hidden');
                };
            
            });

            carregaDadosEmpregado();

            $('#tabelaPedidosContratacao').DataTable({
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
    
    //  carrega os dados da pessoa logada na sessão
    function carregaDadosEmpregado(json){

    var url = ('../../api/sistemas/v1/dados_empregado')
    
        $.ajax({
        
        type: 'GET',
        url : url,
        
            success: function(carregaEmpregado){
               
            var empregado = JSON.parse(carregaEmpregado);
            
            $.each(empregado, function(key, value){

                switch (value.codigoLotacaoAdministrativa){

                    case '5459':
                        $('.complementar').remove();
                        $('.confirmar').remove();
                        $('.assinar').remove();
                }
            
            });

            $.each(empregado, function(key, value){

                switch (value.nivelAcesso){

                    case 'EMPREGADO_AG':
                    case 'EMPREGADO_SR':
                    case 'EMPREGADO_MATRIZ':
                    case 'GIGAD':        
                        $('.analisar').remove();
                }
    
            });
            }
        }); 

    }
});