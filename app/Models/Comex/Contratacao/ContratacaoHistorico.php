<?php

namespace App\Models\Comex\Contratacao;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class ContratacaoHistorico extends Model
{
    protected $table = 'TBL_EST_CONTRATACAO_HISTORICO';
    protected $primaryKey = 'idHistorico';
    public $timestamps = false;

    function EsteiraContratacaoDemanda() {
        return $this->belongsTo('App\Models\Comex\Contratacao\ContratacaoDemanda', 'idDemanda', 'idDemanda');
    }

    public static function RetornaMatriculaQueCadastrou($idDemanda) {
        // echo ($idDemanda) . PHP_EOL;
        // $matriculaCadastro = DB::select("
        //     SELECT
        //         [responsavelStatus] 
        //     FROM 
        //         [TBL_EST_CONTRATACAO_HISTORICO]
        //     WHERE 
        //         [idDemanda] = '" . $idDemanda . "' AND [tipoStatus] = 'CADASTRO'
        //     ");
        // echo ($matriculaCadastro[0]->responsavelStatus);
        // return ($matriculaCadastro);

        $matriculaCadastro = DB::select("
            SELECT
                [nomeCompleto]
            FROM
                [TBL_EMPREGADOS]
            INNER JOIN
                [TBL_EST_CONTRATACAO_HISTORICO]
            ON
                [TBL_EMPREGADOS].matricula = [TBL_EST_CONTRATACAO_HISTORICO].responsavelStatus
            WHERE
                [TBL_EST_CONTRATACAO_HISTORICO].[idDemanda] = '" . $idDemanda . "' AND [TBL_EST_CONTRATACAO_HISTORICO].[tipoStatus] = 'CADASTRO'
            ");
        echo ($matriculaCadastro[0]->nomeCompleto);
        return ($matriculaCadastro);
    }
}
