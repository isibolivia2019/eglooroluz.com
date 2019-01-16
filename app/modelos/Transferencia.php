<?php
require_once 'Base.php';
class Transferencia{
	private $db;
	public function __construct(){
		$this->db = new Base;
	}

	public function listaTransferencia($datos){
		$sql = "SELECT producto.cod_producto, cod_item_producto, nombre_producto, imagen_producto, cantidad_producto, compra_unit_producto, observacion_traspaso_producto, fecha_traspaso_producto, hora_traspaso_producto, CONCAT(nombre_usuario, ' ', appat_usuario, ' ', apmat_usuario) as 'personal' FROM traspaso_producto, producto, usuario WHERE traspaso_producto.cod_producto = producto.cod_producto and traspaso_producto.cod_usuario = usuario.cod_usuario and cod_almacenamiento_de = ? and cod_almacenamiento_a = ?;";
		return $this->db->select($sql, $datos);
	}
    
    public function agregarTransferencia($datos){
		$sql = "INSERT INTO traspaso_producto(cod_almacenamiento_de, cod_almacenamiento_a, cod_producto, cantidad_producto, compra_unit_producto, precio_sugerido_venta, observacion_traspaso_producto, fecha_traspaso_producto, hora_traspaso_producto, cod_usuario) VALUES(?,?,?,?,?,?,?,?,?,?);";
		return $this->db->insert($sql, $datos);
	}
}
?>