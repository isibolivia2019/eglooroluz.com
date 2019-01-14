<?php
require_once 'Base.php';
class Descuento{
	private $db;
	public function __construct(){
		$this->db = new Base;
	}
    
    public function listaDescuentos($datos){
		$sql = "SELECT * FROM descuento_producto";
		return $this->db->select($sql, $datos);
	}
}
?>