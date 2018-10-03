<?php
/**
 * Created by PhpStorm.
 * User: Juan Camilo
 * Date: 18/11/2017
 * Time: 10:39 PM
 */

namespace App;


class Usuario
{

    private $nombre1;
    private $nombre2;
    private $apellido1;
    private $apellido2;

    public function setNombre1($nombre){
       $this->nombre1=$nombre;
    }
    public function setNombre2($nombre){
       $this->nombre2=$nombre;
    }
    public function setApellido1($apellido){
       $this->apellido1=$apellido;
    }
    public function setApellido2($apellildo){
       $this->apellido2=$apellildo;
    }


    public function getNombre1(){
      return $this->nombre1;
    }
    public function getNombre2(){
      return $this->nombre2;
    }
    public function getApellido1(){
      return $this->apellido1;
    }
    public function getApellido2(){
      return $this->apellido2;
    }

}
