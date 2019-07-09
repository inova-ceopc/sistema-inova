<?php

namespace App\Http\Middleware;

use Closure;

class ValidaAcessoRotaEsteiraComex
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
        // dd($request->path());
        switch(preg_replace('/[0-9]+/', '', $request->path())) {
            // RESTRINGIR ACESSO DE UNIDADES DE FORA DA 5459
            case 'esteiracomex/contratacao/analise/':
            case 'esteiracomex/distribuir':
                if ($request->session()->get('unidadeEmpregadoEsteiraComex') != '5459') {
                    $request->session()->flash(
                        'acessoNegado', 
                        "Acesso negado!"
                    ); 
                    return redirect('esteiracomex/');
                }
                break;

            // RESTINGIR ACESSO DA 5459
            case 'esteiracomex/contratacao':
            case 'esteiracomex/contratacao/complemento/':
                if ($request->session()->get('unidadeEmpregadoEsteiraComex') == '5459') {
                    $request->session()->flash(
                        'acessoNegado', 
                        "Acesso negado!"
                    ); 
                    return redirect('esteiracomex/');
                }
                break;
        }
        return $next($request);
    }
}
