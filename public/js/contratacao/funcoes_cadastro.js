// 8 MEGA = 8388608 bytes
// 20 MEGA = 20971520 bytes

var tamanhoMaximoView = 8;

$('#labelLimiteArquivos span').html(tamanhoMaximoView);

var tamanhoMaximo = 8388608;

$('.collapse').collapse()

// ####################### MARCARA DE DATA, CPF, CNPJ e dinheiro #######################

$(document).ready(function(){
    $('.mascaradinheiro').mask('000.000.000.000.000,00' , { reverse : true});
    $('.mascaradata').mask('00/00/0000');
    $('.mascaraconta').mask('0000.000.00000000-0');

});

// ####################### VALIDAÇÃO DE CPF E CNPJ #######################

$('#radioCpf').click(function (){
    $('#submitBtn').prop("disabled", false);
    $('#spanCpf').html();
    $('#spanCnpj').html();
    $('.validarCpf').cpfcnpj({
        mask: true,
        validate: 'cpf',
        event: 'focusout',
        //validateOnlyFocus: true,
        handler: $(this),
        ifValid: function (input) {
            input.removeClass("error");
            $("#spanValidadorCpf").remove();
            $('#spanCpf').html( '<small class="col label bg-green" id="spanValidadorCpf">O número digitado é VÁLIDO.</small>');
            $('#submitBtn').prop("disabled", false);
        },
        ifInvalid: function (input) {
            input.addClass("error");
            $("#spanValidadorCpf").remove();
            $('#spanCpf').html( '<small class="col label bg-red error" id="spanValidadorCpf">O número digitado é INVÁLIDO.</small>');
            $('#submitBtn').prop("disabled", true);
        }
    });
});

$('#radioCnpj').click(function (){
    $('#submitBtn').prop("disabled", false);
    $('#spanCpf').html();
    $('#spanCnpj').html();
    $('.validarCnpj').cpfcnpj({
        mask: true,
        validate: 'cnpj',
        event: 'focusout',
        //validateOnlyFocus: true,
        handler: $(this),
        ifValid: function (input) {
            input.removeClass("error");
            $("#spanValidadorCnpj").remove();
            $('#spanCnpj').html( '<small class="col label bg-green" id="spanValidadorCpf">O número digitado é VÁLIDO.</small>');
            $('#submitBtn').prop("disabled", false);
        },
        ifInvalid: function (input) {
            input.addClass("error");
            $("#spanValidadorCnpj").remove();
            $('#spanCnpj').html( '<small class="col label bg-red error" id="spanValidadorCnpj">O número digitado é INVÁLIDO.</small>');
            $('#submitBtn').prop("disabled", true);
        }
    });
});

// ####################### FUNÇÃO QUE ZERA O VALOR DE CPF E CNPJ QUANDO O OUTRO FOR SELECIONADO #######################

$(function() {
    $('#radioCpf').click(function() {
        $('#radioCnpj').removeAttr('checked');
        $('#cnpj').val('');
        $('#cpfCnpj2').show();
        $('#cpf').attr('required', true);
        $('#cpfCnpj3').hide();
        $('#cnpj').attr('required', false);
    });
    $('#radioCnpj').click(function() {
        $('#radioCpf').removeAttr('checked');
        $('#cpf').val('');
        $('#cpfCnpj2').hide();
        $('#cpf').attr('required', false);
        $('#cpfCnpj3').show();
        $('#cnpj').attr('required', true);
    });

});

// ####################### VALIDAÇÃO DE SWIFT #######################

$('#swiftAbaBancoBeneficiario').change(function() {
    let value = $(this).val();
    isBic(value);
    function isBic(value) {
        let retorno = /^([A-Z]{6}[A-Z2-9][A-NP-Z1-9])(X{3}|[A-WY-Z0-9][A-Z0-9]{2})?$/.test( value.toUpperCase() );
        
        if (retorno == true) {
            $('#retornoBene').html('<small class="label bg-green">Este SWIFT é VÁLIDO!</small>');
            $('#submitBtn').prop("disabled", false);
        }
        else {
            $('#retornoBene').html('<small class="label bg-red">Este SWIFT é INVÁLIDO!</small>');
            $('#submitBtn').prop("disabled", true);
        };
    
    };
});

$('#swiftAbaBancoIntermediario').change(function() {
    let value = $(this).val();
    isBic(value);
    function isBic(value) {
        let retorno = /^([A-Z]{6}[A-Z2-9][A-NP-Z1-9])(X{3}|[A-WY-Z0-9][A-Z0-9]{2})?$/.test( value.toUpperCase() );
        
        if (retorno == true) {
            $('#retornoInte').html('<small class="label bg-green">Este SWIFT é VÁLIDO!</small>');
            $('#submitBtn').prop("disabled", false);
        }
        else {
            $('#retornoInte').html('<small class="label bg-red">Este SWIFT é INVÁLIDO!</small>');
            $('#submitBtn').prop("disabled", true);
        };
    
    };
});



