<?php
ini_set('display_errors', '1');
ini_set('max_execution_time', 120);
session_start();

function modelo($modelo){
    require_once './app/modelos/'.$modelo.'.php';
    return new $modelo();
}
echo 'ejecutando funcion';
$datos = array();
$modelo = modelo('Transferencia');
$listaProducto = $modelo->listaTrans($datos);
$c = 0;
for($i=0 ; $i<sizeof($listaProducto) ; $i++){
    $c++;
        $datos = array($listaProducto[$i]['cod_producto'], $listaProducto[$i]['compra_unit_producto'], $listaProducto[$i]['precio_sugerido_venta'], $listaProducto[$i]['cod_almacenamiento_de']);
        $modelo = modelo('Inventario');
        $listaInventario = $modelo->buscarListaInventarioEspecifico($datos);

        if(sizeof($listaInventario) > 0){
            $datos = array($listaInventario[0]['cod_inventario'], $listaProducto[$i]['cod_traspaso_producto']);
            $modelo = modelo('Transferencia');
            $res = $modelo->actualizaCodInventarioDe($datos);
        }

        $datos = array($listaProducto[$i]['cod_producto'], $listaProducto[$i]['compra_unit_producto'], $listaProducto[$i]['precio_sugerido_venta'], $listaProducto[$i]['cod_almacenamiento_a']);
        $modelo = modelo('Inventario');
        $listaInventario = $modelo->buscarListaInventarioEspecifico($datos);
        if(sizeof($listaInventario) > 0){
            $datos = array($listaInventario[0]['cod_inventario'], $listaProducto[$i]['cod_traspaso_producto']);
            $modelo = modelo('Transferencia');
            $res = $modelo->actualizaCodInventarioA($datos);
        }
}
echo 'fin de la funcion c='.$c;

?>