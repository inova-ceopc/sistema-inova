<?php

use App\Classes\Comex\CadastraAcessoEsteiraComex;
use App\Classes\Comex\ControleDemandasEsteira;
use App\Empregado;
use App\RelacaoAgSrComEmail;
use App\Classes\Geral\Ldap;

$empregado = new Ldap;
$usuario = Empregado::find($empregado->getMatricula());
$acesso = new CadastraAcessoEsteiraComex($usuario);

    $objRelacaoEmailUnidades = RelacaoAgSrComEmail::where('codigoAgencia', '2515')->get();

    // $objRelacaoEmailUnidades = RelacaoAgSrComEmail::where('codigoAgencia', $objEsteiraContratacao->agResponsavel);


dd($objRelacaoEmailUnidades);

// echo $acesso;

// $demandasEsteira = new ControleDemandasEsteira($usuario);
// echo $demandasEsteira;
