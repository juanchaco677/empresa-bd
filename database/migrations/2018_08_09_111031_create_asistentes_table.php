<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAsistentesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asistentes', function (Blueprint $table) {
        
            $table->integer('id_user')->unsigned();
             $table->foreign('id_user')->references('id')
                   ->on('users')->onDelete('cascade');
             $table->integer('id_evento')->unsigned();
             $table->foreign('id_evento')->references('id')
           ->on('eventos')->onDelete('cascade');
            $table->primary(array('id_user','id_evento'));
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
        Schema::dropIfExists('asistentes');
    }
}
