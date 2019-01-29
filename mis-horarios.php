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
                        <input id="modal" type="text" value="" style="display:none">
                    </div>
                    <div class="input-field col s12">
                        <input id="codigo" type="text" value="" style="display:none">
                    </div>
                    <div class="input-field col s12">
                        <textarea id="observacion" class="materialize-textarea"></textarea>
                        <label for="observacion">Observacion</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <div class="input-field col s6 right">
                          <a class="btn waves-effect waves-light col s12" onclick="agregarObservacion()">Agregar Observacion</a>
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
                                    <h5 class="breadcrumbs-title">Registro de Horarios</h5>
                                    <ol class="breadcrumb">
                                        <li><a href="inicio.php">Inicio</a></li>
                                        <li class="active">Mis Horarios</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="container">
                        <div class="section">
                            <p class="caption">Registro de Horarios.</p>
                            <div class="divider"></div>
                            <br>
                            <div class="divider"></div> 
                            <div id="table-datatables">
                                <h4 class="header">Horarios Entrada / Salida</h4>
                                <div class="row">
                                    <div class="col s12">
                                        <table id="table-simple" class="responsive-table display" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>Fecha</th>
                                                    <th>Entrada</th>
                                                    <th>Salida</th>
                                                    <th>Personal</th>
                                                    <th>Observacion Entrada</th>
                                                    <th>Observacion salida</th>
                                                    <th>Observacion Entrada</th>
                                                    <th>Observacion salida</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>Fecha</th>
                                                    <th>Entrada</th>
                                                    <th>Salida</th>
                                                    <th>Personal</th>
                                                    <th>Observacion Entrada</th>
                                                    <th>Observacion salida</th>
                                                    <th>Observacion Entrada</th>
                                                    <th>Observacion salida</th>
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
        var table = ""
        $(document).ready(function() {
            var parametros = {
                "action" : "listaRegistroHorarioEspecifico"
            };
            table = $('#table-simple').DataTable({
                "destroy":true,
                "ajax":{
                    "method": "POST",
                    "data":  parametros,
                    "url": "app/controladores/HuellasDactilares.php"
                },
                
                "columns": [
                    {"data" : "fecha_reg_hr"},
                    {"data" : "entrada_horario_reg_hr"},
                    {"data" : "salida_horario_reg_hr"},
                    {"data" : "personal"},
                    {"data" : "observacion_entrada"},
                    {"data" : "observacion_salida"},
                    {"defaultContent" : "<button id='boton_entrada' class='boton_entrada btn waves-effect green' type='submit' name='action'><i class='mdi-editor-border-color'></i></button>"},
                    {"defaultContent" : "<button id='boton_salida' class='boton_salida btn waves-effect light-green' type='submit' name='action'><i class='mdi-editor-border-color'></i></button>"}
                ],
                "columnDefs": [
   		        	{ "type": "date-euro", "targets": 0 }
                ],
                "order": [[ 0, "desc" ]],
                "language": {
                    "url": "public/Spanish.lang"
                }
            });
            btn_editar_entrada("#table-simple tbody", table);
            btn_editar_salida("#table-simple tbody", table);
        }); 

        var btn_editar_entrada = function(tbody, table){
                $(tbody).on("click", "button.boton_entrada", function(){
                    var data = table.row( $(this).parents("tr") ).data();
                    document.getElementById('modal').value = "entrada";
                    document.getElementById('codigo').value = data.cod_reg_hr;
                    $('#myModalForm').openModal();
                })
        }
        var btn_editar_salida = function(tbody, table){
            $(tbody).on("click", "button.boton_salida", function(){
                var data = table.row( $(this).parents("tr") ).data();
                document.getElementById('modal').value = "salida";
                document.getElementById('codigo').value = data.cod_reg_hr;
                $('#myModalForm').openModal();
            })
        }

        function agregarObservacion(){
            var modal = document.getElementById("modal").value;
            var codigo = document.getElementById("codigo").value;
            var observacion = document.getElementById("observacion").value;
            var parametros = {
               "action" : "agregarObservacion",
               "modal" : modal,      
               "observacion" : observacion,        
               "codigo" : codigo
            };
            $.ajax({
              type:'POST',
              data: parametros,
              url:'app/controladores/HuellasDactilares.php',
              success:function(data){
                  datos = JSON.parse(data);
                  if(datos.resp == "true"){
                      $('#myModalForm').closeModal();
                      table.ajax.reload();
                      document.getElementById("observacion").value = ""
                      Materialize.toast('Observacion de registro agregado correctamente', 5000)
                  }
                  if(datos.resp == "false"){
                      Materialize.toast('Hubo un fallo al agregar observacion. Vuelva a Intentarlo', 5000)
                  }
                  if(datos.resp != "true" && datos.resp != "false"){
                      Materialize.toast('Hubo un fallo al agregar observacion. COD:'+datos.resp, 5000)
                  }
              }
            })
        }
        
    </script>
</body>
</html>