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
                                    <h5 class="breadcrumbs-title">Asignar Producto a una Categoria</h5>
                                    <ol class="breadcrumb">
                                        <li><a href="categoria.php">Categoria</a></li>
                                        <li class="active">Asignar producto</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="container">
                        <div class="section">
                            <p class="caption">Seleccione una Categoria</p>
                            <div class="divider"></div>
                            <div class="row">
                                <form class="col s12">
                                    <div class="row">
                                    <div class="input-field col s12">
                                            <select class="cbox browser-default" id="cboxCategoria">
                                                <option value="" disabled selected>Seleccione la Categoria</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <div class="input-field col s6 right">
                                                  <a class="cbox btn waves-effect waves-light col s12" onclick="seleccionarCategoria()">Seleccionar Categoria</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div id="table-datatables">
                                <h4 class="header">Productos</h4>
                                <div class="row">
                                    <div class="col s12">
                                        <table id="table-simple" class="responsive-table display" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>Imagen</th>
                                                    <th>Codigo</th>
                                                    <th>Nombre</th>
                                                    <th>Descripcion</th>
                                                    <th>Color</th>
                                                    <th>Seleccionar</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>Imagen</th>
                                                    <th>Codigo</th>
                                                    <th>Nombre</th>
                                                    <th>Descripcion</th>
                                                    <th>Color</th>
                                                    <th>Seleccionar</th>
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
            verificarAcceso("Permiso_Categoria");
            var cboxSueldo = document.getElementById("cboxCategoria");
            var parametros = {
             "action" : "listaCategorias"        
          };
          $.ajax({
            type:'POST',
            data: parametros,
            url:'app/controladores/Categorias.php',
            success:function(data){
                datos = JSON.parse(data);
                datos = datos.data
                for(let i=0 ; i<datos.length ; i++){
                    var tag = document.createElement('option');
                    tag.setAttribute('value', datos[i].cod_categoria);
                    tag.innerHTML = datos[i].nombre_categoria;
                    cboxCategoria.appendChild(tag);
                }
            }
          })
        });

        function listaProductos(){
            verificarAcceso("Permiso_Categoria");
            var parametros = {
                "action" : "listaProductos"
            };
            var table = $('#table-simple').DataTable({
                "destroy":true,
                "ajax":{
                    "method": "POST",
                    "data":  parametros,
                    "url": "app/controladores/Productos.php"
                },
                "columns": [
                    {"render": function (data, type, JsonResultRow, meta) {
                            return "<img width='150'src=public/imagenes/productos/"+JsonResultRow.imagen_producto+">";
                        }
                    },
                    {"data" : "cod_item_producto"},
                    {"data" : "nombre_producto"},
                    {"data" : "descripcion_producto"},
                    {"data" : "color_producto"},
                    {"defaultContent" : "<button id='seleccionar' class='seleccionar btn waves-effect light-green' type='submit' name='action'><i class='mdi-content-send'></i></button>"},
                ],
                "language": {
                    "url": "public/Spanish.lang"
                }
            });
            btn_seleccionar("#table-simple tbody", table);
        }

        var btn_seleccionar = function(tbody, table){
                $(tbody).on("click", "button.seleccionar", function(){
                    verificarAcceso("Permiso_Categoria");
                    var cboxCategoria = document.getElementById("cboxCategoria").value;
                    var data = table.row( $(this).parents("tr") ).data();
                    var tableRemove = $(this).parents("tr");
                    var parametros = {
                       "action" : "asignarProductoCategoria",
                       "cod_categoria" : cboxCategoria,
                       "cod_producto" : data.cod_producto
                    };
                    $.ajax({
                      type:'POST',
                      data: parametros,
                      url:'app/controladores/Categorias.php',
                      success:function(data){
                          console.log(data)
                          datos = JSON.parse(data);
                          if(datos.resp == "true"){
                              Materialize.toast('Producto asignado en Categoria', 5000)
                              table.row(tableRemove).remove().draw(false);
                          }
                          if(datos.resp == "false"){
                              Materialize.toast('El producto ya esta Asignado a esta Categoria, elija otro Producto', 5000)
                          }
                          if(datos.resp != "true" && datos.resp != "false"){
                              Materialize.toast('Hubo un fallo al Asignar el Producto COD:'+datos.resp, 5000)
                          }
                      }
                    })
                })
        }
        function seleccionarCategoria(){
            //$('body').addClass('loaded');
            $('.cbox').attr("disabled","disabled");
            $('.btnSel').attr("disabled","disabled");
            verificarAcceso("Permiso_Categoria");
            listaProductos()
        }
    </script>
</body>
</html>