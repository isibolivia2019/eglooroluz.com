<?php
ini_set('display_errors', '1');
session_start();
$action = '';

if (isset($_POST['action'])) {
    $action = $_POST['action'];
    switch ($action) {
        case 'autentificacionUsuario' :
            autentificacionUsuario();
            break;
        case 'listaUsuarioEstado' :
            listaUsuarioEstado();
            break;
        case 'listaUsuarioSinCargo' :
            listaUsuarioSinCargo();
            break;
        case 'verificarPrivilegio' :
            verificarPrivilegio();
            break;
        case 'usuarioEspecifico' :
            usuarioEspecifico();
            break;
        case 'agregarUsuario' :
            agregarUsuario();
            break;
        case 'actualizarUsuario' :
            actualizarUsuario();
            break;
        case 'cambiarEstado' :
            cambiarEstado();
            break;
    }
}

function modelo($modelo){
    require_once '../modelos/'.$modelo.'.php';
    return new $modelo();
}

function autentificacionUsuario(){
    $usuario = $_POST['usuario'];
    $pass = $_POST['pass'];
    $datos = array($usuario, $pass);
    $usuarioModelo = modelo('Usuario');
    $usuario = $usuarioModelo->autentificacionUsuario($datos);
    if(sizeof($usuario) > 0){
        if($usuario[0]["estado_usuario"] == "1"){
            $_SESSION['tiempoAsigando'] = (60*30);//60 segundos * minutos
            $_SESSION['tiempoSession'] = time();
            $_SESSION['codigo']=$usuario[0]['cod_usuario'];
            $_SESSION['personal']=$usuario[0]['nombre_usuario']." ".$usuario[0]['appat_usuario']." ".$usuario[0]['apmat_usuario'];
            $_SESSION['cargo']=$usuario[0]['nombre_cargo'];
            $datos = array($_SESSION['codigo']);
            $permisos = $usuarioModelo->listaPrivilegiosUsuarios($datos);

            $_SESSION['Permiso_Usuario']=$permisos[0]['itemUsuario'];
            $_SESSION['Permiso_Cargo']=$permisos[0]['itemCargo'];
            $_SESSION['Permiso_Horario']=$permisos[0]['itemHorario'];
            $_SESSION['Permiso_Sueldo']=$permisos[0]['itemSueldo'];
            $_SESSION['Permiso_Sucursal']=$permisos[0]['itemAlmacen'];
            $_SESSION['Permiso_Almacen']=$permisos[0]['itemAlmacen'];
            $_SESSION['Permiso_Producto']=$permisos[0]['itemProducto'];
            $_SESSION['Permiso_Categoria']=$permisos[0]['itemCategoria'];
            $_SESSION['Permiso_Descuento']=$permisos[0]['itemDescuentoProductos'];
            $_SESSION['Permiso_Trasnferencia']=$permisos[0]['itemTraspasoProductos'];
            $_SESSION['Permiso_ProductoPerdido']=$permisos[0]['itemProductosPerdidos'];
            $_SESSION['Permiso_Venta']=$permisos[0]['itemVentas'];
            $_SESSION['Permiso_Reporte']=$permisos[0]['itemReportes'];
            $_SESSION['Permiso_Acceso']=$permisos[0]['itemAccesos'];
            //$_SESSION['Permiso_CajaChica']=$permisos[0]['itemCajaChica'];
            //$_SESSION['Permiso_Cliente']=$permisos[0]['itemCliente'];
            //$_SESSION['Permiso_Configuracion']=$permisos[0]['itemConfiguracion'];
        }
    }
    echo json_encode($usuario);
}

function listaUsuarioSinCargo(){
    $datos = array();
    $modelo = modelo('Usuario');
    $lista = $modelo->listaUsuarioSinCargo($datos);
    echo json_encode($lista);
}

