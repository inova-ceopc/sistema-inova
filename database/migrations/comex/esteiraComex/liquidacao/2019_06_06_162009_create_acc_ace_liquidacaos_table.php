<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccAceLiquidacaosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_LIQUIDACAO', function (Blueprint $table) {
            $table->increments('CO_LIQ');
            $table->integer('CO_OPERACAO');
            $table->string('NO_RAZAO_SOCIAL', 80);
            $table->string('CNPJ', 20);
            $table->integer('CO_SR');
            $table->integer('CO_PV');
            $table->integer('CO_AREA');
            $table->string('CO_MATRICULA', 7);
            $table->string('NO_EMPREGADO', 50);
            $table->float('VL_CONTRATADO', 17, 2);
            $table->float('VL_SALDO_MN', 17, 2);
            $table->string('DT_VENCIMENTO', 10);
            $table->string('NU_O_PAGTO', 50);
            $table->string('NO_FATURA', 200);
            $table->float('VL_O_PGTO', 17, 2);
            $table->float('VL_DP_BANQ', 17, 2);
            $table->float('VL_AP_CONTRATO', 17, 2);
            $table->string('TP_MOEDA', 10);
            $table->string('DT_NEGOCIACAO', 10);
            $table->string('DT_INICIAL', 10);
            $table->string('CO_STATUS', 20);
            $table->string('NO_CAMINHO', 500);
            $table->string('NO_OBSERVACOES', 2000);
            $table->string('CO_MATRICULA_CEOPC', 7);
            $table->string('CO_POSICAO', 10);
            $table->float('VL_CO_AGENTE', 17, 2);
            $table->string('NO_AGENTE', 60);
            $table->string('CO_BANCO_AGENTE', 40);
            $table->string('NU_AGENTE_CONTA', 40);
            $table->string('NO_AGENTE_ENDERECO', 1000);
            $table->smallInteger('NU_CONF_NU_O_PAGTO');
            $table->smallInteger('NU_CONF_VL_O_PAGTO');
            $table->smallInteger('NU_CONF_VL_BANQUEIRO');
            $table->smallInteger('NU_CONF_VL_APLICADO');
            $table->smallInteger('NU_CONF_MOEDA');
            $table->string('DT_CALC_JUROS', 10);
            $table->string('DT_EMBARQUE', 10);
            $table->smallInteger('NU_CONF_VL_AGENTE');
            $table->smallInteger('NU_CONF_NO_AGENTE');
            $table->smallInteger('NU_CONF_CD_BANCO');
            $table->smallInteger('NU_CONF_NU_CONTA');
            $table->smallInteger('NU_CONF_ENDERECO');
            $table->smallInteger('NU_CONF_CAMINHO');
            $table->smallInteger('NU_CONF_OBSERVACOES');
            $table->string('NU_CAMBIAL', 50);
            $table->string('NO_CONCLUSAO', 2000);
            $table->string('DT_ATUAL', 20);
            $table->smallInteger('DOCS_COPY');
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_LIQUIDACAO');
    }
}
