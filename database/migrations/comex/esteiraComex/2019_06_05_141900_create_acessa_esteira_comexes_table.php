<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAcessaEsteiraComexesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TBL_ACESSA_ESTEIRA_COMEX', function (Blueprint $table) {
            $table->string('matricula', 7);
            $table->string('nivelAcesso', 30);
            $table->smallInteger('unidade');
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
        Schema::dropIfExists('TBL_ACESSA_ESTEIRA_COMEX');
    }
}
