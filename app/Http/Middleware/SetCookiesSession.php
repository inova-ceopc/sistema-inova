<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Classes\Geral\Ldap;
use App\Empregado;

class SetCookiesSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (env('DB_CONNECTION') === 'sqlite') {
            if (!$request->session()->has('matricula')) {
                $empregado = Empregado::find('c112346');
                $request->session()->put([
                    'matricula' => $empregado->matricula,
                    'nomeCompleto' => $empregado->nomeCompleto,
                    'primeiroNome' => $empregado->primeiroNome,
                    'nomeFuncao' => $empregado->nomeFuncao,
                    if ($empregado->codigoLotacaoAdministrativa === null) {
                        'codigoLotacao' => $empregado->codigoLotacaoFisica,
                        'nomeLotacao' => $empregado->nomeLotacaoFisica,
                    } else {
                        'codigoLotacao' => $empregado->codigoLotacaoAdministrativa,
                        'nomeLotacao' => $empregado->nomeLotacaoAdministrativa,
                    }
                    'codigoLotacaoAdministrativa' => $empregado->codigoLotacaoAdministrativa,
                    'nomeLotacaoAdministrativa' => $empregado->nomeLotacaoAdministrativa,
                    'codigoLotacaoFisica' => $empregado->codigoLotacaoFisica,
                    'nomeLotacaoFisica' => $empregado->nomeLotacaoFisica,
                    'acessoEmpregado' => $empregado->acessoEmpregado->nivelAcesso
                ]); 
                // dd(session()->all());
            } // else {
            //     dd('já está settado');
            // }
        } else {
            if (!$request->session()->has('matricula')) {
                $usuario = new Ldap;
                $empregado = Empregado::find($usuario->getMatricula());
                $request->session()->put([
                    'matricula' => $empregado->matricula,
                    'nomeCompleto' => $empregado->nomeCompleto,
                    'primeiroNome' => $empregado->primeiroNome,
                    'nomeFuncao' => $empregado->nomeFuncao,
                    if ($empregado->codigoLotacaoAdministrativa === null) {
                        'codigoLotacao' => $empregado->codigoLotacaoFisica,
                        'nomeLotacao' => $empregado->nomeLotacaoFisica,
                    } else {
                        'codigoLotacao' => $empregado->codigoLotacaoAdministrativa,
                        'nomeLotacao' => $empregado->nomeLotacaoAdministrativa,
                    }
                    'codigoLotacaoAdministrativa' => $empregado->codigoLotacaoAdministrativa,
                    'nomeLotacaoAdministrativa' => $empregado->nomeLotacaoAdministrativa,
                    'codigoLotacaoFisica' => $empregado->codigoLotacaoFisica,
                    'nomeLotacaoFisica' => $empregado->nomeLotacaoFisica,
                    'acessoEmpregado' => $empregado->acessoEmpregado->nivelAcesso
                ]); 
            } 
        }
        return $next($request);
    }
}
