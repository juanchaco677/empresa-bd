<?php

use Illuminate\Database\Seeder;

class Campana extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('campanas')->delete();
      \App\Campana::create([
          'id'=>1,
          'imagen'	   =>	'default.png',
          'ancho'=>50,
          'alto'=>50,
          'id_ano'=>117,
          'id_mes'=>12,
          'dia'=>30,
          'meta'=>0,
      ]);
    }
}
