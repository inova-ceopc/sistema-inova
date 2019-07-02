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
Route::get('/consumo-json-multinivel', function () {return view('consumoJsonMultinivel');});
Route::fallback(function(){return response()->view('errors.404', [], 404);});

/* ROTAS ESTEIRA COMEX */
Route::prefix('esteiracomex')->group(function(){
    
    // HOME
    Route::get('/', function () {
        return view('Comex.Home.index');
    });//->middleware('controleDemandasEsteira');
    Route::get('/perfil-acesso-esteira', function () {
        return view('Comex.cadastroPerfil');
    });
    
    

    /* ESTEIRA CONTRATACAO */
    
    Route::get('contratacao', 'Comex\Contratacao\ContratacaoController@index')->middleware('controleDemandasEsteira');


    // Route::get('contratacao/analise', function () {
    //     return view('Comex.Contratacao.analise');
    // });
    Route::get('contratacao/analise/{demanda}', function ($demanda) {
        return view('Comex.Contratacao.analise')->with('demanda', $demanda);
    });

    Route::post('contratacao/analise', 'UploadFileControllerCarlos@store');

    // Route::get('contratacao/consulta', function () {
    //     return view('Comex.Contratacao.consulta');
    // });
    Route::get('contratacao/consulta/{demanda}', function ($demanda) {
        return view('Comex.Contratacao.consulta')->with('demanda', $demanda);
    });
    Route::post('contratacao/consulta', 'UploadFileControllerCarlos@store');
    
    
    // Indicadores Antecipados
    Route::get('indicadores/antecipados', function () {
        return view('Comex.Indicadores.antecipados');
    });

    // Distribuir demandas
    Route::get('distribuir', function () {
        return view('Comex.Distribuir.index');
    });

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

/* ROTAS BNDES SIAF */
Route::prefix('bndes')->group(function(){
    /* NOVOSIAF */   
    Route::get('siaf-amortizacao-liquidacao', function () {
        return view('Bndes.NovoSiaf.index');
    });
});


