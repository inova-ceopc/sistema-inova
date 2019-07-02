<?php

namespace App\Http\Controllers\Comex;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Comex\Contratacao\ContratacaoDemanda;
use App\Models\Comex\Contratacao\ContratacaoHistorico;

class DistribuicaoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // dd($request->session()->all());
        
        $arrayDemandasContratacao = [];
        $arrayDemandasEsteiraComEmpregadosDistribuicao = ['demandas'];
        
        // LISTA DE DEMANDAS CONTRATACAO
        $demandasContratacao = ContratacaoDemanda::select('idDemanda', 'nomeCliente', 'cpf', 'cnpj', 'tipoOperacao', 'valorOperacao', 'agResponsavel', 'srResponsavel', 'statusAtual', 'responsavelCeopc')->whereIn('statusAtual', ['CADASTRADA', 'DISTRIBUIDA', 'EM ANALISE'])->get();
        for ($i = 0; $i < sizeof($demandasContratacao); $i++) {   
            if ($demandasContratacao[$i]->cpf === null) {
                $cpfCnpj = $demandasContratacao[$i]->cnpj;
            } else {
                $cpfCnpj = $demandasContratacao[$i]->cpf;
            }
            if ($demandasContratacao[$i]->agResponsavel === null) {
                $unidadeDemandante = $demandasContratacao[$i]->srResponsavel;
            } else {
                $unidadeDemandante = $demandasContratacao[$i]->agResponsavel;
            }
            
            $demandas = array(
                'idDemanda' => $demandasContratacao[$i]->idDemanda, 
                'nomeCliente' => $demandasContratacao[$i]->nomeCliente, 
                'cpfCnpj' => $cpfCnpj, 
                'tipoOperacao' => $demandasContratacao[$i]->tipoOperacao, 
                'valorOperacao' => $demandasContratacao[$i]->valorOperacao, 
                'unidadeDemandante' => $unidadeDemandante,  
                'responsavelCeopc' => $demandasContratacao[$i]->responsavelCeopc, 
                'statusAtual' => $demandasContratacao[$i]->statusAtual
            );
            array_push($arrayDemandasContratacao, $demandas);
        }
        
        // LISTA DE EMPREGADOS NO BACK OFFICE
        $arrayEmpregados = array(
            ['matricula' => 'c058725', 'nome' => 'THAIS COSTA JOMAH'],
            ['matricula' => 'c080709', 'nome' => 'JOSIAS DO NASCIMENTO FLORIANO'],
            ['matricula' => 'c133633', 'nome' => 'MARIO ALBERTO LABRONICI BAIARDI'],
            ['matricula' => 'c052972', 'nome' => 'MARIA BEATRIZ GARCIA RUSSO'],
        );
        $arrayTeste = array(
            'contratacao' => $arrayDemandasContratacao, 
            'empregadosDistribuicao' => $arrayEmpregados
        );
        $arrayDemandasEsteiraComEmpregadosDistribuicao = array(
            'demandasEsteira' => array($arrayTeste));
        // dd($arrayDemandasEsteiraComEmpregadosDistribuicao);
        return json_encode($arrayDemandasEsteiraComEmpregadosDistribuicao, JSON_UNESCAPED_SLASHES);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if ($request->session()->get('codigoLotacaoFisica') == null || $request->session()->get('codigoLotacaoFisica') === "NULL") {
            $lotacao = $request->session()->get('codigoLotacaoAdministrativa');
        } else {
            $lotacao = $request->session()->get('codigoLotacaoFisica');
        }
        // dd($request->all());
        switch ($request->tipoDemanda) {
            case 'contratacao':
                // Atualiza a tabela TBL_EST_CONTRATACAO_DEMANDAS
                $demandaContratacao = ContratacaoDemanda::find($id);
                // dd($demandaContratacao);
                $demandaContratacao->statusAtual = 'DISTRIBUIDA';
                $demandaContratacao->responsavelCeopc = $request->analista;
                $demandaContratacao->save();

                // Recupera os dados da demanda atualizada
                $dadosDemandaAtualizada = ContratacaoDemanda::find($id);
                // dd($dadosDemandaAtualizada);
                // Registra o historico da distribuicao
                $historicoContratacao = new ContratacaoHistorico;
                $historicoContratacao->idDemanda = $dadosDemandaAtualizada->idDemanda;
                $historicoContratacao->tipoStatus = "DISTRIBUICAO";
                $historicoContratacao->dataStatus = date("Y-m-d H:i:s", time());
                $historicoContratacao->responsavelStatus = $request->session()->get('matricula');
                $historicoContratacao->area = $lotacao;
                $historicoContratacao->analiseHistorico = "Demanda distribuida para $dadosDemandaAtualizada->responsavelAtual.";
                $historicoContratacao->save();

                // registra o sucesso da atualizacao e retorna para a tela de distribuicao
                $request->session()->flash('mensagem', "demanda $dadosDemandaAtualizada->idDemanda distribuída com sucesso.");
                // header("location:../esteiracomex/distribuir");
                // return redirect()->route('distribuir.index');

                break;
            case 'liquidacao':
                # code...
                break;
            case 'antecipado':
                # code...
                break;
        }
        return "Demanda distribuida com sucesso";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
