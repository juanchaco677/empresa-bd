<!DOCTYPE html>
<html>
  <head>
    <title>Geolocalización</title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      #floating-panel {
        position: absolute;
        top: 10px;
        left: 25%;
        z-index: 5;
        background-color: #fff;
        padding: 5px;
        border: 1px solid #999;
        text-align: center;
        font-family: 'Roboto','sans-serif';
        line-height: 30px;
        padding-left: 10px;
      }
    </style>
      <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  </head>
  <body>
    @include ('footer')
    <div id="map"></div>
    <script>
    function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 12,
          center: {lat: 4.570868, lng: -74.297333},
          styles:[{"featureType":"water","stylers":[{"color":"#19a0d8"}]},{"featureType":"administrative","elementType":"labels.text.stroke","stylers":[{"color":"#ffffff"},{"weight":6}]},{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"#e85113"}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#efe9e4"},{"lightness":-40}]},{"featureType":"road.arterial","elementType":"geometry.stroke","stylers":[{"color":"#efe9e4"},{"lightness":-20}]},{"featureType":"road","elementType":"labels.text.stroke","stylers":[{"lightness":100}]},{"featureType":"road","elementType":"labels.text.fill","stylers":[{"lightness":-100}]},{"featureType":"road.highway","elementType":"labels.icon"},{"featureType":"landscape","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"landscape","stylers":[{"lightness":20},{"color":"#efe9e4"}]},{"featureType":"landscape.man_made","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"labels.text.stroke","stylers":[{"lightness":100}]},{"featureType":"water","elementType":"labels.text.fill","stylers":[{"lightness":-100}]},{"featureType":"poi","elementType":"labels.text.fill","stylers":[{"hue":"#11ff00"}]},{"featureType":"poi","elementType":"labels.text.stroke","stylers":[{"lightness":100}]},{"featureType":"poi","elementType":"labels.icon","stylers":[{"hue":"#4cff00"},{"saturation":58}]},{"featureType":"poi","elementType":"geometry","stylers":[{"visibility":"on"},{"color":"#f0e4d3"}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#efe9e4"},{"lightness":-25}]},{"featureType":"road.arterial","elementType":"geometry.fill","stylers":[{"color":"#efe9e4"},{"lightness":-10}]},{"featureType":"poi","elementType":"labels","stylers":[{"visibility":"simplified"}]}
        ]
        });


           var listausuarios="";
            for(var i=0;i<puntos.length;i++) {
                 listausuarios+="<li class='list-group-item'>Nombre:"+puntos[i].nombres+"&nbsp"+"Cedula:"+puntos[i].nit+"</li>";
               try {
                   if(puntos[i].punto_id != puntos[i+1].punto_id){

                     geocodeAddress( map,puntos,i,listausuarios);
                     listausuarios="";


                   }

                }catch(err) {

                   geocodeAddress( map,puntos,i,listausuarios);
                   listausuarios="";

                }
              }
         }

         function geocodeAddress( resultsMap,puntos,key,listausuarios) {

            var contentString =  "<div class='modal-dialog' role='document'>"+
                "<div class='modal-content' style='border-radius: 10px 10px 10px 10px;-moz-border-radius: 10px 10px 10px 10px;-webkit-border-radius: 10px 10px 10px 10px;'>"+
                    "<div class='col-md-12'>"+
                      "<h5>Dirección: "+puntos[key].direccion+"</h5>  "+
                    "</div>"+
                    "<div class='col-md-12'>"+
                      "<h6>Cantidad de votantes:"+puntos[key].cantidad+"</h6>"+
                    "</div>"+

                  "<div class='modal-body' style='height:300px !important;overflow-y:scroll !important;'>"+
                  "<ul class='list-group'>"+listausuarios

                  "</ul>"+
                  "</div>"+
                "</div>"+
              "</div>";

            var myLatLng = {lat: puntos[key].latitud, lng:puntos[key].longitud};

            var infowindow = new google.maps.InfoWindow({
              content: contentString
            });

            var marker = new google.maps.Marker({
              position: myLatLng,
              map: resultsMap,
            });
            marker.addListener('click', function() {
            infowindow.open(map, marker);
              });
          }


    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCV4ya46Yoag-iGeJb5SUwZ2q1Irx0UjnU&callback=initMap">
    </script>
  </body>
</html>
