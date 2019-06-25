<?php

namespace App\Models\Comex\Contratacao;

use Illuminate\Database\Eloquent\Model;

class ContratacaoHistorico extends Model
{
    protected $table = 'TBL_EST_CONTRATACAO_HISTORICO';
    protected $primaryKey = 'idHistorico';

    function EsteiraContratacaoDemanda() {
        return $this->belongsTo('App\Models\Comex\Contratacao\ContratacaoDemanda', 'idDemanda', 'idDemanda');
    }
}
