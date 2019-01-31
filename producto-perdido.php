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
                        <input id="codProductoPerdido" type="text" value="" style="display:none">
                    </div>
                    <div class="input-field col s12">
                        <input id="codInventario" type="text" value="" style="display:none">
                    </div>
                    <div class="input-field col s12">
                        <input id="almacenamiento" type="text" value="" style="display:none">
                    </div>
                    <div class="input-field col s12">
                        <input placeholder="" id="cantidad" type="number" >
                        <label for="modalPrecio">Ingrese la Cantidad</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <div class="input-field col s6 right">
                          <a class="btn waves-effect waves-light col s12" onclick="reponer()">Reponer Producto</a>
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
                                    <h5 class="breadcrumbs-title">Inventario Productos Perdidos</h5>
                                    <ol class="breadcrumb">
                                        <li><a href="inicio.php">Inicio</a></li>
                                        <li class="active">Lista de Productos Perdidos</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="container">
                        <div class="section">
                            <p class="caption">Inventario</p>
                            <div class="divider"></div>
                            <br>
                            <div class="divider"></div> 
                            <div id="table-datatables">
                                <h4 class="header">Productos Perdidos</h4>
                                <div class="row">
                                    <div class="col s12">
                                        <table id="table-simple" class="responsive-table display" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>Almacenando en</th>
                                                    <th>Imagen</th>
                                                    <th>Codigo</th>
                                                    <th>Nombre</th>
                                                    <th>Cantidad</th>
                                                    <th>Costo de Adquisicion</th>
                                                    <th>Precio de Venta</th>
                                                    <th>Observacion</th>
                                                    <th>Reponer</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>Almacenando en</th>
                                                    <th>Imagen</th>
                                                    <th>Codigo</th>
                                                    <th>Nombre</th>
                                                    <th>Cantidad</th>
                                                    <th>Costo de Adquisicion</th>
                                                    <th>Precio de Venta</th>
                                                    <th>Observacion</th>
                                                    <th>Reponer</th>
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
            verificarAcceso("Permiso_ProductoPerdido");
            var parametros = {
                "action" : "listaInventarioPerdidos"
            };
            var table = $('#table-simple').DataTable({
                "destroy":true,
                "ajax":{
                    "method": "POST",
                    "data":  parametros,
                    "url": "app/controladores/ProductosPerdidos.php"
                },
                "columns": [
                    {"data" : "nombre_almacenamiento"},
                    {"render": function (data, type, JsonResultRow, meta) {
                            return "<img width='150'src=public/imagenes/productos/"+JsonResultRow.imagen_producto+">";
                        }
                    },
                    {"data" : "cod_item_producto"},
                    {"data" : "nombre_producto"},
                    {"data" : "cant_producto"},
                    {"data" : "compra_unit_producto"},
                    {"data" : "precio_sugerido_venta"},
                    {"data" : "observacion_producto_perdido"},
                    {"defaultContent" : "<button id='reponer' class='reponer btn waves-effect blue' type='button' name='editar'><i class='mdi-editor-insert-drive-file'></i></button>"}
                ],
                "language": {
                    "url": "public/Spanish.lang"
                }
            });
            btn_reponer("#table-simple tbody", table);
        });

        var btn_reponer = function(tbody, table){
            $(tbody).on("click", "button.reponer", function(){
                var data = table.row( $(this).parents("tr") ).data();
                document.getElementById('codProductoPerdido').value = data.cod_producto_perdido;
                document.getElementById('codInventario').value = data.cod_inventario;
                document.getElementById('almacenamiento').value = data.cod_almacenamiento;
                $('#myModalForm').openModal();
            })
        }

        function reponer(){
            verificarAcceso("Permiso_ProductoPerdido");
            var cboxSucursal = document.getElementById("cboxSucursal").value;
            var cboxAño = document.getElementById("cboxAño").value;
            var cboxMes = document.getElementById("cboxMes").value;
            
            var parametros = {
                "action" : "listaCajaChica",
                "sucursal" : cboxSucursal,
                "año" : cboxAño,
                "mes" : cboxMes
            };
            
        }

    </script>
</body>
</html>