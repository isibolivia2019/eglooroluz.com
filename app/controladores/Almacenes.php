<?php
ini_set('display_errors', '1');
session_start();
$action = '';

if (isset($_POST['action'])) {
    $action = $_POST['action'];
    switch ($action) {
        case 'listaAlmacenes' :
            listaAlmacenes();
            break;
        case 'agregarAlmacen' :
            agregarAlmacen();
            break;
        case 'almacenEspecifico' :
            almacenEspecifico();
            break;
        case 'actualizarAlmacen' :
            actualizarAlmacen();
            break;
        case 'listaInventarioActual' :
            listaInventarioActual();
            break;
        case 'conversionMonedaProducto' :
            conversionMonedaProducto();
            break;
        case 'listaInventarioVenta' :
            listaInventarioVenta();
            break;
    }
}

function modelo($modelo){
    require_once '../modelos/'.$modelo.'.php';
    return new $modelo();
}

function listaInventarioVenta(){
    $codigo = $_POST['codigo'];
    $data = array();
    $datos = array($codigo);
    $modelo = modelo('Inventario');
    $lista = $modelo->listaInventarioActual($datos);
    for($i = 0 ; $i < sizeof($lista) ; $i++){
        $lista[$i]["cod_item_producto"] = '#'.$lista[$i]["cod_item_producto"];
        $lista[$i]["compra_unit_producto"] = '$us '.$lista[$i]["compra_unit_producto"];
        $lista[$i]["precio_sugerido_venta"] = '$us '.$lista[$i]["precio_sugerido_venta"];
    }



    




    $data = ['data' => $lista];
    echo json_encode($data);
}

function conversionMonedaProducto(){
    $codInventario = $_POST['codInventario'];

    $datos = array();
    $modelo = modelo('TipoCambio');
    $cambioMoneda = $modelo->TipoCambio($datos);
    $datos = array($codInventario);
    $modelo = modelo('Inventario');
    $lista = $modelo->listaInventarioEspecifico($datos);

    for($i = 0 ; $i < sizeof($lista) ; $i++){
        $lista[$i]["cod_item_producto"] = '#'.$lista[$i]["cod_item_producto"];
        $lista[$i]["cant_producto"] = $lista[$i]["cant_producto"].' Unidades.';
        $resultado = round($lista[$i]["compra_unit_producto"] * $cambioMoneda[0]['dolar'],2);
        $lista[$i]["compra_unit_producto"] = 'Bs. '.$resultado;
        $resultado = round($lista[$i]["precio_sugerido_venta"] * $cambioMoneda[0]['dolar'],2);
        $lista[$i]["precio_sugerido_venta"] = 'Bs. '.$resultado;
    }

    $data = array();
    $data = ['data' => $lista];
    echo json_encode($data);
}

function listaAlmacenes(){
    $datos = array();
    $modelo = modelo('Almacen');
    $lista = $modelo->listaAlmacenes($datos);
    $data = array();
    $data = ['data' => $lista];
    echo json_encode($data);
}

function agregarAlmacen(){
    $nombre = $_POST['nombre'];
    $direccion = $_POST['direccion'];
    $codigo = "";
    $datos = array();
    $modelo = modelo('Almacen');
    $almacen = $modelo->listaAlmacenes($datos);
    $cod = "";
    for($i=0 ; $i<sizeof($almacen) ; $i++){
        $cod = $almacen[$i]['cod_almacen'];
    }
    $cod = substr($cod, 4);
    $cod = $cod + 1;
    if(strlen($cod) == 1){
        $codigo = "ALM-00".$cod;
    }
    if(strlen($cod) == 2){
        $codigo = "ALM-0".$cod;
    }
    if(strlen($cod) == 3){
        $codigo = "ALM-".$cod;
    }

    $data = array();
    $resp = "";

    $datos = array($codigo, $nombre, $direccion);
    $modelo = modelo('Almacen');
    $resp = $modelo->agregarAlmacen($datos);

    $data = ['resp' => $resp];
    echo json_encode($data);
}

function almacenEspecifico(){
    $cod_almacen = $_POST['cod_almacen'];
    $datos = array($cod_almacen);
    $modelo = modelo('Almacen');
    $lista = $modelo->almacenEspecifico($datos);
    echo json_encode($lista);
}

function actualizarAlmacen(){
    $codigo = $_POST['codigo'];
    $nombre = $_POST['nombre'];
    $direccion = $_POST['direccion'];
    $data = array();
    $resp = "";

    $datos = array($nombre,$direccion, $codigo);
    $modelo = modelo('Almacen');
    $resp = $modelo->actualizarAlmacen($datos);

    $data = ['resp' => $resp];
    echo json_encode($data);
}

function listaInventarioActual(){
    $codigo = $_POST['codigo'];
    $data = array();
    $datos = array($codigo);
    $modelo = modelo('Inventario');
    $lista = $modelo->listaInventarioActual($datos);
    for($i = 0 ; $i < sizeof($lista) ; $i++){
        $lista[$i]["cod_item_producto"] = '#'.$lista[$i]["cod_item_producto"];
        $lista[$i]["cant_producto"] = $lista[$i]["cant_producto"].' Uds.';
        $lista[$i]["compra_unit_producto"] = '$us '.$lista[$i]["compra_unit_producto"];
        $lista[$i]["precio_sugerido_venta"] = '$us '.$lista[$i]["precio_sugerido_venta"];
    }
    $data = ['data' => $lista];
    echo json_encode($data);
}

?>