<?php
require_once 'Base.php';
class Transferencia{
	private $db;
	public function __construct(){
		$this->db = new Base;
	}
	public function listaTrans($datos){
		$sql = "SELECT * FROM traspaso_producto;";
		return $this->db->select($sql, $datos);
	}

	public function listaTransOrigenNull($datos){
		$sql = "SELECT * FROM traspaso_producto WHERE cod_inventario_de IS NULL;";
		return $this->db->select($sql, $datos);
	}

	public function listaTransDestinoNull($datos){
		$sql = "SELECT * FROM traspaso_producto WHERE cod_inventario_a IS NULL;";
		return $this->db->select($sql, $datos);
	}

	public function actualizaCodInventarioDe($datos){
		$sql = "UPDATE traspaso_producto SET cod_inventario_de = ? WHERE cod_traspaso_producto = ? ";
		return $this->db->update($sql, $datos);
	}

	public function actualizaCodInventarioA($datos){
		$sql = "UPDATE traspaso_producto SET cod_inventario_a = ? WHERE cod_traspaso_producto = ? ";
		return $this->db->update($sql, $datos);
	}


	public function listaTransferencia($datos){
		$sql = "SELECT producto.cod_producto, cod_item_producto, nombre_producto, imagen_producto, cantidad_producto, compra_unit_producto, observacion_traspaso_producto, fecha_traspaso_producto, hora_traspaso_producto, CONCAT(nombre_usuario, ' ', appat_usuario, ' ', apmat_usuario) as 'personal' FROM traspaso_producto, producto, usuario WHERE traspaso_producto.cod_producto = producto.cod_producto and traspaso_producto.cod_usuario = usuario.cod_usuario and cod_almacenamiento_de = ? and cod_almacenamiento_a = ?;";
		return $this->db->select($sql, $datos);
	}

	public function listaTransferenciaEspecificoOrigen($datos){
		$sql = "SELECT cod_almacenamiento_a, cod_almacenamiento_de, producto.cod_producto, cod_item_producto, nombre_producto, imagen_producto, cantidad_producto, compra_unit_producto, precio_sugerido_venta, observacion_traspaso_producto, fecha_traspaso_producto, hora_traspaso_producto, CONCAT(nombre_usuario, ' ', appat_usuario, ' ', apmat_usuario) as 'personal' FROM traspaso_producto, producto, usuario WHERE traspaso_producto.cod_producto = producto.cod_producto and traspaso_producto.cod_usuario = usuario.cod_usuario and cod_almacenamiento_de = ? and traspaso_producto.cod_producto = ? and traspaso_producto.compra_unit_producto = ? and traspaso_producto.precio_sugerido_venta = ?;";
		return $this->db->select($sql, $datos);
	}

	public function listaTransferenciaInventarioEspecificoOrigen($datos){
		$sql = "SELECT cod_almacenamiento_a, cod_almacenamiento_de, producto.cod_producto, cod_item_producto, nombre_producto, imagen_producto, cantidad_producto, compra_unit_producto, precio_sugerido_venta, observacion_traspaso_producto, fecha_traspaso_producto, hora_traspaso_producto, CONCAT(nombre_usuario, ' ', appat_usuario, ' ', apmat_usuario) as 'personal' FROM traspaso_producto, producto, usuario WHERE traspaso_producto.cod_producto = producto.cod_producto and traspaso_producto.cod_usuario = usuario.cod_usuario and cod_inventario_de = ?;";
		return $this->db->select($sql, $datos);
	}

	public function listaTransferenciaInventarioEspecificoDestino($datos){
		$sql = "SELECT cod_almacenamiento_a, cod_almacenamiento_de, producto.cod_producto, cod_item_producto, nombre_producto, imagen_producto, cantidad_producto, compra_unit_producto, precio_sugerido_venta, observacion_traspaso_producto, fecha_traspaso_producto, hora_traspaso_producto, CONCAT(nombre_usuario, ' ', appat_usuario, ' ', apmat_usuario) as 'personal' FROM traspaso_producto, producto, usuario WHERE traspaso_producto.cod_producto = producto.cod_producto and traspaso_producto.cod_usuario = usuario.cod_usuario and cod_inventario_a = ?;";
		return $this->db->select($sql, $datos);
	}

	public function listaTransferenciaEspecificoDestino($datos){
		$sql = "SELECT cod_almacenamiento_a, cod_almacenamiento_de, producto.cod_producto, cod_item_producto, nombre_producto, imagen_producto, cantidad_producto, compra_unit_producto, precio_sugerido_venta, observacion_traspaso_producto, fecha_traspaso_producto, hora_traspaso_producto, CONCAT(nombre_usuario, ' ', appat_usuario, ' ', apmat_usuario) as 'personal' FROM traspaso_producto, producto, usuario WHERE traspaso_producto.cod_producto = producto.cod_producto and traspaso_producto.cod_usuario = usuario.cod_usuario and cod_almacenamiento_a = ? and traspaso_producto.cod_producto = ? and traspaso_producto.compra_unit_producto = ? and traspaso_producto.precio_sugerido_venta = ?;";
		return $this->db->select($sql, $datos);
	}
    
