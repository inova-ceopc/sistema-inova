<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AcessaEmpregado extends Model
{
    protected $table = 'TBL_ACESSA_EMPREGADOS_SISTEMAS_BNDES';
    protected $primaryKey = 'matricula';
    public $incrementing = false;

    public function empregados()
    {
        return $this->belongsTo('App\Empregado', 'matricula', 'matricula');
    }
}