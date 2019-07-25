<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSiafContratosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TBL_SIAF_CONTRATOS', function (Blueprint $table) {
            $table->string('cnpj', 14);
            $table->string('cliente', 50);
            $table->string('contratoCaixa', 19);
            $table->char('operacao', 3);
            $table->string('contaDebito', 19)->nullable();
            $table->string('contratoBndes', 50)->nullable();
            $table->string('contratoBndesFiname', 50)->nullable();
            $table->smallInteger('codigoPa');
            $table->string('nomePa', 255);
            $table->string('emailPa', 255);
            $table->smallInteger('codigoSr');
            $table->string('nomeSr', 255);
            $table->string('emailSr', 255);
            $table->smallInteger('codigoGigad');
            $table->string('nomeGigad', 255);
            $table->string('emailGigad', 255);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('TBL_SIAF_CONTRATOS');
    }
}
