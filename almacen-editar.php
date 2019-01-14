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
                                    <h5 class="breadcrumbs-title">Editar datos de un Almacen</h5>
                                    <ol class="breadcrumb">
                                        <li><a href="almacen.php">Almacenes</a></li>
                                        <li class="active">Editar Almacen</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="container">
                        <div class="section">
                            <p class="caption">Modifique el Siguiente Formulario.</p>
                            <div class="divider"></div>
                            <div class="row">
                                <form class="col s12">
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <input placeholder="" id="nombre" type="text">
                                            <label for="nombre">Nombre del Almacen</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <input placeholder="" id="direccion" type="text">
                                            <label for="direccion">Direccion del Almacen</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <div class="input-field col s6 right">
                                                  <a class="btn waves-effect waves-light col s12" onclick="actualizarAlmacen()">Actualizar</a>
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
        $(document).ready(function() {
            verificarAcceso("Permiso_Almacen");
            var parametros = {
                "action" : "almacenEspecifico",
                "cod_almacen" : localStorage.getItem("almacen")
            };
            $.ajax({
              type:'POST',
              data: parametros,
              url:'app/controladores/Almacenes.php',
              success:function(data){
                datos = JSON.parse(data);
                document.getElementById('nombre').value = datos[0].nombre_almacen;
                document.getElementById('direccion').value = datos[0].direccion_almacen;
              }
            })
        });

        function actualizarAlmacen(){
          var nombre = document.getElementById('nombre').value;
          var direccion = document.getElementById('direccion').value;
          var parametros = {
             "action" : "actualizarAlmacen",
             "codigo" : localStorage.getItem("almacen"),
             "nombre" : nombre,
             "direccion" : direccion,
          };
          $.ajax({
            type:'POST',
            data: parametros,
            url:'app/controladores/Almacenes.php',
            success:function(data){
                datos = JSON.parse(data);
                if(datos.resp == "true"){
                    Materialize.toast('Almacen Actualizado con exito', 5000)
                }
                if(datos.resp == "false"){
                    Materialize.toast('Hubo un fallo al actualizar el Almacen. Vuelva a Intentarlo', 5000)
                }
                if(datos.resp != "true" && datos.resp != "false"){
                    Materialize.toast('Hubo un fallo al actualizar el Almacen COD:'+datos.resp, 5000)
                }
            }
          })
        }
    </script>
</body>
</html>