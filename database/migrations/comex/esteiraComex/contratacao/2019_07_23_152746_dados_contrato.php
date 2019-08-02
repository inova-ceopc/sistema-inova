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
            $table->integer('idUploadContrato'); //FK
            $table->dateTime('dataEnvio');
            $table->string('tipoContrato', 50);
            $table->string('motivoAlteracao', 50);
            $table->string('temRetornoRede', 10);
            $table->dateTime('dataLimiteRetorno', 10)->nullable();
            $table->dateTime('dataLimiteRetorno', 10)->nullable();
            $table->dateTime('dataConfirmacao')->nullable();
            $table->string('matriculaResponsavelAssinatura', 7)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('TBL_EST_CONTRATACAO_DADOS_CONTRATO');
    }
}