function listaUsuarioEstado(){
    $estado = $_POST['estado'];
    $datos = array($estado);
    $modelo = modelo('Usuario');
    $lista = $modelo->listaUsuarioEstado($datos);
    $data = array();
    $data = ['data' => $lista];
    echo json_encode($data);
}

function cambiarEstado(){
    $codigo = $_POST['codigo'];
    $estado = $_POST['estado'];
    $datos = array($estado, $codigo);
    $modelo = modelo('Usuario');
    $resp = $modelo->cambiarEstado($datos);
    $data = array();
    $data = ['resp' => $resp];
    echo json_encode($data);
}

function usuarioEspecifico(){
    $usuario = $_POST['usuario'];
    $datos = array($usuario);
    $usuarioModelo = modelo('Usuario');
    $lista = $usuarioModelo->usuarioEspecifico($datos);
    echo json_encode($lista);
}

function agregarUsuario(){
    $nombre = $_POST['nombre'];
    $appat = $_POST['appat'];
    $apmat = $_POST['apmat'];
    $ci = $_POST['ci'];
    $ci_exp = $_POST['ci_exp'];
    $genero = $_POST['genero'];
    $fec_nac = $_POST['fec_nac'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $nombreRef = $_POST['nombreRef'];
    $telefonoRef = $_POST['telefonoRef'];
    $tipoRef = $_POST['tipoRef'];
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $codCargo = $_POST['codCargo'];
    $estado = $_POST['estado'];

    $data = array();
    $resp = "";

    $datos = array($nombre, $appat, $apmat, $ci, $ci_exp, $genero, $fec_nac, $direccion, $telefono, $nombreRef, $telefonoRef, $tipoRef, $email, $pass, $codCargo, $estado);
    $modelo = modelo('Usuario');
    $resp = $modelo->agregarUsuario($datos);
    if($resp == "true"){
        $datos = array();
        $lista = $modelo->listaUsuarios($datos);

        $datos = array($lista[sizeof($lista)-1]["cod_usuario"], "1", "1", "1", "1", "1", "1", "1", "1", "1", "1", "1", "1", "1", "1", "1", "1", "1", "1");
        $resp = $modelo->agregarPrivilegio($datos);
    }

    $data = ['resp' => $resp];
    echo json_encode($data);
}

function actualizarUsuario(){
    $codigo = $_POST['codigo'];
    $nombre = $_POST['nombre'];
    $appat = $_POST['appat'];
    $apmat = $_POST['apmat'];
    $ci = $_POST['ci'];
    $ci_exp = $_POST['ci_exp'];
    $genero = $_POST['genero'];
    $fec_nac = $_POST['fec_nac'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $nombreRef = $_POST['nombreRef'];
    $telefonoRef = $_POST['telefonoRef'];
    $tipoRef = $_POST['tipoRef'];
    $email = $_POST['email'];
    $pass = $_POST['pass'];

    $datos = array($nombre, $appat, $apmat, $ci, $ci_exp, $genero, $fec_nac, $direccion, $telefono, $nombreRef, $telefonoRef, $tipoRef, $email, $pass, $codigo);
    $modelo = modelo('Usuario');
    $resp = $modelo->actualizarUsuario($datos);
    $data = ['resp' => $resp];
    echo json_encode($data);
}

function verificarPrivilegio(){
    $privilegio = $_POST['privilegio'];
    $data = array();
    if(isset($_SESSION[$privilegio])){
        if ($_SESSION[$privilegio] == 1) {
            if ((time() - $_SESSION['tiempoSession']) < $_SESSION['tiempoAsigando'] ) {
                $_SESSION['tiempoSession'] = time();
                $data = ['privilegio' => '2'];
            }else{
                session_destroy();
                $data = ['privilegio' => '1'];
            }
        }else{
            session_destroy();
            $data = ['privilegio' => '0'];
        }
    }else{
        session_destroy();
        $data = ['privilegio' => '-1'];
    }
    echo json_encode($data);
}
?>