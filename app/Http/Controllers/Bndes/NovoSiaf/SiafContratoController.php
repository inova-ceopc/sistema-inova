<?php
namespace App\Http\Controllers\Bndes\NovoSiaf;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Bndes\NovoSiaf\SiafContrato;
use App\Classes\Geral\Ldap;
use App\Empregado;
use App\AcessaEmpregado;
use App\Classes\Bndes\NovoSiaf\SiafPhpMailer;
use App\Classes\Bndes\NovoSiaf\LoteAmortizacaoLiquidacaoSIAF;
use App\Http\Controllers\Sistemas\EmpregadoController;

class SiafContratoController extends Controller
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
        if ($request->input('valorAmortizacao') != null && $request->input('tipoComando') != null && $request->input('contaDebito') != null) {
            $solicitacao = array(
                "contratoBndes" => $request->input('contratoBndes'),
                "contratoCaixa" => $request->input('contratoCaixa'),
                "contaDebito" => $request->input('contaDebito'),
                "valorAmortizacao" => $request->input('valorAmortizacao'),
                "tipoComando" => $request->input('tipoComando'),
            );
            return json_encode($solicitacao);
        } else {
            return "objeto vazio";
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *  @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        if ($request->session()->get('codigoLotacaoFisica') == 'NULL' || $request->session()->get('codigoLotacaoFisica') === null) {
            $lotacaoUsuario = $request->session()->get('codigoLotacaoAdministrativa');
        } else {
            $lotacaoUsuario = $request->session()->get('codigoLotacaoFisica');
        }
        
        // $dadosContrato = Contratos::find($id);
        $dataLote = new LoteAmortizacaoLiquidacaoSIAF;
        $dadosContrato = DB::table('TBL_SIAF_CONTRATOS')
                        ->leftjoin('TBL_SIAF_DEMANDAS', 'TBL_SIAF_CONTRATOS.contratoCaixa', '=', 'TBL_SIAF_DEMANDAS.contratoCaixa')
                        ->select('TBL_SIAF_CONTRATOS.cnpj', 'TBL_SIAF_CONTRATOS.cliente', 'TBL_SIAF_CONTRATOS.contratoBndes', 'TBL_SIAF_CONTRATOS.contratoBndesFiname', 'TBL_SIAF_CONTRATOS.contratoCaixa', 'TBL_SIAF_CONTRATOS.contaDebito', 'TBL_SIAF_CONTRATOS.contaDebito')
                        ->where('TBL_SIAF_CONTRATOS.cnpj', '=', $id)
                        // ->where('TBL_SIAF_CONTRATOS.codigoPa', $lotacaoUsuario)
                        ->where(function($where) use($dataLote) {
                            $where
                                ->where('TBL_SIAF_DEMANDAS.dataLote', '=', $dataLote->getDataLoteAtual())
                                ->whereIn('TBL_SIAF_DEMANDAS.status', ['CANCELADO', 'EXCLUIDO UD'])
                                ->orWhere('TBL_SIAF_DEMANDAS.dataLote', '<>', $dataLote->getDataLoteAtual())
                                ->orWhereNull('TBL_SIAF_DEMANDAS.dataLote');
                            })
                        ->distinct()
                        ->get();
        if (isset($dadosContrato)) {
            return json_encode($dadosContrato);
        } else{
            return response('Empresa não encontrada', 404);
        }
    }

    /* TERCEIRA VERSÃO DAS ROTAS DE API DE CONTRATOS DISPONIVEIS PARA CADASTRO*/
    public function selectListaContratos($codigoUnidadeTabelaContratos, $codigoUnidadePerfilUsuario) 
    {
        $dataLote = new LoteAmortizacaoLiquidacaoSIAF;
        $listaContratos = DB::select("SELECT DISTINCT
                    TBL_SIAF_CONTRATOS.cnpj
                    ,TBL_SIAF_CONTRATOS.cliente
                FROM 
                    TBL_SIAF_CONTRATOS LEFT JOIN TBL_SIAF_DEMANDAS ON TBL_SIAF_CONTRATOS.contratoCaixa = TBL_SIAF_DEMANDAS.contratoCaixa
                WHERE 
                    $codigoUnidadeTabelaContratos = '{$codigoUnidadePerfilUsuario}'
                    AND
                    ((dataLote = '{$dataLote->getDataLoteAtual()}' AND TBL_SIAF_DEMANDAS.status IN ('EXCLUIDO UD', 'CANCELADO'))
                    OR
                    (dataLote <> '{$dataLote->getDataLoteAtual()}' AND TBL_SIAF_DEMANDAS.tipoOperacao = 'L' AND TBL_SIAF_DEMANDAS.status IN ('EXCLUIDO UD', 'CANCELADO', 'NL SEM SALDO', 'SUMEP - RESIDUO SIFBN', 'SUMEP DEB_PENDENTE', 'SUMEP - NAO LIQUIDADO', 'GESTOR', 'RESIDUO SIFBN', 'SEM SALDO', 'SEM COMANDO SIFBN'))
                    OR
                    dataLote IS NULL)
                ORDER BY TBL_SIAF_CONTRATOS.cliente");  
        return $listaContratos;
    }

    public function indexSimplificadaComQuerySeparada(Request $request)
    {
        $empregadoAcesso = json_decode(app('App\Http\Controllers\Sistemas\EmpregadoController')->index($request));     
        switch ($empregadoAcesso[0]->nivelAcesso) {
            case 'EMPREGADO_AG':
                if ($empregadoAcesso[0]->codigoLotacaoFisica == 'NULL' || $request->session()->get('codigoLotacaoFisica') === null) {   
                    // dd($empregadoAcesso[0]->codigoLotacaoFisica);
                    $listaContratos = $this->selectListaContratos('TBL_SIAF_CONTRATOS.codigoPa', $empregadoAcesso[0]->codigoLotacaoAdministrativa);                            
                    return json_encode($listaContratos, JSON_UNESCAPED_SLASHES);
                } elseif (in_array($empregadoAcesso[0]->codigoLotacaoFisica, $this->arrayGigad)) {
                    $listaContratos = $this->selectListaContratos('TBL_SIAF_CONTRATOS.codigoGigad', $empregadoAcesso[0]->codigoLotacaoFisica);
                    return json_encode($listaContratos, JSON_UNESCAPED_SLASHES);
                } elseif (in_array($empregadoAcesso[0]->codigoLotacaoFisica, $this->arraySR)) {     
                    $listaContratos = $this->selectListaContratos('TBL_SIAF_CONTRATOS.codigoSr', $empregadoAcesso[0]->codigoLotacaoFisica); 
                    return json_encode($listaContratos, JSON_UNESCAPED_SLASHES);
                } else {  
                    $listaContratos = $this->selectListaContratos('TBL_SIAF_CONTRATOS.codigoPa', $empregadoAcesso[0]->codigoLotacaoFisica);
                    return json_encode($listaContratos, JSON_UNESCAPED_SLASHES);
                }                                  
                break;
            case 'EMPREGADO_SR':
                if ($empregadoAcesso[0]->codigoLotacaoFisica == 'NULL' || $request->session()->get('codigoLotacaoFisica') === null) {
                    $listaContratos = $this->selectListaContratos('TBL_SIAF_CONTRATOS.codigoSr', $empregadoAcesso[0]->codigoLotacaoAdministrativa);
                    return json_encode($listaContratos, JSON_UNESCAPED_SLASHES);
                } elseif (in_array($empregadoAcesso[0]->codigoLotacaoFisica, $this->arrayGigad)) {
                    $listaContratos = $this->selectListaContratos('TBL_SIAF_CONTRATOS.codigoGigad', $empregadoAcesso[0]->codigoLotacaoFisica);
                    return json_encode($listaContratos, JSON_UNESCAPED_SLASHES);
                } elseif (in_array($empregadoAcesso[0]->codigoLotacaoFisica, $this->arraySR)) {
                    $listaContratos = $this->selectListaContratos('TBL_SIAF_CONTRATOS.codigoSr', $empregadoAcesso[0]->codigoLotacaoFisica);      
                    return json_encode($listaContratos, JSON_UNESCAPED_SLASHES);
                } else { 
                    $listaContratos = $this->selectListaContratos('TBL_SIAF_CONTRATOS.codigoPa', $empregadoAcesso[0]->codigoLotacaoFisica); 
                    return json_encode($listaContratos, JSON_UNESCAPED_SLASHES);
                }                                   
                break;
            case 'GIGAD':
                if ($empregadoAcesso[0]->codigoLotacaoFisica == 'NULL' || $request->session()->get('codigoLotacaoFisica') === null) {     
                    $listaContratos = $this->selectListaContratos('TBL_SIAF_CONTRATOS.codigoGigad', $empregadoAcesso[0]->codigoLotacaoAdministrativa);
                    return json_encode($listaContratos, JSON_UNESCAPED_SLASHES);
                } elseif (in_array($empregadoAcesso[0]->codigoLotacaoFisica, $this->arrayGigad)) {
                    $listaContratos = $this->selectListaContratos('TBL_SIAF_CONTRATOS.codigoGigad', $empregadoAcesso[0]->codigoLotacaoFisica);
                    return json_encode($listaContratos, JSON_UNESCAPED_SLASHES);
                } elseif (in_array($empregadoAcesso[0]->codigoLotacaoFisica, $this->arraySR)) {
                    $listaContratos = $this->selectListaContratos('TBL_SIAF_CONTRATOS.codigoSr', $empregadoAcesso[0]->codigoLotacaoFisica);
                    return json_encode($listaContratos, JSON_UNESCAPED_SLASHES);
                } else {
                    $listaContratos = $this->selectListaContratos('TBL_SIAF_CONTRATOS.codigoPa', $empregadoAcesso[0]->codigoLotacaoFisica);
                    return json_encode($listaContratos, JSON_UNESCAPED_SLASHES);
                }                   
                break;
            default:    
                $listaContratos = "";
                return json_encode($listaContratos, JSON_UNESCAPED_SLASHES);
                break;
        }
    }
}