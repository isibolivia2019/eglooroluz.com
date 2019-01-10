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
    }
}

function modelo($modelo){
    require_once '../modelos/'.$modelo.'.php';
    return new $modelo();
}

function listaCargos(){
    $datos = array();
    $usuarioModelo = modelo('Cargo');
    $lista = $usuarioModelo->listaCargos($datos);
    $data = array();
    $data = ['data' => $lista];
    echo json_encode($data);
}

?>