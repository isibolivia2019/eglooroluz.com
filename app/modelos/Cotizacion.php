<?php
require_once 'Base.php';
class Cotizacion{
	private $db;
	public function __construct(){
		$this->db = new Base;
	}

	public function listaCarritoCotizacion($datos){
		$sql = "SELECT codigo, carrito_cotizacion.cod_inventario, cod_item_producto, nombre_producto, imagen_producto, precio_sugerido_venta, sugerido, cantidad, descuento, total FROM carrito_cotizacion, inventario, producto WHERE carrito_cotizacion.cod_inventario = inventario.cod_inventario and inventario.cod_producto = producto.cod_producto and carrito_cotizacion.cod_sucursal = ?";
		return $this->db->select($sql, $datos);
	}

	public function listaCotizacionNroOrden($datos){
		$sql = "SELECT codigo,cod_sucursal, producto.cod_item_producto, producto.nombre_producto, producto.descripcion_producto, producto.color_producto, cotizacion.cant_producto, sugerido, nro_orden, inventario.precio_sugerido_venta, descuento_porcentaje_venta_producto, total_unitario, empresa, personal,fecha,hora FROM cotizacion, inventario, producto WHERE cotizacion.cod_inventario = inventario.cod_inventario and inventario.cod_producto = producto.cod_producto and nro_orden = ?";
		return $this->db->select($sql, $datos);
	}

	public function listaCotizacionUltimo($datos){
		$sql = "SELECT codigo,cod_sucursal, producto.cod_item_producto, producto.nombre_producto, producto.descripcion_producto, producto.color_producto, cotizacion.cant_producto, nro_orden, inventario.precio_sugerido_venta, descuento_porcentaje_venta_producto, total_unitario, empresa, personal,fecha,hora FROM cotizacion, inventario, producto WHERE cotizacion.cod_inventario = inventario.cod_inventario and inventario.cod_producto = producto.cod_producto ORDER BY codigo desc LIMIT 1";
		return $this->db->select($sql, $datos);
	}

	public function agregarCotizacion($datos){
		$sql = "INSERT INTO cotizacion(cod_sucursal, cod_inventario, cant_producto, sugerido, descuento_porcentaje_venta_producto, total_unitario, nro_orden, empresa, personal, fecha, hora, cod_usuario) VALUES(?,?,?,?,?,?,?,?,?,?,?,?);";
		return $this->db->insert($sql, $datos);
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
		$sql = "INSERT INTO carrito_cotizacion(cod_inventario, cantidad, descuento, total, sugerido, cod_sucursal) VALUES(?,?,?,?,?,?);";
		return $this->db->insert($sql, $datos);
	}

	public function actualizarCarrito($datos){
		$sql = "UPDATE carrito_cotizacion SET cantidad = ?, descuento = ?, total= ?, sugerido = ? WHERE codigo = ?";
		return $this->db->update($sql, $datos);
	}

	public function listaCarritoEspecifico($datos){
		$sql = "SELECT codigo, inventario.cod_inventario, inventario.cod_almacenamiento, inventario.precio_sugerido_venta, producto.cod_item_producto, producto.nombre_producto, producto.imagen_producto, cantidad, descuento, total, sugerido, (cantidad * total)as 'subTotal', cod_sucursal FROM carrito_cotizacion, inventario, producto WHERE carrito_cotizacion.cod_inventario = inventario.cod_inventario and producto.cod_producto = inventario.cod_producto and codigo = ?";
		return $this->db->select($sql, $datos);
	}
    
    public function listaCarrito($datos){
		$sql = "SELECT codigo, inventario.cod_inventario, inventario.cod_almacenamiento, inventario.precio_sugerido_venta, producto.cod_item_producto, producto.nombre_producto, producto.imagen_producto, cantidad, descuento, total, sugerido, (cantidad * total)as 'subTotal', cod_sucursal FROM carrito_cotizacion, inventario, producto WHERE carrito_cotizacion.cod_inventario = inventario.cod_inventario and producto.cod_producto = inventario.cod_producto and carrito_cotizacion.cod_sucursal = ?";
		return $this->db->select($sql, $datos);
	}

	public function reporteListaCarrito($datos){
		$sql = "SELECT codigo, inventario.cod_inventario, inventario.cod_almacenamiento, inventario.precio_sugerido_venta, producto.cod_item_producto, producto.nombre_producto, producto.imagen_producto, cantidad, descuento, total, sugerido, (cantidad * total)as 'subTotal', cod_sucursal FROM carrito_cotizacion, inventario, producto WHERE carrito_cotizacion.cod_inventario = inventario.cod_inventario and producto.cod_producto = inventario.cod_producto and carrito_cotizacion.cod_sucursal = ?";
		return $this->db->select($sql, $datos);
	}
}
?>