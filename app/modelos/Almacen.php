<?php
require_once 'Base.php';
class Almacen{
	private $db;
	public function __construct(){
		$this->db = new Base;
	}
    
    public function listaAlmacenes($datos){
		$sql = "SELECT * FROM almacen";
		return $this->db->select($sql, $datos);
	}

	public function agregarAlmacen($datos){
		$sql = "INSERT INTO almacen(cod_almacen, nombre_almacen, direccion_almacen) VALUES(?,?,?);";
		return $this->db->insert($sql, $datos);
	}

	public function almacenEspecifico($datos){
		$sql = "SELECT * FROM almacen WHERE cod_almacen = ?";
		return $this->db->select($sql, $datos);
	}

	public function actualizarAlmacen($datos){
		$sql = "UPDATE almacen SET nombre_almacen = ?, direccion_almacen = ? WHERE cod_almacen = ? ";
		return $this->db->update($sql, $datos);
	}
}
?>