<?php
ini_set('display_errors', '1');
session_start();

function modelo($modelo){
    require_once './app/modelos/'.$modelo.'.php';
    return new $modelo();
}
echo 'ejecutando funcion';
$datos = array();
$modelo = modelo('ProductoPerdido');
$listaProducto = $modelo->listaProductoPerdidosReg($datos);
$c = 0;
for($i=0 ; $i<sizeof($listaProducto) ; $i++){

        $c++;
        $datos = array($listaProducto[$i]['cod_producto'], $listaProducto[$i]['compra_unit_producto'], $listaProducto[$i]['precio_sugerido_venta'], $listaProducto[$i]['cod_almacenamiento']);
        $modelo = modelo('Inventario');
        $listaInventario = $modelo->buscarListaInventarioEspecifico($datos);

        if(sizeof($listaInventario) > 0){
            $datos = array($listaInventario[0]['cod_inventario'], $listaProducto[$i]['cod_producto_perdido_reg']);
            $modelo = modelo('ProductoPerdido');
            $res = $modelo->actualizaCodInventarioProductoPerdidosReg($datos);
        }

}
echo 'fin de la funcion c='.$c;

?>