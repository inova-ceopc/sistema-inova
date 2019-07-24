var tamanhoMaximoView = 8;

$('#labelLimiteArquivos span').html(tamanhoMaximoView);

var tamanhoMaximo = 8388608;

// Carrega função de animação de spinner do arquivo anima_loading_submit.js
$('#formUploadComplemento').submit(function(){
    _animaLoadingSubmit();
});

//  FUNÇÃO DE ANIMAÇÃO DO BOTÃO UPLOAD do arquivo anima_input_file.js
_animaInputFile();


// FUNÇÃO QUE PROIBE DAR UPLOAD EM ARQUIVOS QUE NÃO SEJAM OS PERMITIDOS do arquivo anima_input_file.js
_tiposArquivosPermitidos();

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


$(document).ready(function() {

    var unidade = $('#unidade').val();

    var idDemanda = $("#idDemanda").val();

    $.ajax({
        type: 'GET',
        url: '/esteiracomex/contratacao/complemento/dados/' + idDemanda,
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

            // function formatMoney () {
            //     numeral.locale('pt-br');
            //     var money = numeral(dados[0].valorOperacao).format('0,0.00');
            //     return money;
            // };

            $('#nomeCliente').html(dados[0].nomeCliente);
            $('#tipoOperacao').html(dados[0].tipoOperacao);
            $('#tipoMoeda').html(dados[0].tipoMoeda);
            $('#valorOperacao').html(dados[0].valorOperacao);
            $('#dataPrevistaEmbarque').html(formatDate);
            $('#agResponsavel').html(dados[0].agResponsavel);
            $('#srResponsavel').html(dados[0].srResponsavel);            
            $('#dataLiquidacao').html(formatDate2);
            $('#numeroBoleto').html(dados[0].numeroBoleto);
            $('#equivalenciaDolar').val(dados[0].equivalenciaDolar);
            $('#statusGeral').html(dados[0].statusAtual);
            
            //EACH para montar cada linha de histórico que vem no json

            $.each(dados[0].esteira_contratacao_historico, function(key, item) {

                if (item.analiseHistorico === null) {
                    var linha = 
                    '<tr>' +
                        '<td class="col-sm-1">' + item.idHistorico + '</td>' +
                        '<td class="col-sm-1">' + item.dataStatus + '</td>' +
                        '<td class="col-sm-1">' + item.tipoStatus + '</td>' +
                        '<td class="col-sm-1 responsavel">' + item.responsavelStatus + '</td>' +
                        '<td class="col-sm-1">' + item.area + '</td>' +
                        '<td class="col-sm-7"></td>' +
                    '</tr>';
                }
                else {               
                    var linha = 
                        '<tr>' +
                            '<td class="col-sm-1">' + item.idHistorico + '</td>' +
                            '<td class="col-sm-1">' + item.dataStatus + '</td>' +
                            '<td class="col-sm-1">' + item.tipoStatus + '</td>' +
                            '<td class="col-sm-1 responsavel">' + item.responsavelStatus + '</td>' +
                            '<td class="col-sm-1">' + item.area + '</td>' +
                            '<td class="col-sm-7 Nenhum">' + item.analiseHistorico + '</td>' +
                        '</tr>';
                }

                $(linha).appendTo('#historico>tbody');
                
                if (unidade != 5459) {
                    $('.responsavel').remove();
                }; 
    
            });

            // IF que faz aparecer e popula os capos de Conta de Beneficiário no exterior e IBAN etc

            var tipoOperação = $("#tipoOperacao").html();

            if ((tipoOperação == 'Pronto Importação Antecipado') || (tipoOperação == 'Pronto Importação')){
                $('#divHideDadosBancarios').show();
                $('#divHideDadosIntermediario').show();
                $.each(dados[0].esteira_contratacao_conta_importador, function(key, item) {
                    $('#' + key).val(item);
                });
            };


            $.each(dados[0].esteira_contratacao_confere_conformidade, function(key, item) {
                $('#div' + item.tipoDocumento).show();
                $('#' + item.tipoDocumento).val(item.statusDocumento);
            });


            // IF que fazem aparecer os campos de input file de acordo com o status

            if ($("select[name=statusInvoice]").val() == 'INCONFORME') {
                $('#divInvoiceUpload').show();
            };
        
            if ($("select[name=statusConhecimento]").val() == 'INCONFORME') {
                $('#divConhecimentoUpload').show();
            };
        
            if ($("select[name=statusDi]").val() == 'INCONFORME') {
                $('#divDiUpload').show();
            };
        
            if ($("select[name=statusDue").val() == 'INCONFORME') {
                $('#divDueUpload').show();
            };
        
            if ($("select[name=statusDadosBancarios").val() == 'INCONFORME') {
                $('.iban').prop('disabled', false);
            };
                   
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

}); // fecha document ready
