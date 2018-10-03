<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imagenes;
use App\Eventos;
use App\Publicaciones;
use App\User;
use App\ArchivosApp;
class ImagenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getImagenesFoto(Request $request){
	$eventoImagenes=Eventos::join("imagenes","eventos.id","imagenes.id_evento")
		       ->select("imagenes.id","imagenes.id_evento","imagenes.foto","imagenes.created_at","imagenes.updated_at")
		       ->where("eventos.id","=",$request->id_evento)->get();          
	if(!empty($eventoImagenes)){
		return response()->json(["imagenesTabla"=>$eventoImagenes,"data"=>"Carga de lista de imagenes."],200);
	}
	return response()->json(["success"=>false,"error"=>"error buscando los datos"],401);
	
    }

    public function storeDeleteImagen(Request $request){

	if(!empty($request->imagenestabla)){	
	   foreach ($request->imagenestabla as $key => $value) {	
		$imagen=Imagenes::find($value["id"]);
	        $imagen->delete();			            	
	   }
	}

  	if(count($request->imagenestabla) == 1){
    	      $comentarios=Publicaciones::where("id_evento","=",$request->id);
	      $comentarios->delete();
	      $evento=Eventos::find($request->id);
	      $evento->delete();
	      return response()->json(["success"=>false,"data"=>"Redireccionar."],200);	  
	}
	$evento=Eventos::find($request->id);
	$evento->titulo=$request->titulo;
	$evento->descripcion=$request->descripcion;
	$evento->id_creador=$request->id_creador;
    $evento->save();
    
        if(!empty($evento)){
            if(!empty($request->imagenes)){
                foreach ($request->imagenes as $key => $value) {
                    $archivo=new ArchivosApp($value,User::find($request->id_creador));
                    $archivo->guardarArchivo64();
                    $imagenes=new Imagenes();
                    $imagenes->id_evento=$evento->id;
                    $imagenes->foto=$archivo->getRutaExtension();
                    $imagenes->save();
                }
            }
        return response()->json(["success"=>true,"data"=>"Se actualizo correctamente el evento."],200);
        }
	
    }



}
