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
                                    <h5 class="breadcrumbs-title">Lista de Descuentos de Productos</h5>
                                    <ol class="breadcrumb">
                                        <li><a href="inicio.php">Inicio</a></li>
                                        <li class="active">Descuento de Productoss</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="container">
                        <div class="section">
                            <p class="caption">Descuentos de Productos registrados.</p>
                            <div class="divider"></div>
                            <div id="table-datatables">
                                <h4 class="header">Descuentos de Productos</h4>
                                <div class="row">
                                    <div class="col s12">
                                        <table id="table-simple" class="responsive-table display" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>Lugar</th>
                                                    <th>Producto</th>
                                                    <th>Lugar</th>
                                                    <th>Producto</th>
                                                    <th>Descuento Web</th>
                                                    <th>Descuento Interno</th>
                                                    <th>Fecha Inicio</th>
                                                    <th>Observacion</th>
                                                    <th>Eliminar</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>Lugar</th>
                                                    <th>Producto</th>
                                                    <th>Lugar</th>
                                                    <th>Producto</th>
                                                    <th>Descuento Web</th>
                                                    <th>Descuento Interno</th>
                                                    <th>Fecha Inicio</th>
                                                    <th>Observacion</th>
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
            verificarAcceso("Permiso_Descuento");
            var parametros = {
                "action" : "listaDescuentos"
            };
            var table = $('#table-simple').DataTable({
                "destroy":true,
                "ajax":{
                    "method": "POST",
                    "data":  parametros,
                    "url": "app/controladores/Descuentos.php"
                },
                "columns": [
                    {"data" : "cod_inventario"},
                    {"data" : "porcenta_descuento_producto"},
                    {"data" : "cod_inventario"},
                    {"data" : "porcenta_descuento_producto"},
                    {"data" : "descuento_interno"},
                    {"data" : "observacion_descuento_producto"},
                    {"data" : "porcenta_descuento_producto"},
                    {"data" : "descuento_interno"},
                    {"data" : "observacion_descuento_producto"},
                ],
                "language": {
                    "url": "public/Spanish.lang"
                }
            });
        });

    </script>
</body>
</html>