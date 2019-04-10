<?php
ini_set('display_errors', '1');
session_start();
$action = '';

if (isset($_POST['action'])) {
    $action = $_POST['action'];
    switch ($action) {
        case 'listaSueldos' :
            listaSueldos();
            break;
        case 'listaSueldoUsuarios' :
            listaSueldoUsuarios();
            break;
        case 'agregarSueldo' :
            agregarSueldo();
            break;
        case 'sueldoEspecifico' :
            sueldoEspecifico();
            break;
        case 'actualizarSueldo' :
            actualizarSueldo();
            break;
        case 'eliminarSueldo' :
            eliminarSueldo();
            break;
        case 'eliminarUsuarioSueldo' :
            eliminarUsuarioSueldo();
            break;
        case 'asignarUsuarioSueldo' :
            asignarUsuarioSueldo();
            break;
        case 'planillaSueldo' :
            planillaSueldo();
            break;
    }
}

function modelo($modelo){
    require_once '../modelos/'.$modelo.'.php';
    return new $modelo();
}

function planillaSueldo(){
    $usuario = $_POST['usuario'];
    date_default_timezone_set('America/La_Paz');
    $mes =  $_POST['mes'];
    $año =  $_POST['año'];
    $datos = array($usuario, $mes, $año);
    $modelo = modelo('HuellaDactilar');
    $lista = $modelo->listaRegistroHorarioEspecifico($datos);
    $diaMes = UltimoDia($año, $mes);
    $planilla = "";
    for($j = 1 ; $j <= $diaMes ; $j++){
        $sw = false;
        $c = 0;
        for($i = 0 ; $i < sizeof($lista) ; $i++){
            $diaNum = date("d", strtotime($lista[$i]["fecha_reg_hr"]));
            if($diaNum == $j){
                $c = $i;
                $sw = true;
                break;
            }
        }

        if($sw == true){
            $planilla[$j-1]["fecha_reg_hr"] = date("d/m/Y", strtotime($lista[$c]["fecha_reg_hr"]));
            $planilla[$j-1]["entrada_horario_reg_hr"] = $lista[$c]["entrada_horario_reg_hr"];
        }else{
            $planilla[$j-1]["fecha_reg_hr"] = date("d/m/Y", strtotime($año."-".$mes."-".$j));
            $planilla[$j-1]["entrada_horario_reg_hr"] = "No";
        }
    }

    /*for($i = 0 ; $i < sizeof($lista) ; $i++){

        $dias = array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sabado");
        $fechats = strtotime($lista[$i]["fecha_reg_hr"]); //fecha en yyyy-mm-dd
        $dia = $dias[date('w', $fechats)];
        $diaNum = date("d", strtotime($lista[$i]["fecha_reg_hr"]));
        $lista[$i]["fecha_reg_hr"] = date("d/m/Y", strtotime($lista[$i]["fecha_reg_hr"]))." ".$dia;
*/
        
        /*$fechaFormat = date("d-m-Y", strtotime($lista[$i]["fecha_reg_hr"]));
        $fechats = strtotime($fechaFormat);
        switch (date('w', $fechats)){ 
            case 0: $lista[$i]["fecha_reg_hr"] = $lista[$i]["fecha_reg_hr"]." "."Domingo"; break; 
            case 1: $lista[$i]["fecha_reg_hr"] = $lista[$i]["fecha_reg_hr"]." "."Lunes"; break; 
            case 2: $lista[$i]["fecha_reg_hr"] = $lista[$i]["fecha_reg_hr"]." "."Martes"; break; 
            case 3: $lista[$i]["fecha_reg_hr"] = $lista[$i]["fecha_reg_hr"]." "."Miercoles"; break; 
            case 4: $lista[$i]["fecha_reg_hr"] = $lista[$i]["fecha_reg_hr"]." "."Jueves"; break; 
            case 5: $lista[$i]["fecha_reg_hr"] = $lista[$i]["fecha_reg_hr"]." "."Viernes"; break; 
            case 6: $lista[$i]["fecha_reg_hr"] = $lista[$i]["fecha_reg_hr"]." "."Sabado"; break; 
        }*/

        /*$f1 = new DateTime($lista[$i]["entrada_horario_reg_hr"]);
        $f2 = new DateTime($lista[$i]["salida_horario_reg_hr"]);
        $d = $f1->diff($f2);
        $lista[$i]["diferenciaHora"] = $d->format('%H:%I:%S');

    }*/
    $data = array();
    $data = ['data' => $planilla];
    echo json_encode($data);
}

