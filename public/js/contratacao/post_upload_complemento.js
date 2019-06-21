$(document).ready(function() {

    if ($('#statusInvoice').val() == 'Inconforme') {
        $('#divInvoice').show();
    };

    if ($('#statusConhecimento').val() == 'Inconforme') {
        $('#divConhecimento').show();
    };

    if ($('#statusDi').val() == 'Inconforme') {
        $('#divDi').show();
    };

    if ($('#statusDue').val() == 'Inconforme') {
        $('#divDue').show();
    };

    if ($('#statusDadosBancarios').val() == 'Inconforme') {
        $('#divDados').show();
    };

    if ($('#statusAutorizacaoSr').val() == 'Inconforme') {
        $('#divAutorizacao').show();
    };



    $('#formUploadComplemento').submit(function(e){
        e.preventDefault();
        var formData = $('#formUploadComplemento').serializeArray();
        console.log(formData);
        $.ajax({
            method: 'POST',
            url: '{{ url('/') }}/complemento',
            dataType: 'json',
            data: formData, // Important! The formData should be sent this way and not as a dict.
            // beforeSend: function(xhr){xhr.setRequestHeader('X-CSRFToken', "{{csrf_token}}");},
            success: function(data, textStatus) {
                console.log(data);
                console.log(formData);
                console.log(textStatus);
                alert ("Demanda não cadastrada.");
                redirect = window.location.replace("/distribuir/demandas");
            },
            error: function (textStatus, errorThrown) {
                console.log(errorThrown);
                console.log(textStatus);
                console.log(errorThrown);
                alert ("Demanda não cadastrada.");
            }
        });
    }); 

}); // fecha document ready
