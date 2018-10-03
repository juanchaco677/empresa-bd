<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use App\User;
use App\Ciudades;
use App\Departamentos;
use App\Historialobservacion;
use App\Campana;
use App\CampanaUsuarios;
use App\Ano;
use App\Mes;
use App\Eventos;
use App\Imagenes;
Route::get('evento',function (){

  return $eventos=Eventos::join("imagenes","eventos.id","imagenes.id_evento")
  ->where("titulo","like","%e%")->skip(0)->take(2)
  ->select("eventos.*","imagenes.id as id_imagen","imagenes.foto")->get();
});
Route::get('enviosms', 'UsuarioEController@envioSms');


Route::get('fosyga','ConsultarInformacionElectoral@fosyga');
Route::resource('consultareporte','ConsultaController');

Route::get('/consulta', function () {
    return view('consulta');
});

Route::get('/cargando', function () {
    return view('layouts.cargando');
});
Route::get('listadepartamentos','DepartamentoController@cargarListaCombo');

Route::get('listaciudades','CiudadController@cargarListaCombo');


Route::get('listadesplieguedepartamento','DepartamentoController@cargarDespliegueCombo');

Route::get('listadespliegueciudad','CiudadController@cargarDespliegueCombo');

Route::get('listadespliegueciudadfinal','CiudadController@cargarDespliegueComboFinal');

Route::get('listadesplieguemesa','MesaVotacionController@cargarDespliegueComboMesa');

Route::get('listadesplieguepuntofinal','PuntoVotacionController@cargarDespliegueComboFinal');

Route::get('listadesplieguepunto','MesaVotacionController@cargarDespliegueCombo');

Route::get('datosregistraduria','ConsultarInformacionElectoral@index');

Route::get('location','ConsultarInformacionElectoral@consultarCoordenadas');



Route::get('/', function () {

    if(!Auth::guard()){
      $campana=Campana::find(1);
      $usuario=new User();
      $usuario=$usuario->cantidadPotencialElectoralTodo();

      return view('welcome')->with([
        "general"=>$campana,
        "ano"=>Ano::find($campana->id_ano),
        "mes"=>Mes::find($campana->id_mes),
        "usuario"=>$usuario,
        "porcentaje"=>$campana->meta==0?0:round((100*$usuario->cantidadreal)/$campana->meta,2),
        ]);
    }else if(Auth::user() == null){
      $campana=Campana::find(1);

      $usuario=new User();
      $usuario=$usuario->cantidadPotencialElectoralTodo();

      return view('welcome')->with([
        "general"=>$campana,
        "ano"=>Ano::find($campana->id_ano),
        "mes"=>Mes::find($campana->id_mes),
        "usuario"=>$usuario,
        "porcentaje"=>$campana->meta==0?0:round((100*$usuario->cantidadreal)/$campana->meta,2),
        ]);

    }else{
      $campana=Campana::where("id_candidato","=",Auth::user()->id)->first();
      $usuario=new User();
      $usuario=$usuario->cantidadPotencialElectoralTodo();

      return view('welcome')->with([
        "general"=>$campana,
        "ano"=>Ano::find($campana->id_ano),
        "mes"=>Mes::find($campana->id_mes),
        "usuario"=>$usuario,
        "porcentaje"=>$campana->meta==0?0:round((100*$usuario->cantidadreal)/$campana->meta,2),
        ]);
    }
    
});
Route::get('/prueba', function () {
  $usuario=User::find(8);

  return view("layouts.cargando");
});
Route::get('reporte', 'UsuarioEController@oprimirExcel');

Route::get('/cselect', function () {
return \DB::table('ciudades')->join("puntos_votacions","ciudades.id","puntos_votacions.id_ciudad")
                       ->join("mesas_votacions","puntos_votacions.id","mesas_votacions.id_punto")
                       ->join("users","mesas_votacions.id","users.id_mesa")
                       ->select(\DB::raw('COUNT(puntos_votacions.id) as contar, puntos_votacions.direccion,ciudades.nombre,users.name,users.name2,users.lastname,users.lastname2'))
                       ->groupBy('puntos_votacions.direccion','ciudades.nombre','users.name','users.name2','users.lastname','users.lastname2')
                       ->get();
});

Route::get('/otra',function(){

return Departamentos::join("ciudades","departamentos.id","ciudades.id_departamento")->select("ciudades.id","ciudades.nombre as ciudad","departamentos.nombre as departamento")->paginate(10);

});

