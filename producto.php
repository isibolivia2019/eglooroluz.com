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
                                    <h5 class="breadcrumbs-title">Lista de Productos</h5>
                                    <ol class="breadcrumb">
                                        <li><a href="producto.php">Inicio</a></li>
                                        <li class="active">Productos</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="container">
                        <div class="section">
                            <p class="caption">Productos registrados en el Sistema.</p>
                            <div class="divider"></div>
                            <div id="table-datatables">
                                <h4 class="header">Productos</h4>
                                <div class="row">
                                    <div class="col s12">
                                        <table id="table-simple" class="responsive-table display" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>Codigo</th>
                                                    <th>Nombre</th>
                                                    <th>Descripcion</th>
                                                    <th>Color</th>
                                                    <th>Compra</th>
                                                    <th>Editar</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>Codigo</th>
                                                    <th>Nombre</th>
                                                    <th>Descripcion</th>
                                                    <th>Color</th>
                                                    <th>Compra</th>
                                                    <th>Editar</th>
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
                    {"defaultContent" : "<button id='datos' class='datos btn waves-effect light-green' type='submit' name='action'><i class='mdi-content-send'></i></button>"},
                    {"defaultContent" : "<button id='editar' class='editar btn waves-effect blue' type='button' name='editar'><i class='mdi-content-send'></i></button>"},
                ],
                "language": {
                    "url": "public/Spanish.lang"
                }
            });
            btn_editar("#table-simple tbody", table);
            btn_ver_datos("#table-simple tbody", table);
        });

        

        var btn_editar = function(tbody, table){
                $(tbody).on("click", "button.editar", function(){
                    var data = table.row( $(this).parents("tr") ).data();
                    localStorage.setItem("producto", data.cod_producto);
                    location.href = "producto-editar.php";
                })
        }
        var btn_ver_datos = function(tbody, table){
                $(tbody).on("click", "button.datos", function(){
                    var data = table.row( $(this).parents("tr") ).data();
                    localStorage.setItem("producto", data.cod_producto);
                    location.href = "producto-compra.php";
                })
        }
    </script>
</body>
</html>