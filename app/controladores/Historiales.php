<?php
ini_set('display_errors', '1');
session_start();
$action = '';

if (isset($_POST['action'])) {
    $action = $_POST['action'];
    switch ($action) {
        case 'listaInventarioEspecifico' :
            listaInventarioEspecifico();
            break;
        case 'listaHistorial' :
            listaHistorial();
            break;
    }
}

function modelo($modelo){
    require_once '../modelos/'.$modelo.'.php';
    return new $modelo();
}

function listaInventarioEspecifico(){
    $codInventario = $_POST['codInventario'];
    $datos = array($codInventario);
    $modelo = modelo('Inventario');
    $lista = $modelo->listaInventarioEspecifico($datos);
    $data = array();
    $data = ['data' => $lista];
    echo json_encode($data);
}

function listaHistorial(){
    $lista = [];
    $i = 0;
    $codInventario = $_POST['codInventario'];

    $datos = array();
    $modelo = modelo('Sucursal');
    $listaSucursales = $modelo->listaSucursales($datos);
    $modelo = modelo('Almacen');
    $listaAlmacenes = $modelo->listaAlmacenes($datos);

    $datos = array($codInventario);
    $modelo = modelo('Inventario');
    $producto = $modelo->listaInventarioEspecifico($datos);
    
    $datos = array($codInventario);
    $modelo = modelo('Venta');
    $listaVenta = $modelo->listaVentaEspecifica($datos);
    $j = 0;
    $total = 0;
    While ($j < sizeof($listaVenta)){
        $lista[$i]['fecha_hora'] = date("d/m/Y", strtotime($listaVenta[$j]["fecha_venta_producto"]))." ".$listaVenta[$j]["hora_venta_producto"];
        $lista[$i]['personal'] = $listaVenta[$j]['personal'];
        $lista[$i]['cantidad'] = '- '.$listaVenta[$j]['cant_venta_producto'].' Uds.';
        $lista[$i]['observacion'] = '';
        $lista[$i]['evento'] = 'Venta';
        $lista[$i]['cod_item_producto'] = '#'.$listaVenta[$j]['cod_item_producto'];
        $total = $total - $listaVenta[$j]['cant_venta_producto'];
        $lista[$i]['total'] = $total;
        $i++;
        $j++;
    }
    
    $datos = array($codInventario);
    $modelo = modelo('Producto');
    $listaCompra = $modelo->compraProductosEspecificoCodInventario($datos);
    $j = 0;
    While ($j < sizeof($listaCompra)){
        $lista[$i]['fecha_hora'] = date("d/m/Y", strtotime($listaCompra[$j]["fecha_compra_producto"]))." ".$listaCompra[$j]["hora_compra_producto"];
        $lista[$i]['personal'] = $listaCompra[$j]['personal'];
        $lista[$i]['cantidad'] = '+ '.$listaCompra[$j]['cantidad_compra_producto'].' Uds.';
        $lista[$i]['observacion'] = $listaCompra[$j]['observacion_compra_producto'];
        $lista[$i]['evento'] = 'Compra';
        $lista[$i]['cod_item_producto'] = '#'.$listaCompra[$j]['cod_item_producto'];
        $total = $total + $listaCompra[$j]['cantidad_compra_producto'];
        $lista[$i]['total'] = $total;
        $i++;
        $j++;
    }

    $datos = array($codInventario);
    $modelo = modelo('Transferencia');
    $listaTransferenciaOrigen = $modelo->listaTransferenciaInventarioEspecificoOrigen($datos);
    $j = 0;
    While ($j < sizeof($listaTransferenciaOrigen)){
        for($l = 0 ; $l < sizeof($listaSucursales) ; $l++){
            if($listaSucursales[$l]["cod_sucursal"] == $listaTransferenciaOrigen[$j]['cod_almacenamiento_a']){
                $listaTransferenciaOrigen[$j]['cod_almacenamiento_a'] = $listaSucursales[$l]["nombre_sucursal"];
            }
        }
        for($k = 0 ; $k < sizeof($listaAlmacenes) ; $k++){
            if($listaAlmacenes[$k]["cod_almacen"] == $listaTransferenciaOrigen[$j]['cod_almacenamiento_a']){
                $listaTransferenciaOrigen[$j]['cod_almacenamiento_a'] = $listaAlmacenes[$k]["nombre_almacen"];
            }
        }
        $lista[$i]['fecha_hora'] = date("d/m/Y", strtotime($listaTransferenciaOrigen[$j]["fecha_traspaso_producto"]))." ".$listaTransferenciaOrigen[$j]["hora_traspaso_producto"];
        $lista[$i]['personal'] = $listaTransferenciaOrigen[$j]['personal'];
        $lista[$i]['cantidad'] = '- '.$listaTransferenciaOrigen[$j]['cantidad_producto'].' Uds.';
        $lista[$i]['observacion'] = $listaTransferenciaOrigen[$j]['observacion_traspaso_producto'];
        $lista[$i]['evento'] = 'Transferencia ENVIADA a: '.$listaTransferenciaOrigen[$j]['cod_almacenamiento_a'];
        $lista[$i]['cod_item_producto'] = '#'.$listaTransferenciaOrigen[$j]['cod_item_producto'];
        $total = $total - $listaTransferenciaOrigen[$j]['cantidad_producto'];
        $lista[$i]['total'] = $total;
        $i++;
        $j++;
    }

    $datos = array($codInventario);
    $modelo = modelo('Transferencia');
    $listaTransferenciaDestino = $modelo->listaTransferenciaInventarioEspecificoDestino($datos);
    $j = 0;
    While ($j < sizeof($listaTransferenciaDestino)){
        for($l = 0 ; $l < sizeof($listaSucursales) ; $l++){
            if($listaSucursales[$l]["cod_sucursal"] == $listaTransferenciaDestino[$j]['cod_almacenamiento_de']){
                $listaTransferenciaDestino[$j]['cod_almacenamiento_de'] = $listaSucursales[$l]["nombre_sucursal"];
            }
        }
        for($k = 0 ; $k < sizeof($listaAlmacenes) ; $k++){
            if($listaAlmacenes[$k]["cod_almacen"] == $listaTransferenciaDestino[$j]['cod_almacenamiento_de']){
                $listaTransferenciaDestino[$j]['cod_almacenamiento_de'] = $listaAlmacenes[$k]["nombre_almacen"];
            }
        }
        $lista[$i]['fecha_hora'] = date("d/m/Y", strtotime($listaTransferenciaDestino[$j]["fecha_traspaso_producto"]))." ".$listaTransferenciaDestino[$j]["hora_traspaso_producto"];
        $lista[$i]['personal'] = $listaTransferenciaDestino[$j]['personal'];
        $lista[$i]['cantidad'] = '+ '.$listaTransferenciaDestino[$j]['cantidad_producto'].' Uds.';
        $lista[$i]['observacion'] = $listaTransferenciaDestino[$j]['observacion_traspaso_producto'];
        $lista[$i]['evento'] = 'Transferencia RECIBIDA de: '.$listaTransferenciaDestino[$j]['cod_almacenamiento_de'];
        $lista[$i]['cod_item_producto'] = '#'.$listaTransferenciaDestino[$j]['cod_item_producto'];
        $total = $total + $listaTransferenciaDestino[$j]['cantidad_producto'];
        $lista[$i]['total'] = $total;
        $i++;
        $j++;
    }

    $datos = array($producto[0]['cod_producto'], $producto[0]['compra_unit_producto'], $producto[0]['precio_sugerido_venta'], $producto[0]['cod_almacenamiento']);
    $modelo = modelo('ProductoPerdido');
    $listaProductoPerdido = $modelo->listaPerdidos($datos);
    $j = 0;
    While ($j < sizeof($listaProductoPerdido)){
        for($l = 0 ; $l < sizeof($listaSucursales) ; $l++){
            if($listaSucursales[$l]["cod_sucursal"] == $listaProductoPerdido[$j]['cod_almacenamiento']){
                $listaProductoPerdido[$j]['cod_almacenamiento'] = $listaSucursales[$l]["nombre_sucursal"];
            }
        }
        for($k = 0 ; $k < sizeof($listaAlmacenes) ; $k++){
            if($listaAlmacenes[$k]["cod_almacen"] == $listaProductoPerdido[$j]['cod_almacenamiento']){
                $listaProductoPerdido[$j]['cod_almacenamiento'] = $listaAlmacenes[$k]["nombre_almacen"];
            }
        }
        $lista[$i]['fecha_hora'] = date("d/m/Y", strtotime($listaProductoPerdido[$j]["fecha_producto_perdido"]))." ".$listaProductoPerdido[$j]["hora_producto_perdido"];
        $lista[$i]['personal'] = $listaProductoPerdido[$j]['personal'];
        $lista[$i]['cantidad'] = '- '.$listaProductoPerdido[$j]['cant_producto'].' Uds.';
        $lista[$i]['observacion'] = $listaProductoPerdido[$j]['observacion_producto_perdido'];
        $lista[$i]['evento'] = 'PRODUCTO PERDIDO EN '.$listaProductoPerdido[$j]['cod_almacenamiento'];
        $lista[$i]['cod_item_producto'] = '#'.$listaProductoPerdido[$j]['cod_item_producto'];
        $total = $total - $listaProductoPerdido[$j]['cant_producto'];
        $lista[$i]['total'] = $total;
        $i++;
        $j++;
    }

    $datos = array($producto[0]['cod_producto'], $producto[0]['compra_unit_producto'], $producto[0]['precio_sugerido_venta'], $producto[0]['cod_almacenamiento']);
    $modelo = modelo('ProductoPerdido');
    $listaProductoRecuperado = $modelo->listaPerdidosReponido($datos);
    $j = 0;
    While ($j < sizeof($listaProductoRecuperado)){
        for($l = 0 ; $l < sizeof($listaSucursales) ; $l++){
            if($listaSucursales[$l]["cod_sucursal"] == $listaProductoRecuperado[$j]['cod_almacenamiento']){
                $listaProductoRecuperado[$j]['cod_almacenamiento'] = $listaSucursales[$l]["nombre_sucursal"];
            }
        }
        for($k = 0 ; $k < sizeof($listaAlmacenes) ; $k++){
            if($listaAlmacenes[$k]["cod_almacen"] == $listaProductoRecuperado[$j]['cod_almacenamiento']){
                $listaProductoRecuperado[$j]['cod_almacenamiento'] = $listaAlmacenes[$k]["nombre_almacen"];
            }
        }
        $lista[$i]['fecha_hora'] = date("d/m/Y", strtotime($listaProductoRecuperado[$j]["fecha_producto_perdido"]))." ".$listaProductoPerdido[$j]["hora_producto_perdido"];
        $lista[$i]['personal'] = $listaProductoRecuperado[$j]['personal'];
        $lista[$i]['cantidad'] = '+ '.$listaProductoRecuperado[$j]['cant_producto'].' Uds.';
        $lista[$i]['observacion'] = $listaProductoRecuperado[$j]['observacion_producto_perdido'];
        $lista[$i]['evento'] = 'PRODUCTO PERDIDO RECUPERADO EN '.$listaProductoRecuperado[$j]['cod_almacenamiento'];
        $lista[$i]['cod_item_producto'] = '#'.$listaProductoRecuperado[$j]['cod_item_producto'];
        $total = $total + $listaProductoRecuperado[$j]['cant_producto'];
        $lista[$i]['total'] = $total;
        $i++;
        $j++;
    }

    $datos = array($codInventario);
    $modelo = modelo('CompraEliminada');
    $ListaEliminada = $modelo->listaHistorialCompraEliminada($datos);
    $j = 0;
    While ($j < sizeof($ListaEliminada)){
        $lista[$i]['fecha_hora'] = date("d/m/Y", strtotime($ListaEliminada[$j]["fecha"]))." ".$ListaEliminada[$j]["hora"];
        $lista[$i]['personal'] = $ListaEliminada[$j]['personal'];
        $lista[$i]['cantidad'] = '- '.$ListaEliminada[$j]['cantidad'].' Uds.';
        $lista[$i]['observacion'] = $ListaEliminada[$j]['observacion'];
        $lista[$i]['evento'] = 'ORDEN DE COMPRA ELIMINADO';
        $lista[$i]['cod_item_producto'] = '#'.$ListaEliminada[$j]['cod_item_producto'];
        $total = $total - $ListaEliminada[$j]['cantidad'];
        $lista[$i]['total'] = $total;
        $i++;
        $j++;
    }

    $datos = array($codInventario);
    $modelo = modelo('ActualizarCantidad');
    $ListaActualizarCantidad = $modelo->listaHistorialCantidadInventario($datos);
    $j = 0;
    While ($j < sizeof($ListaActualizarCantidad)){
        $lista[$i]['fecha_hora'] = date("d/m/Y", strtotime($ListaActualizarCantidad[$j]["fecha"]))." ".$ListaActualizarCantidad[$j]["hora"];
        $lista[$i]['personal'] = $ListaActualizarCantidad[$j]['personal'];
        $lista[$i]['cantidad'] = $ListaActualizarCantidad[$j]['cantidad'].' Uds.';
        $lista[$i]['observacion'] = $ListaActualizarCantidad[$j]['observacion'];
        $lista[$i]['evento'] = 'ACTUALIZACION DE CANTIDAD';
        $lista[$i]['cod_item_producto'] = '#'.$ListaActualizarCantidad[$j]['cod_item_producto'];
        $total = $total - ($total - $ListaActualizarCantidad[$j]['cantidad']);
        $lista[$i]['total'] = $total;
        $i++;
        $j++;
    }

    $datos = array($codInventario);
    $modelo = modelo('ActualizarPrecio');
    $ListaActualizarCantidad = $modelo->listaHistorialEditarPrecioInventario($datos);
    $j = 0;
    While ($j < sizeof($ListaActualizarCantidad)){
        $lista[$i]['fecha_hora'] = date("d/m/Y", strtotime($ListaActualizarCantidad[$j]["fecha"]))." ".$ListaActualizarCantidad[$j]["hora"];
        $lista[$i]['personal'] = $ListaActualizarCantidad[$j]['personal'];
        $lista[$i]['cantidad'] = $ListaActualizarCantidad[$j]['cantidad'].' Uds.';
        $lista[$i]['observacion'] = $ListaActualizarCantidad[$j]['observacion'];
        $lista[$i]['evento'] = 'ACTUALIZACION DE PRECIOS';
        $lista[$i]['cod_item_producto'] = '#'.$ListaActualizarCantidad[$j]['cod_item_producto'];
        //$total = $total - ($total - $ListaActualizarCantidad[$j]['cantidad']);
        $lista[$i]['total'] = $total;
        $i++;
        $j++;
    }
    
    $data = array();
    $data = ['data' => $lista];
    echo json_encode($data);
}
?>