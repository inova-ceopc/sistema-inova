$(document).ready(function() {

    
    var idDemanda = $("#idDemanda").val();

    console.log(idDemanda);


    $.ajax({
        type: 'GET',
        url: '/api/esteiracomex/contratacao/' + idDemanda,
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

            $('#nomeCliente').html(dados[0].nomeCliente);
            $('#tipoOperacao').html(dados[0].tipoOperacao);
            $('#tipoMoeda').html(dados[0].tipoMoeda);
            $('#valorOperacao').html(dados[0].valorOperacao);
            $('#dataPrevistaEmbarque').html(dados[0].dataPrevistaEmbarque);
            $('#agResponsavel').html(dados[0].agResponsavel);
            $('#srResponsavel').html(dados[0].srResponsavel);            
            $('#dataLiquidacao').html(dados[0].dataLiquidacao);
            $('#numeroBoleto').html(dados[0].numeroBoleto);
            $('#statusGeral').html(dados[0].statusAtual);
            
            //EACH para montar cada linha de histórico que vem no json

            $.each(dados[0].esteira_contratacao_historico, function(key, item) {
                var linha = 
                    '<tr>' +
                        '<td class="col-sm-1">' + item.idHistorico + '</td>' +
                        '<td class="col-sm-2">' + item.dataStatus + '</td>' +
                        '<td class="col-sm-1">' + item.tipoStatus + '</td>' +
                        '<td class="col-sm-1">' + item.responsavelStatus + '</td>' +
                        '<td class="col-sm-1">' + item.area + '</td>' +
                        '<td class="col-sm-7">' + item.analiseHistorico + '</td>' +
                    '</tr>';

                $(linha).appendTo('#historico>tbody');

            });

            // IF que faz aparecer e popula os capos de Conta de Beneficiário no exterior e IBAN etc

            var tipoOperação = $("#tipoOperacao").html();
            console.log(tipoOperação);

            if ((tipoOperação == 'Pronto Importação Antecipado') || (tipoOperação == 'Pronto Importação')){
                $('#groupIban').show();
                $('#iban1').val(dados[0].esteira_contratacao_conta_importador.nomeBeneficiario);
                $('#iban2').val(dados[0].esteira_contratacao_conta_importador.nomeBanco);
                $('#iban3').val(dados[0].esteira_contratacao_conta_importador.iban);
                $('#iban4').val(dados[0].esteira_contratacao_conta_importador.agContaBeneficiario);
            };


            $.each(dados[0].esteira_contratacao_confere_conformidade, function(key, item) {

                console.log(item)

                $('#div' + item.tipoDocumento).show();
                $('#' + item.tipoDocumento).val(item.statusDocumento);

                // $('#statusConhecimento').val(dados[0].statusConhecimento);
                // $('#statusDi').val(dados[0].statusDi);
                // $('#statusDue').val(dados[0].statusDue);
                // $('#statusDadosBancarios').val(dados[0].statusDadosBancarios);
                // $('#statusAutorizacaoSr').val(dados[0].statusAutorizacaoSr);       
                
                
                // switch (tipoOperação) {

                // case 'Pronto Importação Antecipado':

                // }; // fecha switch

            });


            // IF que fazem aparecer os campos de input file de acordo com o status

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

        }
    });


    $('#formUploadComplemento').submit(function(e){
        e.preventDefault();
        var formData = $('#formUploadComplemento').serializeArray();
        console.log(formData);
        $.ajax({
            method: 'PUT',
            url: 'api/esteiracomex/contratacao/{contratacao}',
            dataType: 'JSON',
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
