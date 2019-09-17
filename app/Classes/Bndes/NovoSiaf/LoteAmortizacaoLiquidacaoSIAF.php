<?php

namespace App\Classes\Bndes\NovoSiaf;

class LoteAmortizacaoLiquidacaoSIAF
{
	private $dataLoteAtual;
	private $dataLoteAnterior;
	private $dataLimiteParaCadastroDeDemanda;

	// $dataLoteAtual
	public function getDataLoteAtual()
	{
		return $this->dataLoteAtual;
	}
	public function setDataLoteAtual()
	{
		if(date("d/m/Y") <= date('d/m/Y', strtotime(str_replace('/', '-', $this->getDataLimiteParaCadastroDeDemanda())))) {
			$this->dataLoteAtual = date('d/m/Y', strtotime(date("Y") . '-' . sprintf('%02d', date('m')) . '-15'));
		} else {
			if(date("m") <= 9) {	
				$this->dataLoteAtual = date('d/m/Y', strtotime(date("Y") . '-' . sprintf("%02d", (date('m')+1)) . '-15'));
			} else {
				$this->dataLoteAtual = date('d/m/Y', strtotime(date("Y") . '-' . (date('m')+1) . '-15'));
			}
		}
	}

	// $dataLoteAnterior;
	public function getDataLoteAnterior()
	{
		return $this->dataLoteAnterior;
	}
	public function setDataLoteAnterior()
	{
		if(date("d/m/Y") <= date('d/m/Y', strtotime(str_replace('/', '-', $this->getDataLimiteParaCadastroDeDemanda())))) {
			if(date("m") == 1) {	
				$this->dataLoteAnterior = date('d/m/Y', strtotime((date("Y")-1) . '-12-15'));				
			} else {	
				$this->dataLoteAnterior = date('d/m/Y', strtotime(date("Y") . '-' . sprintf("%02d", (date('m') - 1)) . '-15'));
			}
		} else {
			$this->dataLoteAnterior = date('d/m/Y', strtotime(date("Y") . '-' . date('m') . '-15'));
		}
	}

	// $dataLimiteParaCadastroDeDemanda
	public function getDataLimiteParaCadastroDeDemanda()
	{
		return $this->dataLimiteParaCadastroDeDemanda;
	}
	public function setDataLimiteParaCadastroDeDemanda()
	{
		$this->dataLimiteParaCadastroDeDemanda = date('Y-m-d', strtotime(date('Y') . '-' . sprintf("%02d", date('m')) . '-15'));
		
		switch (date('w', strtotime($this->dataLimiteParaCadastroDeDemanda))) {
			case '0':
				$this->dataLimiteParaCadastroDeDemanda = date('d/m/Y', strtotime(date('Y') . '-' . sprintf("%02d", date('m')+1) . '-12'));
				break;
			case '1':
			case '2':
				$this->dataLimiteParaCadastroDeDemanda = date('d/m/Y', strtotime(date('Y') . '-' . sprintf("%02d", date('m')+1) . '-11'));
				break;   
			default:
				$this->dataLimiteParaCadastroDeDemanda = date('d/m/Y', strtotime(date('Y') . '-' . sprintf("%02d", date('m')+1) . '-13'));
				break;
		}

		if (date('d/m/Y') > $this->dataLimiteParaCadastroDeDemanda) {
			$this->dataLimiteParaCadastroDeDemanda = date('Y-m-d', strtotime(date('Y') . '-' . sprintf("%02d", (date('m') +1)) . '-15'));
			switch (date('w', strtotime($this->dataLimiteParaCadastroDeDemanda))) 
			{
				case '0':
					$this->dataLimiteParaCadastroDeDemanda = date('d/m/Y', strtotime(date('Y') . '-' . sprintf("%02d", date('m')+1) . '-12'));
					break;
				case '1':
				case '2':
					$this->dataLimiteParaCadastroDeDemanda = date('d/m/Y', strtotime(date('Y') . '-' . sprintf("%02d", date('m')+1) . '-11'));
					break;   
				default:
					$this->dataLimiteParaCadastroDeDemanda = date('d/m/Y', strtotime(date('Y') . '-' . sprintf("%02d", date('m')+1) . '-13'));
					break;
			}
		}
	}
	
	public function __construct()
	{
		$this->setDataLimiteParaCadastroDeDemanda();
		$this->setDataLoteAtual();
		$this->setDataLoteAnterior();
	}

	public function __toString()
	{
		return json_encode(array(
			'dataLoteAtual'=>$this->getDataLoteAtual(),
			'dataLoteAnterior'=>$this->getDataLoteAnterior(),
			'dataLimiteParaCadastroDemanda'=>$this->getDataLimiteParaCadastroDeDemanda(),
		), JSON_UNESCAPED_SLASHES);	
	}
}