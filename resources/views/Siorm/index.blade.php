@extends('Siorm.layout')

@section('titulo-pagina', 'SIORM - Emissão de Historico Exportador')

@section('conteudo')

      
  <form method="POST">
    <div class="form-group">
      <label for="xml">
        <i class="fa fa-paste 2x"></i> Cole aqui o código XML
      </label>
      
      <textarea 
        class="form-control" 
        id="xml" 
        rows="15" 
        name="xml"
        autofocus
        oninvalid="this.setCustomValidity('Por favor só clique em enviar após colar o xml')"
        oninput="setCustomValidity('')"
        required>
      </textarea>

    </div>
    
      <button 
        type="submit" 
        class="btn btn-primary"
        id="gera-relatorio"> Gerar o Relatório
      </button>
      
      <a 
        class="btn btn-warning" 
        onclick="document.getElementById('xml').value = ''"
        href="{{ url()->current() }}"> 
        
        <i class="fa fa-trash" aria-hidden="true"></i> 
        Limpar Resultado 
      </a>
                
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
            &#128521; Processamento Realizado com sucesso!
            <p>
              Copie e cole o resultado abaixo numa planilha 
              (mais interessante se o relatório usar vários XML's) 
              ou então gere o arquivo excel diretamente no botão verde acima. 
            </p>
          </div>

          <div class="card-body">
            <div class="row" id="historico-exportador" onload="arrumaMoeda()">
              <div class="col-md-12 container-fluid">
                  <table 
                    class="table table-striped table-bordered table-responsive" 
                    id="tabelaResultado">
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
                        <tr class="formato-moeda">
                          <td>{{'##-'.$historico['mesCompetencia'] .'-##'}}</td>
                          <td class="formato-moeda-item">{{number_format($historico['VlrTotContrd'],2,".","")}}</td>
                          <td class="formato-moeda-item">{{number_format($historico['VlrTotLiqdado'],2,".","")}}</td>
                          <td class="formato-moeda-item">{{number_format($historico['VlrTotCancel'],2,".","")}}</td>
                          <td class="formato-moeda-item">{{number_format($historico['VlrTotBaixd'],2,".","")}}</td>
                          <td class="formato-moeda-item">{{number_format($historico['VlrTotACC'],2,".","")}}</td>
                        </tr>  
                      @endforeach 
                    </tbody>
                  </table>
              </div>
            </div>
          </div> 
        </div>
    
    @endisset
    
@endsection

@section('js')

@endsection