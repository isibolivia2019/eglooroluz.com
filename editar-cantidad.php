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
            <div id="myModal" class="modal">
                <div id="modalText" class="modal-content teal white-text"></div>
                <div class="modal-footer  teal lighten-4">
                    <a class="waves-effect waves-red btn-flat modal-action modal-close">Cerrar</a>
                </div>
            </div>
            <div id="myModalForm" class="modal">
                <div id="modalTextForm" class="modal-content teal white-text"></div>
                <div class="row">
                    <div class="input-field col s12">
                        <input id="modalCantidadAnterior" type="text" value="" style="display:none">
                    </div>
                    <div class="input-field col s12">
                        <input id="modalCodInventario" type="text" value="" style="display:none">
                    </div>
                    <div class="input-field col s12">
                        <input id="modalCodAlmacenamiento" type="text" value="" style="display:none">
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s6">
                        <input placeholder="" id="modalCantidadNueva" type="number">
                        <label for="modalCantidadNueva">Cantidad de Producto</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input placeholder="" id="modalObservacion" type="text">
                        <label for="modalObservacion">Observacion / Nota</label>
                    </div>
                </div>
                
                <div class="row">
                    <div class="input-field col s12">
                        <div class="input-field col s6 right">
                          <a class="btn waves-effect waves-light col s12" onclick="actualizarDatos()">Actualizar Cantidad</a>
                        </div>
                    </div>
                </div>
                
            </div>
            <div class="wrapper">
                <?php require("app-slider.php");?>
                
                <section id="content">
                    <div id="breadcrumbs-wrapper" class=" grey lighten-3">
                        <div class="container">
                            <div class="row">
                                <div class="col s12 m12 l12">
                                    <h5 class="breadcrumbs-title">Editar Cantidad de Producto en Inventario</h5>
                                    <ol class="breadcrumb">
                                        <li><a href="inicio.php">Inicio</a></li>
                                        <li class="active">Editar Cantidad</li>
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
                                <h4 class="header">Selecciones un Punto de Almacenamiento</h4>
                                    <div class="row">
                                        <div class="col s12 m12 l12">
                                            <label>Almacenamiento</label>
                                            <select class="browser-default cbox" id="cboxOrigen" onchange="listaProductos()">
                                                <option value="" disabled selected>Seleccione Una Sucursal o Almacen</option>
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <br>
                            <div class="divider"></div> 
                            <div id="table-datatables">
                                <h4 class="header">Producto del Almacenamiento</h4>
                                <div class="row">
                                    <div class="col s12">
                                        <table id="table-simple" class="responsive-table display" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>Imagen</th>
                                                    <th>Codigo</th>
                                                    <th>Nombre</th>
                                                    <th>Cantidad</th>
                                                    <th>Costo de Adquision</th>
                                                    <th>Precio de Venta</th>
                                                    <th>Editar</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>Imagen</th>
                                                    <th>Codigo</th>
                                                    <th>Nombre</th>
                                                    <th>Cantidad</th>
                                                    <th>Costo de Adquision</th>
                                                    <th>Precio de Venta</th>
                                                    <th>Editar</th>
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
        var table = "";
        $(document).ready(function() {
            verificarAcceso("Permiso_Configuracion");
            listaAlmacenamiento()
        });

        function listaAlmacenamiento(){
            verificarAcceso("Permiso_Configuracion");
            var cboxOrigen = document.getElementById("cboxOrigen");
            var cboxDestino = document.getElementById("cboxDestino");
          var parametros = {
            "action" : "listaAlmacenes"            
          };
          $.ajax({
            type:'POST',
            data: parametros,
            url:'app/controladores/Almacenes.php',
            success:function(data){
                datos = JSON.parse(data);
                datos = datos.data;
                for(let i=0 ; i<datos.length ; i++){
                    var tag = document.createElement('option');
                    tag.setAttribute('value', datos[i].cod_almacen);
                    tag.innerHTML = datos[i].nombre_almacen;
                    cboxOrigen.appendChild(tag);
                }
                for(let i=0 ; i<datos.length ; i++){
                    var tag = document.createElement('option');
                    tag.setAttribute('value', datos[i].cod_almacen);
                    tag.innerHTML = datos[i].nombre_almacen;
                    cboxDestino.appendChild(tag);
                }
            }
          })
          parametros = {
             "action" : "listaSucursales"      
          };
          $.ajax({
            type:'POST',
            data: parametros,
            url:'app/controladores/Sucursales.php',
            success:function(data){
                datos = JSON.parse(data);
                datos = datos.data;
                for(let i=0 ; i<datos.length ; i++){
                    var tag = document.createElement('option');
                    tag.setAttribute('value', datos[i].cod_sucursal);
                    tag.innerHTML = datos[i].nombre_sucursal;
                    cboxOrigen.appendChild(tag);
                }
                for(let i=0 ; i<datos.length ; i++){
                    var tag = document.createElement('option');
                    tag.setAttribute('value', datos[i].cod_sucursal);
                    tag.innerHTML = datos[i].nombre_sucursal;
                    cboxDestino.appendChild(tag);
                }
            }
          })
        }

        function listaProductos(){
            verificarAcceso("Permiso_Configuracion");
            $('.cbox').attr("disabled","disabled");
            var cboxOrigen = document.getElementById("cboxOrigen").value;
            var url = ""
            if(cboxOrigen.search("SUC") != -1 ){
                var url = "app/controladores/Sucursales.php"
            }else{
                var url = "app/controladores/Almacenes.php"
            }
            var parametros = {
                "action" : "listaInventarioVenta",
                "codigo" : cboxOrigen
            };
            table = $('#table-simple').DataTable({
                "destroy":true,
                "ajax":{
                    "method": "POST",
                    "data":  parametros,
                    "url": url
                },
                "columns": [
                    {"render": function (data, type, JsonResultRow, meta) {
                            return "<img width='150'src=public/imagenes/productos/"+JsonResultRow.imagen_producto+">";
                        }
                    },
                    {"data" : "cod_item_producto"},
                    {"data" : "nombre_producto"},
                    {"data" : "cant_producto"},
                    {"data" : "compra_unit_producto"},
                    {"data" : "precio_sugerido_venta"},
                    {"defaultContent" : "<button id='editar' class='editar btn waves-effect light-green' type='submit' name='action'><i class='mdi-editor-border-color'></i></button>"}
                ],
                "language": {
                    "url": "public/Spanish.lang"
                }
            });
            
            btn_editar("#table-simple tbody", table);
        }
        var btn_editar = function(tbody, table){
            
            $(tbody).on("click", "button.editar", function(){
                
                var data = table.row( $(this).parents("tr") ).data();
               
                let cant = data.cant_producto;

                var cboxOrigen = document.getElementById("cboxOrigen").value;
                
                document.getElementById("modalCodInventario").value = data.cod_inventario;
                document.getElementById("modalCodAlmacenamiento").value = data.cod_almacenamiento;
                document.getElementById("modalCantidadAnterior").value = cant;
                document.getElementById("modalCantidadNueva").value = cant;
                $('#myModalForm').openModal();
            })
        }

        function actualizarDatos(){
            verificarAcceso("Permiso_Configuracion");
            var modalCodInventario = document.getElementById("modalCodInventario").value;
            var modalCodAlmacenamiento = document.getElementById("modalCodAlmacenamiento").value;
            var modalCantidadAnterior = document.getElementById("modalCantidadAnterior").value;
            var modalCantidadNueva = document.getElementById("modalCantidadNueva").value;
            var modalObservacion = document.getElementById("modalObservacion").value;
            
            if(modalCantidadNueva != ""){
                    var parametros = {
                           "action" : "actualizarCantidad",
                           "cod_almacenamiento" : modalCodAlmacenamiento,      
                           "cantidadNueva" : modalCantidadNueva,        
                           "cantidadAntertior" : modalCantidadAnterior,     
                           "cod_inventario" : modalCodInventario,
                           "observacion" : modalObservacion
                        };
                    $.ajax({
                      type:'POST',
                      data: parametros,
                      url:'app/controladores/Configuraciones.php',
                      success:function(data){
                            console.log("data:",data)
                          datos = JSON.parse(data);
                          
                          if(datos.resp == "true"){
                                $('#myModalForm').closeModal();
                                table.ajax.reload();
                                Materialize.toast('Cantidad Actualizado Correctamente', 5000)
                          }
                          if(datos.resp == "false"){
                              Materialize.toast('Hubo un fallo al actualizar la Cantidad. revise los datos y Vuelva a Intentarlo', 5000)
                          }
                          if(datos.resp != "true" && datos.resp != "false"){
                              Materialize.toast('Hubo un fallo al actualizar la Cantidad COD:'+datos.resp, 5000)
                          }
                      }
                    })
            }else{
                Materialize.toast('Ingrese la Cantidad de productos.', 5000)
            }
        }
    </script>
</body>
</html>