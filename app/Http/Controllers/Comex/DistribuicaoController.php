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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $arrayDemandasContratacao = [];
        $arrayDemandasEsteiraComEmpregadosDistribuicao = ['demandas'];
        
        // LISTA DE DEMANDAS CONTRATACAO
        $demandasContratacao = ContratacaoDemanda::select('idDemanda', 'nomeCliente', 'cpf', 'cnpj', 'tipoOperacao', 'valorOperacao', 'agResponsavel', 'srResponsavel', 'statusAtual')->whereIn('statusAtual', ['CADASTRADA', 'DISTRIBUIDA', 'EM ANALISE'])->get();
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

        switch ($request->tipoDemanda) {
            case 'contratacao':
                // Atualiza a tabela TBL_EST_CONTRATACAO_DEMANDAS
                $demandaContratacao = ContratacaoDemanda::find($id);
                $demandaContratacao->responsavelCeopc = $request->analista;
                $demandaContratacao->save();

                // Recupera os dados da demanda atualizada
                $dadosDemandaAtualizada = ContratacaoDemanda::find($id);

                // Registra o historico da distribuicao
                $historicoContratacao = new ContratacaoHistorico;
                $historicoContratacao->idDemanda = $dadosDemandaAtualizada->idDemanda;
                $historicoContratacao->tipoStatus = "DISTRIBUICAO";
                $historicoContratacao->dataStatus = date("Y-m-d H:i:s", time());
                $historicoContratacao->responsavelStatus = $request->session()->get('matricula');
                $historicoContratacao->area = $lotacao;
                $historicoContratacao->analiseHistoricoContratacao = "Demanda distribuida para $dadosDemandaAtualizada->responsavelAtual.";
                $historicoContratacao->save();

                // registra o sucesso da atualizacao e retorna para a tela de distribuicao
                $request->session()->flash('mensagem', "demanda $demanda->idDemanda distribuída com sucesso.");
                return redirect('esteiracomex/distribuir');

                break;
            case 'liquidacao':
                # code...
                break;
            case 'antecipado':
                # code...
                break;
        }
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
