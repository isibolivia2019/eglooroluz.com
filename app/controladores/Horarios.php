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
    }
}

function modelo($modelo){
    require_once '../modelos/'.$modelo.'.php';
    return new $modelo();
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

?>