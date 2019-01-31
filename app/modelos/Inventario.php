<?php
require_once 'Base.php';
class Inventario{
	private $db;
	public function __construct(){
		$this->db = new Base;
	}

	public function listaTodoInventario($datos){
		$sql = "SELECT * FROM inventario;";
		return $this->db->select($sql, $datos);
	}

	public function listaInventarioCodigoAlmacenamiento($datos){
		$sql = "SELECT * FROM inventario WHERE cod_producto = ? and cod_almacenamiento = ?;";
		return $this->db->select($sql, $datos);
	}

	public function listaInventarioCodInventario($datos){
		$sql = "SELECT * FROM inventario WHERE cod_inventario = ?;";
		return $this->db->select($sql, $datos);
	}

	public function listaInventarioActual($datos){
		$sql = "SELECT cod_inventario, cod_almacenamiento, producto.cod_producto, cod_item_producto, imagen_producto, nombre_producto, cant_producto, compra_unit_producto, precio_sugerido_venta, imagen_producto FROM inventario, producto WHERE inventario.cod_producto = producto.cod_producto and cod_almacenamiento = ? ORDER BY cod_item_producto";
		return $this->db->select($sql, $datos);
	}
    
    public function listaInventarioActualStock($datos){
		$sql = "SELECT cod_inventario, cod_almacenamiento, producto.cod_producto, cod_item_producto, imagen_producto, nombre_producto, cant_producto, compra_unit_producto, precio_sugerido_venta, imagen_producto FROM inventario, producto WHERE inventario.cod_producto = producto.cod_producto and cant_producto > 0 and cod_almacenamiento = ? ORDER BY cod_item_producto";
		return $this->db->select($sql, $datos);
	}

	public function listaInventarioCotizaciones($datos){
		$sql = "SELECT cod_inventario, cod_almacenamiento, producto.cod_producto, cod_item_producto, imagen_producto, nombre_producto, cant_producto, compra_unit_producto, precio_sugerido_venta, imagen_producto FROM inventario, producto WHERE inventario.cod_producto = producto.cod_producto GROUP BY cod_producto;";
		return $this->db->select($sql, $datos);
	}

	public function buscarListaInventarioEspecifico($datos){
		$sql = "SELECT * FROM inventario WHERE cod_producto = ? and compra_unit_producto = ? and precio_sugerido_venta = ? and cod_almacenamiento = ?";
		return $this->db->select($sql, $datos);
	}

	public function listaInventarioEspecifico($datos){
		$sql = "SELECT cod_inventario, producto.cod_producto, cod_almacenamiento, cod_item_producto, imagen_producto, nombre_producto, cant_producto, compra_unit_producto, precio_sugerido_venta FROM inventario, producto WHERE inventario.cod_producto = producto.cod_producto and cod_inventario = ?";
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