//Função global que formata a data para valor humano.
function _formataData() {
    moment.locale('pt-br');
    $('.formata-data').each(function (key, item) {
        var data = $(this).text()
        var dataFormatada = moment(data, 'YYYY-MM-DD, HH:mm:ss').format('L LT');
        $(item).text(dataFormatada);
    });
};