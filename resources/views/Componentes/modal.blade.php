<!-- Modal para visualizar informações -->

<div class="modal fade" id="modalVisualizar">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><strong>@yield('cabecalhoModalVisualizar')</strong></h4>
      </div>
    <div class="modal-body">    
        @yield('conteudoModalVisualizar')
    </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>


<!-- modal para editar informações -->

<div class="modal fade" id="modalEditar">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><strong>@yield('cabecalhoModalEditar')</strong></h4>
      </div>
    <div class="modal-body">
        @yield('conteudoModalEditar')
    </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary">Salvar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>


<!-- modal para consulta de historico -->

<div class="modal fade" id="modalHistórico">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><strong>@yield('cabecalhoModalHistorico')</strong></h4>
      </div>
    <div class="modal-body">
        @yield('conteudoModalHistorico')
    </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div><!-- /.modal -->
