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
                                    <h5 class="breadcrumbs-title">Lista de Sucursales</h5>
                                    <ol class="breadcrumb">
                                        <li><a href="inicio.php">Inicio</a></li>
                                        <li class="active">Sucursales</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="container">
                        <div class="section">
                            <p class="caption">Sucursales registrados en el Sistema.</p>
                            <div class="divider"></div>
                            <div id="table-datatables">
                                <h4 class="header">Sucursales</h4>
                                <div class="row">
                                    <div class="col s12">
                                        <table id="table-simple" class="responsive-table display" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>Sucursal</th>
                                                    <th>Direccion</th>
                                                    <th>Inventario</th>
                                                    <th>Editar</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>Sucursal</th>
                                                    <th>Direccion</th>
                                                    <th>Inventario</th>
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
            verificarAcceso("Permiso_Sucursal");
            var parametros = {
                "action" : "listaSucursales"
            };
            var table = $('#table-simple').DataTable({
                "destroy":true,
                "ajax":{
                    "method": "POST",
                    "data":  parametros,
                    "url": "app/controladores/Sucursales.php"
                },
                "columns": [
                    {"data" : "nombre_sucursal"},
                    {"data" : "direccion_sucursal"},
                    {"defaultContent" : "<button id='inventario' class='inventario btn waves-effect green' type='submit' name='action'><i class='mdi-action-store'></i></button>"},
                    {"defaultContent" : "<button id='editar' class='editar btn waves-effect blue' type='button' name='editar'><i class='mdi-editor-border-color'></i></button>"},
                ],
                "language": {
                    "url": "public/Spanish.lang"
                }
            });
            btn_editar("#table-simple tbody", table);
            btn_inventario("#table-simple tbody", table);
        });

        

        var btn_editar = function(tbody, table){
                $(tbody).on("click", "button.editar", function(){
                    var data = table.row( $(this).parents("tr") ).data();
                    localStorage.setItem("sucursal", data.cod_sucursal);
                    location.href = "sucursal-editar.php";
                })
        }
        var btn_inventario = function(tbody, table){
                $(tbody).on("click", "button.inventario", function(){
                    var data = table.row( $(this).parents("tr") ).data();
                    localStorage.setItem("sucursal", data.cod_sucursal);
                    location.href = "sucursal-inventario.php";
                })
        }
    </script>
</body>
</html>