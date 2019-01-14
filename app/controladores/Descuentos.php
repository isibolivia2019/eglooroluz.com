<?php
ini_set('display_errors', '1');
session_start();
$action = '';

if (isset($_POST['action'])) {
    $action = $_POST['action'];
    switch ($action) {
        case 'listaDescuentos' :
            listaDescuentos();
            break;
    }
}

function modelo($modelo){
    require_once '../modelos/'.$modelo.'.php';
    return new $modelo();
}

function listaDescuentos(){
    $datos = array();
    $modelo = modelo('Descuento');
    $lista = $modelo->listaDescuentos($datos);
    $data = array();
    $data = ['data' => $lista];
    echo json_encode($data);
}

?>