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
                                    <h5 class="breadcrumbs-title">Registrar Usuario</h5>
                                    <ol class="breadcrumb">
                                        <li><a href="usuario.php">Usuarios</a></li>
                                        <li class="active">Registrar Usuario</li>
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
                                            <input id="nombre" type="text">
                                            <label for="nombre">Nombre (s)</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s6">
                                            <input id="appat" type="text">
                                            <label for="appat">Primer Apellido</label>
                                        </div>

                                        <div class="input-field col s6">
                                            <input id="apmat" type="text">
                                            <label for="apmat">Segundo Apellido</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s6">
                                            <input id="ci" type="number">
                                            <label for="ci">Cedula de Identidad</label>
                                        </div>

                                        <div class="input-field col s6">
                                            <select id="ci_exp" required>
                                                <option value="" disabled selected>Seleccione la Expedicion</option>
                                                <option value="BN">Beni</option>
                                                <option value="CB">Cochabamba</option>
                                                <option value="CH">Chuquisaca</option>
                                                <option value="LP">La Paz</option>
                                                <option value="OR">Oruro</option>
                                                <option value="PA">Pando</option>
                                                <option value="PT">Potosi</option>
                                                <option value="SC">Santa Cruz</option>
                                                <option value="TJ">Tarija</option>
                                            </select>
                                            <label>Expedicion</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s6">
                                            <input id="email" type="email">
                                            <label for="email">Correo Electronico</label>
                                        </div>
                                        <div class="input-field col s6">
                                            <select id="genero" required>
                                                <option value="" disabled selected>Seleccione el Genero</option>
                                                <option value="Masculino">Masculino</option>
                                                <option value="Femenino">Femenino</option>
                                            </select>
                                            <label>Genero</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s6">
                                            <input id="telefono" type="number">
                                            <label for="telefono">Telefono / Celular</label>
                                        </div>
                                        <div class="input-field col s6">
                                            <div class="input-field col s12 m6 l6">
                                                <label for="fec_nac">Fecha de Nacimiento</label>
                                            </div>
                                            <div class="input-field col s12 m6 l6">
                                                <input id="fec_nac" type="date">
                                             </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <input id="direccion" type="text">
                                            <label for="direccion">Direccion de Domicilio</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <input id="pass" type="password">
                                            <label for="pass">Contraseña</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <input id="nombre_ref" type="text">
                                            <label for="nombre_ref">Nombre (s) y Apellidos de referencia</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s6">
                                            <input id="telefono_ref" type="number">
                                            <label for="telefono_ref">Celular / Tel Ref</label>
                                        </div>
                                        <div class="input-field col s6">
                                            <select id="tipo_ref" required>
                                                <option value="" disabled selected>Seleccione la referencia</option>
                                                <option value="Familiar">Familiar</option>
                                                <option value="Amistad">Amistad</option>
                                            </select>
                                            <label>Referencia</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s6 right">
                                              <a class="btn waves-effect waves-light col s12" onclick="agregarUsuario()">Registrar</a>
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
            verificarAcceso("Permiso_Usuario");
        });

        function agregarUsuario(){
          var nombre = document.getElementById('nombre').value;
          var appat = document.getElementById('appat').value;
          var apmat = document.getElementById('apmat').value;
          var ci = document.getElementById('ci').value;
          var ci_exp = document.getElementById('ci_exp').value;
          var email = document.getElementById('email').value;
          var genero = document.getElementById('genero').value;
          var telefono = document.getElementById('telefono').value;
          var fec_nac = document.getElementById('fec_nac').value;
          var direccion = document.getElementById('direccion').value;
          var pass = document.getElementById('pass').value;
          var nombre_ref = document.getElementById('nombre_ref').value;
          var telefono_ref = document.getElementById('telefono_ref').value;
          var tipo_ref = document.getElementById('tipo_ref').value;
          var codCargo = "1";
          var estado = "1";

          var parametros = {
             "action" : "agregarUsuario",
             "nombre" : nombre,
             "appat" : appat,
             "apmat" : apmat,
             "ci" : ci,
             "ci_exp" : ci_exp,
             "email" : email,
             "genero" : genero,
             "telefono" : telefono,
             "fec_nac" : fec_nac,
             "direccion" : direccion,
             "pass" : pass,
             "nombreRef" : nombre_ref,
             "telefonoRef" : telefono_ref,
             "tipoRef" : tipo_ref,
             "codCargo" : codCargo,
             "estado" : estado
          };
          $.ajax({
            type:'POST',
            data: parametros,
            url:'app/controladores/Usuarios.php',
            success:function(data){
                datos = JSON.parse(data);
                if(datos.resp == "true"){
                    Materialize.toast('Usuario Registrado con exito', 5000)

                    document.getElementById('nombre').value = "";
                    document.getElementById('appat').value = "";
                    document.getElementById('apmat').value = "";
                    document.getElementById('ci').value = "";
                    document.getElementById('ci_exp').value = "";
                    document.getElementById('email').value = "";
                    document.getElementById('genero').value = "";
                    document.getElementById('telefono').value = "";
                    document.getElementById('fec_nac').value = "";
                    document.getElementById('direccion').value = "";
                    document.getElementById('pass').value = "";
                    document.getElementById('nombre_ref').value = "";
                    document.getElementById('telefono_ref').value = "";
                    document.getElementById('tipo_ref').value = "";
                }
                if(datos.resp == "false"){
                    Materialize.toast('Hubo un fallo al registrar el usuario. Vuelva a Intentarlo', 5000)
                }
                if(datos.resp != "true" && datos.resp != "false"){
                    Materialize.toast('Hubo un fallo al registrar el usuario COD:'+datos.resp, 5000)
                }
            }
          })
        }
    </script>
</body>
</html>