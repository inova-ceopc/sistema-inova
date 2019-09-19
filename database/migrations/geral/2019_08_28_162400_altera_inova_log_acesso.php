<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlteraInovaLogAcesso extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('TBL_INOVA_LOG_ACESSOS', function (Blueprint $table) {
            $table->dateTime('dataAcesso')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('TBL_INOVA_LOG_ACESSOS', function (Blueprint $table) {
            $table->date('dataAcesso')->change();
        });
    }
}
