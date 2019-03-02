<?php
ini_set('display_errors', '1');
session_start();
$action = '';

if (isset($_POST['action'])) {
    $action = $_POST['action'];
    switch ($action) {
        case 'listaDescuentosActivos' :
            listaDescuentosActivos();
            break;
        case 'listaDescuentosTodo' :
            listaDescuentosTodo();
            break;
        case 'eliminarDescuento' :
            eliminarDescuento();
            break;
        case 'agregarDescuento' :
            agregarDescuento();
            break;
    }
}

function modelo($modelo){
    require_once '../modelos/'.$modelo.'.php';
    return new $modelo();
}

function eliminarDescuento(){
    $cod_descuento_producto = $_POST['cod_descuento_producto'];
    date_default_timezone_set('America/La_Paz');
    $hora = date("H:i:s");
    $fecha = date("Y-m-d");

    $datos = array($fecha, "0", $cod_descuento_producto);
    $modelo = modelo('Descuento');
    $resp = $modelo->eliminarDescuento($datos);

    $data = ['resp' => $resp];
    echo json_encode($data);
}

function listaDescuentosTodo(){
    $datos = array();
    $modelo = modelo('Sucursal');
    $listaSucursales = $modelo->listaSucursales($datos);
    $modelo = modelo('Almacen');
    $listaAlmacenes = $modelo->listaAlmacenes($datos);

    $datos = array("1");
    $modelo = modelo('Descuento');
    $lista = $modelo->listaDescuentosTodo($datos);
    for($i=0;$i<sizeof($lista);$i++){
        $lista[$i]['descuento_interno'] = $lista[$i]['descuento_interno'].' %';
        if($lista[$i]["fecha_final_descuento_producto"] == ""){

        }else{
            $lista[$i]["fecha_final_descuento_producto"] = date("d/m/Y", strtotime($lista[$i]["fecha_final_descuento_producto"]));
        
        }
        $lista[$i]["fecha_inicio_descuento_producto"] = date("d/m/Y", strtotime($lista[$i]["fecha_inicio_descuento_producto"]));
        $lista[$i]['cod_item_producto'] = '#'.$lista[$i]['cod_item_producto'].' '.$lista[$i]['nombre_producto'];
        $lista[$i]['porcenta_descuento_producto'] = $lista[$i]['porcenta_descuento_producto'].' %';
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
        if($lista[$i]["estado_descuento_producto"] == "1"){
            $lista[$i]["estado_descuento_producto"] = "EN PROMOCION";
        }else{
            $lista[$i]["estado_descuento_producto"] = "FINALIZADO";
        }
    }


    $data = array();
    $data = ['data' => $lista];
    echo json_encode($data);
}

function listaDescuentosActivos(){
    $datos = array();
    $modelo = modelo('Sucursal');
    $listaSucursales = $modelo->listaSucursales($datos);
    $modelo = modelo('Almacen');
    $listaAlmacenes = $modelo->listaAlmacenes($datos);

    $datos = array("1");
    $modelo = modelo('Descuento');
    $lista = $modelo->listaDescuentosActivos($datos);
    for($i=0;$i<sizeof($lista);$i++){
        $lista[$i]['descuento_interno'] = $lista[$i]['descuento_interno'].' %';
        $lista[$i]["fecha_inicio_descuento_producto"] = date("d/m/Y", strtotime($lista[$i]["fecha_inicio_descuento_producto"]));
        $lista[$i]['cod_item_producto'] = '#'.$lista[$i]['cod_item_producto'].' '.$lista[$i]['nombre_producto'];
        $lista[$i]['porcenta_descuento_producto'] = $lista[$i]['porcenta_descuento_producto'].' %';
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

function agregarDescuento(){
    $paginaWeb = $_POST['paginaWeb'];
    $interno = $_POST['interno'];
    $observacion = $_POST['observacion'];
    $inventario = $_POST['inventario'];

    date_default_timezone_set('America/La_Paz');
    $hora = date("H:i:s");
    $fecha = date("Y-m-d");

    $data = array();
    $resp = "";
    $usuario = $_SESSION['codigo'];
    $datos = array($inventario, "1");
    $modelo = modelo('Descuento');
    $lista = $modelo->verificarProductoDescuento($datos);
    if(sizeof($lista) == 0){
        $datos = array($inventario, $paginaWeb, $interno, $observacion, $fecha, "1", $usuario);
        $modelo = modelo('Descuento');
        $resp = $modelo->agregarDescuento($datos);
    }else{
        $resp = "false";
    }

    $data = ['resp' => $resp];
    echo json_encode($data);
}

?>