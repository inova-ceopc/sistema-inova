<?php

namespace App\Models\Comex\AccAceLiquidacao;

use Illuminate\Database\Eloquent\Model;

class ResumoDtLiquidacao extends Model
{
    //
    protected $table = 'tbl_RESUMO_DT_LIQUIDACAO';
    protected $primaryKey = 'CO_LIQ';
    public $incrementing = false;
    public $timestamps = false;

}
