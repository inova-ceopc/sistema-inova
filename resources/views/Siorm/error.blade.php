@extends('Siorm.layout')

    @section('titulo-pagina', 'SIORM - verificar entrada!')

        @section('conteudo')

        <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{ url('/siorm/historico-exportador') }}" >SIORM</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Mensagem de Erro</li>
                </ol>
              </nav>

        <div class="card border-danger">
                <div class="card-header text-white bg-danger">
                  <h5> Houve um erro!</h5>
                </div>
                <div class="card-body">
                  <h5 class="card-title">Atençāo</h5>
                    <p class="card-text">
                      Pelos testes realizados neste método 
                      (até o momento) possivelmente os valores de entrada nāo correspondem 
                      ao padrāo do arquivo XML.
                    </p>
                    <p class="card-text font-weight-bold">
                        Por favor mande apenas o conteúdo da tag XML da página do SIORM.
                    </p>
                    <p>
                        Tente novamente. Caso a ferramenta esteja se comportando de 
                        maneira estranha, contate <a href="mailto:ceopa01@mail.caixa?cc=c095060@mail.caixa;c079436@mail.caixa;c111710@mail.caixa;c142765@mail.caixa&amp;subject=Problemas%20o%20Projeto%20Relatório%20SIORM&amp;body=Deixe%20seu%20recado!"> equipe de TI</a>.
                    </p>

                    
                   

                  <a href="{{ url('/siorm/historico-exportador') }}" class="btn btn-primary">Voltar </a>
                </div>
              </div>

        @endsection

    
    @section('js')

    @endsection
