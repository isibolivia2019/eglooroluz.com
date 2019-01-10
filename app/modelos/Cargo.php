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
}
?>