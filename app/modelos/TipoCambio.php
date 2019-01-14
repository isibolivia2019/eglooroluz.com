<?php
require_once 'Base.php';
class TipoCambio{
	private $db;
	public function __construct(){
		$this->db = new Base;
	}
    
    public function TipoCambio($datos){
		$sql = "SELECT * FROM tipo_cambio";
		return $this->db->select($sql, $datos);
	}
}
?>