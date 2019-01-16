<?php
ini_set('display_errors', '1');
session_start();
$action = '';

if (isset($_POST['action'])) {
    $action = $_POST['action'];
    switch ($action) {
        case 'asignarUsuarioSucursal' :
            asignarUsuarioSucursal();
            break;
        case 'asignarUsuarioAlmacen' :
            asignarUsuarioAlmacen();
            break;
        case 'listaAccesosSucursales' :
            listaAccesosSucursales();
            break;
        case 'listaAccesosAlmacenes' :
            listaAccesosAlmacenes();
            break;
    }
}

function modelo($modelo){
    require_once '../modelos/'.$modelo.'.php';
    return new $modelo();
}

function listaAccesosSucursales(){
    $usuario = $_SESSION['codigo'];
    $datos = array($usuario);
    $modelo = modelo('Acceso');
    $lista = $modelo->listaAccesosSucursales($datos);
    $data = array();
    $data = ['data' => $lista];
    echo json_encode($data);
}

function listaAccesosAlmacenes(){
    $usuario = $_SESSION['codigo'];
    $datos = array($usuario);
    $modelo = modelo('Acceso');
    $lista = $modelo->listaAccesosAlmacenes($datos);
    $data = array();
    $data = ['data' => $lista];
    echo json_encode($data);
}

function asignarUsuarioAlmacen(){
    $almacen = $_POST['almacen'];
    $usuario = $_POST['usuario'];
    $data = array();

    $datos = array($usuario, $almacen);
    $modelo = modelo('Acceso');
    $lista = $modelo->verificarUsuarioAlmacen($datos);

    if(sizeof($lista) == 0){
        $datos = array($usuario, $almacen);
        $modelo = modelo('Acceso');
        $resp = $modelo->asignarUsuarioAlmacen($datos);
    }else{
        $resp = "false";
    }

    $data = ['resp' => $resp];
    echo json_encode($data);
}

function asignarUsuarioSucursal(){
    $sucursal = $_POST['sucursal'];
    $usuario = $_POST['usuario'];
    $data = array();

    $datos = array($usuario, $sucursal);
    $modelo = modelo('Acceso');
    $lista = $modelo->verificarUsuarioSucursal($datos);

    if(sizeof($lista) == 0){
        $datos = array($usuario, $sucursal);
        $modelo = modelo('Acceso');
        $resp = $modelo->asignarUsuarioSucursal($datos);
    }else{
        $resp = "false";
    }

    $data = ['resp' => $resp];
    echo json_encode($data);
}

?>