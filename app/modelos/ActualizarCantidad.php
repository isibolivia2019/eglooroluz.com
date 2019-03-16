<?php
require_once 'Base.php';
class ActualizarCantidad{
	private $db;
	public function __construct(){
		$this->db = new Base;
	}
    
    public function listaHistorialCantidadInventario($datos){
	$sql = "SELECT inventario.cod_almacenamiento, cod_item_producto, nombre_producto, compra_unit_producto, precio_sugerido_venta, cantidad, observacion, fecha, hora, CONCAT(nombre_usuario, ' ',appat_usuario, ' ',apmat_usuario) as 'personal' FROM registro_producto_cantidad, inventario, producto, usuario WHERE registro_producto_cantidad.cod_inventario = inventario.cod_inventario and inventario.cod_producto = producto.cod_producto and registro_producto_cantidad.cod_usuario = usuario.cod_usuario and registro_producto_cantidad.cod_inventario = ?";
		return $this->db->select($sql, $datos);
	}

	public function actualizarCantidadInventario($datos){
		$sql = "UPDATE inventario SET cant_producto = ? WHERE cod_inventario = ?";
		return $this->db->update($sql, $datos);
	}

	public function agregarRegistroEditarCantidad($datos){
		$sql = "INSERT INTO registro_producto_cantidad(cod_inventario, cod_almacenamiento, cantidad, observacion, fecha, hora, cod_usuario) VALUES(?,?,?,?,?,?,?)";
		return $this->db->insert($sql, $datos);
	}
}
?>