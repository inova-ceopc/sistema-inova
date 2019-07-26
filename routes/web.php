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
Route::get('/capturanavegador', function () {return view('capturanavegador');});
Route::get('/consumo-json-multinivel', function () {return view('consumoJsonMultinivel');});
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
    
    Route::get('contratacao/demandas', function () {
        return view('Comex.Contratacao.demandas');
    });
    // cadastro de demanda
    Route::get('/contratacao/analise/{demanda}', function ($demanda) {
        return view('Comex.Contratacao.analise')->with('demanda', $demanda);
    });
    Route::resource('/contratacao', 'Comex\Contratacao\ContratacaoController');
    // Route::post('contratacao','Comex\Contratacao\ContratacaoController@store');
    
    Route::get('contratacao/analise/{demanda}', function ($demanda) {
        return view('Comex.Contratacao.analise')->with('demanda', $demanda);
    });

    // Route::post('contratacao/analise', 'UploadFileControllerCarlos@store');

    Route::put('contratacao/complemento/{demanda}', 'Comex\Contratacao\ContratacaoController@complementaConformidadeContratacao' );
    Route::get('contratacao/complemento/dados/{demanda}', 'Comex\Contratacao\ContratacaoController@showComplemento' );


    Route::get('contratacao/complemento/{demanda}', function ($demanda) {
        return view('Comex.Contratacao.complemento')->with('demanda', $demanda);
    });

    Route::get('contratacao/consulta/{demanda}', function ($demanda) {
        return view('Comex.Contratacao.consulta')->with('demanda', $demanda);
    });
    // Route::post('contratacao/consulta', 'UploadFileControllerCarlos@store');
    
    Route::get('contratacao/formaliza/{demanda}', function ($demanda) {
        return view('Comex.Contratacao.formaliza')->with('demanda', $demanda);
    });

    Route::get('contratacao/resumo/conformidade', 'Comex\Contratacao\ResumoDiarioContratacao@resumoDiarioConformidadeContratacao');
    
    // Indicadores Antecipados
    Route::get('indicadores/antecipados', function () {
        return view('Comex.Indicadores.antecipados');
    });

    Route::get('indicadores/painel-matriz', function () {
        return view('Indicadores.painel-matriz');
    });


    // Distribuir demandas
    Route::get('distribuir', 'Comex\DistribuicaoController@index')->name('distribuir.index');
    Route::put('distribuir/{demanda}', 'Comex\DistribuicaoController@update');


    // ACOMPANHAMENTOS
    Route::get('distribuir/demandas', function () {
        return view('Comex.Distribuir.demandas');
    })->name('minhasDemandas');



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


