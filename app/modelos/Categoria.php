<?php
require_once 'Base.php';
class Categoria{
	private $db;
	public function __construct(){
		$this->db = new Base;
	}
    
    public function listaCategorias($datos){
		$sql = "SELECT * FROM categoria";
		return $this->db->select($sql, $datos);
	}
}
?>