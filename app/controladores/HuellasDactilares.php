<?php
ini_set('display_errors', '1');
session_start();
$action = '';

if (isset($_POST['action'])) {
    $action = $_POST['action'];
    switch ($action) {
        case 'registrarEntradaSalida' :
            registrarEntradaSalida();
            break;
        case 'registrarInicioSoftware' :
            registrarInicioSoftware();
            break;
        case 'registrarFinSoftware' :
            registrarFinSoftware();
            break;
    }
}

function modelo($modelo){
    require_once '../modelos/'.$modelo.'.php';
    return new $modelo();
}

function registrarInicioSoftware(){
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];
    $computadora = $_POST['computadora'];
    $datos = array($fecha, $hora, $computadora);
    $modelo = modelo('HuellaDactilar');
    $lista = $modelo->inicioSoftware($datos);
}

function registrarFinSoftware(){
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];
    $computadora = $_POST['computadora'];
    $datos = array($fecha, $hora, $computadora);
    $modelo = modelo('HuellaDactilar');
    $lista = $modelo->finSoftware($datos);
}

function registrarEntradaSalida(){
    $action = $_POST['action'];
    $action = $_POST['action'];
    $datos = array();
    $usuarioModelo = modelo('Cargo');
    $lista = $usuarioModelo->listaCargos($datos);
    $data = array();
    $data = ['data' => $lista];
    echo json_encode($data);
}
?>