Route::get('/select', function () {
  return config('app.url');
});
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
Route::group(['middleware'=>'super'],function(){
  Route::resource('usuarioe', 'UsuarioEController',  ['only' => ['create', 'store', 'update', 'destroy','edit']]);
  Route::resource('usuario', 'UsuarioAController',  ['only' => ['create', 'store', 'update', 'destroy','edit']]);
  Route::resource('observation', 'HistorialObservacionController');
  Route::resource('departamento', 'DepartamentoController',  ['only' => ['create', 'store', 'update', 'destroy','edit']]);
  Route::resource('ciudad', 'CiudadController',  ['only' => ['create', 'store', 'update', 'destroy','edit']]);
  Route::resource('punto', 'PuntoVotacionController',  ['only' => ['create', 'store', 'update', 'destroy','edit']]);
  Route::resource('mesa', 'MesaVotacionController',  ['only' => ['create', 'store', 'update', 'destroy','edit']]);
  Route::resource('campana', 'CampanaController',  ['only' => ['create', 'store', 'update', 'destroy','edit','index']]);
  Route::resource('ano', 'AnoController',  ['only' => ['create', 'store', 'update', 'destroy','edit']]);
  Route::resource('mes', 'MesController',  ['only' => ['create', 'store', 'update', 'destroy','edit']]);
  Route::get('reprocesar', 'PuntoVotacionController@localizacionDireccion');
  Route::post('actualizarlocalizacion', 'PuntoVotacionController@actualizarlocalizacion');


  Route::get('listaano','AnoController@cargarListaAno');
  Route::get('listames','MesController@cargarListaMes');
  Route::get('transferirdatos','UsuarioEController@transferirdatos');
  Route::get('rutamensaje','MensajeController@index');
  Route::post('mensajes','MensajeController@envioMensaje');
});

Route::group(['middleware'=>'comun'],function(){
  Route::resource('campana', 'CampanaController',  ['only' => ['create', 'store', 'update', 'destroy','edit','index']]);

  Route::get('usuarioe/refrescar', 'UsuarioEController@refrescar');
  Route::get('usuario/refrescar', 'UsuarioAController@refrescar');
  Route::get('oprimirusuariogeneralpdf/{buscar}', 'UsuarioAController@oprimirPdf');
  Route::get('oprimirusuariogeneralexcel/{buscar}', 'UsuarioAController@oprimirExcel');

  Route::resource('usuario', 'UsuarioAController',  ['only' => ['index']]);
  Route::resource('usuarioe', 'UsuarioEController',  ['only' => ['index','create', 'store', 'update', 'destroy','edit']]);
  Route::get('oprimirusuarioegeneralpdf/{buscar}', 'UsuarioEController@oprimirPdf');
  Route::get('oprimirusuarioegeneralexcel/{buscar}', 'UsuarioEController@oprimirExcel');

  //Departamentos
  Route::resource('departamento', 'DepartamentoController',  ['only' => ['index']]);
  Route::get('departamento/refrescar','DepartamentoController@refrescar');
  Route::get('oprimirdepartamentogeneralpdf/{buscar}', 'DepartamentoController@oprimirPdf');
  Route::get('oprimirdepartamentogeneralexcel/{buscar}', 'DepartamentoController@oprimirExcel');

  //Ciudad
  Route::resource('ciudad','CiudadController',['only' => ['index']]);
  Route::get('ciudad/refrescar','CiudadController@refrescar');
  Route::get('oprimirciudadgeneralpdf/{buscar}', 'CiudadController@oprimirPdf');
  Route::get('oprimirciudadgeneralexcel/{buscar}', 'CiudadController@oprimirExcel');

  //punto de
  Route::resource('punto', 'PuntoVotacionController',  ['only' => ['index']]);
  Route::get('punto/refrescar','PuntoVotacionController@refrescar');
  Route::get('oprimirpuntogeneralpdf/{buscar}', 'PuntoVotacionController@oprimirPdf');
  Route::get('oprimirpuntogeneralexcel/{buscar}', 'PuntoVotacionController@oprimirExcel');
  //mesavotacion
  Route::resource('mesa', 'MesaVotacionController',  ['only' => ['index']]);
  Route::get('mesa/refrescar', 'MesaVotacionController@refrescar');
  Route::get('oprimirpdf/{buscar}', 'MesaVotacionController@oprimirPdf');
  Route::get('oprimirexcel/{buscar}', 'MesaVotacionController@oprimirExcel');


  //buscar Referido
  Route::get('listardiferidos', 'UsuarioEController@buscarReferido');
  Route::get('google','PuntoVotacionController@googleMaps');
  Route::get('potencial','UsuarioEController@mostrarpotencial');
  //ano
  Route::resource('ano', 'AnoController',  ['only' => ['index']]);
  Route::get('ano/refrescar','AnoController@refrescar');
  //mes
  Route::resource('mes', 'mesController',  ['only' => ['index']]);
  Route::get('mes/refrescar','MesController@refrescar');
//formulari mesa informes
  Route::resource('mesaforminforme', 'MesaInformeController',  ['only' => ['index']]);
  Route::post('oprimirinformemesa', 'MesaInformeController@oprimirPdf')->name('oprimirPdf');
  Route::post('oprimirinformemesageneral', 'MesaInformeController@oprimirPdfGeneral')->name('oprimirPdfGeneral');

  Route::get('mesaforminformegeneral', 'MesaInformeController@general');
  Route::get('transferirdatos','UsuarioEController@transferirdatos');
  Route::get('rutamensaje','MensajeController@index');
  Route::post('mensajes','MensajeController@envioMensaje');
  
});
Route::group(['middleware'=>'admin'],function(){

});

Route::get('datos','ConsultarInformacionElectoral@consultarDatos');

Route::get("jar","UsuarioEController@registrarPorJar");