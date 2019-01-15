<?php
require_once 'Base.php';
class Inventario{
	private $db;
	public function __construct(){
		$this->db = new Base;
	}
    
    public function listaInventarioActual($datos){
		$sql = "SELECT cod_inventario, cod_almacenamiento, cod_item_producto, imagen_producto, nombre_producto, cant_producto, compra_unit_producto, precio_sugerido_venta FROM inventario, producto WHERE inventario.cod_producto = producto.cod_producto and cod_almacenamiento = ? ORDER BY cod_item_producto";
		return $this->db->select($sql, $datos);
	}

	public function listaInventarioEspecifico($datos){
		$sql = "SELECT cod_inventario, cod_almacenamiento, cod_item_producto, imagen_producto, nombre_producto, cant_producto, compra_unit_producto, precio_sugerido_venta FROM inventario, producto WHERE inventario.cod_producto = producto.cod_producto and cod_inventario = ?";
		return $this->db->select($sql, $datos);
	}

	public function listaInventarioCodigoAlmanenamiento($datos){
	$sql = "SELECT cod_inventario, cod_almacenamiento, cod_item_producto, imagen_producto, nombre_producto, cant_producto, compra_unit_producto, precio_sugerido_venta FROM inventario, producto WHERE inventario.cod_producto = producto.cod_producto and inventario.cod_producto = ? and inventario.cod_almacenamiento = ?";
		return $this->db->select($sql, $datos);
	}

	public function agregarInventario($datos){
		$sql = "INSERT inventario(cod_almacenamiento, cod_producto, cant_producto, compra_unit_producto, precio_sugerido_venta) VALUES(?,?,?,?,?);";
		return $this->db->insert($sql, $datos);
	}

	public function actualizarCantidadInventario($datos){
		$sql = "UPDATE inventario SET cant_producto = ? WHERE cod_inventario = ?";
		return $this->db->update($sql, $datos);
	}

}
?>