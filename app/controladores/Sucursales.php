<?php
ini_set('display_errors', '1');
ini_set('max_execution_time', 90);
session_start();
$action = '';

if (isset($_POST['action'])) {
    $action = $_POST['action'];
    switch ($action) {
        case 'listaSucursales' :
            listaSucursales();
            break;
        case 'agregarSucursal' :
            agregarSucursal();
            break;
        case 'sucursalEspecifico' :
            sucursalEspecifico();
            break;
        case 'actualizarSucursal' :
            actualizarSucursal();
            break;
        case 'listaInventarioActual' :
            listaInventarioActual();
            break;
        case 'listaInventarioVenta' :
            listaInventarioVenta();
            break;
        case 'conversionMonedaProducto' :
            conversionMonedaProducto();
            break;
            
    }
}

function modelo($modelo){
    require_once '../modelos/'.$modelo.'.php';
    return new $modelo();
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

function listaSucursales(){
    $datos = array();
    $modelo = modelo('Sucursal');
    $lista = $modelo->listaSucursales($datos);
    $data = array();
    $data = ['data' => $lista];
    echo json_encode($data);
}

function agregarSucursal(){
    $nombre = $_POST['nombre'];
    $direccion = $_POST['direccion'];
    $imagen = "sin_imagen_sucursal.jpg";
    $codigo = "";
    $datos = array();
    $modelo = modelo('Sucursal');
    $sucursal = $modelo->listaSucursales($datos);
    $cod = "";
    for($i=0 ; $i<sizeof($sucursal) ; $i++){
        $cod = $sucursal[$i]['cod_sucursal'];
    }
    $cod = substr($cod, 4);
    $cod = $cod + 1;
    if(strlen($cod) == 1){
        $codigo = "SUC-00".$cod;
    }
    if(strlen($cod) == 2){
        $codigo = "SUC-0".$cod;
    }
    if(strlen($cod) == 3){
        $codigo = "SUC-".$cod;
    }

    $data = array();
    $resp = "";

    $datos = array($codigo, $nombre, $direccion, $imagen);
    $modelo = modelo('Sucursal');
    $resp = $modelo->agregarSucursal($datos);

    $data = ['resp' => $resp];
    echo json_encode($data);
}

function sucursalEspecifico(){
    $cod_sucursal = $_POST['cod_sucursal'];
    $datos = array($cod_sucursal);
    $modelo = modelo('Sucursal');
    $lista = $modelo->sucursalEspecifico($datos);
    echo json_encode($lista);
}

function actualizarSucursal(){
    $codigo = $_POST['codigo'];
    $nombre = $_POST['nombre'];
    $direccion = $_POST['direccion'];
    $data = array();
    $resp = "";

    $datos = array($nombre,$direccion, $codigo);
    $modelo = modelo('Sucursal');
    $resp = $modelo->actualizarSucursal($datos);

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

function listaInventarioVenta(){
    $codigo = $_POST['codigo'];
    $data = array();
    $datos = array($codigo);
    $modelo = modelo('Inventario');
    $lista = $modelo->listaInventarioActualStock($datos);
    for($i = 0 ; $i < sizeof($lista) ; $i++){
        $lista[$i]["cod_item_producto"] = '#'.$lista[$i]["cod_item_producto"];
        $lista[$i]["compra_unit_producto"] = '$us '.$lista[$i]["compra_unit_producto"];
        $lista[$i]["precio_sugerido_venta"] = '$us '.$lista[$i]["precio_sugerido_venta"];
    }
    $data = ['data' => $lista];
    echo json_encode($data);
}

?>