<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlteraEmpregadosTable extends Migration
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
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('TBL_EMPREGADOS', function (Blueprint $table) {
            $table->string('matricula', 7)->unique();
        });
    }
}
