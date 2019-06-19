<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableIndicadorTempestividadeAutorizacaoOperacaoAntecipadasComex extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TBL_DASHBOARD_INDICADORES_TEMPESTIVIDADE_AUTORIZACAO_OPERACAO_ANTECIPADA_COMEX', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('quantidadeDemandasRealizadas');
            $table->decimal('resultadoIndicador', 5, 2);
            $table->string('matricula', 7);
            $table->string('mesReferencia', 7);
            $table->dateTime('dataRegistro');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('TBL_DASHBOARD_INDICADORES_TEMPESTIVIDADE_AUTORIZACAO_OPERACAO_ANTECIPADA_COMEX');
    }
}
