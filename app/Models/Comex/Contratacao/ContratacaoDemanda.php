<?php

namespace App\Models\Comex\Contratacao;

use Illuminate\Database\Eloquent\Model;

class ContratacaoDemanda extends Model
{
    protected $table = 'TBL_EST_CONTRATACAO_DEMANDAS';
    protected $primaryKey = 'idDemanda';

    function EsteiraContratacaoContaImportador() {
        return $this->hasOne('App\Models\Comex\Contratacao\ContratacaoContaImportador', 'idDemanda', 'idDemanda');
    }

    function EsteiraContratacaoHistorico() {
        return $this->hasMany('App\Models\Comex\Contratacao\ContratacaoHistorico', 'idDemanda', 'idDemanda');
    }

    function EsteiraContratacaoConfereConformidade() {
        return $this->hasMany('App\Models\Comex\Contratacao\ContratacaoConfereConformidade', 'idDemanda', 'idDemanda');
    }

    function EsteiraContratacaoUpload() {
        return $this->hasMany('App\Models\Comex\Contratacao\ContratacaoUpload', 'idDemanda', 'idDemanda');
    }
}
