<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePuntosVotacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('puntos_votacions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre',60)->nullable();
            $table->integer('id_localizacion')->unsigned();
            $table->foreign('id_localizacion')
                    ->references('id')
                    ->on('localizaciones');
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
        Schema::dropIfExists('puntos_votacions');
    }
}
