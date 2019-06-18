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

                '<div id="divModal' + item.idDocumento + '" class="divModal">' +
                    
                    '<input type="text" class="excluiHidden" name="excluiDoc' + item.idDocumento + '" hidden="hidden">' +

                    '<div class="radio-inline">' +
                        '<a rel="tooltip" class="btn btn-danger btn-lg" id="btnExcluiDoc' + item.idDocumento + '" title="Excluir arquivo."' + 
                        '<span> <i class="glyphicon glyphicon-trash"> </i>   ' + '</span>' + 
                        '</a>' +
                    '</div>' +
                
                    '<div class="radio-inline">' +

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

