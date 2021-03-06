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
                                    <h5 class="breadcrumbs-title">Lista de Productos en Categoria</h5>
                                    <ol class="breadcrumb">
                                        <li><a href="categoria.php">Categorias</a></li>
                                        <li class="active">Productos en Categoria</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="container">
                        <div class="section">
                            <p class="caption">Informacion del Cargo.</p>
                            <div class="divider"></div>
                                <div class="row">
                                  <div class="col s12 m4 l3">
                                    <p class="header">Datos Cargo</p>
                                  </div>
                                  <div class="col s12 m8 l9">
                                    <ul class="collection">
                                        <li class="collection-item avatar" id="lblDatos1">
                                            
                                        </li>
                                    </ul>
                                  </div>
                                </div>
                                <div class="row">
                                    <div class="col s12">
                                    <div class="divider"></div>
                                    <div id="table-datatables">
                                        <h4 class="header">Personal con este Cargo</h4>
                                        <div class="row">
                                            <div class="col s12">
                                                <table id="table-simple" class="responsive-table display" cellspacing="0">
                                                    <thead>
                                                        <tr>
                                                            <th>Imagen</th>
                                                            <th>Codigo</th>
                                                            <th>Nombre</th>
                                                            <th>Eliminar</th>
                                                        </tr>
                                                    </thead>
                                                    <tfoot>
                                                        <tr>
                                                            <th>Imagen</th>
                                                            <th>Codigo</th>
                                                            <th>Nombre</th>
                                                            <th>Eliminar</th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
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
    actualizarLista();
});

function actualizarLista(){
    var table
    var parametros = {
        "action" : "listaCategoriaProductos",
        "cod_categoria" : localStorage.getItem("categoria")
    };
    $.ajax({
      type:'POST',
      data: parametros,
      url:'app/controladores/Categorias.php',
      success:function(data){
        let datos = JSON.parse(data);
        datos = datos.data;
        if(datos.length > 0){
            document.getElementById("lblDatos1").innerHTML = 
            "<i class='mdi-file-folder circle'></i>"+
            "<span class='title'>Categoria: "+datos[0].nombre_categoria+"</span>";

            table = $('#table-simple').DataTable({
                "destroy":true,
                "data": datos,
                "columns": [
                    {"render": function (data, type, JsonResultRow, meta) {
                            return "<img width='150'src=public/imagenes/productos/"+JsonResultRow.imagen_producto+">";
                        }
                    },
                    {"data" : "cod_item_producto"},
                    {"data" : "nombre_producto"},
                    {"defaultContent" : "<button id='eliminar' class='eliminar btn waves-effect red' type='submit' name='eliminar'><i class='mdi-action-delete'></i></button>"}
                ],
                "language": {
                    "url": "public/Spanish.lang"
                }
            });
            btn_eliminar("#table-simple tbody", table);
        }else{
            document.getElementById("lblDatos1").innerHTML = 
            "<i class='mdi-file-folder circle'></i>"+
            "<span class='title'>No se encontraron Resultados  </span>"+
            "</p>";
        }
        
      }
    })
    
}
var btn_eliminar = function(tbody, table){
        $(tbody).on("click", "button.eliminar", function(){
            verificarAcceso("Permiso_Categoria");
            var data = table.row( $(this).parents("tr") ).data();
            var tableRemove = $(this).parents("tr");
            
            var parametros = {
               "action" : "eliminarProductoCategoria",
               "cod_producto" : data.cod_producto,
               "cod_categoria" : data.cod_categoria
            };
            $.ajax({
              type:'POST',
              data: parametros,
              url:'app/controladores/Categorias.php',
              success:function(data){
                console.log("data",data)
                  datos = JSON.parse(data);
                  if(datos.resp == "true"){
                      Materialize.toast('El Producto fue eliminado de la categoria Satisfactoriamene', 5000);
                      table.row(tableRemove).remove().draw(false);
                  }
                  if(datos.resp == "false"){
                      Materialize.toast('Hubo un fallo al eliminar al Producto de la categoria. Vuelva a Intentarlo', 5000)
                  }
                  if(datos.resp != "true" && datos.resp != "false"){
                      Materialize.toast('Hubo un fallo al eliminar al Producto de la categoria COD:'+datos.resp, 5000)
                  }
              }
            })
        })
}
</script>
</body>
</html>