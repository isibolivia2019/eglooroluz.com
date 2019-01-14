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
                                    <h5 class="breadcrumbs-title">Editar datos de Usuario</h5>
                                    <ol class="breadcrumb">
                                        <li><a href="usuario.php">Usuarios</a></li>
                                        <li class="active">Editar Usuario</li>
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
                                            <label for="first_name">Nombre (s)</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s6">
                                            <input placeholder="" id="appat" type="text">
                                            <label for="appat">Primer Apellido</label>
                                        </div>

                                        <div class="input-field col s6">
                                            <input placeholder="" id="apmat" type="text">
                                            <label for="apmat">Segundo Apellido</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s6">
                                            <input placeholder="" id="ci" type="number">
                                            <label for="ci">Cedula de Identidad</label>
                                        </div>

                                        <div class="input-field col s6">
                                            <select id="ci_exp" required>
                                                <option value="" disabled selected>Seleccione la Expedicion</option>
                                                <option value="1">Beni</option>
                                                <option value="2">Cochabamba</option>
                                                <option value="3">Chuquisaca</option>
                                                <option value="1">La Paz</option>
                                                <option value="2">Oruro</option>
                                                <option value="3">Pando</option>
                                                <option value="1">Potosi</option>
                                                <option value="2">Santa Cruz</option>
                                                <option value="3">Tarija</option>
                                            </select>
                                            <label>Expedicion</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s6">
                                            <input placeholder="" id="email" type="email">
                                            <label for="email">Correo Electronico</label>
                                        </div>
                                        <div class="input-field col s6">
                                            <select id="genero"required>
                                                <option value="" disabled selected>Seleccione el Genero</option>
                                                <option value="Masculino">Masculino</option>
                                                <option value="Femenino">Femenino</option>
                                            </select>
                                            <label>Genero</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s6">
                                            <input placeholder="" id="telefono" type="number">
                                            <label for="telefono">Telefono / Celular</label>
                                        </div>
                                        <div class="input-field col s6">
                                            <div placeholder="" class="input-field col s12 m6 l6">
                                                <label for="fec_nac">Fecha de Nacimiento</label>
                                            </div>
                                            <div placeholder="" class="input-field col s12 m6 l6">
                                                <input id="fec_nac" type="date">
                                             </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <input placeholder="" id="direccion" type="text">
                                            <label for="direccion">Direccion de Domicilio</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <input placeholder="" id="pass" type="password">
                                            <label for="pass">Contraseña</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <input placeholder="" id="nombre_ref" type="text">
                                            <label for="nombre_ref">Nombre (s) y Apellidos de referencia</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s6">
                                            <input placeholder="" id="telefono_ref" type="number">
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
                                            <div class="input-field col s12">
                                                <div class="input-field col s6 right">
                                                  <a class="btn waves-effect waves-light col s12" onclick="actualizarUsuario()">Actualizar</a>
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
            verificarAcceso("Permiso_Usuario");
            var parametros = {
                "action" : "usuarioEspecifico",
                "usuario" : localStorage.getItem("usuario")
            };
            $.ajax({
              type:'POST',
              data: parametros,
              url:'app/controladores/Usuarios.php',
              success:function(data){
                datos = JSON.parse(data);
                document.getElementById('nombre').value = datos[0].nombre_usuario;
                document.getElementById('appat').value = datos[0].appat_usuario;
                document.getElementById('apmat').value = datos[0].apmat_usuario;
                document.getElementById('ci').value = datos[0].ci_usuario;
                document.getElementById('ci_exp').value = datos[0].ci_exp_usuario;
                document.getElementById('email').value = datos[0].email_usuario;
                document.getElementById('genero').value = datos[0].genero_usuario;
                document.getElementById('telefono').value = datos[0].telefono_usuario;
                document.getElementById('fec_nac').value = datos[0].fec_nac_usuario;
                document.getElementById('direccion').value = datos[0].direccion_usuario;
                document.getElementById('pass').value = datos[0].pass_usuario;
                document.getElementById('nombre_ref').value = datos[0].nombre_ref_usuario;
                document.getElementById('telefono_ref').value = datos[0].telefono_ref_usuario;
                document.getElementById('tipo_ref').value = datos[0].tipo_ref_usuario;
              }
            })
        });

        function actualizarUsuario(){
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
          if(ci_exp != ""){
            if(genero != ""){
                if(tipo_ref != ""){
                    var parametros = {
                       "action" : "actualizarUsuario",
                       "codigo" : localStorage.getItem("usuario"),
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
                       "tipoRef" : tipo_ref
                    };
                    $.ajax({
                      type:'POST',
                      data: parametros,
                      url:'app/controladores/Usuarios.php',
                      success:function(data){
                          datos = JSON.parse(data);
                          if(datos.resp == "true"){
                              Materialize.toast('Datos del Usuario actualizado con exito', 5000)
                          }
                          if(datos.resp == "false"){
                              Materialize.toast('Hubo un fallo al actualizar el usuario. Vuelva a Intentarlo', 5000)
                          }
                          if(datos.resp != "true" && datos.resp != "false"){
                              Materialize.toast('Hubo un fallo al actualizar el usuario COD:'+datos.resp, 5000)
                          }
                      }
                    })
                }else{
                    Materialize.toast('Seleccione el tipo de Referencia', 5000)
                }
            }else{
                Materialize.toast('Seleccione el genero', 5000)
            }
          }else{
            Materialize.toast('Seleccione la expedicion de CI', 5000)
          }
        }
    </script>
</body>
</html>