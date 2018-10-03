<?php

namespace App;

use Carbon\Carbon;
class ArchivosApp {
    private $ruta;
    private $file;
    private $usuario;
    private $nombreRuta;
    private $foto;
    /**
     * constructor de la clase recibe un archivo
     * @param  $file
     */
    public function __construct ($file,$usuario)
    {
        $DesdeLetra = "a";
        $HastaLetra = "z";
        $DesdeNumero = 1;
        $HastaNumero = 10000;
        
        $letraAleatoria = chr(rand(ord($DesdeLetra), ord($HastaLetra)));
        $numeroAleatorio = rand($DesdeNumero, $HastaNumero);
        $this->file=$file;
        $this->usuario=$usuario;
        $name=$numeroAleatorio.''.$letraAleatoria.''.time().''.date('hisjmy').'.jpg';
        $this->foto='/imagenes'.$usuario->tipo.'/'.$usuario->id.'/'.$name;
        $this->ruta=public_path().'/imagenes/'.$usuario->tipo.'/'.$usuario->id;
        $this->rutaextension=$this->ruta.'\\'.$name;
     
    }

    public function getRutaExtension(){
        return $this->foto;
    }

    
    public function guardarArchivo64(){
        $imagen=$this->file;
        $imagen=str_replace('data:image/jpeg;base64,','',$imagen);
        $imagen=str_replace('data:image/jpg;base64,','',$imagen);
        $imagen=str_replace(' ','+',$imagen);
        $imagen=base64_decode($imagen);
       
        if (!file_exists($this->ruta)) {
            mkdir($this->ruta, 0777, true);
        }
        file_put_contents($this->rutaextension,$imagen);     
    }



}
