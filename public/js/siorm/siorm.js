console.log("Está funcionando normal");


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



function arrumaMoeda() {
        
        let i;
        x = document.getElementsByClassName('formato-moeda');
       
        for (i = 0; i < x.length; i++) {
            x[i].innerHTML.toFixed(2);
        }
      }



// nao rolou vou manter com request msm;
document.getElementById("btn-limpar").addEventListener("click", function(){
  var campo = document.getElementById('xml');
      campo.value = '';
      // campo.autofocus;
    }
  );
