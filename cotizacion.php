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
                                    <h5 class="breadcrumbs-title">Cotización</h5>
                                    <ol class="breadcrumb">
                                        <li><a href="inicio.php">Inicio</a></li>
                                        <li class="active">Cotización</li>
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
                                </form>
                            </div>
                            <br>
                            <div class="divider"></div> 
                            <h4 class="header">Stock Disponible</h4>
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
                                                    <th>Bolivianos</th>
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
                                                    <th>Bolivianos</th>
                                                    <th>AGREGAR</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                <br>
                                <br>
                                <div class="divider"></div> 
                                <h4 class="header">CARRITO DE COTIZACION</h4>
                                <div class="row">
                                    <div class="col s12">
                                        <table id="table-carrito" class="responsive-table display" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>Codigo</th>
                                                    <th>Nombre</th>
                                                    <th>Cantidad</th>
                                                    <th>Precio Sugerido</th>
                                                    <th>Descuento</th>
                                                    <th>Precio de_Venta</th>
                                                    <th>SubTotal</th>
                                                    <th>Bolivianos</th>
                                                    <th>Editar</th>
                                                    <th>Eliminar</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>Codigo</th>
                                                    <th>Nombre</th>
                                                    <th>Cantidad</th>
                                                    <th>Precio Sugerido</th>
                                                    <th>Descuento</th>
                                                    <th>Precio de_Venta</th>
                                                    <th>SubTotal</th>
                                                    <th>Bolivianos</th>
                                                    <th>Editar</th>
                                                    <th>Eliminar</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                <br>
                                <br>
                                <div class="divider"></div> 

                                <div class="row">
                                    <div class="col s12" id="txtTotal">

                                    </div>
                                </div>
                                <div class="row">
                                        <div class="input-field col s12 m6">
                                            <input id="empresa" type="text">
                                            <label for="empresa">Empresa / Institucion</label>
                                        </div>

                                        <div class="input-field col s12 m6">
                                            <input id="atencion" type="text">
                                            <label for="atencion">Atencion</label>
                                        </div>
                                    </div>
                                <div class="row">
                                    <div class="input-field col s12 submitBtn">
                                        <div class="input-field col s12 right ">
                                          <a class="btn waves-effect waves-light col s12" onclick="cotizacion()">Realizar Cotizacion</a>
                                        </div>
                                    </div>
                                </div>
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
                          url:'app/controladores/Cotizaciones.php',
                          success:function(data){
                              datos = JSON.parse(data);
                              if(datos.resp == "true"){
                                  $('#myModalForm').closeModal();
                                  tableCarrito.ajax.reload();
                                  totalPagar(document.getElementById("cboxSucursal").value)
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
            verificarAcceso("Permiso_Venta");
            $('.cbox').attr("disabled","disabled");
            var cboxSucursal = document.getElementById("cboxSucursal").value;
            listaCarrito(cboxSucursal)
            totalPagar(cboxSucursal)
            var parametros = {
                "action" : "listaInventarioCotizaciones"
            };
            table = $('#table-simple').DataTable({
                "destroy":true,
                "ajax":{
                    "method": "POST",
                    "data":  parametros,
                    "url": "app/controladores/Cotizaciones.php"
                },
                "columns": [
                    {"render": function (data, type, JsonResultRow, meta) {
                            return "<img width='150'src=public/imagenes/productos/"+JsonResultRow.imagen_producto+">";
                        }
                    },
                    {"data" : "cod_item_producto"},
                    {"data" : "nombre_producto"},
                    {"data" : "precio_sugerido_venta"},
                    {"defaultContent" : "<input type='number' id='cant' class='cant' name='row-1-position' value=''>"},
                    {"defaultContent" : "<input type='number' step='0.01' id='precio' class='precio' name='row-1-position' value=''>"},
                    {"defaultContent" : "<button id='conversion1' class='conversion1 btn waves-effect cyan' type='button' name='editar'><i class='mdi-image-transform'></i></button>"},
                    {"defaultContent" : "<button id='carrito' class='carrito btn waves-effect light-green' type='submit' name='action'><i class='mdi-action-shopping-cart'></i></button>"}
                ],
                "language": {
                    "url": "public/Spanish.lang"
                }
            });
            btn_conversion1("#table-simple tbody", table);
            btn_carrito("#table-simple tbody", table);
        }
        
        var btn_conversion1 = function(tbody, table){
            $(tbody).on("click", "button.conversion1", function(){
                    var data = table.row( $(this).parents("tr") ).data();
                    var parametros = {
                       "action" : "conversionMonedaProducto",
                       "codInventario" : data.cod_inventario,
                    };
                    $.ajax({
                      type:'POST',
                      data: parametros,
                      url:'app/controladores/Sucursales.php',
                      success:function(data){
                            datos = JSON.parse(data);
                            datos = datos.data
                            $('#myModal').openModal();
                            document.getElementById("modalText").innerHTML = 
                            "<span class='title'>Nombre: "+datos[0].nombre_producto+"</span><p></p>"+
                            "<span class='title'>**** Precio en Bolivianos **** </span>"+
                            "<p>Precio Adquicion: "+datos[0].compra_unit_producto+"</p>"+
                            "<p>Precio Sugerido de Venta: "+datos[0].precio_sugerido_venta+"</p>"+
                            "<p>Cantidad Disponible: "+datos[0].cant_producto+"</p>"
                      }
                    })
                })
        }

        var btn_carrito = function(tbody, table){
            $(tbody).on("click", "button.carrito", function(){
                var data = table.row( $(this).parents("tr") ).data();
                var tableRemove = $(this).parents("tr");
                var cant = $(this).parents("tr").find('#cant').val();
                var precio = $(this).parents("tr").find('#precio').val();

                if(cant != ""){
                    if(precio != ""){
                        if(Number(cant) > 0){
                            actualizarCarrito(data.cod_inventario, data.cod_almacenamiento, cant, precio, table, tableRemove);
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
                        Materialize.toast('Ingrese el Precio de Venta.', 8000)
                    }
                }else{
                    Materialize.toast('Ingrese la Cantidad de Venta', 8000)
                }
            })
        }

        function actualizarCarrito(cod_inventario, sucursal, cant, precio, table, tableRemove){
            verificarAcceso("Permiso_Venta");
            var cboxSucursal = document.getElementById("cboxSucursal").value;
            var parametros = {
                "action" : "agregarCarrito",
                "cod_inventario" : cod_inventario,
                "cantidad" : cant,
                "precio" : precio,
                "sucursal" : cboxSucursal
            };
            console.log("parametros:", parametros)
            $.ajax({
              type:'POST',
              data: parametros,
              url:'app/controladores/Cotizaciones.php',
              success:function(data){
                  console.log("data:", data)
                  datos = JSON.parse(data);
                  if(datos.resp == "true"){
                      table.row(tableRemove).remove().draw(false);
                      tableCarrito.ajax.reload();
                      totalPagar(document.getElementById("cboxSucursal").value)
                      Materialize.toast('Producto agregado al Carrito de Cotizaciones.', 5000)
                  }
                  if(datos.resp == "false"){
                      Materialize.toast('Hubo un fallo al agregar al carrito de cotizaciones. Vuelva a Intentarlo', 5000)
                  }
                  if(datos.resp != "true" && datos.resp != "false"){
                      Materialize.toast('Hubo un fallo al agregar al carrito de cotizaciones COD:'+datos.resp, 5000)
                  }
              }
            })
        }

        function listaCarrito(sucursal){
            parametros = {
                "action" : "listaCarrito",
                "sucursal" : sucursal
            };
            tableCarrito = $('#table-carrito').DataTable({
                "destroy":true,
                "ajax":{
                    "method": "POST",
                    "data":  parametros,
                    "url": "app/controladores/Cotizaciones.php"
                },
                "columns": [
                    {"data" : "cod_item_producto"},
                    {"data" : "nombre_producto"},
                    {"data" : "cantidad"},
                    {"data" : "precio_sugerido_venta"},
                    {"data" : "descuento"},
                    {"data" : "total"},
                    {"data" : "subTotal"},
                    {"defaultContent" : "<button id='conversion' class='conversion btn waves-effect cyan' type='button' name='editar'><i class='mdi-image-transform'></i></button>"},
                    {"defaultContent" : "<button id='editar' class='editar btn waves-effect light-green' type='submit' name='action'><i class='mdi-editor-border-color'></i></button>"},
                    {"defaultContent" : "<button id='eliminar' class='eliminar btn waves-effect red' type='submit' name='action'><i class='mdi-navigation-close'></i></button>"}
                ],
                "language": {
                    "url": "public/Spanish.lang"
                }
            });
            btn_conversion("#table-carrito tbody", tableCarrito);
            btn_editar("#table-carrito tbody", tableCarrito);
            btn_eliminar("#table-carrito tbody", tableCarrito);
        }
        var btn_eliminar = function(tbody, table){
                $(tbody).on("click", "button.eliminar", function(){
                    verificarAcceso("Permiso_Venta");
                    var data = table.row( $(this).parents("tr") ).data();
                    var tableRemove = $(this).parents("tr");
                    var parametros = {
                       "action" : "eliminarCarrito",
                       "cod_carrito" : data.codigo
                    };
                    $.ajax({
                      type:'POST',
                      data: parametros,
                      url:'app/controladores/Cotizaciones.php',
                      success:function(data){
                          datos = JSON.parse(data);
                          if(datos.resp == "true"){
                              Materialize.toast('Producto eliminado del Carrito  de Cotizaciones Satisfactoriamene', 5000)
                              totalPagar(document.getElementById("cboxSucursal").value)
                              table.row(tableRemove).remove().draw(false);
                          }
                          if(datos.resp == "false"){
                              Materialize.toast('Hubo un fallo al eliminar el producto del Carrito. Vuelva a Intentarlo', 5000)
                          }
                          if(datos.resp != "true" && datos.resp != "false"){
                              Materialize.toast('Hubo un fallo al eliminar el producto del Carrito COD:'+datos.resp, 5000)
                          }
                      }
                    })
                })
        }

        var btn_editar = function(tbody, table){
                $(tbody).on("click", "button.editar", function(){
                    var data = table.row( $(this).parents("tr") ).data();
                    var parametros = {
                       "action" : "listaCarritoEspecifico",
                       "codCarrito" : data.codigo,
                    };
                    $.ajax({
                      type:'POST',
                      data: parametros,
                      url:'app/controladores/Cotizaciones.php',
                      success:function(data){
                            datos = JSON.parse(data);
                            datos = datos.data
                            document.getElementById('modalCarrito').value = datos[0].codigo;
                            document.getElementById('modalInventario').value = datos[0].cod_inventario;
                            document.getElementById('modalCantidad').value = datos[0].cantidad;
                            document.getElementById('modalPrecio').value = datos[0].total;
                            $('#myModalForm').openModal();
                      }
                    })
                })
        }

        var btn_conversion = function(tbody, table){
            $(tbody).on("click", "button.conversion", function(){
                var data = table.row( $(this).parents("tr") ).data();
                var parametros = {
                   "action" : "conversionMonedaProducto",
                   "codCarrito" : data.codigo,
                };
                $.ajax({
                  type:'POST',
                  data: parametros,
                  url:'app/controladores/Cotizaciones.php',
                  success:function(data){
                        datos = JSON.parse(data);
                        datos = datos.data
                        $('#myModal').openModal();
                        document.getElementById("modalText").innerHTML = 
                        "<p>Precio Sugerido de Venta: Bs. "+datos[0].precio_sugerido_venta+"</p>"+
                        "<span class='title'>**** Precios Seleccionados en Bolivianos **** </span>"+
                        "<p>Precio Descuento: "+datos[0].descuento+"</p>"+
                        "<p>Precio Unitario: Bs. "+datos[0].total+"</p>"+
                        "<p>Precio subTotal: Bs. "+(Number(datos[0].total) * Number(datos[0].cantidad))+"</p>"
                  }
                })
            })
        }

        function totalPagar(sucursal){
            var parametros = {
                "action" : "totalPagar",
                "sucursal" : sucursal,
            };
            $.ajax({
              type:'POST',
              data: parametros,
              url:'app/controladores/Cotizaciones.php',
              success:function(data){
                    datos = JSON.parse(data);
                    moneda = datos.total;
                    document.getElementById("txtTotal").innerHTML =
                    "<h4 class='header' onclick='convercionTotal()'>Total a pagar : $us "+datos.total+"</h4>"
              }
            })
        }
        function convercionTotal(){
            var parametros = {
                "action" : "convertirBolivianos",
                "moneda" : moneda
            };
            $.ajax({
              type:'POST',
              data: parametros,
              url:'app/controladores/TipoCambios.php',
              success:function(data){
                    datos = JSON.parse(data);
                    $('#myModal').openModal();
                    document.getElementById("modalText").innerHTML = "<span class='title'>Precio Total de Venta Bs. "+datos.data+"</span>"
              }
            })
        }
        function cotizacion(){
            var sucursal = document.getElementById("cboxSucursal").value;
            var empresa = document.getElementById("empresa").value;
            var atencion = document.getElementById("atencion").value;
            if(sucursal != ""){
                if(empresa != ""){
                    if(atencion != ""){
                        var parametros = {
                            "action" : "agregarCotizacion",
                            "sucursal" : sucursal,
                            "empresa" : empresa,
                            "atencion" : atencion
                        };
                        $.ajax({
                            type:'POST',
                            data: parametros,
                            url:'app/controladores/Cotizaciones.php',
                            success:function(data){
                                datos = JSON.parse(data);
                                if(datos.resp == "true"){
                                    document.getElementById("empresa").value = "";
                                    document.getElementById("atencion").value = "";
                                    document.location.href="reportes/cotizacion.php?nro="+datos.nro;
                                    tableCarrito.ajax.reload();
                                    table.ajax.reload();
                                    totalPagar(sucursal);
                                    Materialize.toast('Cotizacion realizada con exito', 6000)
                                }
                                if(datos.resp == "false"){
                                    Materialize.toast('Hubo un fallo al registrar la Cotizacion. Vuelva a Intentarlo', 5000)
                                }
                                if(datos.resp != "true" && datos.resp != "false"){
                                    Materialize.toast('Hubo un fallo al registrar la Cotizacion COD:'+datos.resp, 5000)
                                }
                            }
                        })
                    }else{
                        var textbox = document.getElementById("atencion");
                        textbox.focus();
                        textbox.scrollIntoView();
                        Materialize.toast('Seleccione el nombre dirigido de la Atencion', 6000)
                    }
                }else{
                    var textbox = document.getElementById("empresa");
                    textbox.focus();
                    textbox.scrollIntoView();
                    Materialize.toast('Seleccione el nombre dirigido de la Empresa', 6000)
                }
            }else{
                Materialize.toast('Seleccione una Sucursal', 6000)
            }
        }
    </script>
</body>
</html>