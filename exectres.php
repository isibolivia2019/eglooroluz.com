<?php
ini_set('display_errors', '1');
session_start();

function modelo($modelo){
    require_once './app/modelos/'.$modelo.'.php';
    return new $modelo();
}
echo 'ejecutando funcion</br>';
$datos = array();
$modelo = modelo('Transferencia');
$listaProducto = $modelo->listaTransDestinoNull($datos);
$c = 0;
for($i=0 ; $i<sizeof($listaProducto) ; $i++){
 
        $c++;
        $datos = array($listaProducto[$i]['cod_producto'], $listaProducto[$i]['cod_almacenamiento_a']);
        $modelo = modelo('Inventario');
        $listaInventario = $modelo->listaInventarioCodigoAlmacenamiento($datos);

        if(sizeof($listaInventario) == 0){
            $datos = array($listaInventario[0]['cod_inventario'], $listaProducto[$i]['cod_traspaso_producto']);
            $modelo = modelo('Transferencia');
            $res = $modelo->actualizaCodInventarioA($datos);
        }

}
echo 'fin de la funcion c='.$c;

?>