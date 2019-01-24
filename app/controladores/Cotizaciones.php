<?php
ini_set('display_errors', '1');
session_start();
$action = '';

if (isset($_POST['action'])) {
    $action = $_POST['action'];
    switch ($action) {
        case 'agregarCarrito' :
            agregarCarrito();
            break;
        case 'actualizarCarrito' :
            actualizarCarrito();
            break;
        case 'totalPagar' :
            totalPagar();
            break;
        case 'listaCarrito' :
            listaCarrito();
            break;
        case 'eliminarCarrito' :
            eliminarCarrito();
            break;
        case 'listaCarritoEspecifico' :
            listaCarritoEspecifico();
            break;
        case 'conversionMonedaProducto' :
            conversionMonedaProducto();
            break;
        case 'agregarCotizacion' :
            agregarCotizacion();
            break;
        case 'listaInventarioCotizaciones' :
            listaInventarioCotizaciones();
            break;
            
    }
}

function modelo($modelo){
    require_once '../modelos/'.$modelo.'.php';
    return new $modelo();
}


function listaInventarioCotizaciones(){
    $data = array();
    $datos = array();
    $modelo = modelo('Inventario');
    $lista = $modelo->listaInventarioCotizaciones($datos);
    for($i = 0 ; $i < sizeof($lista) ; $i++){
        $lista[$i]["cod_item_producto"] = '#'.$lista[$i]["cod_item_producto"];
        $lista[$i]["compra_unit_producto"] = '$us '.$lista[$i]["compra_unit_producto"];
        $lista[$i]["precio_sugerido_venta"] = '$us '.$lista[$i]["precio_sugerido_venta"];
    }
    $data = ['data' => $lista];
    echo json_encode($data);
}

function agregarCotizacion(){
    $sucursal = $_POST['sucursal'];
    $empresa = $_POST['empresa'];
    $atencion = $_POST['atencion'];

    $usuario = $_SESSION['codigo'];
    date_default_timezone_set('America/La_Paz');
    $hora = date("H:i:s");
    $fecha = date("Y-m-d");

    $datos = array($sucursal);
    $modelo = modelo('Cotizacion');
    $lista = $modelo->listaCarritoCotizacion($datos);

    $datos = array();
    $modelo = modelo('Cotizacion');
    $listaUltimo = $modelo->listaCotizacionUltimo($datos);

    $resp = "";

    for($i = 0 ; $i < sizeof($lista) ; $i++){
        $datos = array($sucursal, $lista[$i]['cod_inventario'], $lista[$i]['cantidad'], $lista[$i]['descuento'], $lista[$i]['total'], ($listaUltimo[0]['nro_orden'] + 1), $empresa, $atencion, $fecha, $hora, $usuario);
        $modelo = modelo('Cotizacion');
        $resp = $modelo->agregarCotizacion($datos);
    }

    $datos = array($sucursal);
    $modelo = modelo('Cotizacion');
    $resp = $modelo->vaciarCarrito($datos);

    $data = array();
    $data = ['resp' => $resp,
    'nro' => ($listaUltimo[0]['nro_orden'] + 1)];
    echo json_encode($data);
}

function conversionMonedaProducto(){
    $codCarrito = $_POST['codCarrito'];

    $datos = array();
    $modelo = modelo('TipoCambio');
    $cambioMoneda = $modelo->TipoCambio($datos);
    $datos = array($codCarrito);
    $modelo = modelo('Cotizacion');
    $lista = $modelo->listaCarritoEspecifico($datos);

    for($i = 0 ; $i < sizeof($lista) ; $i++){
        $resultado = round(((0.01 * $lista[$i]["descuento"]) * $lista[$i]["precio_sugerido_venta"]),2);
        $resultado = round($resultado * $cambioMoneda[0]['dolar'] ,2);
        $resultado = $lista[$i]["descuento"].'% (Bs. '.$resultado.')';
        $lista[$i]["descuento"] = $resultado;
        $resultado = round($lista[$i]["total"] * $cambioMoneda[0]['dolar'],2);
        $lista[$i]["total"] = $resultado;
        $resultado = round($lista[$i]["precio_sugerido_venta"] * $cambioMoneda[0]['dolar'],2);
        $lista[$i]["precio_sugerido_venta"] = $resultado;
    }

    $data = array();
    $data = ['data' => $lista];
    echo json_encode($data);
}

