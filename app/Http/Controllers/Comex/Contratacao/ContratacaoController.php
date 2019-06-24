<?php

namespace App\Http\Controllers\Comex\Contratacao;

use App\Models\Contratacao;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContratacaoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Comex.Contratacao.index');
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
        $dadosFinal = [];
        $dadosFileInvoice = [];
        $uploadInvoice = [];
        $dados = $request->all();
        array_push($dadosFinal, $dados);
        $fileTeste = $request->file('uploadInvoice');
        dd(sizeof($fileTeste));
        foreach ($fileTeste as $file) {
            
            foreach ($file as $key => $value) {
                
                // $uploadInvoice[$file] = [
                //     "nomeOriginal" => $value->getClientOriginalName(),
                // ];
                // array_push($dadosFileInvoice, $uploadInvoice[$file]);
            }
            
        }
        array_push($dadosFinal, $dadosFileInvoice);
        // if ($fileTeste[0]) {
        //     $uploadInvoice = [
        //         "nomeOriginal" => $fileTeste[0]->getClientOriginalName(),
        //     ];
        //     array_push($dadosFinal, $uploadInvoice);
        // } else {
        //     return 'não reconheceu';
        // }
        if ($request->hasFile('uploadAutorizacaoSr')) {
            $uploadAutorizacaoSr = $request->file('uploadAutorizacaoSr');
            array_push($dadosFinal, $uploadAutorizacaoSr);
        }
        

        return json_encode($dadosFinal, JSON_UNESCAPED_SLASHES);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Contratacao  $contratacao
     * @return \Illuminate\Http\Response
     */
    public function show(Contratacao $contratacao)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Contratacao  $contratacao
     * @return \Illuminate\Http\Response
     */
    public function edit(Contratacao $contratacao)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contratacao  $contratacao
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contratacao $contratacao)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contratacao  $contratacao
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contratacao $contratacao)
    {
        //
    }
}
