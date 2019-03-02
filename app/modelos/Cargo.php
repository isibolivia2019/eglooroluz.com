<?php
require_once 'Base.php';
class Cargo{
	private $db;
	public function __construct(){
		$this->db = new Base;
	}
    
  public function listaCargos($datos){
		$sql = "SELECT * FROM cargo";
		return $this->db->select($sql, $datos);
	}

	public function listaCargoUsuarios($datos){
		$sql = "SELECT cargo.nombre_cargo, cargo.descripcion_cargo, nombre_usuario, appat_usuario, apmat_usuario, cargo.cod_cargo, cod_usuario FROM cargo, usuario WHERE cargo.cod_cargo = usuario.cod_cargo and usuario.cod_cargo = ?;";
		return $this->db->select($sql, $datos);
	}

	public function eliminarUsuarioCargo($datos){
		$sql = "UPDATE usuario SET cod_cargo = ? WHERE cod_usuario = ?;";
		return $this->db->update($sql, $datos);
	}

	public function eliminarCargoUsuario($datos){
		$sql = "UPDATE usuario SET cod_cargo = ? WHERE cod_cargo = ?;";
		return $this->db->update($sql, $datos);
	}

	public function eliminarCargo($datos){
		$sql = "DELETE FROM cargo WHERE cod_cargo = ?";
		return $this->db->update($sql, $datos);
	}

	public function cargoEspecifico($datos){
		$sql = "SELECT * FROM cargo WHERE cod_cargo = ?";
		return $this->db->select($sql, $datos);
	}

	public function actualizarCargo($datos){
		$sql = "UPDATE cargo SET nombre_cargo = ?, descripcion_cargo = ? WHERE cod_cargo = ? ";
		return $this->db->update($sql, $datos);
	}

	public function agregarCargo($datos){
		$sql = "INSERT INTO cargo(nombre_cargo, descripcion_cargo) VALUES(?,?);";
		return $this->db->insert($sql, $datos);
	}

	public function agregarCargoUsuario($datos){
		$sql = "UPDATE usuario SET cod_cargo = ? WHERE cod_usuario = ?;";
		return $this->db->insert($sql, $datos);
	}
}
?>