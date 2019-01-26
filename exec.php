<?php
ini_set('display_errors', '1');
session_start();

function modelo($modelo){
    require_once './app/modelos/'.$modelo.'.php';
    return new $modelo();
}
echo 'ejecutando funcion';
$datos = array();
$modelo = modelo('Producto');
$listaProducto = $modelo->listaCompraProductos($datos);
$c = 0;
for($i=0 ; $i<sizeof($listaProducto) ; $i++){
    if($listaProducto[$i]['cod_inventario'] == ""){
        $c++;
        $datos = array($listaProducto[$i]['cod_producto'], $listaProducto[$i]['precio_unit_compra_producto'], $listaProducto[$i]['precio_sugerido_venta'], $listaProducto[$i]['cod_almacenamiento']);
        $modelo = modelo('Inventario');
        $listaInventario = $modelo->buscarListaInventarioEspecifico($datos);

        if(sizeof($listaInventario) > 0){
            $datos = array($listaInventario[0]['cod_inventario'], $listaProducto[$i]['cod_compra_producto']);
            $modelo = modelo('Producto');
            $res = $modelo->actualizaCodInventarioCompraProducto($datos);
        }
    }
}
echo 'fin de la funcion c='.$c;

?>