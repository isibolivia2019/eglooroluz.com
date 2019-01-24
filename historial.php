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
                  <div id="modalText" class="modal-content teal white-text">
                    </div>
                  <div class="modal-footer  teal lighten-4">
                    <a class="waves-effect waves-red btn-flat modal-action modal-close">Cerrar</a>
                  </div>
                </div>
            <div class="wrapper">
                <?php require("app-slider.php");?>
                
                <section id="content">
                    <div id="breadcrumbs-wrapper" class=" grey lighten-3">
                        <div class="container">
                            <div class="row">
                                <div class="col s12 m12 l12">
                                    <h5 class="breadcrumbs-title">Historial</h5>
                                    <ol class="breadcrumb">
                                        <li><a href="sucursal.php">Sucursales</a></li>
                                        <li><a href="sucursal-inventario.php">Inventario</a></li>
                                        <li class="active">Historial</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="container">
                        <div class="section">
                            <p class="caption">Historial de Productos</p>
                            <div class="divider"></div>
                            <div id="table-datatables">
                                <h4 class="header">Datos del Producto</h4>
                                <div class="row">
                                <div class="col s12 m4 l3">
                                    <div id="divImagen">
                                        
                                        </div>
                                  </div>
                                  <div class="col s12 m8 l9">
                                    <ul class="collection">
                                        <li class="collection-item avatar" id="lblDatos1">
                                            
                                        </li>
                                    </ul>
                                  </div>
                                </div>
                                <h4 class="header">Historial</h4>
                                <div class="row">
                                    <div class="col s12">
                                        <table id="table-simple" class="responsive-table display" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>FECHA / HORA</th>
							                        <th>EVENTO</th>
							                        <th>CANTIDAD</th>
							                        <th>OBSERVACION</th>
							                        <th>PERSONAL</th>
							                        <th>CODIGO</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>FECHA / HORA</th>
							                        <th>EVENTO</th>
							                        <th>CANTIDAD</th>
							                        <th>OBSERVACION</th>
							                        <th>PERSONAL</th>
							                        <th>CODIGO</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                <div class="divider"></div>
                                <div id="txtTotal"></div>
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
            verificarAcceso("Permiso_Sucursal");
            console.log("inve:",localStorage.getItem("inventario"))
            var parametros = {
                "action" : "listaInventarioEspecifico",
                "codInventario" : localStorage.getItem("inventario")
            };
            $.ajax({
              type:'POST',
              data: parametros,
              url:'app/controladores/Historiales.php',
              success:function(data){
                let datos = JSON.parse(data);
                datos = datos.data
                document.getElementById("lblDatos1").innerHTML = 
                    "<i class='mdi-file-folder circle'></i>"+
                    "<span class='title'>#"+datos[0].cod_item_producto+"</span>"+
                    "<p>Nombre: "+datos[0].nombre_producto+
                    "</p>";
                    document.getElementById("divImagen").innerHTML = "<img width='150'src=public/imagenes/productos/"+datos[0].imagen_producto+">";
              }
            })

            parametros = {
                "action" : "listaHistorial",
                "codInventario" : localStorage.getItem("inventario")
            };

            /*$.ajax({
              type:'POST',
              data: parametros,
              url:'app/controladores/Historiales.php',
              success:function(data){
                console.log("data", data)
                let datos = JSON.parse(data);
                datos = datos.data
                }
            })*/
            var table = $('#table-simple').DataTable({
                "destroy":true,
                "ajax":{
                    "method": "POST",
                    "data":  parametros,
                    "url": "app/controladores/Historiales.php",
                    "dataSrc": function ( json ) {
                        console.log("dataSrc", json.data[json.data.length -1])
                        document.getElementById("txtTotal").innerHTML = "<h4 class='header'>Total: " + json.data[json.data.length -1].total + " UNIDADES. </h4>";
                        
                return json.data;
                    }
                },
                "columns": [
                    {"data" : "fecha_hora"},
                    {"data" : "evento"},
                    {"data" : "cantidad"},
                    {"data" : "observacion"},
                    {"data" : "personal"},
                    {"data" : "cod_item_producto"}
                    ],
                "columnDefs": [
   		        	{ "type": "date-euro", "targets": 0 }
                ],
                "order": [[ 0, "desc" ]],
                "language": {
                    "url": "public/Spanish.lang"
                }
            });
        });

    </script>
</body>
</html>