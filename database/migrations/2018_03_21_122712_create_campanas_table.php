<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCampanasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campanas', function (Blueprint $table) {
          $table->increments('id');
          $table->string('imagen',50)->nullable();
          $table->string('elecciones',35)->nullable();
          $table->text('eslogan')->nullable();
          $table->integer('ancho')->nullable()->default(0);
          $table->integer('alto')->nullable()->default(0);
          $table->integer('meta')->nullable()->default(0);
          $table->integer('id_candidato')->unsigned()->nullable();
          $table->foreign('id_candidato')
              ->references('id')
              ->on('users');
          $table->integer('id_ano')->unsigned();
          $table->foreign('id_ano')
              ->references('id')
              ->on('anos');
          $table->integer('id_mes')->unsigned()->nullable();
          $table->foreign('id_mes')
              ->references('id')
              ->on('mes');
          $table->integer('dia')->nullable();
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
        Schema::dropIfExists('campanas');
    }
}
