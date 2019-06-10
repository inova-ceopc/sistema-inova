<?php

namespace App\Models\Comex\AccAceLiquidacao;

use Illuminate\Database\Eloquent\Model;

class AccAceLiquidacao extends Model
{
    protected $table = 'tbl_LIQUIDACAO';
    protected $primaryKey = 'CO_LIQ';
    public $incrementing = false;
    public $timestamps = false;
}
