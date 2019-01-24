<?php
require_once 'Base.php';
class ActualizarPrecio{
	private $db;
	public function __construct(){
		$this->db = new Base;
	}
    
    public function listaHistorialEditarPrecioInventario($datos){
		$sql = "SELECT inventario.cod_almacenamiento, cod_item_producto, nombre_producto, compra_unit_producto, precio_sugerido_venta, cantidad, observacion, fecha, hora, CONCAT(nombre_usuario, ' ',appat_usuario, ' ',apmat_usuario) as 'personal' FROM registro_producto_editar_precio, inventario, producto, usuario WHERE registro_producto_editar_precio.cod_inventario = inventario.cod_inventario and inventario.cod_producto = producto.cod_producto and registro_producto_editar_precio.cod_usuario = usuario.cod_usuario and registro_producto_editar_precio.cod_inventario = ?";
		return $this->db->select($sql, $datos);
	}
}
?>