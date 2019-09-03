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

            case "CONFORME":
                progress = 50;
            break;

            case "CONTRATO ENVIADO":
                progress = 62;
            break;
            
            case "ASSINATURA CONFIRMADA":
                progress = 75;
            break;

            case "LIQUIDADA" || "CONTRATO ASSINADO":
                progress = 87;
            break;

            case "ARQUIVADA":
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
        $('#Formalizado').removeClass('border-default');
    }
    if (progress >= 75) {
        $('#AssConfirmada').removeClass('border-default');
    }
    if (progress >= 87) {
        $('#Liquidada').removeClass('border-default').addClass('border-success');
    }
    if (progress == 100) {
        $('#Arquivada').removeClass('border-default');
    }
    
};


