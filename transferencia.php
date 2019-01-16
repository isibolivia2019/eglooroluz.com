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
                                    <h5 class="breadcrumbs-title">Tranferencia de Productos</h5>
                                    <ol class="breadcrumb">
                                        <li><a href="inicio.php">Inicio</a></li>
                                        <li class="active">Tranferencia de Productos</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="container">
                        <div class="section">
                            <p class="caption">Tranferencia de Productos</p>
                            <div class="divider"></div>
                            <div class="row">
                                <form class="col s12">
                                <h4 class="header">Selecciones el Origen / Destino</h4>
                                    <div class="row">
                                        <div class="col s12 m6 l6">
                                            <label>Origen</label>
                                            <select class="browser-default cbox" id="cboxOrigen" onchange="listaProductos()">
                                                <option value="" disabled selected>Seleccione Una Sucursal o Almacen</option>
                                            </select>
                                        </div>
                                        <div class="col s12 m6 l6">
                                            <label>Destinoo</label>
                                            <select class="browser-default" id="cboxDestino">
                                                <option value="" disabled selected>Seleccione Una Sucursal o Almacen</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <input id="observacion" type="text">
                                            <label for="observacion">Observacion / Nota</label>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <br>
                            <div class="divider"></div> 
                            <div id="table-datatables">
                                <h4 class="header">Producto del Almacenamiento de Origen</h4>
                                <div class="row">
                                    <div class="col s12">
                                        <table id="table-simple" class="responsive-table display" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>Imagen</th>
                                                    <th>Codigo</th>
                                                    <th>Nombre</th>
                                                    <th>Costo de Adquision</th>
                                                    <th>Precio de Venta</th>
                                                    <th>Cantidad</th>
                                                    <th>Transferir</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>Imagen</th>
                                                    <th>Codigo</th>
                                                    <th>Nombre</th>
                                                    <th>Costo de Adquision</th>
                                                    <th>Precio de Venta</th>
                                                    <th>Cantidad</th>
                                                    <th>Transferir</th>
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
            verificarAcceso("Permiso_Trasnferencia");
            listaAlmacenamiento()
        });

        function listaAlmacenamiento(){
            verificarAcceso("Permiso_Trasnferencia");
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
            verificarAcceso("Permiso_Trasnferencia");
            $('.cbox').attr("disabled","disabled");
            var table
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
                    {"data" : "compra_unit_producto"},
                    {"data" : "precio_sugerido_venta"},
                    {"defaultContent" : "<input type='number' id='cant' class='cant' name='row-1-position' value=''>"},
                    {"defaultContent" : "<button id='transferir' class='transferir btn waves-effect light-green' type='submit' name='action'><i class='mdi-action-trending-neutral'></i></button>"}
                ],
                "language": {
                    "url": "public/Spanish.lang"
                }
            });
            
            btn_transferir("#table-simple tbody", table);
        }
        var btn_transferir = function(tbody, table){
            
            $(tbody).on("click", "button.transferir", function(){
                var data = table.row( $(this).parents("tr") ).data();
                let str = data.compra_unit_producto
                let compra_unit_producto = Number(str.substring(4))
                console.log("data", data)
                str = data.precio_sugerido_venta
                let precio_sugerido_venta = Number(str.substring(4))

                var cant = $(this).parents("tr").find('#cant').val();
                var cboxOrigen = document.getElementById("cboxOrigen").value;
                var cboxDestino = document.getElementById("cboxDestino").value;
                var observacion = document.getElementById("observacion").value;

                if(cant != ""){
                    if(cboxOrigen != ""){
                        if(cboxDestino != ""){
                            if(cboxOrigen != cboxDestino){
                                if(Number(cant) <= Number(data.cant_producto) && Number(cant) > 0){
                                    var parametros = {
                                       "action" : "agregarTransferencia",
                                       "origen" : cboxOrigen,
                                       "destino" : cboxDestino,
                                       "codProducto" : data.cod_producto,
                                       "cantidad" : cant,
                                       "costo" : compra_unit_producto,
                                       "precio" : precio_sugerido_venta,
                                       "observacion" : observacion
                                    };
                                    $.ajax({
                                      type:'POST',
                                      data: parametros,
                                      url:'app/controladores/Transferencias.php',
                                      success:function(data){
                                          console.log("data", data)
                                          datos = JSON.parse(data);
                                          if(datos.resp == "true"){
                                              Materialize.toast('Transferencia realizada con exito', 5000)
                                          }
                                          if(datos.resp == "false"){
                                              Materialize.toast('Hubo un fallo al registrar la Transferencia. Vuelva a Intentarlo', 5000)
                                          }
                                          if(datos.resp != "true" && datos.resp != "false"){
                                              Materialize.toast('Hubo un fallo al registrar la Transferencia COD:'+datos.resp, 5000)
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
                                $.alert({
                                    title: 'NO SE PUEDE TRANSFERIR',
                                    content: 'El punto de Origen es igual al Punto de Destino porfavor revise e intente nuevamente',
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
                            $.alert({
                                title: 'DESTINO NO SELECCIONADO',
                                content: 'El punto de Destino no fue seleccionado porfavor seleccione uno e intentenuevamente',
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
                        $.alert({
                            title: 'ORIGEN NO SELECCIONADO',
                            content: 'El punto de Origen no fue seleccionado porfavor seleccione uno e intentenuevamente',
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
                    $.alert({
                        title: 'CANTIDAD INVALIDA',
                        content: 'La cantidad de transferencia no fue seleccionado porfavor ingrese una cantidad permitida al stock e intentenuevamente',
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
            })
        }
    </script>
</body>
</html>