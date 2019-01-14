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
        default:
            echo "prueba:".$_POST['codigo'];
    }
}

function modelo($modelo){
    require_once '../modelos/'.$modelo.'.php';
    return new $modelo();
}

function listaProductos(){
    $datos = array();
    $modelo = modelo('Producto');
    $lista = $modelo->listaProductos($datos);
    $data = array();
    $data = ['data' => $lista];
    echo json_encode($data);
}

function agregarProducto(){
    $codigo = $_POST['codigo'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $color = $_POST['color'];
    $imagen = "sin_imagen_producto.jpg";
    $estado = "1";

    if(!empty($_FILES["file"]["type"])){
        $fileName = $_FILES['file']['name'];
        $valid_extensions = array("jpeg", "jpg", "png");
        $temporary = explode(".", $_FILES["file"]["name"]);
        $file_extension = end($temporary);
        if((($_FILES["hard_file"]["type"] == "image/png") || ($_FILES["file"]["type"] == "image/jpg") || ($_FILES["file"]["type"] == "image/jpeg")) && in_array($file_extension, $valid_extensions)){
            $sourcePath = $_FILES['file']['tmp_name'];
            $targetPath = "public/imagenes/".$fileName;
            if(move_uploaded_file($sourcePath,$targetPath)){
                $imagen = $fileName;
            }
        }
    }

    $data = array();
    $resp = "";

    $datos = array($codigo, $nombre, $descripcion, $color, $imagen, $estado);
    $modelo = modelo('Producto');
    $resp = $modelo->agregarProducto($datos);

    $data = ['resp' => $resp];
    //echo json_encode($data);
    echo "pruebaF:".$_POST['codigo'];
    /*$codigo = $_POST['codigo'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $color = $_POST['color'];
    $imagen = "";
    $estado = "";

    $data = array();
    $resp = "";

    $datos = array($codigo, $nombre, $descripcion, $color, $imagen, $estado);
    $modelo = modelo('Producto');
    $resp = $modelo->agregarProducto($datos);

    $data = ['resp' => $resp];
    echo json_encode($data);*/
}

?>