<?php

namespace App\Http\Controllers;

use App\PuntosVotacion;
use Illuminate\Http\Request;
use App\Evssa\EvssaPropertie;
use App\Evssa\EvssaConstantes;
use App\Evssa\EvssaUtil;
use App\Evssa\EvssaException;
use Illuminate\Support\Facades\Validator;
use App\Ciudades;
use App\Reporteador;
use App\Localizacione;
use JavaScript;
use Illuminate\Support\Facades\Auth;
class PuntoVotacionController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {

    return response()->json(view("lugar.punto.listar")->with(["urllistar"=>"punto","urlgeneral"=>url("/"),"listapuntovotacion"=>$this->cargarListaPunto()])->render());
  }

  private function cargarListaPunto(){
    return Ciudades::join("localizaciones","ciudades.id","localizaciones.id_ciudad")
                    ->join("puntos_votacions","localizaciones.id","puntos_votacions.id_localizacion")
                    ->join("mesas_votacions","puntos_votacions.id","mesas_votacions.id_punto")
                    ->join("users","mesas_votacions.id","users.id_mesa")
                    ->where("users.type","=","E")
                    ->where("users.id_candidato","=",Auth::user()->id)
                    ->select("localizaciones.direccion","puntos_votacions.id","puntos_votacions.nombre","ciudades.nombre as ciudad")
                    ->paginate(10);
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
          'direccion' => 'required|string|max:255',
          'id_ciudad' => 'required|string|max:255'
        ],
        [
          'direccion.required'=>str_replace('s$nombre$s','direccion',EvssaPropertie::get('TB_OBLIGATORIO_MENSAJE')),
          'id_ciudad.required'=>str_replace('s$nombre$s','ciudad',EvssaPropertie::get('TB_OBLIGATORIO_MENSAJE')),

        ]);

  }
  /**
   * Get the post register / login redirect path.
   *
   * @return string
   */
  public function redirectPath()
  {
      if (method_exists($this, 'redirectTo')) {
          return $this->redirectTo();
      }

      return property_exists($this, 'redirectTo') ? $this->redirectTo : '/home';
  }
  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
      //

      return response()->json(view("lugar.punto.crear")->with(["formulario"=>"I",'urldespliegue'=>'listadespliegueciudad','idname'=>'id_ciudad'])->render());
  }
  /**
   * Create a new user instance after a valid registration.
   *
   * @param  array  $data
   * @return \App\Punto de votacion
   */
  public function insertar(array $data)
  {
      $ciudad=Ciudades::find($data['id_ciudad']);
      $localizacion=new Localizacione();
      $localizacion=$localizacion->buscar($data['direccion'],null,null,$ciudad->id);
      $punto=new PuntosVotacion();
      $punto->nombre=$data['nombre'];
      $punto->id_localizacion=$localizacion->id;
      $punto->save();
  }
  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    try{

      $this->validator($request->all())->validate();
      $this->insertar($request->all());

      return response()->json([
          EvssaConstantes::NOTIFICACION=> EvssaConstantes::SUCCESS,
          EvssaConstantes::MSJ=>"Se ha insertado correctamente la punto.",
          "html"=>response()->json(view("lugar.punto.listar")->with(["urllistar"=>"punto","urlgeneral"=>url("/"),"listapuntovotacion"=>$this->cargarListaPunto()])->render())
      ]);
    } catch (EvssaException $e) {
        return response()->json([
            EvssaConstantes::NOTIFICACION=> EvssaConstantes::DANGER,
            EvssaConstantes::MSJ=>$e->getMensaje(),
        ],400);
    } catch (\Illuminate\Database\QueryException $e) {
         return response()->json([
             EvssaConstantes::NOTIFICACION=> EvssaConstantes::DANGER,
             EvssaConstantes::MSJ=>"Registro secundario encontrado",
         ],400);
    }

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
    $punto=PuntosVotacion::find($id);
    return response()->json(view("lugar.punto.crear")->with(["formulario"   =>"A",
                                                              'urldespliegue'=>'listadespliegueciudad',
                                                              'idname'=>'id_ciudad',
                                                              'punto'=>$punto,
                                                              'objeto'=>Ciudades::find($punto->id_ciudad)])->render());

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
    try{

        $this->validator($request->all())->validate();
        $this->actualizar(PuntosVotacion::find($id),$request->all());
        return response()->json([
            EvssaConstantes::NOTIFICACION=> EvssaConstantes::SUCCESS,
            EvssaConstantes::MSJ=>"Se ha actualizado correctamente el punto de votación.",
            "html"=>response()->json(view("lugar.punto.listar")->with(["urllistar"=>"punto","urlgeneral"=>url("/"),"listapuntovotacion"=>$this->cargarListaPunto()])->render())
        ]);
      } catch (EvssaException $e) {
          return response()->json([
              EvssaConstantes::NOTIFICACION=> EvssaConstantes::DANGER,
              EvssaConstantes::MSJ=>$e->getMensaje(),
          ],400);
      } catch (\Illuminate\Database\QueryException $e) {
           return response()->json([
               EvssaConstantes::NOTIFICACION=> EvssaConstantes::DANGER,
               EvssaConstantes::MSJ=>"Registro secundario encontrado",
           ],400);
      }
  }

  /**
   * Create a new user instance after a valid registration.
   *
   * @param  array  $data
   * @return \App\Ciudad
   */
  private function actualizar($punto,array $data)
  {


      $punto->nombre=$data['nombre'];
      $punto->id_ciudad=$data['id_ciudad'];
      $punto->direccion=$data['direccion'];
      $punto->save();
}
  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
       try {
         PuntosVotacion::find($id)->delete();
         return response()->json([
             EvssaConstantes::NOTIFICACION=> EvssaConstantes::SUCCESS,
             EvssaConstantes::MSJ=>"Se ha eliminado correctamente el registro.",
             "html"=>response()->json(view("lugar.punto.listar")->with(["urllistar"=>"punto","urlgeneral"=>url("/"),"listapuntovotacion"=>$this->cargarListaPunto()])->render())
         ]);
        } catch (EvssaException $e) {
            return response()->json([
                EvssaConstantes::NOTIFICACION=> EvssaConstantes::DANGER,
                EvssaConstantes::MSJ=>$e->getMensaje(),
            ],400);
        } catch (\Illuminate\Database\QueryException $e) {
             return response()->json([
                 EvssaConstantes::NOTIFICACION=> EvssaConstantes::DANGER,
                 EvssaConstantes::MSJ=>"Registro secundario encontrado",
             ],400);
        }
  }
  /**
  *lista todos los ciudades
  */

  public function cargarListaCombo(Request $request)
  {

      if($request->ajax()){
          return response()->json($this->buscar("combos.grande",$request)->render());
      }else{
          return $this->buscar('combos.grande',$request);
      }
  }

  private function buscar($vista,Request $request)
  {
      $ciudades=new Ciudades();
      return view($vista)->with([
          "departamentos"=>$ciudades->getListarCiudades($request),
          "entrada"=>"entrada-ciudad",
          "entradaid"=>"entrada-ciudad-id"
      ]);
  }
  public function cargarDespliegueCombo(Request $request){

    $ciudad=new Ciudades();

    return response()->json(view("combos.despliegue")->with(["lista"=>$ciudad->getListarCiudadDespliegue($request->buscar)])->render());
  }
  public function cargarDespliegueComboFinal(Request $request){

        $punto=PuntosVotacion::join("localizaciones","puntos_votacions.id_localizacion","localizaciones.id")
        ->where('direccion','like','%'.$request->buscar.'%')->where("id_ciudad","=",$request->id)->select("puntos_votacions.id","localizaciones.id_ciudad","localizaciones.direccion","puntos_votacions.nombre")->get();
    return response()->json(view("combos.desplieguepunto")->with(["listapunto"=>$punto])->render());

  }
  public function refrescar(Request $request){

    return response()->json(view("lugar.punto.tabla")->with(["urllistar"=>"punto","urlgeneral"=>url("/"),"listapuntovotacion"=>
          Ciudades::join("localizaciones","ciudades.id","localizaciones.id_ciudad")
          ->join("puntos_votacions","localizaciones.id","puntos_votacions.id_localizacion")
          ->join("mesas_votacions","puntos_votacions.id","mesas_votacions.id_punto")
          ->join("users","mesas_votacions.id","users.id_mesa")  
          ->orWhere("puntos_votacions.nombre","like","%".$request->buscar."%")
          ->orWhere("localizaciones.direccion","like","%".$request->buscar."%")
          ->orWhere("ciudades.nombre","like","%".$request->buscar."%")
          ->where("users.type","=","E")
          ->where("users.id_candidato","=",Auth::user()->id)
          ->select("localizaciones.direccion","puntos_votacions.id","puntos_votacions.nombre","ciudades.nombre as ciudad")
          ->paginate(10)
    ])->render());
  }


  public function googleMaps(){
    $id_candidato=Auth::user()->type=='S'?Auth::user()->id:Auth::user()->id_candidato;
    $puntos=\DB::select('select nit,concat_ws(" ",users.name,users.name2,users.lastname,users.lastname2) as nombres,cantidad,punto_id,departamentos.nombre as departamentos,localizaciones.direccion,ciudades.nombre as ciudades,localizaciones.latitud,localizaciones.longitud  from departamentos
                    inner join ciudades on
                    departamentos.id=ciudades.id_departamento
                    inner join localizaciones on
                    ciudades.id=localizaciones.id_ciudad
                    inner join puntos_votacions on
                    localizaciones.id=puntos_votacions.id_localizacion
                    inner join mesas_votacions on
                    puntos_votacions.id=mesas_votacions.id_punto
                    inner join users on
                    mesas_votacions.id=users.id_mesa
                    inner join (select count(mesas_votacions.id_punto) as cantidad,mesas_votacions.id_punto as punto_id  from departamentos
                                    inner join ciudades on
                                    departamentos.id=ciudades.id_departamento
                                    inner join localizaciones on
                                    ciudades.id=localizaciones.id_ciudad
                                    inner join puntos_votacions on
                                    localizaciones.id=puntos_votacions.id_localizacion
                                    inner join mesas_votacions on
                                    puntos_votacions.id=mesas_votacions.id_punto
                                    inner join users on
                                    mesas_votacions.id=users.id_mesa
                                         where  users.id_candidato='.$id_candidato.'
                                    group by mesas_votacions.id_punto) as tabla on
                    puntos_votacions.id=tabla.punto_id
                    where  users.id_candidato='.$id_candidato.'
                    order by punto_id');
    

    JavaScript::put(['puntos' =>$puntos]);

    return view('maps.mapa');
  }

  public function localizacionDireccion(){
    $localizacion=\DB::select('select localizaciones.direccion,ciudades.nombre as ciudades,departamentos.nombre as departamentos,localizaciones.id from departamentos
                    inner join ciudades on
                    departamentos.id=ciudades.id_departamento
                    inner join localizaciones on
                    ciudades.id=localizaciones.id_ciudad
                    inner join puntos_votacions on
                    localizaciones.id=puntos_votacions.id_localizacion
                    where localizaciones.latitud IS NULL and localizaciones.longitud IS NULL
                    and localizaciones.estado=1
                    order by id asc
                    LIMIT 0,10');
      JavaScript::put(['localizacion' => $localizacion]);

      return response()->json(view("maps.procesarlocalizacion")->render());

  }

  public function actualizarlocalizacion(Request $request){
      $array=json_decode($request->data);

      foreach($array as $localizacion){

            $geocode=Localizacione::find($localizacion->id);
            $geocode->direccion=$localizacion->direccion;
            $geocode->latitud=$localizacion->latitud;
            $geocode->longitud=$localizacion->longitud;
            $geocode->estado=$localizacion->estado;
            $geocode->save();

      }

      $localizacion=\DB::select('select localizaciones.direccion,ciudades.nombre as ciudades,departamentos.nombre as departamentos,localizaciones.id from departamentos
                      inner join ciudades on
                      departamentos.id=ciudades.id_departamento
                      inner join localizaciones on
                      ciudades.id=localizaciones.id_ciudad
                      inner join puntos_votacions on
                      localizaciones.id=puntos_votacions.id_localizacion
                      where localizaciones.latitud is null and localizaciones.longitud is null
                      and localizaciones.estado=1
                      order by id asc
                      LIMIT 0,10');
        JavaScript::put(['localizacion' => $localizacion]);

        return response()->json(view("maps.procesarlocalizacion")->render());
  }
  /**
  *metodo que al oprimir el boton pdf se descarga el listado de personas o reporte en pdf
  */
  public function oprimirPdf($buscar){

    $reemplazos=array(
          "buscar"=>$buscar==".c*"?"":str_replace(" ",".c*",$buscar)
    );
    $param=array("PR_STRSQL"=>Reporteador::resuelveConsulta("002PUNTOSVOTACION",$reemplazos));

    Reporteador::exportar("002PUNTOSVOTACION",EvssaConstantes::PDF,$param);
  }

  /**
  *metodo que al oprimir el boton pdf se descarga el listado de personas o reporte en excel
  */
  public function oprimirExcel($buscar){
    $reemplazos=array(
          "buscar"=>$buscar==".c*"?"":str_replace(" ",".c*",$buscar)
    );
    $param=array("PR_STRSQL"=>Reporteador::resuelveConsulta("002PUNTOSVOTACION",$reemplazos));

    Reporteador::exportar("002PUNTOSVOTACION",EvssaConstantes::EXCEL,$param);
  }
}
