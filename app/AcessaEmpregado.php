<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AcessaEmpregado extends Model
{
    protected $table = 'tbl_ACESSA_EMPREGADOS';
    protected $primaryKey = 'matricula';
    public $incrementing = false;

    public function empregados()
    {
        return $this->belongsTo('App\Empregado', 'matricula', 'matricula');
    }
}
