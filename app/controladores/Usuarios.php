<?php
require_once 'Controlador.php';
class Usuarios extends Controlador{
    public function __construct(){
        $this->usuarioModelo = $this->modelo('Usuario');
    }

    public function usuarioPrueba(){
        $datos = array();
        $usuario = $this->usuarioModelo->usuarioPrueba($datos);
        return $usuario;
    }

    public function autentificacionLogin(){
        /*$usuario = $_POST['usuario'];
        $pass = $_POST['pass'];
        if(!empty($usuario)){
            $datos = array($usuario, $pass);
            $usuario = $this->usuarioModelo->autentificacionUsuario($datos);
            if(sizeof($usuario) > 0){
                setcookie("mycod", $usuario[0]['cod_usuario'], time() + (3600 * 12));
                $_SESSION['tiempoAsigando'] = (60*30);//60 segundos * minutos
                $_SESSION['tiempoSession'] = time();
                $_SESSION['codigo']=$usuario[0]['cod_usuario'];
                $_SESSION['personal']=$usuario[0]['nombre_usuario']." ".$usuario[0]['appat_usuario']." ".$usuario[0]['apmat_usuario'];
                require_once('../app/controladores/UsuariosPrivilegios.php');
                $privilegios = new UsuariosPrivilegios();
                $permisos = $privilegios->listaUsuarioActual($_SESSION['codigo']);
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
                $_SESSION['Permiso_CajaChica']=$permisos[0]['itemCajaChica'];
                $_SESSION['Permiso_Cliente']=$permisos[0]['itemCliente'];
                $_SESSION['Permiso_Configuracion']=$permisos[0]['itemConfiguracion'];
                session_start();
                redireccionar('Inicio');
            }else{
                echo "<script> alert('EL USUARIO Y CONTRASEÑA SON INCORRECTOS ');window.location='http://eglooroluz.com/Logins'</script>";
            }
        }else{
            echo "<script> alert('NO PUEDE DEJAR CAMPOS VACIOS. VUELVA A INTENTARLO');window.location='http://eglooroluz.com/Logins'</script>";
        }*/
    }
}
?>