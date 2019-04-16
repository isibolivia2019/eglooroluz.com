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
        case 'planillaSueldoInicio' :
            planillaSueldoInicio();
            break;
        case 'planillaSueldoModificado' :
            planillaSueldoModificado();
            break;
    }
}

function modelo($modelo){
    require_once '../modelos/'.$modelo.'.php';
    return new $modelo();
}

function planillaSueldoInicio(){
    $usuario = $_POST['usuario'];
    date_default_timezone_set('America/La_Paz');
    $mes =  $_POST['mes'];
    $año =  $_POST['año'];
    $diasPost =  $_POST['diasPost'];
    $diasElminados =  $_POST['diasElminados'];
    $diaMes = 0;

    $datos = array($usuario, $mes, $año);
    $modelo = modelo('HuellaDactilar');
    $lista = $modelo->listaRegistroHorarioEspecifico($datos);

    $datos = array($usuario);
    $modelo = modelo('Horario');
    $listaHorario = $modelo->horarioEspecificoUsuario($datos);

    $datos = array($usuario);
    $modelo = modelo('Sueldo');
    $listaSueldo = $modelo->sueldoEspecificoUsuario($datos);

    $planilla = "";

    if($diasPost == 0){
        $diaMes = UltimoDia($año, $mes);
    }else{
        $diaMes = $diasPost;
    }

    $c = 1;
    $cDias = 1;
    echo "dias:".$diasElminados;
    while($cDias <= $diaMes){
        $dias = array("Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado");
        $fechats = strtotime($año."-".$mes."-".$cDias); //fecha en yyyy-mm-dd
        $dia = $dias[date('w', $fechats)];
        $diaLiteral = "dia_".strtolower($dia);

        $swDiaEliminado = false;
        for($aa = 0 ; $aa < sizeOf($diasElminados) ; $aa++){
            if((integer)$diasElminados[$aa] == (integer)$cDias){
                echo "if:SII".(integer)$diasElminados[$aa];
                $swDiaEliminado = true;
                break;
            }
        }

        if($swDiaEliminado == true){
            
        }else{
            $cc = 0;
            while($cc < sizeof($listaHorario)){
                if($listaHorario[$cc][$diaLiteral] == "1"){
                    $sw = false;
                    $cLista = 0;
                    for($a=0;$a<sizeof($lista);$a++){
                        $diaLista = date("d", strtotime($lista[$a]["fecha_reg_hr"]));
                        if($cDias == $diaLista){
                            $sw = true;
                            $cLista = $a;
                            break;
                        }
                    }
    
                    $f1 = new DateTime($listaHorario[$cc]["entrada_horario"]);
                    $f2 = new DateTime($listaHorario[$cc]["salida_horario"]);
                    $d = $f1->diff($f2);
                    $planilla[$c-1]["diferenciaTrabajo"] = $d->format('%H:%I:%S');
                    $f1 = new DateTime($listaHorario[$cc]["tiempo_espera"]);
                    $f2 = new DateTime($planilla[$c-1]["diferenciaTrabajo"]);
                    $d = $f1->diff($f2);
                    $planilla[$c-1]["diferenciaTrabajo"] = $d->format('%H:%I:%S');
    
                    if($sw == true){
                        if($lista[$cLista]["entrada_horario_reg_hr"]){
                            $planilla[$c-1]["entrada_horario_reg_hr"] = $lista[$cLista]["entrada_horario_reg_hr"];
                        }else{
                            $planilla[$c-1]["entrada_horario_reg_hr"] = "- -";
                        }
                        if($lista[$cLista]["salida_horario_reg_hr"]){
                            $planilla[$c-1]["salida_horario_reg_hr"] = $lista[$cLista]["salida_horario_reg_hr"];
                        }else{
                            $planilla[$c-1]["salida_horario_reg_hr"] = "- -";
                        }
    
                        if($lista[$cLista]["entrada_horario_reg_hr"]){
                            if($lista[$cLista]["salida_horario_reg_hr"]){
                                $f1 = new DateTime($lista[$cLista]["entrada_horario_reg_hr"]);
                                $f2 = new DateTime($lista[$cLista]["salida_horario_reg_hr"]);
                                $d = $f1->diff($f2);
                                $planilla[$c-1]["diferenciaHora"] = $d->format('%H:%I:%S');
                            }else{
                                $planilla[$c-1]["diferenciaHora"] = "00:00:00";
                            }
                        }else{
                            $planilla[$c-1]["diferenciaHora"] = "00:00:00";
                        }
    
                        $planilla[$c-1]["fecha_reg_hr"] = date("d/m/Y", strtotime($año."-".$mes."-".$cDias))." ".$dia;
    
                        $planilla[$c-1]["observacion_entrada"] = $lista[$cLista]["observacion_entrada"];
                        $planilla[$c-1]["observacion_salida"] = $lista[$cLista]["observacion_salida"];
                        
                        $planilla[$c-1]["totalPago"] = "0.00";
                    }else{
                        $planilla[$c-1]["fecha_reg_hr"] = date("d/m/Y", strtotime($año."-".$mes."-".$cDias))." ".$dia;
                        $planilla[$c-1]["entrada_horario_reg_hr"] = "- -";
                        $planilla[$c-1]["salida_horario_reg_hr"] = "- -";
                        $planilla[$c-1]["observacion_entrada"] = "- -";
                        $planilla[$c-1]["observacion_salida"] = "- -";
                        $planilla[$c-1]["diferenciaHora"] = "00:00:00";
                        $planilla[$c-1]["totalPago"] = '0.00';
                    }
                    
                    $c++;
                }
                $cc++;
            }
            
        }

        
        $cDias++;
    }

    $sueldoDia = round($listaSueldo[0]["sueldo"] / ($c-1), 2);;
    for($i=0;$i<sizeof($planilla);$i++){
        $planilla[$i]["totalPago"] = $sueldoDia;
        if($planilla[$i]["diferenciaHora"] == "00:00:00"){
            $planilla[$i]["totalPago"] = "0.00";
        }

        if($planilla[$i]["diferenciaHora"] >= $planilla[$i]["diferenciaTrabajo"]){
            $planilla[$i]["totalPago"] = $sueldoDia;
        }else{
            list($horas, $minutos, $segundos) = explode(':', $planilla[$i]["diferenciaHora"]);
            $minutosDiferencia= ($horas * 60 ) + $minutos;
            $minutosDiferencia;  

            list($horas, $minutos, $segundos) = explode(':', $planilla[$i]["diferenciaTrabajo"]);
            $minutosTrabajo= ($horas * 60 ) + $minutos;
            $minutosTrabajo;  

            $sueldoMinuto = round($sueldoDia / $minutosTrabajo, 3);
            $planilla[$i]["totalPago"] = round($sueldoMinuto * $minutosDiferencia, 2);
        }
    }
    
    $data = array();
    $data = ['data' => $planilla];
    echo json_encode($data);
}

