<?php

namespace App\Models\Comex\Contratacao;

use Illuminate\Database\Eloquent\Model;

class ContratacaoDadosContrato extends Model
{
    protected $table = 'TBL_EST_CONTRATACAO_CONFORMIDADE_CONTRATO';
    protected $primaryKey = 'idContrato';
    public $timestamps = false;

    function EsteiraContratacaoUpload() {
        return $this->hasOne('App\Models\Comex\Contratacao\ContratacaoUpload', 'idUploadLink', 'idUploadContrato');
    }
}