$(document).ready(function() {

    var cpfCnpj = $("#cpfCnpj").html();
    var protocolo = $("#idDemanda").html();


    $.ajax({
        type: 'GET',
        url: '../../js/contratacao/tabela_analise_arquivos3.json',
        // data: { get_param: 'value' },
        dataType: 'JSON',
        success: function(data){
            // var data = data;
            
            $.each(data, function(key, item) {
                var modal = 

                
                '<div id="divModal' + item.idDocumento + '">' +
                    '<div>' +

                        '<a rel="tooltip" class="btn btn-primary btn-lg" title="Visualizar arquivo." data-toggle="modal" data-target="#modal' + item.idDocumento + '">' + 
                        '<span class="glyphicon glyphicon-file">     ' + item.tipoDocumento + '</span>' + 
                        '</a>' +

                        '<div class="modal fade" id="modal' + item.idDocumento + '" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">' + 
                            '<div class="modal-dialog modal-lg">' + 
                                '<div class="modal-content" height="600px">' + 
                                    '<div class="modal-header">' +
                                        '<h4 class="modal-title">' + item.tipoDocumento + '<button type="button" class="btn btn-default pull-right" data-dismiss="modal">Fechar</button> </h4>' +
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
            });

            console.log(data);
        },
    });

    $('#formAnaliseDemanda').on('submit', function(e){
        e.preventDefault();
        var formData = new FormData($('#formAnaliseDemanda').get(0)); // Creating a formData using the form.
        $.ajax({
            type: 'POST',
            url: '../../js/contratacao/backend/post_teste_inova.php',
            dataType: 'JSON',
            cache: false,
            processData: false, // Important!
            contentType: false, // Important! I set dataType above as Json
            data: formData, // Important! The formData should be sent this way and not as a dict.
            // beforeSend: function(xhr){xhr.setRequestHeader('X-CSRFToken', "{{csrf_token}}");},
            success: function(data, textStatus) {
                console.log(data);
                console.log(formData);
                console.log(textStatus);
            },
            error: function (textStatus, errorThrown) {
                console.log(errorThrown);
                console.log(textStatus);
                console.log(errorThrown);
            }
        });
    });



}) // fim do doc ready

