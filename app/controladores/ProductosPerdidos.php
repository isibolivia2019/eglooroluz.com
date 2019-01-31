<?php
ini_set('display_errors', '1');
session_start();
$action = '';

if (isset($_POST['action'])) {
    $action = $_POST['action'];
    switch ($action) {
        case 'listaInventarioPerdidos' :
            listaInventarioPerdidos();
            break;
        case 'agregarProductoPerdido' :
            agregarProductoPerdido();
            break;
    }
}

function modelo($modelo){
    require_once '../modelos/'.$modelo.'.php';
    return new $modelo();
}

function agregarProductoPerdido(){
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
        $datos = array($destino, $codProducto, $cantidad, $costo, $precio);
        $modelo = modelo('Inventario');
        $resp = $modelo->agregarInventario($datos);
    }
    $data = ['resp' => $resp];
    echo json_encode($data);
}

function listaInventarioPerdidos(){
    $datos = array();
    $modelo = modelo('Sucursal');
    $listaSucursales = $modelo->listaSucursales($datos);
    $modelo = modelo('Almacen');
    $listaAlmacenes = $modelo->listaAlmacenes($datos);

    $datos = array();
    $usuarioModelo = modelo('ProductoPerdido');
    $lista = $usuarioModelo->listaInventarioPerdidos($datos);
    for($i = 0 ; $i < sizeof($lista) ; $i++){
        $lista[$i]["cod_item_producto"] = '#'.$lista[$i]["cod_item_producto"];
        $lista[$i]["cant_producto"] = $lista[$i]["cant_producto"].' Uds.';
        $lista[$i]["compra_unit_producto"] = '$us '.$lista[$i]["compra_unit_producto"];
        $lista[$i]["precio_sugerido_venta"] = '$us '.$lista[$i]["precio_sugerido_venta"];
        for($j = 0 ; $j < sizeof($listaSucursales) ; $j++){
            if($listaSucursales[$j]["cod_sucursal"] == $lista[$i]["cod_almacenamiento"]){
                $lista[$i]["cod_almacenamiento"] = $listaSucursales[$j]["nombre_sucursal"];
            }
        }
        for($k = 0 ; $k < sizeof($listaAlmacenes) ; $k++){
            if($listaAlmacenes[$k]["cod_almacen"] == $lista[$i]["cod_almacenamiento"]){
                $lista[$i]["cod_almacenamiento"] = $listaAlmacenes[$k]["nombre_almacen"];
            }
        }
    }
    $data = array();
    $data = ['data' => $lista];
    echo json_encode($data);
}

?>