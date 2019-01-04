<?php
$action = '';

if (isset($_POST['action'])) {
    $action = $_POST['action'];
    switch ($action) {
        case 'pruebaAjax' :
            usuarioPrueba();
            break;
        case 'autentificacionUsuario' :
            autentificacionUsuario();
            break;
    }
}

function modelo($modelo){
    require_once '../modelos/'.$modelo.'.php';
    return new $modelo();
}

function usuarioPrueba(){
    $datos = array();
    $usuarioModelo = modelo('Usuario');
    $usuario = $usuarioModelo->usuarioPrueba($datos);
    echo json_encode($usuario);;
}

function autentificacionUsuario(){
    $usuario = $_POST['usuario'];
    $pass = $_POST['pass'];
    $datos = array($usuario, $pass);
    $usuarioModelo = modelo('Usuario');
    $usuario = $usuarioModelo->autentificacionUsuario($datos);
    echo json_encode($usuario);
}
?>