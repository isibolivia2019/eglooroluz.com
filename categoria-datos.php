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
                                    <h5 class="breadcrumbs-title">Lista de Productos en Categoria</h5>
                                    <ol class="breadcrumb">
                                        <li><a href="categoria.php">Categorias</a></li>
                                        <li class="active">Productos en Categoria</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="container">
                        <div class="section">
                            <p class="caption">Categorias registrados para publicar en la pagina principal.</p>
                            <div class="divider"></div>
                            <div id="table-datatables">
                                <h4 class="header">Categorias</h4>
                                <div class="row">
                                    <div class="col s12">
                                        <table id="table-simple" class="responsive-table display" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>categoria</th>
                                                    <th>Eliminar</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th></th>
                                                    <th>categoria</th>
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
            verificarAcceso("Permiso_Categoria");
            var parametros = {
                "action" : "listaCategorias"
            };
            var table = $('#table-simple').DataTable({
                "destroy":true,
                "ajax":{
                    "method": "POST",
                    "data":  parametros,
                    "url": "app/controladores/Categorias.php"
                },
                "columns": [
                    {"data" : "nombre_categoria"},
                    {"defaultContent" : "<button id='deshabilitar' class='deshabilitar btn waves-effect red' type='submit' name='action'><i class='mdi-content-send'></i></button>"}
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
                    localStorage.setItem("cargo", data.cod_cargo);
                    location.href = "categoria-editar.php";
                })
        }
    </script>
</body>
</html>