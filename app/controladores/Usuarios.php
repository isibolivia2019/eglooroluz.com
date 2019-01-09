<?php
ini_set('display_errors', '1');
$action = '';

if (isset($_POST['action'])) {
    $action = $_POST['action'];
    switch ($action) {
        case 'autentificacionUsuario' :
            autentificacionUsuario();
            break;
        case 'listaUsuarioEstado' :
            listaUsuarioEstado();
            break;
    }
}

function modelo($modelo){
    require_once '../modelos/'.$modelo.'.php';
    return new $modelo();
}

function autentificacionUsuario(){
    $usuario = $_POST['usuario'];
    $pass = $_POST['pass'];
    $datos = array($usuario, $pass);
    $usuarioModelo = modelo('Usuario');
    $usuario = $usuarioModelo->autentificacionUsuario($datos);
    if(sizeof($usuario) > 0){
        //echo "existe";
        if($usuario[0]["estado_usuario"] == "1"){
            //echo "con estado";
            $_SESSION['tiempoAsigando'] = (60*30);//60 segundos * minutos
            $_SESSION['tiempoSession'] = time();
            $_SESSION['codigo']=$usuario[0]['cod_usuario'];
            $_SESSION['personal']=$usuario[0]['nombre_usuario']." ".$usuario[0]['appat_usuario']." ".$usuario[0]['apmat_usuario'];
        }else{
            //echo "sin estado";
        }
    }else{
        //echo "noexiste";
    }
    echo json_encode($usuario);
}

function listaUsuarioEstado(){
    $estado = $_POST['estado'];
    $datos = array($estado);
    $usuarioModelo = modelo('Usuario');
    $lista = $usuarioModelo->listaUsuarioEstado($datos);
    $data = array();
    $data = ['data' => $lista];
    echo json_encode($data);
}
?>