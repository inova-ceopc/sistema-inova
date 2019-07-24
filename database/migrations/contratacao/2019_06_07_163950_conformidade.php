<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Conformidade extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TBL_EST_CONTRATACAO_CONFORMIDADE_DOCUMENTAL', function (Blueprint $table) {
            $table->increments('idCheckList');
            $table->integer('idDemanda'); //FK
            $table->dateTime('dataConferencia')->nullable();
            $table->string('tipoDocumento', 50);
            $table->string('tipoOperacao', 50);
            $table->string('statusDocumento', 50);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {  
        Schema::drop('TBL_EST_CONTRATACAO_CONFORMIDADE_DOCUMENTAL');
    }
}
