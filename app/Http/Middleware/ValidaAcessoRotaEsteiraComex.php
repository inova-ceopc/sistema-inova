<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Comex\Contratacao\ContratacaoDemanda;

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
        switch(preg_replace('/[0-9]+/', '', $request->path())) {
            // RESTRINGIR ACESSO DE UNIDADES DE FORA DA 5459
            case 'esteiracomex/contratacao/analise/':
                if ($request->session()->get('unidadeEmpregadoEsteiraComex') != '5459') {
                    $request->session()->flash(
                        'acessoNegado', 
                        "Acesso negado!"
                    ); 
                    return redirect('esteiracomex/');
                } else {
                    $demanda = ContratacaoDemanda::find($request->demanda);
                    $demanda->statusAtual = 'EM ANALISE';
                    $demanda->save();
                }
                break;
            case 'esteiracomex/distribuir':             
                if ($request->session()->get('unidadeEmpregadoEsteiraComex') != '5459') {
                    $request->session()->flash(
                        'acessoNegado', 
                        "Acesso negado!"
                    ); 
                    return redirect('esteiracomex/');
                } // elseif ($request->session()->get('acessoEmpregadoEsteiraComex') != 'GESTOR') {
                //     $request->session()->flash(
                //         'acessoNegado', 
                //         "Acesso negado!"
                //     ); 
                //     return redirect('esteiracomex/');
                // } 
                break;

            // RESTINGIR ACESSO DA 5459
            case 'esteiracomex/contratacao':
                if ($request->session()->get('unidadeEmpregadoEsteiraComex') == '5459') {
                    $request->session()->flash(
                        'acessoNegado', 
                        "Acesso negado!"
                    ); 
                    return redirect('esteiracomex/');
                }
                break;
            case 'esteiracomex/contratacao/complemento/':
                if ($request->session()->get('unidadeEmpregadoEsteiraComex') == '5459') {
                    $request->session()->flash(
                        'acessoNegado', 
                        "Acesso negado!"
                    ); 
                    return redirect('esteiracomex/');
                } else {
                    $demanda = ContratacaoDemanda::find($request->demanda);
                    if ($demanda->statusAtual != 'INCONFORME') {
                        $request->session()->flash(
                            'complementoAcessoNegado', 
                            "Protocolo #" . str_pad($request->demanda, 4, '0', STR_PAD_LEFT)
                        ); 
                        return redirect('esteiracomex/contratacao/consulta/' . $request->demanda);
                    }
                }
                break;
        }
        return $next($request);
    }
}
