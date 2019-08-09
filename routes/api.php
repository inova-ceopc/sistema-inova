<?php

use Illuminate\Http\Request;
use App\Classes\Bndes\NovoSiaf\LoteAmortizacaoLiquidacaoSIAF;
use App\Classes\Bndes\NovoSiaf\TransfereDadosBaseSiga;

/* ROTAS UTILIZADAS EM TODOS OS SISTEMAS CEOPC */
    Route::get('sistemas/v1/dados_empregado', 'Sistemas\EmpregadoController@index');
    Route::get('sistemas/v1/dados_empregado/{matricula}', 'Sistemas\EmpregadoController@show');

/* ROTAS UTILIZADAS EM PROJETOS ESPECIFICOS */

    /* ROTAS BNDES */

        /* NOVOSIAF */
            Route::resource('bndes/v1/siaf_contratos', 'Bndes\NovoSiaf\SiafContratoController');
            Route::get('bndes/v3/siaf_contratos', 'Bndes\NovoSiaf\SiafContratoController@indexSimplificadaComQuerySeparada');
            // Route::get('bndes/v2/siaf_contratos', 'Bndes\NovoSiaf\SiafContratoController@indexComConsultaDiretoNoModal');
            Route::get('bndes/v1/siaf_amortizacoes_lote_atual', 'Bndes\NovoSiaf\SiafDemandaController@loteAtual');
            Route::get('bndes/v1/siaf_amortizacoes_lote_anterior', 'Bndes\NovoSiaf\SiafDemandaController@loteAnterior');
            Route::get('bndes/v1/siaf_contratos_gestor', 'Bndes\NovoSiaf\SiafDemandaController@contratosComGestor');
            Route::get('bndes/v1/siaf_amortizacoes/{demanda}', 'Bndes\NovoSiaf\SiafDemandaController@show')->where('demanda', '[0-9]+');
            Route::post('bndes/v1/siaf_amortizacoes', 'Bndes\NovoSiaf\SiafDemandaController@store');
            Route::post('bndes/v2/siaf_amortizacoes', 'Bndes\NovoSiaf\SiafDemandaController@storeComValidacao');
            Route::get('bndes/v2/siaf_amortizacoes/{demanda}', 'Bndes\NovoSiaf\SiafDemandaController@showDemandaComHistoricos')->where('demanda', '[0-9]+');
            Route::put('bndes/v2/siaf_amortizacoes/{demanda}', 'Bndes\NovoSiaf\SiafDemandaController@update')->where('demanda', '[0-9]+');
            Route::get('bndes/v1/lista_solicitacoes_por_lotes', 'Bndes\NovoSiaf\SiafDemandaController@todasSolicitacoesAmortizacaoPorLote');
            Route::get('bndes/v1/lista_solicitacoes_ultimos_doze_meses', 'Bndes\NovoSiaf\SiafDemandaController@todasSolicitacoesAmortizacaoUltimosDozeMeses');
            Route::get('bndes/v1/exporta_lote_para_excel/{dataLote}', 'Bndes\NovoSiaf\SiafDemandaController@exportToExcel');
            Route::get('bndes/v1/dados_lote', function() {
                $lote = new LoteAmortizacaoLiquidacaoSIAF;
                echo $lote;
            });