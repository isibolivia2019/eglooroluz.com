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
                                    <h5 class="breadcrumbs-title">Registrar Nuevo Producto</h5>
                                    <ol class="breadcrumb">
                                        <li><a href="producto.php">Productos</a></li>
                                        <li class="active">Registrar Producto</li>
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
                                <form enctype="multipart/form-data" id="formulario" method="post">
                                    <div class="row">
                                        <div class="form-group input-field col s12">
                                            <input id="action" name="action" type="text" value="agregarProducto" style="display:none">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group input-field col s12">
                                            <input id="codigo" name="codigo" type="text" required>
                                            <label for="codigo">Codigo del Producto</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group input-field col s12">
                                            <input id="nombre" name="nombre" type="text" required>
                                            <label for="nombre">Nombre del Producto</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group input-field col s12">
                                            <input id="descripcion" name="descripcion" type="text">
                                            <label for="descripcion">Descripcion del Producto</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group input-field col s12">
                                            <input id="color" name="color" type="text">
                                            <label for="color">Color del Producto</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group file-field input-field col s12">
                                            <input class="file-path validate" type="text" id="txtImagen" name="txtImagen" disabled/>
                                            <div class="btn">
                                                <span>Imagen</span>
                                                <input type="file" name="imagen" id="imagen"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <button class="btn cyan waves-effect waves-light right submitBtn" type="submit" name="submit">Registrar
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
        $(document).ready(function(e) {
            verificarAcceso("Permiso_Producto");
            
            $("#formulario").on('submit', function(e){
                
                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: 'app/controladores/Productos.php',
                    data: new FormData(this),
                    contentType: false,
                    processData: false,
                    beforeSend: function(){
                        $('.submitBtn').attr("disabled","disabled");
                        $('#formulario').css("opacity",".5");
                        Materialize.toast('Aguarde porfavor mientras se procesede al registro', 5000)
                    },
                    success: function(data){
                        datos = JSON.parse(data);
                        if(datos.resp == "true"){
                            Materialize.toast('Producto Registrado con exito', 5000)
                            document.getElementById('codigo').value = "";
                            document.getElementById('nombre').value = "";
                            document.getElementById('descripcion').value = "";
                            document.getElementById('color').value = "";
                            document.getElementById('txtImagen').value = "";
                        }
                        if(datos.resp == "false"){
                            Materialize.toast('Hubo un fallo al registrar el Producto. Vuelva a Intentarlo', 5000)
                        }
                        if(datos.resp != "true" && datos.resp != "false"){
                            Materialize.toast('Hubo un fallo al registrar el Producto COD:'+datos.resp, 5000)
                        }
                        $('#formulario').css("opacity","");
                        $(".submitBtn").removeAttr("disabled");
                    }
                });
            });

            //file type validation
            $("#imagen").change(function() {
                var file = this.files[0];
                var imagefile = file.type;
                var match= ["image/jpeg","image/png","image/jpg"];
                if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2]))){
                    $.alert({
                        title: 'FORMATO NO VALIDO',
                        content: 'El archivo elegido no es una formato valido de Imagen. Los Formatos validos son: .JPEG, .JPG .PNG',
                        buttons: {
                            deAcuerdo: {
                                text: 'De Acuerdo',
                                btnClass: 'btn-blue',
                                keys: ['enter'],
                                action: function(){
                                    ""
                                }
                            }
                        }
                    });
                    $("#txtImagen").val('');
                    return false;
                }
            });
        });
    </script>
</body>
</html>