<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAcessaEmpregadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TBL_ACESSA_EMPREGADOS', function (Blueprint $table) {
            $table->string('matricula', 7);
            $table->string('nivelAcesso', 30);
            $table->smallInteger('unidade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('TBL_ACESSA_EMPREGADOS');
    }
}
