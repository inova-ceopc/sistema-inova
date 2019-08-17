console.log("Está funcionando normal");


// Função mais atualizada para gerar excel usa lib SheetJS

var wb = XLSX.utils.table_to_book(document.getElementById('tabelaResultado'), {sheet:"Histórico Exportador"});
    var wbout = XLSX.write(wb, {bookType:'xlsx', bookSST:true, type: 'binary'});
    function s2ab(s) {
                    var buf = new ArrayBuffer(s.length);
                    var view = new Uint8Array(buf);
                    for (var i=0; i<s.length; i++) view[i] = s.charCodeAt(i) & 0xFF;
                    return buf;
    }
    $("#emite-planilha").click(function(){
    saveAs(new Blob([s2ab(wbout)],{type:"application/octet-stream"}), 'historico_exportador.xlsx');
    });

