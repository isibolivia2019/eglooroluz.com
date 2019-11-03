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
                                    <h5 class="breadcrumbs-title">Reportes de Horario</h5>
                                    <ol class="breadcrumb">
                                        <li><a href="inicio.php">Inicio</a></li>
                                        <li class="active">Horario</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="container">
                        <div class="section">
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
                                                <option value="" disabled selected>Seleccione el Personal</option>
                                            </select>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12 submitBtn">
                                                <div class="input-field col s12 right ">
                                                  <a class="btn waves-effect waves-light col s12" onclick="generarReporte()">Generar Registro de Horario</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
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
            verificarAcceso("Permiso_Reporte");
            var cboxUsuario = document.getElementById("cboxUsuario");
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
                    datos = datos.data;
                    for(let i=0 ; i<datos.length ; i++){
                        var tag = document.createElement('option');
                        tag.setAttribute('value', datos[i].cod_usuario);
                        tag.innerHTML = datos[i].nombre_usuario + " " + datos[i].appat_usuario + " " + datos[i].apmat_usuario;
                        cboxUsuario.appendChild(tag);
                    }
                }
            })
        });

        function generarReporte(){
            verificarAcceso("Permiso_Reporte");
            var cboxUsuario = document.getElementById("cboxUsuario").value;
            var cboxAño = document.getElementById("cboxAño").value;
            var cboxMes = document.getElementById("cboxMes").value;
            window.open("reportes/reporte-caja-chica.php?suc="+cboxSucursal+"&a="+cboxAño+"&m="+cboxMes,'New Window'); 
        }
        
    </script>
</body>
</html>