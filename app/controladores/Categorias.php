<?php
ini_set('display_errors', '1');
session_start();
$action = '';

if (isset($_POST['action'])) {
    $action = $_POST['action'];
    switch ($action) {
        case 'listaCategorias' :
            listaCategorias();
            break;
    }
}

function modelo($modelo){
    require_once '../modelos/'.$modelo.'.php';
    return new $modelo();
}

function listaCategorias(){
    $datos = array();
    $modelo = modelo('Categoria');
    $lista = $modelo->listaCategorias($datos);
    $data = array();
    $data = ['data' => $lista];
    echo json_encode($data);
}

?>