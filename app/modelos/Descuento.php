<?php
require_once 'Base.php';
class Descuento{
	private $db;
	public function __construct(){
		$this->db = new Base;
	}

	public function agregarDescuento($datos){
		$sql = "INSERT INTO descuento_producto(cod_inventario, porcenta_descuento_producto, descuento_interno, observacion_descuento_producto, fecha_inicio_descuento_producto, estado_descuento_producto, cod_usuario) VALUES(?,?,?,?,?,?,?);";
		return $this->db->insert($sql, $datos);
	}

	public function verificarProductoDescuento($datos){
		$sql = "SELECT * FROM descuento_producto WHERE cod_inventario = ?, estado_descuento_producto = ?;";
		return $this->db->select($sql, $datos);
	}
    
  public function listaDescuentosActivos($datos){
		$sql = "SELECT cod_descuento_producto, inventario.cod_inventario, inventario.cod_almacenamiento, producto.cod_producto, producto.cod_item_producto, producto.nombre_producto, porcenta_descuento_producto, descuento_interno, observacion_descuento_producto, fecha_inicio_descuento_producto, fecha_final_descuento_producto, estado_descuento_producto, cod_usuario FROM descuento_producto, inventario, producto WHERE descuento_producto.cod_inventario = inventario.cod_inventario and producto.cod_producto = inventario.cod_producto and estado_descuento_producto = ?;";
		return $this->db->select($sql, $datos);
	}

	public function listaDescuentosTodo($datos){
		$sql = "SELECT cod_descuento_producto, inventario.cod_inventario, inventario.cod_almacenamiento, producto.cod_producto, producto.cod_item_producto, producto.nombre_producto, porcenta_descuento_producto, descuento_interno, observacion_descuento_producto, fecha_inicio_descuento_producto, fecha_final_descuento_producto, estado_descuento_producto, cod_usuario FROM descuento_producto, inventario, producto WHERE descuento_producto.cod_inventario = inventario.cod_inventario and producto.cod_producto = inventario.cod_producto;";
		return $this->db->select($sql, $datos);
	}

	public function eliminarDescuento($datos){
		$sql = "UPDATE descuento_producto SET fecha_final_descuento_producto = ?, estado_descuento_producto = ? WHERE cod_descuento_producto = ? ";
		return $this->db->update($sql, $datos);
	}
}
?>