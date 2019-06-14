$(document).ready(function() {

//Declaração de variáveis dos inputs de arquivos, para carregar múltiplos como array.
    // var invoiceImpAnt = [];
    // var dadosImpAnt = [];
    // var autSrImpAnt = [];

    // var invoiceImp = [];
    // var embarqueImp = [];
    // var di = [];
    // var dadosImp = [];
    // var autSrImp = [];

    // var invoiceExpAnt = [];
    // var autSrExpAnt = [];
   
    // var invoiceExp = [];
    // var embarqueExp = [];
    // var due = [];
    // var autSrExp = [];





// $('input[name="temContaBeneficiarioAntecipado"]').click(function() {
//         if ($('#temContaBeneficiarioAntecipadoSim').is(':checked')) {
//         $('#dadosImpAnt').attr('required', true);
//         }
//         else {
//         $('#dadosImpAnt').attr('required', false);
//         }
//     });
// $('input[name="temContaBeneficiarioNormal"]').click(function() {
//         if ($('#temContaBeneficiarioNormalSim').is(':checked')) {
//         $('#dadosImp').attr('required', true);
//         }
//         else{
//         $('#dadosImp').attr('required', false);
//         }
    
//     });

    // $('input[type="file"]').change(function () {
    //     var ext = this.value.split('.').pop().toLowerCase();
    //     switch (ext) {
    //         case 'jpg':
    //         case 'jpeg':
    //         case 'png':
    //         case 'pdf':
    //             $('#submitBtn').attr('disabled', false);
                
    //             break;
    //         default:
    //             $('#submitBtn').attr('disabled', true);
    //             alert('O tipo de arquivo selecionado não é aceito. Favor carregar um arquivo de imagem ou PDF.');
    //             this.value = '';
    //     }
    // });

    $(":file").fileinput({
        fileActionSettings: {
        },
        theme: 'fa',
        language: 'pt-BR',
        uploadUrl: '../../js/contratacao/backend/',
        uploadAsync: false,
        minFileCount: 1,
        maxFileCount: 20,
        overwriteInitial: false,
        previewFileIcon: '<i class="fas fa-file"></i>',
        allowedPreviewExtensions: ["pdf","zip", "jpg", "png", "jpeg"],
        allowedFileExtensions: ["jpg", "jpeg", "png","pdf", "zip", "rar", "7z"],
        msgInvalidFileExtension: "O tipo de arquivo selecionado não é suportado. Favor selecionar um arquivo de imagem, PDF ou ZIP." ,
        purifyHtml: true,
        uploadExtraData:{ function() {
            return {

            userid: $("#matricula").val(),
            username: $("#matricula").val(),
            cpf: $('#cpf').val(),
            cnpj: $('#cnpj').val(),
            nomeCliente: $('#nomeCliente').val(),
            tipoOperacao: $('#tipoOperacao').val(),
            tipoMoeda: $('#tipoMoeda').val(),
            valorOperacao: $('#valorOperacao').val(),
            dataPrevistaEmbarque: $('#dataPrevistaEmbarque').val(),
            responsavelAtual: $('#matricula').val(),

            //-puxa dados bancarios beneficiário Antecipado
            nomeBeneficiario: $('#nomeBeneficiarioAnt').val(),
            nomeBanco: $('#nomeBancoAnt').val(),
            iban: $('#ibanAnt').val(),
            AgContaBeneficiario: $('#AgContaBeneficiarioAnt').val(),
            //
            //-puxa arquivos de Pronto Importação Antecipado
            uploadArquivos: $('#uploadArquivos').val(),


        //     img_key: "1000",
        //     img_keywords: "happy, nature"
        }}
    },
        preferIconicPreview: true, // this will force thumbnails to display icons for following file extensions
             previewFileIconSettings: { // configure your icon file extensions
            'doc': '<i class="fas fa-file-word text-primary"></i>',
            'xls': '<i class="fas fa-file-excel text-success"></i>',
            'ppt': '<i class="fas fa-file-powerpoint text-danger"></i>',
            'pdf': '<i class="fas fa-file-pdf text-danger"></i>',
            'zip': '<i class="fas fa-file-archive text-muted"></i>',
            'htm': '<i class="fas fa-file-code text-info"></i>',
            'txt': '<i class="fas fa-file-text text-info"></i>',
            'mov': '<i class="fas fa-file-video text-warning"></i>',
            'mp3': '<i class="fas fa-file-audio text-warning"></i>',
            // note for these file types below no extension determination logic 
            // has been configured (the keys itself will be used as extensions)
            'jpg': '<i class="fas fa-file-image text-danger"></i>', 
            'gif': '<i class="fas fa-file-image text-muted"></i>', 
            'png': '<i class="fas fa-file-image text-primary"></i>'    
        },
        previewFileExtSettings: { // configure the logic for determining icon file extensions
            'doc': function(ext) {
                return ext.match(/(doc|docx)$/i);
            },
            'xls': function(ext) {
                return ext.match(/(xls|xlsx)$/i);
            },
            'ppt': function(ext) {
                return ext.match(/(ppt|pptx)$/i);
            },
            'zip': function(ext) {
                return ext.match(/(zip|rar|tar|gzip|gz|7z)$/i);
            },
            'htm': function(ext) {
                return ext.match(/(htm|html)$/i);
            },
            'txt': function(ext) {
                return ext.match(/(txt|ini|csv|java|php|js|css)$/i);
            },
            'mov': function(ext) {
                return ext.match(/(avi|mpg|mkv|mov|mp4|3gp|webm|wmv)$/i);
            },
            'mp3': function(ext) {
                return ext.match(/(mp3|wav)$/i);
            }
        }
        })
        // .on('filesorted', function(e, params) {
        //     console.log('File sorted params', params);
        //     })
        // .on('fileuploaded', function(e, params) {
        //     console.log('File uploaded params', params);
        //     });    

// $("#formTipoOperacao").submit(function postCadastro() {

//     tipoOperacao = $('#tipoOperacao').val();
//     switch (tipoOperacao) {

//     case '1':

//     alert = "Nenhuma operação foi selecionada.";

//     break;

//     case '2': //-Tipo 2 é Pronto Importação Antecipado

//     submit = {
//         cpf: $('#cpf').val(),
//         cnpj: $('#cnpj').val(),
//         nomeCliente: $('#nomeCliente').val(),
//         tipoOperacao: $('#tipoOperacao').val(),
//         tipoMoeda: $('#tipoMoeda').val(),
//         valorOperacao: $('#valorOperacao').val(),
//         dataPrevistaEmbarque: $('#dataPrevistaEmbarque').val(),
//         responsavelAtual: $('#matricula').val(),

//         //-puxa dados bancarios beneficiário Antecipado
//         nomeBeneficiario: $('#nomeBeneficiarioAnt').val(),
//         nomeBanco: $('#nomeBancoAnt').val(),
//         iban: $('#ibanAnt').val(),
//         AgContaBeneficiario: $('#AgContaBeneficiarioAnt').val(),
//         //
//         //-puxa arquivos de Pronto Importação Antecipado
//         invoiceImpAnt: $('#invoiceImpAnt').val(),
//         dadosImpAnt: $('#dadosImpAnt').val(),
//         autSrImpAnt: $('#autSrImpAnt').val(),
//         //
//         } //- Fecha submit case 2

//         break;

//     case '3': //-Tipo 3 é Pronto Importação

//     submit = {
//         cpf: $('#cpf').val(),
//         cnpj: $('#cnpj').val(),
//         nomeCliente: $('#nomeCliente').val(),
//         tipoOperacao: $('#tipoOperacao').val(),
//         tipoMoeda: $('#tipoMoeda').val(),
//         valorOperacao: $('#valorOperacao').val(),
//         dataPrevistaEmbarque: $('#dataPrevistaEmbarque').val(),
//         responsavelAtual: $('#matricula').val(),


//         //-puxa dados bancarios beneficiário 
//         nomeBeneficiario: $('#nomeBeneficiario').val(),
//         nomeBanco: $('#nomeBanco').val(),
//         iban: $('#iban').val(),
//         AgContaBeneficiario: $('#AgContaBeneficiario').val(),
//         //        

//         //-puxa arquivos de Pronto Importação
//         invoiceImp: $('#invoiceImp').val(),
//         embarqueImp: $('#embarqueImp').val(),
//         di: $('#di').val(),
//         dadosImp: $('#dadosImp').val(),
//         autSrImp: $('#autSrImp').val(),
//         //
//         }//- Fecha submit case 3

//         break;

//     case '4': //-Tipo 3 é Pronto Exportação Antecipado

//     submit = {
//         cpf: $('#cpf').val(),
//         cnpj: $('#cnpj').val(),
//         nomeCliente: $('#nomeCliente').val(),
//         tipoOperacao: $('#tipoOperacao').val(),
//         tipoMoeda: $('#tipoMoeda').val(),
//         valorOperacao: $('#valorOperacao').val(),
//         dataPrevistaEmbarque: $('#dataPrevistaEmbarque').val(),
//         responsavelAtual: $('#matricula').val(),

//         //-puxa arquivos de Pronto Exportação Antecipado
//         invoiceExpAnt: $('#invoiceExpAnt').val(),
//         autSrExpAnt: $('#autSrExpAnt').val(),
//         //
//         }//- Fecha submit case 4

//         break;

//     case '5': //-Tipo 3 é Pronto Exportação

//     submit = {
//         cpf: $('#cpf').val(),
//         cnpj: $('#cnpj').val(),
//         nomeCliente: $('#nomeCliente').val(),
//         tipoOperacao: $('#tipoOperacao').val(),
//         tipoMoeda: $('#tipoMoeda').val(),
//         valorOperacao: $('#valorOperacao').val(),
//         dataPrevistaEmbarque: $('#dataPrevistaEmbarque').val(),
//         responsavelAtual: $('#matricula').val(),

//         //-puxa arquivos de Pronto Exportação
//         invoiceExp: $('#invoiceExp').val(),
//         embarqueExp: $('#embarqueExp').val(),
//         due: $('#due').val(),
//         autSrExp: $('#autSrExp').val(),
//         //
//         } // fecha submit case 5

// }; // fecha switch

$.ajaxSetup({
    headers: {
    'X-CSRF-TOKEN': "{{ csrf_token() }}"
    }
}); 



// $.post('backend/post_teste.php', submit, function(postCadastro){
//     // submit = JSON.parse(postCadastro);
//     console.log (postCadastro);
//     alert("Demanda cadastrada com sucesso.");
// });


$('#formTipoOperacao').submit (function(e){
    e.preventDefault();
    var formData = new FormData($(this)[0]); // Creating a formData using the form.
    $.ajax({
        method: 'POST',
        url: '/contratacao/cadastro',
        dataType: 'json',
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










// $.each($('input[type="file"]').lenght, function(i=0, value) {

    
// var filename = this.value;
// console.log(filename);
// var valid_extensions = /(\.jpg|\.jpeg|\.gif)$/i;   
// if(valid_extensions.test(filename))
// {

// }
// else
// {
//    alert('O tipo de arquivo selecionado não é aceito. Favor carregar um arquivo de imagem ou PDF.');
// }
// });


    // linha = montaLinhaTabelaProdutos(produto);
    // $('#tabelaProdutos>tbody').append(linha);
    



// }); // fecha função postCadastro


}); // fecha document ready
