<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Campana extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'imagen',  'codigo','id_ano','id_mes','eslogan'
  ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'id','id_ano','id_mes'
      ];

    public static final function buscar($id)
    {
      return $this->where("id_candidato","=",$id)->fisrt();
    }

}
