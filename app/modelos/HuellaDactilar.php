<?php
require_once 'Base.php';
class HuellaDactilar{
	private $db;
	public function __construct(){
		$this->db = new Base;
	}
    
    public function inicioSoftware($datos){
		$sql = "INSERT INTO inicio_biometrico(fecha, hora, computadora) VALUES(?,?,?)";
		return $this->db->insert($sql, $datos);
	}

	public function finSoftware($datos){
		$sql = "INSERT INTO final_biometrico(fecha, hora, computadora) VALUES(?,?,?)";
		return $this->db->insert($sql, $datos);
	}
}
?>