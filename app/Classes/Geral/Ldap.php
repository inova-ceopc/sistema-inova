<?php

namespace App\Classes\Geral;
use App\Empregado;

class Ldap
{
    private $simularMatricula;
    // private $simularMatricula = 'c058725'; // Thais - CEOPA
    // private $simularMatricula = 'c032579'; // Euclidio - AG
    // private $simularMatricula = 'c122954';
    private $matricula;
    private $nomeCompleto;
    private $primeiroNome;
    private $dataDeNascimento;
    private $codigoFuncao;
    private $nomeFuncao;
    private $codigoLotacaoAdministrativa;
    private $nomeLotacaoAdministrativa;
    private $codicoLotacaoFisica;
    private $nomeLotacaoFisica;

    /* Getters and Setters */
    public function getMatricula()
    {
        return $this->matricula;
    }
    public function setMatricula($matricula)
    {
        $this->matricula = $matricula;
    }

    public function getNomeCompleto()
    {
        return $this->nomeCompleto;
    }
    public function setNomeCompleto($nomeCompleto)
    {
        $this->nomeCompleto = $nomeCompleto;
    }

    public function getPrimeiroNome()
    {
        return $this->primeiroNome;
    } 
    public function setPrimeiroNome($primeiroNome)
    {
        $nome = explode(" ", $primeiroNome);
        $this->primeiroNome = $nome[0];
    }

    public function getDataDeNascimento()
    {
        return $this->dataDeNascimento;
    }
    public function setDataDeNascimento($dataDeNascimento)
    {
        if(isset($dataDeNascimento))
        {
            $var = $dataDeNascimento;
            $date = str_replace('/', '-', $var);
            $dataFormatada = date('Y-m-d', strtotime($date));
            $this->dataDeNascimento = $dataFormatada;
        } else {
            $this->dataDeNascimento = null;
        }
    }

    public function getCodigoFuncao()
    {
        return $this->codigoFuncao;
    }
    public function setCodigoFuncao($codigoFuncao)
    {
        if(isset($codigoFuncao))
        {
            $this->codigoFuncao = $codigoFuncao;
        } else {
            $this->codigoFuncao = null;
        }
    }

    public function getNomeFuncao()
    {
        return $this->nomeFuncao;
    }
    public function setNomeFuncao($nomeFuncao)
    {
        if(isset($nomeFuncao))
        {
            $this->nomeFuncao = $nomeFuncao;
        } else {
            $this->nomeFuncao = null;
        }
    }

    public function getCodigoLotacaoAdministrativa()
    {
        return $this->codigoLotacaoAdministrativa;
    }
    public function setCodigoLotacaoAdministrativa($codigoLotacaoAdministrativa)
    {
        $this->codigoLotacaoAdministrativa = $codigoLotacaoAdministrativa;
    }

    public function getNomeLotacaoAdministrativa()
    {
        return $this->nomeLotacaoAdministrativa;
    }

    public function setNomeLotacaoAdministrativa($nomeLotacaoAdministrativa)
    {
        $this->nomeLotacaoAdministrativa = $nomeLotacaoAdministrativa;
    }

    public function getCodicoLotacaoFisica()
    {
        return $this->codicoLotacaoFisica;
    }
    public function setCodicoLotacaoFisica($codicoLotacaoFisica)
    {
        if ($codicoLotacaoFisica == $this->getCodigoLotacaoAdministrativa()) {
            $this->codicoLotacaoFisica = null;
        } else {
            $this->codicoLotacaoFisica = $codicoLotacaoFisica;
        }   
    }

    public function getNomeLotacaoFisica()
    {
        return $this->nomeLotacaoFisica;
    }
    public function setNomeLotacaoFisica($nomeLotacaoFisica)
    {  
        if ($nomeLotacaoFisica == $this->getNomeLotacaoAdministrativa()) {
            $this->nomeLotacaoFisica = null;
        } else {
            $this->nomeLotacaoFisica = $nomeLotacaoFisica;
        }
    }

    public function getSimularMatricula()
    {
        return $this->simularMatricula;
    }

