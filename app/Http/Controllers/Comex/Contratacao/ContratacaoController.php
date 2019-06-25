<?php

namespace App\Http\Controllers\Comex\Contratacao;

use App\Models\Contratacao;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Exceptions\Handler;
use App\Http\Controllers\Comex\Contratacao\Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;

class ContratacaoController extends Controller
{
    public $pastaPrimeiroNivel;
    public $pastaSegundoNivel;
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
        $this->criaDiretorioUploadArquivo($request);
        $dadosFinal = [];
        $dados = $request->all();
        array_push($dadosFinal, ["dadosDemanda" => $dados]);
        $arrayArquivosUpload = $this->validaDadosArquivoUpload($request, $dadosFinal);
        array_push($dadosFinal, $arrayArquivosUpload);
        // dd($dadosFinal);
        // // foreach ($fileTeste as $file) {
            
        // //     foreach ($file as $key => $value) {
                
        // //         // $uploadInvoice[$file] = [
        // //         //     "nomeOriginal" => $value->getClientOriginalName(),
        // //         // ];
        // //         // array_push($dadosFileInvoice, $uploadInvoice[$file]);
        // //     }
            
        // // }
        // array_push($dadosFinal, $dadosFileInvoice);
        // // if ($fileTeste[0]) {
        // //     $uploadInvoice = [
        // //         "nomeOriginal" => $fileTeste[0]->getClientOriginalName(),
        // //     ];
        // //     array_push($dadosFinal, $uploadInvoice);
        // // } else {
        // //     return 'não reconheceu';
        // // }
        // if ($request->hasFile('uploadAutorizacaoSr')) {
        //     $uploadAutorizacaoSr = $request->file('uploadAutorizacaoSr');
        //     array_push($dadosFinal, $uploadAutorizacaoSr);
        // }
        

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

    /**
     * @return \Illuminate\Http\Response
     */
    public function validaDadosArquivoUpload($request, $dadosFinal)
    {
        $dadosFileInvoice = [];
        $arrayInvoice = [];
        $fileInvoice = $request->file('uploadInvoice');
        // if (in_array($fileInvoice[0]->getClientOriginalExtension(), array('pdf', 'doc', 'docx', 'txt', 'zip', 'jpg', 'png', 'gif'))) {
            for ($i = 0; $i < sizeof($fileInvoice); $i++) { 
                $novoNomeArquivo = $fileInvoice[$i]->storeAs($this->pastaSegundoNivel, 'INVOICE_' . $i . '.' . $fileInvoice[$i]->getClientOriginalExtension());
                $linkArquivo = Storage::disk('local')->getAdapter()->getPathPrefix() . $novoNomeArquivo;
                $dadosFileInvoice = array(
                    'arquivosInvoice' . $i => array(
                        "nome" => $fileInvoice[$i]->getClientOriginalName(),
                        "extensao" => $fileInvoice[$i]->getClientOriginalExtension(),
                        "caminhoOriginal" => $fileInvoice[$i]->getRealPath(),
                        "novoNomeArquivo" => $novoNomeArquivo,
                        "linkArquivo" => $linkArquivo,
                    )
                );
                // dd($current_date_time = Carbon::now()->toDateTimeString());
                
                // dd($dadosFileInvoice);

                
                array_push($arrayInvoice, $dadosFileInvoice);
            }
        // } else {
        //     return response('Extensão não permitida', 403);
        // }
        return $arrayInvoice;
    }

    public function criaDiretorioUploadArquivo($request)
    {
        if ($request->tipoPessoa === "PF") {
            $this->pastaPrimeiroNivel = "/CPF" . str_replace(".","", str_replace("-", "", $request->cpf));
        } else {
            $this->pastaPrimeiroNivel = "/CNPJ" . str_replace(".","", str_replace("/", "", $request->cnpj));
        }
        $this->pastaSegundoNivel = $this->pastaPrimeiroNivel . '/PROTOCOLO_001';
        // dd(array(
        //     "pastaRaiz" => $this->pastaRaiz,
        //     "pastaPrimeiroNivel" => $this->pastaPrimeiroNivel,
        //     "pastaSegundoNivel" => $this->pastaSegundoNivel,
        // ));
        if (!file_exists($this->pastaPrimeiroNivel)) {
            Storage::makeDirectory($this->pastaPrimeiroNivel, $mode = 0777, true, true);
        }
        if (!file_exists($this->pastaSegundoNivel)) {
            Storage::makeDirectory($this->pastaSegundoNivel, $mode = 0777, true, true);
        }
    }
}
