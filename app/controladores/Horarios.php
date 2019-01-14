<?php
ini_set('display_errors', '1');
session_start();
$action = '';

if (isset($_POST['action'])) {
    $action = $_POST['action'];
    switch ($action) {
        case 'listaHorarios' :
            listaHorarios();
            break;
        case 'listaHorarioUsuarios' :
            listaHorarioUsuarios();
            break;
        case 'agregarHorario' :
            agregarHorario();
            break;
        case 'horarioEspecifico' :
            horarioEspecifico();
            break;
        case 'actualizarHorario' :
            actualizarHorario();
            break;
        case 'eliminarHorario' :
            eliminarHorario();
            break;
        case 'eliminarUsuarioHorario' :
            eliminarUsuarioHorario();
            break;
        case 'asignarUsuarioHorario' :
            asignarUsuarioHorario();
            break;
    }
}

function modelo($modelo){
    require_once '../modelos/'.$modelo.'.php';
    return new $modelo();
}

function listaHorarioUsuarios(){
    $horario = $_POST['horario'];
    $datos = array($horario);
    $modelo = modelo('Horario');
    $lista = $modelo->listaHorarioUsuarios($datos);
    for($i = 0 ; $i < sizeof($lista) ; $i++){
        if($lista[$i]["dia_lunes"] == "1"){$lista[$i]["dia_lunes"] = "Lunes, ";}else{$lista[$i]["dia_lunes"] = "";}
        if($lista[$i]["dia_martes"] == "1"){$lista[$i]["dia_martes"] = "Martes, ";}else{$lista[$i]["dia_martes"] = "";}
        if($lista[$i]["dia_miercoles"] == "1"){$lista[$i]["dia_miercoles"] = "Miercoles, ";}else{$lista[$i]["dia_miercoles"] = "";}
        if($lista[$i]["dia_jueves"] == "1"){$lista[$i]["dia_jueves"] = "Jueves, ";}else{$lista[$i]["dia_jueves"] = "";}
        if($lista[$i]["dia_viernes"] == "1"){$lista[$i]["dia_viernes"] = "Viernes, ";}else{$lista[$i]["dia_viernes"] = "";}
        if($lista[$i]["dia_sabado"] == "1"){$lista[$i]["dia_sabado"] = "Sabado, ";}else{$lista[$i]["dia_sabado"] = "";}
        if($lista[$i]["dia_domingo"] == "1"){$lista[$i]["dia_domingo"] = "Domingo, ";}else{$lista[$i]["dia_domingo"] = "";}
    }
    $data = array();
    $data = ['data' => $lista];
    echo json_encode($data);
}

function listaHorarios(){
    $datos = array();
    $modelo = modelo('Horario');
    $lista = $modelo->listaHorarios($datos);
    $data = array();
    for($i = 0 ; $i < sizeof($lista) ; $i++){
        if($lista[$i]["dia_lunes"] == "1"){$lista[$i]["dia_lunes"] = "si";}else{$lista[$i]["dia_lunes"] = "no";}
        if($lista[$i]["dia_martes"] == "1"){$lista[$i]["dia_martes"] = "si";}else{$lista[$i]["dia_martes"] = "no";}
        if($lista[$i]["dia_miercoles"] == "1"){$lista[$i]["dia_miercoles"] = "si";}else{$lista[$i]["dia_miercoles"] = "no";}
        if($lista[$i]["dia_jueves"] == "1"){$lista[$i]["dia_jueves"] = "si";}else{$lista[$i]["dia_jueves"] = "no";}
        if($lista[$i]["dia_viernes"] == "1"){$lista[$i]["dia_viernes"] = "si";}else{$lista[$i]["dia_viernes"] = "no";}
        if($lista[$i]["dia_sabado"] == "1"){$lista[$i]["dia_sabado"] = "si";}else{$lista[$i]["dia_sabado"] = "no";}
        if($lista[$i]["dia_domingo"] == "1"){$lista[$i]["dia_domingo"] = "si";}else{$lista[$i]["dia_domingo"] = "no";}
    }
    $data = ['data' => $lista];
    echo json_encode($data);
}

function eliminarHorario(){
    $cod_horario = $_POST['cod_horario'];
    $datos = array($cod_horario);
    $modelo = modelo('Horario');
    $resp = $modelo->eliminarHorario($datos);
    $resp = $modelo->eliminarHorarioUsuario($datos);

    $data = ['resp' => $resp];
    echo json_encode($data);
}

function eliminarUsuarioHorario(){
    $cod_horario = $_POST['cod_horario'];
    $cod_usuario = $_POST['cod_usuario'];
    $datos = array($cod_horario, $cod_usuario);
    $modelo = modelo('Horario');
    $resp = $modelo->eliminarUsuarioHorario($datos);

    $data = ['resp' => $resp];
    echo json_encode($data);
}

function horarioEspecifico(){
    $cod_horario = $_POST['cod_horario'];
    $datos = array($cod_horario);
    $modelo = modelo('Horario');
    $lista = $modelo->horarioEspecifico($datos);
    echo json_encode($lista);
}

function asignarUsuarioHorario(){
    $horario = $_POST['horario'];
    $usuario = $_POST['usuario'];
    $data = array();
    $resp = "";

    $datos = array($horario, $usuario);
    $modelo = modelo('Horario');
    $lista = $modelo->verificarHorarioUsuario($datos);
    if(sizeof($lista) == 0){
        $datos = array($horario, $usuario);
        $modelo = modelo('Horario');
        $resp = $modelo->agregarHorarioUsuario($datos);
    }else{
        $resp = "false";
    }

    $data = ['resp' => $resp];
    echo json_encode($data);
}

function agregarHorario(){
    $entrada = $_POST['entrada'];
    $salida = $_POST['salida'];
    $tolerancia = $_POST['tolerancia'];
    $cboxLunes = $_POST['cboxLunes'];
    $cboxMartes = $_POST['cboxMartes'];
    $cboxMiercoles = $_POST['cboxMiercoles'];
    $cboxJueves = $_POST['cboxJueves'];
    $cboxViernes = $_POST['cboxViernes'];
    $cboxSabado = $_POST['cboxSabado'];
    $cboxDomingo = $_POST['cboxDomingo'];
    
    $data = array();
    $resp = "";

    $datos = array($entrada, $salida, $tolerancia, $cboxLunes, $cboxMartes, $cboxMiercoles, $cboxJueves, $cboxViernes, $cboxSabado, $cboxDomingo);
    $modelo = modelo('Horario');
    $resp = $modelo->agregarHorario($datos);

    $data = ['resp' => $resp];
    echo json_encode($data);
}

function actualizarHorario(){
    $codigo = $_POST['codigo'];
    $entrada = $_POST['entrada'];
    $salida = $_POST['salida'];
    $tolerancia = $_POST['tolerancia'];
    $cboxLunes = $_POST['cboxLunes'];
    $cboxMartes = $_POST['cboxMartes'];
    $cboxMiercoles = $_POST['cboxMiercoles'];
    $cboxJueves = $_POST['cboxJueves'];
    $cboxViernes = $_POST['cboxViernes'];
    $cboxSabado = $_POST['cboxSabado'];
    $cboxDomingo = $_POST['cboxDomingo'];
    
    $data = array();
    $resp = "";

    $datos = array($entrada, $salida, $tolerancia, $cboxLunes, $cboxMartes, $cboxMiercoles, $cboxJueves, $cboxViernes, $cboxSabado, $cboxDomingo, $codigo);
    $modelo = modelo('Horario');
    $resp = $modelo->actualizarHorario($datos);

    $data = ['resp' => $resp];
    echo json_encode($data);
}
?>