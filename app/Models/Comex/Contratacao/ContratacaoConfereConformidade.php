<?php

namespace App\Models\Comex\Contratacao;

use Illuminate\Database\Eloquent\Model;

class ContratacaoConfereConformidade extends Model
{
    protected $table = 'TBL_EST_CONTRATACAO_CONFERE_CONFORMIDADE';
    protected $primaryKey = 'idCheckList';

    function EsteiraContratacaoDemanda() {
        return $this->belongsTo('App\Models\Comex\Contratacao\ContratacaoDemanda', 'idDemanda', 'idDemanda');
    }
}
