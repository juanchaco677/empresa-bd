<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCampanaUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campana_usuarios', function (Blueprint $table) {

             $table->integer('id_user')->unsigned();
             $table->foreign('id_user')->references('id')
                   ->on('users')->onDelete('cascade');
             $table->integer('id_campana')->unsigned();
             $table->foreign('id_campana')->references('id')
           ->on('campanas')->onDelete('cascade');
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
        Schema::dropIfExists('campana_usuarios');
    }
}
