$(document).ready(function() {

    // var cpfCnpj = '10.222.2220001-88';
    // var protocolo ='546654';

    // var cpfCnpj = $("#cpfCnpj").val();
    // var protocolo = $("#idDemanda").val();

    var cpfCnpj = $("#cpfCnpj").html();
    var protocolo = $("#idDemanda").html();

    // var json = {
    //     "fileInvoice" : "'http://www.ceopc.hom.sp.caixa/esteira-contratacao/upload-teste/10222222000188/546654/invoice_546654.jpg','",
    //     "captionInvoice" : "'{caption: 'invoice_546654.jpg'},'",
    //     "fileDi" : "'http://www.ceopc.hom.sp.caixa/esteira-contratacao/upload-teste/10222222000188/546654/di_546654.pdf','",
    //     "captionDi": "'{caption: 'di_546654.pdf'},'",
    //     "fileConhecimento": "'http://www.ceopc.hom.sp.caixa/esteira-contratacao/upload-teste/10222222000188/546654/conhecimento_546654.docx','",
    //     "captionConhecimento": "'{caption: 'conhecimento_546654.docx'},'"
    // };

    // var invoiceUrl = {
        
    // };
    // var di = {
        
    // };
    // var conhecimento = {
        
    // };
    var urlInvoice = '';
    var fileInvoice = '';
    var typeInvoice = '';
    var urlDi = '';
    var fileDi = '';
    var typeDi = '';
    var urlConhecimento = '';
    var fileConhecimento = '';
    var typeConhecimento = '';
    var urlSr = '';
    var fileSr = '';
    var typeSr = '';


// $.ajax({
//     type: 'GET',
//     url: 'tabela_analise_arquivos.json',
//     // data: { get_param: 'value' },
//     dataType: 'JSON',
//     success: function(data){
//         // var data = data;
        
//         fileInvoice = data[0].fileInvoice;
//         captionInvoice = data[0].captionInvoice;
//         fileDi = data[0].fileDi;
//         captionDi = data[0].captionDi;
//         fileConhecimento = data[0].fileConhecimento;
//         captionConhecimento = data[0].captionConhecimento;
//         console.log(data);
    // },
    // });

    $.ajax({
        type: 'GET',
        url: '../../js/contratacao/tabela_analise_arquivos2.json',
        // data: { get_param: 'value' },
        dataType: 'JSON',
        success: function(data){
            // var data = data;
            
            urlInvoice = data[0].urlInvoice;
            fileInvoice = data[0].fileInvoice;
            typeInvoice = data[0].typeInvoice;
            urlDi = data[0].urlDi;
            fileDi = data[0].fileDi;
            typeDi = data[0].typeDi;
            urlConhecimento = data[0].urlConhecimento;
            fileConhecimento = data[0].fileConhecimento;
            typeConhecimento = data[0].typeConhecimento;
            urlSr = data[0].urlSr;
            fileSr = data[0].fileSr;
            typeSr = data[0].typeSr;       
            console.log(data);
    



// salvaVariaveis();

// $("#input-iconic").fileinput({
$(":file").fileinput({
    fileActionSettings: {
        showRemove: false,
        showUpload: false,
        showZoom: true,
        showDrag: false,
    },
    showBrowse: false,
    theme: 'fa',
    language: 'pt-BR',
    uploadUrl: '../../js/contratacao/upload-teste/',
    minFileCount: 1,
    maxFileCount: 5,
    overwriteInitial: false,
    previewFileIcon: '<i class="fa fa-fw fa-file-o"></i>',
    allowedPreviewExtensions: ["pdf", "doc", "docx", "txt", "zip", "jpg", "png", "jpeg"],
    allowedFileExtensions: ["jpg", "jpeg", "png","pdf"],
    msgInvalidFileExtension: "O tipo de arquivo selecionado não é suportado. Favor selecionar um arquivo de imagem ou PDF." ,

    // accept=".pdf,.doc,.docx,.txt,.zip,.jpg,.gif,.png" 

    initialPreview: [
        
        urlInvoice, 
        urlDi, 
        urlConhecimento,
        urlSr,

            // 'upload-teste/' + cpfCnpj + '/' + protocolo + '/invoice_' + protocolo + '.jpg',
            // 'upload-teste/' + cpfCnpj + '/' + protocolo + '/di_' + protocolo + '.pdf',
            // 'upload-teste/' + cpfCnpj + '/' + protocolo + '/conhecimento_' + protocolo + '.docx',


            // 'upload-teste/' + cpfCnpj + '/' + protocolo + '/invoice_' + protocolo + '.jpg',
            // 'upload-teste/' + cpfCnpj + '/' + protocolo + '/di_' + protocolo + '.pdf',
            // 'upload-teste/' + cpfCnpj + '/' + protocolo + '/conhecimento_' + protocolo + '.docx',
            
            // 'upload-teste/' + cpfCnpj + '/' + protocolo + '/invoice_' + protocolo + '.jpeg',
            // 'upload-teste/' + cpfCnpj + '/' + protocolo + '/invoice_' + protocolo + '.png',
            // 'upload-teste/' + cpfCnpj + '/' + protocolo + '/invoice_' + protocolo + '.pdf',
            // 'upload-teste/' + cpfCnpj + '/' + protocolo + '/invoice_' + protocolo + '.rar',
            // 'upload-teste/' + cpfCnpj + '/' + protocolo + '/invoice_' + protocolo + '.zip',
            // 'upload-teste/' + cpfCnpj + '/' + protocolo + '/invoice_' + protocolo + '.7z',


            // 'upload-teste/10.222.2220001-88/546654/invoice_546654.jpg',

    ],
    initialPreviewAsData: true, // defaults markup  
    initialPreviewFileType: 'image',
    initialPreviewDownloadUrl: '../../js/contratacao/upload-teste/' + cpfCnpj + '/' + protocolo + '/{filename}',
    initialPreviewConfig: [ 

        {caption: fileInvoice},
        {type: typeDi, caption: fileDi, url: urlDi},
        {type: typeConhecimento, caption: fileConhecimento, url: urlConhecimento},
        {type: typeSr, caption: fileSr, url: urlSr},


        // {caption: 'invoice_' + protocolo + '.pdf', type: 'pdf'},
        // {caption: 'invoice_' + protocolo + '.doc', type: 'office'},
        // {caption: 'invoice_' + protocolo + '.docx', type: 'office'},
        // {caption: 'invoice_' + protocolo + '.txt', type: 'text'},
        // {caption: 'invoice_' + protocolo + '.zip'},
        // {caption: 'invoice_' + protocolo + '.jpg'},
        // {caption: 'invoice_' + protocolo + '.png'},
        // {caption: 'invoice_' + protocolo + '.gif'},

        // {caption: 'di_' + protocolo + '.pdf', type: 'pdf'},
        // {caption: 'di_' + protocolo + '.doc', type: 'office'},
        // {caption: 'di_' + protocolo + '.docx', type: 'office'},
        // {caption: 'di_' + protocolo + '.txt', type: 'text'},
        // {caption: 'di_' + protocolo + '.zip'},
        // {caption: 'di_' + protocolo + '.jpg'},
        // {caption: 'di_' + protocolo + '.png'},
        // {caption: 'di_' + protocolo + '.gif'},

        // {caption: 'conhecimento_' + protocolo + '.doc', type: 'office'},
        // {caption: 'conhecimento_' + protocolo + '.docx', type: 'office'},
        // {caption: 'conhecimento_' + protocolo + '.pdf', type: 'pdf'},
        // {caption: 'conhecimento_' + protocolo + '.txt', type: 'text'},
        // {caption: 'conhecimento_' + protocolo + '.zip'},
        // {caption: 'conhecimento_' + protocolo + '.jpg'},
        // {caption: 'conhecimento_' + protocolo + '.png'},
        // {caption: 'conhecimento_' + protocolo + '.gif'},



        // {caption: 'invoice_' + protocolo + '.jpg'},
        // {caption: 'di_' + protocolo + '.pdf', type: 'pdf'},
        // {caption: 'conhecimento_' + protocolo + '.docx', type: 'office'},
    ],

    // removeFromPreviewOnError: true,
    purifyHtml: true,
    uploadExtraData: { 
        function() {
            return {
            userid: $("#matricula").val(),
            username: $("#matricula").val(),
            responsavelAtual: $('#matricula').val(),

            dataLiquidacao: $('#dataLiquidacao').val(),
            numeroBoleto: $('#numeroBoleto').val(),
            statusGeral: $('#statusGeral').val(),

                    // fazer if

            statusInvoice: $('#statusInvoice').val(),
            statusConhecimento: $('#statusConhecimento').val(),
            statusDiDue: $('#statusDiDue').val(),
            statusDadosBancarios: $('#statusDadosBancarios').val(),
            statusAutorizacaoSr: $('#statusAutorizacaoSr').val(),
            
            observacoesCeopc: $('#observacoesCeopc').val(),
            }; 
        }    
    },
    preferIconicPreview: true, // this will force thumbnails to display icons for following file extensions
         previewFileIconSettings: { // configure your icon file extensions
            'doc': '<i class="fa fa-fw fa-file-word-o text-primary"></i>',
            'pdf': '<i class="fa fa-fw fa-file-pdf-o text-danger"></i>',
            'zip': '<i class="fa fa-fw fa-file-zip-o text-muted"></i>',
            // note for these file types below no extension determination logic 
            // has been configured (the keys itself will be used as extensions)
            'jpg': '<i class="fa fa-fw fa-file-image-o text-danger"></i>', 
            'gif': '<i class="fa fa-fw fa-file-image-o text-muted"></i>', 
            'png': '<i class="fa fa-fw fa-file-image-o text-primary"></i>'    
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
// }).on('filesorted', function(e, params) {
//     console.log('File sorted params', params);
// }).on('fileuploaded', function(e, params) {
//     console.log('File uploaded params', params);
});
},
});




}) // fim do doc ready

