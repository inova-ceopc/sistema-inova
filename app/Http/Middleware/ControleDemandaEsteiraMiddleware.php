<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Classes\Comex\ControleDemandasEsteira;

class ControleDemandaEsteiraMiddleware
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
        $controleDemandasEsteira = new ControleDemandasEsteira($request);
        $request->session()->flash('dataAtualizacaoBaseSuint', $controleDemandasEsteira->getDataAtualizacaoBaseSuint());
        $request->session()->flash('contagemDemandasCadastradasLiquidacao', $controleDemandasEsteira->getContagemDemandasCadastradasLiquidacao());
        $request->session()->flash('contagemDemandasCadastradasAntecipadosCambioPronto', $controleDemandasEsteira->getContagemDemandasCadastradasAntecipadosCambioPronto());
        $request->session()->flash('contagemDemandasDistribuidasLiquidacao', $controleDemandasEsteira->getContagemDemandasDistribuidasLiquidacao());
        $request->session()->flash('contagemDemandasEmAnaliseLiquidacao', $controleDemandasEsteira->getContagemDemandasEmAnaliseLiquidacao());
        $request->session()->flash('contademDemandasDistribuidasAntecipadoCambioPronto', $controleDemandasEsteira->getContademDemandasDistribuidasAntecipadoCambioPronto()); 
        // dd($request->session()->all());
        return $next($request);
    }
}