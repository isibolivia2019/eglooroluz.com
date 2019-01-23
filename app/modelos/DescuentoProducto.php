<?php
require_once 'Base.php';
class DescuentoProducto{
	private $db;
	public function __construct(){
		$this->db = new Base;
	}
    
    public function listaDescuentoProducto($datos){
		$sql = "SELECT cod_descuento_producto, nombre_sucursal, producto.cod_producto, producto.cod_item_producto, producto.nombre_producto, producto.descripcion_producto, producto.color_producto, producto.imagen_producto, porcenta_descuento_producto, descuento_interno, observacion_descuento_producto, fecha_inicio_descuento_producto FROM descuento_producto, inventario, producto, sucursal WHERE inventario.cod_inventario = descuento_producto.cod_inventario and producto.cod_producto = inventario.cod_producto and inventario.cod_almacenamiento = sucursal.cod_sucursal and estado_descuento_producto = 1";
		return $this->db->select($sql, $datos);
	}
}
?>