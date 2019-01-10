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
}
?>