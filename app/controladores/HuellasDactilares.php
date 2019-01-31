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
        case 'listaRegistroHorarioEspecifico' :
            listaRegistroHorarioEspecifico();
            break;
        case 'agregarObservacion' :
            agregarObservacion();
            break;
    }
}

function modelo($modelo){
    require_once '../modelos/'.$modelo.'.php';
    return new $modelo();
}

function agregarObservacion(){
    $modal = $_POST['modal'];
    $observacion = $_POST['observacion'];
    $codigo = $_POST['codigo'];
    $resp = "";
    if($modal == "entrada"){
        $datos = array($observacion, $codigo);
        $modelo = modelo('HuellaDactilar');
        $resp = $modelo->agregarObservacionEntrada($datos);
    }
    if($modal == "salida"){
        $datos = array($observacion, $codigo);
        $modelo = modelo('HuellaDactilar');
        $resp = $modelo->agregarObservacionSalida($datos);
    }
    $data = ['resp' => $resp];
    echo json_encode($data);
}

function listaRegistroHorario(){
    $mes = $_POST['mes'];
    $año = $_POST['año'];

    $datos = array($mes, $año);
    $modelo = modelo('HuellaDactilar');
    $lista = $modelo->listaRegistroHorario($datos);
    for($i = 0 ; $i < sizeof($lista) ; $i++){
        $lista[$i]["fecha_reg_hr"] = date("d/m/Y", strtotime($lista[$i]["fecha_reg_hr"]));
    }
    $data = array();
    $data = ['data' => $lista];
    echo json_encode($data);
}

function listaRegistroHorarioEspecifico(){
    $usuario = $_SESSION['codigo'];
    date_default_timezone_set('America/La_Paz');
    $mes = date("m");
    $año = date("Y");
    $datos = array($usuario, $mes, $año);
    $modelo = modelo('HuellaDactilar');
    $lista = $modelo->listaRegistroHorarioEspecifico($datos);
    for($i = 0 ; $i < sizeof($lista) ; $i++){
        $lista[$i]["fecha_reg_hr"] = date("d/m/Y", strtotime($lista[$i]["fecha_reg_hr"]));
    }
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
    $cadena = $_POST['cadena'];
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
            $datos = array($usuario[0]['cod_usuario'], $fecha, $hora, "1", "salida", $cadena);
            $modelo = modelo('HuellaDactilar');
            $listaHorario = $modelo->registroSalida($datos);
        }else{
            $datos = array($usuario[0]['cod_usuario'], $fecha, $hora, "1", "entrada", $cadena);
            $modelo = modelo('HuellaDactilar');
            $listaHorario = $modelo->registroEntrada($datos);
        }
    }
    echo 'funciona';
}
?>