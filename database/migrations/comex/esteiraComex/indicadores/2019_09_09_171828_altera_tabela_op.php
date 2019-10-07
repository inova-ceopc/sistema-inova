<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlteraTabelaOp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_SIEXC_OPES_ENVIADAS_ANALITICO', function (Blueprint $table) {

            $table->integer('numero');	
            $table->integer('codigoExterno');	
            $table->string('cliente',60);	
            $table->string('cpfCnpjCliente',20);
            $table->string('moeda', 10);	
            $table->decimal('valorMe', 17,2);
            $table->string('banqueiroCorrespondente', 60);
            $table->string('pagador', 100);	
            $table->string('pais',50);	
            $table->string('dataEnvioOp', 11);	
            $table->string('dataChegadaOp', 11);	
            $table->smallInteger('codigoPv');	
            $table->string('nomePv', 30);	
        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_SIEXC_OPES_ENVIADAS_ANALITICO');
    }
}
