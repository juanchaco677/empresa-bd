<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Eventos;
use App\Imagenes;
use App\Archivos;
use App\ArchivosApp;
use App\User;
use App\Publicaciones;
class EventoController extends Controller
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


    public function getEventos(Request $request){
        $buscar=$request->buscar;
        if(!empty($buscar)){
 
            $inicial=$request->inicial;
   
            $eventos=Eventos::join("imagenes","eventos.id","imagenes.id_evento")
            ->where("titulo","like","%".$buscar."%")->skip($inicial)->take($inicial+10)
            ->select("eventos.*","imagenes.id as id_imagen","imagenes.foto")->get();

            if(!empty($eventos)){
               
                return response()->json(["success"=>true,"data"=>$eventos,"imagenes"=>""]);
            }

            return response()->json(["success"=>false,"data"=>"No hay eventos creados"]);
        }        
        return response()->json(["success"=>false,"data"=>"Variable buscar vacia"]);
    }
    
    public function storeEvento(Request $request){
	$evento=new Eventos();
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
   	   return response()->json(["success"=>true,"data"=>"Se registro correctamente el evento."],200);
	}
        return response()->json(["success"=>false,"data"=>"Ocurrio un error al registrar el evento."],401);
    }



    public function deleteEvento(Request $request){
	$imagen=Imagenes::where("id_evento","=",$request->id);
	$imagen->delete();	
  	$comentarios=Publicaciones::where("id_evento","=",$request->id);
	$comentarios->delete();
	$evento=Eventos::find($request->id);
	$evento->delete();
	return response()->json(["success"=>true,"data"=>"Se Elimino correctamente el evento."],200);
    }
}
