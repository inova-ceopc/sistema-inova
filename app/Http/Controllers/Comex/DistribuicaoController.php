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
        if ($request->session()->get('codigoLotacaoFisica') == null || $request->session()->get('codigoLotacaoFisica') === "NULL") {
            $lotacao = $request->session()->get('codigoLotacaoAdministrativa');
        } else {
            $lotacao = $request->session()->get('codigoLotacaoFisica');
        }
        
        if ($request->session()->get('unidadeEmpregadoEsteiraComex') == '5459') {
            $demandasContratacao = ContratacaoDemanda::select('idDemanda', 'nomeCliente', 'cpf', 'cnpj', 'tipoOperacao', 'valorOperacao', 'agResponsavel', 'srResponsavel', 'statusAtual', 'responsavelCeopc')->whereIn('statusAtual', ['CADASTRADA', 'DISTRIBUIDA', 'EM ANALISE', 'INCONFORME'])->get();
        } else {
            switch ($request->session()->get('acessoEmpregadoEsteiraComex')) {
                case 'AGENCIA':
                    $demandasContratacao = ContratacaoDemanda::select('idDemanda', 'nomeCliente', 'cpf', 'cnpj', 'tipoOperacao', 'valorOperacao', 'agResponsavel', 'srResponsavel', 'statusAtual', 'responsavelCeopc')
                        ->where('agResponsavel', $lotacao)                            
                        ->whereIn('statusAtual', ['CADASTRADA', 'DISTRIBUIDA', 'EM ANALISE', 'INCONFORME'])
                        ->get();    
                    break;
                case 'SR':
                    $demandasContratacao = ContratacaoDemanda::select('idDemanda', 'nomeCliente', 'cpf', 'cnpj', 'tipoOperacao', 'valorOperacao', 'agResponsavel', 'srResponsavel', 'statusAtual', 'responsavelCeopc')
                            ->where('srResponsavel', $lotacao)                            
                            ->whereIn('statusAtual', ['CADASTRADA', 'DISTRIBUIDA', 'EM ANALISE', 'INCONFORME'])
                            ->get();
                    break;
            }
        }
        
        // LISTA DE EMPREGADOS NO BACK OFFICE
        $arrayEmpregados = collect([
            (object) ['matricula' => 'c080709', 'nome' => 'JOSIAS'],
            (object) ['matricula' => 'c079258', 'nome' => 'LAURA'],
            (object) ['matricula' => 'c052972', 'nome' => 'BEATRIZ'],
            (object) ['matricula' => 'c133633', 'nome' => 'MARIO'],
            (object) ['matricula' => 'c058725', 'nome' => 'THAIS'],
        ]);

        return view('Comex.Distribuir.index', compact('arrayEmpregados', 'demandasContratacao'));
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
                $historicoContratacao->analiseHistorico = "Demanda distribuida para analise.";
                $historicoContratacao->save();

                // registra o sucesso da atualizacao e retorna para a tela de distribuicao
                $request->session()->flash('mensagem', "Demanda #" . str_pad($dadosDemandaAtualizada->idDemanda, 4, '0', STR_PAD_LEFT) . " distribuída");
                // header("location:../esteiracomex/distribuir");

                return redirect()->route('distribuir.index');
                break;
            case 'liquidacao':
                # code...
                break;
            case 'antecipado':
                # code...
                break;
        }
        // return "Demanda distribuida com sucesso";
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

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function indexApi(Request $request)
    {
        $arrayDemandasContratacao = [];
        $arrayDemandasEsteiraComEmpregadosDistribuicao = ['demandas'];


        if ($request->session()->get('codigoLotacaoFisica') == null || $request->session()->get('codigoLotacaoFisica') === "NULL") {
            $lotacao = $request->session()->get('codigoLotacaoAdministrativa');
        } else {
            $lotacao = $request->session()->get('codigoLotacaoFisica');
        }
        
        if ($request->session()->get('unidadeEmpregadoEsteiraComex') == '5459') {
            $demandasContratacao = ContratacaoDemanda::select('idDemanda', 'nomeCliente', 'cpf', 'cnpj', 'tipoOperacao', 'valorOperacao', 'agResponsavel', 'srResponsavel', 'statusAtual', 'responsavelCeopc')->whereIn('statusAtual', ['CADASTRADA', 'DISTRIBUIDA', 'EM ANALISE', 'INCONFORME', 'CONFORME'])->where('responsavelCeopc', $request->session()->get('matricula'))->get();
        } else {
            switch ($request->session()->get('acessoEmpregadoEsteiraComex')) {
                case 'AGENCIA':
                    $demandasContratacao = ContratacaoDemanda::select('idDemanda', 'nomeCliente', 'cpf', 'cnpj', 'tipoOperacao', 'valorOperacao', 'agResponsavel', 'srResponsavel', 'statusAtual', 'responsavelCeopc')
                        ->where('agResponsavel', $lotacao)                            
                        ->whereIn('statusAtual', ['CADASTRADA', 'DISTRIBUIDA', 'EM ANALISE', 'INCONFORME'])
                        ->get();    
                    break;
                case 'SR':
                    $demandasContratacao = ContratacaoDemanda::select('idDemanda', 'nomeCliente', 'cpf', 'cnpj', 'tipoOperacao', 'valorOperacao', 'agResponsavel', 'srResponsavel', 'statusAtual', 'responsavelCeopc')
                            ->where('srResponsavel', $lotacao)                            
                            ->whereIn('statusAtual', ['CADASTRADA', 'DISTRIBUIDA', 'EM ANALISE', 'INCONFORME'])
                            ->get();
                    break;
            }
        }
        
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

        $arrayTeste = array(
            'contratacao' => $arrayDemandasContratacao
        );
        $arrayDemandasEsteiraComEmpregadosDistribuicao = array(
            'demandasEsteira' => array($arrayTeste));
        // dd($arrayDemandasEsteiraComEmpregadosDistribuicao);
        return json_encode($arrayDemandasEsteiraComEmpregadosDistribuicao, JSON_UNESCAPED_SLASHES);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function indexApiTodasAsDemandas(Request $request)
    {
        $arrayDemandasContratacao = [];
        $arrayDemandasEsteiraComEmpregadosDistribuicao = ['demandas'];


        if ($request->session()->get('codigoLotacaoFisica') == null || $request->session()->get('codigoLotacaoFisica') === "NULL") {
            $lotacao = $request->session()->get('codigoLotacaoAdministrativa');
        } else {
            $lotacao = $request->session()->get('codigoLotacaoFisica');
        }
        
        if ($request->session()->get('unidadeEmpregadoEsteiraComex') == '5459') {
            $demandasContratacao = ContratacaoDemanda::select('idDemanda', 'nomeCliente', 'cpf', 'cnpj', 'tipoOperacao', 'valorOperacao', 'agResponsavel', 'srResponsavel', 'statusAtual', 'responsavelCeopc')->whereIn('statusAtual', ['CADASTRADA', 'DISTRIBUIDA', 'EM ANALISE', 'INCONFORME', 'CONFORME'])->get();
        } else {
            switch ($request->session()->get('acessoEmpregadoEsteiraComex')) {
                case 'AGENCIA':
                    $demandasContratacao = ContratacaoDemanda::select('idDemanda', 'nomeCliente', 'cpf', 'cnpj', 'tipoOperacao', 'valorOperacao', 'agResponsavel', 'srResponsavel', 'statusAtual', 'responsavelCeopc')
                        ->where('agResponsavel', $lotacao)                            
                        ->whereIn('statusAtual', ['CADASTRADA', 'DISTRIBUIDA', 'EM ANALISE', 'INCONFORME', 'CONFORME'])
                        ->get();    
                    break;
                case 'SR':
                    $demandasContratacao = ContratacaoDemanda::select('idDemanda', 'nomeCliente', 'cpf', 'cnpj', 'tipoOperacao', 'valorOperacao', 'agResponsavel', 'srResponsavel', 'statusAtual', 'responsavelCeopc')
                            ->where('srResponsavel', $lotacao)                            
                            ->whereIn('statusAtual', ['CADASTRADA', 'DISTRIBUIDA', 'EM ANALISE', 'INCONFORME', 'CONFORME'])
                            ->get();
                    break;
            }
        }
        
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

        $arrayTeste = array(
            'contratacao' => $arrayDemandasContratacao
        );
        $arrayDemandasEsteiraComEmpregadosDistribuicao = array(
            'demandasEsteira' => array($arrayTeste));
        // dd($arrayDemandasEsteiraComEmpregadosDistribuicao);
        return json_encode($arrayDemandasEsteiraComEmpregadosDistribuicao, JSON_UNESCAPED_SLASHES);
    }
}
