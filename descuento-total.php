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
                                    <h5 class="breadcrumbs-title">Todos los Descuentos de Productos</h5>
                                    <ol class="breadcrumb">
                                        <li><a href="inicio.php">Inicio</a></li>
                                        <li class="active">Total Descuento de Productos</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="container">
                        <div class="section">
                            <p class="caption">Registros de Descuentos de Productos</p>
                            <div class="divider"></div>
                            <div id="table-datatables">
                                <h4 class="header">Registros de Descuentos de Productos</h4>
                                <div class="row">
                                    <div class="col s12">
                                        <table id="table-simple" class="responsive-table display" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>Lugar</th>
                                                    <th>Producto</th>
                                                    <th>Descuento Web</th>
                                                    <th>Descuento Interno</th>
                                                    <th>Fecha Inicio</th>
                                                    <th>Fecha Final</th>
                                                    <th>Observacion</th>
                                                    <th>Estado</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>Lugar</th>
                                                    <th>Producto</th>
                                                    <th>Descuento Web</th>
                                                    <th>Descuento Interno</th>
                                                    <th>Fecha Inicio</th>
                                                    <th>Fecha Final</th>
                                                    <th>Observacion</th>
                                                    <th>Estado</th>
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
            verificarAcceso("Permiso_Descuento");
            var parametros = {
                "action" : "listaDescuentosTodo"
            };
            var table = $('#table-simple').DataTable({
                "destroy":true,
                "ajax":{
                    "method": "POST",
                    "data":  parametros,
                    "url": "app/controladores/Descuentos.php"
                },
                "columns": [
                    {"data" : "nombre_almacenamiento"},
                    {"data" : "cod_item_producto"},
                    {"data" : "porcenta_descuento_producto"},
                    {"data" : "descuento_interno"},
                    {"data" : "fecha_inicio_descuento_producto"},
                    {"data" : "fecha_final_descuento_producto"},
                    {"data" : "observacion_descuento_producto"},
                    {"data" : "estado_descuento_producto"}
                ],
                "language": {
                    "url": "public/Spanish.lang"
                }
            });
            btn_eliminar("#table-simple tbody", table);
        });

        

        var btn_eliminar = function(tbody, table){
                $(tbody).on("click", "button.eliminar", function(){
                    verificarAcceso("Permiso_Descuento");
                    var data = table.row( $(this).parents("tr") ).data();
                    var tableRemove = $(this).parents("tr");
                    var parametros = {
                       "action" : "eliminarDescuento",
                       "cod_descuento_producto" : data.cod_descuento_producto
                    };
                    $.ajax({
                      type:'POST',
                      data: parametros,
                      url:'app/controladores/Descuentos.php',
                      success:function(data){
                          console.log(data)
                          datos = JSON.parse(data);
                          if(datos.resp == "true"){
                              Materialize.toast('El Descuento fue cancelado correctamente', 5000)
                              table.row(tableRemove).remove().draw(false);
                          }
                          if(datos.resp == "false"){
                              Materialize.toast('Hubo un fallo al cancelar el Descuento. Vuelva a Intentarlo', 5000)
                          }
                          if(datos.resp != "true" && datos.resp != "false"){
                              Materialize.toast('Hubo un fallo al cancelar el Descuento COD:'+datos.resp, 5000)
                          }
                      }
                    })
                })
        }

    </script>
</body>
</html>