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
                                    <h5 class="breadcrumbs-title">Lista de Usuarios Deshabilitados</h5>
                                    <ol class="breadcrumb">
                                        <li><a href="usuario.php">Usuarios </a></li>
                                        <li class="active">Deshabilitados</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="container">
                        <div class="section">
                            <p class="caption">Usuarios Deshabilitados para el uso del sistema.</p>
                            <div class="divider"></div>
                            <div id="table-datatables">
                                <h4 class="header">Usuarios</h4>
                                <div class="row">
                                    <div class="col s12">
                                        <table id="table-simple" class="responsive-table display" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>Nombre(s)</th>
                                                    <th>Ap. Paterno</th>
                                                    <th>Ap. Materno</th>
                                                    <th>Telefono</th>
                                                    <th>Ver Datos</th>
                                                    <th>Editar</th>
                                                    <th>Habilitar</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>Nombre(s)</th>
                                                    <th>Ap. Paterno</th>
                                                    <th>Ap. Materno</th>
                                                    <th>Telefono</th>
                                                    <th>Ver Datos</th>
                                                    <th>Editar</th>
                                                    <th>Habilitar</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
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
            actualizarLista();
        });

        var btn_editar = function(tbody, table){
                $(tbody).on("click", "button.editar", function(){
                    var data = table.row( $(this).parents("tr") ).data();
                    localStorage.setItem("usuario", data.cod_usuario);
                    location.href = "usuario-editar.php";
                })
        }
        var btn_ver_datos = function(tbody, table){
                $(tbody).on("click", "button.datos", function(){
                    var data = table.row( $(this).parents("tr") ).data();
                    localStorage.setItem("usuario", data.cod_usuario);
                    location.href = "usuario-datos.php";
                })
        }
        var btn_deshabilitar = function(tbody, table){
                $(tbody).on("click", "button.deshabilitar", function(){
                    var data = table.row( $(this).parents("tr") ).data();
                    var tableRemove = $(this).parents("tr");
                    var parametros = {
                       "action" : "cambiarEstado",
                       "codigo" : data.cod_usuario,
                       "estado" : "1",
                    };
                    $.ajax({
                      type:'POST',
                      data: parametros,
                      url:'app/controladores/Usuarios.php',
                      success:function(data){
                          datos = JSON.parse(data);
                          if(datos.resp == "true"){
                              Materialize.toast('Datos del Usuario actualizado con exito', 5000)
                              table.row(tableRemove).remove().draw(false);
                          }
                          if(datos.resp == "false"){
                              Materialize.toast('Hubo un fallo al actualizar el usuario. Vuelva a Intentarlo', 5000)
                          }
                          if(datos.resp != "true" && datos.resp != "false"){
                              Materialize.toast('Hubo un fallo al actualizar el usuario COD:'+datos.resp, 5000)
                          }
                      }
                    })
                })
        }

        function actualizarLista(){
            verificarAcceso("Permiso_Usuario");
            var parametros = {
                "action" : "listaUsuarioEstado",
                "estado" : "0"
            };
            var table = $('#table-simple').DataTable({
                "destroy":true,
                "ajax":{
                    "method": "POST",
                    "data":  parametros,
                    "url": "app/controladores/Usuarios.php"
                },
                "columns": [
                    {"data" : "nombre_usuario"},
                    {"data" : "appat_usuario"},
                    {"data" : "apmat_usuario"},
                    {"data" : "telefono_usuario"},
                    {"defaultContent" : "<button id='datos' class='datos btn waves-effect light-green' type='submit' name='action'><i class='mdi-file-folder-open'></i></button>"},
                    {"defaultContent" : "<button id='editar' class='editar btn waves-effect blue' type='button' name='editar'><i class='mdi-editor-border-color'></i></button>"},
                    {"defaultContent" : "<button id='deshabilitar' class='deshabilitar btn waves-effect green' type='submit' name='action'><i class='mdi-navigation-check'></i></button>"}
                ],
                "language": {
                    "url": "public/Spanish.lang"
                }
            });
            btn_editar("#table-simple tbody", table);
            btn_ver_datos("#table-simple tbody", table);
            btn_deshabilitar("#table-simple tbody", table);
        }
    </script>
</body>
</html>