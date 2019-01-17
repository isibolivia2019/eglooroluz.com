<?php
require_once 'Base.php';
class Producto{
	private $db;
	public function __construct(){
		$this->db = new Base;
	}
    
    public function listaProductos($datos){
		$sql = "SELECT * FROM producto";
		return $this->db->select($sql, $datos);
	}

	public function agregarCompra($datos){
		$sql = "INSERT INTO compra_producto(cod_producto, cantidad_compra_producto, precio_unit_compra_producto, precio_sugerido_venta, observacion_compra_producto, fecha_compra_producto, hora_compra_producto, cod_almacenamiento, cod_usuario) VALUES(?,?,?,?,?,?,?,?,?);";
		return $this->db->insert($sql, $datos);
	}

	public function agregarProducto($datos){
		$sql = "INSERT INTO producto(cod_item_producto, nombre_producto, descripcion_producto, color_producto, imagen_producto, estado_producto) VALUES(?,?,?,?,?,?);";
		return $this->db->insert($sql, $datos);
	}

	public function actualizarProducto($datos){
		$sql = "UPDATE producto SET cod_item_producto = ?, nombre_producto = ?, descripcion_producto = ?, color_producto = ? WHERE cod_producto = ? ";
		return $this->db->update($sql, $datos);
	}

	public function actualizarImagenProducto($datos){
		$sql = "UPDATE producto SET imagen_producto = ? WHERE cod_producto = ? ";
		return $this->db->update($sql, $datos);
	}

	public function productoEspecifico($datos){
		$sql = "SELECT * FROM producto WHERE cod_producto = ?";
		return $this->db->select($sql, $datos);
	}

	public function listaCompraProductos($datos){
		$sql = "SELECT cod_compra_producto, cod_item_producto, nombre_producto, imagen_producto, cantidad_compra_producto, precio_unit_compra_producto, precio_sugerido_venta, observacion_compra_producto, fecha_compra_producto, hora_compra_producto, cod_almacenamiento, CONCAT(cod_almacenamiento) as 'nombre_almacenamiento', CONCAT(nombre_usuario, ' ', appat_usuario, ' ', apmat_usuario) as 'personal' FROM compra_producto, producto, usuario WHERE compra_producto.cod_producto = producto.cod_producto and compra_producto.cod_usuario = usuario.cod_usuario;";
		return $this->db->select($sql, $datos);
	}

	public function ultimaCompraProducto($datos){
		$sql = "SELECT * FROM compra_producto WHERE cod_producto = ? ORDER BY cod_compra_producto desc limit 1";
		return $this->db->select($sql, $datos);
	}

	public function reporteListaCompraProductos($datos){
		$sql = "SELECT cod_compra_producto, cod_item_producto, nombre_producto, imagen_producto, cantidad_compra_producto, precio_unit_compra_producto, precio_sugerido_venta, observacion_compra_producto, fecha_compra_producto, hora_compra_producto, cod_almacenamiento, CONCAT(cod_almacenamiento) as 'nombre_almacenamiento', CONCAT(nombre_usuario, ' ', appat_usuario, ' ', apmat_usuario) as 'personal' FROM compra_producto, producto, usuario WHERE compra_producto.cod_producto = producto.cod_producto and compra_producto.cod_usuario = usuario.cod_usuario and MONTH(fecha_compra_producto) = ? and YEAR(fecha_compra_producto) = ?;";
		return $this->db->select($sql, $datos);
	}
	
	public function reporteListaCompraProductosAlmacenamiento($datos){
		$sql = "SELECT cod_compra_producto, cod_item_producto, nombre_producto, imagen_producto, cantidad_compra_producto, precio_unit_compra_producto, precio_sugerido_venta, observacion_compra_producto, fecha_compra_producto, hora_compra_producto, cod_almacenamiento, CONCAT(cod_almacenamiento) as 'nombre_almacenamiento', CONCAT(nombre_usuario, ' ', appat_usuario, ' ', apmat_usuario) as 'personal' FROM compra_producto, producto, usuario WHERE compra_producto.cod_producto = producto.cod_producto and compra_producto.cod_usuario = usuario.cod_usuario and compra_producto.cod_almacenamiento = ? and MONTH(fecha_compra_producto) = ? and YEAR(fecha_compra_producto) = ?;";
		return $this->db->select($sql, $datos);
	}
}
?>