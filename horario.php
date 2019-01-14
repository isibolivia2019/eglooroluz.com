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
                                    <h5 class="breadcrumbs-title">Lista de Horarios</h5>
                                    <ol class="breadcrumb">
                                        <li><a href="horario.php">Horario</a></li>
                                        <li class="active">Lista de Horarios</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="container">
                        <div class="section">
                            <p class="caption">Horarios habilitados para el uso de Personal.</p>
                            <div class="divider"></div>
                            <div id="table-datatables">
                                <h4 class="header">Horarios</h4>
                                <div class="row">
                                    <div class="col s12">
                                        <table id="table-simple" class="responsive-table display" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>Entrada</th>
                                                    <th>Salida</th>
                                                    <th>Tolerancia</th>
                                                    <th>L</th>
                                                    <th>M</th>
                                                    <th>M</th>
                                                    <th>J</th>
                                                    <th>V</th>
                                                    <th>S</th>
                                                    <th>D</th>
                                                    <th>Ver Datos</th>
                                                    <th>Editar</th>
                                                    <th>Eliminar</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>Entrada</th>
                                                    <th>Salida</th>
                                                    <th>Tolerancia</th>
                                                    <th>L</th>
                                                    <th>M</th>
                                                    <th>M</th>
                                                    <th>J</th>
                                                    <th>V</th>
                                                    <th>S</th>
                                                    <th>D</th>
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
                verificarAcceso("Permiso_Horario");
                $(tbody).on("click", "button.editar", function(){
                    var data = table.row( $(this).parents("tr") ).data();
                    localStorage.setItem("horario", data.cod_horario);
                    location.href = "horario-editar.php";
                })
        }
        var btn_ver_datos = function(tbody, table){
                verificarAcceso("Permiso_Horario");
                $(tbody).on("click", "button.datos", function(){
                    var data = table.row( $(this).parents("tr") ).data();
                    localStorage.setItem("horario", data.cod_horario);
                    location.href = "horario-datos.php";
                })
        }
        var btn_eliminar = function(tbody, table){
                verificarAcceso("Permiso_Horario");
                $(tbody).on("click", "button.eliminar", function(){
                    var data = table.row( $(this).parents("tr") ).data();
                    var tableRemove = $(this).parents("tr");
                    var parametros = {
                       "action" : "eliminarHorario",
                       "cod_horario" : data.cod_horario
                    };
                    $.ajax({
                      type:'POST',
                      data: parametros,
                      url:'app/controladores/Horarios.php',
                      success:function(data){
                          console.log(data)
                          datos = JSON.parse(data);
                          if(datos.resp == "true"){
                              Materialize.toast('El Horario fue eliminado Satisfactoriamene', 5000)
                              table.row(tableRemove).remove().draw(false);
                          }
                          if(datos.resp == "false"){
                              Materialize.toast('Hubo un fallo al eliminar el Horario. Vuelva a Intentarlo', 5000)
                          }
                          if(datos.resp != "true" && datos.resp != "false"){
                              Materialize.toast('Hubo un fallo al eliminar el Horario COD:'+datos.resp, 5000)
                          }
                      }
                    })
                })
        }

        function actualizarLista(){
            verificarAcceso("Permiso_Horario");
            var parametros = {
                "action" : "listaHorarios"
            };
            var table = $('#table-simple').DataTable({
                "destroy":true,
                "ajax":{
                    "method": "POST",
                    "data":  parametros,
                    "url": "app/controladores/Horarios.php"
                },
                "columns": [
                    {"data" : "entrada_horario"},
                    {"data" : "salida_horario"},
                    {"data" : "tiempo_espera"},
                    {"data" : "dia_lunes"},
                    {"data" : "dia_martes"},
                    {"data" : "dia_miercoles"},
                    {"data" : "dia_jueves"},
                    {"data" : "dia_viernes"},
                    {"data" : "dia_sabado"},
                    {"data" : "dia_domingo"},
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