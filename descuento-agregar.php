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
                        <input id="modalCarrito" type="text" value="" style="display:none">
                    </div>
                    <div class="input-field col s12">
                        <input id="modalInventario" type="text" value="" style="display:none">
                    </div>
                    <div class="input-field col s12">
                        <input placeholder="" id="modalCantidad" type="number" >
                        <label for="modalCantidad">Cantidad de Venta</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input placeholder="" id="modalPrecio" type="number" step="0.01">
                        <label for="modalPrecio">Precio de Venta</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <div class="input-field col s6 right">
                          <a class="btn waves-effect waves-light col s12" onclick="actualizarDatosCarrito()">Actualizar</a>
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
                                    <h5 class="breadcrumbs-title">Agregar Descuento(s)</h5>
                                    <ol class="breadcrumb">
                                        <li><a href="inicio.php">Inicio</a></li>
                                        <li class="active">Agregar Descuento(s)</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="container">
                        <div class="section">
                            <p class="caption">Seleccione una Sucursal</p>
                            <div class="divider"></div>
                            <div class="row">
                                <form class="col s12">
                                    <div class="row">
                                        <div class="col s12 m8 l9">
                                            <label>Sucursal</label>
                                            <select class="browser-default cbox" id="cboxSucursal" onchange="listaProductos()">
                                                <option value="" disabled selected>Seleccione una Sucursal</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12 m6 l4">
                                            <input id="paginaWeb" type="text">
                                            <label for="paginaWeb">Descuento Pagina Web</label>
                                        </div>
                                        <div class="input-field col s12 m6 l4">
                                            <input id="interno" type="text">
                                            <label for="interno">Descuento Interno</label>
                                        </div>
                                        <div class="input-field col s12 m12 l4">
                                            <input id="observacion" type="text">
                                            <label for="observacion">Observacion / Nota</label>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <br>
                            <div class="divider"></div> 
                            <h4 class="header">Productos Disponibles</h4>
                                <div class="row">
                                    <div class="col s12">
                                        <table id="table-simple" class="responsive-table display" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>imagen</th>
                                                    <th>Codigo</th>
                                                    <th>Nombre</th>
                                                    <th>Precio Sugerido</th>
                                                    <th>Cantidad</th>
                                                    <th>Precio de_Venta</th>
                                                    <th>AGREGAR</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>imagen</th>
                                                    <th>Codigo</th>
                                                    <th>Nombre</th>
                                                    <th>Precio Sugerido</th>
                                                    <th>Cantidad</th>
                                                    <th>Precio de_Venta</th>
                                                    <th>AGREGAR</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                <br>
                                <br>
                        </div>
                    </div>
                </section>
            </div>
        </div>

        <?php require("app-footer.php");?>
        <?php require("app-foot.php");?>

    <script>
    var tableCarrito = "";
    var table = "";
    var moneda = 0;
        function actualizarDatosCarrito(){
            verificarAcceso("Permiso_Venta");
            var modalCarrito = document.getElementById("modalCarrito").value;
            var modalInventario = document.getElementById("modalInventario").value;
            var modalCantidad = document.getElementById("modalCantidad").value;
            var modalPrecio = document.getElementById("modalPrecio").value;

            if(modalCantidad != ""){
                if(modalPrecio != ""){
                    if(Number(modalCantidad) > 0){
                        var parametros = {
                           "action" : "actualizarCarrito",
                           "codCarrito" : modalCarrito,      
                           "precio" : modalPrecio,        
                           "cantidad" : modalCantidad,        
                           "cod_inventario" : modalInventario        
                        };
                        $.ajax({
                          type:'POST',
                          data: parametros,
                          url:'app/controladores/Ventas.php',
                          success:function(data){
                              datos = JSON.parse(data);
                              if(datos.resp == "true"){
                                  $('#myModalForm').closeModal();
                                  tableCarrito.ajax.reload();

                                  Materialize.toast('Carrito Actualizado con exito', 5000)
                              }
                              if(datos.resp == "false"){
                                  Materialize.toast('Hubo un fallo al actualizar el Carrito. Vuelva a Intentarlo', 5000)
                              }
                              if(datos.resp != "true" && datos.resp != "false"){
                                  Materialize.toast('Hubo un fallo al actualizar el Carrito COD:'+datos.resp, 5000)
                              }
                          }
                        })
                    }else{
                        $.alert({
                            title: 'STOCK NO DISPONIBLE',
                            content: 'La cantidad de venta que introdujo no esta disponible en la cantidad de stock del Producto. Ingrese una cantidad mayor a 0 e inferior o igual a :'+ data.cant_producto,
                            buttons: {
                                deAcuerdo: {
                                    text: 'De Acuerdo',
                                    btnClass: 'btn-blue',
                                    keys: ['enter'],
                                    action: function(){
                                    }
                                }
                            }
                        });
                    }
                }else{
                    Materialize.toast('Ingrese el Precio de Venta.', 5000)
                }
            }else{
                Materialize.toast('Ingrese la Cantidad de Venta', 5000)
            }
        }

        $(document).ready(function() {
            verificarAcceso("Permiso_Venta");
            
            var cboxSucursal = document.getElementById("cboxSucursal");
            var parametros = {
             "action" : "listaAccesosSucursales"        
          };
          $.ajax({
            type:'POST',
            data: parametros,
            url:'app/controladores/Accesos.php',
            success:function(data){
                datos = JSON.parse(data);
                datos = datos.data
                for(let i=0 ; i<datos.length ; i++){
                    var tag = document.createElement('option');
                    tag.setAttribute('value', datos[i].cod_sucursal);
                    tag.innerHTML = datos[i].nombre_sucursal;
                    cboxSucursal.appendChild(tag);
                }
            }
          })
        });

        function listaProductos(){
            verificarAcceso("Permiso_Descuento");
            $('.cbox').attr("disabled","disabled");
            var cboxSucursal = document.getElementById("cboxSucursal").value;
            var parametros = {
                "action" : "listaInventarioVenta",
                "codigo" : cboxSucursal
            };
            table = $('#table-simple').DataTable({
                "destroy":true,
                "ajax":{
                    "method": "POST",
                    "data":  parametros,
                    "url": "app/controladores/Sucursales.php"
                },
                "columns": [
                    {"render": function (data, type, JsonResultRow, meta) {
                            return "<img width='150'src=public/imagenes/productos/"+JsonResultRow.imagen_producto+">";
                        }
                    },
                    {"data" : "cod_item_producto"},
                    {"data" : "nombre_producto"},
                    {"data" : "precio_sugerido_venta"},
                    {"data" : "cant_producto"},
                    {"data" : "precio_sugerido_venta"},
                    {"defaultContent" : "<button id='agregar' class='agregar btn waves-effect light-green' type='submit' name='action'><i class='mdi-content-send'></i></button>"}
                ],
                "language": {
                    "url": "public/Spanish.lang"
                }
            });

            btn_agregar("#table-simple tbody", table);
        }


        var btn_agregar = function(tbody, table){
            $(tbody).on("click", "button.agregar", function(){
                verificarAcceso("Permiso_Descuento");
                    var paginaWeb = document.getElementById("paginaWeb").value;
                    var interno = document.getElementById("interno").value;
                    var observacion = document.getElementById("observacion").value;
                    if(paginaWeb !=""){
                        if(interno !=""){
                            var data = table.row( $(this).parents("tr") ).data();
                    var tableRemove = $(this).parents("tr");
                    var parametros = {
                       "action" : "agregarDescuento",
                       "paginaWeb" : paginaWeb,
                       "interno" : interno,
                       "observacion" : observacion,
                       "inventario" : data.cod_inventario
                    };
                    $.ajax({
                      type:'POST',
                      data: parametros,
                      url:'app/controladores/Descuentos.php',
                      success:function(data){
                          console.log(data)
                          datos = JSON.parse(data);
                          if(datos.resp == "true"){
                              Materialize.toast('Producto fue agregado en descuento', 5000)
                              table.row(tableRemove).remove().draw(false);
                          }
                          if(datos.resp == "false"){
                              Materialize.toast('El producto actualmente se encuentra en Descuento, elija otro Producto', 5000)
                          }
                          if(datos.resp != "true" && datos.resp != "false"){
                              Materialize.toast('El producto actualmente se encuentra en Descuento COD:'+datos.resp, 5000)
                          }
                      }
                    })
                        }else{
                            Materialize.toast('Ingrese un porcentaje de Descuento Interno ', 5000)
                        }
                    }else{
                        Materialize.toast('Ingrese un porcentaje de Descuento para la Pagina WEB ', 5000)
                    }

                    
            })
        }

    </script>
</body>
</html>