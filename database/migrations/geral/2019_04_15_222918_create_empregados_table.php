<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmpregadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TBL_EMPREGADOS', function (Blueprint $table) {
            $table->string('matricula', 7)->unique();
            $table->string('nomeCompleto', 50);
            $table->string('primeiroNome', 15);
            $table->string('dataNascimento', 10)->nullable();
            $table->smallInteger('codigoFuncao')->nullable();
            $table->string('nomeFuncao', 30)->nullable();
            $table->smallInteger('codigoLotacaoAdministrativa');
            $table->string('nomeLotacaoAdministrativa', 40);
            $table->smallInteger('codigoLotacaoFisica')->nullable();
            $table->string('nomeLotacaoFisica', 40)->nullable();
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
        Schema::dropIfExists('TBL_EMPREGADOS');
    }
}
