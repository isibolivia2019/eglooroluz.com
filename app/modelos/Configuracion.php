<?php
require_once 'Base.php';
class Configuracion{
	private $db;
	public function __construct(){
		$this->db = new Base;
	}

	public function ingresarEmail($datos){
		$sql = "INSERT INTO email_cliente(email) VALUES(?)";
		return $this->db->insert($sql, $datos);
	}

	public function agregarRegistroEditarPrecio($datos){
		$sql = "INSERT INTO registro_producto_editar_precio(cod_inventario, cod_almacenamiento, cantidad, observacion, fecha, hora, cod_usuario) VALUES(?,?,?,?,?,?,?)";
		return $this->db->insert($sql, $datos);
	}
    
  public function actualizarPreciosInventarios($datos){
		$sql = "UPDATE inventario SET compra_unit_producto = ?, precio_sugerido_venta = ? WHERE cod_inventario = ?";
		return $this->db->update($sql, $datos);
	}
}
?>