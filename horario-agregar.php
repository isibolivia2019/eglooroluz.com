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
                                    <h5 class="breadcrumbs-title">Registrar Nuevo Horario</h5>
                                    <ol class="breadcrumb">
                                        <li><a href="horario.php">Horarios</a></li>
                                        <li class="active">Registrar Horario</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="container">
                        <div class="section">
                            <p class="caption">Llene el Siguiente Formulario.</p>
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
                                                <button class="btn cyan waves-effect waves-light right" type="submit" name="action">Registrar
                                                    <i class="mdi-content-send right"></i>
                                                </button>
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
        });
    </script>
</body>
</html>