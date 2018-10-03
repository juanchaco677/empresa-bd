<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Sotfware Electoral Valerian</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>SB Admin - Start Bootstrap Template</title>
    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/electoral.css') }}" rel="stylesheet">
    <link href="{{ asset('css/cargando.css') }}" rel="stylesheet">

    <script type="text/javascript" src="{{ asset('js/jquery-3.2.1.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('js/iniciar.js')}}"></script>
    <script type="text/javascript" src="{{ asset('js/enviar.js')}}"></script>
    <script type="text/javascript" src="{{ asset('js/notificacion.js')}}"></script>
    <script type="text/javascript" src="{{ asset('js/paginacion.js')}}"></script>
    <script type="text/javascript" src="{{ asset('js/select.js')}}"></script>
    <script type="text/javascript" src="{{ asset('js/menuizquierda.js')}}"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>

window.dato="";
</script>
</head>

<body class="fixed-nav sticky-footer bg-dark" id="page-top">
@include('layouts.cargando')
@include('alert.notificacion')

<!-- Navigation-->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" style="background-color:#2b5797!important"  id="mainNav">

   <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a class="nav-link" href="{{url('/')}}">
                <img id="imagePreview-header" style="float:left" width="40" height="25" src="{{'archivos/\\logo.png'}}" class="img-fluid img-fluid img-thumbnail" />
                <h4>ELECCIONES {{strtoupper($campana->elecciones)}} {{$ano->numero}}</h4>
            </a>
        </li>
    </ul>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Inicio">
                <a class="nav-link" href="{{url('/')}}">
                    <i class="fa fa-clock-o"></i>
                    <span class="nav-link-text">Inicio</span>
                </a>
            </li>
            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Mensajes">
                <a class="nav-link" onclick="mostrarSeccionMenu('L','rutamensaje','')">
                    <i class="fa fa-wechat"></i>
                    <span class="nav-link-text">Mensajes</span>
                </a>
            </li>
            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="General">
                <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#general" data-parent="#exampleAccordion">
                    <i class="fa fa-table"></i>
                    <span class="nav-link-text">Configuración</span>
                </a>
                <ul class="sidenav-second-level collapse" id="general">
                    <li>
                        <a onclick="mostrarSeccionMenu('A','campana','{{$campana->id}}')">General</a>
                    </li>
                    <li>
                        <a onclick="mostrarSeccionMenu('I','ano','')">Ano</a>
                    </li>
                    <li>
                        <a onclick="mostrarSeccionMenu('I','mes','')">Mes</a>
                    </li>
                    <li>
                        <a onclick="mostrarSeccionMenu('I','reprocesar','')">Reprocesar</a>
                    </li>
                </ul>
            </li>


            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Persona">
                <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseComponents" data-parent="#exampleAccordion">
                    <i class="fa fa-fw fa-user"></i>
                    <span class="nav-link-text">Persona</span>
                </a>
                <ul class="sidenav-second-level collapse" id="collapseComponents">
                    @if (Auth::user()->type =='S')
                    <li>
                        <a onclick="mostrarSeccionMenu('L','usuario','')">Registrar Aministrador</a>
                    </li>
                    @endif
                    <li>
                        <a onclick="mostrarSeccionMenu('L','usuarioe','')">Registrar Votante</a>
                    </li>

                </ul>
            </li>

            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Lugar">
                <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseMulti" data-parent="#exampleAccordion">
                    <i class="fa fa-globe"></i>
                    <span class="nav-link-text">Lugar</span>
                </a>
                <ul class="sidenav-second-level collapse" id="collapseMulti">
                    <li>
                        <a onclick="mostrarSeccionMenu('I','departamento','')">Departamento</a>
                    </li>
                    <li>
                        <a onclick="mostrarSeccionMenu('I','ciudad','')">Ciudad</a>
                    </li>


                </ul>
            </li>
            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Puntos votación">
                <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseExamplePages" data-parent="#exampleAccordion">
                    <i class="fa fa-map-marker"></i>
                    <span class="nav-link-text">Puntos votación</span>
                </a>
                <ul class="sidenav-second-level collapse" id="collapseExamplePages">
                    <li>
                        <a onclick="mostrarSeccionMenu('I','punto','')">Rergistrar</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Mesa">
                <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#mesavotacion" data-parent="#exampleAccordion">
                    <i class="fa fa-table"></i>
                    <span class="nav-link-text">Mesa de Votación</span>
                </a>
                <ul class="sidenav-second-level collapse" id="mesavotacion">
                    <li>
                        <a onclick="mostrarSeccionMenu('I','mesa','')">Mesa</a>
                    </li>
                    <li>
                        <a onclick="mostrarSeccionMenu('I','mesaforminforme','')">Informe (puntos de votación)</a>
                    </li>
                    <li>
                        <a onclick="mostrarSeccionMenu('I','mesaforminformegeneral','')">Informe General</a>
                    </li>

                </ul>
            </li>




        </ul>
        <ul class="navbar-nav sidenav-toggler">
            <li class="nav-item">
                <a class="nav-link text-center" id="sidenavToggler">
                    <i class="fa fa-fw fa-angle-left"></i>
                </a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
                <img id="imagePreview-header-logo-campana" width="{{$campana->ancho}}" height="$campana->alto" src="{{$campana->imagen=='default.png'?'archivos/\\default.png':'archivos/S/'.$campana->imagen}}" class="img-thumbnail" />
          </li>
          <li class="nav-item">
              <a class="nav-link" data-toggle="modal" onclick="mostrarSeccionMenu('A','compania','001');getAjaxModal('usuario/'+{{Auth::user()->id}}+'/edit','modal-edicion',null)" data-target="#modal-edicion">
                <img  width="25" height="25" src="{{Auth::user()->photo=='default.png'?'archivos/\\default.png':'archivos/'.Auth::user()->type.'/'.Auth::user()->id.'/'.Auth::user()->photo}}" class="img-circle" />
                {{Auth::user()->name.' '.Auth::user()->name2.' '.Auth::user()->lastname  }}</a>
          </li>


            <li class="nav-item">
                <a class="nav-link" data-toggle="modal" data-target="#exampleModal">
                    <i class="fa fa-fw fa-sign-out"></i>Cerrar Sesión</a>
            </li>
        </ul>
    </div>
</nav>
<div class="content-wrapper">
    <div class="porro"></div>
    <div class="container-fluid contenedor" style="margin-top:20px;">
        <!-- incluye todo -->
        @include('campana.crear')
    </div>
    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
    <footer class="sticky-footer">
        <div class="container">
            <div class="text-center">
                <small>Version 1.0</small>
            </div>
        </div>
    </footer>
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fa fa-angle-up"></i>
    </a>
    <!-- Logout Modal-->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">¿Listo para salir?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Esta seguro de cerrar la sesión actual, oprima salir</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                    <a class="btn btn-primary"  href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">Salir</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </div>
            </div>
        </div>
    </div>



    <link href="{{ asset('css/sb-admin.css') }}" rel="stylesheet">
    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Core plugin JavaScript-->
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <!-- Page level plugin JavaScript-->
    <script src="{{ asset('vendor/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.js') }}"></script>
    <!-- Custom scripts for all pages-->
    <script src="{{asset('js/sb-admin.min.js') }}"></script>
    <!-- Custom scripts for this page-->
    <script src="{{asset('js/sb-admin-datatables.min.js') }}"></script>
    <script src="{{asset('js/sb-admin-charts.min.js') }}"></script>

</div>

<!-- para que funcione las fechas -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>

</html>
