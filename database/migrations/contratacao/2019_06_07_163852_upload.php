<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Upload extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TBL_EST_CONTRATACAO_LINK_UPLOADS', function (Blueprint $table) 
        {
            
            $table->increments('idUploadLink');
            $table->date('dataInclusao');
            $table->integer('idDemanda'); //chave estrangeira
            $table->string('cpf',11);
            $table->string('cnpj',14);
            $table->string('tipoDoDocumento',50);
            $table->string('excluido',3);
            $table->date('dataExcluido');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('TBL_EST_CONTRATACAO_LINK_UPLOADS');
    }
}
