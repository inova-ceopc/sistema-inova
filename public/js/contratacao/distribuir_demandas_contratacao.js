$(document).ready(function() {

    // $.ajaxSetup({
    //     beforeSend: function(xhr, type) {
    //         if (!type.crossDomain) {
    //             xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
    //         }
    //     },
    // });
    $.ajax({
        type: 'GET',
        url: '../../api/esteiracomex/distribuicao',
        // url: '../../js/contratacao/carrega_distribuicao_contratacao.json',
        data: 'value',
        dataType: 'json',
        success: function (dados) {

            console.log(dados); //array completo do json

            // captura os arrays de demandas do json
            $.each(dados.demandasEsteira[0].contratacao, function(key, item) {

                console.log(item);

            // monta a linha com o array de cada demanda
                var linha = 
                    '<tr>' +
                        '<td>' + item.idDemanda + '</td>' +
                        '<td>' + item.nomeCliente + '</td>' +
                        '<td>' + item.cpfCnpj + '</td>' +
                        '<td>' + item.tipoOperacao + '</td>' +
                        '<td>' + item.valorOperacao + '</td>' +
                        '<td>' + item.unidadeDemandante + '</td>' +
                        '<td>' + item.statusAtual + '</td>' +
                        '<td>' +
                                '<input type="hidden" name="protocolo" value="' + item.idDemanda + '">' + 
                                '<input type="hidden" name="tipoDemanda" value="contratacao">' + 
                                '<select name="analista" id="selectDistribuir' + item.idDemanda + '" class="selectDistribuir" inline required>' +
                                    '<option value="">Distribuir</option>' +
                                '</select>' +
                                '<button type="submit" rel="tooltip" class="btn btn-primary inline gravaDistribuicao" title="Gravar distribuição">' + 
                                    '<span> <i class="glyphicon glyphicon-floppy-disk"> </i></span>' + 
                                '</button>' +
                        '</td>' +
                    '</tr>';
                    // '<form action="/distribuir/' + item.idDemanda + '">' +
                    // '{{ csrf_field() }}' +
                    // '<input type="hidden" name="protocolo" value="' + item.idDemanda + '">' + 
                    // '<input type="hidden" name="tipoDemanda" value="contratacao">' + 
                    // '<tr>' +
                    //     '<td>' + item.idDemanda + '</td>' +
                    //     '<td>' + item.nomeCliente + '</td>' +
                    //     '<td>' + item.cpfCnpj + '</td>' +
                    //     '<td>' + item.tipoOperacao + '</td>' +
                    //     '<td>' + item.valorOperacao + '</td>' +
                    //     '<td>' + item.unidadeDemandante + '</td>' +
                    //     '<td>' + item.statusAtual + '</td>' +
                    //     '<td>' +
                    //         '<select name="analista" id="selectDistribuir' + item.idDemanda + '" class="selectDistribuir" inline" required>' +
                    //             '<option value="">Distribuir</option>' +
                    //         '</select>' +
                    //         '&emsp;' +
                    //         '<button rel="tooltip" class="btn btn-primary inline gravaDistribuicao" id="gravaDistribuicao' + item.idDemanda + '" title="Gravar distribuição">' + 
                    //             '<span> <i class="glyphicon glyphicon-floppy-disk"> </i></span>' + 
                    //         '</button>' +
                    //     '</td>' +
                    // '</tr>' +
                    // '</form>';

                // popula a linha na tabela
                $(linha).appendTo('#tabelaContratacoes>tbody');

            });
            // monta as options de distribuição de cada linha dependendo do tipo de modalidade
            $.each(dados.demandasEsteira[0].empregadosDistribuicao, function(key, item) {

                var nome = item.nome;
                var stringNome = nome.split(" ");
                var primeiroNome = stringNome[0] + '-' + item.matricula;
                var options = '<option class="matricula" value="' + item.matricula + '">' + primeiroNome + '</option>'
                
                $(options).appendTo('.selectDistribuir');
            });

            // logica do select e do botao de gravar
            // $.each(dados.demandasEsteira[0].contratacao, function(key, item) {

            //     $('#selectDistribuir' + item.idDemanda).val(item.responsavelCeopc);


                // trigger click
                // $('#gravaDistribuicao' + item.idDemanda).click(function(){
                //     var linhaAtual = $(this).parents('tr:first').text();
                //     var analista = $(this).siblings('select').val();

                //     if (analista == item.responsavelCeopc) {
                //         alert('A demanda ' + item.idDemanda + ' já está distribuída para ' + analista + '.')
                //     }   
                    
                //     else {

                //     var data = {'tipoDemanda':'contratacao','protocolo':linhaAtual[0],'analista':analista};
                //     console.log(data);
                //     $.ajax({
                //         type: 'PUT',
                //         url: '../esteiracomex/distribuicao/' + linhaAtual[0],
                //         data: data,
                //         dataType: 'json',
                //         success: function (grava) {
                //             console.log(grava);
                //             alert('Demanda distribuída.');
                //         }
                
                //     })

                //     }

                // });

            // });

            $('#tabelaContratacoes').DataTable({
                
            });

            // $('.gravaDistribuicao').click(function(){
            //     alert('nice');
            
            // });
            
        
        }
    });


    // api/esteiracomex/distribuicao/{distribuicao}
    
});



// $.get( '../../js/contratacao/carrega_distribuicao_contratacao.json', function(dados) {

//     var dados = JSON.parse(dados);

//     console.log(dados);

//     for(i = 0; i < dados.demandasEsteira.contratacao.length; i++){

//         linha = montaLinhaTabelaSaldo(dados.demandasEsteira.contratacao[i]);
        
//         $('#tabelaContratacoes>tbody').append(linha);
//     }

    //monta as linhas da tabela          
    // function montaLinhaTabelaSaldo(dadosSaldo)
    // {
    //     bDestroy= true;

    //     linha = '<tr>' +
                    
    //                 '<td>' +  + '</td>' +
    //                 '<td>' + dadosSaldo.statusSaldo + '</td>' +
    //                 '<td>' + dadosSaldo.saldoDisponivel + '</td>' +
    //                 '<td>' + dadosSaldo.saldoBloqueado + '</td>' +
    //                 '<td>' + dadosSaldo.LimiteChequeAzul + '</td>' +
    //                 '<td>' + dadosSaldo.LimiteGim + '</td>' +
    //                 '<td>' + dadosSaldo.saldoTotal + '</td>' +
    //             '</tr>';
    //     return linha;

    // }
    

    // transforma a tabela em data table



