$(document).ready(function() { 

    $('.sidebar-toggle').click();

    $.ajax({
        type: 'GET',
        url: '../contratacao/formalizar',
        // url: '../contratacao/formalizar',
        data: 'value',
        dataType: 'json',
        success: function (dados) {

            // captura os arrays de demandas do json
            $.each(dados.demandasFormalizadas, function(key, item) {

                // TABELA CONTRATOS CONFORMES E FORMALIZADOS
                // if (item.statusAtual == 'CONFORME' || item.statusAtual == 'CONTRATO ENVIADO'){

                    // monta a linha com o array de cada demanda
                    var linha = 
                        '<tr>' +
                            '<td>' + item.idDemanda + '</td>' +
                            '<td>' + item.nomeCliente + '</td>' +
                            '<td>' + item.cpfCnpj + '</td>' +  //////////////////////////////////ARRUMAR
                            '<td>' + item.tipoOperacao + '</td>' +
                            '<td class="mascaradinheiro">' + item.valorOperacao + '</td>' +
                            '<td>' + item.unidadeDemandante + '</td>' +
                            '<td>' + item.statusAtual + '</td>' +
                            '<td class="padding5">' +
                                '<a href="../contratacao/formalizar/' + item.idDemanda + '" rel="tooltip" class="btn btn-success margin05 inline formalizar" id="btnFormalizar' + item.idDemanda + '" title="Formalizar demanda">' + 
                                '<span> <i class="glyphicon glyphicon-open-file"> </i></span>' + 
                                '</a>' +
                                // '<a href="../contratacao/verificar-contrato-assinado/' + item.idDemanda + '" rel="tooltip" class="btn btn-info margin05 inline verificar" id="btnVerificar' + item.idDemanda + '" title="Verificar assinatura do contrato">' + 
                                // '<span> <i class="fa fa-pencil"> </i></span>' + 
                                // '</a>' +
                            '</td>' +
                        '</tr>';

                    // popula a linha na tabela
                    $(linha).appendTo('#tabelaContratacoesFormalizadas>tbody');

                // };

                // TABELA CONTROLE DE RETORNOS
                if (item.statusAtual == 'CONTRATO ENVIADO'){

                    // monta a linha com o array de cada demanda
                    var linha = 
                        '<tr href="/esteiracomex/contratacao/consultar/' + item.idDemanda + '">' +
                            '<td>' + item.idDemanda + '</td>' +
                            '<td>' + item.nomeCliente + '</td>' +
                            '<td>' + item.cpfCnpj + '</td>' +  //////////////////////////////////ARRUMAR
                            '<td>' + item.tipoOperacao + '</td>' +
                            '<td class="mascaradinheiro">' + item.valorOperacao + '</td>' +
                            '<td>' + item.unidadeDemandante + '</td>' +
                            '<td>' + item.statusAtual + '</td>' +
                        '</tr>';

                    // popula a linha na tabela
                    $(linha).appendTo('#tabelaControleRetornos>tbody');

                };

                // TABELA VERIFICAÇÃO DE ASSINATURA
                if (item.statusAtual == 'ASSINATURA CONFIRMADA' || item.statusAtual == 'CONTRATO ASSINADO'){

                    // monta a linha com o array de cada demanda
                    var linha = 
                        '<tr>' +
                            '<td>' + item.idDemanda + '</td>' +
                            '<td>' + item.nomeCliente + '</td>' +
                            '<td>' + item.cpfCnpj + '</td>' +  //////////////////////////////////ARRUMAR
                            '<td>' + item.tipoOperacao + '</td>' +
                            '<td class="mascaradinheiro">' + item.valorOperacao + '</td>' +
                            '<td>' + item.unidadeDemandante + '</td>' +
                            '<td>' + item.statusAtual + '</td>' +
                            '<td class="padding5">' +
                                // '<a href="../contratacao/formalizar/' + item.idDemanda + '" rel="tooltip" class="btn btn-success margin05 inline formalizar" id="btnFormalizar' + item.idDemanda + '" title="Formalizar demanda">' + 
                                // '<span> <i class="glyphicon glyphicon-open-file"> </i></span>' + 
                                // '</a>' +
                                '<a href="../contratacao/verificar-contrato-assinado/' + item.idDemanda + '" rel="tooltip" class="btn btn-info margin05 inline verificar" id="btnVerificar' + item.idDemanda + '" title="Verificar assinatura do contrato">' + 
                                '<span> <i class="fa fa-pencil"> </i></span>' + 
                                '</a>' +
                            '</td>' +
                        '</tr>';

                    // popula a linha na tabela
                    $(linha).appendTo('#tabelaVerificacaoAssinatura>tbody');

                };
            });

            //Função global que formata dinheiro para valor humano do arquivo formata_data.js.
            _formataValores();

            //Função global que formata DataTable para portugues do arquivo formata_datatable.js.
            _formataDatatable();
        }
    });

    $('#tabelaControleRetornos tbody').on('click', 'tr', function () {
        var href = $(this).attr("href");            
        if (href == undefined) {
            document.location.href = '/esteiracomex/acompanhar/contratacao';
        } else {
            document.location.href = href;
        };
    });  

});