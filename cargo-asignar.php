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
                                    <h5 class="breadcrumbs-title">Asignar Cargo a un Personal</h5>
                                    <ol class="breadcrumb">
                                        <li><a href="cargo.php">Cargo</a></li>
                                        <li class="active">Asignar Cargo</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="container">
                        <div class="section">
                            <p class="caption">Seleccione un Cargo y un Personal</p>
                            <div class="divider"></div>
                            <div class="row">
                                <form class="col s12">
                                    <div class="row">
                                    <div class="input-field col s12">
                                            <select class="browser-default" id="cboxCargo">
                                                <option value="" disabled selected>Seleccione el Cargo</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <select class="browser-default" id="cboxUsuario">
                                                <option value="" disabled selected>Seleccione al Personal</option>
                                            </select>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <button class="btn cyan waves-effect waves-light right" type="button" name="action" onclick="asignarUsuarioCargo()">Asignar Cargo
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
            listaUsuarios();
            var cboxCargo = document.getElementById("cboxCargo");
            var parametros = {
             "action" : "listaCargos"        
          };
          $.ajax({
            type:'POST',
            data: parametros,
            url:'app/controladores/Cargos.php',
            success:function(data){
                console.log("data", data)
                datos = JSON.parse(data);
                datos = datos.data
                for(let i=0 ; i<datos.length ; i++){
                    var tag = document.createElement('option');
                    tag.setAttribute('value', datos[i].cod_cargo);
                    tag.innerHTML = datos[i].nombre_cargo;
                    cboxCargo.appendChild(tag);
                }
            }
          })
        });

        function listaUsuarios(){
            verificarAcceso("Permiso_Cargo");
            var cboxUsuario = document.getElementById("cboxUsuario");
            var parametros = {
             "action" : "listaUsuarioSinCargo"        
          };
          $.ajax({
            type:'POST',
            data: parametros,
            url:'app/controladores/Usuarios.php',
            success:function(data){
                datos = JSON.parse(data);
                for(let i=0 ; i<datos.length ; i++){
                    var tag = document.createElement('option');
                    tag.setAttribute('value', datos[i].cod_usuario);
                    tag.innerHTML = datos[i].nombre_usuario+" "+datos[i].appat_usuario+" "+datos[i].apmat_usuario;
                    cboxUsuario.appendChild(tag);
                }
            }
          })
        }

        function asignarUsuarioCargo(){
            //$('body').addClass('loaded');
            verificarAcceso("Permiso_Cargo");
            var cboxUsuario = document.getElementById("cboxUsuario").value;
            var cboxCargo = document.getElementById("cboxCargo").value;
            var parametros = {
                "action" : "asignarUsuarioCargo",
                "usuario" : cboxUsuario,
                "cargo" : cboxCargo
            };
            $.ajax({
                type:'POST',
                data: parametros,
                url:'app/controladores/Cargos.php',
                success:function(data){
                    datos = JSON.parse(data);
                    if(datos.resp == "true"){
                        Materialize.toast('El Usuario fue asignado correctamente al Cargo', 7000)
                    }
                    if(datos.resp == "false"){
                        Materialize.toast('El Usuario ya se encuentra asignado a este Cargo', 7000)
                    }
                    if(datos.resp != "true" && datos.resp != "false"){
                        Materialize.toast('Hubo un fallo al asignar al Usuario en el Cargo COD:'+datos.resp, 7000)
                    }      
                }
            })
        }
    </script>
</body>
</html>