function totalPagar(){
    $sucursal = $_POST['sucursal'];
    $datos = array($sucursal);
    $modelo = modelo('Cotizacion');
    $lista = $modelo->totalPagar($datos);
    $total = 0;
    for($i = 0 ; $i < sizeof($lista) ; $i++){
        $total = $total + ($lista[$i]["cantidad"] * $lista[$i]["total"]);
    }
    $total = round($total,2);
    $data = ['total' => $total];
    echo json_encode($data);
}

function listaCarritoEspecifico(){
    $codCarrito = $_POST['codCarrito'];
    $datos = array($codCarrito);
    $modelo = modelo('Cotizacion');
    $lista = $modelo->listaCarritoEspecifico($datos);
    $data = ['data' => $lista];
    echo json_encode($data);
}

function eliminarCarrito(){
    $cod_carrito = $_POST['cod_carrito'];
    $datos = array($cod_carrito);
    $modelo = modelo('Cotizacion');
    $resp = $modelo->eliminarCarrito($datos);

    $data = ['resp' => $resp];
    echo json_encode($data);
}

function agregarCarrito(){
    $cod_inventario = $_POST['cod_inventario'];
    $cantidad = $_POST['cantidad'];
    $precio = $_POST['precio'];
    $sucursal = $_POST['sucursal'];

    $datos = array($cod_inventario);
    $modelo = modelo('Inventario');
    $lista = $modelo->listaInventarioEspecifico($datos);

    $diferencia = $lista[0]["precio_sugerido_venta"] - $precio;
    $descuento = round(($diferencia*100)/$lista[0]["precio_sugerido_venta"], 2);
    $descuento = $descuento * -1;
    $datos = array($cod_inventario, $cantidad, $descuento, $precio, $sucursal);
    $modelo = modelo('Cotizacion');
    $resp = $modelo->agregarCarrito($datos);

    $data = array();
    $data = ['resp' => $resp];
    echo json_encode($data);
}

function listaCarrito(){
    $sucursal = $_POST['sucursal'];
    $datos = array($sucursal);
    $modelo = modelo('Cotizacion');
    $lista = $modelo->listaCarrito($datos);
    for($i = 0 ; $i < sizeof($lista) ; $i++){
        $lista[$i]["cod_item_producto"] = '#'.$lista[$i]["cod_item_producto"];
        $lista[$i]["cantidad"] = $lista[$i]["cantidad"].' Uds.';
        $lista[$i]["descuento"] = $lista[$i]["descuento"].'%($us. '.round(((0.01 * $lista[$i]["descuento"]) * $lista[$i]["precio_sugerido_venta"]),2).')';
        $lista[$i]["precio_sugerido_venta"] = '$us. '.$lista[$i]["precio_sugerido_venta"];
        $lista[$i]["total"] = '$us. '.$lista[$i]["total"];
        $lista[$i]["subTotal"] = '$us. '.$lista[$i]["subTotal"];
        
        
    }
    $data = array();
    $data = ['data' => $lista];
    echo json_encode($data);
}

function actualizarCarrito(){
    $codCarrito = $_POST['codCarrito'];
    $precio = $_POST['precio'];
    $cantidad = $_POST['cantidad'];
    $cod_inventario = $_POST['cod_inventario'];

    $datos = array($cod_inventario);
    $modelo = modelo('Inventario');
    $lista = $modelo->listaInventarioEspecifico($datos);

    $diferencia = $lista[0]["precio_sugerido_venta"] - $precio;
    $descuento = round(($diferencia*100)/$lista[0]["precio_sugerido_venta"], 2);
    $descuento = $descuento * -1;

    $data = array();

    $datos = array($cantidad, $descuento, $precio, $codCarrito);
    $modelo = modelo('Cotizacion');
    $resp = $modelo->actualizarCarrito($datos);

    $data = ['resp' => $resp];
    echo json_encode($data);
}

?>