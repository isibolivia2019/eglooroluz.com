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
                                    <h5 class="breadcrumbs-title">Lista de Correos Electronicos</h5>
                                    <ol class="breadcrumb">
                                        <li><a href="inicio.php">Inicio</a></li>
                                        <li class="active">CLientes</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="container">
                        <div class="section">
                            <p class="caption">Lista de Correos Electronicos</p>
                            <div class="divider"></div>
                            <div id="table-datatables">
                                <h4 class="header">Correos Electronicos</h4>
                                <div class="row">
                                    <div class="col s12">
                                        <table id="table-simple" class="responsive-table display" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>Correo Electronico</th>
                                                    <th>Fecha</th>
                                                    <th>Hora</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>Correo Electronico</th>
                                                    <th>Fecha</th>
                                                    <th>Hora</th>
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
var table
        $(document).ready(function() {
            verificarAcceso("Permiso_Cliente");
            var parametros = {
                "action" : "listaEmailCliente"
            };
            table = $('#table-simple').DataTable({
                "destroy":true,
                "ajax":{
                    "method": "POST",
                    "data":  parametros,
                    "url": "app/controladores/Configuraciones.php"
                },
                "columns": [
                    {"data" : "email"},
                    {"data" : "fecha"},
                    {"data" : "hora"}
                ],
                "language": {
                    "url": "public/Spanish.lang"
                }
            });
            btn_editar("#table-simple tbody", table);
            btn_ver_datos("#table-simple tbody", table);
            btn_eliminar("#table-simple tbody", table);
        });

        

        var btn_editar = function(tbody, table){
                $(tbody).on("click", "button.editar", function(){
                    var data = table.row( $(this).parents("tr") ).data();
                    localStorage.setItem("cargo", data.cod_cargo);
                    location.href = "cargo-editar.php";
                })
        }
        var btn_ver_datos = function(tbody, table){
                $(tbody).on("click", "button.datos", function(){
                    var data = table.row( $(this).parents("tr") ).data();
                    localStorage.setItem("cargo", data.cod_cargo);
                    location.href = "cargo-datos.php";
                })
        }
        var btn_eliminar = function(tbody, table){
                $(tbody).on("click", "button.eliminar", function(){
                    verificarAcceso("Permiso_Cargo");
                    var data = table.row( $(this).parents("tr") ).data();
                    var tableRemove = $(this).parents("tr");
                    var parametros = {
                       "action" : "eliminarCargo",
                       "cod_cargo" : data.cod_cargo
                    };
                    $.ajax({
                      type:'POST',
                      data: parametros,
                      url:'app/controladores/Cargos.php',
                      success:function(data){
                          console.log(data)
                          datos = JSON.parse(data);
                          if(datos.resp == "true"){
                              Materialize.toast('El Cargo fue eliminado Satisfactoriamene', 5000)
                              table.row(tableRemove).remove().draw(false);
                          }
                          if(datos.resp == "false"){
                              Materialize.toast('Hubo un fallo al eliminar el Cargo. Vuelva a Intentarlo', 5000)
                          }
                          if(datos.resp != "true" && datos.resp != "false"){
                              Materialize.toast('Hubo un fallo al eliminar el Cargo COD:'+datos.resp, 5000)
                          }
                      }
                    })
                })
        }
    </script>
</body>
</html>