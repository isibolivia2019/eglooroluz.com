<?php
ini_set('display_errors', '1');
session_start();
$action = '';

if (isset($_POST['action'])) {
    $action = $_POST['action'];
    switch ($action) {
        case 'agregarTransferencia' :
            agregarTransferencia();
            break;
        case 'listaTransferencia' :
            listaTransferencia();
            break;
    }
}

function modelo($modelo){
    require_once '../modelos/'.$modelo.'.php';
    return new $modelo();
}

function listaTransferencia(){
    $origen = $_POST['origen'];
    $destino = $_POST['destino'];

    $datos = array($origen, $destino);
    $modelo = modelo('Transferencia');
    $lista = $modelo->listaTransferencia($datos);

    for($i = 0 ; $i < sizeof($lista) ; $i++){
        $lista[$i]["fecha_traspaso_producto"] = date("d/m/Y", strtotime($lista[$i]["fecha_traspaso_producto"])).' '.$lista[$i]["hora_traspaso_producto"];
        $lista[$i]["compra_unit_producto"] = '$us '.$lista[$i]["compra_unit_producto"];
        $lista[$i]["cantidad_producto"] = $lista[$i]["cantidad_producto"].' Uds.';
    }
    $data = array();
    $data = ['data' => $lista];
    echo json_encode($data);
}

function agregarTransferencia(){
    $origen = $_POST['origen'];
    $destino = $_POST['destino'];
    $codProducto = $_POST['codProducto'];
    $cantidad = $_POST['cantidad'];
    $costo = $_POST['costo'];
    $precio = $_POST['precio'];
    $observacion = $_POST['observacion'];
    $usuario = $_SESSION['codigo'];
    date_default_timezone_set('America/La_Paz');
    $hora = date("H:i:s");
    $fecha = date("Y-m-d");

    $datos = array($origen, $destino, $codProducto, $cantidad, $costo, $precio, $observacion, $fecha, $hora, $usuario);
    $modelo = modelo('Transferencia');
    $resp = $modelo->agregarTransferencia($datos);

    $datos = array($codProducto, $origen);
    $modelo = modelo('Inventario');
    $lista = $modelo->listaInventarioCodigoAlmanenamiento($datos);

    $cant = $lista[0]['cant_producto'] - $cantidad;
    $datos = array($cant, $lista[0]['cod_inventario']);
    $modelo = modelo('Inventario');
    $resp = $modelo->actualizarCantidadInventario($datos);


    $datos = array($codProducto, $destino);
    $modelo = modelo('Inventario');
    $lista = $modelo->listaInventarioCodigoAlmanenamiento($datos);
    if(sizeof($lista) > 0){
        $cant = $lista[0]['cant_producto'] + $cantidad;
        $datos = array($cant, $lista[0]['cod_inventario']);
        $modelo = modelo('Inventario');
        $resp = $modelo->actualizarCantidadInventario($datos);
    }else{
        $datos = array($cboxAlmacenamiento, $cod_producto, $cantidad, $costo, $precio);
        $modelo = modelo('Inventario');
        $resp = $modelo->agregarInventario($datos);
    }
    $data = ['resp' => $resp];
    echo json_encode($data);
}

?>