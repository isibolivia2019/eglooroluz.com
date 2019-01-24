<?php
require_once 'Base.php';
class Venta{
	private $db;
	public function __construct(){
		$this->db = new Base;
	}

	public function agregarVenta($datos){
		$sql = "INSERT INTO venta_producto(cod_sucursal, cod_inventario, cant_venta_producto, descuento_porcentaje_venta_producto, nro_factura_venta_producto, total_venta_producto, fecha_venta_producto, hora_venta_producto, cod_nit, cod_cliente, cod_usuario, codigo_control) VALUES(?,?,?,?,?,?,?,?,?,?,?,?);";
		return $this->db->insert($sql, $datos);
	}

	public function totalPagar($datos){
		$sql = "SELECT * FROM carrito WHERE cod_sucursal = ?";
		return $this->db->select($sql, $datos);
	}

	public function vaciarCarrito($datos){
		$sql = "DELETE FROM carrito WHERE cod_sucursal = ?";
		return $this->db->update($sql, $datos);
	}

	public function eliminarCarrito($datos){
		$sql = "DELETE FROM carrito WHERE cod_carrito = ?";
		return $this->db->update($sql, $datos);
	}

	public function agregarCarrito($datos){
		$sql = "INSERT INTO carrito(cod_inventario, cantidad, descuento, total, cod_sucursal) VALUES(?,?,?,?,?);";
		return $this->db->insert($sql, $datos);
	}

	public function actualizarCarrito($datos){
		$sql = "UPDATE carrito SET cantidad = ?, descuento = ?, total= ? WHERE cod_carrito = ?";
		return $this->db->update($sql, $datos);
	}

	public function listaCarritoEspecifico($datos){
		$sql = "SELECT cod_carrito, inventario.cod_inventario, inventario.cod_almacenamiento, inventario.precio_sugerido_venta, producto.cod_item_producto, producto.nombre_producto, producto.imagen_producto, cantidad, descuento, total, (cantidad * total)as 'subTotal', cod_sucursal FROM carrito, inventario, producto WHERE carrito.cod_inventario = inventario.cod_inventario and producto.cod_producto = inventario.cod_producto and  cod_carrito = ?";
		return $this->db->select($sql, $datos);
	}
    
    public function listaCarrito($datos){
		$sql = "SELECT cod_carrito, inventario.cod_inventario, inventario.cod_almacenamiento, inventario.precio_sugerido_venta, producto.cod_item_producto, producto.nombre_producto, producto.imagen_producto, cantidad, descuento, total, (cantidad * total)as 'subTotal', cod_sucursal FROM carrito, inventario, producto WHERE carrito.cod_inventario = inventario.cod_inventario and producto.cod_producto = inventario.cod_producto and carrito.cod_sucursal = ?";
		return $this->db->select($sql, $datos);
	}

	public function listaVentas($datos){
		$sql = "SELECT venta_producto.cod_sucursal, inventario.cod_inventario, producto.cod_item_producto, producto.nombre_producto, cant_venta_producto, descuento_porcentaje_venta_producto, nro_factura_venta_producto, total_venta_producto, CONCAT(total_venta_producto) as 'precio_unitario', fecha_venta_producto, hora_venta_producto, cod_nit, cod_cliente, CONCAT(nombre_usuario, ' ', appat_usuario, ' ', apmat_usuario) as 'personal', codigo_control FROM venta_producto, inventario, producto, usuario WHERE venta_producto.cod_inventario = inventario.cod_inventario and inventario.cod_producto = producto.cod_producto and venta_producto.cod_usuario = usuario.cod_usuario and cod_sucursal = ? and MONTH(fecha_venta_producto) = ? and YEAR(fecha_venta_producto) = ?;";
		return $this->db->select($sql, $datos);
	}

	public function listaVentaEspecifica($datos){
		$sql = "SELECT venta_producto.cod_sucursal, inventario.cod_inventario, producto.cod_item_producto, producto.nombre_producto, cant_venta_producto, descuento_porcentaje_venta_producto, nro_factura_venta_producto, total_venta_producto, CONCAT(total_venta_producto) as 'precio_unitario', fecha_venta_producto, hora_venta_producto, cod_nit, cod_cliente, CONCAT(nombre_usuario, ' ', appat_usuario, ' ', apmat_usuario) as 'personal', codigo_control FROM venta_producto, inventario, producto, usuario WHERE venta_producto.cod_inventario = inventario.cod_inventario and inventario.cod_producto = producto.cod_producto and venta_producto.cod_usuario = usuario.cod_usuario and venta_producto.cod_inventario = ?;";
		return $this->db->select($sql, $datos);
	}

	public function reporteListaVentas($datos){
		$sql = "SELECT venta_producto.cod_sucursal, sucursal.nombre_sucursal, inventario.cod_inventario, inventario.compra_unit_producto, producto.cod_item_producto, producto.nombre_producto, cant_venta_producto, descuento_porcentaje_venta_producto, nro_factura_venta_producto, total_venta_producto, CONCAT(total_venta_producto) as 'precio_unitario', fecha_venta_producto, hora_venta_producto, cod_nit, cod_cliente, CONCAT(nombre_usuario, ' ', appat_usuario, ' ', apmat_usuario) as 'personal', codigo_control FROM venta_producto, inventario, producto, usuario, sucursal WHERE venta_producto.cod_inventario = inventario.cod_inventario and venta_producto.cod_sucursal = sucursal.cod_sucursal and inventario.cod_producto = producto.cod_producto and venta_producto.cod_usuario = usuario.cod_usuario and venta_producto.cod_sucursal = ? and MONTH(fecha_venta_producto) = ? and YEAR(fecha_venta_producto) = ?;";
		return $this->db->select($sql, $datos);
	}
}
?>