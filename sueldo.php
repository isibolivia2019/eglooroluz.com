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
                                    <h5 class="breadcrumbs-title">Lista de Sueldos</h5>
                                    <ol class="breadcrumb">
                                        <li><a href="inicio.php">Inicio</a></li>
                                        <li class="active">Sueldos</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="container">
                        <div class="section">
                            <p class="caption">Sueldos registrados para el Personal.</p>
                            <div class="divider"></div>
                            <div id="table-datatables">
                                <h4 class="header">Sueldos</h4>
                                <div class="row">
                                    <div class="col s12">
                                        <table id="table-simple" class="responsive-table display" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>Sueldo</th>
                                                    <th>Ver Datos</th>
                                                    <th>Editar</th>
                                                    <th>Eliminar</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>Sueldo</th>
                                                    <th>Ver Datos</th>
                                                    <th>Editar</th>
                                                    <th>Eliminar</th>
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
            actualizarLista()
        });

        var btn_editar = function(tbody, table){
                $(tbody).on("click", "button.editar", function(){
                    verificarAcceso("Permiso_Sueldo");
                    var data = table.row( $(this).parents("tr") ).data();
                    localStorage.setItem("sueldo", data.cod_sueldo);
                    location.href = "sueldo-editar.php";
                })
        }
        var btn_ver_datos = function(tbody, table){
                $(tbody).on("click", "button.datos", function(){
                    verificarAcceso("Permiso_Sueldo");
                    var data = table.row( $(this).parents("tr") ).data();
                    localStorage.setItem("sueldo", data.cod_sueldo);
                    location.href = "sueldo-datos.php";
                })
        }
        var btn_eliminar = function(tbody, table){
                $(tbody).on("click", "button.eliminar", function(){
                    verificarAcceso("Permiso_Sueldo");
                    var data = table.row( $(this).parents("tr") ).data();
                    var tableRemove = $(this).parents("tr");
                    var parametros = {
                       "action" : "eliminarSueldo",
                       "cod_sueldo" : data.cod_sueldo
                    };
                    $.ajax({
                      type:'POST',
                      data: parametros,
                      url:'app/controladores/Sueldos.php',
                      success:function(data){
                          console.log(data)
                          datos = JSON.parse(data);
                          if(datos.resp == "true"){
                              Materialize.toast('El Sueldo fue eliminado Satisfactoriamene', 5000)
                              table.row(tableRemove).remove().draw(false);
                          }
                          if(datos.resp == "false"){
                              Materialize.toast('Hubo un fallo al eliminar el Sueldo. Vuelva a Intentarlo', 5000)
                          }
                          if(datos.resp != "true" && datos.resp != "false"){
                              Materialize.toast('Hubo un fallo al eliminar el Sueldo COD:'+datos.resp, 5000)
                          }
                      }
                    })
                })
        }

        function actualizarLista(){
            verificarAcceso("Permiso_Sueldo");
            var parametros = {
                "action" : "listaSueldos"
            };
            var table = $('#table-simple').DataTable({
                "destroy":true,
                "ajax":{
                    "method": "POST",
                    "data":  parametros,
                    "url": "app/controladores/Sueldos.php"
                },
                "columns": [
                    {"data" : "sueldo"},
                    {"defaultContent" : "<button id='datos' class='datos btn waves-effect light-green' type='submit' name='action'><i class='mdi-file-folder-open'></i></button>"},
                    {"defaultContent" : "<button id='editar' class='editar btn waves-effect blue' type='button' name='editar'><i class='mdi-editor-border-color'></i></button>"},
                    {"defaultContent" : "<button id='eliminar' class='eliminar btn waves-effect red' type='submit' name='action'><i class='mdi-action-delete'></i></button>"}
                ],
                "language": {
                    "url": "public/Spanish.lang"
                }
            });
            btn_editar("#table-simple tbody", table);
            btn_ver_datos("#table-simple tbody", table);
            btn_eliminar("#table-simple tbody", table);
        }
    </script>
</body>
</html>