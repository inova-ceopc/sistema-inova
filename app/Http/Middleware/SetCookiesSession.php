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
            // $urlBaseSistemaInova = substr($_SERVER['REQUEST_URI'], 0, strpos($_SERVER['REQUEST_URI'], '/', strpos($_SERVER['REQUEST_URI'], '/')+1));
            if (!$request->session()->has('matricula')) {
                $empregado = Empregado::find('c104061');
                // if($urlBaseSistemaInova === "/bndes") {
                //     $request->session()->put('acessoEmpregadoBndes', $empregado->acessoEmpregado->nivelAcesso);
                // } else {
                //     $perfilAcesso = new CadastraAcessoEsteiraComex($empregado);
                //     $request->session()->put('acessoEmpregadoEsteiraComex', $empregado->esteiraComexPerfilEmpregado->nivelAcesso);
                // }
                $request->session()->put([
                    'matricula' => $empregado->matricula,
                    'nomeCompleto' => $empregado->nomeCompleto,
                    'primeiroNome' => $empregado->primeiroNome,
                    'nomeFuncao' => $empregado->nomeFuncao,
                    'codigoLotacaoAdministrativa' => $empregado->codigoLotacaoAdministrativa,
                    'nomeLotacaoAdministrativa' => $empregado->nomeLotacaoAdministrativa,
                    'codigoLotacaoFisica' => $empregado->codigoLotacaoFisica,
                    'nomeLotacaoFisica' => $empregado->nomeLotacaoFisica,
                    'acessoEmpregadoBndes' => $empregado->acessoEmpregado->nivelAcesso,
                    'acessoEmpregadoEsteiraComex' => $empregado->esteiraComexPerfilEmpregado->nivelAcesso
                ]);
            } // else {
            //     dd('já está settado');
            // }
        } else {
            if (!$request->session()->has('matricula')) {
                $usuario = new Ldap;
                $empregado = Empregado::find($usuario->getMatricula());
                // if($urlBaseSistemaInova === "/bndes") {
                //     ;
                // } else {
                //     $perfilAcesso = new CadastraAcessoEsteiraComex($empregado);
                //     $request->session()->put('acessoEmpregadoEsteiraComex', $empregado->esteiraComexPerfilEmpregado->nivelAcesso);
                // }
                $request->session()->put([
                    'matricula' => $empregado->matricula,
                    'nomeCompleto' => $empregado->nomeCompleto,
                    'primeiroNome' => $empregado->primeiroNome,
                    'nomeFuncao' => $empregado->nomeFuncao,
                    'codigoLotacaoAdministrativa' => $empregado->codigoLotacaoAdministrativa,
                    'nomeLotacaoAdministrativa' => $empregado->nomeLotacaoAdministrativa,
                    'codigoLotacaoFisica' => $empregado->codigoLotacaoFisica,
                    'nomeLotacaoFisica' => $empregado->nomeLotacaoFisica,
                    'acessoEmpregadoBndes' => $empregado->acessoEmpregado->nivelAcesso,
                    'acessoEmpregadoEsteiraComex' => $empregado->esteiraComexPerfilEmpregado->nivelAcesso
                ]); 
            }
        }
        // dd(session()->all());
        return $next($request);
    }
}
