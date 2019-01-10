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
                                    <h5 class="breadcrumbs-title">Datos del Usuario</h5>
                                    <ol class="breadcrumb">
                                        <li><a href="usuario.php">Usuarios</a></li>
                                        <li class="active">Datos de Usuario</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="container">
                        <div class="section">
                            <p class="caption">Informacion del usuario.</p>
                            <div class="divider"></div>
                                <div class="row">
                                  <div class="col s12 m4 l3">
                                    <p class="header">Datos Personales</p>
                                  </div>
                                  <div class="col s12 m8 l9">
                                    <ul class="collection">
                                        <li class="collection-item avatar" id="lblDatos1">
                                            
                                        </li>
                                        <li class="collection-item avatar" id="lblDatos2">
                                            
                                        </li>
                                        <li class="collection-item avatar" id="lblDatos3">
                                            
                                        </li>
                                        <li class="collection-item avatar" id="lblDatos4">
                                            
                                        </li>
                                    </ul>
                                  </div>
                                </div>
                                <div class="row">
                                    <div class="col s12 m8 l9">
                                        <button class="btn cyan waves-effect waves-light " type="submit" name="action">Editar Datos
                                        <i class="mdi-content-send right"></i>
                                      </button>
                                      <button class="btn red waves-effect waves-light " type="submit" name="action">Ver Contraseña
                                        <i class="mdi-content-send right"></i>
                                      </button>
                                    </div>
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
            verificarAcceso("Permiso_Usuario");
            //localStorage.clear();
            var parametros = {
                "action" : "usuarioEspecifico",
                "usuario" : localStorage.getItem("usuario")
            };
            $.ajax({
              type:'POST',
              data: parametros,
              url:'app/controladores/Usuarios.php',
              success:function(data){
                $datos = JSON.parse(data);
                document.getElementById("lblDatos1").innerHTML = 
                "<img src='public/images/avatar.jpg' alt='' class='circle'>"+
                "<span class='title'>"+$datos[0].nombre_usuario+" "+$datos[0].appat_usuario+" "+$datos[0].apmat_usuario+"</span>"+
                "<p>C.I. : "+$datos[0].ci_usuario+" "+$datos[0].ci_exp_usuario+
                "<p>Genero : "+$datos[0].genero_usuario+
                "</p>";
                document.getElementById("lblDatos2").innerHTML = 
                "<i class='mdi-file-folder circle'></i>"+
                "<p>Fec. Nacimiento : "+$datos[0].fec_nac_usuario+
                "<p>Direccion : "+$datos[0].direccion_usuario+
                "</p>";
                document.getElementById("lblDatos3").innerHTML =
                "<i class='mdi-file-folder circle'></i>"+
                "<p>Telefono : "+$datos[0].telefono_usuario+
                "<p>Correo Electronico : "+$datos[0].email_usuario+
                "</p>";
                document.getElementById("lblDatos4").innerHTML =
                "<i class='mdi-action-assessment circle green'></i>"+
                "<p>"+$datos[0].nombre_ref_usuario+" ("+$datos[0].tipo_ref_usuario+")"+
                "<p>"+$datos[0].telefono_ref_usuario+
                "</p>";
              }
            })
        });
    </script>
</body>
</html>