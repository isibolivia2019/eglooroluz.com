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
                                    <h5 class="breadcrumbs-title">Caja Chica Agregar</h5>
                                    <ol class="breadcrumb">
                                        <li><a href="caja-chica.php">Caja Chica</a></li>
                                        <li class="active">Registrar en Caja Chica</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="container">
                        <div class="section">
                            <p class="caption">Llene el Siguiente Formulario.</p>
                            <div class="divider"></div>
                            <div class="row">
                                <form class="col s12">
                                    <div class="row">
                                        <div class="col s12 m12 l4">
                                            <label>Sucursal</label>
                                            <select class="browser-default" id="cboxSucursal">
                                                <option value="" disabled selected>Seleccione la Sucursal</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <input id="costo" type="number" step='0.01'>
                                            <label for="costo">Costo del gasto</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <input id="detalle" type="text">
                                            <label for="detalle">Detalle de gasto</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <input id="comprobante" type="text">
                                            <label for="comprobante">Comprobante</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <div class="input-field col s6 right">
                                                  <a class="btn waves-effect waves-light col s12" onclick="agregarCajaChica()">Registrar</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
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
            verificarAcceso("Permiso_CajaChica");
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

        function agregarCajaChica(){
            verificarAcceso("Permiso_CajaChica");
            var costo = document.getElementById('costo').value;
            var detalle = document.getElementById('detalle').value;
            var comprobante = document.getElementById('comprobante').value;
            var sucursal = document.getElementById("cboxSucursal").value;
            var parametros = {
               "action" : "agregarCajaChica",
               "costo" : costo,
               "detalle" : detalle,
               "comprobante" : comprobante,
               "sucursal" : sucursal,
            };
          if(sucursal != ""){
            $.ajax({
              type:'POST',
              data: parametros,
              url:'app/controladores/CajasChicas.php',
              success:function(data){
                  datos = JSON.parse(data);
                  if(datos.resp == "true"){
                      Materialize.toast('Gasto Registrado con exito', 5000)
                      document.getElementById('costo').value = "";
                      document.getElementById('detalle').value = "";
                      document.getElementById('comprobante').value = "";
                  }
                  if(datos.resp == "false"){
                      Materialize.toast('Hubo un fallo al registrar el Gasto. Vuelva a Intentarlo', 5000)
                  }
                  if(datos.resp != "true" && datos.resp != "false"){
                      Materialize.toast('Hubo un fallo al registrar el Gasto COD:'+datos.resp, 5000)
                  }
              }
            })
          } else {
                Materialize.toast("Seleccione un Sucursal", 5000)
          }
        }
    </script>
</body>
</html>