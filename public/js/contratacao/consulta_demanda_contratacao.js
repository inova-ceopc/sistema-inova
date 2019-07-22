$(document).ready(function() {

    
    var idDemanda = $("#idDemanda").val();

    // var urlDiretorioVirtual = 'https://' + window.location.host + '/uploads/';

    var urlDiretorioVirtual = 'https://inova.ceopc.des.caixa/uploads/';

    var unidade = $('#unidade').val();

    console.log(idDemanda);

    $.ajax({
        type: 'GET',
        url: '/esteiracomex/contratacao/' + idDemanda,
        data: 'value',
        dataType: 'json',
        success: function (dados) {

            console.log(dados);

            if (dados[0].cpf == null){
                $('#cpfCnpj').html(dados[0].cnpj);
            }
            else {
                $('#cpfCnpj').html(dados[0].cpf);
            };
            
            if (dados[0].tipoOperacao == 'Pronto Importação Antecipado' || dados[0].tipoOperacao == 'Pronto Exportação Antecipado') {
                $('#divDataPrevistaEmbarque').show();

                function formatDate () {
                    var datePart = dados[0].dataPrevistaEmbarque.match(/\d+/g),
                    year = datePart[0],
                    month = datePart[1], 
                    day = datePart[2];
                
                    return day+'/'+month+'/'+year;
                };
            }
            else{
                var formatDate = dados[0].dataPrevistaEmbarque;
            };

            if (dados[0].dataLiquidacao == null) {
                formatDate2 = '';
            }

            else{
                function formatDate2 () {
                    var datePart = dados[0].dataLiquidacao.match(/\d+/g),
                    year = datePart[0],
                    month = datePart[1], 
                    day = datePart[2];
                
                    return day+'/'+month+'/'+year;
                };
            };
            
            function formatMoney () {
                numeral.locale('pt-br');
                var money = numeral(dados[0].valorOperacao).format('0,0.00');
                return money;
            };

            $('#nomeCliente').html(dados[0].nomeCliente);
            $('#tipoOperacao').html(dados[0].tipoOperacao);
            $('#tipoMoeda').html(dados[0].tipoMoeda);
            $('#valorOperacao').html(formatMoney);
            $('#dataPrevistaEmbarque').html(formatDate);
            $('#agResponsavel').html(dados[0].agResponsavel);
            $('#srResponsavel').html(dados[0].srResponsavel);            
            $('#dataLiquidacao').html(formatDate2);
            $('#numeroBoleto').html(dados[0].numeroBoleto);
            $('#statusGeral').html(dados[0].statusAtual);

            
            //EACH para montar cada linha de histórico que vem no json

            $.each(dados[0].esteira_contratacao_historico, function(key, item) {
                
                if (item.analiseHistorico === null) {
                    var linha = 
                    '<tr>' +
                        '<td class="col-sm-1">' + item.idHistorico + '</td>' +
                        '<td class="col-sm-1">' + item.dataStatus + '</td>' +
                        '<td class="col-sm-1">' + item.tipoStatus + '</td>' +
                        '<td class="col-sm-1 responsavel">' + item.responsavelStatus + '</td>' +
                        '<td class="col-sm-1">' + item.area + '</td>' +
                        '<td class="col-sm-7"></td>' +
                    '</tr>';
                }
                else {               
                    var linha = 
                        '<tr>' +
                            '<td class="col-sm-1">' + item.idHistorico + '</td>' +
                            '<td class="col-sm-1">' + item.dataStatus + '</td>' +
                            '<td class="col-sm-1">' + item.tipoStatus + '</td>' +
                            '<td class="col-sm-1 responsavel">' + item.responsavelStatus + '</td>' +
                            '<td class="col-sm-1">' + item.area + '</td>' +
                            '<td class="col-sm-7 Nenhum">' + item.analiseHistorico + '</td>' +
                        '</tr>';
                }

                $(linha).appendTo('#historico>tbody');

                if (unidade != '5459') {
                    $('.responsavel').remove();
                }; 
            });

            // IF que faz aparecer e popula os capos de Conta de Beneficiário no exterior e IBAN etc

            var tipoOperação = $("#tipoOperacao").html();

            if ((tipoOperação == 'Pronto Importação Antecipado') || (tipoOperação == 'Pronto Importação')){
                $('#divHideDadosBancarios').show();
                $('#divHideDadosIntermediario').show();
                $.each(dados[0].esteira_contratacao_conta_importador, function(key, item) {
                    $('#' + key).html(item);
                });
            };


            $.each(dados[0].esteira_contratacao_confere_conformidade, function(key, item) {
                $('#div' + item.tipoDocumento).show();
                $('#' + item.tipoDocumento).val(item.statusDocumento);
            });

            $.each(dados[0].esteira_contratacao_upload, function(key, item) {
                var modal = 

                    '<div id="divModal' + item.idUploadLink + '" class="divModal">' +
                                           
                        '<div class="radio-inline">' +

                            '<a rel="tooltip" class="btn btn-primary" title="Visualizar arquivo." data-toggle="modal" data-target="#modal' + item.idUploadLink + '">' + 
                            '<span class="glyphicon glyphicon-file">     ' + item.tipoDoDocumento + '</span>' + 
                            '</a>' +

                            '<div class="modal fade" id="modal' + item.idUploadLink + '" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">' + 
                                '<div class="modal-dialog modal-lg">' + 
                                    '<div class="modal-content" height="600px">' + 
                                        '<div class="modal-header">' +
                                            '<h3 class="modal-title">' + item.tipoDoDocumento +
                                            '<button type="button" class="btn btn-danger pull-right margin10" data-dismiss="modal">Fechar painel</button>' +
                                            '<a class="btn btn-primary pull-right margin10" href="' + urlDiretorioVirtual + item.caminhoDoDocumento + '" download="' + item.tipoDoDocumento + '">Baixar arquivo</a>' +
                                            '</h3>' +
                                        '</div>' +
                                        '<div class="modal-body">' +
                                            '<a href="#!" class="modal-close waves-effect waves-green btn-flat" id="btn_fecha_modal"> </a>' +
                                            '<embed src="' + urlDiretorioVirtual + item.caminhoDoDocumento + '" width="100%" height="650px" />' +
                                        '</div>' +
                                    '</div>' +
                                '</div>' +
                            '</div>' +

                        '</div>' +
                    '<div> <br>';
                
                $(modal).appendTo('#divModais');
           
            });

            $('#historico').DataTable({
                "pageLength": 5,
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


}); // fecha document ready
