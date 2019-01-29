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
                                    <h5 class="breadcrumbs-title">Registro de Horarios</h5>
                                    <ol class="breadcrumb">
                                        <li><a href="inicio.php">Inicio</a></li>
                                        <li class="active">Mis Horarios</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="container">
                        <div class="section">
                            <p class="caption">Registro de Horarios.</p>
                            <div class="divider"></div>
                            <br>
                            <div class="divider"></div> 
                            <div id="table-datatables">
                                <h4 class="header">Horarios Entrada / Salida</h4>
                                <div class="row">
                                    <div class="col s12">
                                        <table id="table-simple" class="responsive-table display" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>Fecha</th>
                                                    <th>Hora</th>
                                                    <th>Personal</th>
                                                    <th>Observacion Entrada</th>
                                                    <th>Observacion salida</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>Fecha</th>
                                                    <th>Hora</th>
                                                    <th>Personal</th>
                                                    <th>Observacion Entrada</th>
                                                    <th>Observacion salida</th>
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
                "action" : "listaRegistroHorarioEspecifico"
            };
            var table = $('#table-simple').DataTable({
                "destroy":true,
                "ajax":{
                    "method": "POST",
                    "data":  parametros,
                    "url": "app/controladores/HuellasDactilares.php"
                },
                "columns": [
                    {"data" : "fecha"},
                    {"data" : "monto_gasto"},
                    {"data" : "detalle"},
                    {"data" : "comprobante"},
                    {"data" : "personal"}
                ],
                "columnDefs": [
   		        	{ "type": "date-euro", "targets": 0 }
                ],
                "order": [[ 0, "desc" ]],
                "language": {
                    "url": "public/Spanish.lang"
                }
            });
        }); 
    </script>
</body>
</html>