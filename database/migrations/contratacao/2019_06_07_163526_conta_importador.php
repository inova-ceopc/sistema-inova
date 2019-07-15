<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ContaImportador extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TBL_EST_CONTRATACAO_CONTA_IMPORTADOR', function (Blueprint $table) {        
            $table->increments('idConta');
            $table->integer('idDemanda'); //chave estrangeira

            // DADOS BENEFICIARIO
            $table->string('nomeBeneficiario', 100);
            $table->string('enderecoBeneficiario', 150);
            $table->string('cidadeBeneficiario', 189);
            // $table->string('estadoBeneficiario', 189)->nullable();
            $table->string('paisBeneficiario', 90);
            $table->string('nomeBancoBeneficiario', 100);
            // $table->string('paisBancoBeneficiario', 90);
            $table->string('ibanBancoBeneficiario', 40)->nullable();
            $table->string('swiftAbaBancoBeneficiario', 40);
            $table->string('numeroContaBeneficiario', 60)->nullable();

            // DADOS BANCO INTERMEDIÁRIO
            $table->string('nomeBancoIntermediario', 100)->nullable();
            $table->string('ibanBancoIntermediario', 40)->nullable();
            // $table->string('paisBancoIntermediario', 90)->nullable();
            $table->string('contaBancoIntermediario', 60)->nullable();
            $table->string('swiftAbaBancoIntermediario', 60)->nullable();     
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::drop('TBL_EST_CONTRATACAO_CONTA_IMPORTADOR');
    }
}
