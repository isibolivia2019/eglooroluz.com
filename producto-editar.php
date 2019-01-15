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
                                    <h5 class="breadcrumbs-title">Editar datos del Producto</h5>
                                    <ol class="breadcrumb">
                                        <li><a href="producto.php">Productos</a></li>
                                        <li class="active">Editar Producto</li>
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
                                <div class="col s4">
                                    <div class="row">
                                        <div id="divImagen">
                                        
                                        </div>
                                    </div>
                                </div>
                                <div class="col s8">
                                    <div class="row">
                                        <form enctype="multipart/form-data" id="formulario" method="post">
                                            <div class="row">
                                                <div class="form-group input-field col s12">
                                                    <input id="action" name="action" type="text" value="actualizarImagenProducto" style="display:none">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group input-field col s12">
                                                    <input id="cod" name="cod" type="text" value="" style="display:none">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group input-field col s12">
                                                    <input id="codItem" name="codItem" type="text" value="" style="display:none">
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
                                                        <button class="btn cyan waves-effect waves-light right submitBtn" type="submit" name="submit">Actualizar Imagen
                                                            <i class="mdi-content-send right"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="divider"></div>
                            <div class="row">
                                <form>
                                    <div class="row">
                                        <div class="form-group input-field col s12">
                                            <input placeholder="" id="codigo" name="codigo" type="text" required>
                                            <label for="codigo">Codigo del Producto</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group input-field col s12">
                                            <input placeholder="" id="nombre" name="nombre" type="text" required>
                                            <label for="nombre">Nombre del Producto</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group input-field col s12">
                                            <input placeholder="" id="descripcion" name="descripcion" type="text">
                                            <label for="descripcion">Descripcion del Producto</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group input-field col s12">
                                            <input placeholder="" id="color" name="color" type="text">
                                            <label for="color">Color del Producto</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <div class="input-field col s6 right">
                                                    <a class="btn waves-effect waves-light col s12" onclick="actualizarDatos()">Actualizar</a>
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
    function lista(){
        var parametros = {
                "action" : "productoEspecifico",
                "cod_producto" : localStorage.getItem("producto")
            };
            $.ajax({
              type:'POST',
              data: parametros,
              url:'app/controladores/Productos.php',
              success:function(data){
                datos = JSON.parse(data);
                document.getElementById('txtImagen').value = datos[0].imagen_producto;
                document.getElementById('cod').value = datos[0].cod_producto;
                document.getElementById('codItem').value = datos[0].cod_item_producto;
                document.getElementById("divImagen").innerHTML = "<img width='250'src=public/imagenes/productos/"+datos[0].imagen_producto+">";
                
                document.getElementById('codigo').value = datos[0].cod_item_producto;
                document.getElementById('nombre').value = datos[0].nombre_producto;
                document.getElementById('descripcion').value = datos[0].descripcion_producto;
                document.getElementById('color').value = datos[0].color_producto;
              }
            })
    }
        $(document).ready(function() {
            verificarAcceso("Permiso_Producto");
            $('.submitBtn').attr("disabled","disabled");
            lista();

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
                        Materialize.toast('Aguarde porfavor mientras actualizamos la imagen', 5000)
                    },
                    success: function(data){
                        console.log("data", data)
                        datos = JSON.parse(data);
                        if(datos.resp == "true"){
                            Materialize.toast('Imagen actualizado con exito', 5000)
                            lista();
                        }
                        if(datos.resp == "false"){
                            Materialize.toast('Hubo un fallo al actualizar la Imagen. Vuelva a Intentarlo', 5000)
                        }
                        if(datos.resp != "true" && datos.resp != "false"){
                            Materialize.toast('Hubo un fallo al actualizar la Imagen COD:'+datos.resp, 5000)
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
                    $('.submitBtn').attr("disabled","disabled");
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
                }else{
                    $(".submitBtn").removeAttr("disabled");
                }
            });
        });

        function actualizarDatos(){
            verificarAcceso("Permiso_Producto");
          var codigo = document.getElementById('codigo').value;
          var nombre = document.getElementById('nombre').value;
          var descripcion = document.getElementById('descripcion').value;
          var color = document.getElementById('color').value;

          var parametros = {
             "action" : "actualizarProducto",
             "codigo" : localStorage.getItem("producto"),
             "cod_item" : codigo,
             "nombre" : nombre,
             "descripcion" : descripcion,
             "color" : color,
          };
          $.ajax({
            type:'POST',
            data: parametros,
            url:'app/controladores/Productos.php',
            success:function(data){
                datos = JSON.parse(data);
                if(datos.resp == "true"){
                    Materialize.toast('Producto Actualizado con exito', 5000)
                    lista();
                }
                if(datos.resp == "false"){
                    Materialize.toast('Hubo un fallo al actualizar el Producto. Vuelva a Intentarlo', 5000)
                }
                if(datos.resp != "true" && datos.resp != "false"){
                    Materialize.toast('Hubo un fallo al actualizar el Producto COD:'+datos.resp, 5000)
                }
            }
          })
        }
    </script>
</body>
</html>