<?php
require_once 'Base.php';
class Sucursal{
	private $db;
	public function __construct(){
		$this->db = new Base;
	}
    
    public function listaSucursales($datos){
		$sql = "SELECT * FROM sucursal";
		return $this->db->select($sql, $datos);
	}

	public function agregarSucursal($datos){
		$sql = "INSERT INTO sucursal(cod_sucursal, nombre_sucursal, direccion_sucursal, imagen_sucursal) VALUES(?,?,?,?);";
		return $this->db->insert($sql, $datos);
	}

	public function sucursalEspecifico($datos){
		$sql = "SELECT * FROM sucursal WHERE cod_sucursal = ?";
		return $this->db->select($sql, $datos);
	}

	public function actualizarSucursal($datos){
		$sql = "UPDATE sucursal SET nombre_sucursal = ?, direccion_sucursal = ? WHERE cod_sucursal = ? ";
		return $this->db->update($sql, $datos);
	}
}
?>