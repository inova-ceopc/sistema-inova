<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// use Illuminate\Support\Facades\DB;
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
// Route::prefix('esteiracomex')->group(function(){
Route::group(['prefix' => 'esteiracomex', 'middleware' => ['controleDemandasEsteira']], function(){
    
    // HOME
    Route::get('/', function () {
        return view('Comex.Home.index');
    });//->middleware('controleDemandasEsteira');
    Route::get('/perfil-acesso-esteira', function () {
        return view('Comex.cadastroPerfil');
    });

    /* ESTEIRA CONTRATACAO */
    
    // cadastro de demanda de contratacao
    Route::resource('/contratacao', 'Comex\Contratacao\ContratacaoController');
    // Route::post('contratacao','Comex\Contratacao\ContratacaoController@store');

    // Analise de demanda de contratacao
    Route::get('contratacao/analisar/{demanda}', function ($demanda) {
        return view('Comex.Solicitar.Contratacao.analisar')->with('demanda', $demanda);
    });

    // Complemento de demanda de contratacao
    Route::put('contratacao/complemento/{demanda}', 'Comex\Contratacao\ContratacaoController@complementaConformidadeContratacao' );
    Route::get('contratacao/complemento/dados/{demanda}', 'Comex\Contratacao\ContratacaoController@showComplemento' );
    Route::get('contratacao/complementar/{demanda}', function ($demanda) {
        return view('Comex.Solicitar.Contratacao.complementar')->with('demanda', $demanda);
    });

    // Consulta de demanda de contratacao
    Route::get('contratacao/consultar/{demanda}', function ($demanda) {
        return view('Comex.Solicitar.Contratacao.consultar')->with('demanda', $demanda);
    });
    
    // Formaliza demanda de contratacao
    Route::get('contratacao/formalizar/{demanda}', function ($demanda) {
        return view('Comex.Solicitar.Contratacao.formalizar')->with('demanda', $demanda);
    });

    // Confirma assinatura de contrato
    Route::get('contratacao/confirmar/{demanda}', function ($demanda) {
        return view('Comex.Solicitar.Contratacao.confirmar')->with('demanda', $demanda);
    });

    // Envia contrato assinado
    Route::get('contratacao/assinar/{demanda}', function ($demanda) {
        return view('Comex.Solicitar.Contratacao.assinar')->with('demanda', $demanda);
    });

    // Verifica assinatura de contrato
    Route::get('contratacao/verificar/{demanda}', function ($demanda) {
        return view('Comex.Solicitar.Contratacao.verificar')->with('demanda', $demanda);
    });

    Route::get('contratacao/resumo/conformidade', 'Comex\Contratacao\ResumoDiarioContratacaoController@resumoDiarioConformidadeContratacao');
   
    // ACOMPANHAMENTOS

    //Minhas Demandas
    Route::get('acompanhar/minhas-demandas', function () {
        return view('Comex.Acompanhar.minhasDemandas');
    })->name('minhasDemandas');

    //Protocolos Contratacao - Todos
    Route::get('acompanhar/contratacao', function () {
        return view('Comex.Acompanhar.protocolosContratacao');
    });

    //Protocolos Contratacao Formalizados
    Route::get('acompanhar/formalizados', function () {
        return view('Comex.Acompanhar.protocolosContratacaoFormalizados');
    });

    // DISTRIBUIR
    Route::get('distribuir', 'Comex\DistribuicaoController@index')->name('distribuir.index');
    Route::put('distribuir/{demanda}', 'Comex\DistribuicaoController@update');
    
    // Indicadores Antecipados
    Route::get('indicadores/antecipados', function () {
        return view('Comex.Indicadores.antecipados');
    });

    // VIEW INDICADORES DE PAINEL-MATRIZ - COMEX
    Route::get('indicadores/painel-matriz', function () {
        return view('Indicadores.painel');
    });


    Route::get('indicadores/painel-matriz/ordens-recebidas', 'Comex\Indicadores\ControllerPainelMatriz@index');
    Route::get('indicadores/painel-matriz/resumo-acc-ace-mensal', 'Comex\Indicadores\ControllerPainelMatriz@resumoAccAceMensal');
    Route::get('indicadores/painel-matriz/resumo-acc-ace-30dias', 'Comex\Indicadores\ControllerPainelMatriz@resumoAccAceUltimos30dias');

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

    // Cadastra email para envio notificação de chegada de OP
    Route::get('solicitacoes/cadastraemailop', function () {
        return view('Comex.CadastraEmailOp.index');
    });

    // Indicadores comex CEOPC
    Route::get('indicadores/comex', function () {
        return view('Comex.Indicadores.comex');
    });

    
});

/* ROTAS BNDES */
Route::prefix('bndes')->group(function(){
    /* NOVOSIAF */   
    Route::get('siaf-amortizacao-liquidacao', function () {
        return view('Bndes.NovoSiaf.index');
    });
});


