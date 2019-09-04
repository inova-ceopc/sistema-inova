<?php

namespace App\Http\Controllers\Bndes\NovoSiaf;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Bndes\NovoSiaf\SiafDemanda;
use App\Models\Bndes\NovoSiaf\SiafHistoricoDemanda;
use App\Http\Controllers\Bndes\NovoSiaf\SiafHistoricoDemandaController;
use App\Classes\Bndes\NovoSiaf\SiafPhpMailer;
use App\Classes\Bndes\NovoSiaf\LoteAmortizacaoLiquidacaoSIAF;
use App\Models\Bndes\NovoSiaf\SiafContrato;
use App\Classes\Geral\Ldap;
use App\Empregado;
use App\AcessaEmpregado;
use App\Http\Controllers\Sistemas\EmpregadoController;
use App\Exports\Bndes\DemandasLoteExport;
use Maatwebsite\Excel\Facades\Excel;

class SiafDemandaController extends Controller
{
    public $arrayGigad = [
        '7641', '7639', '7640', '7606', '7648', '7647', '7649', '7652', '7655', '7658', '7657', '7659', '7660', '7661'
    ];
    public $arraySR = [
        '2487', '2489', '2573', '2574', '2575', '2576', '2577', '2578', '2579', '2580', '2581', '2582', '2584', '2585', 
        '2586', '2587', '2588', '2589', '2591', '2592', '2593', '2594', '2595', '2596', '2597', '2598', '2601', '2602', 
        '2603', '2604', '2606', '2607', '2608', '2612', '2613', '2615', '2616', '2617', '2618', '3335', '3410', '3599',
        '3031', '5824', '2506', '2795', '3661', '3675', '3678', '3680', '3683', '3727', '4012', '4169', '4170', '4172', 
        '3332', '2619', '2621', '2622', '2623', '2624', '2625', '2626', '2627', '2628', '2629', '2634', '2635', '2636', 
        '2637', '2639', '2640', '2641', '2642', '2645', '2646', '2647', '2648', '2649', '2650', '2651', '2653', '2654',
        '2655', '2656', '2690', '2691', '2692', '2693', '2694', '3222', '3226', '3227'
    ];

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $arrayDemanda = [];
        // Capturar os dados do contrato
        $contrato = SiafContrato::find($request->input("data.0.contratoCaixa"));
        // Capturar os dados do lote de amortizacao
        $lote = new LoteAmortizacaoLiquidacaoSIAF;
        // Capturar os dados do usuário da sessão
        $usuario = Empregado::find($request->session()->get('matricula'));
        // Captura a lotacao do usuario
        if ($usuario->codigoLotacaoFisica == 'NULL' || $usuario->codigoLotacaoFisica === null) {
            $lotacao = $usuario->codigoLotacaoAdministrativa;
        } else {
            $lotacao = $usuario->codigoLotacaoFisica;
        }
        
        for ($i = 0; $i < sizeof($request->input('data')); $i++) { 
            /* 
                Valida se já existe demanda cadastrada no lote atual e com status de cancelada 
                para que não seja aberto um novo protocolo e sim a atualização do protocolo cancelado
            */
            $demandaJaExiste = SiafDemanda::where('contratoCaixa', $request->input("data." . $i . ".contratoCaixa"))
                        ->where('status', 'CANCELADO')
                        ->where('dataLote', $lote->getDataLoteAtual())
                        ->first();
            if ($demandaJaExiste) {
                echo "demanda já existe";
                $demanda = SiafDemanda::where('contratoCaixa', $request->input("data." . $i . ".contratoCaixa"))
                                    ->where('status', 'CANCELADO')
                                    ->where('dataLote', $lote->getDataLoteAtual())
                                    ->first();
                $demanda->contratoBndes = $request->input("data." . $i . ".contratoBndes");
                $demanda->contaDebito = $request->input("data." . $i . ".contaDebito");
                $demanda->valorOperacao = $request->input("data." . $i . ".valorAmortizacao");
                $demanda->tipoOperacao = $request->input("data." . $i . ".tipoComando");
                $demanda->status = 'CADASTRADO';
                $demanda->save();

                // Recupera os dados da demanda cadastrada
                $dadosDemandaCadastrada = SiafDemanda::find($demanda->codigoDemanda);
                
                // Instancia o model de  Historico da Demanda
                $historicoDemanda = new SiafHistoricoDemanda;
                $historicoDemanda->contratoCaixa = $dadosDemandaCadastrada->contratoCaixa;
                $historicoDemanda->loteAmortizacao = $dadosDemandaCadastrada->dataLote;
                $historicoDemanda->tipoHistorico = 'CADASTRO';
                $historicoDemanda->historico = preg_replace( "/\r|\n/", "", $request->input("data." . $i . ".observacoes"));
                $historicoDemanda->matriculaResponsavel = $usuario->matricula;
                $historicoDemanda->unidadeResponsavel = $lotacao;
                $historicoDemanda->save();

                $dadosHistoricoDemanda = SiafHistoricoDemanda::find($historicoDemanda->codigoHistorico);
                
                // $dados = $request->input("data.".$i.".contratoCaixa"); //
                array_push($arrayDemanda, $dadosDemandaCadastrada);
                array_push($arrayDemanda, $dadosHistoricoDemanda);

                $mail = new SiafPhpMailer;
                $tipoEmail = "registroNovaDemanda";
                $mail->enviarMensageria($usuario, $dadosDemandaCadastrada, $tipoEmail);
            } else {
                // Instancia o model da Demanda
                $demanda = new SiafDemanda();
                $demanda->nomeCliente = $contrato->cliente;
                $demanda->cnpj = $contrato->cnpj;
                $demanda->contratoCaixa = $request->input("data." . $i . ".contratoCaixa");
                $demanda->contratoBndes = $request->input("data." . $i . ".contratoBndes");
                $demanda->valorOperacao = $request->input("data." . $i . ".valorAmortizacao");
                $demanda->tipoOperacao = $request->input("data." . $i . ".tipoComando");
                $demanda->codigoPa = $contrato->codigoPa;
                $demanda->nomePa = $contrato->nomePa;
                $demanda->emailPa = $contrato->emailPa;
                $demanda->codigoSr = $contrato->codigoSr;
                $demanda->nomeSr = $contrato->nomeSr;
                $demanda->emailSr = $contrato->emailSr;
                $demanda->codigoGigad = $contrato->codigoGigad;
                $demanda->nomeGigad = $contrato->nomeGigad;
                $demanda->emailGigad = $contrato->emailGigad;
                $demanda->dataCadastramento = date("Y-m-d H:i:s", time());
                $demanda->dataLote = $lote->getDataLoteAtual();
                $demanda->status = 'CADASTRADO';
                $demanda->matriculaSolicitante = $usuario->matricula;
                $demanda->contaDebito = $request->input("data." . $i . ".contaDebito");
                $demanda->save();

                // Recupera os dados da demanda cadastrada
                $dadosDemandaCadastrada = SiafDemanda::find($demanda->codigoDemanda);
                
                // Instancia o model de  Historico da Demanda
                $historicoDemanda = new SiafHistoricoDemanda;
                $historicoDemanda->contratoCaixa = $dadosDemandaCadastrada->contratoCaixa;
                $historicoDemanda->loteAmortizacao = $dadosDemandaCadastrada->dataLote;
                $historicoDemanda->tipoHistorico = 'CADASTRO';
                $historicoDemanda->historico = preg_replace( "/\r|\n/", "", $request->input("data." . $i . ".observacoes"));
                $historicoDemanda->matriculaResponsavel = $dadosDemandaCadastrada->matriculaSolicitante;
                $historicoDemanda->unidadeResponsavel = $lotacao;
                $historicoDemanda->save();

                $dadosHistoricoDemanda = SiafHistoricoDemanda::find($historicoDemanda->codigoHistorico);
                
                // $dados = $request->input("data.".$i.".contratoCaixa"); //
                array_push($arrayDemanda, $dadosDemandaCadastrada);
                array_push($arrayDemanda, $dadosHistoricoDemanda);

                $mail = new SiafPhpMailer;
                $tipoEmail = "registroNovaDemanda";
                $mail->enviarMensageria($usuario, $dadosDemandaCadastrada, $tipoEmail);
            }
        }

