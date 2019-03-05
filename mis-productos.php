<?php
function modelo($modelo){
  require_once 'app/modelos/'.$modelo.'.php';
  return new $modelo();
}

$codigo = $_GET['c'];

$datos = array($codigo);
$modelo = modelo('Categoria');
$categoria = $modelo->categoriaEspecifico($datos);

$datos = array($codigo);
$listaProducto = $modelo->listaCategoriaProductosPagina($datos);
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
        <h3><?php echo $categoria[0]['nombre_categoria'];?></h3>
        <div class="ps-breadcrumb">
          <ol class="breadcrumb">
            <li><a href="index.php">Inicio</a></li>
            <li class="active"><?php echo $categoria[0]['nombre_categoria'];?></li>
          </ol>
        </div>
      </div>
    </div>
    <main class="ps-main">
      <div class="ps-container">

        <div class="row" id="listaProductosCategoria">

        <?php 
        for($i = 0; $i < sizeof($listaProducto) ; $i++){?>
        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 ">
                <div class="ps-product">
                  <div class="ps-product__thumbnail"><a class="ps-product__favorite" href="#"><i class="furniture-heart"></i></a><img src=<?php echo "public/imagenes/productos/".$listaProducto[$i]['imagen_producto'];?> alt=""><a class="ps-product__overlay" href="product-detail.html"></a>
                    <div class="ps-product__content full">

                          <select class="ps-rating">
                            <option value="1">1</option>
                            <option value="1">2</option>
                            <option value="1">3</option>
                            <option value="1">4</option>
                            <option value="1">5</option>
                          </select><a class="ps-product__title" href="product-detail-2.html"><?php echo $listaProducto[$i]['nombre_producto'];?></a>
                      <div class="ps-product__categories"><a href="product-listing.html"><?php echo $listaProducto[$i]['descripcion_producto'];?></a></div>
                      <p class="ps-product__price">
                        <del>£220</del>£120
                      </p><a class="ps-btn ps-btn--sm" href="product-detail-2.html">STOCK DISPONIBLE</a>
                      <p class="ps-product__feature"><i class="furniture-delivery-truck-2"></i>Comuniquese con nosotros</p>
                    </div>
                  </div>
                  <div class="ps-product__content">
                        <select class="ps-rating">
                          <option value="1">1</option>
                          <option value="1">2</option>
                          <option value="1">3</option>
                          <option value="1">4</option>
                          <option value="1">5</option>
                        </select><a class="ps-product__title" href="product-detail-2.html"><?php echo $listaProducto[$i]['nombre_producto'];?></a>
                    <div class="ps-product__categories"><a href="product-listing.html"><?php echo $listaProducto[$i]['descripcion_producto'];?></a></div>
                  </div>
                </div>
              </div>
            <?php }?>
        </div>
      </div>

    </main>
    
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
        });

        function prueba(codigo){
          localStorage.setItem("cat", codigo);
          location.href = "mis-productos.php?c="+codigo;
        }
    </script>
  </body>


</html>