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
            echo "prueba default:".$_POST['codigo'];
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
    /*$codigo = $_POST['codigo'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $color = $_POST['color'];
    $imagen = "sin_imagen_producto.jpg";
    $estado = "1";*/

    if(!empty($_FILES["imagen"]["type"])){
        echo "*entro imagen*";
        echo "*".$_SERVER["HTTP_HOST"]."*";
        echo "*".$_SERVER["REQUEST_URI"]."*";
        /*opendir("/");
        $destino = "/".$nombre.".jpg";
        $destino = str_replace(" ", "_", $destino);
        copy($_FILES["imagen"]["tmp_name"], $destino);*/
        $fileName = $_FILES['imagen']['name'];
        $valid_extensions = array("jpeg", "jpg", "png");
        $temporary = explode(".", $_FILES["imagen"]["name"]);
        $file_extension = end($temporary);
        if((($_FILES["imagen"]["type"] == "image/png") || ($_FILES["imagen"]["type"] == "image/jpg") || ($_FILES["imagen"]["type"] == "image/jpeg")) && in_array($file_extension, $valid_extensions)){
            $sourcePath = $_FILES['imagen']['tmp_name'];
            require_once("../modelos/Config.php");
            $config = new Config();
            $url = $config->ruta();
            $targetPath = $url."/public/imagenes/".$fileName;
            if(move_uploaded_file($sourcePath,$targetPath)){
                $imagen = $fileName;
            }
        }
    }else{
        echo "no entro imagen";
    }

    /*$data = array();
    $resp = "";

    $datos = array($codigo, $nombre, $descripcion, $color, $imagen, $estado);
    $modelo = modelo('Producto');
    $resp = $modelo->agregarProducto($datos);

    $data = ['resp' => $resp];
    echo json_encode($data);*/
}

?>