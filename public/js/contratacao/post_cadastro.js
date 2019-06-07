$(document).ready(function() {

//Declaração de variáveis dos inputs de arquivos, para carregar múltiplos como array.
    var invoiceImpAnt = '';
    var dadosImpAnt = '';
    var autSrImpAnt = '';

    var invoiceImp = '';
    var embarqueImp = '';
    var di = '';
    var dadosImp = '';
    var autSrImp = '';

    var invoiceExpAnt = '';
    var autSrExpAnt = '';
   
    var invoiceExp = '';
    var embarqueExp = '';
    var due = '';
    var autSrExp = '';

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

//     $("#formCadastroContratacao").submit(function postCadastro() {

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
//         nomeBeneficiario: $('#iban1').val(),
//         nomeBanco: $('#iban2').val(),
//         iban: $('#iban3').val(),
//         agContaBeneficiario: $('#iban4').val(),
//         //
//         //-puxa arquivos de Pronto Importação Antecipado
//         invoiceImpAnt: $('#uploadInvoice').map(function(){return $(this).val();}).get(),
//         dadosImpAnt: $('#uploadDadosBancarios').map(function(){return $(this).val();}).get(),
//         autSrImpAnt: $('#uploadAutorizacaoSr').map(function(){return $(this).val();}).get(),
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
//         nomeBeneficiario: $('#iban1').val(),
//         nomeBanco: $('#iban2').val(),
//         iban: $('#iban3').val(),
//         agContaBeneficiario: $('#iban4').val(),
//         //        

//         //-puxa arquivos de Pronto Importação
//         invoiceImp: $('#uploadInvoice').val(),
//         embarqueImp: $('#uploadConhecimento').val(),
//         di: $('#uploadDi').val(),
//         dadosImp: $('#uploadDadosBancarios').val(),
//         autSrImp: $('#uploadAutorizacaoSr').val(),
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
//         invoiceExpAnt: $('#uploadInvoice').val(),
//         autSrExpAnt: $('#uploadAutorizacaoSr').val(),
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
//         invoiceExp: $('#uploadInvoice').val(),
//         embarqueExp: $('#uploadConhecimento').val(),
//         due: $('#uploadDue').val(),
//         autSrExp: $('#uploadAutorizacaoSr').val(),
//         //
//         } // fecha submit case 5

// }; // fecha switch


// $('#formCadastroContratacao').on('submit', function(e){
//     e.preventDefault();
//     var formData = new FormData($(this).get(0)); // Creating a formData using the form.
//     $.ajax({
//         method: 'post',
//         url: 'backend/post_teste2.php',
//         dataType: 'json',
//         cache: false,
//         processData: false, // Important!
//         contentType: false, // Important! I set dataType above as Json
//         data: formData, // Important! The formData should be sent this way and not as a dict.
//         // beforeSend: function(xhr){xhr.setRequestHeader('X-CSRFToken', "{{csrf_token}}");},
//         success: function(data, textStatus) {
//             console.log(data);
//             console.log(formData);
//             console.log(textStatus);
//         },
//         error: function (textStatus, errorThrown) {
//             console.log(errorThrown);
//             console.log(textStatus);
//             console.log(errorThrown);
//         }
//     });
// });



$('#formCadastroContratacao').on('submit', function(e){
    e.preventDefault();
    var formData = new FormData($(this).get(0)); // Creating a formData using the form.
    $.ajax({
        type: 'post',
        url: 'backend/post_teste2.php',
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


// $.post('backend/post_teste.php', submit, function(postCadastro){
//     // submit = JSON.parse(postCadastro);
//     console.log (submit);
//     alert("Demanda cadastrada com sucesso.");
// });


    // var form_data = new FormData();
    // var ins = document.getElementById('multiFiles').files.length;
    // for (var x = 0; x < ins; x++) {
    //     form_data.append("files[]", document.getElementById('multiFiles').files[x]);
    // }
    // $.ajax({
    //     url: '/backend/post_teste.php', // point to server-side PHP script 
    //     dataType: 'text', // what to expect back from the PHP script
    //     cache: false,
    //     contentType: false,
    //     processData: false,
    //     data: form_data,
    //     type: 'post',
    //     success: function (response) {
    //         $('#msg').html(response); // display success response from the PHP script
    //     },
    //     error: function (response) {
    //         $('#msg').html(response); // display error response from the PHP script
    //     }
    // });






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
