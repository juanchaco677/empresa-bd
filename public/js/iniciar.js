
//array utilizado para iniciar el despliegu de cajas para la formacion academica en el formulario registrar y editar
formacion=[];
photo = new Array();

function oprimirReporte(formulario,tipo){

  $("#tiporeporte").val(tipo);
  $("#"+formulario).submit();
}


function onCargandoSubmit(){
    $(".cargando").show();
}


function getAjaxReporte(url,opcion,elemento){
    $(".cargando").show();
    var valor=$("#"+elemento).val()==""?".c*":$("#"+elemento).val();
    $.get(opcion==1?url:url+"/"+valor,function(resul){
      console.log("reporte");
      var notificacion = new Notificacion();
      notificacion.crearContenedor();
      notificacion.crearNotificacion("Se descargo correctamente el reporte","INFO");
    }) .done(function( data ) {
      $(".cargando").hide();
    }).fail(function(error) {
      $(".cargando").hide();
      var data = JSON.parse(error.responseText).errors;
      if(data!=undefined){
         for(var key in data) {

                 var notificacion = new Notificacion();
                 notificacion.crearContenedor();
                 notificacion.crearNotificacion(data[key],"DANGER");
         }

       }else{
         data = JSON.parse(error.responseText);
         var notificacion = new Notificacion();
         notificacion.crearContenedor();
         notificacion.crearNotificacion(data.msj,data.notificacion);
       }
    });
}
function leerDatosRegistraduria(){
  var url="https://mejorvargaslleras-4fd2e.firebaseio.com/user.json";
  $.get(url,function(resul){
    // $(".contenedor").html(resul);

    json=JSON.parse(resul);

}) .done(function( data ) {

}).fail(function(error) {
 
});
}

/**
 * metodo que construye los datos de la registraduria para su posterior envio a la base de datos
 * @param {ruta} url 
 */
function transferirDatos(url){

  //  var vector="1022353924;BOGOTA D.C.;BOGOTA. D.C.;COL. GABRIEL BETANCOURT MEJIA;Carrera 87 A No. 6 A - 23;43";
    // consultarCoordenadaContruirDatosRegistraduria(vector.split(";"),url);  
  
  if(window.dato!="" || window.dato!=undefined){
    consultarCoordenadaContruirDatosRegistraduria(window.dato.split(";"),url);      
  }else{
    console.log("no existe la variable dato");
  }
}
/**
 * metodo que consultar coordenadas y construir datos
 */
function consultarCoordenadaContruirDatosRegistraduria(vector,url){
//1022353924;BOGOTA D.C.;BOGOTA. D.C.;COL. GABRIEL BETANCOURT MEJIA;Carrera 87 A No. 6 A - 23;43
 
  departamento=vector[1];
  ciudad=vector[2];
  puesto=vector[3];
  direccion=vector[4];
  mesa=vector[5];
  localidad=vector[3];  
  cedula=vector[0];
  var address=ciudad.replace("D.C.","").replace(".","").trim().toLowerCase()+" "+puesto.toLowerCase()+" "+direccion;

  axios.get('https://maps.googleapis.com/maps/api/geocode/json', {
    params: {
      address: address,
      key: 'AIzaSyDrlw6mkVtgkaYvpEkGQ8LrjwNkpuvkNlw'
    }
  }).then(function (response) {
    direccion=response.data.results[0].formatted_address;
    latitude=response.data.results[0].geometry.location.lat;
    longitude=response.data.results[0].geometry.location.lng;

    if (direccion != "" && latitude != "" && longitude!=""
      && cedula != "" && departamento != "" && ciudad!=""
      && puesto != "" && mesa!=""){
        //construir datos de envion en un json
        var json={
                cedula:cedula,
                departamento:departamento,
                ciudad:ciudad,
                nombre:puesto,
                direccion:direccion,
                mesa:mesa,
                latitud:latitude,
                longitud:longitude
              };
        getAjaxransferirDatos(url,json);  
        window.dato="";
    }
  }).catch(function (error) {
    console.log("error calculando coordenadas json"+error);
  });

  
 

}


