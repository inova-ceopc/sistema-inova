<?php

namespace App\Models\Comex\Contratacao;

use Illuminate\Database\Eloquent\Model;

class ContratacaoUpload extends Model
{
    protected $table = 'TBL_EST_CONTRATACAO_LINK_UPLOADS';
    protected $primaryKey = 'idUploadLink';
    public $timestamps = false;

    function EsteiraContratacaoDemanda() {
        return $this->belongsTo('App\Models\Comex\Contratacao\ContratacaoDemanda', 'idDemanda', 'idDemanda');
    }

    function EsteiraDadosContrato() {
        return $this->hasOne('App\Models\Comex\Contratacao\ContratacaoDadosContrato', 'idUploadContratoSemAssinatura', 'idUploadLink');
    }
}
