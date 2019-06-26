<?php

namespace App\Models\Comex\Contratacao;

use Illuminate\Database\Eloquent\Model;

class ContratacaoContaImportador extends Model
{
    protected $table = 'TBL_EST_CONTRATACAO_CONTA_IMPORTADOR';
    protected $primaryKey = 'idConta';
    public $timestamps = false;

    function EsteiraContratacaoDemanda() {
        return $this->belongsTo('App\Models\Comex\Contratacao\ContratacaoDemanda', 'idDemanda', 'idDemanda');
    }
}