    public function agregarTransferencia($datos){
		$sql = "INSERT INTO traspaso_producto(cod_almacenamiento_de, cod_almacenamiento_a, cod_producto, cantidad_producto, compra_unit_producto, precio_sugerido_venta, observacion_traspaso_producto, fecha_traspaso_producto, hora_traspaso_producto, cod_usuario) VALUES(?,?,?,?,?,?,?,?,?,?);";
		return $this->db->insert($sql, $datos);
	}

	public function reporteListaTransferencia($datos){
		$sql = "SELECT producto.cod_producto, cod_item_producto, nombre_producto, imagen_producto, cantidad_producto, compra_unit_producto, precio_sugerido_venta, observacion_traspaso_producto, fecha_traspaso_producto, hora_traspaso_producto, CONCAT(nombre_usuario, ' ', appat_usuario, ' ', apmat_usuario) as 'personal', CONCAT(cod_almacenamiento_de) as 'nombre_origen', CONCAT(cod_almacenamiento_a) as 'nombre_destino', cod_almacenamiento_de, cod_almacenamiento_a FROM traspaso_producto, producto, usuario WHERE traspaso_producto.cod_producto = producto.cod_producto and traspaso_producto.cod_usuario = usuario.cod_usuario and MONTH(fecha_traspaso_producto) = ? and YEAR(fecha_traspaso_producto) = ?;";
		return $this->db->select($sql, $datos);
	}

	public function reporteListaTransferenciaDestino($datos){
		$sql = "SELECT producto.cod_producto, cod_item_producto, nombre_producto, imagen_producto, cantidad_producto, compra_unit_producto, precio_sugerido_venta, observacion_traspaso_producto, fecha_traspaso_producto, hora_traspaso_producto, CONCAT(nombre_usuario, ' ', appat_usuario, ' ', apmat_usuario) as 'personal', CONCAT(cod_almacenamiento_de) as 'nombre_origen', CONCAT(cod_almacenamiento_a) as 'nombre_destino', cod_almacenamiento_de, cod_almacenamiento_a FROM traspaso_producto, producto, usuario WHERE traspaso_producto.cod_producto = producto.cod_producto and traspaso_producto.cod_usuario = usuario.cod_usuario and cod_almacenamiento_a = ? and MONTH(fecha_traspaso_producto) = ? and YEAR(fecha_traspaso_producto) = ?;";
		return $this->db->select($sql, $datos);
	}

	public function reporteListaTransferenciaOrigen($datos){
		$sql = "SELECT producto.cod_producto, cod_item_producto, nombre_producto, imagen_producto, cantidad_producto, compra_unit_producto, precio_sugerido_venta, observacion_traspaso_producto, fecha_traspaso_producto, hora_traspaso_producto, CONCAT(nombre_usuario, ' ', appat_usuario, ' ', apmat_usuario) as 'personal', CONCAT(cod_almacenamiento_de) as 'nombre_origen', CONCAT(cod_almacenamiento_a) as 'nombre_destino', cod_almacenamiento_de, cod_almacenamiento_a FROM traspaso_producto, producto, usuario WHERE traspaso_producto.cod_producto = producto.cod_producto and traspaso_producto.cod_usuario = usuario.cod_usuario and cod_almacenamiento_de = ? and MONTH(fecha_traspaso_producto) = ? and YEAR(fecha_traspaso_producto) = ?;";
		return $this->db->select($sql, $datos);
	}

	public function reporteListaTransferenciaAmbos($datos){
		$sql = "SELECT producto.cod_producto, cod_item_producto, nombre_producto, imagen_producto, cantidad_producto, compra_unit_producto, precio_sugerido_venta, observacion_traspaso_producto, fecha_traspaso_producto, hora_traspaso_producto, CONCAT(nombre_usuario, ' ', appat_usuario, ' ', apmat_usuario) as 'personal', CONCAT(cod_almacenamiento_de) as 'nombre_origen', CONCAT(cod_almacenamiento_a) as 'nombre_destino', cod_almacenamiento_de, cod_almacenamiento_a FROM traspaso_producto, producto, usuario WHERE traspaso_producto.cod_producto = producto.cod_producto and traspaso_producto.cod_usuario = usuario.cod_usuario and cod_almacenamiento_de = ? and cod_almacenamiento_a = ? and MONTH(fecha_traspaso_producto) = ? and YEAR(fecha_traspaso_producto) = ?;";
		return $this->db->select($sql, $datos);
	}
}
?>