<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <!-- Meta tags Obrigatórias -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/vendor/font-awesome/css/font-awesome.min.css') }}">
    <link href="{{ asset('css/siorm/estilos.css') }}" rel="stylesheet">
    
    <title>SIORM - Histórico do Exportador </title>
  </head>
  <body>

  
  <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
      <a class="navbar-brand" href="#">SIORM - Emissão de Histórico do Exportador</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      
    </nav>

    <main role="main" class="container">

        
        <form method="POST">
            <div class="form-group">
                      
                <label for="xml">Cole aqui o código XML</label>
                <textarea 
                  class="form-control" 
                  id="xml" 
                  rows="20" 
                  name="xml"
                  autofocus
                  oninvalid="this.setCustomValidity('Por favor só clique em enviar após colar o xml')"
                  oninput="setCustomValidity('')"
                  required></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Gerar o Relatório</button>
            <a class="btn btn-warning" href="{{ url()->current() }}">Limpar Resultado </a>
            
        </form>
  
        
                 @isset($historicoExportador)

                 <div class="row">
                    <div class="alert alert-success col-md-12 mt-3" role="alert">
                        
                      <h3>Processamento realizado com sucesso</h3>  
                        <a class=" btn btn-success text-white"
                            onclick="fnExcelReport()"> 
                            <i class="fa fa-lg fa-file-excel-o"></i> 
                            Gerar Arquivo Excel
                        </a>
                    </div>
                  </div>


                 
                
                 <div class="row" id="historico-exportador">
                  
                    <table class="table table-striped" id="tabelaResultado">
                      <thead>
                        <tr>
                          <th scope="col">Ano/Mês Competência</th>
                          <th scope="col">Valor Total Contratado</th>
                          <th scope="col">Valor Total Liquidado</th>
                          <th scope="col">Valor Total Cancelado</th>
                          <th scope="col">Valor Total Baixado</th>
                          <th scope="col">Valor Total ACC</th>
                        </tr>
                      </thead>
                      <tbody>
          

                      @foreach($historicoExportador as $historico)
                      <tr>
                          <td>{{$historico['mesCompetencia']}}</td>
                          <td class="formato-moeda">{{$historico['VlrTotContrd']}}</td>
                          <td class="formato-moeda">{{$historico['VlrTotLiqdado']}}</td>
                          <td class="formato-moeda">{{$historico['VlrTotCancel']}}</td>
                          <td class="formato-moeda">{{$historico['VlrTotBaixd']}}</td>
                          <td class="formato-moeda">{{$historico['VlrTotACC']}}</td>
                      </tr>  
                    @endforeach 

                    </tbody>
                  </table>
                </div>
                
              
                @endisset

            
         



    </main><!-- /.container -->

    <!-- JavaScript (Opcional) -->
    <!-- jQuery primeiro, depois Popper.js, depois Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="{{ asset('js/plugins/numeral/numeral.min.js') }}"></script>
    <script src="{{ asset('js/plugins/numeral/locales/pt-br.min.js') }}"></script>
    <script src="{{ asset('js/plugins/moment/moment-with-locales.min.js') }}"></script>
    <script src="{{ asset('js/global/formata_data.js') }}"></script>   <!-- Função global que formata a data para valor humano br. -->
    <script src="{{ asset('js/global/formata_datatable.js') }}"></script>
    <script src="{{ asset('js/siorm/siorm.js') }}"></script>

<script>

function fnExcelReport()
{
    var tab_text="<table border='2px'><tr bgcolor='#fff'>";
    var textRange; var j=0;
    tab = document.getElementById('tabelaResultado'); // id of table

    for(j = 0 ; j < tab.rows.length ; j++) 
    {     
        tab_text=tab_text+tab.rows[j].innerHTML+"</tr>";
        //tab_text=tab_text+"</tr>";
    }

    tab_text=tab_text+"</table>";
    tab_text= tab_text.replace(/<A[^>]*>|<\/A>/g, "");//remove if u want links in your table
    tab_text= tab_text.replace(/<img[^>]*>/gi,""); // remove if u want images in your table
    tab_text= tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); // reomves input params

    var ua = window.navigator.userAgent;
    var msie = ua.indexOf("MSIE "); 

    if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))      // If Internet Explorer
    {
        txtArea1.document.open("txt/html","replace");
        txtArea1.document.write(tab_text);
        txtArea1.document.close();
        txtArea1.focus(); 
        sa=txtArea1.document.execCommand("SaveAs",true,"relatorio_siorm.xls");
    }  
    else                 //other browser not tested on IE 11
        sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));  

    return (sa);
}

</script>

  </body>
</html>