<?php
ini_set('display_errors', '1');
session_start();
$action = '';

if (isset($_POST['action'])) {
    $action = $_POST['action'];
    switch ($action) {
        case 'ingresarEmail' :
            ingresarEmail();
            break;
        case 'actualizarPrecio' :
            actualizarPrecio();
            break;
        case 'actualizarCantidad' :
            actualizarCantidad();
            break;
    }
}

function modelo($modelo){
    require_once '../modelos/'.$modelo.'.php';
    return new $modelo();
}

function ingresarEmail(){
    $email = $_POST['email'];
    
    $datos = array($email);
    $modelo = modelo('Configuracion');
    $resp = $modelo->ingresarEmail($datos);

    $data = ['resp' => $resp];
    echo json_encode($data);
}

function actualizarPrecio(){
    $cod_almacenamiento = $_POST['cod_almacenamiento'];
    $precio = $_POST['precio'];
    $sugerido = $_POST['sugerido'];
    $cantidad = $_POST['cantidad'];
    $cod_inventario = $_POST['cod_inventario'];
    $observacion = $_POST['observacion'];
    $cod_producto = $_POST['cod_producto'];
    $sugeridoAnterior = $_POST['sugeridoAnterior'];
    $precioAnterior = $_POST['precioAnterior'];
    $usuario = $_SESSION['codigo'];
    date_default_timezone_set('America/La_Paz');
    $hora = date("H:i:s");
    $fecha = date("Y-m-d");
    $resp = "";
    $observacion = 'PRECIO MODIFICADO, COSTO ANTERIOR DE COMPRA=$us '.$precioAnterior.' PRECIO ANTERIOR DE VENTA=$us '.$sugeridoAnterior.' ('.$observacion.')';
    if($cod_almacenamiento == "todos"){
        $datos = array($cod_producto, $precioAnterior, $sugeridoAnterior);
        $modelo = modelo('Inventario');
        $listaProducto = $modelo->buscaListaInventarioPrecio($datos);
        
        for($i=0; $i<sizeof($listaProducto);$i++){
            $datos = array($listaProducto[$i]['cod_inventario'], $listaProducto[$i]['cod_almacenamiento'], $listaProducto[$i]['cant_producto'], $observacion, $fecha, $hora, $usuario);
            $modelo = modelo('Configuracion');
            $resp = $modelo->agregarRegistroEditarPrecio($datos);

            $datos = array($precio, $sugerido, $listaProducto[$i]['cod_inventario']);
            $modelo = modelo('Configuracion');
            $resp = $modelo->actualizarPreciosInventarios($datos);
        }

    }else{
        $datos = array($cod_inventario, $cod_almacenamiento, $cantidad, $observacion, $fecha, $hora, $usuario);
        $modelo = modelo('Configuracion');
        $resp = $modelo->agregarRegistroEditarPrecio($datos);

        $datos = array($precio, $sugerido, $cod_inventario);
        $modelo = modelo('Configuracion');
        $resp = $modelo->actualizarPreciosInventarios($datos);
    }

    $data = ['resp' => $resp];
    echo json_encode($data);

}

function actualizarCantidad(){
    $cod_almacenamiento = $_POST['cod_almacenamiento'];
    $cantidadNueva = $_POST['cantidadNueva'];
    $cantidadAntertior = $_POST['cantidadAntertior'];
    $cod_inventario = $_POST['cod_inventario'];
    $observacion = $_POST['observacion'];
    $usuario = $_SESSION['codigo'];
    date_default_timezone_set('America/La_Paz');
    $hora = date("H:i:s");
    $fecha = date("Y-m-d");
    $resp = "";
    $observacion = 'Cantidad Anterior:'.$cantidadAntertior.' Uds. Nueva Cantidad:'.$cantidadNueva.' Uds. ('.$observacion.')';
 
    $datos = array($cantidadNueva, $cod_inventario);
    $modelo = modelo('ActualizarCantidad');
    $resp = $modelo->actualizarCantidadInventario($datos);

    $datos = array($cod_inventario, $cod_almacenamiento, $cantidadNueva, $observacion, $fecha, $hora, $usuario);
    $modelo = modelo('ActualizarCantidad');
    $resp = $modelo->agregarRegistroEditarCantidad($datos);
 

    $data = ['resp' => $resp];
    echo json_encode($data);
}

?>