<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Campana;
use App\CampanaUsuarios;
use App\Evssa\EvssaConstantes;
use App\Evssa\EvssaUtil;
use App\Evssa\EvssaException;
use Illuminate\Support\Facades\Validator;
use App\Evssa\EvssaPropertie;
use Illuminate\Support\Facades\Auth;
use App\Archivos;
use App\Ano;
use App\Mes;
use Illuminate\Support\Facades\Session;

class CampanaController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return response()->json(view("campana.crear")->with(self::url())->render());
  }

  public final static function url(){

      $campana=Campana::where("id_candidato","=",Auth::user()->id)->first();
      if(empty($campana)){
        $campana=Campana::find(CampanaUsuarios::where("id_user","=",Auth::user()->id)->first()->id_campana);
      }

      return [
        "campana"=>$campana,
        "idano"=>"id_ano",
        "idmes"=>"id_mes",
        "urldespliegue"=>"listaano",
        "urldesplieguefinal"=>"listames",
        "ano"=>Ano::find($campana->id_ano),
        "mes"=>Mes::find($campana->id_mes)
      ];

  }
  /**
   * Get a validator for an incoming registration request.
   *
   * @param  array  $data
   * @return \Illuminate\Contracts\Validation\Validator
   */
  public function validator(array $data)
  {
      return Validator::make($data, [
          'id_ano' => 'required',
          'id_mes' =>'required',
        ],
         [
          'id_ano.required'=>str_replace('s$nombre$s','ano',EvssaPropertie::get('TB_OBLIGATORIO_MENSAJE')),
          'id_mes.required'=>str_replace('s$nombre$s','mes',EvssaPropertie::get('TB_OBLIGATORIO_MENSAJE')),

        ]
    );

  }
  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {

  }
  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {

  }
  /**
   * Create a new user instance after a valid registration.
   *
   * @param  array  $data
   * @return \App\Ano
   */
  public function insertar(array $data)
  {

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
    $campana=Campana::find($id);
    return response()->json(view("campana.crear")->with(["formulario"=>"A",
    "campana"=>$campana,
    "idano"=>"id_ano",
    "idmes"=>"id_mes",
    "urldespliegue"=>"listaano",
    "urldesplieguefinal"=>"listames",
    "ano"=>Ano::find($campana->id_ano),
    "mes"=>Mes::find($campana->id_mes)])->render());
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

  try{
      $this->validator($request->all())->validate();
      if (!empty($request->file('photo'))) {
        $this->validatePhoto($request->all())->validate();
      }
      $campana=Campana::find($id);
      $this->actualizar($campana,$request);
      Session::flash("notificacion","SUCCESS");
      Session::flash("msj","Se actualizo correctamente los datos generales.");
      return back()->with([
          "formulario"=>"A",
          "campana"=>$campana,
          "idano"=>"id_ano",
          "idmes"=>"id_mes",
          "urldespliegue"=>"listaano",
          "urldesplieguefinal"=>"listames",
          "ano"=>Ano::find($campana->id_ano),
          "mes"=>Mes::find($campana->id_mes)]);
    } catch (EvssaException $e) {
      Session::flash("notificacion","DANGER");
      Session::flash("msj","Hubo un problema al actualizar los datos generales.");
      return back();
    } catch (\Illuminate\Database\QueryException $e) {
      Session::flash("notificacion","DANGER");
      Session::flash("msj","Registro secundario encontrado.");
      return back();
    }
  }
  private function validatePhoto(array $data){
    return Validator::make($data, [
        'photo' =>'mimes:jpeg,jpg,png,gif'
      ],
       [
          'photo.mimes'=>EvssaPropertie::get('TB_FORMATO'),
      ]
      );
  }
  /**
   * Create a new user instance after a valid registration.
   *
   * @param  array  $data
   * @return \App\General
   */
  private function actualizar($campana,Request $request)
  {

      $data=$request->all();

      if (!empty($request->file('photo'))) {
          $archivo = new Archivos ($request->file('photo'));
          $campana->imagen = $archivo -> getNombreSuper();
      }


      if (!empty($request->file('photo'))) {
          $archivo->guardarArchivoSuper();
      }

      $campana->id_ano=$data['id_ano'];
      $campana->id_mes=$data['id_mes'];
      $campana->dia=$data['dia'];
      $campana->ancho=$data['ancho'];
      $campana->alto=$data['alto'];
      $campana->elecciones=$data['elecciones'];
      $campana->meta=$data['meta'];
      $campana->eslogan=$data['eslogan'];
      $campana->save();


  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {

  }

/**
*refrescar la tabla
*/
    public function refrescar(Request $request){

      return response()->json(view("periodo.ano.tabla")->with(["urllistar"=>"ano","urlgeneral"=>url("/"),"listaano"=>Ano::where("numero","like","".$request->buscar."%")->paginate(10)])->render());
  }
}