function buscarCon(vector,palabra){
  for (var x=0;x<vector.length;x++){
        if(vector[x].indexOf(palabra)>=0){
          return vector[x+1].replace('Departamento','').replace('Municipio','').replace('Código localidad','').replace('Nombre localidad','').replace('Puesto','').replace('Dirección del puesto','').replace('Fecha de ingreso','').replace('Mesa','').replace('Zona','');
        }
  }
  return undefined;
}
function buscarTabla(vector,palabra){
  for (var x=0;x<vector.length;x++){
        if(vector[x].indexOf(palabra)>=0){
          return vector[x+1].replace('Departamento','').replace('Municipio','').replace('Código localidad','').replace('Nombre localidad','').replace('Puesto','').replace('Dirección del puesto','').replace('Fecha de ingreso','').replace('Mesa','').replace('Zona','');
        }
  }
  return undefined;
}
function getAjaxransferirDatos(url,json){
    // $(".contenedor").html();
    $(".cargando").show();
    $.get(url,json,function(resul){

        // $(".contenedor").html(resul);
        $(".cargando").hide();
        $(".contenedor").html();
        $(".contenedor").html(resul);
         $(".modal").modal("hide");
         $("#cedulaconsulta").val("");
         $('#transferir').val("");

    }) .done(function( data ) {
      $(".cargando").hide();
    }).fail(function(error) {
      $(".cargando").hide();
      var data = JSON.parse(error.responseText).errors;
      if(data!=undefined){
         for(var key in data) {

                 var notificacion = new Notificacion();
                 notificacion.crearContenedor();
                 notificacion.crearNotificacion(data[key],"DANGER");
         }

       }else{
         data = JSON.parse(error.responseText);
         var notificacion = new Notificacion();
         notificacion.crearContenedor();
         notificacion.crearNotificacion(data.msj,data.notificacion);
       }
    });
}
function getAjax(url){
    $(".contenedor").html();
    $(".cargando").show();
    $.get(url,function(resul){
        $(".contenedor").html(resul);
    }) .done(function( data ) {
      $(".cargando").hide();
    }).fail(function(error) {
      $(".cargando").hide();
      var data = JSON.parse(error.responseText).errors;
      if(data!=undefined){
         for(var key in data) {

                 var notificacion = new Notificacion();
                 notificacion.crearContenedor();
                 notificacion.crearNotificacion(data[key],"DANGER");
         }

       }else{
         data = JSON.parse(error.responseText);
         var notificacion = new Notificacion();
         notificacion.crearContenedor();
         notificacion.crearNotificacion(data.msj,data.notificacion);
       }
    });
}

function getAjaxUsuarioe(url,data){
  $(".contenedor").html();
  $(".cargando").show();
  $.get(url,data,function(resul){
      $(".contenedor").html(resul);
  }) .done(function( data ) {
    $(".cargando").hide();
  }).fail(function(error) {
    $(".cargando").hide();
    var data = JSON.parse(error.responseText).errors;
    if(data!=undefined){
       for(var key in data) {

               var notificacion = new Notificacion();
               notificacion.crearContenedor();
               notificacion.crearNotificacion(data[key],"DANGER");
       }

     }else{
       data = JSON.parse(error.responseText);
       var notificacion = new Notificacion();
       notificacion.crearContenedor();
       notificacion.crearNotificacion(data.msj,data.notificacion);
     }
  });
}

function getAjaxContenedor(url,elemento,id_referido){
    $("."+elemento).html();
    $(".cargando").show();
    $.get(url,{id_referido:id_referido},function(resul){
        $("."+elemento).html(resul);
    }) .done(function( data ) {
      $(".cargando").hide();
    }).fail(function(error) {
      $(".cargando").hide();
      var data = JSON.parse(error.responseText).errors;
      if(data!=undefined){
         for(var key in data) {

                 var notificacion = new Notificacion();
                 notificacion.crearContenedor();
                 notificacion.crearNotificacion(data[key],"DANGER");
         }

       }else{
         data = JSON.parse(error.responseText);
         var notificacion = new Notificacion();
         notificacion.crearContenedor();
         notificacion.crearNotificacion(data.msj,data.notificacion);
       }
    });
}
function getAjaxModal(url,elemento,dato){
    $("."+elemento).html();
    $(".cargando").show();
    $.get(url,{dato:dato},function(resul){
      $("body").append(resul);
      $('#'+elemento).modal('show');
    }) .done(function( data ) {
      $(".cargando").hide();
    }).fail(function(error) {
      $(".cargando").hide();
      var data = JSON.parse(error.responseText).errors;
      if(data!=undefined){
         for(var key in data) {

                 var notificacion = new Notificacion();
                 notificacion.crearContenedor();
                 notificacion.crearNotificacion(data[key],"DANGER");
         }

       }else{
         data = JSON.parse(error.responseText);
         var notificacion = new Notificacion();
         notificacion.crearContenedor();
         notificacion.crearNotificacion(data.msj,data.notificacion);
       }
    });
}



/**
	 * funcion que envia los archivos al controlador
	 * @param formulario
	 */
	function envioDatos(formulario){

		var dato=addDatos(formulario);
		$.ajax({
			headers: {'X-CSRF-TOKEN': $("#token").val()},
			url: $("."+formulario).attr("action"),
			method: $("."+formulario).attr("method"),
			data: dato,
			contentType: false,
			processData: false,
			dataType: 'json',
			success: function (resul) {
        $(".cargando").hide();
        var notificacion = new Notificacion();
        notificacion.crearContenedor();
        notificacion.crearNotificacion(resul.msj,resul.notificacion);
         $(".contenedor").html(resul.html.original);
         $(".modal").modal("hide");
			},
			error: function (error) {
        $(".cargando").hide();
        var data = JSON.parse(error.responseText).errors;
        if(data!=undefined){
           for(var key in data) {

                   var notificacion = new Notificacion();
                   notificacion.crearContenedor();
                   notificacion.crearNotificacion(data[key],"DANGER");
           }

         }else{
           data = JSON.parse(error.responseText);
           var notificacion = new Notificacion();
           notificacion.crearContenedor();
           notificacion.crearNotificacion(data.msj,data.notificacion);
         }
			}
		});
	}
