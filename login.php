<?php
ini_set('display_errors', '1');
session_start();
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="msapplication-tap-highlight" content="no">
    <meta name="description" content="Inicio de Sesion del Sistema Importadora ORO LUZ">
    <meta name="keywords" content="login, inicio, sesion, inicio de sesion, inicio sesion, ingresar, oro luz, oroluz, eglooroluz, eglo login, oro luz, login, importadora oro luz login,">
    <title>Inicio de Sesion</title>

    <!-- Favicons-->
    <link rel="icon" href="public/imagenes/sistema/favicon.jpg" sizes="32x32">
    <!-- Favicons-->
    <link rel="apple-touch-icon-precomposed" href="public/imagenes/sistema/favicon119.jpg">
    <!-- For iPhone -->
    <meta name="msapplication-TileColor" content="#00bcd4">
    <meta name="msapplication-TileImage" content="public/imagenes/sistema/favicon119.jpg">
    <!-- For Windows Phone -->


    <!-- CORE CSS-->
  
    <link href="public/css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection">
    <link href="public/css/style.css" type="text/css" rel="stylesheet" media="screen,projection">
    <link href="public/css/page-center.css" type="text/css" rel="stylesheet" media="screen,projection">

    <!-- INCLUDED PLUGIN CSS ON THIS PAGE -->
    <link href="public/css/prism.css" type="text/css" rel="stylesheet" media="screen,projection">
    <link href="public/js/plugins/perfect-scrollbar/perfect-scrollbar.css" type="text/css" rel="stylesheet" media="screen,projection">
  
</head>

<body class="cyan">
  <!-- Start Page Loading -->
  <div id="loader-wrapper">
      <div id="loader"></div>        
      <div class="loader-section section-left"></div>
      <div class="loader-section section-right"></div>
  </div>
  <!-- End Page Loading -->

  <div id="login-page" class="row">
    <div class="col s12 z-depth-4 card-panel">
      <form class="login-form" method="post">
        <div class="row">
          <div class="input-field col s12 center">
            <img src="public/imagenes/sistema/oroluz.gif" width="350px">
            <p class="center login-form-text">Inicio de Sesion</p>
          </div>
        </div>
        <div class="row margin">
          <div class="input-field col s12">
            <i class="mdi-social-person-outline prefix"></i>
            <input type="text" id="usuario" name="usuario">
            <label for="usuario" class="center-align">Usuario</label>
          </div>
        </div>
        <div class="row margin">
          <div class="input-field col s12">
            <i class="mdi-action-lock-outline prefix"></i>
            <input id="pass" name="pass" type="password">
            <label for="pass">Contraseña</label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s12">
            <a class="btn waves-effect waves-light col s12" onclick="autentificacion()">INICIAR SESION</a>
          </div>
        </div>
      </form>
    </div>
  </div>



  <!-- ================================================
    Scripts
    ================================================ -->

  <script>
  function autentificacion(){
    var usuario = document.getElementById('usuario').value;
    var pass = document.getElementById('pass').value;
    if(usuario != ""){
      if(pass != ""){
        var parametros = {
           "action" : "autentificacionUsuario",
           "usuario" : usuario,
           "pass" : pass
        };
        $.ajax({
          type:'POST',
          data: parametros,
          url:'app/controladores/Usuarios.php',
          success:function(data){
            $datos = JSON.parse(data);
            if($datos.length > 0){
              if($datos[0].estado_usuario == "1"){
                location.href = "inicio.php";
              }else{
                document.getElementById('pass').value = ""
                Materialize.toast('Usuario Bloqueado para el Uso del Sistema.', 5000)
              }

            }else{
              document.getElementById('pass').value = ""
              Materialize.toast('Usuario y/o Contraseña Incorrectos.', 5000)
            }
          }
        })
      }else{
        Materialize.toast('Ingrese su Contraseña porfavor.', 5000)
      }
    }else{
      Materialize.toast('Ingrese su Usuario porfavor.', 5000)
    }
  }
  </script>
  <!-- jQuery Library -->
  <script type="text/javascript" src="public/js/jquery-1.11.2.min.js"></script>
  <!--materialize js-->
  <script type="text/javascript" src="public/js/materialize.js"></script>
  <!--prism-->
  <script type="text/javascript" src="public/js/prism.js"></script>
  <!--scrollbar-->
  <script type="text/javascript" src="public/js/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>

  <!--plugins.js - Some Specific JS codes for Plugin Settings-->
  <script type="text/javascript" src="public/js/plugins.js"></script>

</body>

</html>