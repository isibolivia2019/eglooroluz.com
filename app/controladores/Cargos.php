<?php
ini_set('display_errors', '1');
session_start();
$action = '';

if (isset($_POST['action'])) {
    $action = $_POST['action'];
    switch ($action) {
        case 'listaCargos' :
            listaCargos();
            break;
        case 'listaCargoUsuarios' :
            listaCargoUsuarios();
            break;
        case 'eliminarUsuarioCargo' :
            eliminarUsuarioCargo();
            break;
        case 'cargoEspecifico' :
            cargoEspecifico();
            break;
        case 'actualizarCargo' :
            actualizarCargo();
            break;
        case 'eliminarCargo' :
            eliminarCargo();
            break;
        case 'agregarCargo' :
            agregarCargo();
            break;
        case 'asignarUsuarioCargo' :
            asignarUsuarioCargo();
            break;
    }
}

function modelo($modelo){
    require_once '../modelos/'.$modelo.'.php';
    return new $modelo();
}

function asignarUsuarioCargo(){
    $cargo = $_POST['cargo'];
    $usuario = $_POST['usuario'];
    
    $data = array();
    $resp = "";

    $datos = array($cargo, $usuario);
    $modelo = modelo('Cargo');
    $resp = $modelo->agregarCargoUsuario($datos);


    $data = ['resp' => $resp];
    echo json_encode($data);
}

function agregarCargo(){
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $data = array();
    $resp = "";

    $datos = array($nombre, $descripcion);
    $modelo = modelo('Cargo');
    $resp = $modelo->agregarCargo($datos);

    $data = ['resp' => $resp];
    echo json_encode($data);
}

function listaCargos(){
    $datos = array();
    $usuarioModelo = modelo('Cargo');
    $lista = $usuarioModelo->listaCargos($datos);
    $data = array();
    $data = ['data' => $lista];
    echo json_encode($data);
}

function listaCargoUsuarios(){
    $cargo = $_POST['cargo'];
    $datos = array($cargo);
    $modelo = modelo('Cargo');
    $lista = $modelo->listaCargoUsuarios($datos);
    $data = array();
    $data = ['data' => $lista];
    echo json_encode($data);
}

function eliminarUsuarioCargo(){
    $cod_usuario = $_POST['cod_usuario'];
    $datos = array("1", $cod_usuario);
    $modelo = modelo('Cargo');
    $resp = $modelo->eliminarUsuarioCargo($datos);

    $data = ['resp' => $resp];
    echo json_encode($data);
}

function cargoEspecifico(){
    $cod_cargo = $_POST['cod_cargo'];
    $datos = array($cod_cargo);
    $modelo = modelo('Cargo');
    $lista = $modelo->cargoEspecifico($datos);
    echo json_encode($lista);
}

function actualizarCargo(){
    $codigo = $_POST['codigo'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $data = array();
    $resp = "";

    $datos = array($nombre, $descripcion, $codigo);
    $modelo = modelo('Cargo');
    $resp = $modelo->actualizarCargo($datos);

    $data = ['resp' => $resp];
    echo json_encode($data);
}

function eliminarCargo(){
    $cod_cargo = $_POST['cod_cargo'];
    
    $datos = array("1", $cod_cargo);
    $modelo = modelo('Cargo');
    $resp = $modelo->eliminarCargoUsuario($datos);
    $datos = array($cod_cargo);
    $resp = $modelo->eliminarCargo($datos);
    

    $data = ['resp' => $resp];
    echo json_encode($data);
}

?>