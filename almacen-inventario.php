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
                                    <h5 class="breadcrumbs-title">Inventario de Productos</h5>
                                    <ol class="breadcrumb">
                                        <li><a href="almacen.php">Almacenes</a></li>
                                        <li class="active">Inventario</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="container">
                        <div class="section">
                            <p class="caption">Inventario de Productos</p>
                            <div class="divider"></div>
                            <div id="table-datatables">
                                <h4 class="header">Datos del Almacen</h4>
                                <div class="row">
                                  <div class="col s12 m12 l12">
                                    <ul class="collection">
                                        <li class="collection-item avatar" id="lblDatos1">
                                            
                                        </li>
                                    </ul>
                                  </div>
                                </div>
                                <h4 class="header">Inventario</h4>
                                <div class="row">
                                    <div class="col s12">
                                        <table id="table-simple" class="responsive-table display" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>Imagen</th>
                                                    <th>Codigo</th>
                                                    <th>Nombre</th>
                                                    <th>Cantidad</th>
                                                    <th>Precio de Compra</th>
                                                    <th>Precio de Venta</th>
                                                    <th>Bolivianos</th>
                                                    <th>Historial</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>Imagen</th>
                                                    <th>Codigo</th>
                                                    <th>Nombre</th>
                                                    <th>Cantidad</th>
                                                    <th>Precio de Compra</th>
                                                    <th>Precio de Venta</th>
                                                    <th>Bolivianos</th>
                                                    <th>Historial</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                <div class="row" id="lblResp"></div>
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
            verificarAcceso("Permiso_Almacen");
            var parametros = {
                "action" : "listaInventarioActual",
                "codigo" : localStorage.getItem("almacen")
            };
            var table = $('#table-simple').DataTable({
                "destroy":true,
                "ajax":{
                    "method": "POST",
                    "data":  parametros,
                    "url": "app/controladores/Almacenes.php",
                    "dataSrc": function ( json ) {
                        console.log("resp", "total:" + json.data[json.data.length -1].total_respuesta + ",correctos:" + json.data[json.data.length -1].total_correcto + ",incorrectos:"+json.data[json.data.length -1].total_incorrecto)
                        return json.data;
                    }
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
                    {"defaultContent" : "<button id='conversion' class='conversion btn waves-effect green' type='button' name='editar'><i class='mdi-image-transform'></i></button>"},
                    {"defaultContent" : "<button id='historial' class='historial btn waves-effect blue' type='button' name='editar'><i class='mdi-editor-insert-drive-file'></i></button>"},
                ],
                "language": {
                    "url": "public/Spanish.lang"
                }
            });
            btn_historial("#table-simple tbody", table);
            btn_conversion("#table-simple tbody", table);

            parametros = {
                "action" : "almacenEspecifico",
                "cod_almacen" : localStorage.getItem("almacen")
            };
            $.ajax({
              type:'POST',
              data: parametros,
              url:'app/controladores/Almacenes.php',
              success:function(data){
                let datos = JSON.parse(data);
                document.getElementById("lblDatos1").innerHTML = 
                "<i class='mdi-maps-store-mall-directory circle'></i>"+
                "<span class='title'>Almacen: "+datos[0].nombre_almacen+"</span>"+
                "<p>Direccion: "+datos[0].direccion_almacen+
                "</p>";
              }
            })
        });

        var btn_historial = function(tbody, table){
                $(tbody).on("click", "button.historial", function(){
                    var data = table.row( $(this).parents("tr") ).data();
                    localStorage.setItem("inventario", data.cod_inventario);
                    location.href = "historial.php";
                })
        }
        var btn_conversion = function(tbody, table){
                $(tbody).on("click", "button.conversion", function(){
                    var data = table.row( $(this).parents("tr") ).data();
                    var parametros = {
                       "action" : "conversionMonedaProducto",
                       "codInventario" : data.cod_inventario,
                    };
                    $.ajax({
                      type:'POST',
                      data: parametros,
                      url:'app/controladores/Almacenes.php',
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
    </script>
</body>
</html>