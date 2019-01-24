<?php
ini_set('display_errors', '1');
session_start();

function modelo($modelo){
    require_once '../modelos/'.$modelo.'.php';
    return new $modelo();
}



$datos = array();
$modelo = modelo('Producto');
$listaProducto = $modelo->listaCompraProductos($datos);

for($i=0 ; $i<sizeof($listaProducto) ; $i++){
    $datos = array($listaProducto[$i]['']);
    $modelo = modelo('Inventario');
    $listaInventario = $modelo->buscarListaInventarioEspecifico($datos);
}

?>