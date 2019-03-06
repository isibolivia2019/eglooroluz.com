<?php
function modelo($modelo){
  require_once 'app/modelos/'.$modelo.'.php';
  return new $modelo();
}

$datos = array();
$modelo = modelo('Producto');
$lista = $modelo->listaProductos($datos);
$datos = array();
$modelo = modelo('Categoria');
$listaCategoria = $modelo->listaCategorias($datos);
$datos = array();
$modelo = modelo('DescuentoProducto');
$listaDescuento = $modelo->listaDescuentoProducto($datos);
?>
<!DOCTYPE html>
  <html lang="es">
    <head>
      <?php require("public-head.php");?>
      <meta name="keywords" content="eglooroluz.com, eglooroluz, oro luz, importadora oro luz, importadora lamparas, importadora, La Paz Bolivia, Lamparas La Paz, Lamparas Bolivia, Lamparas La Paz Bolivia, Focos La Paz, Focos Bolivia, Focos La Paz Bolivia, iluminacion La Paz, iluminacion Bolivia, Iluminacion La Paz Bolivia, Iluminacion, Focos, Lamparas, Eglo La Paz, Eglo Bolivia, Eglo La Paz Bolivia, Eglo Oro Luz, Importadora Oro Luz, Eglo, ciudad La paz, venta lamparas, venta focos, venta iluminacion, eglo iluminacion, productos eglo la paz bolivia, productos iluminacion, eglo ciudad la paz, lamparas ciudad la paz">
      <meta name="description" content="eglooroluz.com, eglooroluz, oro luz, importadora oro luz, importadora lamparas, importadora, La Paz Bolivia, Lamparas La Paz, Lamparas Bolivia, Lamparas La Paz Bolivia, Focos La Paz, Focos Bolivia, Focos La Paz Bolivia, iluminacion La Paz, iluminacion Bolivia, Iluminacion La Paz Bolivia, Iluminacion, Focos, Lamparas, Eglo La Paz, Eglo Bolivia, Eglo La Paz Bolivia, Eglo Oro Luz, Importadora Oro Luz, Eglo, ciudad La paz, venta lamparas, venta focos, venta iluminacion, eglo iluminacion, productos eglo la paz bolivia, productos iluminacion, eglo ciudad la paz, lamparas ciudad la paz">
      <title>Importadora ORO LUZ</title><link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700%7CLibre+Baskerville:400,700" rel="stylesheet">
    </head>
    
    <body>
      <div class="header--sidebar"></div>
      <?php require("public-header.php");?>
      <div class='ps-slider--banner owl-slider' data-owl-auto='true' data-owl-loop='true' data-owl-speed='2000' data-owl-gap='0' data-owl-nav='false' data-owl-dots='true' data-owl-item='1' data-owl-item-xs='1' data-owl-item-sm='1' data-owl-item-md='1' data-owl-item-lg='1' data-owl-duration='1000' data-owl-mousedrag='on'>
        <?php $i = 0; while($i < 10){
          $num = rand(0, (sizeof($lista)-1));
          if($lista[$num]['imagen_producto'] != "sin_imagen_producto.jpg"){?>
        <div class='ps-product--banner'>
          <div class='ps-product__thumbnail'>
            <a href=''><img src=<?php echo 'public/imagenes/productos/'.$lista[$num]['imagen_producto'];?> alt=''></a>
          </div>
          <div class='ps-product__content'>
            <h3><?php echo strtoupper ($lista[$num]['nombre_producto']);?></h3>
            <h4><?php echo "#".$lista[$num]['cod_item_producto'];?></h4>
            <select class='ps-rating'>
              <option value='1'>1</option>
              <option value='1'>2</option>
              <option value='1'>3</option>
              <option value='1'>4</option>
              <option value='1'>5</option>
            </select>
            <p>Con nuestra amplia variedad de Lámparas Colgantes de EGLO, podrás decorar los distintos espacios en el hogar, ideal para Living, Comedor, Dormitorio, Sala de Estar, Cocinas entre otros. Descubre los exclusivos diseños colgantes con iluminación LED que sólo IMPORTADORA ORO LUZ puede ofrecer.</p>
            <h4>STOCK Disponible</h4>
            <div class='ps-product__actions'><a class='ps-btn' href='cart.html'>MAS INFORMACION</a></div>
          </div>
        </div>
        <?php $i=$i+1;}}?>
      </div>

    <?php /*<div class="ps-home-features-2">
      <div class="container">
        <div class="row">
              <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 ">
                <div class="ps-block--icon"><i class="furniture-delivery-truck-1"></i>
                  <h4>Free Shipping <span> ON ORDER OVER $199</span></h4>
                  <p>Want to track a package? Find tracking information and order details from Your Orders.</p>
                </div>
              </div>
              <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 ">
                <div class="ps-block--icon"><i class="furniture-sofa"></i>
                  <h4>Everything Home <span> CHOOSE YOUR ITEM</span></h4>
                  <p>Shop zillions of finds, with new arrivals added daily.</p>
                </div>
              </div>
              <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 ">
                <div class="ps-block--icon"><i class="furniture-credit-card-1"></i>
                  <h4>Secure Payment <span> INFORMATION SECURITY</span></h4>
                  <p>Use the Shop Card for exclusive savings and financing options.</p>
                </div>
              </div>
              <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 ">
                <div class="ps-block--icon"><i class="furniture-hours"></i>
                  <h4>Support 24/7 <span> ALWAYS LISTEN</span></h4>
                  <p>We offer a 24/7 customer hotline so you’re never alone if you have a question.</p>
                </div>
              </div>
        </div>
      </div>
    </div>*/?>
    <div class="ps-section ps-home-promotions">
      <div class="ps-container">
        <div class="ps-section__header text-center">
          <p>elija sus productos de</p>
          <h3 class="ps-section__title">Nuestras Promociones</h3><span class="ps-section__line"></span>
        </div>
        <div class="ps-section__content masonry-root">
          <div class="masonry-wrapper" data-col-lg="4" data-col-md="3" data-col-sm="2" data-col-xs="1" data-gap="30" data-radio="100%">
            <div class="ps-masonry filter">
              <div class="grid-sizer"></div>
              <?php $i = 0; while($i < 4){
                $num = rand(0, (sizeof($listaDescuento)-1));?>
              <div class="grid-item">
                <div class="grid-item__content-wrapper">
                      <div class="ps-product">
                        <div class="ps-product__thumbnail">
                          <div class="ps-badge"><span><?php echo strtoupper ($listaDescuento[$num]['observacion_descuento_producto']);?></span></div>
                          <div class="ps-badge ps-badge--sale"><span><?php echo strtoupper ("-".$listaDescuento[$num]['porcenta_descuento_producto']." %");?></span></div>
                          <a class="ps-product__favorite" href="#"><i class="furniture-heart"></i></a><img src=<?php echo 'public/imagenes/productos/'.$listaDescuento[$num]['imagen_producto'];?> alt=""><a class="ps-product__overlay" href="product-detail.html"></a>
                          <div class="ps-product__content full">
                              <a class="ps-product__title" href="product-detail-2.html"><?php echo strtoupper ($listaDescuento[$num]['nombre_producto']);?></a>
                            <div class="ps-product__categories"><a href="product-listing.html"><?php echo strtoupper ($listaDescuento[$num]['descripcion_producto']);?></a></div>
                            <div class="ps-product__categories"><a href="product-listing.html"><?php echo strtoupper ($listaDescuento[$num]['color_producto']);?></a></div>
                            <p class="ps-product__price">
                            EN STOCK
                            </p><a class="ps-btn ps-btn--sm" href="product-detail-2.html">Mas informacion</a>
                            <p class="ps-product__feature"><i class="furniture-delivery-truck-2"></i><?php echo strtoupper ("EN: ".$listaDescuento[$i]['nombre_sucursal']);?></p>
                          </div>
                        </div>
                        <div class="ps-product__content"><a class="ps-product__title" href="product-detail-2.html"><?php echo strtoupper ($listaDescuento[$num]['nombre_producto']);?></a>
                          <div class="ps-product__categories"><a href="product-listing.html"><?php echo strtoupper ($listaDescuento[$num]['descripcion_producto']);?></a></div>
                          <p class="ps-product__price">
                            EN STOCK
                          </p>
                        </div>
                      </div>
                </div>
              </div>
              <?php $i++;}?>
            </div>
          </div>
          <div class="text-center"><a class="ps-btn ps-btn--blue" href="#">Mas Descuentos</a></div>
        </div>
      </div>
    </div>
      <div class="ps-home-collection-2">
          <div class="ps-collection double"><a class="ps-collection__overlay" href="#"></a><img src="public/imagenes/paginaweb/m-img1.jpg" alt=""></div>
          <div class="ps-collection double"><a class="ps-collection__overlay" href="#"></a><img src="public/imagenes/paginaweb/m-img2.jpg" alt=""></div>
          <div class="ps-collection double"><a class="ps-collection__overlay" href="#"></a><img src="public/imagenes/paginaweb/m-img3.jpg" alt=""></div>
      </div>
    </div>
    <div class="ps-partners">
      <div class="ps-container">
        <div class="ps-slider--partners owl-slider" data-owl-auto="true" data-owl-loop="true" data-owl-speed="1000" data-owl-gap="50" data-owl-nav="false" data-owl-dots="false" data-owl-item="5" data-owl-item-xs="2" data-owl-item-sm="3" data-owl-item-md="4" data-owl-item-lg="5" data-owl-duration="1000" data-owl-mousedrag="on">
          <?php for($i = 0; $i < sizeof($listaCategoria) ; $i++){?>
            <a href=<?php echo "mis-productos.php?c=".$listaCategoria[$i]['cod_categoria'];?>><img src=<?php echo "public/imagenes/categorias/".$listaCategoria[$i]['imagen_categoria'];?> alt=''></a>
          <?php }?>
          </div>
      </div>
    </div>
    <?php /*<div class="ps-home-product-list">
      <div class="ps-container">
        <div class="row">
              <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12 ">
                <h4 class="ps-heading">Features</h4>
                <div class="ps-product--horizontal">
                  <div class="ps-product__thumbnail"><a class="ps-product__overlay" href="product-detail.html"></a><img src="public/images/product/Item-1.jpg" alt=""></div>
                  <div class="ps-product__content"><a class="ps-product__title" href="#">VEDBO Version 2018</a>
                    <p class="ps-product__price"><del> £220</del> £120</p>
                        <select class="ps-rating">
                          <option value="1">1</option>
                          <option value="1">2</option>
                          <option value="1">3</option>
                          <option value="1">4</option>
                          <option value="2">5</option>
                        </select><a class="ps-btn" href="product-detail.html">Add to cart</a>
                  </div>
                </div>
                <div class="ps-product--horizontal">
                  <div class="ps-product__thumbnail"><a class="ps-product__overlay" href="product-detail.html"></a><img src="public/images/product/Item-2.jpg" alt=""></div>
                  <div class="ps-product__content"><a class="ps-product__title" href="#">VEDBO Version 2018</a>
                    <p class="ps-product__price"><del> £220</del> £120</p>
                        <select class="ps-rating">
                          <option value="1">1</option>
                          <option value="1">2</option>
                          <option value="1">3</option>
                          <option value="1">4</option>
                          <option value="2">5</option>
                        </select><a class="ps-btn" href="product-detail.html">Add to cart</a>
                  </div>
                </div>  
                <div class="ps-product--horizontal">
                  <div class="ps-product__thumbnail"><a class="ps-product__overlay" href="product-detail.html"></a><img src="public/images/product/Item-3.jpg" alt=""></div>
                  <div class="ps-product__content"><a class="ps-product__title" href="#">VEDBO Version 2018</a>
                    <p class="ps-product__price"><del> £220</del> £120</p>
                        <select class="ps-rating">
                          <option value="1">1</option>
                          <option value="1">2</option>
                          <option value="1">3</option>
                          <option value="1">4</option>
                          <option value="2">5</option>
                        </select><a class="ps-btn" href="product-detail.html">Add to cart</a>
                  </div>
                </div>
              </div>
              <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12 ">
                <h4 class="ps-heading">MEJOR VENDIDO</h4>
                <div class="ps-product--horizontal">
                  <div class="ps-product__thumbnail"><a class="ps-product__overlay" href="product-detail.html"></a><img src="public/images/product/Item-4.jpg" alt=""></div>
                  <div class="ps-product__content"><a class="ps-product__title" href="#">VEDBO Version 2018</a>
                    <p class="ps-product__price"><del> £220</del> £120</p>
                        <select class="ps-rating">
                          <option value="1">1</option>
                          <option value="1">2</option>
                          <option value="1">3</option>
                          <option value="1">4</option>
                          <option value="2">5</option>
                        </select><a class="ps-btn" href="product-detail.html">Add to cart</a>
                  </div>
                </div>
                <div class="ps-product--horizontal">
                  <div class="ps-product__thumbnail"><a class="ps-product__overlay" href="product-detail.html"></a><img src="public/images/product/Item-5.jpg" alt=""></div>
                  <div class="ps-product__content"><a class="ps-product__title" href="#">VEDBO Version 2018</a>
                    <p class="ps-product__price"><del> £220</del> £120</p>
                        <select class="ps-rating">
                          <option value="1">1</option>
                          <option value="1">2</option>
                          <option value="1">3</option>
                          <option value="1">4</option>
                          <option value="2">5</option>
                        </select><a class="ps-btn" href="product-detail.html">Add to cart</a>
                  </div>
                </div>
                <div class="ps-product--horizontal">
                  <div class="ps-product__thumbnail"><a class="ps-product__overlay" href="product-detail.html"></a><img src="public/images/product/Item-6.jpg" alt=""></div>
                  <div class="ps-product__content"><a class="ps-product__title" href="#">VEDBO Version 2018</a>
                    <p class="ps-product__price"><del> £220</del> £120</p>
                        <select class="ps-rating">
                          <option value="1">1</option>
                          <option value="1">2</option>
                          <option value="1">3</option>
                          <option value="1">4</option>
                          <option value="2">5</option>
                        </select><a class="ps-btn" href="product-detail.html">Add to cart</a>
                  </div>
                </div>
              </div>
              <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12 ">
                <h4 class="ps-heading">NUEVOS PRODUCTOS</h4>
                <div class="ps-product--horizontal">
                  <div class="ps-product__thumbnail"><a class="ps-product__overlay" href="product-detail.html"></a><img src="public/images/product/Item-7.jpg" alt=""></div>
                  <div class="ps-product__content"><a class="ps-product__title" href="#">VEDBO Version 2018</a>
                    <p class="ps-product__price"><del> £220</del> £120</p>
                        <select class="ps-rating">
                          <option value="1">1</option>
                          <option value="1">2</option>
                          <option value="1">3</option>
                          <option value="1">4</option>
                          <option value="2">5</option>
                        </select><a class="ps-btn" href="product-detail.html">Add to cart</a>
                  </div>
                </div>
                <div class="ps-product--horizontal">
                  <div class="ps-product__thumbnail"><a class="ps-product__overlay" href="product-detail.html"></a><img src="public/images/product/Item-8.jpg" alt=""></div>
                  <div class="ps-product__content"><a class="ps-product__title" href="#">VEDBO Version 2018</a>
                    <p class="ps-product__price"><del> £220</del> £120</p>
                        <select class="ps-rating">
                          <option value="1">1</option>
                          <option value="1">2</option>
                          <option value="1">3</option>
                          <option value="1">4</option>
                          <option value="2">5</option>
                        </select><a class="ps-btn" href="product-detail.html">Add to cart</a>
                  </div>
                </div>
                <div class="ps-product--horizontal">
                  <div class="ps-product__thumbnail"><a class="ps-product__overlay" href="product-detail.html"></a><img src="public/images/product/Item-9.jpg" alt=""></div>
                  <div class="ps-product__content"><a class="ps-product__title" href="#">VEDBO Version 2018</a>
                    <p class="ps-product__price"><del> £220</del> £120</p>
                        <select class="ps-rating">
                          <option value="1">1</option>
                          <option value="1">2</option>
                          <option value="1">3</option>
                          <option value="1">4</option>
                          <option value="2">5</option>
                        </select><a class="ps-btn" href="product-detail.html">Add to cart</a>
                  </div>
                </div>
              </div>
        </div>
        <div class="ps-section__footer pt-50"><a href="#"><img src="public/imagenes/paginaweb/img4.jpg" alt=""></a></div>
      </div>
    </div> */?>
    <?php /*<div class="ps-section ps-home-blog second">
      <div class="ps-container">
        <div class="ps-section__header text-center">
          <p>Last news</p>
          <h3 class="ps-section__title">From our Blog</h3><span class="ps-section__line"></span>
        </div>
        <div class="ps-section__content">
          <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 ">
                  <article class="ps-post--vertical">
                    <div class="ps-post__thumbnail"><a class="ps-post__overlay" href="#"></a><img src="public/images/post/1.jpg" alt="">
                    </div>
                    <div class="ps-post__content">
                      <div class="ps-post__meta">
                        <div class="ps-post__posted"><span class="date">25</span><span class="month">Dec</span></div>
                        <div class="ps-post__actions">
                          <div class="ps-post__action red"><a href="#"><i class="furniture-heart"></i><span><i>10</i></span></a></div>
                          <div class="ps-post__action cyan"><a href="#"><i class="fa fa-comment-o"></i><span><i>5</i></span></a></div>
                          <div class="ps-post__action shared"><a href="#"><i class="fa fa-share-alt"></i> Share</a>
                            <ul class="ps-list--shared">
                              <li class="facebook"><a href="#"><i class="fa fa-facebook"></i></a></li>
                              <li class="twitter"><a href="#"><i class="fa fa-twitter"></i></a></li>
                              <li class="google"><a href="#"><i class="fa fa-google-plus"></i></a></li>
                            </ul>
                          </div>
                        </div>
                      </div>
                      <div class="ps-post__container">
                        <h3 class="ps-post__title"><a href="blog-detail.html">Friday Fresh Recipes</a></h3>
                        <div class="ps-post__byline">By <a href="#"> Alena Studio</a></div>
                        <p>Leverage agile frameworks to provide a robust synopsis for high level overviews. Iterative approaches to corporate strategy foster collaborative thinking to further…</p><a class="ps-post__morelink" href="blog-detail.html">READ MORE</a>
                      </div>
                    </div>
                  </article>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 ">
                  <article class="ps-post--vertical">
                    <div class="ps-post__thumbnail"><a class="ps-post__overlay" href="#"></a><img src="public/images/post/2.jpg" alt="">
                    </div>
                    <div class="ps-post__content">
                      <div class="ps-post__meta">
                        <div class="ps-post__posted"><span class="date">25</span><span class="month">Dec</span></div>
                        <div class="ps-post__actions">
                          <div class="ps-post__action red"><a href="#"><i class="furniture-heart"></i><span><i>10</i></span></a></div>
                          <div class="ps-post__action cyan"><a href="#"><i class="fa fa-comment-o"></i><span><i>5</i></span></a></div>
                          <div class="ps-post__action shared"><a href="#"><i class="fa fa-share-alt"></i> Share</a>
                            <ul class="ps-list--shared">
                              <li class="facebook"><a href="#"><i class="fa fa-facebook"></i></a></li>
                              <li class="twitter"><a href="#"><i class="fa fa-twitter"></i></a></li>
                              <li class="google"><a href="#"><i class="fa fa-google-plus"></i></a></li>
                            </ul>
                          </div>
                        </div>
                      </div>
                      <div class="ps-post__container">
                        <h3 class="ps-post__title"><a href="blog-detail.html">Friday Fresh Recipes</a></h3>
                        <div class="ps-post__byline">By <a href="#"> Alena Studio</a></div>
                        <p>Leverage agile frameworks to provide a robust synopsis for high level overviews. Iterative approaches to corporate strategy foster collaborative thinking to further…</p><a class="ps-post__morelink" href="blog-detail.html">READ MORE</a>
                      </div>
                    </div>
                  </article>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 ">
                  <article class="ps-post--vertical">
                    <div class="ps-post__thumbnail"><a class="ps-post__overlay" href="#"></a><img src="public/images/post/2.jpg" alt="">
                    </div>
                    <div class="ps-post__content">
                      <div class="ps-post__meta">
                        <div class="ps-post__posted"><span class="date">25</span><span class="month">Dec</span></div>
                        <div class="ps-post__actions">
                          <div class="ps-post__action red"><a href="#"><i class="furniture-heart"></i><span><i>10</i></span></a></div>
                          <div class="ps-post__action cyan"><a href="#"><i class="fa fa-comment-o"></i><span><i>5</i></span></a></div>
                          <div class="ps-post__action shared"><a href="#"><i class="fa fa-share-alt"></i> Share</a>
                            <ul class="ps-list--shared">
                              <li class="facebook"><a href="#"><i class="fa fa-facebook"></i></a></li>
                              <li class="twitter"><a href="#"><i class="fa fa-twitter"></i></a></li>
                              <li class="google"><a href="#"><i class="fa fa-google-plus"></i></a></li>
                            </ul>
                          </div>
                        </div>
                      </div>
                      <div class="ps-post__container">
                        <h3 class="ps-post__title"><a href="blog-detail.html">Friday Fresh Recipes</a></h3>
                        <div class="ps-post__byline">By <a href="#"> Alena Studio</a></div>
                        <p>Leverage agile frameworks to provide a robust synopsis for high level overviews. Iterative approaches to corporate strategy foster collaborative thinking to further…</p><a class="ps-post__morelink" href="blog-detail.html">READ MORE</a>
                      </div>
                    </div>
                  </article>
                </div>
          </div>
        </div>
      </div>
    </div>*/?>
    <div class="ps-subscribe-2">
      <div class="container">
        <div class="ps-section__header">
          <h3>INGRESE SU CORRE ELECTRONICO</h3>
          <p>Para hacerle llegar acerca de nuestras <span> PROMOCIONES y PRODUCTOS</span></p>
        </div>
        <form class="ps-form--subscribe">
          <input class="form-control" type="text" id="txtEmail" placeholder="ingrese su Correo Electronico...">
          <button type="button" onclick="ingresarEmail()">ENVIAR</button>
        </form>
        <div class="ps-section__content"><img src="public/imagenes/paginaweb/subscribirse.png" alt=""></div>
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
                    contenido = contenido + "<li><a href='mis-productos.php?c="+datos[i].cod_categoria+"'>" + datos[i].nombre_categoria + "</a></li>";
                }
                document.getElementById("idListaCategoria").innerHTML = contenido;
              }
            })
        });

        function ingresarEmail(){
          var txtEmail = document.getElementById('txtEmail').value;
          var parametros = {
                "action" : "ingresarEmail",
                "email": txtEmail
            };
            $.ajax({
              type:'POST',
              data: parametros,
              url:'app/controladores/Configuraciones.php',
              success:function(data){
                alert("Gracias por Suscribirse con nosotros");
                document.getElementById('txtEmail').value = ""
              }
            })
        }
    </script>
  </body>
</html>