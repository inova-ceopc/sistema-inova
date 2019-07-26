<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInovaLogAcessoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TBL_INOVA_LOG_ACESSOS', function (Blueprint $table) {
            $table->increments('idLog');
            $table->date('dataAcesso');
            $table->string('matricula', 7);
            $table->string('tipoAcaoAcesso', 20);
            $table->string('sistema', 100);
            $table->string('nomePagina', 50);
            $table->string('nomeNavegador', 50);
            $table->string('versaoNavegador', 50);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('TBL_INOVA_LOG_ACESSOS');
    }
}
