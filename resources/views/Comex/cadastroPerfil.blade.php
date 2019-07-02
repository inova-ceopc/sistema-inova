<?php

use App\Classes\Comex\CadastraAcessoEsteiraComex;
use App\Classes\Comex\ControleDemandasEsteira;
use App\Empregado;
use App\RelacaoAgSrComEmail;
use App\Classes\Geral\Ldap;
use App\Classes\Comex\Contratacao\ContratacaoPhpMailer;

$empregado = new Ldap;
$usuario = Empregado::find($empregado->getMatricula());
$acesso = new CadastraAcessoEsteiraComex($usuario);

// Codigo para pegar o e-mail da Agência    
$objRelacaoEmailUnidades = RelacaoAgSrComEmail::where('codigoAgencia', '3191')->first();

// Codigo para pegar o e-mail da SR    
// $objRelacaoEmailUnidades = RelacaoAgSrComEmail::where('codigoSr', '2637')->first();

dd($objRelacaoEmailUnidades);

// echo $acesso;

// $demandasEsteira = new ControleDemandasEsteira($usuario);
// echo $demandasEsteira;