// ####################### VALIDAÇÃO DE IBAN #######################

$('#ibanBancoBeneficiario').on('change',function(){
    let val = $('#ibanBancoBeneficiario').val();
    let html;

    if (IBAN.isValid(val)) {
        html = '<small class="label bg-green">Este IBAN é VÁLIDO!</small>';
        // $('#submitBtn').attr("disabled", false);

    }
    else {
        html = '<small class="label bg-red">Este IBAN é INVÁLIDO!</small>';
        // $('#submitBtn').attr("disabled", true);
    }
    $('#spanIbanBeneficiario').html(html);
    $('#spanIbanBeneficiario').show();
});

$('#ibanBancoIntermediario').on('change',function(){
    let val = $('#ibanBancoIntermediario').val();
    let html;

    if (IBAN.isValid(val)) {
        html = '<small class="label bg-green">Este IBAN é VÁLIDO!</small>';
        // $('#submitBtn').attr("disabled", false);

    }
    else {
        html = '<small class="label bg-red">Este IBAN é INVÁLIDO!</small>';
        // $('#submitBtn').attr("disabled", true);
    }
    $('#spanIbanIntermediario').html(html);
    $('#spanIbanIntermediario').show();
});



// ####################### FUNÇÃO QUE MOSTRA DOCUMENTACAO DEPENDENDO DA OPERACAO SELECIONADA #######################
// ####################### FUNÇÃO DE REQUIRED NOS ARQUIVOS #######################
$(document).ready(function() {
    $('#tipoOperacao').on('change',function(){
        
    // var val = parseInt($(this).val(), 10);

        switch($('#tipoOperacao option:selected').val()) {

            case "": //-Tipo 1 é Nenhum

            $('input[type="file"]').val('');
            $('.previewNomeArquivo').val('');

            $('#submitBtn').prop("disabled", false);

            $('#divDataPrevistaEmbarque').hide();
            $('#dataPrevistaEmbarque').attr('required', false);
            $('#divRadioDadosBancarios').hide();
            $('input.iban[type=text]').val('');
            $('input.iban[type=text]').attr('required', false);
           
            $('#divInvoice').hide();
            $('#divConhecimento').hide();
            $('#divDi').hide();
            $('#divDue').hide();
            $('#divDocumentosDiversos').hide();


            break;
            
            case "Pronto Importação Antecipado": //-Tipo 2 é Pronto Importação Antecipado

            $('input[type="file"]').val('');
            $('.previewNomeArquivo').val('');

            $('#submitBtn').prop("disabled", false);

            $('#divDataPrevistaEmbarque').show();
            $('#dataPrevistaEmbarque').attr('required', true);
            $('#divRadioDadosBancarios').show();
            $('input.iban[type=text]').val('');
            $('input.iban[type=text]').attr('required', true);

            $('#uploadInvoice').attr('required', true);
            $('#divInvoice').show();
            $('#uploadConhecimento').attr('required', false);
            $('#divConhecimento').hide();
            $('#uploadDi').attr('required', false);
            $('#divDi').hide();
            $('#uploadDue').attr('required', false);
            $('#divDue').hide();
            $('#divDocumentosDiversos').show();
            
    
            break;

            case "Pronto Importação": //-Tipo 3 é Pronto Importação
            
            $('input[type="file"]').val('');
            $('.previewNomeArquivo').val('');

            $('#submitBtn').prop("disabled", false);

            $('#divDataPrevistaEmbarque').hide();
            $('#dataPrevistaEmbarque').attr('required', false);
            $('#divRadioDadosBancarios').show();
            $('input.iban[type=text]').val('');
            $('input.iban[type=text]').attr('required', true);

            $('#uploadInvoice').attr('required', true);
            $('#divInvoice').show();
            $('#uploadConhecimento').attr('required', true);
            $('#divConhecimento').show();
            $('#uploadDi').attr('required', true);
            $('#divDi').show();
            $('#uploadDue').attr('required', false);
            $('#divDue').hide();
            $('#divDocumentosDiversos').show();

            break;

            case "Pronto Exportação Antecipado": //-Tipo 4 é Pronto Exportação Antecipado

            $('input[type="file"]').val('');
            $('.previewNomeArquivo').val('');

            $('#submitBtn').prop("disabled", false);

            $('#divDataPrevistaEmbarque').show();
            $('#dataPrevistaEmbarque').attr('required', true);
            $('#divRadioDadosBancarios').hide();
            $('input.iban[type=text]').val('');
            $('input.iban[type=text]').attr('required', false);

            $('#uploadInvoice').attr('required', true);
            $('#divInvoice').show();
            $('#uploadConhecimento').attr('required', false);
            $('#divConhecimento').hide();
            $('#uploadDi').attr('required', false);
            $('#divDi').hide();
            $('#uploadDue').attr('required', false);
            $('#divDue').hide();
            $('#divDocumentosDiversos').show();
     
        
            break;

            case "Pronto Exportação": //-Tipo 5 é Pronto Exportação

            $('input[type="file"]').val('');
            $('.previewNomeArquivo').val('');

            $('#submitBtn').prop("disabled", false);

            $('#divDataPrevistaEmbarque').hide();
            $('#dataPrevistaEmbarque').attr('required', false);
            $('#divRadioDadosBancarios').hide();
            $('input.iban[type=text]').val('');
            $('input.iban[type=text]').attr('required', false);

            $('#uploadInvoice').attr('required', true);
            $('#divInvoice').show();
            $('#uploadConhecimento').attr('required', true);
            $('#divConhecimento').show();
            $('#uploadDi').attr('required', false);
            $('#divDi').hide();
            $('#uploadDue').attr('required', true);
            $('#divDue').show();
            $('#divDocumentosDiversos').show();

            break;

        } // fecha switch

        //TIRA O REQUIRED DOS CAMPOS INTERMEDIARIO QUE O SWITCH COLOCA

        $('#nomeBancoIntermediario').prop('required', false);
        $('#swiftAbaBancoIntermediario').prop('required', false);
        $('#ibanBancoIntermediario').prop('required', false);
        $('#contaBancoIntermediario').prop('required', false);
        
    });
    
});

        //COLOCA REQUIRED DOS CAMPOS INTERMEDIARIO CONFORME O CHECKBOX


