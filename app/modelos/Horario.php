<?php
require_once 'Base.php';
class Horario{
	private $db;
	public function __construct(){
		$this->db = new Base;
	}
    
    public function listaHorarios($datos){
		$sql = "SELECT * FROM horario";
		return $this->db->select($sql, $datos);
	}
}
?>