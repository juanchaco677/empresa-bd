<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CampanaUsuarios extends Model
{

    public static final function buscar ($id){
      return $this->where("id_campana","=",$id)->first();
    }
}
