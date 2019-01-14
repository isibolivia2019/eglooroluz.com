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
                                    <h5 class="breadcrumbs-title">Editar datos de Horario</h5>
                                    <ol class="breadcrumb">
                                        <li><a href="horario.php">Horarios</a></li>
                                        <li class="active">Editar Horario</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="container">
                        <div class="section">
                            <p class="caption">Modifique el Siguiente Formulario.</p>
                            <div class="divider"></div>
                            <div class="row">
                                <form class="col s12">
                                    <div class="row">
                                        <div class="input-field col s5 m3 l2">
                                            <label for="entrada">Hora de Entrada</label>
                                        </div>
                                        <div class="input-field col s7 m9 l10">
                                            <input id="entrada" type="time">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s5 m3 l2">
                                            <label for="salida">Hora de Salida</label>
                                        </div>
                                        <div class="input-field col s7 m9 l10">
                                            <input id="salida" type="time">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s5 m3 l2">
                                            <label for="tolerancia">Tolerancia</label>
                                        </div>
                                        <div class="input-field col s7 m9 l10">
                                            <input id="tolerancia" type="time">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <input type="checkbox" class="filled-in" id="cboxLunes" checked="checked" />
                                            <label for="cboxLunes">Lunes</label>
                                            
                                            <input type="checkbox" class="filled-in" id="cboxMartes" checked="checked" />
                                            <label for="cboxMartes">Martes</label>
                                            
                                            <input type="checkbox" class="filled-in" id="cboxMiercoles" checked="checked" />
                                            <label for="cboxMiercoles">Miercoles</label>
                                            
                                            <input type="checkbox" class="filled-in" id="cboxJueves" checked="checked" />
                                            <label for="cboxJueves">Jueves</label>
                                            
                                            <input type="checkbox" class="filled-in" id="cboxViernes" checked="checked" />
                                            <label for="cboxViernes">Viernes</label>
                                            
                                            <input type="checkbox" class="filled-in" id="cboxSabado" checked="checked" />
                                            <label for="cboxSabado">Sabado</label>
                                            
                                            <input type="checkbox" class="filled-in" id="cboxDomingo" checked="checked" />
                                            <label for="cboxDomingo">Domingo</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <div class="input-field col s6 right">
                                                  <a class="btn waves-effect waves-light col s12" onclick="actualizarHorario()">Actualizar</a>
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
            verificarAcceso("Permiso_Horario");
            var parametros = {
                "action" : "horarioEspecifico",
                "cod_horario" : localStorage.getItem("horario")
            };
            $.ajax({
              type:'POST',
              data: parametros,
              url:'app/controladores/Horarios.php',
              success:function(data){
                datos = JSON.parse(data);
                document.getElementById('entrada').value = datos[0].entrada_horario;
                document.getElementById('salida').value = datos[0].salida_horario;
                document.getElementById('tolerancia').value = datos[0].tiempo_espera;
                document.getElementById('cboxLunes').checked = Boolean(Number(datos[0].dia_lunes));
                document.getElementById('cboxMartes').checked = Boolean(Number(datos[0].dia_martes));
                document.getElementById('cboxMiercoles').checked = Boolean(Number(datos[0].dia_miercoles));
                document.getElementById('cboxJueves').checked = Boolean(Number(datos[0].dia_jueves));
                document.getElementById('cboxViernes').checked = Boolean(Number(datos[0].dia_viernes));
                document.getElementById('cboxSabado').checked = Boolean(Number(datos[0].dia_sabado));
                document.getElementById('cboxDomingo').checked = Boolean(Number(datos[0].dia_domingo));
              }
            })
        });

        function actualizarHorario(){
          var entrada = document.getElementById('entrada').value;
          var salida = document.getElementById('salida').value;
          var tolerancia = document.getElementById('tolerancia').value;
          var cboxLunes = Number(document.getElementById("cboxLunes").checked);
          var cboxMartes = Number(document.getElementById("cboxMartes").checked);
          var cboxMiercoles = Number(document.getElementById("cboxMiercoles").checked);
          var cboxJueves = Number(document.getElementById("cboxJueves").checked);
          var cboxViernes = Number(document.getElementById("cboxViernes").checked);
          var cboxSabado = Number(document.getElementById("cboxSabado").checked);
          var cboxDomingo = Number(document.getElementById("cboxDomingo").checked);

          var parametros = {
             "action" : "actualizarHorario",
             "codigo" : localStorage.getItem("horario"),
             "entrada" : entrada,
             "salida" : salida,
             "tolerancia" : tolerancia,
             "cboxLunes" : cboxLunes,
             "cboxMartes" : cboxMartes,
             "cboxMiercoles" : cboxMiercoles,
             "cboxJueves" : cboxJueves,
             "cboxViernes" : cboxViernes,
             "cboxSabado" : cboxSabado,
             "cboxDomingo" : cboxDomingo,
             
          };
          $.ajax({
            type:'POST',
            data: parametros,
            url:'app/controladores/Horarios.php',
            success:function(data){
                datos = JSON.parse(data);
                if(datos.resp == "true"){
                    Materialize.toast('Horario Actualizado con exito', 5000)
                }
                if(datos.resp == "false"){
                    Materialize.toast('Hubo un fallo al actualizar el Horario. Vuelva a Intentarlo', 5000)
                }
                if(datos.resp != "true" && datos.resp != "false"){
                    Materialize.toast('Hubo un fallo al actualizar el Horario COD:'+datos.resp, 5000)
                }
            }
          })
        }
    </script>
</body>
</html>