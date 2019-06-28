$(document).ready(function() {

    $.ajax({
        type: 'GET',
        url: '../../js/contratacao/carrega_distribuicao_contratacao.json',
        data: 'value',
        dataType: 'json',
        success: function (dados) {

            console.log(dados);

            $.each(dados.demandasEsteira[0].contratacao, function(key, item) {

                console.log(item);
                var linha = 
                    '<tr>' +
                        '<td>' + item.idDemanda + '</td>' +
                        '<td>' + item.nomeCliente + '</td>' +
                        '<td>' + item.cpfCnpj + '</td>' +
                        '<td>' + item.tipoOperacao + '</td>' +
                        '<td>' + item.valorOperacao + '</td>' +
                        '<td>' + item.unidadeDemandante + '</td>' +
                        '<td>' + item.statusAtual + '</td>' +
                    '</tr>';

                $(linha).appendTo('#tabelaContratacoes>tbody');

            });
       
            $.each(dados.demandasEsteira[0].empregadosDistribuicao, function(key, item) {

                console.log(item);
                var linha =
                '<tr>' +
                '<td><select><option value="volvo">Volvo</option><option value="saab">Saab</option><option value="mercedes">Mercedes</option><option value="audi">Audi</option></select>' +
                '</tr>';
                $(linha).appendTo('#tabelaContratacoes>tbody');

            });

        }
    });

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



    




//    $('#tabelaContratacoes').DataTable( {
//         ajax: {
//             url: '../../js/contratacao/carrega_distribuicao_contratacao.json',
//             dataSrc: 'demandasEsteira.0.contratacao'
            
//         },
//         columns: [
            
//             { data: 'idDemanda' },
//             { data: 'nomeCliente' },
//             { data: 'cpfCnpj' },
//             { data: 'tipoOperacao' },
//             { data: 'valorOperacao' },
//             { data: 'unidadeDemandante' },
//             { data: 'statusAtual' },
//             { data: null},
//         ],
//         columnDefs: [ {
//             targets: -1,
//             data: null,
//             defaultContent: '<select><option value="volvo">Volvo</option><option value="saab">Saab</option><option value="mercedes">Mercedes</option><option value="audi">Audi</option></select>',
//         } ]            


//     });








    $('#formUploadComplemento').submit(function(e){
        e.preventDefault();
        var formData = $('#formUploadComplemento').serializeArray();
        console.log(formData);
        $.ajax({
            method: 'POST',
            url: '{{ url('/') }}/complemento',
            dataType: 'json',
            data: formData, // Important! The formData should be sent this way and not as a dict.
            // beforeSend: function(xhr){xhr.setRequestHeader('X-CSRFToken', "{{csrf_token}}");},
            success: function(data, textStatus) {
                console.log(data);
                console.log(formData);
                console.log(textStatus);
                alert ("Complemento gravado com sucesso.");
                redirect = window.location.replace("/distribuir/demandas");
            },
            error: function (textStatus, errorThrown) {
                console.log(errorThrown);
                console.log(textStatus);
                console.log(errorThrown);
                alert ("Complemento não gravado.");
            }
        });
    })