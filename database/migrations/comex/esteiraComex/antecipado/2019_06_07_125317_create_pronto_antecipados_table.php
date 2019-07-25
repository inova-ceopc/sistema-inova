<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProntoAntecipadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_ANT_DEMANDAS', function (Blueprint $table) {
            $table->increments('CO_CONF');
            $table->integer('CO_OPERACAO');
            $table->string('CLIENTE', 100);
            $table->string('CNPJ_CPF', 20);
            $table->string('CO_PV', 4);
            $table->string('NO_PV', 50);
            $table->string('CO_SR', 4);
            $table->string('NO_SR', 50);
            $table->string('CO_UF', 2);
            $table->string('CO_DIRE', 4);
            $table->string('NO_DIRE', 50);
            $table->string('DT_CADASTRADA', 20);
            $table->string('DT_EM_ANALISE', 20);
            $table->string('DT_INCONFORME', 20);
            $table->string('DT_CONFORME', 20);
            $table->string('DT_EMBARQUE', 20);
            $table->string('DT_EMBARQUE_OLD', 20);
            $table->string('CO_STATUS', 20);
            $table->string('CO_CONCLUSAO', 2000);
            $table->string('CO_CAMINHO', 300);
            $table->string('CO_OBSERVACAO', 2000);
            $table->string('CO_MATRICULA_PA', 7);
            $table->string('CO_NOME_PA', 80);
            $table->string('CO_MATRICULA_CEOPC', 7);
            $table->string('CO_NOME_CEOPC', 80);
            $table->string('DT_CANCELAMENTO', 20);
            $table->string('DT_DATA_OK', 20);
            $table->string('DT_ATUAL', 20);
            $table->string('DT_DISTRIBUIDA', 20);
            $table->string('STATUS_ANTERIOR', 20);
            $table->string('CO_CAMINHO_DATA', 300);
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
        Schema::dropIfExists('tbl_ANT_DEMANDAS');
    }
}
