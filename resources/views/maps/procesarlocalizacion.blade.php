    @include ('footer')
  <script type="text/javascript" src="{{ asset('js/jquery-3.2.1.min.js')}}"></script>
      <!-- <script type="text/javascript" src="{{ asset('js/notificacion.js')}}"></script> -->
    <script>
    var data = new Array();
    var latitude=null;
    var longitude=null;
        function initMap(){
          var geocoder = new google.maps.Geocoder();

          for(var i=0;i<localizacion.length;i++) {

            geocodeAddress(geocoder,localizacion,i);
          }
        }

        function geocodeAddress(geocoder,puntos,i) {
          var address = puntos[i].direccion+" "+puntos[i].ciudades+" "+puntos[i].departamentos+" COLOMBIA";

          geocoder.geocode( { 'address': address}, function(results, status) {
            console.log(status+" "+i);
                console.log(puntos[i]);
            if (status == "OK") {

              latitude= results[0].geometry.location.lat();
               longitude = results[0].geometry.location.lng();

                data.push ( {"id":puntos[i].id,"latitud":latitude,"longitud":longitude,"direccion":puntos[i].direccion,"estado":1} );

                  console.log(localizacion[i]);

            }else{
              data.push ( {"id":puntos[i].id,"latitud":latitude,"longitud":longitude,"direccion":puntos[i].direccion,"estado":0} );

            }
          });


        }
        function postAjaxLocalizacion(){
            console.log(JSON.stringify(data));
            // $(".contenedor").html();
            $(".cargando").show();
                  var  datos = { _token : $("#tokenlocalizacion").attr("value"),data:JSON.stringify(data)};
                   $.post('actualizarlocalizacion', datos,function(resul){
                       // var notificacion = new Notificacion();
                       // notificacion.crearContenedor();
                       // notificacion.crearNotificacion(resul.msj,resul.notificacion);
                      $(".contenedor").html(resul);
                      $(".cargando").hide();
                   }).done(function( data ) {
                     $(".cargando").hide();
                   }).fail(function(error) {
                     $(".cargando").hide();
                     // var data = JSON.parse(error.responseText).errors;
                     // if(data!=undefined){
                     //    for(var key in data) {
                     //
                     //            var notificacion = new Notificacion();
                     //            notificacion.crearContenedor();
                     //            notificacion.crearNotificacion(data[key],"DANGER");
                     //    }
                     //
                     //  }else{
                     //    data = JSON.parse(error.responseText);
                     //    var notificacion = new Notificacion();
                     //    notificacion.crearContenedor();
                     //    notificacion.crearNotificacion(data.msj,data.notificacion);
                     //  }
                   });

        }
    </script>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Reprocesar geolocalización</div>

                <div class="panel-body">

                    <input type="hidden" name="_token" id="tokenlocalizacion" value="{{ csrf_token() }}">
                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="button" class="btn btn-primary" onclick="postAjaxLocalizacion()">
                                    Adicionar coordenadas
                                </button>

                            </div>
                        </div>

                </div>
            </div>
        </div>
    </div>
</div>
<script async defer
src="https://maps.googleapis.com/maps/api/js?key=AIzaSyATU83_eaKLaqf59h2FJ7NMRHGo60vR00k&callback=initMap">
</script>
