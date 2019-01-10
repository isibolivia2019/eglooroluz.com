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
}
?>