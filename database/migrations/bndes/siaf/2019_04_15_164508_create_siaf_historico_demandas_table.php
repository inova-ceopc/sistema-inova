<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSiafHistoricoDemandasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TBL_SIAF_HISTORICO_DEMANDAS', function (Blueprint $table) {
            $table->increments('codigoHistorico');
            $table->string('contratoCaixa', 20);
            $table->string('loteAmortizacao', 10);
            $table->string('tipoHistorico', 100);
            $table->text('historico')->nullable();
            $table->string('matriculaResponsavel', 7);
            $table->string('unidadeResponsavel', 4);
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
        Schema::dropIfExists('TBL_SIAF_HISTORICO_DEMANDAS');
    }
}
