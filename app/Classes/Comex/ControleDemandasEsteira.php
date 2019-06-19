<?php

namespace App\Classes\Comex;

use Illuminate\Support\Facades\DB;

class ControleDemandasEsteira
{
    private $dataAtualizacaoBaseSuint = '30/05/2019'; //$datadeatualizacao
    private $contagemDemandasCadastradasLiquidacao; //$badget_cadastrada
    private $contagemDemandasCadastradasAntecipadosCambioPronto; //$badget_cadastrada_antecipados
    private $contagemDemandasDistribuidasLiquidacao; //$badget_usuario
    private $contagemDemandasEmAnaliseLiquidacao; //$badget_usuario_em
    private $contademDemandasDistribuidasAntecipadoCambioPronto; //$badget_cadastrada_antecipados_usuario

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
        $this->setContagemDemandasCadastradasLiquidacao();
        $this->setContagemDemandasCadastradasAntecipadosCambioPronto();
        $this->setContagemDemandasDistribuidasLiquidacao($request->session()->get('matricula'));
        $this->setContagemDemandasEmAnaliseLiquidacao($request->session()->get('matricula'));
        $this->setContademDemandasDistribuidasAntecipadoCambioPronto($request->session()->get('matricula'));       
    }

    public function __toString()
    {
        return json_encode(array(
            "DATA_ATUALIZACAO_BASE_SUINT"=>$this->getDataAtualizacaoBaseSuint(),
            "CONTAR_DEMANDAS_CADASTRADAS_LIQUIDACAO_COMEX"=>$this->getContagemDemandasCadastradasLiquidacao(),
            "CONTAR_DEMANDAS_CADASTRADAS_ANTECIPADOS_CAMBIO_PRONTO"=>$this->getContagemDemandasCadastradasAntecipadosCambioPronto(),
            "CONTAR_DEMANDAS_DISTRIBUIDAS_LIQUIDACAO_COMEX"=>$this->getContagemDemandasDistribuidasLiquidacao(),
            "CONTAR_DEMANDAS_EM_ANALISE_LIQUIDACAO_COMEX"=>$this->getContagemDemandasEmAnaliseLiquidacao(),
            "CONTAR_DEMANDAS_DISTRIBUIDAS_ANTECIPADOS_CAMBIO_PRONTO"=>$this->getContademDemandasDistribuidasAntecipadoCambioPronto()          
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
}