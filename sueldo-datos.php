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
                                    <h5 class="breadcrumbs-title">Datos del Usuario</h5>
                                    <ol class="breadcrumb">
                                        <li><a href="usuario.php">Usuarios</a></li>
                                        <li class="active">Datos de Usuario</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="container">
                        <div class="section">
                            <p class="caption">Informacion del usuario.</p>
                            <div class="divider"></div>
                                <div class="row">
                                  <div class="col s12 m4 l3">
                                    <p class="header">Datos Personales</p>
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
                                        <h4 class="header">Personal con este Sueldo</h4>
                                        <div class="row">
                                            <div class="col s12">
                                                <table id="table-simple" class="responsive-table display" cellspacing="0">
                                                    <thead>
                                                        <tr>
                                                            <th>Nombre</th>
                                                            <th>Ap. Paterno</th>
                                                            <th>Ap. Materno</th>
                                                            <th>Eliminar</th>
                                                        </tr>
                                                    </thead>
                                                    <tfoot>
                                                        <tr>
                                                            <th>Nombre</th>
                                                            <th>Ap. Paterno</th>
                                                            <th>Ap. Materno</th>
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
            verificarAcceso("Permiso_Sueldo");
            actualizarLista();
        });

        function actualizarLista(){
            //localStorage.clear();
            var table
            var parametros = {
                "action" : "listaSueldoUsuarios",
                "sueldo" : localStorage.getItem("sueldo")
            };
            $.ajax({
              type:'POST',
              data: parametros,
              url:'app/controladores/Sueldos.php',
              success:function(data){
                let datos = JSON.parse(data);

                datos = datos.data;
                if(datos.length > 0){
                    document.getElementById("lblDatos1").innerHTML = 
                    "<i class='mdi-file-folder circle'></i>"+
                    "<span class='title'>Sueldo: "+datos[0].sueldo+"</span>";

                    table = $('#table-simple').DataTable({
                        "destroy":true,
                        "data": datos,
                        "columns": [
                            {"data" : "nombre_usuario"},
                            {"data" : "appat_usuario"},
                            {"data" : "apmat_usuario"},
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
                    verificarAcceso("Permiso_Sueldo");
                    var data = table.row( $(this).parents("tr") ).data();
                    var tableRemove = $(this).parents("tr");
                    
                    var parametros = {
                       "action" : "eliminarUsuarioSueldo",
                       "cod_sueldo" : data.cod_sueldo,
                       "cod_usuario" : data.cod_usuario
                    };
                    $.ajax({
                      type:'POST',
                      data: parametros,
                      url:'app/controladores/Sueldos.php',
                      success:function(data){
                        console.log("data",data)
                          datos = JSON.parse(data);
                          if(datos.resp == "true"){
                              Materialize.toast('El Personal fue eliminado del Sueldo Satisfactoriamene', 5000);
                              table.row(tableRemove).remove().draw(false);
                          }
                          if(datos.resp == "false"){
                              Materialize.toast('Hubo un fallo al eliminar al Personal del Sueldo. Vuelva a Intentarlo', 5000)
                          }
                          if(datos.resp != "true" && datos.resp != "false"){
                              Materialize.toast('Hubo un fallo al eliminar al Personal del Sueldo COD:'+datos.resp, 5000)
                          }
                      }
                    })
                })
        }
    </script>
</body>
</html>