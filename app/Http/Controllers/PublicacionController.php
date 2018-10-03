<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Publicaciones;
use App\Imagenes;
use App\User;
class PublicacionController extends Controller
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

    public function getPublicaciones(Request $request){
	$publicaciones=User::join("publicaciones","users.id","publicaciones.id_comenta")
                         ->where("id_evento","=",$request->id_evento)
                         ->select("publicaciones.id","publicaciones.id_evento","publicaciones.id_comenta","publicaciones.descripcion",
                                  "users.name","users.name2","users.lastname","users.lastname2","publicaciones.created_at","publicaciones.updated_at")->get();        
	$imagenes=Imagenes::where("id_evento","=",$request->id_evento)->get();
        return response()->json(["success"=>true,"data"=>$publicaciones,"imagenes"=>$imagenes],200);
    }
    public function storePublicacion(Request $request){
	$publicacion=new Publicaciones();
	$publicacion->descripcion=$request->comentario;
	$publicacion->id_evento=$request->id_evento;
	$publicacion->id_comenta=$request->id_comenta;
    $publicacion->save();
  
	return response()->json(["success"=>true,"data"=>$publicacion,"usuario"=>User::find($request->id_comenta)],200);
    }
}
