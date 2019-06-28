<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Historico extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TBL_EST_CONTRATACAO_HISTORICO', function (Blueprint $table) {

            $table->increments('idHistorico');
            $table->integer('idDemanda'); // chave estrangeira
            $table->string('tipoStatus',30);
            $table->dateTime('dataStatus');
            $table->string('responsavelStatus',7);
            $table->string('area',4);
            $table->text('analiseHistorico')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('TBL_EST_CONTRATACAO_HISTORICO');
    }
}