        return json_encode($arrayDemanda);
    }

    /**
     * Display the specified resource.
     *
     * @param  App\Models\Bndes\NovoSiaf\SiafDemanda  $siafDemanda
     * @return \Illuminate\Http\Response
     */
    public function show($demanda)
    {
        $dadosDemanda = DB::table('TBL_SIAF_DEMANDAS')
                            ->select('TBL_SIAF_DEMANDAS.codigoDemanda', 'TBL_SIAF_DEMANDAS.nomeCliente', 'TBL_SIAF_DEMANDAS.cnpj', 'TBL_SIAF_DEMANDAS.contratoCaixa', 'TBL_SIAF_DEMANDAS.contratoBndes', 'TBL_SIAF_DEMANDAS.valorOperacao', 'TBL_SIAF_DEMANDAS.contaDebito', 'TBL_SIAF_DEMANDAS.status', 'TBL_SIAF_DEMANDAS.codigoPa', 'TBL_SIAF_DEMANDAS.codigoSr', 'TBL_SIAF_DEMANDAS.codigoGigad', 'TBL_SIAF_DEMANDAS.tipoOperacao') 
                                // DB::raw("(CASE WHEN tipoOperacao = 'L' THEN 'LIQUIDACAO' WHEN tipoOperacao = 'A' THEN 'AMORTIZACAO' END) AS tipoOperacao"))
                            ->where('TBL_SIAF_DEMANDAS.codigoDemanda', '=', $demanda)
                            ->get();
        if (isset($dadosDemanda)) {
            return json_encode($dadosDemanda, JSON_UNESCAPED_SLASHES);
        } else{
            return response('Demanda não encontrada', 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $arrayHistorico = [];
        $tipoOperacao = "";
        try {
            // Capturar os dados do usuário da sessão
            $usuario = Empregado::find($request->session()->get('matricula'));
            // $usuario = Empregado::find('c112346'); // Necessário forçar matricula da rede para verificar a troca de status para "CORRIGIDO"
            if ($usuario->codigoLotacaoFisica == 'NULL' || $usuario->codigoLotacaoFisica === null) {
                $lotacao = $usuario->codigoLotacaoAdministrativa;
            } else {
                $lotacao = $usuario->codigoLotacaoFisica;
            }

            // Update na tabela TBL_SIAF_DEMANDAS
            $demanda = SiafDemanda::find($id);

            $demanda->contratoBndes = $request->contratoBndes;
            $demanda->contaDebito = $request->contaDebito;
            $demanda->valorOperacao = $request->valorOperacao;
            $demanda->tipoOperacao = $request->tipoOperacao;
            // Verifica se a demanda foi atualizada pela agência e força o status "CORRIGIDO"
            if ($lotacao != '5459') {
                if ($demanda->status === $request->status) {
                    $demanda->status = 'CORRIGIDO';
                } else {
                    $demanda->status = $request->status;
                }              
            } else {
                $demanda->status = $request->status;
            }
            $demanda->save();            

            // Recupera os dados da demanda cadastrada
            $dadoDemandaAtualizada = SiafDemanda::find($id);

            // Insert na tabela TBL_SIAF_HISTORICO_DEMANDAS
            $historicoDemanda = new SiafHistoricoDemanda;
            $historicoDemanda->contratoCaixa = $dadoDemandaAtualizada->contratoCaixa;
            $historicoDemanda->loteAmortizacao = $dadoDemandaAtualizada->dataLote;
            $historicoDemanda->tipoHistorico = $dadoDemandaAtualizada->status;
            $historicoDemanda->historico = $request->observacoes;
            $historicoDemanda->matriculaResponsavel = $usuario->matricula;
            $historicoDemanda->unidadeResponsavel = $lotacao;
            $historicoDemanda->save();

            // Retorna os dados da demanda atualizada/cadastrada via json
            $historicoDemandaCadastrada = SiafHistoricoDemanda::find($historicoDemanda->codigoHistorico);

            $arrayHistoricoDemanda = array(
                "codigoHistorico" => $historicoDemandaCadastrada->codigoHistorico, 
                "dataHistorico" => $historicoDemandaCadastrada->created_at->format('d/m/Y H:i:s'),
                "statusHistorico" => $historicoDemandaCadastrada->tipoHistorico,
                "matriculaResponsavel" => $historicoDemandaCadastrada->matriculaResponsavel,
                "unidadeResponsavel" => str_pad($historicoDemandaCadastrada->unidadeResponsavel, 4, '0', STR_PAD_LEFT),
                "observacaoHistorico" => utf8_decode($historicoDemandaCadastrada->historico)
            );
        
            $arrayDemanda = array(
                "contratoBndes" => $dadoDemandaAtualizada->contratoBndes,
                "contaDebito" => $dadoDemandaAtualizada->contaDebito,
                "valorOperacao" => $dadoDemandaAtualizada->valorOperacao,
                "tipoOperacao" => $dadoDemandaAtualizada->tipoOperacao,
                "status" => $dadoDemandaAtualizada->status,
                "historicoDemanda" => $arrayHistoricoDemanda
            );

            $mail = new SiafPhpMailer;
            $tipoEmail = "";
            switch ($dadoDemandaAtualizada->status) {
                case 'RECEBIDO':
                    $tipoEmail = "demandaRecebidaConforme";
                    break;
                case 'CONTA DIVERGENTE':
                    $tipoEmail = "pendenciaContaDivergente";
                    break;
                case 'VALOR DIVERGENTE':
                    $tipoEmail = "pendenciaValorDivergenteSiafSifbn";
                    break;
                case 'CONTA PF':
                    $tipoEmail = "pendenciaSolicitacaoComContaPessoaFisica";
                    break;
                case 'CONTRATO EM CA':
                    $tipoEmail = "pendenciaContratoCreditoEmAtraso";
                    break;
                case 'CONCLUIDO':
                    $tipoEmail = "contratoLiquidadoOuAmortizado";
                    break;
                case 'GEPOD RESIDUO SIFBN':
                    $tipoEmail = "pendenciaContratoNaoLiquidadoResiduo";
                    break;
                case 'SEM SALDO':
                    $tipoEmail = "pendenciaContratoNaoLiquidadoPorAusenciaSaldo";
                    break;
                case 'SEM COMANDO SIFBN':
                    $tipoEmail = "pendenciaSemComandoNoSifbn";
                    break;
            }
            if($tipoEmail != "") {
                $mail->enviarMensageria($usuario, $dadoDemandaAtualizada, $tipoEmail);
            }
            
            // Verifica o tipo de DataTable que está realizando a requisição, retornando somente o json atualizado dele
            switch ($request->loteDataTable) {
                case 'atual':
                    return $this->loteAtual($request);
                    break;
                case 'anterior':
                    return $this->loteAnterior($request);
                    break;
                case 'gestor':
                    return $this->contratosComGestor($request);
                    break;
            }
            
        } catch (Exception $e) {
            echo 'Exceção capturada: ',  $e->getMessage(), "\n";
        }   
    }

    public function consultaLoteAnterior($dataLoteAnterior, $dataLoteAtual, $lotacaoEmpregado)
    {
        $loteAnterior = DB::table('TBL_SIAF_DEMANDAS')
                        ->select('codigoDemanda', 'nomeCliente', 'cnpj', 'contratoCaixa', 'contratoBndes', 'contaDebito', 'status', 'tipoOperacao',
                            DB::raw("'valorOperacao' = CAST([valorOperacao] AS VARCHAR)"),
                            DB::raw("(CASE WHEN dataLote = '" . $dataLoteAnterior . "' THEN 'anterior' WHEN dataLote = '" . $dataLoteAtual . "' THEN 'atual' ELSE 'gestor' END) AS lote"))
                        ->where('codigoPa', '=', $lotacaoEmpregado)
                        ->where('dataLote', '=', $dataLoteAnterior)             
                        ->get();
        return $loteAnterior;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * 
     */
    public function loteAnterior(Request $request)
    {
        $empregado = Empregado::find($request->session()->get('matricula'));
        $empregadoAcesso = DB::table('tbl_EMPREGADOS')
                            ->join('TBL_ACESSA_EMPREGADOS_SISTEMAS_BNDES', 'tbl_EMPREGADOS.matricula', '=', 'TBL_ACESSA_EMPREGADOS_SISTEMAS_BNDES.matricula')
                            ->select('tbl_EMPREGADOS.*', 'TBL_ACESSA_EMPREGADOS_SISTEMAS_BNDES.nivelAcesso')
                            ->where('TBL_ACESSA_EMPREGADOS_SISTEMAS_BNDES.matricula', '=', $empregado->matricula)
                            ->get();
        $lote = new LoteAmortizacaoLiquidacaoSIAF; 
        switch ($empregadoAcesso[0]->nivelAcesso) {
            case 'EMPREGADO_AG':
                if ($empregadoAcesso[0]->codigoLotacaoFisica == 'NULL' || $empregadoAcesso[0]->codigoLotacaoFisica === null) {      
                    // $loteAnterior = DB::table('TBL_SIAF_DEMANDAS')
                    //                     ->select('codigoDemanda', 'nomeCliente', 'cnpj', 'contratoCaixa', 'contratoBndes', 'contaDebito', 'status', 'tipoOperacao',
                    //                         DB::raw("'valorOperacao' = CAST([valorOperacao] AS VARCHAR)"),
                    //                         DB::raw("(CASE WHEN dataLote = '" . $lote->getDataLoteAnterior() . "' THEN 'anterior' WHEN dataLote = '" . $lote->getDataLoteAtual() . "' THEN 'atual' ELSE 'gestor' END) AS lote"))
                    //                     ->where('codigoPa', '=', $empregadoAcesso[0]->codigoLotacaoAdministrativa)
                    //                     ->where('dataLote', '=', $lote->getDataLoteAnterior())             
                    //                     ->get(); 
                    $loteAnterior = $this->consultaLoteAnterior($lote->getDataLoteAnterior(), $lote->getDataLoteAtual() , $empregadoAcesso[0]->codigoLotacaoAdministrativa);
                    return json_encode($loteAnterior, JSON_UNESCAPED_SLASHES);
                } elseif (in_array($empregadoAcesso[0]->codigoLotacaoFisica, $this->arrayGigad)) {
                    // $loteAnterior = DB::table('TBL_SIAF_DEMANDAS')
                    //                 ->select('codigoDemanda', 'nomeCliente', 'cnpj', 'contratoCaixa', 'contratoBndes', 'contaDebito', 'status', 'tipoOperacao',
                    //                     DB::raw("'valorOperacao' = CAST([valorOperacao] AS VARCHAR)"),
                    //                     DB::raw("(CASE WHEN dataLote = '" . $lote->getDataLoteAnterior() . "' THEN 'anterior' WHEN dataLote = '" . $lote->getDataLoteAtual() . "' THEN 'atual' ELSE 'gestor' END) AS lote"))
                    //                 ->where('codigoGigad', '=', $empregadoAcesso[0]->codigoLotacaoFisica)
                    //                 ->where('dataLote', '=', $lote->getDataLoteAnterior())
                    //                 ->get();
                    $loteAnterior = $this->consultaLoteAnterior($lote->getDataLoteAnterior(), $lote->getDataLoteAtual() , $empregadoAcesso[0]->codigoLotacaoFisica);
                    return json_encode($loteAnterior, JSON_UNESCAPED_SLASHES);
                } elseif (in_array($empregadoAcesso[0]->codigoLotacaoFisica, $this->arraySR)) {       
                    // $loteAnterior = DB::table('TBL_SIAF_DEMANDAS')
                    //                 ->select('codigoDemanda', 'nomeCliente', 'cnpj', 'contratoCaixa', 'contratoBndes', 'contaDebito', 'status', 'tipoOperacao',
                    //                     DB::raw("'valorOperacao' = CAST([valorOperacao] AS VARCHAR)"),
                    //                     DB::raw("(CASE WHEN dataLote = '" . $lote->getDataLoteAnterior() . "' THEN 'anterior' WHEN dataLote = '" . $lote->getDataLoteAtual() . "' THEN 'atual' ELSE 'gestor' END) AS lote"))
                    //                 ->where('codigoSr', '=', $empregadoAcesso[0]->codigoLotacaoFisica)
                    //                 ->where('dataLote', '=', $lote->getDataLoteAnterior())
                    //                 ->get();      
                    $loteAnterior = $this->consultaLoteAnterior($lote->getDataLoteAnterior(), $lote->getDataLoteAtual() , $empregadoAcesso[0]->codigoLotacaoFisica);
                    return json_encode($loteAnterior, JSON_UNESCAPED_SLASHES);
                } else {       
                    // $loteAnterior = DB::table('TBL_SIAF_DEMANDAS')
                    //                 ->select('codigoDemanda', 'nomeCliente', 'cnpj', 'contratoCaixa', 'contratoBndes', 'contaDebito', 'status', 'tipoOperacao',
                    //                     DB::raw("'valorOperacao' = CAST([valorOperacao] AS VARCHAR)"),
                    //                     DB::raw("(CASE WHEN dataLote = '" . $lote->getDataLoteAnterior() . "' THEN 'anterior' WHEN dataLote = '" . $lote->getDataLoteAtual() . "' THEN 'atual' ELSE 'gestor' END) AS lote"))
                    //                 ->where('codigoPa', '=', $empregadoAcesso[0]->codigoLotacaoFisica)
                    //                 ->where('dataLote', '=', $lote->getDataLoteAnterior())
                    //                 ->get();       
                    $loteAnterior = $this->consultaLoteAnterior($lote->getDataLoteAnterior(), $lote->getDataLoteAtual() , $empregadoAcesso[0]->codigoLotacaoFisica);
                    return json_encode($loteAnterior, JSON_UNESCAPED_SLASHES);
                }                   
                break;
            case 'EMPREGADO_SR':
                if ($empregadoAcesso[0]->codigoLotacaoFisica == 'NULL' || $empregadoAcesso[0]->codigoLotacaoFisica === null) {       
                    // $loteAnterior = DB::table('TBL_SIAF_DEMANDAS')
                    //                 ->select('codigoDemanda', 'nomeCliente', 'cnpj', 'contratoCaixa', 'contratoBndes', 'contaDebito', 'status', 'tipoOperacao',
                    //                     DB::raw("'valorOperacao' = CAST([valorOperacao] AS VARCHAR)"),
                    //                     DB::raw("(CASE WHEN dataLote = '" . $lote->getDataLoteAnterior() . "' THEN 'anterior' WHEN dataLote = '" . $lote->getDataLoteAtual() . "' THEN 'atual' ELSE 'gestor' END) AS lote"))
                    //                 ->where('codigoSr', '=', $empregadoAcesso[0]->codigoLotacaoAdministrativa)
                    //                 ->where('dataLote', '=', $lote->getDataLoteAnterior())
                    //                 ->get();  
                    $loteAnterior = $this->consultaLoteAnterior($lote->getDataLoteAnterior(), $lote->getDataLoteAtual() , $empregadoAcesso[0]->codigoLotacaoAdministrativa);     
                    return json_encode($loteAnterior, JSON_UNESCAPED_SLASHES);
                } elseif (in_array($empregadoAcesso[0]->codigoLotacaoFisica, $this->arrayGigad)) {
                    // $loteAnterior = DB::table('TBL_SIAF_DEMANDAS')
                    //                 ->select('codigoDemanda', 'nomeCliente', 'cnpj', 'contratoCaixa', 'contratoBndes', 'contaDebito', 'status', 'tipoOperacao',
                    //                     DB::raw("'valorOperacao' = CAST([valorOperacao] AS VARCHAR)"),
                    //                     DB::raw("(CASE WHEN dataLote = '" . $lote->getDataLoteAnterior() . "' THEN 'anterior' WHEN dataLote = '" . $lote->getDataLoteAtual() . "' THEN 'atual' ELSE 'gestor' END) AS lote"))
                    //                 ->where('codigoGigad', '=', $empregadoAcesso[0]->codigoLotacaoFisica)
                    //                 ->where('dataLote', '=', $lote->getDataLoteAnterior())
                    //                 ->get();    
                    $loteAnterior = $this->consultaLoteAnterior($lote->getDataLoteAnterior(), $lote->getDataLoteAtual() , $empregadoAcesso[0]->codigoLotacaoFisica);     
                    return json_encode($loteAnterior, JSON_UNESCAPED_SLASHES);
                } elseif (in_array($empregadoAcesso[0]->codigoLotacaoFisica, $this->arraySR)) {     
                    // $loteAnterior = DB::table('TBL_SIAF_DEMANDAS')
                    //                 ->select('codigoDemanda', 'nomeCliente', 'cnpj', 'contratoCaixa', 'contratoBndes', 'contaDebito', 'status', 'tipoOperacao',
                    //                     DB::raw("'valorOperacao' = CAST([valorOperacao] AS VARCHAR)"),
                    //                     DB::raw("(CASE WHEN dataLote = '" . $lote->getDataLoteAnterior() . "' THEN 'anterior' WHEN dataLote = '" . $lote->getDataLoteAtual() . "' THEN 'atual' ELSE 'gestor' END) AS lote"))
                    //                 ->where('codigoSr', '=', $empregadoAcesso[0]->codigoLotacaoFisica)
                    //                 ->where('dataLote', '=', $lote->getDataLoteAnterior())
                    //                 ->get();     
                    $loteAnterior = $this->consultaLoteAnterior($lote->getDataLoteAnterior(), $lote->getDataLoteAtual() , $empregadoAcesso[0]->codigoLotacaoFisica);
                    return json_encode($loteAnterior, JSON_UNESCAPED_SLASHES);
                } else {       
                    // $loteAnterior = DB::table('TBL_SIAF_DEMANDAS')
                    //                 ->select('codigoDemanda', 'nomeCliente', 'cnpj', 'contratoCaixa', 'contratoBndes', 'contaDebito', 'status', 'tipoOperacao',
                    //                     DB::raw("'valorOperacao' = CAST([valorOperacao] AS VARCHAR)"),
                    //                     DB::raw("(CASE WHEN dataLote = '" . $lote->getDataLoteAnterior() . "' THEN 'anterior' WHEN dataLote = '" . $lote->getDataLoteAtual() . "' THEN 'atual' ELSE 'gestor' END) AS lote"))
                    //                 ->where('codigoPa', '=', $empregadoAcesso[0]->codigoLotacaoFisica)
                    //                 ->where('dataLote', '=', $lote->getDataLoteAnterior())
                    //                 ->get();      
                    $loteAnterior = $this->consultaLoteAnterior($lote->getDataLoteAnterior(), $lote->getDataLoteAtual() , $empregadoAcesso[0]->codigoLotacaoFisica);
                    return json_encode($loteAnterior, JSON_UNESCAPED_SLASHES);
                }                   
                break;
            case 'GIGAD':
                if ($empregadoAcesso[0]->codigoLotacaoFisica == 'NULL' || $empregadoAcesso[0]->codigoLotacaoFisica === null) {    
                    // $loteAnterior = DB::table('TBL_SIAF_DEMANDAS')
                    //                 ->select('codigoDemanda', 'nomeCliente', 'cnpj', 'contratoCaixa', 'contratoBndes', 'contaDebito', 'status', 'tipoOperacao',
                    //                     DB::raw("'valorOperacao' = CAST([valorOperacao] AS VARCHAR)"),
                    //                     DB::raw("(CASE WHEN dataLote = '" . $lote->getDataLoteAnterior() . "' THEN 'anterior' WHEN dataLote = '" . $lote->getDataLoteAtual() . "' THEN 'atual' ELSE 'gestor' END) AS lote"))
                    //                 ->where('codigoGigad', '=', $empregadoAcesso[0]->codigoLotacaoAdministrativa)
                    //                 ->where('dataLote', '=', $lote->getDataLoteAnterior())
                    //                 ->get();    
                    $loteAnterior = $this->consultaLoteAnterior($lote->getDataLoteAnterior(), $lote->getDataLoteAtual() , $empregadoAcesso[0]->codigoLotacaoAdministrativa);
                    return json_encode($loteAnterior, JSON_UNESCAPED_SLASHES);
                } elseif (in_array($empregadoAcesso[0]->codigoLotacaoFisica, $this->arrayGigad)) {
                    // $loteAnterior = DB::table('TBL_SIAF_DEMANDAS')
                    //                 ->select('codigoDemanda', 'nomeCliente', 'cnpj', 'contratoCaixa', 'contratoBndes', 'contaDebito', 'status', 'tipoOperacao',
                    //                     DB::raw("'valorOperacao' = CAST([valorOperacao] AS VARCHAR)"),
                    //                     DB::raw("(CASE WHEN dataLote = '" . $lote->getDataLoteAnterior() . "' THEN 'anterior' WHEN dataLote = '" . $lote->getDataLoteAtual() . "' THEN 'atual' ELSE 'gestor' END) AS lote"))
                    //                 ->where('codigoGigad', '=', $empregadoAcesso[0]->codigoLotacaoFisica)
                    //                 ->where('dataLote', '=', $lote->getDataLoteAnterior())
                    //                 ->get();
                    $loteAnterior = $this->consultaLoteAnterior($lote->getDataLoteAnterior(), $lote->getDataLoteAtual() , $empregadoAcesso[0]->codigoLotacaoFisica);
                    return json_encode($loteAnterior, JSON_UNESCAPED_SLASHES);
                } elseif (in_array($empregadoAcesso[0]->codigoLotacaoFisica, $this->arraySR)) {      
                    // $loteAnterior = DB::table('TBL_SIAF_DEMANDAS')
                    //                 ->select('codigoDemanda', 'nomeCliente', 'cnpj', 'contratoCaixa', 'contratoBndes', 'contaDebito', 'status', 'tipoOperacao',
                    //                     DB::raw("'valorOperacao' = CAST([valorOperacao] AS VARCHAR)"),
                    //                     DB::raw("(CASE WHEN dataLote = '" . $lote->getDataLoteAnterior() . "' THEN 'anterior' WHEN dataLote = '" . $lote->getDataLoteAtual() . "' THEN 'atual' ELSE 'gestor' END) AS lote"))
                    //                 ->where('codigoSr', '=', $empregadoAcesso[0]->codigoLotacaoFisica)
                    //                 ->where('dataLote', '=', $lote->getDataLoteAnterior())
                    //                 ->get();      
                    $loteAnterior = $this->consultaLoteAnterior($lote->getDataLoteAnterior(), $lote->getDataLoteAtual() , $empregadoAcesso[0]->codigoLotacaoFisica);
                    return json_encode($loteAnterior, JSON_UNESCAPED_SLASHES);
                } else {      
                    // $loteAnterior = DB::table('TBL_SIAF_DEMANDAS')
                    //                 ->select('codigoDemanda', 'nomeCliente', 'cnpj', 'contratoCaixa', 'contratoBndes', 'contaDebito', 'status', 'tipoOperacao',
                    //                     DB::raw("'valorOperacao' = CAST([valorOperacao] AS VARCHAR)"),
                    //                     DB::raw("(CASE WHEN dataLote = '" . $lote->getDataLoteAnterior() . "' THEN 'anterior' WHEN dataLote = '" . $lote->getDataLoteAtual() . "' THEN 'atual' ELSE 'gestor' END) AS lote"))
                    //                 ->where('codigoPa', '=', $empregadoAcesso[0]->codigoLotacaoFisica)
                    //                 ->where('dataLote', '=', $lote->getDataLoteAnterior())
                    //                 ->get();       
                    $loteAnterior = $this->consultaLoteAnterior($lote->getDataLoteAnterior(), $lote->getDataLoteAtual() , $empregadoAcesso[0]->codigoLotacaoFisica);
                    return json_encode($loteAnterior, JSON_UNESCAPED_SLASHES);
                }
                break;
            default:     
            $loteAnterior = DB::table('TBL_SIAF_DEMANDAS')
                                ->select('codigoDemanda', 'nomeCliente', 'cnpj', 'contratoCaixa', 'contratoBndes', 'contaDebito', 'status', 'tipoOperacao',
                                    DB::raw("'valorOperacao' = CAST([valorOperacao] AS VARCHAR)"),
                                    DB::raw("(CASE WHEN dataLote = '" . $lote->getDataLoteAnterior() . "' THEN 'anterior' WHEN dataLote = '" . $lote->getDataLoteAtual() . "' THEN 'atual' ELSE 'gestor' END) AS lote"))
                                ->where('dataLote', '=', $lote->getDataLoteAnterior())
                                ->get();
            return json_encode($loteAnterior, JSON_UNESCAPED_SLASHES);
                break;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function loteAtual(Request  $request)
    {
        $empregado = Empregado::find($request->session()->get('matricula'));
        $empregadoAcesso = DB::table('tbl_EMPREGADOS')
                            ->join('TBL_ACESSA_EMPREGADOS_SISTEMAS_BNDES', 'tbl_EMPREGADOS.matricula', '=', 'TBL_ACESSA_EMPREGADOS_SISTEMAS_BNDES.matricula')
                            ->select('tbl_EMPREGADOS.*', 'TBL_ACESSA_EMPREGADOS_SISTEMAS_BNDES.nivelAcesso')
                            ->where('TBL_ACESSA_EMPREGADOS_SISTEMAS_BNDES.matricula', '=', $empregado->matricula)
                            ->get();
        $lote = new LoteAmortizacaoLiquidacaoSIAF;
        switch ($empregadoAcesso[0]->nivelAcesso) {
            case 'EMPREGADO_AG':
                if ($empregadoAcesso[0]->codigoLotacaoFisica == 'NULL' || $empregadoAcesso[0]->codigoLotacaoFisica === null) {
                    $loteAnterior = DB::table('TBL_SIAF_DEMANDAS')
                                        ->select('codigoDemanda', 'nomeCliente', 'cnpj', 'contratoCaixa', 'contratoBndes', 'contaDebito', 'status', 'tipoOperacao',
                                            DB::raw("'valorOperacao' = CAST([valorOperacao] AS VARCHAR)"),
                                            DB::raw("(CASE WHEN dataLote = '" . $lote->getDataLoteAnterior() . "' THEN 'anterior' WHEN dataLote = '" . $lote->getDataLoteAtual() . "' THEN 'atual' ELSE 'gestor' END) AS lote"))
                                        ->where('dataLote', '=', $lote->getDataLoteAtual())
                                        ->where('codigoPa', '=', $empregadoAcesso[0]->codigoLotacaoAdministrativa)
                                        ->get();       
                    return json_encode($loteAnterior, JSON_UNESCAPED_SLASHES);
                } elseif (in_array($empregadoAcesso[0]->codigoLotacaoFisica, $this->arrayGigad)) {
                    $loteAnterior = DB::table('TBL_SIAF_DEMANDAS')
                                    ->select('codigoDemanda', 'nomeCliente', 'cnpj', 'contratoCaixa', 'contratoBndes', 'contaDebito', 'status', 'tipoOperacao',
                                        DB::raw("'valorOperacao' = CAST([valorOperacao] AS VARCHAR)"),
                                        DB::raw("(CASE WHEN dataLote = '" . $lote->getDataLoteAnterior() . "' THEN 'anterior' WHEN dataLote = '" . $lote->getDataLoteAtual() . "' THEN 'atual' ELSE 'gestor' END) AS lote"))
                                    ->where('dataLote', '=', $lote->getDataLoteAtual())
                                    ->where('codigoGigad', '=', $empregadoAcesso[0]->codigoLotacaoFisica)
                                    ->get();        
                    return json_encode($loteAnterior, JSON_UNESCAPED_SLASHES);
                } elseif (in_array($empregadoAcesso[0]->codigoLotacaoFisica, $this->arraySR)) {
                    $loteAnterior = DB::table('TBL_SIAF_DEMANDAS')
                                    ->select('codigoDemanda', 'nomeCliente', 'cnpj', 'contratoCaixa', 'contratoBndes', 'contaDebito', 'status', 'tipoOperacao',
                                        DB::raw("'valorOperacao' = CAST([valorOperacao] AS VARCHAR)"),
                                        DB::raw("(CASE WHEN dataLote = '" . $lote->getDataLoteAnterior() . "' THEN 'anterior' WHEN dataLote = '" . $lote->getDataLoteAtual() . "' THEN 'atual' ELSE 'gestor' END) AS lote"))
                                    ->where('dataLote', '=', $lote->getDataLoteAtual())
                                    ->where('codigoSr', '=', $empregadoAcesso[0]->codigoLotacaoFisica)
                                    ->get();         
                    return json_encode($loteAnterior, JSON_UNESCAPED_SLASHES);
                } else {
                    $loteAnterior = DB::table('TBL_SIAF_DEMANDAS')
                                    ->select('codigoDemanda', 'nomeCliente', 'cnpj', 'contratoCaixa', 'contratoBndes', 'contaDebito', 'status', 'tipoOperacao',
                                        DB::raw("'valorOperacao' = CAST([valorOperacao] AS VARCHAR)"),
                                        DB::raw("(CASE WHEN dataLote = '" . $lote->getDataLoteAnterior() . "' THEN 'anterior' WHEN dataLote = '" . $lote->getDataLoteAtual() . "' THEN 'atual' ELSE 'gestor' END) AS lote"))
                                    ->where('dataLote', '=', $lote->getDataLoteAtual())
                                    ->where('codigoPa', '=', $empregadoAcesso[0]->codigoLotacaoFisica)
                                    ->get();        
                    return json_encode($loteAnterior, JSON_UNESCAPED_SLASHES);
                }
                break;
            case 'EMPREGADO_SR':
                if ($empregadoAcesso[0]->codigoLotacaoFisica == 'NULL' || $empregadoAcesso[0]->codigoLotacaoFisica === null) {      
                    $loteAnterior = DB::table('TBL_SIAF_DEMANDAS')
                                        ->select('codigoDemanda', 'nomeCliente', 'cnpj', 'contratoCaixa', 'contratoBndes', 'contaDebito', 'status', 'tipoOperacao',
                                            DB::raw("'valorOperacao' = CAST([valorOperacao] AS VARCHAR)"),
                                            DB::raw("(CASE WHEN dataLote = '" . $lote->getDataLoteAnterior() . "' THEN 'anterior' WHEN dataLote = '" . $lote->getDataLoteAtual() . "' THEN 'atual' ELSE 'gestor' END) AS lote"))
                                        ->where('dataLote', '=', $lote->getDataLoteAtual())
                                        ->where('codigoSr', '=', $empregadoAcesso[0]->codigoLotacaoAdministrativa)
                                        ->get();       
                    return json_encode($loteAnterior, JSON_UNESCAPED_SLASHES);
                } else {
                    if (in_array($empregadoAcesso[0]->codigoLotacaoFisica, $this->arrayGigad)) {
                        $loteAnterior = DB::table('TBL_SIAF_DEMANDAS')
                                        ->select('codigoDemanda', 'nomeCliente', 'cnpj', 'contratoCaixa', 'contratoBndes', 'contaDebito', 'status', 'tipoOperacao',
                                            DB::raw("'valorOperacao' = CAST([valorOperacao] AS VARCHAR)"),
                                            DB::raw("(CASE WHEN dataLote = '" . $lote->getDataLoteAnterior() . "' THEN 'anterior' WHEN dataLote = '" . $lote->getDataLoteAtual() . "' THEN 'atual' ELSE 'gestor' END) AS lote"))
                                        ->where('dataLote', '=', $lote->getDataLoteAtual())
                                        ->where('codigoGigad', '=', $empregadoAcesso[0]->codigoLotacaoFisica)
                                        ->get();        
                        return json_encode($loteAnterior, JSON_UNESCAPED_SLASHES);
                    } elseif (in_array($empregadoAcesso[0]->codigoLotacaoFisica, $this->arraySR)) {      
                        $loteAnterior = DB::table('TBL_SIAF_DEMANDAS')
                                        ->select('codigoDemanda', 'nomeCliente', 'cnpj', 'contratoCaixa', 'contratoBndes', 'contaDebito', 'status', 'tipoOperacao',
                                            DB::raw("'valorOperacao' = CAST([valorOperacao] AS VARCHAR)"),
                                            DB::raw("(CASE WHEN dataLote = '" . $lote->getDataLoteAnterior() . "' THEN 'anterior' WHEN dataLote = '" . $lote->getDataLoteAtual() . "' THEN 'atual' ELSE 'gestor' END) AS lote"))
                                        ->where('dataLote', '=', $lote->getDataLoteAtual())
                                        ->where('codigoSr', '=', $empregadoAcesso[0]->codigoLotacaoFisica)
                                        ->get();      
                        return json_encode($loteAnterior, JSON_UNESCAPED_SLASHES);
                    } else {       
                        $loteAnterior = DB::table('TBL_SIAF_DEMANDAS')
                                        ->select('codigoDemanda', 'nomeCliente', 'cnpj', 'contratoCaixa', 'contratoBndes', 'contaDebito', 'status', 'tipoOperacao',
                                            DB::raw("'valorOperacao' = CAST([valorOperacao] AS VARCHAR)"),
                                            DB::raw("(CASE WHEN dataLote = '" . $lote->getDataLoteAnterior() . "' THEN 'anterior' WHEN dataLote = '" . $lote->getDataLoteAtual() . "' THEN 'atual' ELSE 'gestor' END) AS lote"))
                                        ->where('dataLote', '=', $lote->getDataLoteAtual())
                                        ->where('codigoPa', '=', $empregadoAcesso[0]->codigoLotacaoFisica)
                                        ->get();       
                        return json_encode($loteAnterior, JSON_UNESCAPED_SLASHES);
                    }                   
                }
                break;
            case 'GIGAD':
                if ($empregadoAcesso[0]->codigoLotacaoFisica == 'NULL' || $empregadoAcesso[0]->codigoLotacaoFisica === null) {      
                    $loteAnterior = DB::table('TBL_SIAF_DEMANDAS')
                                        ->select('codigoDemanda', 'nomeCliente', 'cnpj', 'contratoCaixa', 'contratoBndes', 'contaDebito', 'status', 'tipoOperacao',
                                            DB::raw("'valorOperacao' = CAST([valorOperacao] AS VARCHAR)"),
                                            DB::raw("(CASE WHEN dataLote = '" . $lote->getDataLoteAnterior() . "' THEN 'anterior' WHEN dataLote = '" . $lote->getDataLoteAtual() . "' THEN 'atual' ELSE 'gestor' END) AS lote"))
                                        ->where('dataLote', '=', $lote->getDataLoteAtual())
                                        ->where('codigoGigad', '=', $empregadoAcesso[0]->codigoLotacaoAdministrativa)
                                        ->get();   
                    return json_encode($loteAnterior, JSON_UNESCAPED_SLASHES);
                } elseif (in_array($empregadoAcesso[0]->codigoLotacaoFisica, $this->arrayGigad)) {
                    $loteAnterior = DB::table('TBL_SIAF_DEMANDAS')
                                        ->select('codigoDemanda', 'nomeCliente', 'cnpj', 'contratoCaixa', 'contratoBndes', 'contaDebito', 'status', 'tipoOperacao',
                                            DB::raw("'valorOperacao' = CAST([valorOperacao] AS VARCHAR)"),
                                            DB::raw("(CASE WHEN dataLote = '" . $lote->getDataLoteAnterior() . "' THEN 'anterior' WHEN dataLote = '" . $lote->getDataLoteAtual() . "' THEN 'atual' ELSE 'gestor' END) AS lote"))
                                        ->where('dataLote', '=', $lote->getDataLoteAtual())
                                        ->where('codigoGigad', '=', $empregadoAcesso[0]->codigoLotacaoFisica)
                                        ->get();        
                    return json_encode($loteAnterior, JSON_UNESCAPED_SLASHES);
                } elseif (in_array($empregadoAcesso[0]->codigoLotacaoFisica, $this->arraySR)) {       
                    $loteAnterior = DB::table('TBL_SIAF_DEMANDAS')
                                        ->select('codigoDemanda', 'nomeCliente', 'cnpj', 'contratoCaixa', 'contratoBndes', 'contaDebito', 'status', 'tipoOperacao',
                                            DB::raw("'valorOperacao' = CAST([valorOperacao] AS VARCHAR)"),
                                            DB::raw("(CASE WHEN dataLote = '" . $lote->getDataLoteAnterior() . "' THEN 'anterior' WHEN dataLote = '" . $lote->getDataLoteAtual() . "' THEN 'atual' ELSE 'gestor' END) AS lote"))
                                        ->where('dataLote', '=', $lote->getDataLoteAtual())
                                        ->where('codigoSr', '=', $empregadoAcesso[0]->codigoLotacaoFisica)
                                        ->get();       
                    return json_encode($loteAnterior, JSON_UNESCAPED_SLASHES);
                } else {      
                    $loteAnterior = DB::table('TBL_SIAF_DEMANDAS')
                                        ->select('codigoDemanda', 'nomeCliente', 'cnpj', 'contratoCaixa', 'contratoBndes', 'contaDebito', 'status', 'tipoOperacao',
                                            DB::raw("'valorOperacao' = CAST([valorOperacao] AS VARCHAR)"),
                                            DB::raw("(CASE WHEN dataLote = '" . $lote->getDataLoteAnterior() . "' THEN 'anterior' WHEN dataLote = '" . $lote->getDataLoteAtual() . "' THEN 'atual' ELSE 'gestor' END) AS lote"))
                                        ->where('dataLote', '=', $lote->getDataLoteAtual())
                                        ->where('codigoPa', '=', $empregadoAcesso[0]->codigoLotacaoFisica)
                                        ->get();        
                    return json_encode($loteAnterior, JSON_UNESCAPED_SLASHES);
                }
                break;
            default:     
            $loteAnterior = DB::table('TBL_SIAF_DEMANDAS')
                                ->select('codigoDemanda', 'nomeCliente', 'cnpj', 'contratoCaixa', 'contratoBndes', 'contaDebito', 'status', 'tipoOperacao',
                                    DB::raw("'valorOperacao' = CAST([valorOperacao] AS VARCHAR)"),
                                    DB::raw("(CASE WHEN dataLote = '" . $lote->getDataLoteAnterior() . "' THEN 'anterior' WHEN dataLote = '" . $lote->getDataLoteAtual() . "' THEN 'atual' ELSE 'gestor' END) AS lote"))
                                ->where('dataLote', '=', $lote->getDataLoteAtual())
                                ->get();
            return json_encode($loteAnterior, JSON_UNESCAPED_SLASHES);
                break;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function contratosComGestor(Request  $request)

    {
        $empregado = Empregado::find($request->session()->get('matricula'));
        $empregadoAcesso = DB::table('tbl_EMPREGADOS')
                            ->join('TBL_ACESSA_EMPREGADOS_SISTEMAS_BNDES', 'tbl_EMPREGADOS.matricula', '=', 'TBL_ACESSA_EMPREGADOS_SISTEMAS_BNDES.matricula')
                            ->select('tbl_EMPREGADOS.*', 'TBL_ACESSA_EMPREGADOS_SISTEMAS_BNDES.nivelAcesso')
                            ->where('TBL_ACESSA_EMPREGADOS_SISTEMAS_BNDES.matricula', '=', $empregado->matricula)
                            ->get();
        
        switch ($empregadoAcesso[0]->nivelAcesso) {
            case 'EMPREGADO_AG':
                if ($empregadoAcesso[0]->codigoLotacaoFisica == 'NULL' || $empregadoAcesso[0]->codigoLotacaoFisica === null) {
                    $contratosGestor = DB::table('TBL_SIAF_DEMANDAS')
                                            ->select('codigoDemanda', 'nomeCliente', 'contratoCaixa', 'contratoBndes', 'valorOperacao', 'dataLote', 'status', 'tipoOperacao',
                                            DB::raw("'lote' = 'gestor'"))
                                            ->where('status', 'like', '%SUMEP%')
                                            ->orWhere('status', 'like', '%GEPOD%')
                                            ->orWhere('status', 'like', '%GESTOR%')
                                            ->where('codigoPa', '=', $empregadoAcesso[0]->codigoLotacaoAdministrativa)              
                                            ->get();      
                        return json_encode($contratosGestor, JSON_UNESCAPED_SLASHES);
                } else {
                    if (in_array($empregadoAcesso[0]->codigoLotacaoFisica, $this->arrayGigad)) {
                        $contratosGestor = DB::table('TBL_SIAF_DEMANDAS')
                                            ->select('codigoDemanda', 'nomeCliente', 'contratoCaixa', 'contratoBndes', 'valorOperacao', 'dataLote', 'status', 'tipoOperacao',
                                            DB::raw("'lote' = 'gestor'"))
                                            ->where('status', 'like', '%SUMEP%')
                                            ->orWhere('status', 'like', '%GEPOD%')
                                            ->orWhere('status', 'like', '%GESTOR%')
                                            ->where('codigoGigad', '=', $empregadoAcesso[0]->codigoLotacaoFisica)              
                                            ->get();    
                        return json_encode($contratosGestor, JSON_UNESCAPED_SLASHES);
                    } elseif (in_array($empregadoAcesso[0]->codigoLotacaoFisica, $this->arraySR)) {
                        $contratosGestor = DB::table('TBL_SIAF_DEMANDAS')
                                            ->select('codigoDemanda', 'nomeCliente', 'contratoCaixa', 'contratoBndes', 'valorOperacao', 'dataLote', 'status', 'tipoOperacao',
                                            DB::raw("'lote' = 'gestor'"))
                                            ->where('status', 'like', '%SUMEP%')
                                            ->orWhere('status', 'like', '%GEPOD%')
                                            ->orWhere('status', 'like', '%GESTOR%')
                                            ->where('codigoSr', '=', $empregadoAcesso[0]->codigoLotacaoFisica)               
                                            ->get();       
                        return json_encode($contratosGestor, JSON_UNESCAPED_SLASHES);
                    } else {
                        $contratosGestor = DB::table('TBL_SIAF_DEMANDAS')
                                            ->select('codigoDemanda', 'nomeCliente', 'contratoCaixa', 'contratoBndes', 'valorOperacao', 'dataLote', 'status', 'tipoOperacao',
                                            DB::raw("'lote' = 'gestor'"))
                                            ->where('status', 'like', '%SUMEP%')
                                            ->orWhere('status', 'like', '%GEPOD%')
                                            ->orWhere('status', 'like', '%GESTOR%')
                                            ->where('codigoPa', '=', $empregadoAcesso[0]->codigoLotacaoFisica)               
                                            ->get();       
                        return json_encode($contratosGestor, JSON_UNESCAPED_SLASHES);
                    }                   
                }
                break;
            case 'EMPREGADO_SR':
                if ($empregadoAcesso[0]->codigoLotacaoFisica == 'NULL' || $empregadoAcesso[0]->codigoLotacaoFisica === null) {
                    $contratosGestor = DB::table('TBL_SIAF_DEMANDAS')
                                            ->select('codigoDemanda', 'nomeCliente', 'contratoCaixa', 'contratoBndes', 'valorOperacao', 'dataLote', 'status', 'tipoOperacao',
                                            DB::raw("'lote' = 'gestor'"))
                                            ->where('status', 'like', '%SUMEP%')
                                            ->orWhere('status', 'like', '%GEPOD%')
                                            ->orWhere('status', 'like', '%GESTOR%')
                                            ->where('codigoSr', '=', $empregadoAcesso[0]->codigoLotacaoAdministrativa)               
                                            ->get();       
                    return json_encode($contratosGestor, JSON_UNESCAPED_SLASHES);
                } else {
                    if (in_array($empregadoAcesso[0]->codigoLotacaoFisica, $this->arrayGigad)) {
                        $contratosGestor = DB::table('TBL_SIAF_DEMANDAS')
                                            ->select('codigoDemanda', 'nomeCliente', 'contratoCaixa', 'contratoBndes', 'valorOperacao', 'dataLote', 'status', 'tipoOperacao',
                                            DB::raw("'lote' = 'gestor'"))
                                            ->where('status', 'like', '%SUMEP%')
                                            ->orWhere('status', 'like', '%GEPOD%')
                                            ->orWhere('status', 'like', '%GESTOR%')
                                            ->where('codigoGigad', '=', $empregadoAcesso[0]->codigoLotacaoFisica)                
                                            ->get();       
                        return json_encode($contratosGestor, JSON_UNESCAPED_SLASHES);
                    } elseif (in_array($empregadoAcesso[0]->codigoLotacaoFisica, $this->arraySR)) {
                        $contratosGestor = DB::table('TBL_SIAF_DEMANDAS')
                                            ->select('codigoDemanda', 'nomeCliente', 'contratoCaixa', 'contratoBndes', 'valorOperacao', 'dataLote', 'status', 'tipoOperacao',
                                            DB::raw("'lote' = 'gestor'"))
                                            ->where('status', 'like', '%SUMEP%')
                                            ->orWhere('status', 'like', '%GEPOD%')
                                            ->orWhere('status', 'like', '%GESTOR%')
                                            ->where('codigoSr', '=', $empregadoAcesso[0]->codigoLotacaoFisica)                   
                                            ->get();       
                        return json_encode($contratosGestor, JSON_UNESCAPED_SLASHES);
                    } else {
                        $contratosGestor = DB::table('TBL_SIAF_DEMANDAS')
                                            ->select('codigoDemanda', 'nomeCliente', 'contratoCaixa', 'contratoBndes', 'valorOperacao', 'dataLote', 'status', 'tipoOperacao',
                                            DB::raw("'lote' = 'gestor'"))
                                            ->where('status', 'like', '%SUMEP%')
                                            ->orWhere('status', 'like', '%GEPOD%')
                                            ->orWhere('status', 'like', '%GESTOR%')
                                            ->where('codigoPa', '=', $empregadoAcesso[0]->codigoLotacaoFisica)                      
                                            ->get();      
                        return json_encode($contratosGestor, JSON_UNESCAPED_SLASHES);
                    }                   
                }
                break;
            case 'GIGAD':
                if ($empregadoAcesso[0]->codigoLotacaoFisica == 'NULL' || $empregadoAcesso[0]->codigoLotacaoFisica === null) {
                    $contratosGestor = DB::table('TBL_SIAF_DEMANDAS')
                                            ->select('codigoDemanda', 'nomeCliente', 'contratoCaixa', 'contratoBndes', 'valorOperacao', 'dataLote', 'status', 'tipoOperacao',
                                            DB::raw("'lote' = 'gestor'"))
                                            ->where('status', 'like', '%SUMEP%')
                                            ->orWhere('status', 'like', '%GEPOD%')
                                            ->orWhere('status', 'like', '%GESTOR%')
                                            ->where('codigoGigad', '=', $empregadoAcesso[0]->codigoLotacaoAdministrativa)                       
                                            ->get();       
                    return json_encode($contratosGestor, JSON_UNESCAPED_SLASHES);
                } else {
                    if (in_array($empregadoAcesso[0]->codigoLotacaoFisica, $this->arrayGigad)) {
                        $contratosGestor = DB::table('TBL_SIAF_DEMANDAS')
                                            ->select('codigoDemanda', 'nomeCliente', 'contratoCaixa', 'contratoBndes', 'valorOperacao', 'dataLote', 'status', 'tipoOperacao',
                                            DB::raw("'lote' = 'gestor'"))
                                            ->where('status', 'like', '%SUMEP%')
                                            ->orWhere('status', 'like', '%GEPOD%')
                                            ->orWhere('status', 'like', '%GESTOR%')
                                            ->where('codigoGigad', '=', $empregadoAcesso[0]->codigoLotacaoFisica)                        
                                            ->get();       
                        return json_encode($contratosGestor, JSON_UNESCAPED_SLASHES);
                    } elseif (in_array($empregadoAcesso[0]->codigoLotacaoFisica, $this->arraySR)) {
                        $contratosGestor = DB::table('TBL_SIAF_DEMANDAS')
                                            ->select('codigoDemanda', 'nomeCliente', 'contratoCaixa', 'contratoBndes', 'valorOperacao', 'dataLote', 'status', 'tipoOperacao',
                                            DB::raw("'lote' = 'gestor'"))
                                            ->where('status', 'like', '%SUMEP%')
                                            ->orWhere('status', 'like', '%GEPOD%')
                                            ->orWhere('status', 'like', '%GESTOR%')
                                            ->where('codigoSr', '=', $empregadoAcesso[0]->codigoLotacaoFisica)                          
                                            ->get();      
                        return json_encode($contratosGestor, JSON_UNESCAPED_SLASHES); 
                    } else {      
                        $contratosGestor = DB::table('TBL_SIAF_DEMANDAS')
                                            ->select('codigoDemanda', 'nomeCliente', 'contratoCaixa', 'contratoBndes', 'valorOperacao', 'dataLote', 'status', 'tipoOperacao',
                                            DB::raw("'lote' = 'gestor'"))
                                            ->where('status', 'like', '%SUMEP%')
                                            ->orWhere('status', 'like', '%GEPOD%')
                                            ->orWhere('status', 'like', '%GESTOR%')
                                            ->where('codigoPa', '=', $empregadoAcesso[0]->codigoLotacaoFisica)
                                            ->get();       
                        return json_encode($contratosGestor, JSON_UNESCAPED_SLASHES);  
                    }                   
                }
                break;
            default:
            $contratosGestor = DB::table('TBL_SIAF_DEMANDAS')
                                ->select('codigoDemanda', 'nomeCliente', 'contratoCaixa', 'contratoBndes', 'valorOperacao', 'dataLote', 'status', 'tipoOperacao', 'tipoOperacao',
                                DB::raw("'lote' = 'gestor'"))
                                ->where('status', 'like', '%SUMEP%')
                                ->orWhere('status', 'like', '%GEPOD%')
                                ->orWhere('status', 'like', '%GESTOR%')
                                ->get();
            return json_encode($contratosGestor, JSON_UNESCAPED_SLASHES);
                break;
        }
    }

    public function showDemandaComHistoricos($demanda)
    {
        $loteDemanda = SiafDemanda::find($demanda);
        $dataLote = $loteDemanda->dataLote;
        $dadosDemanda = SiafDemanda::with(
            ['SiafHistoricoDemanda' => function($respostaHistorico) use($dataLote) {
                json_encode($respostaHistorico->where('loteAmortizacao', $dataLote), JSON_UNESCAPED_SLASHES);
            }, 'SiafHistoricoSaldoContaAmortizacao' => function($respostaSaldo) use($dataLote) { 
                $respostaSaldo->where('loteAmortizacao', $dataLote);
            }])->where('TBL_SIAF_DEMANDAS.codigoDemanda', $demanda)->get();
        $arrayHistorico = [];
        $arraySaldo = [];
        if(isset($dadosDemanda[0]->SiafHistoricoDemanda)) {
            foreach ($dadosDemanda[0]->SiafHistoricoDemanda as $historico => $value) {  
                $dadosHistorico = array(
                    "codigoHistorico" => $value['codigoHistorico'], 
                    "dataHistorico" => $value['created_at']->format('d/m/Y H:i:s'),
                    "statusHistorico" => $value['tipoHistorico'],
                    "matriculaResponsavel" => $value['matriculaResponsavel'],
                    "unidadeResponsavel" => str_pad($value['unidadeResponsavel'], 4, '0', STR_PAD_LEFT),
                    "observacaoHistorico" => $value['historico']
                );
                array_push($arrayHistorico, $dadosHistorico);
            }
        }

        if(isset($dadosDemanda[0]->SiafHistoricoSaldoContaAmortizacao)) {
            foreach ($dadosDemanda[0]->SiafHistoricoSaldoContaAmortizacao as $saldo => $value) {             
                $dadosSaldo = array(
                    "codigoConsultaSaldo" => $value['codigoHistorico'], 
                    "dataConsultaSaldo" => $value['created_at']->format('d/m/Y H:i:s'),
                    "statusSaldo" => $value['tipoHistorico'],
                    "saldoDisponivel" => number_format($value['saldoDisponivel'], 2, ',', '.'),
                    "saldoBloqueado" => number_format($value['saldoBloqueado'], 2, ',', '.'),
                    "LimiteChequeAzul" => number_format($value['limiteChequeAzul'], 2, ',', '.'),
                    "LimiteGim" => number_format($value['limiteGim'], 2, ',', '.'),
                    "saldoTotal" => number_format($value['saldoTotal'], 2, ',', '.'),
                );
                array_push($arraySaldo, $dadosSaldo);
            }
        }

        // criação de atributo para diferenciar o dataTable a ser atualizado no método update
        $lote = new LoteAmortizacaoLiquidacaoSIAF;
        $statusGestor = ['NA SUMEP', 'SUMEP DEB_PENDENTE', 'SUMEP RESIDUO SIFBN', 'SUMEP NAO LIQUIDADO', 'GESTOR', 'RESIDUO SIFBN', 'SEM SALDO', 'SEM COMANDO SIFBN'];
        if($dadosDemanda[0]->dataLote === $lote->getDataLoteAtual()) {
            $loteDataTable = "atual";
        } elseif($dadosDemanda[0]->dataLote === $lote->getDataLoteAnterior()) {
            $loteDataTable = "anterior";
        } elseif(in_array($dadosDemanda[0]->status, $statusGestor)) {
            $loteDataTable = "gestor";
        } else {
            $loteDataTable = "concluido";
        }
        
        $jsonDados = [
            "codigoDemanda" => $dadosDemanda[0]->codigoDemanda,
            "nomeCliente" => $dadosDemanda[0]->nomeCliente,
            "cnpj" => $dadosDemanda[0]->cnpj, 
            "codigoDemanda" => $dadosDemanda[0]->codigoDemanda,
            "contratoBndes" => $dadosDemanda[0]->contratoBndes,
            "contratoCaixa" => $dadosDemanda[0]->contratoCaixa,
            "contaDebito" => $dadosDemanda[0]->contaDebito,
            "dataLote"=> $dadosDemanda[0]->dataLote,
            "valorOperacao" => number_format($dadosDemanda[0]->valorOperacao, 2, ',', '.'),
            "tipoOperacao" => $dadosDemanda[0]->tipoOperacao,
            "status" => $dadosDemanda[0]->status,
            "codigoPa" => str_pad($dadosDemanda[0]->codigoPa, 4, '0', STR_PAD_LEFT),
            "codigoSr" => $dadosDemanda[0]->codigoSr,
            "codigoGigad" => $dadosDemanda[0]->codigoGigad,
            "loteDataTable" => $loteDataTable,
            "consultaSaldo" => $arraySaldo,
            "historicoContrato" => $arrayHistorico
        ];
        if (isset($jsonDados)) {
            return json_encode($jsonDados, JSON_UNESCAPED_SLASHES);
        } else{
            return response('Demanda não encontrada', 404);
        }
    }

    public function todasSolicitacoesAmortizacaoPorLote() {
        $solicitadas = DB::select('exec sp_cte_contador_todas_demandas_siaf');
        return json_encode($solicitadas, JSON_UNESCAPED_SLASHES);      
    }

    public function todasSolicitacoesAmortizacaoUltimosDozeMeses() {
        $arrayDemandas = [];
        $listaDemandas = DB::select('
            SELECT
                [codigoDemanda]
                ,[nomeCliente]
                ,[cnpj]
                ,[contratoCaixa]
                ,[valorOperacao]
                ,[dataLote]
            FROM 
                [dbo].[TBL_SIAF_DEMANDAS]
            WHERE 
                CONVERT(DATETIME, [dataLote], 103) >= CONVERT(DATETIME, CONCAT(DATEPART(YEAR, DATEADD(YEAR, -1, GETDATE())), \'-15-\', RIGHT(\'0\' + RTRIM(MONTH(GETDATE())), 2)), 103)');
        return json_encode($listaDemandas, JSON_UNESCAPED_SLASHES); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeComValidacao(Request $request)
    {        
        $arrayDemanda = [];
        // Capturar os dados do contrato
        $contrato = SiafContrato::find($request->input("data.0.contratoCaixa"));
        // Capturar os dados do lote de amortizacao
        $lote = new LoteAmortizacaoLiquidacaoSIAF;
        // Capturar os dados do usuário da sessão
        $usuario = Empregado::find($request->session()->get('matricula'));
        // Captura a lotacao do usuario
        if ($usuario->codigoLotacaoFisica == 'NULL' || $usuario->codigoLotacaoFisica === null) {
            $lotacao = $usuario->codigoLotacaoAdministrativa;
        } else {
            $lotacao = $usuario->codigoLotacaoFisica;
        }
        
        for ($i = 0; $i < sizeof($request->input('data')); $i++) { 
            /* 
                Valida se já existe demanda cadastrada no lote atual e com status de cancelada 
                para que não seja aberto um novo protocolo e sim a atualização do protocolo cancelado
            */
            $demandaJaExiste = SiafDemanda::where('contratoCaixa', $request->input("data." . $i . ".contratoCaixa"))
                        ->whereIn('status', ['CANCELADO', 'EXCLUIDO UD', 'CADASTRADO'])
                        ->where('dataLote', $lote->getDataLoteAtual())
                        ->first();
            if ($demandaJaExiste) {
                // echo "demanda já existe (cancelada)";
                $quantidadeDemandaEmAbertoImpeditiva = SiafDemanda::all()->where('contratoCaixa', $request->input("data." . $i . ".contratoCaixa"))
                        ->whereNotIn('status', ['CANCELADO', 'EXCLUIDO UD', 'CADASTRADO'])
                        ->where('dataLote', $lote->getDataLoteAtual());
                if (count($quantidadeDemandaEmAbertoImpeditiva) > 0) {
                    return "Já existe demanda para esse contrato em aberto. não podemos abrir nova demanda.";
                } else {
                    $demanda = SiafDemanda::where('contratoCaixa', $request->input("data." . $i . ".contratoCaixa"))
                                        ->where('status', 'CANCELADO')
                                        ->where('dataLote', $lote->getDataLoteAtual())
                                        ->first();
                    $demanda->contratoBndes = $request->input("data." . $i . ".contratoBndes");
                    $demanda->contaDebito = $request->input("data." . $i . ".contaDebito");
                    $demanda->valorOperacao = $request->input("data." . $i . ".valorAmortizacao");
                    $demanda->tipoOperacao = $request->input("data." . $i . ".tipoComando");
                    $demanda->status = 'CADASTRADO';
                    $demanda->save();

                    // Recupera os dados da demanda cadastrada
                    $dadosDemandaCadastrada = SiafDemanda::find($demanda->codigoDemanda);
                    
                    // Instancia o model de  Historico da Demanda
                    $historicoDemanda = new SiafHistoricoDemanda;
                    $historicoDemanda->contratoCaixa = $dadosDemandaCadastrada->contratoCaixa;
                    $historicoDemanda->loteAmortizacao = $dadosDemandaCadastrada->dataLote;
                    $historicoDemanda->tipoHistorico = 'CADASTRO';
                    $historicoDemanda->historico = preg_replace( "/\r|\n/", "", $request->input("data." . $i . ".observacoes"));
                    $historicoDemanda->matriculaResponsavel = $usuario->matricula;
                    $historicoDemanda->unidadeResponsavel = $lotacao;
                    $historicoDemanda->save();

                    $dadosHistoricoDemanda = SiafHistoricoDemanda::find($historicoDemanda->codigoHistorico);
                    
                    // $dados = $request->input("data.".$i.".contratoCaixa"); //
                    array_push($arrayDemanda, $dadosDemandaCadastrada);
                    array_push($arrayDemanda, $dadosHistoricoDemanda);

                    $mail = new SiafPhpMailer;
                    $tipoEmail = "registroNovaDemanda";
                    $mail->enviarMensageria($usuario, $dadosDemandaCadastrada, $tipoEmail);
                }
            } else {
                // Capturar os dados do contrato
                $contratoSiaf = SiafContrato::find($request->input("data." . $i . ".contratoCaixa"));

                // Instancia o model da Demanda
                $demanda = new SiafDemanda();
                $demanda->nomeCliente = $contratoSiaf->cliente;
                $demanda->cnpj = $contratoSiaf->cnpj;
                $demanda->contratoCaixa = $request->input("data." . $i . ".contratoCaixa");
                $demanda->contratoBndes = $request->input("data." . $i . ".contratoBndes");
                $demanda->valorOperacao = $request->input("data." . $i . ".valorAmortizacao");
                $demanda->tipoOperacao = $request->input("data." . $i . ".tipoComando");
                $demanda->codigoPa = $contratoSiaf->codigoPa;
                $demanda->nomePa = $contratoSiaf->nomePa;
                $demanda->emailPa = $contratoSiaf->emailPa;
                $demanda->codigoSr = $contratoSiaf->codigoSr;
                $demanda->nomeSr = $contratoSiaf->nomeSr;
                $demanda->emailSr = $contratoSiaf->emailSr;
                $demanda->codigoGigad = $contratoSiaf->codigoGigad;
                $demanda->nomeGigad = $contratoSiaf->nomeGigad;
                $demanda->emailGigad = $contratoSiaf->emailGigad;
                $demanda->dataCadastramento = date("Y-m-d H:i:s", time());
                $demanda->dataLote = $lote->getDataLoteAtual();
                $demanda->status = 'CADASTRADO';
                $demanda->matriculaSolicitante = $usuario->matricula;
                $demanda->contaDebito = $request->input("data." . $i . ".contaDebito");
                $demanda->save();

                // Recupera os dados da demanda cadastrada
                $dadosDemandaCadastrada = SiafDemanda::find($demanda->codigoDemanda);
                
                // Instancia o model de  Historico da Demanda
                $historicoDemanda = new SiafHistoricoDemanda;
                $historicoDemanda->contratoCaixa = $dadosDemandaCadastrada->contratoCaixa;
                $historicoDemanda->loteAmortizacao = $dadosDemandaCadastrada->dataLote;
                $historicoDemanda->tipoHistorico = 'CADASTRO';
                $historicoDemanda->historico = preg_replace( "/\r|\n/", "", $request->input("data." . $i . ".observacoes"));
                $historicoDemanda->matriculaResponsavel = $dadosDemandaCadastrada->matriculaSolicitante;
                $historicoDemanda->unidadeResponsavel = $lotacao;
                $historicoDemanda->save();

                $dadosHistoricoDemanda = SiafHistoricoDemanda::find($historicoDemanda->codigoHistorico);
                
                // $dados = $request->input("data.".$i.".contratoCaixa"); //
                array_push($arrayDemanda, $dadosDemandaCadastrada);
                array_push($arrayDemanda, $dadosHistoricoDemanda);

                $mail = new SiafPhpMailer;
                $tipoEmail = "registroNovaDemanda";
                $mail->enviarMensageria($usuario, $dadosDemandaCadastrada, $tipoEmail);
            }
        }
        return $this->loteAtual($request);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function exportToExcel(Request $request)
    {  
        // return $demandasLoteExport->download('DemandasSiafAmortizacaoLiquidacao.xlsx');
        return Excel::download(new DemandasLoteExport((string) $request->dataLote), "#CONFIDENCIAL20_exporta_lote_$request->dataLote.xlsx");
    } 
}
