<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empregado extends Model
{
    protected $table = 'tbl_EMPREGADOS';
    protected $primaryKey = 'matricula';
    public $incrementing = false;
    protected $fillable = 
        [
            'nomeCompleto',
            'primeiroNome',
            'dataNascimento',
            'codigoFuncao',
            'nomeFuncao',
            'codigoLotacaoAdministrativa',
            'nomeLotacaoAdministrativa',
            'codigoLotacaoFisica',
            'nomeLotacaoFisica',
        ];
    public function acessoEmpregado()
    {
        return $this->hasOne('App\AcessaEmpregado', 'matricula', 'matricula');
    }
}
