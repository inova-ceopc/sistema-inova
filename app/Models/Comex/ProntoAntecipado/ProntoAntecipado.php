<?php

namespace App\Models\Comex\ProntoAntecipado;

use Illuminate\Database\Eloquent\Model;

class ProntoAntecipado extends Model
{
    protected $table = 'tbl_ANT_DEMANDAS';
    protected $primaryKey = 'CO_CONF';
    public $incrementing = false;
    public $timestamps = false;
}
