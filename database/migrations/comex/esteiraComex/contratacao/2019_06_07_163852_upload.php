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
            $table->integer('idDemanda'); //chave estrangeira
            $table->dateTime('dataInclusao');
            $table->string('cpf', 14)->nullable();
            $table->string('cnpj', 18)->nullable();
            $table->string('tipoDoDocumento', 50);
            $table->string('nomeDoDocumento', 50);
            $table->string('caminhoDoDocumento', 100);
            $table->string('excluido', 3);
            $table->dateTime('dataExcluido')->nullable();
            $table->string('responsavelExclusao', 7)->nullable();
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
