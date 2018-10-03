<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eventos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('titulo',60);
            $table->enum ( 'type',['N','E'])->default('E');
            $table->mediumText('descripcion');
            $table->integer('id_creador')->unsigned();
            $table->foreign('id_creador')
                  ->references('id')
                  ->on('users');
            $table->timestamps();
            //TYPE N=NOTICIA, E=EVENTO
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('eventos');
    }
}
