<?php ini_set('display_errors', '1');?>
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
                                    <h5 class="breadcrumbs-title">Lista de Usuarios</h5>
                                    <ol class="breadcrumb">
                                        <li><a href="index.html">Usuarios</a></li>
                                        <li class="active">Lista</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="container">
                        <div class="section">
                            <p class="caption">Usuarios habilitados para el uso del sistema.</p>
                            <div class="divider"></div>
                            <div id="table-datatables">
                                <h4 class="header">Usuarios</h4>
                                <div class="row">
                                    <div class="col s12">
                                        <table id="table-simple" class="responsive-table display" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>Nombre(s)</th>
                                                    <th>Ap. Paterno</th>
                                                    <th>Ap. Materno</th>
                                                    <th>Telefono</th>
                                                    <th>Ver Datos</th>
                                                    <th>Editar</th>
                                                    <th>Estado</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>Nombre(s)</th>
                                                    <th>Ap. Paterno</th>
                                                    <th>Ap. Materno</th>
                                                    <th>Telefono</th>
                                                    <th>Ver Datos</th>
                                                    <th>Editar</th>
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
            var parametros = {
                "action" : "listaUsuario"
            };
            var table = $('#table-simple').DataTable({
                "destroy":true,
                "ajax":{
                    "method": "POST",
                    "data":  parametros,
                    "url": "app/controladores/Usuarios.php"
                },
                "columns": [
                    {"data" : "nombre_usuario"},
                    {"data" : "appat_usuario"},
                    {"data" : "apmat_usuario"},
                    {"data" : "telefono_usuario"},
                    {"defaultContent" : "<button class='btn waves-effect light-green' type='submit' name='action'><i class='mdi-content-send'></i></button>"},
                    {"defaultContent" : "<button id='editar'class='editar btn waves-effect blue' type='button' name='editar'><i class='mdi-content-send'></i></button>"},
                    {"defaultContent" : "<button class='btn waves-effect red' type='submit' name='action'><i class='mdi-content-send'></i></button>"}
                ],
                "language": {
                    "url": "public/Spanish.lang"
                }
            });
            btn_editar("#table-simple tbody", table);
        });

        var btn_editar = function(tbody, table){
                $(tbody).on("click", "button.editar", function(){
                    var data = table.row( $(this).parents("tr") ).data();
                    console.log(data)
                })

        }
    </script>
</body>
</html>