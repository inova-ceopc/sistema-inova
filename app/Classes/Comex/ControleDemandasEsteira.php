<?php

namespace App\Classes\Comex;

use Illuminate\Support\Facades\DB;

class ControleDemandasEsteira
{
    private $dataAtualizacaoBaseSuint = '04/07/2019'; //$datadeatualizacao
    private $contagemDemandasCadastradasLiquidacao; //$badget_cadastrada
    private $contagemDemandasCadastradasAntecipadosCambioPronto; //$badget_cadastrada_antecipados
    private $contagemDemandasDistribuidasLiquidacao; //$badget_usuario
    private $contagemDemandasEmAnaliseLiquidacao; //$badget_usuario_em
    private $contademDemandasDistribuidasAntecipadoCambioPronto; //$badget_cadastrada_antecipados_usuario
    private $contagemDemandasCadastradasContratacao;
    private $contagemDemandasDistribuidasContratacao;

    //$dataAtualizacaoBaseSuint
    public function getDataAtualizacaoBaseSuint()
    {
        return $this->dataAtualizacaoBaseSuint;
    }

    /**
     *
     * @param  \Illuminate\Http\Request  $request
     * 
     */
    public function __construct($request)
    {
        // $this->setContagemDemandasCadastradasLiquidacao();
        // $this->setContagemDemandasCadastradasAntecipadosCambioPronto();
        // $this->setContagemDemandasDistribuidasLiquidacao($request->session()->get('matricula'));
        // $this->setContagemDemandasEmAnaliseLiquidacao($request->session()->get('matricula'));
        // $this->setContademDemandasDistribuidasAntecipadoCambioPronto($request->session()->get('matricula'));
        $this->setContagemDemandasCadastradasContratacao($request->session()->get('matricula'));
        $this->setContagemDemandasDistribuidasContratacao($request->session()->get('matricula'));       
    }

    public function __toString()
    {
        return json_encode(array(
            "dataAtualizacaoBaseAccAce" => $this->getDataAtualizacaoBaseSuint(),
            // "contagemDemandasCadastradasLiquidacao" => $this->getContagemDemandasCadastradasLiquidacao(),
            // "contagemDemandasCadastradasAntecipadosCambioPronto" => $this->getContagemDemandasCadastradasAntecipadosCambioPronto(),
            // "contagemDemandasDistribuidasLiquidacao" => $this->getContagemDemandasDistribuidasLiquidacao(),
            // "contagemDemandasEmAnaliseLiquidacao" => $this->getContagemDemandasEmAnaliseLiquidacao(),
            // "contagemDemandasDistribuidasAntecipadosCambioPronto" => $this->getContademDemandasDistribuidasAntecipadoCambioPronto(),
            "contagemDemandasCadastradasContratacao" => $this->getContagemDemandasCadastradasContratacao(),
            "contagemDemandasDistribuidasContratacao" => $this->getContagemDemandasDistribuidasContratacao()          
          
        ), JSON_UNESCAPED_SLASHES);
    }

