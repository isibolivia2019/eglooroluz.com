<?php
ini_set('display_errors', '1');
session_start();
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <?php require("app-head.php");?>
    </head>

    <body>
        <div id="loader-wrapper">
            <div id="loader"></div>        
            <div class="loader-section section-left"></div>
            <div class="loader-section section-right"></div>
        </div>

        <?php require("app-header.php");?>
        
        <div id="main">
            <div class="wrapper">
                <?php require("app-slider.php");?>
                
                <section id="content">
                    <div id="breadcrumbs-wrapper" class=" grey lighten-3">
                        <div class="container">
                            <div class="row">
                                <div class="col s12 m12 l12">
                                    <h5 class="breadcrumbs-title">Registrar Nueva Compra de Producto</h5>
                                    <ol class="breadcrumb">
                                        <li><a href="producto.php">Producto</a></li>
                                        <li class="active">Comprar producto</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="container">
                        <div class="section">
                            <p class="caption">Llene el Siguiente Formulario.</p>
                            <div class="divider"></div>
                            <div class="row">
                                  <div class="col s12 m4 l3">
                                    <div id="divImagen">
                                        
                                        </div>
                                  </div>
                                  <div class="col s12 m8 l9">
                                    <ul class="collection">
                                        <li class="collection-item avatar" id="lblDatos1">
                                            
                                        </li>
                                    </ul>
                                  </div>
                                </div>
                            <div class="row">
                                <form class="col s12">
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <input id="cantidad" type="number">
                                            <label for="cantidad">Cantidad de la Compra</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <input id="costo" type="number" step="0.01">
                                            <label for="costo">Costo de Adquision</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <input id="precio" type="number" step="0.01">
                                            <label for="precio">Precio sugerido de Venta</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col s12 m8 l9">
                                            <label>Lugar de Almacenamiento</label>
                                            <select class="browser-default" id="cboxAlmacenamiento">
                                                <option value="" disabled selected>Seleccione un Punto</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <input id="observacion" type="text">
                                            <label for="observacion">Observacion de Compra</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <div class="input-field col s6 right">
                                                  <a class="btn waves-effect waves-light col s12" onclick="agregarCompra()">Registrar</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <br>
                            <div class="divider"></div> 
                        </div>
                    </div>
                </section>
            </div>
        </div>

        <?php require("app-footer.php");?>
        <?php require("app-foot.php");?>

    <script>
        function listaAlmacenamiento(){
            verificarAcceso("Permiso_Producto");
            var cboxAlmacenamiento = document.getElementById("cboxAlmacenamiento");
            var parametros = {
             "action" : "productoEspecifico",
             "cod_producto" : localStorage.getItem("producto")
          };
          $.ajax({
            type:'POST',
            data: parametros,
            url:'app/controladores/Productos.php',
            success:function(data){
                datos = JSON.parse(data);
                document.getElementById("lblDatos1").innerHTML = 
                    "<i class='mdi-file-folder circle'></i>"+
                    "<span class='title'>#"+datos[0].cod_item_producto+"</span>"+
                    "<p>Nombre: "+datos[0].nombre_producto+
                    "</p>";
                    document.getElementById("divImagen").innerHTML = "<img width='150'src=public/imagenes/productos/"+datos[0].imagen_producto+">";
            }
          })
          parametros = {
            "action" : "listaAlmacenes"            
          };
          $.ajax({
            type:'POST',
            data: parametros,
            url:'app/controladores/Almacenes.php',
            success:function(data){
                datos = JSON.parse(data);
                datos = datos.data;
                for(let i=0 ; i<datos.length ; i++){
                    var tag = document.createElement('option');
                    tag.setAttribute('value', datos[i].cod_almacen);
                    tag.innerHTML = datos[i].nombre_almacen;
                    cboxAlmacenamiento.appendChild(tag);
                }
            }
          })
          parametros = {
             "action" : "listaSucursales"        
          };
          $.ajax({
            type:'POST',
            data: parametros,
            url:'app/controladores/Sucursales.php',
            success:function(data){
                datos = JSON.parse(data);
                datos = datos.data;
                for(let i=0 ; i<datos.length ; i++){
                    var tag = document.createElement('option');
                    tag.setAttribute('value', datos[i].cod_sucursal);
                    tag.innerHTML = datos[i].nombre_sucursal;
                    cboxAlmacenamiento.appendChild(tag);
                }
            }
          })
        }

        $(document).ready(function() {
            listaAlmacenamiento()
        });

        function agregarCompra(){
            verificarAcceso("Permiso_Producto");
          var cantidad = document.getElementById('cantidad').value;
          var costo = document.getElementById('costo').value;
          var precio = document.getElementById('precio').value;
          var cboxAlmacenamiento = document.getElementById('cboxAlmacenamiento').value;
          var observacion = document.getElementById('observacion').value;

          var parametros = {
             "action" : "agregarCompra",
             "cod_producto" : localStorage.getItem("producto"),
             "cantidad" : cantidad,
             "costo" : costo,
             "precio" : precio,
             "cboxAlmacenamiento" : cboxAlmacenamiento,
             "observacion" : observacion,
          };
          $.ajax({
            type:'POST',
            data: parametros,
            url:'app/controladores/Productos.php',
            success:function(data){
                console.log("data", data)
                datos = JSON.parse(data);
                if(datos.resp == "true"){
                    Materialize.toast('Compra del Producto Registrado con exito', 5000)
                    document.getElementById('sueldo').value = "";
                }
                if(datos.resp == "false"){
                    Materialize.toast('Hubo un fallo al registrar la compra del Producto. Vuelva a Intentarlo', 5000)
                }
                if(datos.resp != "true" && datos.resp != "false"){
                    Materialize.toast('Hubo un fallo al registrar la compra del Producto COD:'+datos.resp, 5000)
                }
            }
          })
        }
    </script>
</body>
</html>