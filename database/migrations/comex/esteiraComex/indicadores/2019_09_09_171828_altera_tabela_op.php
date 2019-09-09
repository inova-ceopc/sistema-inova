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

            $table->integer('Numero');	
            $table->integer('Codigo_Externo');	
            $table->string('Cliente',60);	
            $table->string('CPF_CNPJ_Cliente',20);
            $table->string('Moeda', 10);	
            $table->decimal('Valor_ME', 17,2);
            $table->string('Banqueiro_Correspondente', 60);
            $table->string('Pagador', 100);	
            $table->string('Pais',50);	
            $table->string('DATA_ENVIO_OPE', 11);	
            $table->string('DATA_CHEGADA_OPE', 11);	
            $table->string('CO_PV', 4);	
            $table->string('NO_PV', 30);	
        
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
