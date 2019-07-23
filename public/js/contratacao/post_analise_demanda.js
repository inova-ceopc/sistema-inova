$(document).ready(function() {

    var cpfCnpj = $("#cpfCnpj").html();

    var protocolo = $("#idDemanda").html();

    var idDemanda = $("#idDemanda").val();

    // var urlDiretorioVirtual = 'https://' + window.location.host + '/uploads/';

    var urlDiretorioVirtual = 'https://inova.ceopc.des.caixa/uploads/';

    var excluirDocumentos = [];

    $('.mascaradinheiro').mask('000.000.000.000.000,00' , { reverse : true});    

    $.ajax({
        type: 'GET',
        url: '/esteiracomex/contratacao/' + idDemanda,
        data: 'value',
        dataType: 'json',
        success: function (dados) {

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

            else {
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
            $('#dataLiquidacao').val(formatDate2);
            $('#numeroBoleto').val(dados[0].numeroBoleto);
            $('#equivalenciaDolar').val(dados[0].equivalenciaDolar);
            $('#statusGeral').val(dados[0].statusAtual);

            $.each(dados[0].esteira_contratacao_historico, function(key, item) {

                if (item.analiseHistorico === null) {
                    var linha = 
                    '<tr>' +
                        '<td class="col-sm-1">' + item.idHistorico + '</td>' +
                        '<td class="col-sm-1">' + item.dataStatus + '</td>' +
                        '<td class="col-sm-1">' + item.tipoStatus + '</td>' +
                        '<td class="col-sm-1">' + item.responsavelStatus + '</td>' +
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
                            '<td class="col-sm-1">' + item.responsavelStatus + '</td>' +
                            '<td class="col-sm-1">' + item.area + '</td>' +
                            '<td class="col-sm-7 Nenhum">' + item.analiseHistorico + '</td>' +
                        '</tr>';
                }

                $(linha).appendTo('#historico>tbody');
                $('#dataLiquidacao').datepicker();

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
                $('#' + item.tipoDocumento).attr('required', true);
                $('#id' + item.tipoDocumento).val(item.idCheckList);

            });
            
            $.each(dados[0].esteira_contratacao_upload, function(key, item) {
                var modal = 

                    '<div id="divModal' + item.idUploadLink + '" class="divModal">' +

                        '<form method="put" action="" enctype="multipart/form-data" class="form-horizontal excluiDocumentos" name="formExcluiDocumentos' + item.idUploadLink + '"" id="formExcluiDocumentos' + item.idUploadLink + '">' +
                            '<input type="text" class="excluid" name="idUploadLink" value="' + item.idUploadLink + '" hidden="hidden">' +
                            '<input type="text" class="excluiHidden" name="excluir" value="NAO" hidden="hidden">' +
                        '</form>' +

                        '<div class="radio-inline">' +
                            '<a rel="tooltip" class="btn btn-danger" id="btnExcluiDoc' + item.idUploadLink + '" title="Excluir arquivo."' + 
                            '<span> <i class="glyphicon glyphicon-trash"> </i>   ' + '</span>' + 
                            '</a>' +
                        '</div>' +
                    
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

                $('#btnExcluiDoc' + item.idUploadLink).click(function(){
                    $(this).parents(".divModal").hide();
                    $(this).closest("div.divModal").find("input[class='excluiHidden']").val("SIM");
                    alert ("Documento marcado para exclusão, salve a análise para efetivar o comando. Caso não queira mais excluir o documento reinicie a análise sem gravar.");
                });
            
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

    
    $('#formAnaliseDemanda').submit(function(e){
        e.preventDefault();

        if ($('#statusGeral').val() == 'DISTRIBUIDA') {
            alert("Selecione um status geral.");
        } else {
            // var excluirDocumentos = [{'name':'id','value':'9','name':'excluir','value':'SIM'}];
            excluirDocumentos = [];
            $('.excluiDocumentos').each(function() {


                let documento = $(this).serializeArray().reduce(function(obj, item) {
                    obj[item.name] = item.value;
                    return obj;
                }, {});

                excluirDocumentos.push(documento);


                // return excluirDocumentos;
            });

            console.log(excluirDocumentos);

            var data = $('#formAnaliseDemanda').serializeArray().reduce(function(obj, item) {
                obj[item.name] = item.value;
                return obj;
            }, {});
            var formData = {data, excluirDocumentos};
            // var formData = JSON.stringify(dados);
            console.log(formData);
            $.ajax({
                type: 'PUT',
                url: '/esteiracomex/contratacao/' + idDemanda,
                dataType: 'JSON',
                data: formData,
                statusCode: {
                    200: function(data) {
                        console.log(data);
                        window.location.href = "/esteiracomex/distribuir/demandas";
                    }
                }
            });

        }
    });
}) // fim do doc ready
