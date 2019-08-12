<?php

use App\Models\Bndes\NovoSiaf\AtendimentoWebListaAtividades;

/* ROTAS GERAIS CEOPC */
Route::get('/', function () {return 'Hello World';});
Route::get('/phpinfo', function () {return view('phpinfo');});
Route::get('/consumo-carbon/{demanda}', function ($demanda) {
    $contrato = App\Models\Comex\Contratacao\ContratacaoDemanda::find($demanda);
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
        Route::get('/contratacao', 'Comex\Contratacao\ContratacaoController@index');
    });


    // ACOMPANHAR
    Route::group(['prefix' => 'acompanhar'], function(){
        //Minhas Demandas
        Route::get('/minhas-demandas', function () {
            return view('Comex.Acompanhar.minhasDemandas');
        })->name('minhasDemandas');
        // Retorna as demandas do usuário da sessão
        Route::get('/demandas-usuario','Comex\DistribuicaoController@indexApi');
        //Protocolos Contratacao - Todos
        Route::get('/contratacao', function () {
            return view('Comex.Acompanhar.protocolosContratacao');
        });
        //Protocolos Contratacao Formalizados
        Route::get('/formalizados', function () {
            return view('Comex.Acompanhar.protocolosContratacaoFormalizados');
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

        /* CONSULTAS */        
        // Consulta de demanda de contratacao
        Route::get('/consultar/{demanda}', function ($demanda) {
            return view('Comex.Solicitar.Contratacao.consultar')->with('demanda', $demanda);
        });
        // Consulta a produção diária dos empregados nessa atividade
        Route::get('/resumo/conformidade', 'Comex\Contratacao\ResumoDiarioContratacaoController@resumoDiarioConformidadeContratacao');
        

        /* FASE 1 - CONFORMIDADE DOCUMENTAL */
        // cadastro de demanda de contratacao
        Route::post('/cadastrar', 'Comex\Contratacao\ContratacaoController@store');
        // atualização de demanda
        Route::put('/cadastrar', 'Comex\Contratacao\ContratacaoController@store');
        // retorna os dados de demanda
        Route::get('/cadastrar/{demanda}', 'Comex\Contratacao\ContratacaoController@show');
        // Analise de demanda de contratacao
        Route::get('/analisar/{demanda}', function ($demanda) {
            return view('Comex.Solicitar.Contratacao.analisar')->with('demanda', $demanda);
        });
        // Complemento de demanda de contratacao
        Route::put('/complemento/{demanda}', 'Comex\Contratacao\ContratacaoController@complementaConformidadeContratacao' );
        Route::get('/complemento/dados/{demanda}', 'Comex\Contratacao\ContratacaoController@showComplemento' );
        Route::get('/complementar/{demanda}', function ($demanda) {
            return view('Comex.Solicitar.Contratacao.complementar')->with('demanda', $demanda);
        });

        
        /* FASE 2 - ENVIO DE CONTRATO E LIQUIDAÇÃO DA OPERACAO NA CELIT */
        // Formaliza demanda de contratacao
        Route::get('/formalizar/{demanda}', function ($demanda) {
            return view('Comex.Solicitar.Contratacao.formalizar')->with('demanda', $demanda);
        });
        Route::post('/formalizar', 'Comex\Contratacao\ContratacaoFaseLiquidacaoOperacaoController@store');
        // Confirma assinatura de contrato
        Route::get('/confirmar/{demanda}', function ($demanda) {
            return view('Comex.Solicitar.Contratacao.confirmar')->with('demanda', $demanda);
        });
        // Listar demandas que estão na fase 2
        Route::get('/formalizar', 'Comex\Contratacao\ContratacaoFaseLiquidacaoOperacaoController@index');       


        /* FASE 3 - CONFORMIDADE CONTRATO ASSINADO */
        // Envia contrato assinado
        Route::get('/assinar/{demanda}', function ($demanda) {
            return view('Comex.Solicitar.Contratacao.assinar')->with('demanda', $demanda);
        });
        // Verifica assinatura de contrato
        Route::get('/verificar/{demanda}', function ($demanda) {
            return view('Comex.Solicitar.Contratacao.verificar')->with('demanda', $demanda);
        });
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


