<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Localizacione extends Model
{

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'latitud', 'longitud', 'direccion','id_ciudad'
      ];
  public function buscar($direccion,$latitud,$longitud,$id_ciudad){
      $ciudad=$this->where("direccion","=",$direccion)->where("id_ciudad","=",$id_ciudad)->first();
      if(empty($ciudad)){
          return $this->crear($direccion,$latitud,$longitud,$id_ciudad);
      }
      return $ciudad;
  }
  public function buscarLocalizacion($direccion,$latitud,$longitud,$id_ciudad){
    $ciudad=$this->where("latitud","=",$latitud)->where("longitud","=",$longitud)->first();
    if(empty($ciudad)){
        return $this->crear($direccion,$latitud,$longitud,$id_ciudad);
    }
    return $ciudad;
}

  public function crear($direccion,$latitud,$longitud,$id_ciudad){
      $this->direccion=$direccion;
      $this->latitud=empty($latitud)?null:$latitud;
      $this->longitud=empty($longitud)?null:$longitud;
      $this->id_ciudad=empty($longitud)?null:$id_ciudad;
      $this->save();
      return $this;
  }
}
