<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class UploadFileControllerCarlos extends Controller
{
    public function index() {

        return view('Comex.Contratacao.index');
    }
    
    public function create(Request $request) {
        

        // $file = $request->file('uploadArquivos');
     
        // //Display File Name
        // echo 'File Name: '.$file->getClientOriginalName();
        // echo '<br>';
     
        // //Display File Extension
        // echo 'File Extension: '.$file->getClientOriginalExtension();
        // echo '<br>';
     
        // //Display File Real Path
        // echo 'File Real Path: '.$file->getRealPath();
        // echo '<br>';
     
        // //Display File Size
        // echo 'File Size: '.$file->getSize();
        // echo '<br>';
     
        // //Display File Mime Type
        // echo 'File Mime Type: '.$file->getMimeType();
     
        // //Move Uploaded File
        // $destinationPath = '../../js/contratacao/upload-teste';
        // $file->move($destinationPath,$file->getClientOriginalName());

    }

    public function store(Request $request) {

        $demanda = $request->all();
        var_dump($demanda->save());
        return response()->json(['responseText' => 'Cadastrado com sucesso!'], 200);
        return redirect('/distribuir/demandas');
        
    }

    public function edit(Request $request) {


    }
    
    public function show(Request $request) {


    }

}
?>