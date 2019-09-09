<?php

use App\Models\Bndes\NovoSiaf\AtendimentoWebListaAtividades;

/* ROTAS GERAIS CEOPC */
Route::get('/', function () {return 'Hello World';});
Route::get('/phpinfo', function () {return view('phpinfo');});
Route::get('/consumo-carbon/{demanda}', function ($demanda) {
    $contrato = App\Models\Comex\Contratacao\ContratacaoDadosContrato::find($demanda);
    // dd($contrato);
    return view('consumoCarbon', compact('contrato'));
});
Route::fallback(function(){return response()->view('errors.404', [], 404);});

/* ROTAS ESTEIRA COMEX */
Route::group(['prefix' => 'esteiracomex', 'middleware' => ['controleDemandasEsteira']], function(){
    
    // HOME
    Route::get('/', function () {
        return view('Comex.Home.index');
    });
    Route::get('/perfil-acesso-esteira', function () {
        return view('Comex.cadastroPerfil');
    });


    /* SOLICITAR */
    Route::group(['prefix' => 'solicitar'], function(){
        // Cadastra email para envio notificação de chegada de OP
        Route::get('/cadastraemailop', function () {
            return view('Comex.CadastraEmailOp.index');
        });

        // cadastro de demanda de contratacao
        Route::get('/contratacao', 'Comex\Contratacao\ContratacaoFaseConformidadeDocumentalController@index');
    });


    // ACOMPANHAR
    Route::group(['prefix' => 'acompanhar'], function(){
        // Minhas Demandas
        Route::get('/minhas-demandas', function () {
            return view('Comex.Acompanhar.minhasDemandas');
        })->name('minhasDemandas');
        // Protocolos Contratacao - Todos
        Route::get('/contratacao', function () {
            return view('Comex.Acompanhar.protocolosContratacao');
        });
        // Protocolos Contratacao Formalizados
        Route::get('/formalizadas', function () {
            return view('Comex.Acompanhar.protocolosContratacaoFormalizados');
        });
        // View CELIT - Controle de liquidação de demandas
        Route::get('/liquidar', function () {
            return view('Comex.Acompanhar.liquidar');
        });
    });


    // DISTRIBUIR
    Route::group(['prefix' => 'gerenciar'], function(){
        // Distribuir demandas
        Route::get('/distribuir', 'Comex\DistribuicaoController@index')->name('distribuir.index');
        // Atualizar o responsavel pela demanda
        Route::put('/distribuir/{demanda}', 'Comex\DistribuicaoController@update');
        // retorna a lista de demandas para distribuir
        Route::get('/listar-demandas-para-distribuir','Comex\DistribuicaoController@indexApiTodasAsDemandas');
    });

    
    /* ESTEIRA CONTRATACAO */
    Route::group(['prefix' => 'contratacao'], function(){

        /* ROTAS AJAX(GET) */ 
            // FASE 1 - CONFORMIDADE DOCUMENTAL
                // Retorna a lista de demandas de acordo com o usuário da sessão
                Route::get('/demandas-usuario','Comex\DistribuicaoController@indexApi');
                // Retorna a produção diária dos empregados na atividade de contratação
                Route::get('/resumo/conformidade', 'Comex\Contratacao\ResumoDiarioContratacaoController@resumoDiarioConformidadeContratacao');
                // Retorna os dados da demanda
                Route::get('/cadastrar/{demanda}', 'Comex\Contratacao\ContratacaoFaseConformidadeDocumentalController@show');
                // Retorna os dados da demanda para complementar (rede)
                Route::get('/complemento/dados/{demanda}', 'Comex\Contratacao\ContratacaoFaseConformidadeDocumentalController@showComplemento' );
            // FASE 2 - ENVIO DE CONTRATO E LIQUIDAÇÃO DA OPERACAO NA CELIT
                // Retorna lista de demandas que estão disponíveis para envio de contrato/cobrança de confirmação da rede
                Route::get('/formalizar', 'Comex\Contratacao\ContratacaoFaseLiquidacaoOperacaoController@index');
                // Retorna lista de demandas que estão pendentes de confirmação de assinatura
                // Route::get('/formalizar/pendentes-de-retorno', 'Comex\Contratacao\ContratacaoFaseLiquidacaoOperacaoController@listagemDemandasControleDeRetorno');
                // Retorna dados da demanda, com relação de contratos para confirmação de assinatura
                // Route::get('/formalizar/dados/{demanda}', 'Comex\Contratacao\ContratacaoFaseLiquidacaoOperacaoController@show');
                // Retorna lista de demandas que estão disponíveis para envio de contrato assinado - REDE
                Route::get('/formalizar/contratos-assinados', 'Comex\Contratacao\ContratacaoFaseLiquidacaoOperacaoController@listagemDemandasComContratosAssinadosPendentesDeEnvio');
                // Retorna lista de contratos assinados que estão pendentes de upload - REDE
                Route::get('/formalizar/contratos-assinados/dados/{demanda}', 'Comex\Contratacao\ContratacaoFaseLiquidacaoOperacaoController@listagemContratosPendentesUpload');
                // Retorna lista de contratos sem verificação de conformidade - CEOPA
                Route::get('/formalizar/contratos-assinados/{demanda}', 'Comex\Contratacao\ContratacaoFaseLiquidacaoOperacaoController@listagemDemandasDisponiveisParaConformidadeContratoAssinado');
                // Retorna lista de demandas para liquidar - CELIT
                Route::get('/liquidar/listar-contratos', 'Comex\Contratacao\ContratacaoFaseLiquidacaoOperacaoController@listagemDemandasParaLiquidar');
    

        /* CONSULTA DE DEMANDA DE CONTRATAÇÃO - TODAS AS FASES */
        Route::get('/consultar/{demanda}', function ($demanda) {
            return view('Comex.Solicitar.Contratacao.consultar')->with('demanda', $demanda);
        });


        /* FASE 1 - CONFORMIDADE DOCUMENTAL */
            // cadastro de demanda de contratacao
            Route::post('/cadastrar', 'Comex\Contratacao\ContratacaoFaseConformidadeDocumentalController@store');
            // View de analise de demanda de contratacao
            Route::get('/analisar/{demanda}', function ($demanda) {
                return view('Comex.Solicitar.Contratacao.analisar')->with('demanda', $demanda);
            });
            // atualização de demanda
            Route::put('/cadastrar/{demanda}', 'Comex\Contratacao\ContratacaoFaseConformidadeDocumentalController@update');
            // View de complementar demanda
            Route::get('/complementar/{demanda}', function ($demanda) {
                return view('Comex.Solicitar.Contratacao.complementar')->with('demanda', $demanda);
            });
            // Atualiza demanda de contratacao por parte da rede
            Route::put('/complemento/{demanda}', 'Comex\Contratacao\ContratacaoFaseConformidadeDocumentalController@complementaConformidadeContratacao' );

        
        /* FASE 2 - ENVIO DE CONTRATO E LIQUIDAÇÃO DA OPERACAO NA CELIT */
            // View para formalizar demanda de contratacao
            Route::get('/formalizar/{demanda}', function ($demanda) {
                return view('Comex.Solicitar.Contratacao.formalizar')->with('demanda', $demanda);
            });
            // Realiza o envio do contrato para a rede
            Route::post('/formalizar/{demanda}', 'Comex\Contratacao\ContratacaoFaseLiquidacaoOperacaoController@store');
            // View que confirma assinatura de contrato
            // Route::get('/confirmar/{demanda}', function ($demanda) {
            //     return view('Comex.Solicitar.Contratacao.confirmar')->with('demanda', $demanda);
            // }); 
            // Realiza o update com a confirmação do contrato
            // Route::put('/assinar/{demanda}', 'Comex\Contratacao\ContratacaoFaseLiquidacaoOperacaoController@update'); 
            // View que lista a relação contrato pendentes de upload
            Route::get('/carregar-contrato-assinado/{demanda}', function ($demanda) {
                return view('Comex.Solicitar.Contratacao.assinar')->with('demanda', $demanda);
            });
            // Método de Upload de contrato assinado
            Route::put('/carregar-contrato-assinado/{demanda}', 'Comex\Contratacao\ContratacaoFaseLiquidacaoOperacaoController@update');
            // View que lista os contrato(s) assinado(s) da demanda
            Route::get('/verificar-contrato-assinado/{demanda}', function ($demanda) {
                return view('Comex.Solicitar.Contratacao.verificar')->with('demanda', $demanda);
            });
            // Método update de conformidade de contrato assinado
            Route::put('/verificar-contrato-assinado/{demanda}', 'Comex\Contratacao\ContratacaoFaseLiquidacaoOperacaoController@conformidadeContratoAssinado');
            // Realiza o update para liquidar do contrato
            Route::put('/liquidar/{demanda}', 'Comex\Contratacao\ContratacaoFaseLiquidacaoOperacaoController@liquidarDemanda');            
    });
    
  
    // INDICADORES
    Route::group(['prefix' => 'indicadores'], function(){
        // Indicadores Antecipados
        Route::get('/antecipados', function () {
            return view('Comex.Indicadores.antecipados');
        });

        // VIEW INDICADORES DE PAINEL-MATRIZ - COMEX
        Route::get('/painel-matriz', function () {
            return view('Indicadores.painel');
        });

        Route::get('/painel-matriz/ordens-recebidas', 'Comex\Indicadores\ControllerPainelMatriz@index');
        Route::get('/painel-matriz/resumo-acc-ace-mensal', 'Comex\Indicadores\ControllerPainelMatriz@resumoAccAceMensal');
        Route::get('/painel-matriz/resumo-acc-ace-30dias', 'Comex\Indicadores\ControllerPainelMatriz@resumoAccAceUltimos30dias');

        // Indicadores comex CEOPC
        Route::get('/comex', function () {
            return view('Comex.Indicadores.comex');
        });
    });

    /*
        1. Planejamento Rotas Indicadores Comex:
            1.1. Qtde de ordens de pagamento recebidas por dia
            1.2. Qtde de clientes com e-mail cadastrado
            1.3. ACC/ACE:
                 Rotina de Liquidação de contratos (cadastradas, canceladas, liquidadas)
            1.4. Pronto Imp/Exp Antecipados:
                 Rotina de conformidade (cadastradas, canceladas, conformes)
                 Rotina de cobrança, reiteração e bloqueio de contratos
            1.5. Realize/Conquiste:
                 TMA ACC/ACE 
    */

    // Route::get('/uploadfile','UploadFileController@index');
    // Route::post('/uploadfile','UploadFileController@showUploadFile');
});

/* ROTAS BNDES */
Route::prefix('bndes')->group(function(){
    /* NOVOSIAF */   
    Route::get('siaf-amortizacao-liquidacao', function () {
        return view('Bndes.NovoSiaf.index');
    });
});

Route::prefix('indicadores')->group(function(){
    /* NOVOSIAF */   
    Route::get('painel', function () {
        return view('Indicadores.index');
    });
    Route::get('painel-matriz', function () {
        return view('Indicadores.layout');
    });
});


// ROTA FERRAMENTA MIDDLE

Route::prefix('siorm')->group(function(){

    // 
    Route::get('historico-exportador', function(){
        return view('Siorm.index');
    });
    
    Route::get('gera-excel','Siorm\HistoricoExportadorController@exportaExcel')
    ->name('geraPlanilhaHistoricoExportador');

    Route::post('historico-exportador', 
    'Siorm\HistoricoExportadorController@emiteHistoricoExportador');

    Route::get('mensagem-erro', function(){
        return view('Siorm.error');
    });

    // nao rolou mandar e voltar ver com o Chuman a opc de fazer via blade; 
});

