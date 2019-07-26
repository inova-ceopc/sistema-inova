<?php

namespace App\Http\Controllers\Comex\Contratacao;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ResumoDiarioContratacao extends Controller
{
    public function resumoDiarioConformidadeContratacao ()
    {
        $resumo = DB::select('exec sp_comex_contratacao_resumo_diario_conformidade_contratacao');
        dd($resumo);
    }
}