/**
*adicona los datos de cualquier formulario para su posterior envio
*/

function addDatos(formulario){
		var formData = new FormData();
		$.each($("."+formulario).serializeArray(), function(i, json) {
			formData.append(json.name, json.value);
		});
    formData.append("photo",photo[0]);
		return formData;
	}
function postAjax(url,id){
  $(".contenedor").html();
  $(".cargando").show();
        var  data = {  _method:"delete",_token : $("#token").attr("value")};
         $.post(url+"/"+id, data,function(resul){

             var notificacion = new Notificacion();
             notificacion.crearContenedor();
             notificacion.crearNotificacion(resul.msj,resul.notificacion);
              $(".contenedor").html(resul.html.original);

         }).done(function( data ) {
           $(".cargando").hide();
         }).fail(function(error) {
           $(".cargando").hide();
           var data = JSON.parse(error.responseText).errors;
           if(data!=undefined){
              for(var key in data) {

                      var notificacion = new Notificacion();
                      notificacion.crearContenedor();
                      notificacion.crearNotificacion(data[key],"DANGER");
              }

            }else{
              data = JSON.parse(error.responseText);
              var notificacion = new Notificacion();
              notificacion.crearContenedor();
              notificacion.crearNotificacion(data.msj,data.notificacion);
            }
         });
}


function postAjaxSend(){
  $(".contenedor").html();
  $(".cargando").show();
  var formData = new FormData();
  // formData.append("photo",  $('#imageUpload')[0].files[0]);
  var data=$('.formulario').serializeArray();
    // data.push({ name: "photo", value: formData});
           $.post($('.formulario').attr('action'), data,function(resul){

             var notificacion = new Notificacion();
             notificacion.crearContenedor();
             notificacion.crearNotificacion(resul.msj,resul.notificacion);

              $(".contenedor").html(resul.html.original);

         }).done(function( data ) {
           $(".cargando").hide();
         }).fail(function(error) {

           $(".cargando").hide();
           var data = JSON.parse(error.responseText).errors;
           if(data!=undefined){
              for(var key in data) {

                      var notificacion = new Notificacion();
                      notificacion.crearContenedor();
                      notificacion.crearNotificacion(data[key],"DANGER");
              }

            }else{
              data = JSON.parse(error.responseText);
              var notificacion = new Notificacion();
              notificacion.crearContenedor();
              notificacion.crearNotificacion(data.msj,data.notificacion);
            }

         });
}

function postAjaxObservation(){
  $(".contenedor").html();
  $(".cargando").show();

  var data=$('.formulario-observation').serializeArray();
           $.post($('.formulario-observation').attr('action'), data,function(resul){

             var notificacion = new Notificacion();
             notificacion.crearContenedor();
             notificacion.crearNotificacion(resul.msj,resul.notificacion);
              $(".contenedor").html(resul.html.original);

         }).done(function( data ) {
           $(".cargando").hide();
         }).fail(function(error) {
           $(".cargando").hide();
           var data = JSON.parse(error.responseText).errors;
           if(data!=undefined){
              for(var key in data) {

                      var notificacion = new Notificacion();
                      notificacion.crearContenedor();
                      notificacion.crearNotificacion(data[key],"DANGER");
              }

            }else{
              data = JSON.parse(error.responseText);
              var notificacion = new Notificacion();
              notificacion.crearContenedor();
              notificacion.crearNotificacion(data.msj,data.notificacion);
            }

         });
}

$(document).on('submit','.formulario-persona',function(e){
    e.preventDefault();
    envioDatos("formulario-persona");
});

$(document).on('submit','.formulario-general',function(e){
    e.preventDefault();
    envioDatos("formulario-general");
});
$(document).on('submit','.formulario',function(e){
    e.preventDefault();
    postAjaxSend();
});
$(document).on('submit', '#transferirdatos', function (e) {
  e.preventDefault();  
  transferirDatos('datosregistraduria');
});

$(document).on('submit', '#formulariomensajes', function (e) {
  e.preventDefault();

});

$(document).on('submit','.formulario-observation',function(e){
    e.preventDefault();
    postAjaxObservation();
});

function oprimirHref(url,elemento){
  // onCargandoSubmit();
  var valor=$("#"+elemento).val()==""?".c*":$("#"+elemento).val();
  window.location = url+"/"+valor;
}

function tipoCampo(elemento,tipo,decimales,caracteres,digitos){
    var campo=$(elemento);

    var dato=null;
    switch (tipo) {
    case "double":

      break;
    case "entero":
          dato=campo.val();
            console.log(dato);
          if(campo.val().length>=digitos){
            campo.val(dato.slice(0,digitos));
          }
      break;
    case "porcentaje":

      break;
    case "double":

      break;


      default:

    }
}
