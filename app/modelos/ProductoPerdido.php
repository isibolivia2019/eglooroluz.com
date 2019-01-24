<?php
require_once 'Base.php';
class ProductoPerdido{
	private $db;
	public function __construct(){
		$this->db = new Base;
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