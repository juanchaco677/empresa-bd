<?php

namespace App\Http\Controllers;

use App\ArrayList;
use App\Ciudades;
use App\Departamentos;
use App\PuntosVotacion;
use App\MesasVotacion;
use Illuminate\Http\Request;
use Goutte\Client;
use function Sodium\add;
use App\Evssa\EvssaConstantes;
use App\Evssa\EvssaUtil;
use App\Evssa\EvssaException;
use App\Evssa\EvssaPropertie;
use App\Usuario;
use App\User;
use App\Localizacione;
use Illuminate\Support\Facades\Validator;

class ConsultarInformacionElectoral extends Controller
{
    private $lista;

    private $nombres;

    private $usuario;

    private $user;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->lista=new ArrayList();
        $this->nombres = array();
        $this->usuario=new Usuario();
        $this->user=new User();
    }
    public function validator(array $data)
    {
        return Validator::make($data, [
            'cedula' => 'required|numeric',
        ],
        [
          'cedula.required'=>str_replace('s$nombre$s','cedula',EvssaPropertie::get('TB_OBLIGATORIO_MENSAJE')),
          'cedula.numeric'=>EvssaPropertie::get('TB_CEDULA'),

        ]
      );

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

      $this->validator($request->all())->validate();
      if($this->user->buscarUsuario($request->cedula)){
        return response()->json([
                      EvssaConstantes::NOTIFICACION=> EvssaConstantes::DANGER,
                      EvssaConstantes::MSJ=>"El usuario que intenta ingresar ya se encuentra en la base de datos",
                    ],404);
      }
      $client = new Client();
        if($request->mesa){
                  $nombre=array('','');
                  $apellido=array('','');


                $departamento=new Departamentos();
                $departamento=$departamento->buscar($request->departamento);

                $ciudad=new Ciudades();
                $ciudad=$ciudad->buscar($request->ciudad,$departamento);
        
                $localizacion=new Localizacione();
                $localizacion=$localizacion->buscarLocalizacion($request->direccion,$request->latitud,$request->longitud,$ciudad->id);
                $punto=new PuntosVotacion();

                $punto=$punto->getBuscarDireccion($request->nombre,$localizacion->id);

                $mesa=new MesasVotacion();
                // echo 'numero '.$request->mesa;
                $mesa=$mesa->buscar($request->mesa,$punto);

                // $this->sisbenNombre($request,$client);

                if(!empty($this->nombres)){
                    $nombre=explode(' ',$this->nombres['nombre']);
                    $apellido=explode(' ', $this->nombres['apellido']);
                }

                return response()->json(view("auth.admin.creare")->with([
                    "formulario"=>'I',
                    "nit"=>$request->cedula,
                    "departamento"=>$departamento,
                    "ciudad"=>$ciudad,
                    "nombre"=>$request->nombre,
                    "punto"=>$punto,
                    "localizacion"=>$localizacion,
                    "mesa"=>$mesa,
                    "nombre1"=>$nombre[0],
                    "nombre2"=>$nombre[1],
                    "apellido1"=>$apellido[0],
                    "apellido2"=>$apellido[1],
                    "type"=>'E',
                    "urlpunto"=>"listadesplieguepuntofinal",
                    "urlmesa"=>"listadesplieguemesa",
                    "urldesplieguefinal"=>"listadespliegueciudadfinal",
                    'urldesplieguedepartamento'=>'listadesplieguedepartamento',
                    "idnamefinal"=>"id_ciudad",
                    'idname'=>'id_departamento',
                    'idnamepunto'=>'id_punto',
                    'idnamemesa'=>'id_mesa',
                    'idnamereferido'=>'id_referido',
                    'urlreferido'=>'listardiferidos',
                    'oculto'=>0,

                ])->with(UsuarioEController::url())->render());
          }else{
            return response()->json([
                          EvssaConstantes::NOTIFICACION=> EvssaConstantes::DANGER,
                          EvssaConstantes::MSJ=>"Error al consultar la información de la registraduria (Error al pegar los datos)",
                        ],404);
          }
    }

    

    private function registraduriaMesa(Request $request,$client){

        $crawler = $client->request('GET', 'https://wsp.registraduria.gov.co/censo/_censoResultado.php?nCedula='.$request->cedula.'&nCedulaH=&x=91&y=14');
        $configurationRows = $crawler->filter('tr');
        $configurationRows->each(function($configurationRow, $index) {

            $this->lista->addItem($configurationRow->filter('td')->eq(1)->text());
        });


    }
    public function consultarDatos(){
        $INSTANCE_ID = 'YOUR_INSTANCE_ID_HERE';  // TODO: Replace it with your gateway instance ID here
        $CLIENT_ID = "YOUR_CLIENT_ID_HERE";  // TODO: Replace it with your Forever Green client ID here
        $CLIENT_SECRET = "YOUR_CLIENT_SECRET_HERE";   // TODO: Replace it with your Forever Green client secret here
        $postData = array(
          'number' => '573115907753',  // TODO: Specify the recipient's number here. NOT the gateway number
          'message' => 'Howdy! Is this exciting?'
        );
        $headers = array(
          'Content-Type: application/json',
          'X-WM-CLIENT-ID: '.$CLIENT_ID,
          'X-WM-CLIENT-SECRET: '.$CLIENT_SECRET
        );
        $url = 'http://api.whatsmate.net/v3/whatsapp/single/text/message/' . $INSTANCE_ID;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
        $response = curl_exec($ch);
        echo "Response: ".$response;
        curl_close($ch);
       
    }
    
    private function consultarVotacion(Request $request){
        // $vista  =$cliente->request("POST","https://app.infovotantes.co/InfoVotantesWS/InfoServices/Servicios/consultarLugar",array(), array(), array('Content-Type' => 'application/json'), json_encode($params));
        $url ="https://app.infovotantes.co/InfoVotantesWS/InfoServices/Servicios/consultarLugar";

      	$postdata =          array("cedula"=>$request->cedula,"medioconsulta"=>"Web","recaptcha"=>"03ANcjospx5lM7Zr4aQNQGzGttgpS_ToHztqGpiqLKBE864rHxUbd8AP4WL1N2LAOdJLAukxrdWLFvNBYRtG_4OgsadFJ6jOn5wxpDBJl148PM1pcqe7vyjTA0Ne9nW6Z7HDxTzNdAKLKv6tl_-4OWH3WKi4HgKQzaobuYLvPvjIs6DoB5r-JzvgP84T8OuJcV0hu5l4EdY2SuY980z4ZQ3y4zpQiAXikZDuJhOLzfZMePIKUB00uql5tgwvd5vLYzAx97n2D89AsmQ0FRNvV-qIsDHHsTUn8WKVEDuqSj63e0ddKijJ9cTf1Ngr5b1TDEFgxuqM6aQWbDZT-R07Y7fukzPQ-8toHK-Wm1IKFYdyRwdYTZU68vtjfqDvIocUSHJqfZimPiBxFAmLTVZticiMZfDlwtUSItBj8rDWa0E9cfcO6WT_p3bvglvIi5I4bSkipEqZFGXam5WLavD_ge_FSkQHVAsf1xqr1I_uUiQj5Ogg7JvWVjxnVD9EFgZsg7NbQMnEzUY3FcGp11gRZvuZaCd9Sz4iGPvdTR9nPO0Y1pAASluVOlUYy_99tiwhM3ZjHsG4SY9aO8","agente"=>"Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Mobile Safari/537.36","sistemaoperativo"=>"android","navegador"=>"chrome","dispositivo"=>"android","versionso"=>"unknown","versionnavegador"=>"56.0.2924.87");
        $data_string = json_encode($postdata);
      	// Set the POST options
      	$opts = array('http' =>
      		array (
      			'method' => 'POST',
      			'header' => 'Content-type: application/json',
      			'content' => $data_string
      		)
      	);
      	$context  = stream_context_create($opts);
      	$result = file_get_contents($url, false, $context);
        $array = json_decode($result,true);
        if(!boolval($array['exito'])){
          return true;
        }else{
          foreach($array['data']['lugarVotacion'] as $key => $val) {
            $this->lista->addItem($val);
          }
        }
        return false;

    }

    public function fosyga(){
      $cliente = new Client();
      $vista  =$cliente->request("POST","http://ruafsvr2.sispro.gov.co/AfiliacionPersona.aspx");

      $formulario=$vista->selectButton("Consultar")->form();
      //dd($formulario->all());
      $vista=$cliente->submit($formulario, array(
            'ctl00$MainContent$ddlTiposDocumentos'=>'5|CC',
            'ctl00$MainContent$txbNumeroIdentificacion'=>'1052401466',
      ));
      dd($vista);
      // $vista->filter('td')->each(function ($node){
      //       echo $node->text().' fosyga';
      // });

    }

    public function sisbenNombre(Request $request, $cliente){

        $vista  =$cliente->request("POST","https://wssisbenconsulta.sisben.gov.co/DNP_SisbenConsulta/DNP_SISBEN_Consulta.aspx");

        $formulario=$vista->selectButton("Consultar")->form();
        //dd($formulario->all());
        $vista=$cliente->submit($formulario, array(
              'ddlTipoDocumento' => '1',
              'tboxNumeroDocumento'=>$request->cedula,
        ));

        $vista->filter('[id="labelNombres"]')->each(function ($node){
              $this->nombres['nombre']=$node->text();
        });
        $vista->filter('[id="labelApellidos"]')->each(function ($node){
              $this->nombres['apellido']=$node->text();
        });


    }
    public function consultarCoordenadas(){
        $client = new Client();
        $this->googleLocation($client);
    }
    private function googleLocation($cliente){


    }    /**
     * Show the form for creating a nephp artisan ser
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
    public function modalRegistraduria(){
      // echo 'consultar pppppp';
      return view('auth.admin.modalregistraduria');
    }
}
