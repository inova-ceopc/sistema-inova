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
                    $request->session()->flash('corMensagem', 'warning');
                    $request->session()->flash('tituloMensagem', "Acesso negado!");
                    $request->session()->flash('corpoMensagem', "Você não possui perfil para analisar demandas.");
                    return redirect('esteiracomex/');
                } else {
                    $demanda = ContratacaoDemanda::find($request->demanda);
                    if ($demanda->responsavelCeopc != $request->session()->get('matricula') || $demanda->responsavelCeopc == null || $demanda->responsavelCeopc == 'NULL') {
                        $request->session()->flash('corMensagem', 'warning');
                        $request->session()->flash('tituloMensagem', "Protocolo #" . str_pad($request->demanda, 4, '0', STR_PAD_LEFT) . " | não pode ser acessado!");
                        $request->session()->flash('corpoMensagem', "A demanda não foi distribuida ou está distribuida para outro analista. Para tratar essa demanda, solicite a distribuição para sua matrícula.");                         
                        return redirect('esteiracomex/contratacao/consulta/' . $request->demanda);
                    } elseif ($demanda->statusAtual == 'INCONFORME') {
                        $request->session()->flash('corMensagem', 'warning');
                        $request->session()->flash('tituloMensagem', "Protocolo #" . str_pad($request->demanda, 4, '0', STR_PAD_LEFT) . " | não pode ser acessado!");
                        $request->session()->flash('corpoMensagem', "A demanda ainda está INCONFORME. Aguarde a correção da rede para tratá-la novamente.");                         
                        return redirect('esteiracomex/contratacao/consulta/' . $request->demanda);
                    } else {
                        $demanda->statusAtual = 'EM ANALISE';
                        $demanda->save();
                    }
                }
                break;
            case 'esteiracomex/distribuir':             
                if ($request->session()->get('unidadeEmpregadoEsteiraComex') != '5459') {
                    $request->session()->flash('corMensagem', 'warning');
                    $request->session()->flash('tituloMensagem', "Acesso negado!");
                    $request->session()->flash('corpoMensagem', "Você não tem perfil para distribuir demandas.");
                    return redirect('esteiracomex/');
                } // elseif ($request->session()->get('acessoEmpregadoEsteiraComex') != 'GESTOR') {
                //     $request->session()->flash('corMensagem', 'warning'); 
                //     $request->session()->flash('tituloMensagem', "Acesso negado!"); 
                //     $request->session()->flash('corpoMensagem', "Você não tem perfil para distribuir demandas.");            
                //     return redirect('esteiracomex/');
                // } 
                break;
            // RESTINGIR ACESSO DA 5459
            case 'esteiracomex/contratacao':
                if ($request->session()->get('unidadeEmpregadoEsteiraComex') == '5459') {
                    $request->session()->flash('corMensagem', 'warning');
                    $request->session()->flash('tituloMensagem', "Acesso negado!");
                    $request->session()->flash('corpoMensagem', "Você não tem perfil para cadastrar novas demandas.");
                    return redirect('esteiracomex/');
                }
                break;
            case 'esteiracomex/contratacao/complemento/':
                if ($request->session()->get('unidadeEmpregadoEsteiraComex') == '5459') {
                    $request->session()->flash('corMensagem', 'warning');
                    $request->session()->flash('tituloMensagem', "Acesso negado!");
                    $request->session()->flash('corpoMensagem', "Você não tem perfil para editar essa demanda.");
                    return redirect('esteiracomex/');
                } else {
                    $demanda = ContratacaoDemanda::find($request->demanda);
                    if ($demanda->statusAtual != 'INCONFORME') {
                        $request->session()->flash('corMensagem', 'warning');
                        $request->session()->flash('tituloMensagem', "Protocolo #" . str_pad($request->demanda, 4, '0', STR_PAD_LEFT) . " | não pode ser modificado!");
                        $request->session()->flash('corpoMensagem', "A demanda ainda está em tratamento. Aguarde a finalização da análise.");
                        return redirect('esteiracomex/contratacao/consulta/' . $request->demanda);
                    }
                }
                break;
        }
        return $next($request);
    }
}
