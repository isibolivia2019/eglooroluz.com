<?php
require_once 'Base.php';
class Cotizacion{
	private $db;
	public function __construct(){
		$this->db = new Base;
	}

	public function totalPagar($datos){
		$sql = "SELECT * FROM carrito_cotizacion WHERE cod_sucursal = ?";
		return $this->db->select($sql, $datos);
	}

	public function vaciarCarrito($datos){
		$sql = "DELETE FROM carrito_cotizacion WHERE cod_sucursal = ?";
		return $this->db->update($sql, $datos);
	}

	public function eliminarCarrito($datos){
		$sql = "DELETE FROM carrito_cotizacion WHERE codigo = ?";
		return $this->db->update($sql, $datos);
	}

	public function agregarCarrito($datos){
		$sql = "INSERT INTO carrito_cotizacion(cod_inventario, cantidad, descuento, total, cod_sucursal) VALUES(?,?,?,?,?);";
		return $this->db->insert($sql, $datos);
	}

	public function actualizarCarrito($datos){
		$sql = "UPDATE carrito_cotizacion SET cantidad = ?, descuento = ?, total= ? WHERE codigo = ?";
		return $this->db->update($sql, $datos);
	}

	public function listaCarritoEspecifico($datos){
		$sql = "SELECT codigo, inventario.cod_inventario, inventario.cod_almacenamiento, inventario.precio_sugerido_venta, producto.cod_item_producto, producto.nombre_producto, producto.imagen_producto, cantidad, descuento, total, (cantidad * total)as 'subTotal', cod_sucursal FROM carrito_cotizacion, inventario, producto WHERE carrito_cotizacion.cod_inventario = inventario.cod_inventario and producto.cod_producto = inventario.cod_producto and codigo = ?";
		return $this->db->select($sql, $datos);
	}
    
    public function listaCarrito($datos){
		$sql = "SELECT codigo, inventario.cod_inventario, inventario.cod_almacenamiento, inventario.precio_sugerido_venta, producto.cod_item_producto, producto.nombre_producto, producto.imagen_producto, cantidad, descuento, total, (cantidad * total)as 'subTotal', cod_sucursal FROM carrito_cotizacion, inventario, producto WHERE carrito_cotizacion.cod_inventario = inventario.cod_inventario and producto.cod_producto = inventario.cod_producto and carrito_cotizacion.cod_sucursal = ?";
		return $this->db->select($sql, $datos);
	}
}
?>