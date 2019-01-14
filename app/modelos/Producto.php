<?php
require_once 'Base.php';
class Producto{
	private $db;
	public function __construct(){
		$this->db = new Base;
	}
    
    public function listaProductos($datos){
		$sql = "SELECT * FROM producto";
		return $this->db->select($sql, $datos);
	}

	public function agregarProducto($datos){
		$sql = "INSERT INTO producto(cod_item_producto, nombre_producto, descripcion_producto, color_producto, imagen_producto, estado_producto) VALUES(?,?,?,?,?,?);";
		return $this->db->select($sql, $datos);
	}
}
?>