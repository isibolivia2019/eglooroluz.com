<?php
ini_set('display_errors', '1');
session_start();
$action = '';

if (isset($_POST['action'])) {
    $action = $_POST['action'];
    switch ($action) {
        case 'convertirBolivianos' :
            convertirBolivianos();
            break;
    }
}

function modelo($modelo){
    require_once '../modelos/'.$modelo.'.php';
    return new $modelo();
}

function convertirBolivianos(){
    $moneda = $_POST['moneda'];

    $datos = array();
    $modelo = modelo('TipoCambio');
    $cambioMoneda = $modelo->TipoCambio($datos);
    $resp = round($moneda * $cambioMoneda[0]['dolar'], 2);

    $data = ['data' => $resp];
    echo json_encode($data);
}

?>