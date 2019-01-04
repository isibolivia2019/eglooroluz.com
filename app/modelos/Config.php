<?php
ini_set('display_errors', '1');
class Config{
	protected $dbh;
	public function conexion(){
		try{
			$conectar= $this->dbh= new PDO("mysql:local=".DB_LOCALHOST."; dbname=".DB_DATABASE, DB_USER, DB_PASSWORD);
			return $conectar;
		} catch (PDOException $e){
			return print 'Conexion Fallida a la Base de Datos: ' . $e->getMessage();
		}
	}
	
   	public function set_names(){
		return $this->dbh->query("SET NAMES 'utf8'");
   	}
   	
	static function ruta(){
		return "";
   	}
}
?>