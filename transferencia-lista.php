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
                            <p class="caption">Lista de Transferencias registradas.</p>
                            <div class="divider"></div>
                            <div class="row">
                                <form class="col s12">
                                <h4 class="header">Selecciones el Origen / Destino</h4>
                                    <div class="row">
                                        <div class="col s12 m6 l6">
                                            <label>Origen</label>
                                            <select class="browser-default cbox" id="cboxOrigen">
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
                                        <div class="input-field col s12 submitBtn">
                                            <div class="input-field col s12 right ">
                                              <a class="btn waves-effect waves-light col s12" onclick="listaTransferencia()">Buscar Transferencia</a>
                                            </div>
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
                                                    <th>Fecha/Hora</th>
                                                    <th>Imagen</th>
                                                    <th>Codigo</th>
                                                    <th>Producto</th>
                                                    <th>Cantidad</th>
                                                    <th>Costo de Adquision</th>
                                                    <th>Observacion</th>
                                                    <th>Personal</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>Fecha/Hora</th>
                                                    <th>Imagen</th>
                                                    <th>Codigo</th>
                                                    <th>Producto</th>
                                                    <th>Cantidad</th>
                                                    <th>Costo de Adquision</th>
                                                    <th>Observacion</th>
                                                    <th>Personal</th>
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
        
        function listaTransferencia(){
            verificarAcceso("Permiso_Trasnferencia");
            var cboxOrigen = document.getElementById("cboxOrigen").value;
            var cboxDestino = document.getElementById("cboxDestino").value;
            
            var parametros = {
                "action" : "listaTransferencia",
                "origen" : cboxOrigen,
                "destino" : cboxDestino
            };
            var table = $('#table-simple').DataTable({
                "destroy":true,
                "ajax":{
                    "method": "POST",
                    "data":  parametros,
                    "url": "app/controladores/Transferencias.php"
                },
                "columns": [
                    {"data" : "fecha_traspaso_producto"},
                    {"render": function (data, type, JsonResultRow, meta) {
                            return "<img width='150'src=public/imagenes/productos/"+JsonResultRow.imagen_producto+">";
                        }
                    },
                    {"data" : "cod_item_producto"},
                    {"data" : "nombre_producto"},
                    {"data" : "cantidad_producto"},
                    {"data" : "compra_unit_producto"},
                    {"data" : "observacion_traspaso_producto"},
                    {"data" : "personal"}
                ],
                "columnDefs": [
   		        	{ "type": "date-euro", "targets": 0 }
                ],
                "order": [[ 0, "desc" ]],
                "language": {
                    "url": "public/Spanish.lang"
                }
            });
        }
    </script>
</body>
</html>