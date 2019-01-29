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
                                    <h5 class="breadcrumbs-title">Lista de Registros</h5>
                                    <ol class="breadcrumb">
                                        <li><a href="inicio.php">Inicio</a></li>
                                        <li class="active">Lista de Registros</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="container">
                        <div class="section">
                            <p class="caption">Lista de Horarios Registrados.</p>
                            <div class="divider"></div>
                            <div class="row">
                                <form class="col s12">
                                <h4 class="header">Seleccione el Mes / Año </h4>
                                    <div class="row">
                                        <div class="col s12 m6 l4">
                                            <label>Mes</label>
                                            <select class="browser-default" id="cboxMes">
                                                <option value="" disabled selected>Seleccione el Mes</option>
                                                <option value="01">Enero</option>
                                                <option value="02">Febrero</option>
                                                <option value="03">Marzo</option>
                                                <option value="04">Abril</option>
                                                <option value="05">Mayo</option>
                                                <option value="06">Junio</option>
                                                <option value="07">Julio</option>
                                                <option value="08">Agosto</option>
                                                <option value="09">Septiembre</option>
                                                <option value="10">Octubre</option>
                                                <option value="11">Noviembre</option>
                                                <option value="12">Diciembre</option>
                                            </select>
                                        </div>
                                        <div class="col s12 m6 l4">
                                            <label>Año</label>
                                            <select class="browser-default" id="cboxAño">
                                                <option value="" disabled selected>Seleccione el Año</option>
                                            </select>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12 submitBtn">
                                                <div class="input-field col s12 right ">
                                                  <a class="btn waves-effect waves-light col s12" onclick="listaRegistroHorarios()">Buscar registros</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <br>
                            <div class="divider"></div> 
                            <div id="table-datatables">
                                <h4 class="header">Registros de Horarios de Entrada / Salida</h4>
                                <div class="row">
                                    <div class="col s12">
                                        <table id="table-simple" class="responsive-table display" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>Fecha</th>
                                                    <th>Entrada</th>
                                                    <th>Salida</th>
                                                    <th>Personal</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>Fecha</th>
                                                    <th>Entrada</th>
                                                    <th>Salida</th>
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
            var cboxAño = document.getElementById("cboxAño");
            var fecha = new Date();
            var año = fecha.getFullYear();
            for(let i=2019 ; i<=año ; i++){
                var tag = document.createElement('option');
                tag.setAttribute('value', i);
                tag.innerHTML = i;
                cboxAño.appendChild(tag);
            }
        });

        function listaRegistroHorarios(){
            verificarAcceso("Permiso_CajaChica");
            var cboxAño = document.getElementById("cboxAño").value;
            var cboxMes = document.getElementById("cboxMes").value;
            
            var parametros = {
                "action" : "listaRegistroHorario",
                "año" : cboxAño,
                "mes" : cboxMes
            };
            var table = $('#table-simple').DataTable({
                "destroy":true,
                "ajax":{
                    "method": "POST",
                    "data":  parametros,
                    "url": "app/controladores/HuellasDactilares.php"
                },
                "columns": [
                    {"data" : "fecha_reg_hr"},
                    {"data" : "entrada_horario_reg_hr"},
                    {"data" : "salida_horario_reg_hr"},
                    {"data" : "personal"},
                ],
                "columnDefs": [
   		        	{ "type": "date-euro", "targets": 0 }
                ],
                "order": [[ 0, "desc" ]],
                "language": {
                    "url": "public/Spanish.lang"
                }
            });
        }
        
    </script>
</body>
</html>