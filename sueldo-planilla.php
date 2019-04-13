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
                                    <h5 class="breadcrumbs-title">Planilla de Sueldo</h5>
                                    <ol class="breadcrumb">
                                        <li><a href="inicio.php">Inicio</a></li>
                                        <li class="active">Sueldos</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="container">
                        <div class="section">
                            <p class="caption">Generador de Planilla de Sueldo</p>
                            <div class="divider"></div>
                            <div class="row">
                                <form class="col s12">
                                <h4 class="header">Seleccione el Mes / Año</h4>
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
                                        <div class="col s12 m12 l4">
                                            <label>Personal</label>
                                            <select class="browser-default" id="cboxPersonal">
                                                <option value="" disabled selected>Seleccione al Personal</option>
                                            </select>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12 submitBtn">
                                                <div class="input-field col s12 right ">
                                                  <a class="btn waves-effect waves-light col s12" onclick="buscarHorarios()">Buscar Horarios</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <br>
                            <div class="divider"></div> 
                            <div id="table-datatables">
                                <h4 class="header">Registros del Personal</h4>
                                <div class="row">
                                    <div class="col s12">
                                        <table id="table-simple" class="responsive-table display" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>Fecha</th>
                                                    <th>Entrada</th>
                                                    <th>Salida</th>
                                                    <th>Obs. Entrada</th>
                                                    <th>Obs. Salida</th>
                                                    <th>Hrs/Trabajo</th>
                                                    <th>Total de Pago</th>
                                                    <th>Eliminar Dia</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>Fecha</th>
                                                    <th>Entrada</th>
                                                    <th>Salida</th>
                                                    <th>Obs. Entrada</th>
                                                    <th>Obs. Salida</th>
                                                    <th>Hrs/Trabajo</th>
                                                    <th>Total de Pago</th>
                                                    <th>Eliminar Dia</th>
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
            verificarAcceso("Permiso_Sueldo");
            var cboxPersonal = document.getElementById("cboxPersonal");
            var cboxAño = document.getElementById("cboxAño");
            var parametros = {
                "action" : "listaUsuarioEstado",
                "estado" : "1"
            };
            $.ajax({
                type:'POST',
                data: parametros,
                url:'app/controladores/Usuarios.php',
                success:function(data){
                    datos = JSON.parse(data);
                    datos = datos.data
                    for(let i=0 ; i<datos.length ; i++){
                        var tag = document.createElement('option');
                        tag.setAttribute('value', datos[i].cod_usuario);
                        tag.innerHTML = datos[i].nombre_usuario + " " + datos[i].appat_usuario + " " + datos[i].apmat_usuario;
                        cboxPersonal.appendChild(tag);
                    }
                }
            })

            var fecha = new Date();
            var año = fecha.getFullYear();
            for(let i=2018 ; i<=año ; i++){
                var tag = document.createElement('option');
                tag.setAttribute('value', i);
                tag.innerHTML = i;
                cboxAño.appendChild(tag);
            }
        });

        function buscarHorarios(){
            verificarAcceso("Permiso_Sueldo");
            var cboxPersonal = document.getElementById("cboxPersonal").value;
            var cboxAño = document.getElementById("cboxAño").value;
            var cboxMes = document.getElementById("cboxMes").value;
            
            var parametros = {
                "action" : "planillaSueldo",
                "usuario" : cboxPersonal,
                "año" : cboxAño,
                "mes" : cboxMes,
                "diasPost" : 0
            };
            /*$.ajax({
                type:'POST',
                data: parametros,
                url:'app/controladores/Sueldos.php',
                success:function(data){
                    console.log("data", data);
                    datos = JSON.parse(data);
                    datos = datos.data
                }
            })*/
            var table = $('#table-simple').DataTable({
                "destroy":true,
                "ajax":{
                    "method": "POST",
                    "data":  parametros,
                    "url": "app/controladores/Sueldos.php"
                },
                "columns": [
                    {"data" : "fecha_reg_hr"},
                    {"data" : "entrada_horario_reg_hr"},
                    {"data" : "salida_horario_reg_hr"},
                    {"data" : "observacion_entrada"},
                    {"data" : "observacion_salida"},
                    {"data" : "diferenciaHora"},
                    {"data" : "totalPago"},
                    {"defaultContent" : "<button id='deshabilitar' class='deshabilitar btn waves-effect red' type='submit' name='action'><i class='mdi-navigation-close'></i></button>"}
                ],
                "language": {
                    "url": "public/Spanish.lang"
                }
            });
            btn_deshabilitar("#table-simple tbody", table);
        }

        var btn_deshabilitar = function(tbody, table){
                $(tbody).on("click", "button.deshabilitar", function(){
                    var data = table.row( $(this).parents("tr") ).data();
                    console.log("data", data);
                    //console.log("miTabla", table.data());
                    var tableRemove = $(this).parents("tr");
                    //table.row(tableRemove).remove().draw(false);

                    var cell = table.cell(0,0).data("editar").draw();
                })
        }
        
    </script>
</body>
</html>