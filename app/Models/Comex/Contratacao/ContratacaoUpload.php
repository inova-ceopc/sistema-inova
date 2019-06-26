<?php

namespace App\Models\Comex\Contratacao;

use Illuminate\Database\Eloquent\Model;

class ContratacaoUpload extends Model
{
    protected $table = 'TBL_EST_CONTRATACAO_LINK_UPLOADS';
    protected $primaryKey = 'idUploadLink';

    function EsteiraContratacaoDemanda() {
        return $this->belongsTo('App\Models\Comex\Contratacao\ContratacaoDemanda', 'idDemanda', 'idDemanda');
    }
}
