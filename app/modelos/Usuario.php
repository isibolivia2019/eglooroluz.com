<?php
ini_set('display_errors', '1');
define('DB_USER', "root"); // Usuario
define('DB_PASSWORD', '$IsiBolivia2018'); // Contraseña
define('DB_DATABASE', "eglooroluz_bd"); // Nombre de la base de datos
define('DB_LOCALHOST', "localhost:3306"); // localhost

define('DB_SERVER', "127.0.0.1"); // db server --> no es necesario para esta aplicacion

require_once 'Base.php';
class Usuario{
	private $db;
	public function __construct(){
		$this->db = new Base;
	}
	
	public function usuarioPrueba($datos){
		$sql = "SELECT * FROM usuario;";
		return $this->db->select($sql, $datos);
	}

  public function autentificacionUsuario($datos){
		$sql = "SELECT cod_usuario, nombre_usuario, appat_usuario, apmat_usuario, ci_usuario, ci_exp_usuario, genero_usuario, fec_nac_usuario,direccion_usuario, telefono_usuario, nombre_ref_usuario, telefono_ref_usuario, tipo_ref_usuario, email_usuario, pass_usuario, imagen_usuario, nombre_cargo, estado_usuario FROM usuario, cargo WHERE usuario.cod_cargo = cargo.cod_cargo and ci_usuario = ? and pass_usuario = ?;";
		return $this->db->select($sql, $datos);
	}
}
?>