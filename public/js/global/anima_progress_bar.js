//Função global que anima a barra de progresso do arquivo formata_data.js

function _progressBar (){

    var progress = '';

    $('.progress .progress-bar').css("width", function() {

        switch($('#statusGeral').html()) {

            case "CADASTRADA": 
                progress = 13.5;
            break;

            case "DISTRIBUIDA" || "EM ANALISE":
                progress = 26;
            break;

            case "INCONFORME":
                progress = 38;
            break;

            case "CONFORME" || "NAO LIQUIDADA":
                progress = 50;
            break;

            case "CONTRATO EMITIDO":
                progress = 62;
            break;
            
            case "CONTRATO PENDENTE":
                progress = 75;
            break;

            case "CONTRATO ASSINADO || ASSINATURA CONFORME":
                progress = 87;
            break;

            case "LIQUIDADA":
                progress = 100
        }
        return progress + "%";
    });
            
    if (progress >= 26) {
        $('#emAnalise').removeClass('border-default');
    }
    if (progress >= 38) {
        $('#Inconforme').removeClass('border-default').addClass('border-danger');
    }
    if (progress >= 50) {
        $('#Conforme').removeClass('border-default');
    }
    if (progress >= 62) {
        $('#Cont.Emitido').removeClass('border-default');
    }
    if (progress >= 75) {
        $('#Cont.Pendente').removeClass('border-default');
    }
    if (progress >= 87) {
        $('#Cont.Assinado').removeClass('border-default');
    }
    if (progress == 100) {
        $('#Liquidada').removeClass('border-default').addClass('border-success');
    }
    
};


