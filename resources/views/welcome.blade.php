<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Sotfware Electoral Valerian</title>
        <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <!-- Styles -->
        <style>
            body{
                background-image: url("{{ asset('archivos/fondowelcome.png') }}");
                background-color: transparent;
                background-repeat: no-repeat;
                background-position: center top;
                background-attachment: fixed;
                background-size:cover;               
              
            }
            html, body {
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100%;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>

        <link href="{{ asset('css/electoral.css') }}" rel="stylesheet">
        <script type="text/javascript" src="{{ asset('js/jquery-3.2.1.min.js')}}"></script>
        <script type="text/javascript" src="{{ asset('js/notificacion.js')}}"></script>
		<script src="{{ asset('js/flip/compiled/flipclock.js')}}"></script>
    <link rel="stylesheet" href="{{ asset('js/flip/compiled/flipclock.css')}}">

    </head>
    <body>

    @include('alert.notificacion')

        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Casa</a>
                    @else
                        <a href="{{ route('login') }}">Iniciar Sesión</a>
                    @endauth
                </div>
            @endif

       <div class="container hero">
    <div class="row">
        <div class="col-md-4">
            <h1>Software Electoral Valerian.</h1>
            <p>{{empty($general->eslogan)?'Es una herramienta informática.':$general->eslogan}}</p>
            @auth
            <div class="title m-b-md" style="position:relative;height:200px; width:200px; border-radius: 200px 200px 200px 200px;
-moz-border-radius: 200px 200px 200px 200px;
-webkit-border-radius: 200px 200px 200px 200px;
border: 0px solid #000000;background:#f79625;color:#fff;font-weight:bold; font-size:20px;">
                  <div class="col-md-8" style="position:abosolute !important;left:35px;top:23px;">
                  <h6 >Potencial electoral:</h6>
                </div>
                <div class="col-md-6" style="position:abosolute !important;left:105px;top:-14px;">
                    {{$usuario->potencialelectoral}}
                </div>
                <div class="col-md-6" style="position:abosolute !important;left:33px;top:-10px;">
                  <h6 >Potencial real:</h6>
                </div>
                <div class="col-md-12" style="position:abosolute !important;left:75px;top:-47px;">
                   {{$usuario->cantidadreal}}
                </div>
                <div class="col-md-6" style="position:abosolute !important;left:33px;top:-41px;">
                  <h6 >Porcentaje cumplimiento de la meta:</h6>
                </div>
                <div class="col-md-12" style="position:abosolute !important;left:80px;top:-74px;">
                   {{$porcentaje}}%
                </div>
            </div>
        @endauth
        </div>
        <div class="col-md-8">

            <div class="content">
               
                <div class="title m-b-md">
                  <div class="clock" style="margin:2em;"></div>
                	<div class="message"></div>

                	<script type="text/javascript">



                    $(document).ready(function() {
		                    var clock;
                        var dia={{$general->dia}}
                        var ano={{$ano->numero}}
                        var mes="{{$mes->nombre}}"

                        var month = new Array();
                            month[0] = "Enero";
                            month[1] = "Febrero";
                            month[2] = "Marzo";
                            month[3] = "Abril";
                            month[4] = "Mayo";
                            month[5] = "Junio";
                            month[6] = "Julio";
                            month[7] = "Agosto";
                            month[8] = "Septiembre";
                            month[9] = "Octubre";
                            month[10] = "Noviembre";
                            month[11] = "Diciembre";
                        var numeroMes=0;
                          for (var i in month) {
                              var estado=month[i].toUpperCase()===mes.toUpperCase();

                              if(estado){
                                numeroMes=i;
                                break;
                              }
                          }
                      //

        var time =null;
				// Grab the current date
				var currentDate = new Date("December "+dia+", "+ano+" 23:59:00");
         currentDate.setMonth(numeroMes);
				// Set some date in the past. In this case, it's always been since Jan 1
				var pastDate  = new Date();

				// Calculate the difference in seconds between the future and current date
				var diff = currentDate.getTime() / 1000 - pastDate.getTime() / 1000;

				// Instantiate a coutdown FlipClock
      				clock = $('.clock').FlipClock(diff, {
                clockFace: 'DailyCounter',
                        language:'es-es',
                        countdown: true,
                        callbacks: {
                          stop: function() {

                          }
                        }
      				});

			});
                	</script>

                </div>



            </div>

                </div>
            </div>
        </div>
    </div>
</div>
        </div>
    </body>
</html>