    //$contagemDemandasCadastradasLiquidacao;
    public function getContagemDemandasCadastradasLiquidacao()
    {
        return $this->contagemDemandasCadastradasLiquidacao;
    }
    public function setContagemDemandasCadastradasLiquidacao()
    {
        $contador = DB::select("
            SELECT 
                COUNT([CO_LIQ]) AS QUANTIDADE_CAD_LIQ 
            FROM 
                [dbo].[tbl_LIQUIDACAO] 
            WHERE 
                [CO_STATUS] = 'CADASTRADA'
            ");
        $this->contagemDemandasCadastradasLiquidacao = $contador[0]->QUANTIDADE_CAD_LIQ;
    }

    //$contagemDemandasCadastradasAntecipadosCambioPronto;
    public function getContagemDemandasCadastradasAntecipadosCambioPronto()
    {
        return $this->contagemDemandasCadastradasAntecipadosCambioPronto;
    }
    public function setContagemDemandasCadastradasAntecipadosCambioPronto()
    {
        $contador = DB::select("
            SELECT 
                COUNT([CO_CONF]) AS QUANTIDADE_CAD_ANT 
            FROM 
                [dbo].[tbl_ANT_DEMANDAS] 
            WHERE 
                [CO_STATUS] = 'CADASTRADA'
            ");
        $this->contagemDemandasCadastradasAntecipadosCambioPronto = $contador[0]->QUANTIDADE_CAD_ANT;
    }

    //$contagemDemandasDistribuidasLiquidacao;
    public function getContagemDemandasDistribuidasLiquidacao()
    {
        return $this->contagemDemandasDistribuidasLiquidacao;
    }
    public function setContagemDemandasDistribuidasLiquidacao($matricula)
    {
        $contador = DB::select("
            SELECT 
                COUNT([CO_LIQ]) AS QUANTIDADE_DISTR_EMPREG_LIQ 
            FROM 
                [dbo].[tbl_LIQUIDACAO] 
            WHERE 
                [CO_STATUS] = 'DISTRIBUIDA' 
                AND [CO_MATRICULA_CEOPC] = '" . $matricula . "'
            ");
        $this->contagemDemandasDistribuidasLiquidacao = $contador[0]->QUANTIDADE_DISTR_EMPREG_LIQ;
    }

    //$contagemDemandasEmAnaliseLiquidacao;
    public function getContagemDemandasEmAnaliseLiquidacao()
    {
        return $this->contagemDemandasEmAnaliseLiquidacao;
    }
    public function setContagemDemandasEmAnaliseLiquidacao($matricula)
    {
        $contador = DB::select("
            SELECT 
                COUNT([CO_LIQ]) AS QUANTIDADE_EM_ANALISE_EMPREG_LIQ 
            FROM 
                [dbo].[tbl_LIQUIDACAO] 
            WHERE 
                [CO_STATUS] = 'EM ANALISE' 
                AND [CO_MATRICULA_CEOPC] = '" . $matricula . "'
            ");
        $this->contagemDemandasEmAnaliseLiquidacao = $contador[0]->QUANTIDADE_EM_ANALISE_EMPREG_LIQ;
    }

    // $contademDemandasDistribuidasAntecipadoCambioPronto;
    public function getContademDemandasDistribuidasAntecipadoCambioPronto()
    {
        return $this->contademDemandasDistribuidasAntecipadoCambioPronto;
    }
    public function setContademDemandasDistribuidasAntecipadoCambioPronto($matricula)
    {
        $contador = DB::select("
            SELECT 
                COUNT([CO_CONF]) AS QUANTIDADE_DISTR_EMPREG_ANTEC 
            FROM 
                [dbo].[tbl_ANT_DEMANDAS] 
            WHERE 
                [CO_STATUS] = 'DISTRIBUIDA' 
                AND [CO_MATRICULA_CEOPC] = '" . $matricula . "'
            ");
        $this->contademDemandasDistribuidasAntecipadoCambioPronto = $contador[0]->QUANTIDADE_DISTR_EMPREG_ANTEC;
    }

    // $contagemDemandasCadastradasContratacao
    public function getContagemDemandasCadastradasContratacao()
    {
        return $this->contagemDemandasCadastradasContratacao;
    }
    public function setContagemDemandasCadastradasContratacao($matricula)
    {
        $contador = DB::select("
            SELECT 
                COUNT([idDemanda]) AS quantidadeDemandaCadastradaContratacao 
            FROM 
                TBL_EST_CONTRATACAO_DEMANDAS
            WHERE 
                statusAtual = 'CADASTRADA'
            ");
        $this->contagemDemandasCadastradasContratacao = $contador[0]->quantidadeDemandaCadastradaContratacao;
    }

    // $contagemDemandasDistribuidasContratacao
    public function getContagemDemandasDistribuidasContratacao()
    {
        return $this->contagemDemandasDistribuidasContratacao;
    }
    public function setContagemDemandasDistribuidasContratacao($matricula)
    {
        $contador = DB::select("
            SELECT 
                COUNT([idDemanda]) AS quantidadeDemandaDistribuidaContratacao 
            FROM 
                TBL_EST_CONTRATACAO_DEMANDAS
            WHERE 
                statusAtual = 'DISTRIBUIDA' 
                AND responsavelCeopc = '" . $matricula . "'
            ");
        $this->contagemDemandasDistribuidasContratacao = $contador[0]->quantidadeDemandaDistribuidaContratacao;
    }
}