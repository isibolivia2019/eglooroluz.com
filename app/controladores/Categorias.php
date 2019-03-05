<?php
ini_set('display_errors', '1');
session_start();
$action = '';

if (isset($_POST['action'])) {
    $action = $_POST['action'];
    switch ($action) {
        case 'listaCategorias' :
            listaCategorias();
            break;
        case 'listaCategoriaProductos' :
            listaCategoriaProductos();
            break;
        case 'eliminarProductoCategoria' :
            eliminarProductoCategoria();
            break;
        case 'categoriaEspecifico' :
            categoriaEspecifico();
            break;
        case 'actualizarCategoria' :
            actualizarCategoria();
            break;
        case 'actualizarImagenCategoria' :
            actualizarImagenCategoria();
            break;
        case 'eliminarCategoria' :
            eliminarCategoria();
            break;
        case 'agregarCategoria' :
            agregarCategoria();
            break;
        case 'asignarProductoCategoria' :
            asignarProductoCategoria();
            break;
        case 'listaCategoriaProductosPagina' :
            listaCategoriaProductosPagina();
            break;
            
    }
}

function modelo($modelo){
    require_once '../modelos/'.$modelo.'.php';
    return new $modelo();
}

function asignarProductoCategoria(){
    $categoria = $_POST['cod_categoria'];
    $producto = $_POST['cod_producto'];
    $data = array();
    $resp = "";

    $datos = array($categoria, $producto);
    $modelo = modelo('Categoria');
    $lista = $modelo->verificarProductoCategoria($datos);
    if(sizeof($lista) == 0){
        $datos = array($categoria, $producto);
        $modelo = modelo('Categoria');
        $resp = $modelo->asignarUsuarioSueldo($datos);
    }else{
        $resp = "false";
    }

    $data = ['resp' => $resp];
    echo json_encode($data);
}

function agregarCategoria(){
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $imagen = "sin_imagen_producto.jpg";

    if(!empty($_FILES["imagen"]["type"])){
        $fileName = $_FILES['imagen']['name'];
        $valid_extensions = array("jpeg", "jpg", "png");
        $temporary = explode(".", $_FILES["imagen"]["name"]);
        $file_extension = end($temporary);
        if((($_FILES["imagen"]["type"] == "image/png") || ($_FILES["imagen"]["type"] == "image/jpg") || ($_FILES["imagen"]["type"] == "image/jpeg")) && in_array($file_extension, $valid_extensions)){
            $ruta_imagen = $_FILES['imagen']['tmp_name'];
            $ruta_destino = "../../public/imagenes/categorias/".str_replace(" ","_",$nombre).".".$file_extension;
            $imagen = str_replace(" ","_",$nombre).".".$file_extension;
            copy($ruta_imagen, $ruta_destino);
        }
    }

    $data = array();
    $resp = "";

    $datos = array($nombre, $descripcion, $imagen);
    $modelo = modelo('Categoria');
    $resp = $modelo->agregarCategoria($datos);

    $data = ['resp' => $resp];
    echo json_encode($data);
}

function eliminarCategoria(){
    $cod_categoria = $_POST['cod_categoria'];
    $datos = array($cod_categoria);
    $modelo = modelo('Categoria');
    $resp = $modelo->eliminarCategoriaProducto($datos);
    $resp = $modelo->eliminarCategoria($datos);

    $data = ['resp' => $resp];
    echo json_encode($data);
}

function actualizarImagenCategoria(){
    $cod = $_POST['cod'];
    $nombre = $_POST['nom'];
    $imagen = "";
    if(!empty($_FILES["imagen"]["type"])){
        $fileName = $_FILES['imagen']['name'];
        $valid_extensions = array("jpeg", "jpg", "png");
        $temporary = explode(".", $_FILES["imagen"]["name"]);
        $file_extension = end($temporary);
        if((($_FILES["imagen"]["type"] == "image/png") || ($_FILES["imagen"]["type"] == "image/jpg") || ($_FILES["imagen"]["type"] == "image/jpeg")) && in_array($file_extension, $valid_extensions)){
            $ruta_imagen = $_FILES['imagen']['tmp_name'];
            $ruta_destino = "../../public/imagenes/categorias/".str_replace(" ","_",$nombre).".".$file_extension;
            $imagen = str_replace(" ","_",$nombre).".".$file_extension;
            copy($ruta_imagen, $ruta_destino);
        }
    }

    $data = array();
    $resp = "";

    $datos = array($imagen, $cod);
    $modelo = modelo('Categoria');
    $resp = $modelo->actualizarImagenCategoria($datos);

    $data = ['resp' => $resp];
    echo json_encode($data);
}

function actualizarCategoria(){
    $codigo = $_POST['codigo'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];

    $data = array();
    $resp = "";

    $datos = array($nombre, $descripcion, $codigo);
    $modelo = modelo('Categoria');
    $resp = $modelo->actualizarCategoria($datos);

    $data = ['resp' => $resp];
    echo json_encode($data);
}

function categoriaEspecifico(){
    $cod_categoria = $_POST['cod_categoria'];
    $datos = array($cod_categoria);
    $modelo = modelo('Categoria');
    $lista = $modelo->categoriaEspecifico($datos);
    echo json_encode($lista);
}

function listaCategorias(){
    $datos = array();
    $modelo = modelo('Categoria');
    $lista = $modelo->listaCategorias($datos);
    $data = array();
    $data = ['data' => $lista];
    echo json_encode($data);
}

function listaCategoriaProductos(){
    $cod_categoria = $_POST['cod_categoria'];
    $datos = array($cod_categoria);
    $modelo = modelo('Categoria');
    $lista = $modelo->listaCategoriaProductos($datos);
    $data = array();
    $data = ['data' => $lista];
    echo json_encode($data);
}

function eliminarProductoCategoria(){
    $cod_categoria = $_POST['cod_categoria'];
    $cod_producto = $_POST['cod_producto'];
    $datos = array( $cod_categoria, $cod_producto);
    $modelo = modelo('Categoria');
    $resp = $modelo->eliminarProductoCategoria($datos);
    $data = array();
    $data = ['resp' => $resp];
    echo json_encode($data);
}

function listaCategoriaProductosPagina(){
    $cod_categoria = $_POST['codigo'];
    $datos = array($cod_categoria);
    $modelo = modelo('Categoria');
    $lista = $modelo->listaCategoriaProductosPagina($datos);
    $data = array();
    $data = ['data' => $lista];
    echo json_encode($data);
}

?>