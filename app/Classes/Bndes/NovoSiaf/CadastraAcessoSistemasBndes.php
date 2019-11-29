<?php

namespace App\Classes\Bndes\NovoSiaf;

use App\AcessaEmpregado;

class CadastraAcessoSistemasBndes
{
    private $matricula;
    private $nivelAcesso;
    private $unidade;
    public $arraySr = [
        '2487', '2489', '2573', '2574', '2575', '2576', '2577', '2578', '2579', '2580', '2581', '2582', '2584', '2585', 
        '2586', '2587', '2588', '2589', '2591', '2592', '2593', '2594', '2595', '2596', '2597', '2598', '2601', '2602', 
        '2603', '2604', '2606', '2607', '2608', '2612', '2613', '2615', '2616', '2617', '2618', '3335', '3410', '3599',
        '3031', '5824', '2506', '2795', '3661', '3675', '3678', '3680', '3683', '3727', '4012', '4169', '4170', '4172', 
        '3332', '2619', '2621', '2622', '2623', '2624', '2625', '2626', '2627', '2628', '2629', '2634', '2635', '2636', 
        '2637', '2639', '2640', '2641', '2642', '2645', '2646', '2647', '2648', '2649', '2650', '2651', '2653', '2654',
        '2655', '2656', '2690', '2691', '2692', '2693', '2694', '3222', '3226', '3227'
    ];
    public $arrayGigad = [
        '7641', '7639', '7640', '7606', '7648', '7647', '7649', '7652', '7655', '7658', '7657', '7659', '7660', '7661'
    ];
    public $arrayAudir = [
        '7111', '7112', '7849', '7113', '7100', '7114', '7115', '7110', '7116', '7117', '7118', '7119', '7120'
    ];
    public $arrayMatriz = [
        '5624', // GEOPC
        '5199', // GEPOC
        '5637', // GEPOD
        '5174', '5175', '5176', '5177', '5178', '5179', '5181', '5182' // DIRES
    ];
    public $arrayMiddle = [
        'c091639', // Bruno
        'c117210', // Carolina
        'c116287', // Celia
        'c086812', // Daniela
        'c106407', // Nantes
        'c063490', // Erica
        // 'c111697', // Guilherme
        'c114783', // Juliane
        'c077793', // Leticia
        'c095053', // Marina
        // 'c121708', // Thais
        'c113591'  // Thiago
    ];
    public $arrayGestor = [
        /* GESTORES */
        // 'c121472', // Claudia
        // 'c113608', // Daniele
        // 'c084683', // Eidi
        // 'c061940', // Eliana
        // 'c052617', // Lucyenne
        // 'c086282', // Ricardo
        // 'c058725', // Thais Jomah
        // 'c133633', // Mario
        // 'c080709', // Josias
        /* DESENVOLVIMENTO */
        'c142765', // Carlos
        'c111710', // Chuman
        'c095060', // Denise
        'c079436'  // Vladimir
    ];

    /**
     * Get the value of matricula
     */ 
    public function getMatricula()
    {
        return $this->matricula;
    }

    /**
     * Set the value of matricula
     *
     * @return  self
     */ 
    public function setMatricula($matricula)
    {
        $this->matricula = $matricula;

        return $this;
    }

    /**
     * Get the value of nivelAcesso
     */ 
    public function getNivelAcesso()
    {
        return $this->nivelAcesso;
    }

    /**
     * Set the value of nivelAcesso
     *
     * @return  self
     */ 
    public function setNivelAcesso()
    {
        if(in_array($this->getUnidade(), $this->arraySr)) {
            $this->nivelAcesso = 'EMPREGADO_SR';
        } elseif (in_array($this->getUnidade(), $this->arrayGigad)) {
            $this->nivelAcesso = 'GIGAD';
        }elseif (in_array($this->getUnidade(), $this->arrayAudir)) {
            $this->nivelAcesso = 'AUDITOR';
        } elseif (in_array($this->getUnidade(), $this->arrayMatriz)) {
            $this->nivelAcesso = 'EMPREGADO_MATRIZ';
        } elseif ($this->getUnidade() == '5459' || $this->getUnidade() == '7854') {
            if (in_array($this->getMatricula(), $this->arrayGestor)) {
                $this->nivelAcesso = 'MASTER';
            } else {
                $this->nivelAcesso = env('NOME_NOSSA_UNIDADE');
            }
        } else {
            $this->nivelAcesso = 'EMPREGADO_AG';
        }
        return $this;
    }

    /**
     * Get the value of unidade
     */ 
    public function getUnidade()
    {
        return $this->unidade;
    }

    /**
     * Set the value of unidade
     *
     * @return  self
     */ 
    public function setUnidade($objEmpregado)
    {
        if ($objEmpregado->codigoLotacaoFisica === null) {
            $this->unidade = $objEmpregado->codigoLotacaoAdministrativa;
        } else {
            $this->unidade = $objEmpregado->codigoLotacaoFisica;
        }
        return $this;
    }

    public function __construct($objEmpregado)
    {
        $this->setMatricula($objEmpregado->matricula);
        $this->setUnidade($objEmpregado);
        $this->setNivelAcesso();
        $this->atualizaPerfilAcessoEsteira();
    }

    public function __toString()
    {
        return json_encode(array(
            "matricula" => $this->getMatricula(),
            "nivelAcesso" => $this->getNivelAcesso(),
            "unidade" => $this->getUnidade(),
        ), JSON_UNESCAPED_SLASHES);
    }

    public function atualizaPerfilAcessoEsteira()
    {
        $cadastroAcesso = AcessaEmpregado::firstOrNew(['matricula' => $this->getMatricula()]);
        $cadastroAcesso->nivelAcesso = $this->getNivelAcesso();
        $cadastroAcesso->unidade = $this->getUnidade();
        $cadastroAcesso->touch();
        $cadastroAcesso->save(); 
    }
}