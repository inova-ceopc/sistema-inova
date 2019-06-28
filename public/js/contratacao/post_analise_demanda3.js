$(document).ready(function() {

    var cpfCnpj = $("#cpfCnpj").html();
    var protocolo = $("#idDemanda").html();

    /* Brazilian initialisation for the jQuery UI date picker plugin. */
    /* Written by Leonildo Costa Silva (leocsilva@gmail.com). */
    jQuery(function($){
        $.datepicker.regional['pt-BR'] = {
                closeText: 'Fechar',
                prevText: '&#x3c;Anterior',
                nextText: 'Pr&oacute;ximo&#x3e;',
                currentText: 'Hoje',
                monthNames: ['Janeiro','Fevereiro','Mar&ccedil;o','Abril','Maio','Junho',
                'Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
                monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun',
                'Jul','Ago','Set','Out','Nov','Dez'],
                dayNames: ['Domingo','Segunda-feira','Ter&ccedil;a-feira','Quarta-feira','Quinta-feira','Sexta-feira','Sabado'],
                dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sab'],
                dayNamesMin: ['Dom','Seg','Ter','Qua','Qui','Sex','Sab'],
                weekHeader: 'Sm',
                dateFormat: 'dd/mm/yy',
                firstDay: 0,
                isRTL: false,
                showMonthAfterYear: false,
                yearSuffix: ''};
        $.datepicker.setDefaults($.datepicker.regional['pt-BR']);
    });
    // $.get('../../js/contratacao/analise_demanda_contratacao.json', function(dados) {

    //     var dados = JSON.parse(dados);
    //     console.log(dados);
        //preenche os campos da página
    $.ajax({
        type: 'GET',
        url: '../api/esteiracomex/contratacao/{demanda}',
        data: 'value',
        dataType: 'json',
        success: function (dados) {

            console.log(dados);

            $('#idDemanda').html(dados.idDemanda);
            $('#cpfCnpj').html(dados.cpf + dados.cnpj);
            $('#nomeCliente').html(dados.nomeCliente);
            $('#tipoOperacao').html(dados.tipoOperacao);
            $('#tipoMoeda').html(dados.tipoMoeda);
            $('#valorOperacao').html(dados.valorOperacao);
            $('#dataPrevistaEmbarque').html(dados.dataPrevistaEmbarque);
            $('#agResponsavel').html(dados.agResponsavel);
            $('#srResponsavel').html(dados.srResponsavel);
            $('#dadosContaBeneficiario1').html(dados.iban[0].nomeBeneficiario);
            $('#dadosContaBeneficiario2').html(dados.iban[0].nomeBanco);
            $('#dadosContaBeneficiario3').html(dados.iban[0].iban);
            $('#dadosContaBeneficiario4').html(dados.iban[0].agContaBeneficiario);
            $('#dataLiquidacao').val(dados.dataLiquidacao);
            $('#numeroBoleto').val(dados.numeroBoleto);
            $('#statusGeral').val(dados.statusGeral);
            $('#statusInvoice').val(dados.statusInvoice);
            $('#statusConhecimento').val(dados.statusConhecimento);
            $('#statusDi').val(dados.statusDi);
            $('#statusDue').val(dados.statusDue);
            $('#statusDadosBancarios').val(dados.statusDadosBancarios);
            $('#statusAutorizacaoSr').val(dados.statusAutorizacaoSr);


            $.each(dados.historico, function(key, item) {
                var linha = 
                        '<tr>' +
                            '<td class="col-sm-1">' + item.idHistorico + '</td>' +
                            '<td class="col-sm-1">' + item.dataStatus + '</td>' +
                            '<td class="col-sm-1">' + item.tipoStatus + '</td>' +
                            '<td class="col-sm-1">' + item.responsavelStatus + '</td>' +
                            '<td class="col-sm-1">' + item.area + '</td>' +
                            '<td class="col-sm-7">' + item.analiseHistorico + '</td>' +
                        '</tr>';

                $(linha).appendTo('#historico>tbody');
                $('#dataLiquidacao').datepicker();

            });

        }
    });

    
    $.ajax({
        type: 'GET',
        url: '../../js/contratacao/tabela_analise_arquivos3.json',
        // data: { get_param: 'value' },
        dataType: 'JSON',
        success: function(data){
            // var data = data;
            
            $.each(data, function(key, item) {
                var modal = 

                '<div id="divModal' + item.idDocumento + '" class="divModal">' +
                    
                    '<input type="text" class="excluiHidden" name="excluiDoc' + item.idDocumento + '" hidden="hidden">' +

                    '<div class="radio-inline">' +
                        '<a rel="tooltip" class="btn btn-danger" id="btnExcluiDoc' + item.idDocumento + '" title="Excluir arquivo."' + 
                        '<span> <i class="glyphicon glyphicon-trash"> </i>   ' + '</span>' + 
                        '</a>' +
                    '</div>' +
                
                    '<div class="radio-inline">' +

                        '<a rel="tooltip" class="btn btn-primary" title="Visualizar arquivo." data-toggle="modal" data-target="#modal' + item.idDocumento + '">' + 
                        '<span class="glyphicon glyphicon-file">     ' + item.tipoDocumento + '</span>' + 
                        '</a>' +

                        '<div class="modal fade" id="modal' + item.idDocumento + '" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">' + 
                            '<div class="modal-dialog modal-lg">' + 
                                '<div class="modal-content" height="600px">' + 
                                    '<div class="modal-header">' +
                                        '<h3 class="modal-title">' + item.tipoDocumento +
                                        '<button type="button" class="btn btn-danger pull-right margin10" data-dismiss="modal">Fechar painel</button>' +
                                        '<a class="btn btn-primary pull-right margin10" href="' + item.url + '" download="' + item.tipoDocumento + '">Baixar arquivo</a>' +
                                        '</h3>' +
                                    '</div>' +
                                    '<div class="modal-body">' +
                                        '<a href="#!" class="modal-close waves-effect waves-green btn-flat" id="btn_fecha_modal"> </a>' +
                                        '<embed src="' + item.url + '" width="100%" height="650px" />' +
                                    '</div>' +
                                '</div>' +
                            '</div>' +
                        '</div>' +

                    '</div>' +
                '<div> <br>';
                
                $(modal).appendTo('#divModais');

                $('#btnExcluiDoc' + item.idDocumento).click(function(){
                    $(this).parents(".divModal").hide();
                    $(this).closest("div.divModal").find("input[class='excluiHidden']").val("excluir");
                    alert ("Documento marcado para exclusão, salve a análise para efetivar o comando. Caso não queira mais excluir o documento reinicie a análise sem gravar.");
                });
            
            });
            console.log(data);
        },
    });

    $('#formAnaliseDemanda').submit(function(e){
        e.preventDefault();
        var formData = $('#formAnaliseDemanda').serializeArray(); // Creating a formData using the form.
        console.log(formData);
        $.ajax({
            type: 'POST',
            url: '{{ url('/') }}/contratacao',
            dataType: 'JSON',
            data: formData, // Important! The formData should be sent this way and not as a dict.
            // beforeSend: function(xhr){xhr.setRequestHeader('X-CSRFToken', "{{csrf_token}}");},
            success: function(data, textStatus) {
                console.log(data);
                console.log(formData);
                console.log(textStatus);
                alert ("Análise gravada com sucesso.")
            },
            error: function (textStatus, errorThrown) {
                console.log(errorThrown);
                console.log(textStatus);
                console.log(errorThrown);
                alert ("Análise não gravada.")
            }
        });
    });




}) // fim do doc ready

