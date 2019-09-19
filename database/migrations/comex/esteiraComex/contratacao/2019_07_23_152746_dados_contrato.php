<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DadosContrato extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TBL_EST_CONTRATACAO_CONFORMIDADE_CONTRATO', function (Blueprint $table) {
            $table->increments('idContrato');
            $table->integer('idUploadContratoSemAssinatura'); //FK
            $table->integer('idUploadContratoAssinado')->nullable(); //FK
            $table->integer('numeroContrato');           
            $table->string('tipoContrato', 50);
            $table->dateTime('dataEnvioContrato')->nullable();
            $table->string('temRetornoRede', 3)->nullable();
            $table->dateTime('dataLimiteRetorno')->nullable();
            $table->dateTime('dataReiteracao')->nullable();
            $table->dateTime('dataConfirmacaoAssinatura')->nullable();
            $table->dateTime('dataEnvioContratoAssinado')->nullable();
            $table->string('matriculaResponsavelConfirmacao', 7)->nullable();
            $table->string('gerenteResponsavelAssinatura', 7)->nullable();
            $table->dateTime('dataAnaliseContratoAssinado')->nullable();
            $table->string('matriculaResponsavelAnalise', 7)->nullable();
            $table->string('statusContrato', 50)->nullable();
            $table->dateTime('dataArquivoContratoConforme')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('TBL_EST_CONTRATACAO_CONFORMIDADE_CONTRATO');
    }
}