$('#checkbox').change(function () {
    if (this.checked) {
        $('#nomeBancoIntermediario').prop('required', true);
        $('#swiftAbaBancoIntermediario').prop('required', true);
        $('#ibanBancoIntermediario').prop('required', true);
        $('#contaBancoIntermediario').prop('required', true);
    }
    else {
        $('#nomeBancoIntermediario').prop('required', false);
        $('#swiftAbaBancoIntermediario').prop('required', false);
        $('#ibanBancoIntermediario').prop('required', false);
        $('#contaBancoIntermediario').prop('required', false);
    };
});

    //COLOCA REQUIRED EM IBAN OU CONTA CONFORME PREENCHIMENTO


$('#ibanBancoIntermediario, #contaBancoIntermediario').change(function () {
    let $inputs = $('#ibanBancoIntermediario, #contaBancoIntermediario');
    console.log($inputs);
        // Set the required property of the other input to false if this input is not empty.
        $inputs.not(this).prop('required', !$(this).val().length);

});

$('#ibanBancoBeneficiario, #numeroContaBeneficiario').change(function () {
    let $inputs = $('#ibanBancoBeneficiario, #numeroContaBeneficiario');
    console.log($inputs);
        // Set the required property of the other input to false if this input is not empty.
        $inputs.not(this).prop('required', !$(this).val().length);

});



// ####################### FUNÇÃO QUE PROIBE DAR UPLOAD EM ARQUIVOS QUE NÃO SEJAM PDF OU IMAGEM #######################


$('input[type="file"]').change(function () {
    var ext = this.value.split('.').pop().toLowerCase();
    switch (ext) {
        case 'jpg':
        case 'jpeg':
        case 'png':
        case 'pdf':
        case '7z':
        case 'zip':
        case 'rar':
        case 'doc':
        case 'docx':
            $('#submitBtn').attr('disabled', false);
            
            break;
        default:
            $('#submitBtn').attr('disabled', true);
            alert('O tipo de arquivo selecionado não é aceito. Favor carregar um arquivo de imagem, PDF, Word ou Zip.');
            this.value = '';
    }
});

// ####################### FUNÇÃO DE ANIMAÇÃO DO BOTÃO UPLOAD #######################

$(function() {

    // We can attach the `fileselect` event to all file inputs on the page
    $(document).on('change', ':file', function() {
        var input = $(this),
            numFiles = input.get(0).files ? input.get(0).files.length : 1,
            label = input.val().replace(/\\/g, '/').replace(/.*\//, ''),
            totalSize = 0;

        $(input).each(function() {
            for (var i = 0; i < this.files.length; i++) {
                totalSize += this.files[i].size / 1024;
            }
        });

        if (totalSize <= tamanhoMaximo) {
            totalSizeKb = (Math.round(totalSize * 100) / 100) + ' kb no total';
            input.trigger('fileselect', [numFiles, label, totalSizeKb]);
        }
        else {
            alert('O tamanho máximo para upload de arquivos foi excedido');
        }
    });
  
    // We can watch for our custom `fileselect` event like this
    $(document).ready( function() {
        $(':file').on('fileselect', function(event, numFiles, label, totalSizeKb) {
  
            var input = $(this).parents('.input-group').find(':text'),
                log = numFiles > 1 ? numFiles + ' arquivos selecionados, ' + totalSizeKb : label + ', ' + totalSizeKb;
  
            if( input.length ) {
                input.val(log);
            } else {
                if( log ) alert(log);
            }
  
        });
    });
    
  });

  
$('#formCadastroContratacao_').submit(function(){
    $('#submitBtn').html('<div class="loader"></div>&nbsp Gravando...')
    return true;
});