function planillaSueldoModificado(){
    $usuario = $_POST['usuario'];
    date_default_timezone_set('America/La_Paz');
    $mes =  $_POST['mes'];
    $año =  $_POST['año'];
    $diasPost =  $_POST['diasPost'];
    
    $diaMes = 0;

    $datos = array($usuario, $mes, $año);
    $modelo = modelo('HuellaDactilar');
    $lista = $modelo->listaRegistroHorarioEspecifico($datos);

    $datos = array($usuario);
    $modelo = modelo('Horario');
    $listaHorario = $modelo->horarioEspecificoUsuario($datos);

    $datos = array($usuario);
    $modelo = modelo('Sueldo');
    $listaSueldo = $modelo->sueldoEspecificoUsuario($datos);

    $planilla = "";

    if($diasPost == 0){
        $diaMes = UltimoDia($año, $mes);
    }else{
        $diaMes = $diasPost;
    }

    $c = 1;
    $cDias = 1;
    
    while($cDias <= $diaMes){
        $dias = array("Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado");
        $fechats = strtotime($año."-".$mes."-".$cDias); //fecha en yyyy-mm-dd
        $dia = $dias[date('w', $fechats)];
        $diaLiteral = "dia_".strtolower($dia);

        $cc = 0;
        while($cc < sizeof($listaHorario)){
            if($listaHorario[$cc][$diaLiteral] == "1"){
                $sw = false;
                $cLista = 0;
                for($a=0;$a<sizeof($lista);$a++){
                    $diaLista = date("d", strtotime($lista[$a]["fecha_reg_hr"]));
                    if($cDias == $diaLista){
                        $sw = true;
                        $cLista = $a;
                        break;
                    }
                }

                $f1 = new DateTime($listaHorario[$cc]["entrada_horario"]);
                $f2 = new DateTime($listaHorario[$cc]["salida_horario"]);
                $d = $f1->diff($f2);
                $planilla[$c-1]["diferenciaTrabajo"] = $d->format('%H:%I:%S');
                $f1 = new DateTime($listaHorario[$cc]["tiempo_espera"]);
                $f2 = new DateTime($planilla[$c-1]["diferenciaTrabajo"]);
                $d = $f1->diff($f2);
                $planilla[$c-1]["diferenciaTrabajo"] = $d->format('%H:%I:%S');

                if($sw == true){
                    if($lista[$cLista]["entrada_horario_reg_hr"]){
                        $planilla[$c-1]["entrada_horario_reg_hr"] = $lista[$cLista]["entrada_horario_reg_hr"];
                    }else{
                        $planilla[$c-1]["entrada_horario_reg_hr"] = "- -";
                    }
                    if($lista[$cLista]["salida_horario_reg_hr"]){
                        $planilla[$c-1]["salida_horario_reg_hr"] = $lista[$cLista]["salida_horario_reg_hr"];
                    }else{
                        $planilla[$c-1]["salida_horario_reg_hr"] = "- -";
                    }

                    if($lista[$cLista]["entrada_horario_reg_hr"]){
                        if($lista[$cLista]["salida_horario_reg_hr"]){
                            $f1 = new DateTime($lista[$cLista]["entrada_horario_reg_hr"]);
                            $f2 = new DateTime($lista[$cLista]["salida_horario_reg_hr"]);
                            $d = $f1->diff($f2);
                            $planilla[$c-1]["diferenciaHora"] = $d->format('%H:%I:%S');
                        }else{
                            $planilla[$c-1]["diferenciaHora"] = "00:00:00";
                        }
                    }else{
                        $planilla[$c-1]["diferenciaHora"] = "00:00:00";
                    }

                    $planilla[$c-1]["fecha_reg_hr"] = date("d/m/Y", strtotime($año."-".$mes."-".$cDias))." ".$dia;

                    $planilla[$c-1]["observacion_entrada"] = $lista[$cLista]["observacion_entrada"];
                    $planilla[$c-1]["observacion_salida"] = $lista[$cLista]["observacion_salida"];
                    
                    $planilla[$c-1]["totalPago"] = "0.00";
                }else{
                    $planilla[$c-1]["fecha_reg_hr"] = date("d/m/Y", strtotime($año."-".$mes."-".$cDias))." ".$dia;
                    $planilla[$c-1]["entrada_horario_reg_hr"] = "- -";
                    $planilla[$c-1]["salida_horario_reg_hr"] = "- -";
                    $planilla[$c-1]["observacion_entrada"] = "- -";
                    $planilla[$c-1]["observacion_salida"] = "- -";
                    $planilla[$c-1]["diferenciaHora"] = "00:00:00";
                    $planilla[$c-1]["totalPago"] = '0.00';
                }
                
                $c++;
            }
            $cc++;
        }
        
        $cDias++;
    }

    $sueldoDia = round($listaSueldo[0]["sueldo"] / ($c-1), 2);;
    for($i=0;$i<sizeof($planilla);$i++){
        $planilla[$i]["totalPago"] = $sueldoDia;
        if($planilla[$i]["diferenciaHora"] == "00:00:00"){
            $planilla[$i]["totalPago"] = "0.00";
        }

        if($planilla[$i]["diferenciaHora"] >= $planilla[$i]["diferenciaTrabajo"]){
            $planilla[$i]["totalPago"] = $sueldoDia;
        }else{
            list($horas, $minutos, $segundos) = explode(':', $planilla[$i]["diferenciaHora"]);
            $minutosDiferencia= ($horas * 60 ) + $minutos;
            $minutosDiferencia;  

            list($horas, $minutos, $segundos) = explode(':', $planilla[$i]["diferenciaTrabajo"]);
            $minutosTrabajo= ($horas * 60 ) + $minutos;
            $minutosTrabajo;  

            $sueldoMinuto = round($sueldoDia / $minutosTrabajo, 3);
            $planilla[$i]["totalPago"] = round($sueldoMinuto * $minutosDiferencia, 2);
        }
    }
    
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