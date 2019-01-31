<?php
require_once 'Base.php';
class ProductoPerdido{
	private $db;
	public function __construct(){
		$this->db = new Base;
	}

	public function listaProductoPerdidos($datos){
		$sql = "SELECT * FROM producto_perdido";
		return $this->db->select($sql, $datos);
	}

	public function actualizaCodInventarioProductoPerdidos($datos){
		$sql = "UPDATE producto_perdido SET cod_inventario = ? WHERE cod_producto_perdido = ?";
		return $this->db->update($sql, $datos);
	}

	public function listaProductoPerdidosReg($datos){
		$sql = "SELECT * FROM producto_perdido_reg";
		return $this->db->select($sql, $datos);
	}

	public function actualizaCodInventarioProductoPerdidosReg($datos){
		$sql = "UPDATE producto_perdido_reg SET cod_inventario = ? WHERE cod_producto_perdido_reg = ?";
		return $this->db->update($sql, $datos);
	}

	public function agregarProductoPerdidoRegistro($datos){
		$sql = "INSERT INTO producto_perdido_reg(cod_almacenamiento, cod_producto, cant_producto, compra_unit_producto, precio_sugerido_venta, observacion_producto_perdido, fecha_producto_perdido, hora_producto_perdido, estado, cod_usuario, cod_inventario) VALUES(?,?,?,?,?,?,?,?,?,?,?);";
		return $this->db->insert($sql, $datos);
	}

	public function agregarProductoPerdidos($datos){
		$sql = "INSERT INTO producto_perdido(cod_almacenamiento, cod_producto, cant_producto, compra_unit_producto, precio_sugerido_venta, observacion_producto_perdido, cod_inventario) VALUES(?,?,?,?,?,?,?);";
		return $this->db->insert($sql, $datos);
	}

	public function actualizarCantidadProductoPerdidos($datos){
		$sql = "UPDATE producto_perdido SET cant_producto = ? WHERE cod_producto_perdido = ?";
		return $this->db->update($sql, $datos);
	}

	public function buscarProductoPerdidos($datos){
		$sql = "SELECT * FROM producto_perdido WHERE cod_inventario = ? and observacion_producto_perdido = ?";
		return $this->db->select($sql, $datos);
	}

	public function listaInventarioPerdidos($datos){
		$sql = "SELECT cod_producto_perdido, cod_inventario, cod_almacenamiento, cod_item_producto, nombre_producto, imagen_producto, cant_producto, compra_unit_producto, precio_sugerido_venta, observacion_producto_perdido FROM producto_perdido, producto WHERE producto_perdido.cod_producto = producto.cod_producto";
		return $this->db->select($sql, $datos);
	}

	public function listaRegistrosProductosPerdidos($datos){
		$sql = "SELECT cod_almacenamiento, CONCAT(cod_almacenamiento) as 'nombre_almacenamiento', imagen_producto, cod_item_producto, nombre_producto, cant_producto, compra_unit_producto, precio_sugerido_venta, observacion_producto_perdido, fecha_producto_perdido, hora_producto_perdido, estado, CONCAT(nombre_usuario, ' ',appat_usuario, ' ',apmat_usuario) as 'personal' FROM producto_perdido_reg, producto, usuario WHERE producto_perdido_reg.cod_producto = producto.cod_producto and producto_perdido_reg.cod_usuario = usuario.cod_usuario";
		return $this->db->select($sql, $datos);
	}
    
    public function listaPerdidos($datos){
		$sql = "SELECT cod_almacenamiento, cod_item_producto, nombre_producto, cant_producto, compra_unit_producto, precio_sugerido_venta, observacion_producto_perdido, fecha_producto_perdido, hora_producto_perdido, estado, CONCAT(nombre_usuario, ' ',appat_usuario, ' ',apmat_usuario) as 'personal' FROM producto_perdido_reg, producto, usuario WHERE producto_perdido_reg.cod_producto = producto.cod_producto and producto_perdido_reg.cod_usuario = usuario.cod_usuario and estado = 1 and producto_perdido_reg.cod_producto = ? and compra_unit_producto = ? and precio_sugerido_venta = ? and cod_almacenamiento = ?";
		return $this->db->select($sql, $datos);
	}

	public function listaPerdidosReponido($datos){
		$sql = "SELECT cod_almacenamiento, cod_item_producto, nombre_producto, cant_producto, compra_unit_producto, precio_sugerido_venta, observacion_producto_perdido, fecha_producto_perdido, hora_producto_perdido, estado, CONCAT(nombre_usuario, ' ',appat_usuario, ' ',apmat_usuario) as 'personal' FROM producto_perdido_reg, producto, usuario WHERE producto_perdido_reg.cod_producto = producto.cod_producto and producto_perdido_reg.cod_usuario = usuario.cod_usuario and estado = 0 and producto_perdido_reg.cod_producto = ? and compra_unit_producto = ? and precio_sugerido_venta = ? and cod_almacenamiento = ?";
		return $this->db->select($sql, $datos);
	}
}
?>