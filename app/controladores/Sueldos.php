<?php
ini_set('display_errors', '1');
session_start();
$action = '';

if (isset($_POST['action'])) {
    $action = $_POST['action'];
    switch ($action) {
        case 'listaSueldos' :
            listaSueldos();
            break;
        case 'listaSueldoUsuarios' :
            listaSueldoUsuarios();
            break;
        case 'agregarSueldo' :
            agregarSueldo();
            break;
        case 'sueldoEspecifico' :
            sueldoEspecifico();
            break;
        case 'actualizarSueldo' :
            actualizarSueldo();
            break;
        case 'eliminarSueldo' :
            eliminarSueldo();
            break;
        case 'eliminarUsuarioSueldo' :
            eliminarUsuarioSueldo();
            break;
        case 'asignarUsuarioSueldo' :
            asignarUsuarioSueldo();
            break;
    }
}

function modelo($modelo){
    require_once '../modelos/'.$modelo.'.php';
    return new $modelo();
}

function listaSueldos(){
    $datos = array();
    $usuarioModelo = modelo('Sueldo');
    $lista = $usuarioModelo->listaSueldos($datos);
    $data = array();
    for($i = 0 ; $i < sizeof($lista) ; $i++){
        $lista[$i]["sueldo"] = "Bs. ".$lista[$i]["sueldo"];
    }
    $data = ['data' => $lista];
    echo json_encode($data);
}

function listaSueldoUsuarios(){
    $sueldo = $_POST['sueldo'];
    $datos = array($sueldo);
    $modelo = modelo('Sueldo');
    $lista = $modelo->listaSueldoUsuarios($datos);
    for($i = 0 ; $i < sizeof($lista) ; $i++){
        $lista[$i]["sueldo"] = "Bs. ".$lista[$i]["sueldo"];
    }
    $data = array();
    $data = ['data' => $lista];
    echo json_encode($data);
}

function eliminarSueldo(){
    $cod_sueldo = $_POST['cod_sueldo'];
    $datos = array($cod_sueldo);
    $modelo = modelo('Sueldo');
    $resp = $modelo->eliminarSueldo($datos);
    $resp = $modelo->eliminarSueldoUsuario($datos);

    $data = ['resp' => $resp];
    echo json_encode($data);
}

function eliminarUsuarioSueldo(){
    $cod_sueldo = $_POST['cod_sueldo'];
    $cod_usuario = $_POST['cod_usuario'];
    $datos = array($cod_sueldo, $cod_usuario);
    $modelo = modelo('Sueldo');
    $resp = $modelo->eliminarUsuarioSueldo($datos);

    $data = ['resp' => $resp];
    echo json_encode($data);
}

function sueldoEspecifico(){
    $cod_sueldo = $_POST['cod_sueldo'];
    $datos = array($cod_sueldo);
    $modelo = modelo('Sueldo');
    $lista = $modelo->sueldoEspecifico($datos);
    echo json_encode($lista);
}

function asignarUsuarioSueldo(){
    $sueldo = $_POST['sueldo'];
    $usuario = $_POST['usuario'];
    $data = array();
    $resp = "";

    $datos = array($sueldo, $usuario);
    $modelo = modelo('Sueldo');
    $lista = $modelo->verificarSueldoUsuario($datos);
    if(sizeof($lista) == 0){
        $datos = array($sueldo, $usuario);
        $modelo = modelo('Sueldo');
        $resp = $modelo->agregarSueldoUsuario($datos);
    }else{
        $resp = "false";
    }

    $data = ['resp' => $resp];
    echo json_encode($data);
}

function agregarSueldo(){
    $sueldo = $_POST['sueldo'];
    
    $data = array();
    $resp = "";

    $datos = array($sueldo);
    $modelo = modelo('Sueldo');
    $resp = $modelo->agregarSueldo($datos);

    $data = ['resp' => $resp];
    echo json_encode($data);
}

function actualizarSueldo(){
    $codigo = $_POST['codigo'];
    $sueldo = $_POST['sueldo'];
    
    $data = array();
    $resp = "";

    $datos = array($sueldo, $codigo);
    $modelo = modelo('Sueldo');
    $resp = $modelo->actualizarSueldo($datos);

    $data = ['resp' => $resp];
    echo json_encode($data);
}
?>