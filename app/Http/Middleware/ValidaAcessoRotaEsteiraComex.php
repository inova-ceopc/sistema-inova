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
        if ($request->session()->get('acessoEmpregadoEsteiraComex') != env('NOME_NOSSA_UNIDADE')) {
            $request->session()->flash(
                'acessoNegado', 
                "Acesso negado!"
            ); 
            
            return redirect('esteiracomex/');
        }
        
        return $next($request);
    }
}
