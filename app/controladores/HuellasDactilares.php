<?php
ini_set('display_errors', '1');
session_start();
$action = '';

if (isset($_POST['action'])) {
    $action = $_POST['action'];
    switch ($action) {
        case 'registrarEntradaSalida' :
            registrarEntradaSalida();
            break;
        case 'registrarInicioSoftware' :
            registrarInicioSoftware();
            break;
        case 'registrarFinSoftware' :
            registrarFinSoftware();
            break;
        case 'listaRegistroHorario' :
            listaRegistroHorario();
            break;
    }
}

function modelo($modelo){
    require_once '../modelos/'.$modelo.'.php';
    return new $modelo();
}

function listaRegistroHorario(){
    $mes = $_POST['mes'];
    $año = $_POST['año'];

    $datos = array($mes, $año);
    $modelo = modelo('HuellaDactilar');
    $lista = $modelo->listaRegistroHorario($datos);
    $data = array();
    $data = ['data' => $lista];
    echo json_encode($data);
}

function registrarInicioSoftware(){
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];
    $computadora = $_POST['computadora'];
    $datos = array($fecha, $hora, $computadora);
    $modelo = modelo('HuellaDactilar');
    $lista = $modelo->inicioSoftware($datos);
}

function registrarFinSoftware(){
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];
    $computadora = $_POST['computadora'];
    $datos = array($fecha, $hora, $computadora);
    $modelo = modelo('HuellaDactilar');
    $lista = $modelo->finSoftware($datos);
}

function registrarEntradaSalida(){
    $biometrico = $_POST['biometrico'];
    $dedohuella = $_POST['dedohuella'];

    $datos = array($dedohuella, $biometrico);
    $modelo = modelo('HuellaDactilar');
    $usuario = $modelo->listaUsuarioHuellaDactilarEspecifico($datos);

    $datos = array($usuario[0]['cod_usuario']);
    $modelo = modelo('HuellaDactilar');
    $listaHorario = $modelo->ultimoRegistroHuella($datos);

    date_default_timezone_set('America/La_Paz');
    $hora = date("H:i:s");
    $fecha = date("Y-m-d");
    $verificaHora = date("H");
    if(sizeof($listaHorario) > 0 && $fecha == $listaHorario[0]['fecha_reg_hr']){
        if($verificaHora >= 12){
            $datos = array($hora, "salida", $listaHorario[0]['cod_reg_hr']);
            $modelo = modelo('HuellaDactilar');
            $listaHorario = $modelo->actualizaRegistroSalida($datos);
        }
    }else{
        if($verificaHora >= 12){
            $datos = array($usuario[0]['cod_usuario'], $fecha, $hora, "1", "salida");
            $modelo = modelo('HuellaDactilar');
            $listaHorario = $modelo->registroSalida($datos);
        }else{
            $datos = array($usuario[0]['cod_usuario'], $fecha, $hora, "1", "entrada");
            $modelo = modelo('HuellaDactilar');
            $listaHorario = $modelo->registroEntrada($datos);
        }
    }
    echo 'funciona';
}
?>