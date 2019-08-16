<?php

namespace App\Http\Controllers\Comex\Contratacao;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Exceptions\Handler;
use App\Http\Controllers\Comex\Contratacao\Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;
use App\Models\Comex\Contratacao\ContratacaoDemanda;
use App\Models\Comex\Contratacao\ContratacaoConfereConformidade;
use App\Models\Comex\Contratacao\ContratacaoContaImportador;
use App\Models\Comex\Contratacao\ContratacaoHistorico;
use App\Models\Comex\Contratacao\ContratacaoUpload;
use App\Classes\Comex\Contratacao\ContratacaoPhpMailer;
use App\RelacaoAgSrComEmail;

class ContratacaoFaseVerificaContratoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listagemDemandasParaConformidadeContrato = [];

        $demandaContratacao = ContratacaoDemanda::with(['EsteiraContratacaoUpload', 'EsteiraContratacaoUpload.EsteiraDadosContrato'])->whereIn('statusAtual', ['LIQUIDADA', 'CANCELADA', 'CONTRATO PENDENTE'])->get();

        for ($i = 0; $i < sizeof($demandaContratacao); $i++) {
            if ($demandaContratacao[$i]->cpf === null) {
                $cpfCnpj = $demandaContratacao[$i]->cnpj;
            } else {
                $cpfCnpj = $demandaContratacao[$i]->cpf;
            }
            if ($demandaContratacao[$i]->agResponsavel === null) {
                $unidadeDemandante = $demandaContratacao[$i]->srResponsavel;
            } else {
                $unidadeDemandante = $demandaContratacao[$i]->agResponsavel;
            }
            
            // CAPTURA DADOS DA DEMANDA
            $idDemanda = $demandaContratacao[$i]->idDemanda;
            $nomeCliente = $demandaContratacao[$i]->nomeCliente;
            $tipoOperacao = $demandaContratacao[$i]->tipoOperacao;
            $valorOperacao = $demandaContratacao[$i]->valorOperacao;
            $dataLiquidacao = $demandaContratacao[$i]->dataLiquidacao;
            $statusAtual = $demandaContratacao[$i]->statusAtual;

            // CAPTURA DA DADOS DO CONTRATO 
            for ($j = 0; $j < sizeof($demandaContratacao[$i]->EsteiraContratacaoUpload); $j++) { 
                $naoPodeAnalisarContrato = 0;
                switch ($demandaContratacao[$i]->EsteiraContratacaoUpload[$j]->tipoDoDocumento) {
                    case 'CONTRATACAO':
                    case 'ALTERACAO':
                    case 'CANCELAMENTO':
                        if ($demandaContratacao[$i]->EsteiraContratacaoUpload[$j]->EsteiraDadosContrato->temRetornoRede == 'SIM' and $demandaContratacao[$i]->EsteiraContratacaoUpload[$j]->EsteiraDadosContrato->statusContrato != 'CONTRATO ASSINADO') {
                            $naoPodeAnalisarContrato++;
                        }
                        break;
                }
            }
            if ($naoPodeAnalisarContrato == 0) {
                $demandaPendente = array(
                    'idDemanda' => $idDemanda,
                    'nomeCliente' => $nomeCliente,
                    'cpfCnpj' => $cpfCnpj,
                    'tipoOperacao' => $tipoOperacao,
                    'valorOperacao' => $valorOperacao,
                    'dataLiquidacao' => $dataLiquidacao,
                    'unidadeDemandante' => $unidadeDemandante,
                    'statusAtual' => $statusAtual
                );
                array_push($listagemDemandasParaConformidadeContrato, $demandaPendente);
            }
        }
        return json_encode(array('demandasParaConformidadeContrato' => $listagemDemandasParaConformidadeContrato), JSON_UNESCAPED_SLASHES);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comex\Contratacao\ContratacaoDadosContrato $dadosContrato
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(ContratacaoDadosContrato $dadosContrato, $id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function update(Request $request, $id)
    { 

    }
}
