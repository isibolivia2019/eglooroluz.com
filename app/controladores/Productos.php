<?php
ini_set('display_errors', '1');
session_start();
$action = '';

if (isset($_POST['action'])) {
    $action = $_POST['action'];
    switch ($action) {
        case 'listaProductos' :
            listaProductos();
            break;
        case 'agregarProducto' :
            agregarProducto();
            break;
        case 'productoEspecifico' :
            productoEspecifico();
            break;
        case 'actualizarProducto' :
            actualizarProducto();
            break;
        case 'actualizarImagenProducto' :
            actualizarImagenProducto();
            break;
        case 'listaCompraProductos' :
            listaCompraProductos();
            break;
        case 'agregarCompra' :
            agregarCompra();
            break;
        case 'ultimaCompraProducto' :
            ultimaCompraProducto();
            break;
        default:
            echo "No se Encontro la Funcion";
    }
}

function modelo($modelo){
    require_once '../modelos/'.$modelo.'.php';
    return new $modelo();
}

function ultimaCompraProducto(){
    $cod_producto = $_POST['cod_producto'];
    $datos = array($cod_producto);
    $modelo = modelo('Producto');
    $lista = $modelo->ultimaCompraProducto($datos);
    $data = array();
    $data = ['data' => $lista];
    echo json_encode($data);
}

function listaProductos(){
    $datos = array();
    $modelo = modelo('Producto');
    $lista = $modelo->listaProductos($datos);
    $data = array();
    $data = ['data' => $lista];
    echo json_encode($data);
}

function productoEspecifico(){
    $cod_producto = $_POST['cod_producto'];
    $datos = array($cod_producto);
    $modelo = modelo('Producto');
    $lista = $modelo->productoEspecifico($datos);
    echo json_encode($lista);
}

function agregarCompra(){
    $cod_producto = $_POST['cod_producto'];
    $cantidad = $_POST['cantidad'];
    $costo = $_POST['costo'];
    $precio = $_POST['precio'];
    $cboxAlmacenamiento = $_POST['cboxAlmacenamiento'];
    $observacion = $_POST['observacion'];
    $usuario = $_SESSION['codigo'];
    date_default_timezone_set('America/La_Paz');
    $hora = date("H:i:s");
    $fecha = date("Y-m-d");
    
    $datos = array($cod_producto, $cboxAlmacenamiento, $costo, $precio);
    $modelo = modelo('Inventario');
    $lista = $modelo->listaInventarioCodigoAlmanenamiento($datos);
    if(sizeof($lista) > 0){
        $cant = $lista[0]['cant_producto'] + $cantidad;
        $datos = array($cant, $lista[0]['cod_inventario']);
        $modelo = modelo('Inventario');
        $resp1 = $modelo->actualizarCantidadInventario($datos);

        $datos = array($cod_producto, $cantidad, $costo, $precio, $observacion, $fecha, $hora, $cboxAlmacenamiento, $usuario, $lista[0]['cod_inventario']);
        $modelo = modelo('Producto');
        $resp = $modelo->agregarCompra($datos);

        $d = ['resp' => $resp1, 'action' => 'actualizar'];
    }else{
        $datos = array($cboxAlmacenamiento, $cod_producto, $cantidad, $costo, $precio);
        $modelo = modelo('Inventario');
        $resp1 = $modelo->agregarInventario($datos);

        $datos = array($cod_producto, $cboxAlmacenamiento, $costo, $precio);
        $modelo = modelo('Inventario');
        $listaNuevo = $modelo->listaInventarioCodigoAlmanenamiento($datos);

        $datos = array($cod_producto, $cantidad, $costo, $precio, $observacion, $fecha, $hora, $cboxAlmacenamiento, $usuario, $listaNuevo[0]['cod_inventario']);
        $modelo = modelo('Producto');
        $resp = $modelo->agregarCompra($datos);

        $d = ['resp' => $resp1, 'action' => 'agregar'];
    }
    $data = ['producto' => $resp, 'inventario' => $d];

    echo json_encode($data);
}

