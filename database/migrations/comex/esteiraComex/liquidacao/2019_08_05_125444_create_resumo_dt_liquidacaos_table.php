<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResumoDtLiquidacaosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_RESUMO_DT_LIQUIDACAO', function (Blueprint $table) {
            $table->integer('CO_LIQ');
            $table->string('CO_MATRICULA_CEOPC',7)->nullable();
            $table->string('DT_CADASTRAMENTO',10)->nullable();
            $table->string('DT_DISTRIBUIDA',10)->nullable();
            $table->string('DT_EM_ANALISE',10)->nullable();
            $table->string('DT_CANCELAMENTO',10)->nullable();
            $table->string('DT_INCONFORME_PA',10)->nullable();
            $table->string('DT_GECAM',10)->nullable();
            $table->string('DT_GELIT',10)->nullable();
            $table->string('DT_MIDDLE',10)->nullable();
            $table->string('DT_CALCULO',10)->nullable();
            $table->string('DT_LIQUIDACAO',10)->nullable();
            $table->string('DT_CADASTRAMENTO_2',10)->nullable();
            $table->string('DT_DISTRIBUIDA_2',10)->nullable();
            $table->string('CO_MATRICULA_PV',10)->nullable();
            $table->string('DT_INCONFORME_PA_2',10)->nullable();
            $table->string('DT_INCONFORME_SALDO',10)->nullable();
            $table->string('DT_CALCULO_2',10)->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_RESUMO_DT_LIQUIDACAO');
    }
}
