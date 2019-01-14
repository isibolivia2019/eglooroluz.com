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
                                    <h5 class="breadcrumbs-title">Lista de Compras de Productos</h5>
                                    <ol class="breadcrumb">
                                        <li><a href="producto.php">Productos</a></li>
                                        <li class="active">Compras</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="container">
                        <div class="section">
                            <p class="caption">Registro de compras de productos</p>
                            <div class="divider"></div>
                            <div id="table-datatables">
                                <h4 class="header">Compra de Productos</h4>
                                <div class="row">
                                    <div class="col s12">
                                        <table id="table-simple" class="responsive-table display" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>Fecha/Hora</th>
                                                    <th>Imagen</th>
                                                    <th>Codigo</th>
                                                    <th>Nombre</th>
                                                    <th>Cantidad</th>
                                                    <th>Costo</th>
                                                    <th>Observacion</th>
                                                    <th>Almacenado en:</th>
                                                    <th>Personal</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>Fecha/Hora</th>
                                                    <th>Imagen</th>
                                                    <th>Codigo</th>
                                                    <th>Nombre</th>
                                                    <th>Cantidad</th>
                                                    <th>Costo</th>
                                                    <th>Observacion</th>
                                                    <th>Almacenado en:</th>
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
            verificarAcceso("Permiso_Producto");
            var parametros = {
                "action" : "listaProductos"
            };
            var table = $('#table-simple').DataTable({
                "destroy":true,
                "ajax":{
                    "method": "POST",
                    "data":  parametros,
                    "url": "app/controladores/Productos.php"
                },
                "columns": [
                    {"data" : "cod_item_producto"},
                    {"data" : "nombre_producto"},
                    {"data" : "descripcion_producto"},
                    {"data" : "color_producto"},
                    {"data" : "nombre_producto"},
                    {"data" : "descripcion_producto"},
                    {"data" : "color_producto"},
                    {"data" : "descripcion_producto"},
                    {"data" : "color_producto"},
                ],
                "language": {
                    "url": "public/Spanish.lang"
                }
            });
        });
    </script>
</body>
</html>