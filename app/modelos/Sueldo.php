<?php
require_once 'Base.php';
class Sueldo{
	private $db;
	public function __construct(){
		$this->db = new Base;
	}
    
    public function listaSueldos($datos){
		$sql = "SELECT * FROM sueldo";
		return $this->db->select($sql, $datos);
	}

	public function agregarSueldo($datos){
		$sql = "INSERT INTO sueldo(sueldo) VALUES(?);";
		return $this->db->insert($sql, $datos);
	}

	public function actualizarSueldo($datos){
		$sql = "UPDATE sueldo SET sueldo = ? WHERE cod_sueldo = ? ";
		return $this->db->update($sql, $datos);
	}

	public function sueldoEspecifico($datos){
		$sql = "SELECT * FROM sueldo WHERE cod_sueldo = ?";
		return $this->db->select($sql, $datos);
	}

	public function eliminarSueldo($datos){
		$sql = "DELETE FROM sueldo WHERE cod_sueldo = ?";
		return $this->db->update($sql, $datos);
	}

	public function agregarSueldoUsuario($datos){
		$sql = "INSERT INTO sueldo_usuario(cod_sueldo, cod_usuario) VALUES(?,?);";
		return $this->db->insert($sql, $datos);
	}

	public function verificarSueldoUsuario($datos){
		$sql = "SELECT * FROM sueldo_usuario WHERE cod_sueldo = ? and cod_usuario = ?";
		return $this->db->select($sql, $datos);
	}

	public function listaSueldoUsuarios($datos){
		$sql = "SELECT sueldo.sueldo, nombre_usuario, appat_usuario, apmat_usuario, sueldo_usuario.cod_sueldo, sueldo_usuario.cod_usuario FROM sueldo_usuario, sueldo, usuario WHERE sueldo_usuario.cod_sueldo = sueldo.cod_sueldo and sueldo_usuario.cod_usuario = usuario.cod_usuario and sueldo_usuario.cod_sueldo = ?";
		return $this->db->select($sql, $datos);
	}

	public function eliminarUsuarioSueldo($datos){
		$sql = "DELETE FROM sueldo_usuario WHERE cod_sueldo = ? and cod_usuario = ?";
		return $this->db->update($sql, $datos);
	}
	
	public function eliminarSueldoUsuario($datos){
		$sql = "DELETE FROM sueldo_usuario WHERE cod_sueldo = ?";
		return $this->db->update($sql, $datos);
	}
}
?>