function agregarProducto(){
    $codigo = $_POST['codigo'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $color = $_POST['color'];
    $imagen = "sin_imagen_producto.jpg";
    $estado = "1";

    if(!empty($_FILES["imagen"]["type"])){
        $fileName = $_FILES['imagen']['name'];
        $valid_extensions = array("jpeg", "jpg", "png");
        $temporary = explode(".", $_FILES["imagen"]["name"]);
        $file_extension = end($temporary);
        if((($_FILES["imagen"]["type"] == "image/png") || ($_FILES["imagen"]["type"] == "image/jpg") || ($_FILES["imagen"]["type"] == "image/jpeg")) && in_array($file_extension, $valid_extensions)){
            $ruta_imagen = $_FILES['imagen']['tmp_name'];
            $ruta_destino = "../../public/imagenes/productos/".$codigo.".".$file_extension;
            $imagen = $codigo.".".$file_extension;
            copy($ruta_imagen, $ruta_destino);
        }
    }

    $data = array();
    $resp = "";

    $datos = array($codigo, $nombre, $descripcion, $color, $imagen, $estado);
    $modelo = modelo('Producto');
    $resp = $modelo->agregarProducto($datos);

    $data = ['resp' => $resp];
    echo json_encode($data);
}

function actualizarImagenProducto(){
    $cod = $_POST['cod'];
    $codItem = $_POST['codItem'];
    $imagen = "";
    if(!empty($_FILES["imagen"]["type"])){
        $fileName = $_FILES['imagen']['name'];
        $valid_extensions = array("jpeg", "jpg", "png");
        $temporary = explode(".", $_FILES["imagen"]["name"]);
        $file_extension = end($temporary);
        if((($_FILES["imagen"]["type"] == "image/png") || ($_FILES["imagen"]["type"] == "image/jpg") || ($_FILES["imagen"]["type"] == "image/jpeg")) && in_array($file_extension, $valid_extensions)){
            $ruta_imagen = $_FILES['imagen']['tmp_name'];
            $ruta_destino = "../../public/imagenes/productos/".$codItem.".".$file_extension;
            $imagen = $codItem.".".$file_extension;
            copy($ruta_imagen, $ruta_destino);
        }
    }

    $data = array();
    $resp = "";

    $datos = array($imagen, $cod);
    $modelo = modelo('Producto');
    $resp = $modelo->actualizarImagenProducto($datos);

    $data = ['resp' => $resp];
    echo json_encode($data);
}

function actualizarProducto(){
    $codigo = $_POST['codigo'];
    $cod_item = $_POST['cod_item'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $color = $_POST['color'];

    $data = array();
    $resp = "";

    $datos = array($cod_item, $nombre, $descripcion, $color, $codigo);
    $modelo = modelo('Producto');
    $resp = $modelo->actualizarProducto($datos);

    $data = ['resp' => $resp];
    echo json_encode($data);
}

function listaCompraProductos(){
    $datos = array();
    $modelo = modelo('Sucursal');
    $listaSucursales = $modelo->listaSucursales($datos);
    $modelo = modelo('Almacen');
    $listaAlmacenes = $modelo->listaAlmacenes($datos);

    $datos = array();
    $modelo = modelo('Producto');
    $lista = $modelo->listaCompraProductos($datos);
    for($i = 0 ; $i < sizeof($lista) ; $i++){
        $lista[$i]["fecha_compra_producto"] = date("d/m/Y", strtotime($lista[$i]["fecha_compra_producto"]))." ".$lista[$i]["hora_compra_producto"];
        $lista[$i]["cod_item_producto"] = '#'.$lista[$i]["cod_item_producto"];
        $lista[$i]["cantidad_compra_producto"] = $lista[$i]["cantidad_compra_producto"].' Uds.';
        $lista[$i]["precio_unit_compra_producto"] = '$us '.$lista[$i]["precio_unit_compra_producto"];
        $lista[$i]["precio_sugerido_venta"] = '$us '.$lista[$i]["precio_sugerido_venta"];
        for($j = 0 ; $j < sizeof($listaSucursales) ; $j++){
            if($listaSucursales[$j]["cod_sucursal"] == $lista[$i]["cod_almacenamiento"]){
                $lista[$i]["nombre_almacenamiento"] = $listaSucursales[$j]["nombre_sucursal"];
            }
        }
        for($k = 0 ; $k < sizeof($listaAlmacenes) ; $k++){
            if($listaAlmacenes[$k]["cod_almacen"] == $lista[$i]["cod_almacenamiento"]){
                $lista[$i]["nombre_almacenamiento"] = $listaAlmacenes[$k]["nombre_almacen"];
            }
        }
    }
    $data = array();
    $data = ['data' => $lista];
    echo json_encode($data);
}

?>