//Função global que anima a barra de progresso do arquivo formata_data.js

function _progressBar (){

    $('.progress .progress-bar').css("width", function() {

        let progress = '';

        switch($('#statusGeral').html()) {

            case "CADASTRADA": 
                progress = '13.5';
            break;

            case "DISTRIBUIDA":
                progress = '26';
            break;

            case "EM ANALISE":
                progress = '26';
            break;

            case "INCONFORME":
                progress = '38';
            break;

            case "CONFORME":
                progress = '50';
            break;

            case "CONTRATO ENVIADO":
                progress = '62';
            break;
            
            case "ASSINATURA CONFIRMADA":
                progress = '75';
            break;

            case "LIQUIDADO":
                progress = '87';
            break;

            case "CONTRATO ASSINADO":
            progress = '87';
            break;
            
            case "FINALIZADO":
                progress = '100';
        }
        return progress + "%";
    });
};
