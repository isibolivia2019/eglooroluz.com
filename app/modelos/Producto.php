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
}
?>