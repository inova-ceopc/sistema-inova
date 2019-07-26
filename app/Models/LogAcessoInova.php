<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogAcessoInova extends Model
{
    protected $table = 'TBL_INOVA_LOG_ACESSOS';
    protected $primaryKey = 'idLog';
    public $timestamps = false;
}