    public function __construct()
    {
        if ($this->getSimularMatricula() != "") {
            $this->setMatricula(str_replace('C', 'c', $this->getSimularMatricula()));
        } else {
            $this->setMatricula(str_replace('C', 'c', substr($_SERVER["AUTH_USER"], 10)));
        }
        $this->settaDadosEmpregado();
        $this->updateBaseEmpregados();
    }

    public function __toString()
    {
        return json_encode(array(
            "matricula" => $this->getMatricula(),
            "nomeCompleto" => $this->getNomeCompleto(),
            "primeiroNome" => $this->getPrimeiroNome(),
            "dataNascimento" => $this->getDataDeNascimento(),
            "codigoFuncao" => $this->getCodigoFuncao(),
            "nomeFuncao" => $this->getNomeFuncao(),
            "codigoLotacaoAdministrativa" => $this->getCodigoLotacaoAdministrativa(),
            "nomeLotacaoAdministrativa" => $this->getNomeLotacaoAdministrativa(),
            "codigoLotacaoFisica" => $this->getCodicoLotacaoFisica(),
            "nomeLotacaoFisica" => $this->getNomeLotacaoFisica(),
        ), JSON_UNESCAPED_SLASHES);
    }

    public function settaDadosEmpregado()
    {
        // if(!isset($_SESSION['aut_matricula']) or strtoupper($_SESSION['aut_matricula']) != strtoupper(substr($_SERVER["AUTH_USER"],10) ) || $this->getMatricula() != "") {                
        $ldap_handle = ldap_connect('ldap://ldapcluster.corecaixa:489');
        $search_base = 'ou=People,o=caixa';
        $search_filter = '(uid=%s)';          
        $search_filter = sprintf( $search_filter, $this->getMatricula());              
        $search_handle = ldap_search($ldap_handle, $search_base, $search_filter);
        
        if(!$search_handle) {
            throw new Exception("Servidor de Autenticação Indisponível (LDAP: erro na consulta)");
        }
        
        $ldap_resultado = ldap_get_entries($ldap_handle, $search_handle);
        if($ldap_resultado['count'] == 0) {
            throw new Exception("Usuário não reconhecido");
        }
        
        $ldap_user = $ldap_resultado[0];
        $this->setNomeCompleto($ldap_user['no-usuario'][0]);
        $this->setPrimeiroNome($this->getNomeCompleto());
        $this->setNomeFuncao(isset($ldap_user['no-funcao'][0]) ? $ldap_user['no-funcao'][0] : null);
        $this->setCodigoFuncao(isset($ldap_user['nu-funcao'][0]) ? $ldap_user['nu-funcao'][0] : null);
        $this->setCodigoLotacaoAdministrativa($ldap_user['co-unidade'][0]);
        $this->setNomeLotacaoAdministrativa($ldap_user['no-unidade'][0]);
        $this->setCodicoLotacaoFisica($ldap_user['nu-lotacaofisica'][0]);
        $this->setNomeLotacaoFisica($ldap_user['no-lotacaofisica'][0]);         
        $this->setDataDeNascimento(isset($ldap_user['dt-nascimento'][0]) ? $ldap_user['dt-nascimento'][0] : null);
        // }
    }

    public function updateBaseEmpregados()
    {
        $empregado = Empregado::firstOrNew(array('matricula' => $this->getMatricula()));
        $empregado->matricula = $this->getMatricula();
        $empregado->nomeCompleto = $this->getNomeCompleto();
        $empregado->primeiroNome = $this->getPrimeiroNome();
        $empregado->dataNascimento = $this->getDataDeNascimento();
        $empregado->codigoFuncao = $this->getCodigoFuncao();
        $empregado->nomeFuncao = $this->getNomeFuncao();
        $empregado->codigoLotacaoAdministrativa = $this->getCodigoLotacaoAdministrativa();
        $empregado->nomeLotacaoAdministrativa = $this->getNomeLotacaoAdministrativa();
        $empregado->codigoLotacaoFisica = $this->getCodicoLotacaoFisica();
        $empregado->nomeLotacaoFisica = $this->getNomeLotacaoFisica();
        $empregado->save();
    }
}