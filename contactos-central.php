<?php
function modelo($modelo){
  require_once 'app/modelos/'.$modelo.'.php';
  return new $modelo();
}
$datos = array();
$modelo = modelo('Categoria');
$listaCategoria = $modelo->listaCategorias($datos);
?>
<!DOCTYPE html>
<!--[if IE 7]><html class="ie ie7"><![endif]-->
<!--[if IE 8]><html class="ie ie8"><![endif]-->
<!--[if IE 9]><html class="ie ie9"><![endif]-->
<html lang="en">
  
<head>
<?php require("public-head.php");?>
<meta name="keywords" content="eglooroluz.com, eglooroluz, oro luz, importadora oro luz, importadora lamparas, importadora, La Paz Bolivia, Lamparas La Paz, Lamparas Bolivia, Lamparas La Paz Bolivia, Focos La Paz, Focos Bolivia, Focos La Paz Bolivia, iluminacion La Paz, iluminacion Bolivia, Iluminacion La Paz Bolivia, Iluminacion, Focos, Lamparas, Eglo La Paz, Eglo Bolivia, Eglo La Paz Bolivia, Eglo Oro Luz, Importadora Oro Luz, Eglo, ciudad La paz, venta lamparas, venta focos, venta iluminacion, eglo iluminacion, productos eglo la paz bolivia, productos iluminacion, eglo ciudad la paz, lamparas ciudad la paz">
      <meta name="description" content="eglooroluz.com, eglooroluz, oro luz, importadora oro luz, importadora lamparas, importadora, La Paz Bolivia, Lamparas La Paz, Lamparas Bolivia, Lamparas La Paz Bolivia, Focos La Paz, Focos Bolivia, Focos La Paz Bolivia, iluminacion La Paz, iluminacion Bolivia, Iluminacion La Paz Bolivia, Iluminacion, Focos, Lamparas, Eglo La Paz, Eglo Bolivia, Eglo La Paz Bolivia, Eglo Oro Luz, Importadora Oro Luz, Eglo, ciudad La paz, venta lamparas, venta focos, venta iluminacion, eglo iluminacion, productos eglo la paz bolivia, productos iluminacion, eglo ciudad la paz, lamparas ciudad la paz">
      <title>Importadora ORO LUZ</title><link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700%7CLibre+Baskerville:400,700" rel="stylesheet">
      <style>
    #map {
    padding-top: 100px;
    margin-top: 100px;
    widh: 50px;
    height: 600px; }
</style>
  </head>
  <!--[if IE 7]><body class="ie7 lt-ie8 lt-ie9 lt-ie10"><![endif]-->
  <!--[if IE 8]><body class="ie8 lt-ie9 lt-ie10"><![endif]-->
  <!--[if IE 9]><body class="ie9 lt-ie10"><![endif]-->
  <body>
    <div class="header--sidebar"></div>
    <!--  Header-->
    <?php require("public-header.php");?>
    <div class="ps-hero bg--cover" data-background="public/imagenes/paginaweb/subscribirse.png">
      <div class="ps-container">
        <h3>Zona Central</h3>
        <div class="ps-breadcrumb">
          <ol class="breadcrumb">
            <li><a href="index-2.html">Inicio</a></li>
            <li class="active">Nuestra Ubicacion</li>
          </ol>
        </div>
      </div>
    </div>
    <!-- google-map -->
    <div id="map"></div>
    <!-- google-map end -->

    
    <div class="ps-partners">
      <div class="ps-container">
        <div class="ps-slider--partners owl-slider" data-owl-auto="true" data-owl-loop="true" data-owl-speed="1000" data-owl-gap="50" data-owl-nav="false" data-owl-dots="false" data-owl-item="5" data-owl-item-xs="2" data-owl-item-sm="3" data-owl-item-md="4" data-owl-item-lg="5" data-owl-duration="1000" data-owl-mousedrag="on">
          <?php for($i = 0; $i < sizeof($listaCategoria) ; $i++){?>
            <a href=<?php echo "mis-productos.php?c=".$listaCategoria[$i]['cod_categoria'];?>><img src=<?php echo "public/imagenes/categorias/".$listaCategoria[$i]['imagen_categoria'];?> alt=''></a>
          <?php }?>
          </div>
      </div>
    </div>
    <?php require("public-footer.php");?>
    <div class="ps-loading"><div class="loader ">
<div class="loader__item"></div>
<div class="loader__item"></div>
<div class="loader__item"></div>
<div class="loader__item"></div>
<div class="loader__item"></div>
</div>
    </div>
    <?php require("public-foot.php");?>

    <script>
      var map = L.map('map').
    setView([-16.49726, -68.140643], 
    14);
     
    L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="http://cloudmade.com">CloudMade</a>',
        maxZoom: 18
    }).addTo(map);
    
    L.control.scale().addTo(map);
    var marker = L.marker([-16.49726, -68.140643], {draggable: true}).addTo(map);
    marker.bindPopup("<b>ZONA CENTRAL - LA PAZ</b>").openPopup();

        $(document).ready(function() {
            var parametros = {
                "action" : "listaCategorias",
            };
            $.ajax({
              type:'POST',
              data: parametros,
              url:'app/controladores/Categorias.php',
              success:function(data){
                datos = JSON.parse(data);
                datos = datos.data;
                let contenido = ""
                for(i = 0 ; i < datos.length ; i++){
                    contenido = contenido + "<li><a onclick='prueba("+datos[i].cod_categoria+")'>" + datos[i].nombre_categoria + "</a></li>";
                }
                document.getElementById("idListaCategoria").innerHTML = contenido;
              }
            })

            parametros = {
                "action" : "listaCategoriasDescuentos",
            };
            $.ajax({
              type:'POST',
              data: parametros,
              url:'app/controladores/Descuentos.php',
              success:function(data){
                datos = JSON.parse(data);
                datos = datos.data;
                let contenido = ""
                for(i = 0 ; i < datos.length ; i++){
                    var res = datos[i].observacion_descuento_producto.replace(" ", "_");
                    contenido = contenido + "<li><a href='mis-productos-descuentos.php?c="+res+"'>" + datos[i].observacion_descuento_producto + "</a></li>";
                }
                document.getElementById("idListaOferta").innerHTML = contenido;
              }
            })
        });

    </script>
  </body>

</html>