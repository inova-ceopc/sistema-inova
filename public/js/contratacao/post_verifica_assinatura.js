// Carrega função de animação de spinner do arquivo anima_loading_submit.js
$('#formVerificaAssinatura').submit(function(){
    _animaLoadingSubmit();
});

$(document).ready(function() {
    
    var idDemanda = $("#idDemanda").val();

    $.ajax({
        type: 'GET',
        url: '/esteiracomex/contratacao/cadastrar/' + idDemanda,
        data: 'value',
        dataType: 'json',
        success: function (dados) {

            if (dados[0].cpf == null){
                $('#cpfCnpj').html(dados[0].cnpj);
            }

            else {
                $('#cpfCnpj').html(dados[0].cpf);
            };

            if (dados[0].tipoOperacao == 'Pronto Importação Antecipado' || dados[0].tipoOperacao == 'Pronto Exportação Antecipado') {
                $('#divDataPrevistaEmbarque').show();

                function formatDate () {
                    var datePart = dados[0].dataPrevistaEmbarque.match(/\d+/g),
                    year = datePart[0],
                    month = datePart[1], 
                    day = datePart[2];
                    
                    return day+'/'+month+'/'+year;
                };
            }
            else {
                var formatDate = dados[0].dataPrevistaEmbarque;
            };

            if (dados[0].dataLiquidacao == null) {
                formatDate2 = '';
            }

            else{
                function formatDate2 () {
                    var datePart = dados[0].dataLiquidacao.match(/\d+/g),
                    year = datePart[0],
                    month = datePart[1], 
                    day = datePart[2];
                
                    return day+'/'+month+'/'+year;
                };
            };

            $('#nomeCliente').html(dados[0].nomeCliente);
            $('#tipoOperacao').html(dados[0].tipoOperacao);
            $('#tipoMoeda').html(dados[0].tipoMoeda);
            $('#valorOperacao').html(dados[0].valorOperacao);
            $('#dataPrevistaEmbarque').html(formatDate);
            $('#agResponsavel').html(dados[0].agResponsavel);
            $('#srResponsavel').html(dados[0].srResponsavel);            
            $('#dataLiquidacao').html(formatDate2);
            $('#numeroBoleto').html(dados[0].numeroBoleto);
            $('#equivalenciaDolar').html(dados[0].equivalenciaDolar);
            $('#statusGeral').html(dados[0].statusAtual);
            

            //Função global para montar cada linha de histórico do arquivo formata_tabela_historico.js
            _formataTabelaHistorico(dados);

            //Função global que formata a data para valor humano do arquivo formata_data.js
            _formataData();

            //Função global que formata dinheiro para valor humano do arquivo formata_data.js.
            _formataValores();

            // IF que faz aparecer e popula os capos de Conta de Beneficiário no exterior e IBAN etc

            var tipoOperação = $("#tipoOperacao").html();

            if ((tipoOperação == 'Pronto Importação Antecipado') || (tipoOperação == 'Pronto Importação')){
                $('#divHideDadosBancarios').show();
                $('#divHideDadosIntermediario').show();
                $.each(dados[0].esteira_contratacao_conta_importador, function(key, item) {
                    $('#' + key).html(item);
                });
            };

            //Função global que monta a tabela de contratos assinados para verificacao do arquivo formata_tabela_documentos.js
            _formataTabelaVerificaContratosAssinados(dados);

            $.each(dados[0].esteira_contratacao_upload, function(key, item) {

                var botaoAcao = 
                    '<form method="post" action="/esteiracomex/contratacao/verificar-contrato-assinado/' + item.idUploadLink + '" enctype="multipart/form-data" class="radio-inline padding0 excluiDocumentos" name="formExcluiDocumentos' + item.idUploadLink + '"" id="formExcluiDocumentos' + item.idUploadLink + '">' +
                        '<input type="text" class="_method" name="_method" value="PUT" hidden>' +
                        '<input type="text" class="excluid" name="idUploadLink" value="' + item.idUploadLink + '" hidden>' +
                        '<input type="text" class="aprovaHidden" name="aprovarContrato" required hidden>' +
                        // '<input type="text" class="statusDocumento" name="statusDocumento" value="" hidden required>' +
                        '<div class="radio-inline padding0">' +
                            '<a rel="tooltip" type="submit" class="btn btn-success" id="btnAprovaDoc' + item.idUploadLink + '" title="Aprovar arquivo."' + 
                                '<span> <i class="fa fa-check"> </i>   ' + '</span>' + 
                            '</a>' +
                        '</div>' +
                        '<div class="radio-inline padding0">' +
                            '<a rel="tooltip" type="submit" class="btn btn-danger" id="btnExcluiDoc' + item.idUploadLink + '" title="Excluir arquivo."' + 
                                '<span> <i class="glyphicon glyphicon-trash"> </i>   ' + '</span>' + 
                            '</a>' +
                        '</div>' +
                    '</form>';
                
                $(botaoAcao).prependTo('#divModal' + item.idUploadLink);
        
                $('#btnExcluiDoc' + item.idUploadLink).click(function(){
                    $(this).parents("tr").hide();
                    $(this).closest("div.divModal").find("input[class='aprovaHidden']").val("NAO");
                    $(this).closest("form").submit();
                    // $(this).closest("div.divModal").find("input[class='statusDocumento']").val("INCONFORME");
                    // alert ("Documento marcado para exclusão, salve a análise para efetivar o comando. Caso não queira mais excluir o documento atualize a página sem gravar.");
                });

                $('#btnAprovaDoc' + item.idUploadLink).click(function(){
                    $(this).parents("tr").hide();
                    $(this).closest("div.divModal").find("input[class='aprovaHidden']").val("SIM");
                    $(this).closest("form").submit();
                    // $(this).closest("div.divModal").find("input[class='statusDocumento']").val("CONFORME");
                    // alert ("Documento marcado para aprovação, salve a análise para efetivar o comando. Caso não queira mais aprovar o documento atualize a página sem gravar.");
                });    

            });
           
            $('#historico').DataTable({
                "pageLength": 5,
                "order": [[ 0, "desc" ]],    
                "language": {
                    "sEmptyTable": "Nenhum registro encontrado",
                    "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                    "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
                    "sInfoFiltered": "(Filtrados de _MAX_ registros)",
                    "sInfoPostFix": "",
                    "sInfoThousands": ".",
                    "sLengthMenu": "Mostrar _MENU_ resultados por página",
                    "sLoadingRecords": "Carregando...",
                    "sProcessing": "Processando...",
                    "sZeroRecords": "Nenhum registro encontrado",
                    "sSearch": "Pesquisar",
                    "oPaginate": {
                        "sNext": "Próximo",
                        "sPrevious": "Anterior",
                        "sFirst": "Primeiro",
                        "sLast": "Último"
                    },
                    "oAria": {
                        "sSortAscending": ": Ordenar colunas de forma ascendente",
                        "sSortDescending": ": Ordenar colunas de forma descendente"
                    }
                }
            });

        }
    });

    // $('#formVerificaAssinatura').submit(function(e){
    //     e.preventDefault();

    //         // var excluirDocumentos = [{'name':'id','value':'9','name':'excluir','value':'SIM'}];
    //         excluirDocumentos = [];
    //         $('.excluiDocumentos').each(function() {


    //             let documento = $(this).serializeArray().reduce(function(obj, item) {
    //                 obj[item.name] = item.value;
    //                 return obj;
    //             }, {});

    //             excluirDocumentos.push(documento);


    //             // return excluirDocumentos;
    //         });

    //         var data = $('#formVerificaAssinatura').serializeArray().reduce(function(obj, item) {
    //             obj[item.name] = item.value;
    //             return obj;
    //         });
    //         var formData = {data, excluirDocumentos};
    //         // var formData = JSON.stringify(dados);
    //         console.log(formData);


        // $.ajax({
        //     type: 'PUT',
        //     url: '/esteiracomex/contratacao/formalizar/' + idDemanda,
        //     dataType: 'JSON',
        //     data: formData,
        //     statusCode: {
        //         200: function(data) {
        //             console.log(data);
        //             window.location.href = "/esteiracomex/acompanhar/minhas-demandas";
        //         }
        //     }
        // });

    // });


}); // fecha document ready