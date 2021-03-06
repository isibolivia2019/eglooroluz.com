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
                                    <h5 class="breadcrumbs-title">Registrar Nuevo Sueldo</h5>
                                    <ol class="breadcrumb">
                                        <li><a href="sueldo.php">Sueldo</a></li>
                                        <li class="active">Registrar Sueldo</li>
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
                                <form class="col s12">
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <input id="sueldo" type="number">
                                            <label for="sueldo">Monto del Sueldo</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <div class="input-field col s6 right">
                                                  <a class="btn waves-effect waves-light col s12" onclick="agregarSueldo()">Registrar</a>
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
            verificarAcceso("Permiso_Sueldo");
        });

        function agregarSueldo(){
            verificarAcceso("Permiso_Sueldo");
          var sueldo = document.getElementById('sueldo').value;

          var parametros = {
             "action" : "agregarSueldo",
             "sueldo" : sueldo,
          };
          $.ajax({
            type:'POST',
            data: parametros,
            url:'app/controladores/Sueldos.php',
            success:function(data){
                datos = JSON.parse(data);
                if(datos.resp == "true"){
                    Materialize.toast('Sueldo Registrado con exito', 5000)
                    document.getElementById('sueldo').value = "";
                }
                if(datos.resp == "false"){
                    Materialize.toast('Hubo un fallo al registrar el Sueldo. Vuelva a Intentarlo', 5000)
                }
                if(datos.resp != "true" && datos.resp != "false"){
                    Materialize.toast('Hubo un fallo al registrar el Sueldo COD:'+datos.resp, 5000)
                }
            }
          })
        }
    </script>
</body>
</html>