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
}
?>