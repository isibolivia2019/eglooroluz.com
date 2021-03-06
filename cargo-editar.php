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
                                    <h5 class="breadcrumbs-title">Editar datos del Cargo</h5>
                                    <ol class="breadcrumb">
                                        <li><a href="cargo.php">Cargo</a></li>
                                        <li class="active">Editar Cargo</li>
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
                                            <input id="nombre" type="text">
                                            <label for="nombre">Nombre del Cargo</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <input id="descripcion" type="text">
                                            <label for="descripcion">Descripcion del Cargo</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <button class="btn cyan waves-effect waves-light right" type="button" name="action" onclick="actualizarCargo()">Actualizar
                                                    <i class="mdi-content-send right"></i>
                                                </button>
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
            verificarAcceso("Permiso_Cargo");
            var parametros = {
                "action" : "cargoEspecifico",
                "cod_cargo" : localStorage.getItem("cargo")
            };
            $.ajax({
              type:'POST',
              data: parametros,
              url:'app/controladores/Cargos.php',
              success:function(data){
                datos = JSON.parse(data);
                document.getElementById('nombre').value = datos[0].nombre_cargo;
                document.getElementById('descripcion').value = datos[0].descripcion_cargo;
              }
            })
        });

        function actualizarCargo(){
        verificarAcceso("Permiso_Cargo");
          var nombre = document.getElementById('nombre').value;
          var descripcion = document.getElementById('descripcion').value;
          var parametros = {
             "action" : "actualizarCargo",
             "codigo" : localStorage.getItem("cargo"),
             "nombre" : nombre,
             "descripcion" : descripcion
          };
          $.ajax({
            type:'POST',
            data: parametros,
            url:'app/controladores/Cargos.php',
            success:function(data){
                datos = JSON.parse(data);
                if(datos.resp == "true"){
                    Materialize.toast('Cargo Actualizado con exito', 5000)
                }
                if(datos.resp == "false"){
                    Materialize.toast('Hubo un fallo al actualizar el Cargo. Vuelva a Intentarlo', 5000)
                }
                if(datos.resp != "true" && datos.resp != "false"){
                    Materialize.toast('Hubo un fallo al actualizar el Cargo COD:'+datos.resp, 5000)
                }
            }
          })
        }
    </script>
</body>
</html>