<?php
ini_set('display_errors', '1');
ini_set('max_execution_time', 60);
session_start();

function modelo($modelo){
    require_once './app/modelos/'.$modelo.'.php';
    return new $modelo();
}

$datos = array('SUC-001');
$modelo = modelo('Inventario');
$lista = $modelo->listaInventarioActual($datos);
$csi=0;
$cno=0;
$c =0;
$total = 0;
echo 'iniciando total de busqueda:'.sizeof($lista).'</br>';
for($a=0 ; $a<sizeof($lista); $a++){
    $c++;
    $total = 0;
    $codInventario = $lista[$a]['cod_inventario'];
    echo 'nro:'.$c.'->cod_inventario:'.$lista[$a]['cod_inventario'].'->cod_producto:'.$lista[$a]['cod_producto'].'->#'.$lista[$a]['cod_item_producto'].'->cantidad:'.$lista[$a]['cant_producto'];


    $datos = array($codInventario);
    $modelo = modelo('Venta');
    $listaVenta = $modelo->listaVentaEspecifica($datos);
    $j = 0;
    $total = 0;
    While ($j < sizeof($listaVenta)){
        $total = $total - $listaVenta[$j]['cant_venta_producto'];
        $j++;
    }
    
    $datos = array($codInventario);
    $modelo = modelo('Producto');
    $listaCompra = $modelo->compraProductosEspecificoCodInventario($datos);
    $j = 0;
    While ($j < sizeof($listaCompra)){
        $total = $total + $listaCompra[$j]['cantidad_compra_producto'];
        $j++;
    }

    $datos = array($codInventario);
    $modelo = modelo('Transferencia');
    $listaTransferenciaOrigen = $modelo->listaTransferenciaInventarioEspecificoOrigen($datos);
    $j = 0;
    While ($j < sizeof($listaTransferenciaOrigen)){
        $total = $total - $listaTransferenciaOrigen[$j]['cantidad_producto'];
        $j++;
    }

    $datos = array($codInventario);
    $modelo = modelo('Transferencia');
    $listaTransferenciaDestino = $modelo->listaTransferenciaInventarioEspecificoDestino($datos);
    $j = 0;
    While ($j < sizeof($listaTransferenciaDestino)){
        $total = $total + $listaTransferenciaDestino[$j]['cantidad_producto'];
        $j++;
    }

    $datos = array('1', $codInventario);
    $modelo = modelo('ProductoPerdido');
    $listaProductoPerdido = $modelo->listaPerdidos($datos);
    $j = 0;
    While ($j < sizeof($listaProductoPerdido)){
        $total = $total - $listaProductoPerdido[$j]['cant_producto'];
        $j++;
    }

    $datos = array('0', $codInventario);
    $modelo = modelo('ProductoPerdido');
    $listaProductoRecuperado = $modelo->listaPerdidosReponido($datos);
    $j = 0;
    While ($j < sizeof($listaProductoRecuperado)){
        $total = $total + $listaProductoRecuperado[$j]['cant_producto'];
        $j++;
    }

    $datos = array($codInventario);
    $modelo = modelo('CompraEliminada');
    $ListaEliminada = $modelo->listaHistorialCompraEliminada($datos);
    $j = 0;
    While ($j < sizeof($ListaEliminada)){
        $total = $total - $ListaEliminada[$j]['cantidad'];
        $j++;
    }

    $datos = array($codInventario);
    $modelo = modelo('ActualizarCantidad');
    $ListaActualizarCantidad = $modelo->listaHistorialCantidadInventario($datos);
    $j = 0;
    While ($j < sizeof($ListaActualizarCantidad)){
        $total = $total - ($total - $ListaActualizarCantidad[$j]['cantidad']);
        $j++;
    }

    $datos = array($codInventario);
    $modelo = modelo('ActualizarPrecio');
    $ListaActualizarCantidad = $modelo->listaHistorialEditarPrecioInventario($datos);
    $j = 0;
    While ($j < sizeof($ListaActualizarCantidad)){
        //$total = $total - ($total - $ListaActualizarCantidad[$j]['cantidad']);
        $j++;
    }
    echo '=='.$total;    
    
    if($total == $lista[$a]['cant_producto']){
        echo '***** SI'; 
        $csi++;
    }else{
        echo '***** NO *****************'; 
        $cno++;
    }
    echo '</br>'; 
}
echo 'fin --> total='.$c.'_correctos='.$csi.'_incorrectos='.$cno;
?>