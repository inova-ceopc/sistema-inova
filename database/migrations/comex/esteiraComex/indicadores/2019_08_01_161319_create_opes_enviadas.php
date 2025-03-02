<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOpesEnviadas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_SIEXC_OPES_ENVIADAS', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('quantidade');
            $table->date('dia');
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
        Schema::dropIfExists('tbl_SIEXC_OPES_ENVIADAS');
    }
}