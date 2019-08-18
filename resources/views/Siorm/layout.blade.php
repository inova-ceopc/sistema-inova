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
    <title> @yield('titulo-pagina')</title>
  </head>
  <body>

  
  <nav class="navbar navbar-expand-md navbar-dark bg-dark azul fixed-top">
    <img src="/images/logo-caixa.png" alt="">
    <div class="container">
    
      <a class="navbar-brand" href="{{ url('/siorm/historico-exportador') }}" >SIORM - Emissão de Histórico do Exportador | <small>Equipe de TI - CEOPA</small></a>
     
    </div>
      
    </nav>

    <main role="main" class="container">

        @yield('conteudo')
        
    </main><!-- /.container -->

<footer class="footer mt-auto py-3">
  <div class="container">
    <span class="text-muted">&copy 2019 - Time de TI CEOPA </span>
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
   
   @yield('js')
    <script src="{{ asset('js/global/formata_data.js') }}"></script>   <!-- Função global que formata a data para valor humano br. -->
    <script src="{{ asset('js/global/formata_datatable.js') }}"></script>
    <script src="{{ asset('js/siorm/siorm.js') }}"></script>
    
  </body>
</html>