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
                                    <h5 class="breadcrumbs-title">Agregar Acceso a Sucursal</h5>
                                    <ol class="breadcrumb">
                                        <li><a href="acceso.php">Accesos</a></li>
                                        <li class="active">Agregar Acceso</li>
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
                                        <div class="col s12 m8 l9">
                                            <label>Sucursal</label>
                                            <select class="browser-default" id="cboxSucursal">
                                                <option value="" disabled selected>Seleccione una Sucursal</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col s12 m8 l9">
                                            <label>Personal</label>
                                            <select class="browser-default" id="cboxUsuario">
                                                <option value="" disabled selected>Seleccione el Personal</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <div class="input-field col s6 right">
                                                  <a class="btn waves-effect waves-light col s12" onclick="agregarCompra()">Asignar Acceso</a>
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
        function listaSucursal(){
            verificarAcceso("Permiso_Acceso");
            var cboxSucursal = document.getElementById("cboxSucursal");
            var cboxUsuario = document.getElementById("cboxUsuario");
          
            var parametros = {
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
                        cboxSucursal.appendChild(tag);
                    }
                }
            })
            parametros = {
               "action" : "listaUsuarioEstado",
               "estado" : "1"
            };
            $.ajax({
              type:'POST',
              data: parametros,
              url:'app/controladores/Usuarios.php',
              success:function(data){
                    datos = JSON.parse(data);
                    datos = datos.data;
                    for(let i=0 ; i<datos.length ; i++){
                        var tag = document.createElement('option');
                        tag.setAttribute('value', datos[i].cod_usuario);
                        tag.innerHTML = datos[i].nombre_usuario + " " + datos[i].appat_usuario + " " + datos[i].apmat_usuario;
                        cboxUsuario.appendChild(tag);
                    }
                }
            })
        }

        $(document).ready(function() {
            listaSucursal()
        });

        function agregarCompra(){
            verificarAcceso("Permiso_Acceso");

            var cboxUsuario = document.getElementById("cboxUsuario").value;
            var cboxSucursal = document.getElementById("cboxSucursal").value;
            var parametros = {
                "action" : "asignarUsuarioSucursal",
                "usuario" : cboxUsuario,
                "sucursal" : cboxSucursal
            };
            $.ajax({
                type:'POST',
                data: parametros,
                url:'app/controladores/Accesos.php',
                success:function(data){
                    datos = JSON.parse(data);
                    if(datos.resp == "true"){
                        Materialize.toast('El Usuario fue asignado correctamente a la Sucursal', 7000)
                    }
                    if(datos.resp == "false"){
                        Materialize.toast('El Usuario ya se encuentra asignado a la Sucursal', 7000)
                    }
                    if(datos.resp != "true" && datos.resp != "false"){
                        Materialize.toast('Hubo un fallo al asignar al Usuario en la Sucursal COD:'+datos.resp, 7000)
                    }      
                }
            })
        }
    </script>
</body>
</html>