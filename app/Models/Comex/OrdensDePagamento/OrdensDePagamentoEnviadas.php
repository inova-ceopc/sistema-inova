<?php

namespace App\Models\Comex\OrdensDePagamento;

use Illuminate\Database\Eloquent\Model;

class OrdensDePagamentoEnviadas extends Model
{
    protected $table = 'tbl_SIEXC_OPES_ENVIADAS';
    public $incrementing = false;
    public $timestamps = false;
}
