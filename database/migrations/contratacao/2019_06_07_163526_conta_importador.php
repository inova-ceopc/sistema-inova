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
        //
        Schema::create('TBL_EST_CONTRATACAO_CONTA_IMPORTADOR', function (Blueprint $table) {
            
            $table->string('tipoPessoa',2);
            $table->increments('idConta');
            $table->integer('idDemanda'); //chave estrangeira
            $table->string('nomeBeneficiario');
            $table->string('nomeBanco',50);
            $table->string('iban',40);
            $table->string('agContaBeneficiario', 60);
            $table->text('observacoes');
            
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
