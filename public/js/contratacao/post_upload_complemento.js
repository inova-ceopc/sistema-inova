$(document).ready(function() {

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
            $('#dataLiquidacao').html(dados.dataLiquidacao);
            $('#numeroBoleto').html(dados.numeroBoleto);
            $('#statusGeral').html(dados.statusGeral);
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

            });

            if ($('#statusInvoice').val() == 'Inconforme') {
                $('#divInvoice').show();
                console.log($('#statusInvoice').val());
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
        



        }
    });


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
                alert ("Complemento gravado com sucesso.");
                redirect = window.location.replace("/distribuir/demandas");
            },
            error: function (textStatus, errorThrown) {
                console.log(errorThrown);
                console.log(textStatus);
                console.log(errorThrown);
                alert ("Complemento não gravado.");
            }
        });
    }); 

}); // fecha document ready