function listaSueldos(){
    $datos = array();
    $usuarioModelo = modelo('Sueldo');
    $lista = $usuarioModelo->listaSueldos($datos);
    $data = array();
    for($i = 0 ; $i < sizeof($lista) ; $i++){
        $lista[$i]["sueldo"] = "Bs. ".$lista[$i]["sueldo"];
    }
    $data = ['data' => $lista];
    echo json_encode($data);
}

function listaSueldoUsuarios(){
    $sueldo = $_POST['sueldo'];
    $datos = array($sueldo);
    $modelo = modelo('Sueldo');
    $lista = $modelo->listaSueldoUsuarios($datos);
    for($i = 0 ; $i < sizeof($lista) ; $i++){
        $lista[$i]["sueldo"] = "Bs. ".$lista[$i]["sueldo"];
    }
    $data = array();
    $data = ['data' => $lista];
    echo json_encode($data);
}

function eliminarSueldo(){
    $cod_sueldo = $_POST['cod_sueldo'];
    $datos = array($cod_sueldo);
    $modelo = modelo('Sueldo');
    $resp = $modelo->eliminarSueldo($datos);
    $resp = $modelo->eliminarSueldoUsuario($datos);

    $data = ['resp' => $resp];
    echo json_encode($data);
}

function eliminarUsuarioSueldo(){
    $cod_sueldo = $_POST['cod_sueldo'];
    $cod_usuario = $_POST['cod_usuario'];
    $datos = array($cod_sueldo, $cod_usuario);
    $modelo = modelo('Sueldo');
    $resp = $modelo->eliminarUsuarioSueldo($datos);

    $data = ['resp' => $resp];
    echo json_encode($data);
}

function sueldoEspecifico(){
    $cod_sueldo = $_POST['cod_sueldo'];
    $datos = array($cod_sueldo);
    $modelo = modelo('Sueldo');
    $lista = $modelo->sueldoEspecifico($datos);
    echo json_encode($lista);
}

function asignarUsuarioSueldo(){
    $sueldo = $_POST['sueldo'];
    $usuario = $_POST['usuario'];
    $data = array();
    $resp = "";

    $datos = array($sueldo, $usuario);
    $modelo = modelo('Sueldo');
    $lista = $modelo->verificarSueldoUsuario($datos);
    if(sizeof($lista) == 0){
        $datos = array($sueldo, $usuario);
        $modelo = modelo('Sueldo');
        $resp = $modelo->agregarSueldoUsuario($datos);
    }else{
        $resp = "false";
    }

    $data = ['resp' => $resp];
    echo json_encode($data);
}

function agregarSueldo(){
    $sueldo = $_POST['sueldo'];
    
    $data = array();
    $resp = "";

    $datos = array($sueldo);
    $modelo = modelo('Sueldo');
    $resp = $modelo->agregarSueldo($datos);

    $data = ['resp' => $resp];
    echo json_encode($data);
}

function actualizarSueldo(){
    $codigo = $_POST['codigo'];
    $sueldo = $_POST['sueldo'];
    
    $data = array();
    $resp = "";

    $datos = array($sueldo, $codigo);
    $modelo = modelo('Sueldo');
    $resp = $modelo->actualizarSueldo($datos);

    $data = ['resp' => $resp];
    echo json_encode($data);
}

function UltimoDia($anho,$mes){
    if (((fmod($anho,4)==0) and (fmod($anho,100)!=0)) or (fmod($anho,400)==0)) {
        $dias_febrero = 29; 
    } else {
        $dias_febrero = 28; 
    } 
    switch($mes) {
        case 01: return 31; break;
        case 02: return $dias_febrero; break;
        case 03: return 31; break;
        case 04: return 30; break;
        case 05: return 31; break;
        case 06: return 30; break;
        case 07: return 31; break;
        case 8: return 31; break;
        case 9: return 30; break;
        case 10: return 31; break;
        case 11: return 30; break;
        case 12: return 31; break;
    } 
 }
?>