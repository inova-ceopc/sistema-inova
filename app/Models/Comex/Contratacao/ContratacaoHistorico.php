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
}
