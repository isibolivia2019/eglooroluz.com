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
                                    <h5 class="breadcrumbs-title">Editar datos de Usuario</h5>
                                    <ol class="breadcrumb">
                                        <li><a href="usuario.php">Usuarios</a></li>
                                        <li class="active">Editar Usuario</li>
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
                                        <div class="input-field col s12">
                                            <input id="nombre" type="text">
                                            <label for="nombre">Nombre (s)</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s6">
                                            <input id="appat" type="text">
                                            <label for="appat">Primer Apellido</label>
                                        </div>

                                        <div class="input-field col s6">
                                            <input id="apmat" type="text">
                                            <label for="apmat">Segundo Apellido</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s6">
                                            <input id="ci" type="number">
                                            <label for="ci">Cedula de Identidad</label>
                                        </div>

                                        <div class="input-field col s6">
                                            <select id="ci_exp">
                                                <option value="" disabled selected>Seleccione la Expedicion</option>
                                                <option value="1">Beni</option>
                                                <option value="2">Cochabamba</option>
                                                <option value="3">Chuquisaca</option>
                                                <option value="1">La Paz</option>
                                                <option value="2">Oruro</option>
                                                <option value="3">Pando</option>
                                                <option value="1">Potosi</option>
                                                <option value="2">Santa Cruz</option>
                                                <option value="3">Tarija</option>
                                            </select>
                                            <label>Expedicion</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s6">
                                            <input id="email" type="email">
                                            <label for="email">Correo Electronico</label>
                                        </div>
                                        <div class="input-field col s6">
                                            <select id="genero">
                                                <option value="" disabled selected>Seleccione el Genero</option>
                                                <option value="Masculino">Masculino</option>
                                                <option value="Femenino">Femenino</option>
                                            </select>
                                            <label>Genero</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s6">
                                            <input id="telefono" type="number">
                                            <label for="telefono">Telefono / Celular</label>
                                        </div>
                                        <div class="input-field col s6">
                                            <input id="fec_nac" type="date" class="datepicker">
                                            <label for="dob">Fecha de Nacimiento</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <input id="direccion" type="text">
                                            <label for="direccion">Direccion de Domicilio</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <input id="pass" type="password">
                                            <label for="pass">Contraseña</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <input id="nombre_ref" type="text">
                                            <label for="nombre_ref">Nombre (s) y Apellidos de referencia</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s6">
                                            <input id="telefono_ref" type="email">
                                            <label for="telefono_ref">Celular / Tel Ref</label>
                                        </div>
                                        <div class="input-field col s6">
                                            <select id="tipo_ref">
                                                <option value="" disabled selected>Seleccione la referencia</option>
                                                <option value="Familiar">Familiar</option>
                                                <option value="Amistad">Amistad</option>
                                            </select>
                                            <label>Referencia</label>
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
            verificarAcceso("Permiso_Usuario");
        });
    </script>
</body>
</html>