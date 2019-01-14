<?php
require_once 'Base.php';
class Usuario{
	private $db;
	public function __construct(){
		$this->db = new Base;
	}
	
  	public function autentificacionUsuario($datos){
		$sql = "SELECT cod_usuario, nombre_usuario, appat_usuario, apmat_usuario, ci_usuario, ci_exp_usuario, genero_usuario, fec_nac_usuario,direccion_usuario, telefono_usuario, nombre_ref_usuario, telefono_ref_usuario, tipo_ref_usuario, email_usuario, pass_usuario, imagen_usuario, nombre_cargo, estado_usuario FROM usuario, cargo WHERE usuario.cod_cargo = cargo.cod_cargo and ci_usuario = ? and pass_usuario = ?;";
		return $this->db->select($sql, $datos);
	}

	public function listaUsuarioEstado($datos){
		$sql = "SELECT cod_usuario, nombre_usuario, appat_usuario, apmat_usuario, ci_usuario, ci_exp_usuario, genero_usuario, fec_nac_usuario,direccion_usuario, telefono_usuario, nombre_ref_usuario, telefono_ref_usuario, tipo_ref_usuario, email_usuario, pass_usuario, imagen_usuario, nombre_cargo, estado_usuario FROM usuario, cargo WHERE usuario.cod_cargo = cargo.cod_cargo and estado_usuario = ?;";
		return $this->db->select($sql, $datos);
	}

	public function listaUsuarioSinCargo($datos){
		$sql = "SELECT * FROM usuario";
		return $this->db->select($sql, $datos);
	}

	public function listaUsuarios($datos){
		$sql = "SELECT cod_usuario, nombre_usuario, appat_usuario, apmat_usuario, ci_usuario, ci_exp_usuario, genero_usuario, fec_nac_usuario,direccion_usuario, telefono_usuario, nombre_ref_usuario, telefono_ref_usuario, tipo_ref_usuario, email_usuario, pass_usuario, imagen_usuario, nombre_cargo, estado_usuario FROM usuario, cargo WHERE usuario.cod_cargo = cargo.cod_cargo;";
		return $this->db->select($sql, $datos);
	}

	public function listaPrivilegiosUsuarios($datos){
		$sql = "SELECT * FROM usuario_privilegios WHERE cod_usuario = ?";
		return $this->db->select($sql, $datos);
	}

	public function usuarioEspecifico($datos){
		$sql = "SELECT cod_usuario, nombre_usuario, appat_usuario, apmat_usuario, ci_usuario, ci_exp_usuario, genero_usuario, fec_nac_usuario, direccion_usuario, telefono_usuario, nombre_ref_usuario, telefono_ref_usuario, tipo_ref_usuario, email_usuario, pass_usuario, imagen_usuario, nombre_cargo, estado_usuario FROM usuario, cargo WHERE usuario.cod_cargo = cargo.cod_cargo and cod_usuario = ?";
		return $this->db->select($sql, $datos);
	}

	public function agregarUsuario($datos){
		$sql = "INSERT INTO usuario(nombre_usuario, appat_usuario, apmat_usuario, ci_usuario, ci_exp_usuario, genero_usuario, fec_nac_usuario, direccion_usuario, telefono_usuario, nombre_ref_usuario, telefono_ref_usuario, tipo_ref_usuario, email_usuario, pass_usuario, cod_cargo, estado_usuario) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
		return $this->db->insert($sql, $datos);
	}

	public function actualizarUsuario($datos){
		$sql = "UPDATE usuario SET nombre_usuario = ?, appat_usuario = ?, apmat_usuario = ?, ci_usuario = ?, ci_exp_usuario = ?, genero_usuario = ?, fec_nac_usuario = ?, direccion_usuario = ?, telefono_usuario = ?, nombre_ref_usuario = ?, telefono_ref_usuario = ?, tipo_ref_usuario = ?, email_usuario = ?, pass_usuario = ? WHERE cod_usuario = ?";
		return $this->db->update($sql, $datos);
	}

	public function cambiarEstado($datos){
		$sql = "UPDATE usuario SET estado_usuario = ? WHERE cod_usuario = ?";
		return $this->db->update($sql, $datos);
	}

	public function agregarPrivilegio($datos){
		$sql = "INSERT INTO usuario_privilegios(cod_usuario, itemUsuario, itemCargo, itemHorario, itemSueldo, itemProducto, itemCategoria, itemSucursal, itemAlmacen, itemReportes, itemDescuentoProductos, itemTraspasoProductos, itemProductosPerdidos, itemVentas, itemBiometrico, itemAccesos, itemCajaChica, itemCliente, itemConfiguracion) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";
		return $this->db->insert($sql, $datos);
	}
}
?>