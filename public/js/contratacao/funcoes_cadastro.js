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

$(document).ready(function (){
    $('.validarCpf').cpfcnpj({
        mask: true,
        validate: 'cpf',
        event: 'focusout',
        //validateOnlyFocus: true,
        handler: $(this),
        ifValid: function (input) {
            input.removeClass("error");
            $("#spanValidadorCpf").remove();
        },
        ifInvalid: function (input) {
             input.addClass("error");
             $("#spanValidadorCpf").remove();
             input.after( '<span class="col error" id="spanValidadorCpf">O número digitado não é válido.</span>');
        }
    });
});

$(document).ready(function (){
    $('.validarCnpj').cpfcnpj({
        mask: true,
        validate: 'cnpj',
        event: 'focusout',
        //validateOnlyFocus: true,
        handler: $(this),
        ifValid: function (input) {
            input.removeClass("error");
            $("#spanValidadorCnpj").remove();
        },
        ifInvalid: function (input) {
             input.addClass("error");
             $("#spanValidadorCnpj").remove();
             input.after( '<span class="col error" id="spanValidadorCnpj">O número digitado não é válido.</span>');
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

// ####################### FUNÇÃO QUE MOSTRA DOCUMENTACAO DEPENDENDO DA OPERACAO SELECIONADA #######################
// ####################### FUNÇÃO DE REQUIRED NOS ARQUIVOS #######################
$(document).ready(function() {
    $('#tipoOperacao').on('change',function(){
        
    // var val = parseInt($(this).val(), 10);

        switch($('#tipoOperacao option:selected').val()) {

            case "": //-Tipo 1 é Nenhum

            $('input[type="file"]').val('');

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

            $('#divDataPrevistaEmbarque').show();
            $('#dataPrevistaEmbarque').attr('required', true);
            $('#divRadioDadosBancarios').show();
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

            case "Pronto Importação": //-Tipo 3 é Pronto Importação
            
            $('input[type="file"]').val('');

            $('#divDataPrevistaEmbarque').hide();
            $('#dataPrevistaEmbarque').attr('required', false);
            $('#divRadioDadosBancarios').show();
            $('input.iban[type=text]').val('');
            $('input.iban[type=text]').attr('required', false);

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
    })
});


// ####################### FUNÇÃO QUE ESCONDE CAMPO IBAN DEPENDENDO DO SELECIONADO #######################


// $(document).ready(function() {
//     $("input[name$='temDadosBancarios']").click(function() {
//         var test = $(this).val();

//         $("div.desc2").hide();
//         $("#divInformaDadosBancarios" + test).show();

//         if ($('#temDadosBancariosSim').is(':checked')) {
//             $('#divDados').show();
//             $('#uploadDadosBancarios').attr('required', true);
//             $('input.iban[type=text]').attr('required', false);
//         }
//         else {
//             $('#divDados').hide();
//             $('#uploadDadosBancarios').attr('required', false);
//             $('input.iban[type=text]').attr('required', true);
//         }
    
//     });
// });

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


