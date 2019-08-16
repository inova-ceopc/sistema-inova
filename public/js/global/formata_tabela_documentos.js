//Função global que monta a tabela de arquivos do arquivo formata_tabela_documentos.js

function _formataTabelaDocumentos (dados) {

    var urlDiretorioVirtual = 'https://inova.ceopc.des.caixa/uploads/';

    $.each(dados[0].esteira_contratacao_upload, function(key, item) {
        var linha = 

            '<tr>' +
                '<td>' +
                    '<div id="divModal' + item.idUploadLink + '" class="divModal">' +           
                        '<div class="radio-inline padding0">' +
                            '<a rel="tooltip" class="btn btn-primary" title="Visualizar arquivo." data-toggle="modal" data-target="#modal' + item.idUploadLink + '">' + 
                                '<span class="fa fa-search-plus"></span>' + 
                            '</a>' +
                            '<div class="modal fade" id="modal' + item.idUploadLink + '" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">' + 
                                '<div class="modal-dialog modal-lg">' + 
                                    '<div class="modal-content" height="600px">' + 
                                        '<div class="modal-header">' +
                                            '<h3 class="modal-title">' + item.nomeDoDocumento +
                                            '<button type="button" class="btn btn-danger pull-right margin10" data-dismiss="modal">Fechar painel</button>' +
                                            '<a class="btn btn-primary pull-right margin10" href="' + urlDiretorioVirtual + item.caminhoDoDocumento + '" download="' + item.tipoDoDocumento + '">Baixar arquivo</a>' +
                                            '</h3>' +
                                        '</div>' +
                                        '<div class="modal-body">' +
                                            '<a href="#!" class="modal-close waves-effect waves-green btn-flat" id="btn_fecha_modal"> </a>' +
                                            '<embed src="' + urlDiretorioVirtual + item.caminhoDoDocumento + '" width="100%" height="650px" />' +
                                        '</div>' +
                                    '</div>' +
                                '</div>' +
                            '</div>' +
                        '</div>' +
                    '</div>' +
                '</td>' +
                '<td>' + item.idUploadLink + '</td>' +
                '<td>' + item.nomeDoDocumento + '</td>' +
                '<td>' + item.tipoDoDocumento + '</td>' +
                '<td class="formata-data">' + item.dataInclusao + '</td>' +
            '</tr>';
        
        $(linha).appendTo('#documentacao>tbody');

    });
};

//Função global que monta a tabela de contratos assinados do arquivo formata_tabela_documentos.js

function _formataTabelaContratosAssinados (dados) {

    $.each(dados.listaContratosDemanda, function(key, item) {

        if (item.temRetornoRede == 'SIM') {
            if (item.dataConfirmacaoAssinatura != null) {
                var linha = 
                    '<tr>' +
                        // '<td>' +
                        //     '<div id="divContrato' + item.idContrato + '" class="divContrato">' +
                        //     '</div>' +
                        // '</td>' +

                        '<td>' +
                            '<div id="divModal' + item.idUploadContrato + '" class="divModal">' +           
                                '<div class="radio-inline padding0">' +
                                    '<a rel="tooltip" class="btn btn-primary" title="Upload de Arquivo." data-toggle="modal" data-target="#modal' + item.idUploadContrato + '">' + 
                                        '<span class="fa fa-cloud-upload"></span>' + 
                                    '</a>' +
                                    '<div class="modal fade" id="modal' + item.idUploadContrato + '" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">' + 
                                        '<div class="modal-dialog modal-lg">' + 
                                            '<div class="modal-content" height="300px">' + 
                                                '<div class="modal-header">' +
                                                    '<h3 class="modal-title"> CONTRATO DE ' + item.tipoContrato + ' Nº ' + item.numeroContrato +
                                                    '<button type="button" class="btn btn-danger pull-right margin10" data-dismiss="modal">Fechar painel</button>' +
                                                    '</h3>' +
                                                '</div>' +
                                                '<div class="modal-body">' +
                                                    '<div class="input-group col-sm uploadContratoAssinado">' +
                                                        '<label class="input-group-btn">' +
                                                            '<span class="btn btn-primary front">' +
                                                            '<i class="fa fa-lg fa-cloud-upload"></i>' +
                                                            'Carregar arquivo&hellip;' +
                                                            '</span>' +
                                                            '<input type="file" class="behind" accept=".pdf" name="uploadContratoAssinado' + dados.idUploadContrato + '" id="uploadContratoAssinado' + dados.idUploadContrato + '" required>' +
                                                        '</label>' +
                                                        '<input type="text" class="form-control previewNomeArquivo" readonly>' +
                                                    '</div>' +
                                                '</div>' +
                                            '</div>' +
                                        '</div>' +
                                    '</div>' +
                                '</div>' +
                            '</div>' +
                        '</td>' +
                        '<td>' + item.numeroContrato + '</td>' +
                        '<td>' + item.tipoContrato + '</td>' +
                        '<td class="formata-data">' + item.dataLimiteRetorno + '</td>' +
                        '<td class="formata-data">' + item.dataConfirmacaoAssinatura + '</td>' +
                    '</tr>';
                
                $(linha).appendTo('#contratos>tbody');
            };
        };
    });
};

//Função global que monta a tabela de contratos do arquivo formata_tabela_documentos.js

function _formataTabelaContratos (dados) {

    $.each(dados.listaContratosDemanda, function(key, item) {

        if (item.temRetornoRede == 'SIM') {
            if (item.dataConfirmacaoAssinatura == null) {
                var linha = 
                    '<tr>' +
                        '<td>' +
                            '<div id="divContrato' + item.idContrato + '" class="divContrato">' +
                            '</div>' +
                        '</td>' +
                        '<td>' + item.numeroContrato + '</td>' +
                        '<td>' + item.tipoContrato + '</td>' +
                        '<td class="formata-data">' + item.dataLimiteRetorno + '</td>' +
                        '<td class="formata-data">' + item.dataConfirmacaoAssinatura + '</td>' +
                    '</tr>';
                
                $(linha).appendTo('#contratos>tbody');
            };
        };
    });
};