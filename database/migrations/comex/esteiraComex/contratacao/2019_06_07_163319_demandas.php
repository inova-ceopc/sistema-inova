<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Demandas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('TBL_EST_CONTRATACAO_DEMANDAS', function (Blueprint $table) 
        {
            $table->increments('idDemanda');
            $table->string('tipoPessoa', 2);
            $table->string('cpf', 14)->nullable();
            $table->string('cnpj', 18)->nullable();
            $table->string('nomeCliente', 100);
            $table->string('dadosContaCliente', 20);
            $table->string('tipoOperacao', 60);
            $table->string('tipoMoeda', 3);
            $table->decimal('valorOperacao', 17, 2);
            $table->date('dataPrevistaEmbarque')->nullable();
            $table->date('dataLiquidacao')->nullable();
            $table->string('statusAtual', 100);
            $table->string('responsavelAtual', 7);
            $table->string('agResponsavel', 4)->nullable();
            $table->string('srResponsavel', 4)->nullable();
            $table->text('analiseCeopc')->nullable();
            $table->text('analiseAg')->nullable();
            $table->string('numeroBoleto', 10)->nullable();
            $table->decimal('equivalenciaDolar', 17, 2)->nullable();
            $table->string('responsavelCeopc', 7)->nullable();
            $table->date('dataCadastro');
            $table->string('mercadoriaEmTransito', 3)->nullable();
            $table->string('cnaeRestrito', 3)->nullable();
            $table->string('liberadoLiquidacao', 3)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('TBL_EST_CONTRATACAO_DEMANDAS');
    }
}
