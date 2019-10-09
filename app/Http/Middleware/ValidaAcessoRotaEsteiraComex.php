<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Comex\Contratacao\ContratacaoDemanda;

class ValidaAcessoRotaEsteiraComex
{
    public $arrayMatriculaPermitidasAmbienteDesenvolvimento = [
        'c111710' // Chuman
        ,'c142765' // Carlos
        ,'c079436' // Vlad
        ,'c095060' // Denise
        ,'c032579' // Euclidio
        ,'c122954'
    ];
    
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // dd($this->arrayMatriculaPermitidasAmbienteDesenvolvimento);
        
        // if (!in_array($request->session()->get('matricula'), $this->arrayMatriculaPermitidasAmbienteDesenvolvimento)) {
        //     return redirect('https://inova.ceopc.hom.caixa/' . $request->path());
        // } else {
            
            if ($request->session()->get('codigoLotacaoFisica') == null || $request->session()->get('codigoLotacaoFisica') === "NULL") {
                $lotacao = $request->session()->get('codigoLotacaoAdministrativa');
            } else {
                $lotacao = $request->session()->get('codigoLotacaoFisica');
            }

            switch(preg_replace('/[0-9]+/', '', $request->path())) {

                /* ROTAS ESTEIRA COMEX */

                    /* SOLICITAR */

                        // cadastro de demanda de contratacao
                        case 'esteiracomex/solicitar/contratacao':
                            // if ($request->session()->get('unidadeEmpregadoEsteiraComex') == '5459') {
                            //     $request->session()->flash('corMensagem', 'warning');
                            //     $request->session()->flash('tituloMensagem', "Acesso negado!");
                            //     $request->session()->flash('corpoMensagem', "Você não tem perfil para cadastrar novas demandas.");
                            //     return redirect('esteiracomex/');
                            // }
                            break;


                    /* ACOMPANHAR */

                        // Protocolos Contratacao Formalizados
                        case 'esteiracomex/acompanhar/formalizadas':
                            if ($request->session()->get('unidadeEmpregadoEsteiraComex') != '5459') {
                                $request->session()->flash('corMensagem', 'warning');
                                $request->session()->flash('tituloMensagem', "Acesso negado!");
                                $request->session()->flash('corpoMensagem', "Você não tem perfil para acessar essa página.");
                                return redirect('esteiracomex/');
                            }
                            break;

                        // View CELIT - Controle de liquidação de demandas
                        // case 'esteiracomex/acompanhar/liquidar':
                        //     if ($request->session()->get('unidadeEmpregadoEsteiraComex') != '7854') {
                        //         $request->session()->flash('corMensagem', 'warning');
                        //         $request->session()->flash('tituloMensagem', "Acesso negado!");
                        //         $request->session()->flash('corpoMensagem', "Você não tem perfil para acessar essa página.");
                        //         return redirect('esteiracomex/');
                        //     }
                        //     break;


                    /* GERENCIAR */

                        // Distribuir demandas
                        case 'esteiracomex/gerenciar/distribuir':             
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


                    /* CONTRATACÃO */

                        /* FASE 1 - CONFORMIDADE DOCUMENTAL */

                            // View de analise de demanda de contratacao
                            case 'esteiracomex/contratacao/analisar/':
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
                                        $request->session()->flash('corpoMensagem', "A demanda não foi distribuida ou está distribuida para outro analista." . PHP_EOL . "Para tratar essa demanda, solicite a distribuição para sua matrícula.");                         
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

                            // View de complementar demanda
                            case 'esteiracomex/contratacao/complementar/':
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

                        /* FASE 2 - ENVIO DE CONTRATO E LIQUIDAÇÃO DA OPERACAO NA CELIT */

                            // View para envio de minuta para rede
                            case 'esteiracomex/contratacao/formalizar/':
                                if ($request->session()->get('unidadeEmpregadoEsteiraComex') != '5459') {
                                    $request->session()->flash('corMensagem', 'warning');
                                    $request->session()->flash('tituloMensagem', "Acesso negado!");
                                    $request->session()->flash('corpoMensagem', "Você não tem perfil para acessar essa página.");
                                    return redirect('esteiracomex/');
                                }
                                break;

                            // View que confirma assinatura de contrato
                            case 'esteiracomex/contratacao/confirmar/':
                                if ($request->session()->get('unidadeEmpregadoEsteiraComex') == '5459') {
                                    $request->session()->flash('corMensagem', 'warning');
                                    $request->session()->flash('tituloMensagem', "Acesso negado!");
                                    $request->session()->flash('corpoMensagem', "Você não tem perfil para acessar essa página.");
                                    return redirect('esteiracomex/');
                                } else {
                                    $demanda = ContratacaoDemanda::find($request->demanda);
                                    if ($request->session()->get('acessoEmpregadoEsteiraComex') == "SR") {
                                        if ($demanda->srResponsavel != $lotacao) {
                                            $request->session()->flash('corMensagem', 'warning');
                                            $request->session()->flash('tituloMensagem', "Protocolo #" . str_pad($request->demanda, 4, '0', STR_PAD_LEFT) . " | não pode ser acessado!");
                                            $request->session()->flash('corpoMensagem', "A demanda não está vinculada a sua superitendência.");                         
                                            return redirect('esteiracomex/');
                                        }                            
                                    } else {
                                        if ($demanda->agResponsavel != $lotacao) {
                                            $request->session()->flash('corMensagem', 'warning');
                                            $request->session()->flash('tituloMensagem', "Protocolo #" . str_pad($request->demanda, 4, '0', STR_PAD_LEFT) . " | não pode ser acessado!");
                                            $request->session()->flash('corpoMensagem', "A demanda não está vinculada a sua agência.");                         
                                            return redirect('esteiracomex/');
                                        }                             
                                    }
                                }
                                break;

                        /* FASE 3 - CONFORMIDADE CONTRATO ASSINADO */

                            // View que envia contrato assinado
                            case 'esteiracomex/contratacao/carregar-contrato-assinado/':
                                if ($request->isMethod('get')) {
                                    if ($request->session()->get('unidadeEmpregadoEsteiraComex') == '5459') {
                                        $request->session()->flash('corMensagem', 'warning');
                                        $request->session()->flash('tituloMensagem', "Acesso negado!");
                                        $request->session()->flash('corpoMensagem', "Você não tem perfil para acessar essa página.");
                                        return redirect('esteiracomex/');
                                    } else {
                                        $demanda = ContratacaoDemanda::find($request->demanda);
                                        if ($request->session()->get('acessoEmpregadoEsteiraComex') == "SR" and $demanda->srResponsavel != $lotacao) {
                                            $request->session()->flash('corMensagem', 'warning');
                                            $request->session()->flash('tituloMensagem', "Protocolo #" . str_pad($request->demanda, 4, '0', STR_PAD_LEFT) . " | não pode ser acessado!");
                                            $request->session()->flash('corpoMensagem', "A demanda não está vinculada a sua superitendência.");                         
                                            return redirect('esteiracomex/');                
                                        } elseif ($demanda->agResponsavel != $lotacao) {
                                            $request->session()->flash('corMensagem', 'warning');
                                            $request->session()->flash('tituloMensagem', "Protocolo #" . str_pad($request->demanda, 4, '0', STR_PAD_LEFT) . " | não pode ser acessado!");
                                            $request->session()->flash('corpoMensagem', "A demanda não está vinculada a sua agência.");                         
                                            return redirect('esteiracomex/');
                                        }
                                    }
                                } 
                                break;

                            // View que verifica contrato assinado
                            case 'esteiracomex/contratacao/verificar-contrato-assinado/':
                            if ($request->session()->get('unidadeEmpregadoEsteiraComex') != '5459') {
                                $request->session()->flash('corMensagem', 'warning');
                                $request->session()->flash('tituloMensagem', "Acesso negado!");
                                $request->session()->flash('corpoMensagem', "Você não tem perfil para acessar essa página.");
                                return redirect('esteiracomex/');
                            }
                            break;

                            
            }
            return $next($request);
        
    }
}
