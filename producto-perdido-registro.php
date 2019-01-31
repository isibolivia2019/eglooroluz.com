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
                                    <h5 class="breadcrumbs-title">Registro Productos Perdidos</h5>
                                    <ol class="breadcrumb">
                                        <li><a href="inicio.php">Inicio</a></li>
                                        <li class="active">Registro de Productos Perdidos</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="container">
                        <div class="section">
                            <p class="caption">Registros</p>
                            <div class="divider"></div>
                            <br>
                            <div class="divider"></div> 
                            <div id="table-datatables">
                                <h4 class="header">Productos Perdidos</h4>
                                <div class="row">
                                    <div class="col s12">
                                        <table id="table-simple" class="responsive-table display" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>Fecha / Hora</th>
                                                    <th>Almacenando en</th>
                                                    <th>Imagen</th>
                                                    <th>Codigo</th>
                                                    <th>Nombre</th>
                                                    <th>Cantidad</th>
                                                    <th>Costo de Adquisicion</th>
                                                    <th>Precio de Venta</th>
                                                    <th>Observacion</th>
                                                    <th>Estado</th>
                                                    <th>Personal</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>Fecha / Hora</th>
                                                    <th>Almacenando en</th>
                                                    <th>Imagen</th>
                                                    <th>Codigo</th>
                                                    <th>Nombre</th>
                                                    <th>Cantidad</th>
                                                    <th>Costo de Adquisicion</th>
                                                    <th>Precio de Venta</th>
                                                    <th>Observacion</th>
                                                    <th>Estado</th>
                                                    <th>Personal</th>
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
            verificarAcceso("Permiso_ProductoPerdido");
            var parametros = {
                "action" : "listaRegistrosProductosPerdidos"
            };
            var table = $('#table-simple').DataTable({
                "destroy":true,
                "ajax":{
                    "method": "POST",
                    "data":  parametros,
                    "url": "app/controladores/ProductosPerdidos.php"
                },
                "columns": [
                    {"data" : "fecha_producto_perdido"},
                    {"data" : "cod_almacenamiento"},
                    {"render": function (data, type, JsonResultRow, meta) {
                            return "<img width='150'src=public/imagenes/productos/"+JsonResultRow.imagen_producto+">";
                        }
                    },
                    {"data" : "cod_item_producto"},
                    {"data" : "nombre_producto"},
                    {"data" : "cant_producto"},
                    {"data" : "compra_unit_producto"},
                    {"data" : "precio_sugerido_venta"},
                    {"data" : "observacion_producto_perdido"},
                    {"data" : "estado"},
                    {"data" : "personal"}
                ],
                "language": {
                    "url": "public/Spanish.lang"
                }
            });
        });
    </script>
</body>
</html>