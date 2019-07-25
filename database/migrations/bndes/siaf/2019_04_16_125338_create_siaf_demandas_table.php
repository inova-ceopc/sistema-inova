<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSiafDemandasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TBL_SIAF_DEMANDAS', function (Blueprint $table) {
            $table->increments('codigoDemanda');
            $table->string('nomeCliente', 100);
            $table->string('cnpj', 20);
            $table->string('contratoCaixa', 20);
            $table->string('contratoBndes', 20);
            $table->decimal('valorOperacao', 17, 2);	
            $table->char('tipoOperacao', 1);
            $table->smallInteger('codigoPa');
            $table->string('nomePa', 255);
            $table->string('emailPa', 255);
            $table->smallInteger('codigoSr');
            $table->string('nomeSr', 255);
            $table->string('emailSr', 255);
            $table->smallInteger('codigoGigad');
            $table->string('nomeGigad', 255);
            $table->string('emailGigad', 255);
            $table->datetime('dataCadastramento');
            $table->string('dataLote', 10);
            $table->string('status', 20);
            $table->string('matriculaSolicitante', 7);
            $table->string('contaDebito', 20);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('TBL_SIAF_DEMANDAS');
    }
}
