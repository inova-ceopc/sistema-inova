<?php

namespace App\Http\Controllers\Comex\Contratacao;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ResumoDiarioContratacaoController extends Controller
{
    public function resumoDiarioConformidadeContratacao ()
    {
        if (env('DB_CONNECTION') === 'sqlsrv') {
            $resumo = DB::select('exec sp_comex_contratacao_resumo_diario_conformidade_contratacao');
            return json_encode($resumo);
        } else {
            $resumo = array(
                ['responsavelCeopc' => 'c080709', 'nomeCompleto' => 'JOSIAS DO NASCIMENTO FLORIANO', 'prontoImportacao' => '0', 'prontoImportacaoAntecipado' => '0', 'prontoExportacao' => '0', 'prontoExportacaoAntecipado' => '0', 'total' => '0'],
                ['responsavelCeopc' => 'c079258', 'nomeCompleto' => 'LAURA DE NATALE SALVAGNIN', 'prontoImportacao' => '0', 'prontoImportacaoAntecipado' => '0', 'prontoExportacao' => '0', 'prontoExportacaoAntecipado' => '0', 'total' => '0'],
                ['responsavelCeopc' => 'c052972', 'nomeCompleto' => 'MARIA BEATRIZ GARCIA RUSSO', 'prontoImportacao' => '0', 'prontoImportacaoAntecipado' => '0', 'prontoExportacao' => '0', 'prontoExportacaoAntecipado' => '0', 'total' => '0'],
                ['responsavelCeopc' => 'c133633', 'nomeCompleto' => 'MARIO ALBERTO LABRONICI BAIARDI', 'prontoImportacao' => '0', 'prontoImportacaoAntecipado' => '0', 'prontoExportacao' => '0', 'prontoExportacaoAntecipado' => '0', 'total' => '0'],
            );
            return json_encode($resumo);
        }
    }
}
