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

    <script src="{{ asset('js/siorm/sheetJS/xlsx.full.min.js') }}"></script>
    <script src="{{ asset('js/siorm/sheetJS/FileSaver.min.js') }}"></script>
    <title> SIORM/CEOPA - Histórico do Exportador </title>
  </head>
  <body>

  
  <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
      <a class="navbar-brand" href="mailto:ceopa01@mail.caixa?cc=c095060@mail.caixa;c079436@mail.caixa;c111710@mail.caixa;c142765@mail.caixa&amp;subject=Sobre%20o%20Projeto%20Relatório%20SIORM&amp;body=Deixe%20seu%20recado!">SIORM - Emissão de Histórico do Exportador | <small>Equipe de TI - CEOPA</small></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      
      
    </nav>

    <main role="main" class="container">

   
        
        <form method="POST">
            <div class="form-group">
                      
                <label for="xml"><i class="fa fa-paste 2x"></i> Cole aqui o código XML</label>
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
            
            @isset($historicoExportador)
                <a class=" btn btn-success text-white" id="emite-planilha">
                      <i class="fa fa-lg fa-file-excel-o"></i> 
                      Baixe aqui o arquivo em Excel 
                </a>
            @endisset
            
        </form>
  
        

      @isset($historicoExportador)

        <div class="card mt-3 border border-info" >
            <div class="card-header ">
              Processamento Realizado com sucesso!
              <p>Copie e cole o resultado abaixo numa planilha ou gere o arquivo diretamente no botão verde acima ;) </p>
            </div>
            <div class="card-body">

            <div class="row" id="historico-exportador" >
              <table class="table table-striped table-bordered" id="tabelaResultado">
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
            </div>
        </div>

      @endisset

              

    </main><!-- /.container -->

    <footer class="footer mt-auto py-3">
  <div class="container">
    <span class="text-muted">&copy 2019 - Melhorias Time de TI CEOPA </span>
  </div>
</footer>

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
    
  </body>
</html>