<?php
require_once 'Base.php';
class Categoria{
	private $db;
	public function __construct(){
		$this->db = new Base;
	}

	public function asignarUsuarioSueldo($datos){
		$sql = "INSERT INTO categoria_producto(cod_categoria, cod_producto) VALUES(?,?);";
		return $this->db->insert($sql, $datos);
	}

	public function verificarProductoCategoria($datos){
		$sql = "SELECT * FROM categoria_producto WHERE cod_categoria = ? and cod_producto = ?";
		return $this->db->select($sql, $datos);
	}

	public function agregarCategoria($datos){
		$sql = "INSERT INTO categoria(nombre_categoria, descripcion_categoria, imagen_categoria) VALUES(?,?,?);";
		return $this->db->insert($sql, $datos);
	}

	public function eliminarCategoriaProducto($datos){
		$sql = "DELETE FROM categoria_producto WHERE cod_categoria = ?";
		return $this->db->update($sql, $datos);
	}

	public function eliminarCategoria($datos){
		$sql = "DELETE FROM categoria WHERE cod_categoria = ?";
		return $this->db->update($sql, $datos);
	}

	public function actualizarCategoria($datos){
		$sql = "UPDATE categoria SET nombre_categoria = ?, descripcion_categoria = ?WHERE cod_categoria = ? ";
		return $this->db->update($sql, $datos);
	}

	public function actualizarImagenCategoria($datos){
		$sql = "UPDATE categoria SET imagen_categoria = ? WHERE cod_categoria = ? ";
		return $this->db->update($sql, $datos);
	}

	public function categoriaEspecifico($datos){
		$sql = "SELECT * FROM categoria WHERE cod_categoria = ?";
		return $this->db->select($sql, $datos);
	}
    
  public function listaCategorias($datos){
		$sql = "SELECT * FROM categoria";
		return $this->db->select($sql, $datos);
	}

	public function listaCategoriaProductos($datos){
		$sql = "SELECT cod_item_producto, nombre_producto, imagen_producto, producto.cod_producto, categoria.cod_categoria, nombre_categoria, descripcion_categoria FROM categoria_producto, categoria, producto WHERE categoria_producto.cod_producto = producto.cod_producto and categoria_producto.cod_categoria = categoria.cod_categoria and categoria_producto.cod_categoria = ?";
		return $this->db->select($sql, $datos);
	}

	public function eliminarProductoCategoria($datos){
		$sql = "DELETE FROM categoria_producto WHERE cod_categoria = ? and cod_producto = ?;";
		return $this->db->update($sql, $datos);
	}

	public function listaCategoriaProductosPagina($datos){
		$sql = "SELECT cod_item_producto, nombre_producto, descripcion_producto, imagen_producto, producto.cod_producto, categoria.cod_categoria, nombre_categoria, descripcion_categoria FROM categoria_producto, categoria, producto WHERE categoria_producto.cod_producto = producto.cod_producto and categoria_producto.cod_categoria = categoria.cod_categoria and categoria_producto.cod_categoria = ?";
		return $this->db->select($sql, $datos);
	}
}
?>