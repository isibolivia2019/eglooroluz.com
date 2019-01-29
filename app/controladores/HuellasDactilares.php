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
    }
}

function modelo($modelo){
    require_once '../modelos/'.$modelo.'.php';
    return new $modelo();
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

    if(sizeof($listaHorario) > 0 && $fecha == $listaHorario[0]['fecha_reg_hr']){
        $datos = array($hora, "salida", $listaHorario[0]['cod_reg_hr']);
        $modelo = modelo('HuellaDactilar');
        $listaHorario = $modelo->actualizaRegistroSalida($datos);
    }else{
        $verificaHora = date("H");
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
}
?>