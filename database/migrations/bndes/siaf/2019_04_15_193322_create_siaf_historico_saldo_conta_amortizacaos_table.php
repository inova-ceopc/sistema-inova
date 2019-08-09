<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSiafHistoricoSaldoContaAmortizacaosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TBL_SIAF_HISTORICO_SALDO_CONTA_AMORTIZACOES', function (Blueprint $table) {
            $table->increments('codigoHistorico');
            $table->string('tipoHistorico', 100);
            $table->string('loteAmortizacao', 10);
            $table->string('contaDebito', 20);
            $table->string('contratoCaixa', 20);
            $table->decimal('saldoDisponivel', 17, 2);
            $table->decimal('saldoBloqueado', 17, 2);
            $table->decimal('limiteChequeAzul', 17, 2);
            $table->decimal('limiteGim', 17, 2);
            $table->decimal('saldoTotal', 17, 2);
            $table->decimal('saldoConsiderado', 17, 2);
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
        Schema::dropIfExists('TBL_SIAF_HISTORICO_SALDO_CONTA_AMORTIZACOES');
    }
}
