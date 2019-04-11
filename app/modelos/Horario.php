<?php
require_once 'Base.php';
class Horario{
	private $db;
	public function __construct(){
		$this->db = new Base;
	}

	public function horarioEspecificoUsuario($datos){
		$sql = "select entrada_horario, salida_horario, tiempo_espera, dia_lunes, dia_martes, dia_miercoles, dia_jueves, dia_viernes, dia_sabado, dia_domingo from horario_usuario, horario WHERE horario.cod_horario = horario_usuario.cod_horario and cod_usuario = ?;";
		return $this->db->select($sql, $datos);
	}
    
  public function listaHorarios($datos){
		$sql = "SELECT * FROM horario";
		return $this->db->select($sql, $datos);
	}

	public function agregarHorario($datos){
		$sql = "INSERT INTO horario(entrada_horario, salida_horario, tiempo_espera, dia_lunes, dia_martes, dia_miercoles, dia_jueves, dia_viernes, dia_sabado, dia_domingo) VALUES(?,?,?,?,?,?,?,?,?,?);";
		return $this->db->insert($sql, $datos);
	}

	public function actualizarHorario($datos){
		$sql = "UPDATE horario SET entrada_horario = ?, salida_horario = ?, tiempo_espera = ?, dia_lunes = ?, dia_martes = ?, dia_miercoles = ?, dia_jueves = ?, dia_viernes = ?, dia_sabado = ?, dia_domingo = ? WHERE cod_horario = ? ";
		return $this->db->update($sql, $datos);
	}

	public function horarioEspecifico($datos){
		$sql = "SELECT * FROM horario WHERE cod_horario = ?";
		return $this->db->select($sql, $datos);
	}

	public function eliminarHorario($datos){
		$sql = "DELETE FROM horario WHERE cod_horario = ?";
		return $this->db->update($sql, $datos);
	}

	public function agregarHorarioUsuario($datos){
		$sql = "INSERT INTO horario_usuario(cod_horario, cod_usuario) VALUES(?,?);";
		return $this->db->insert($sql, $datos);
	}

	public function verificarHorarioUsuario($datos){
		$sql = "SELECT * FROM horario_usuario WHERE cod_horario = ? and cod_usuario = ?";
		return $this->db->select($sql, $datos);
	}

	public function listaHorarioUsuarios($datos){
		$sql = "SELECT entrada_horario, salida_horario, tiempo_espera, dia_lunes, dia_martes, dia_miercoles, dia_jueves, dia_viernes, dia_sabado, dia_domingo, nombre_usuario, appat_usuario, apmat_usuario, horario_usuario.cod_horario, horario_usuario.cod_usuario FROM horario_usuario, horario, usuario WHERE horario_usuario.cod_horario = horario.cod_horario and horario_usuario.cod_usuario = usuario.cod_usuario and horario_usuario.cod_horario = ?";
		return $this->db->select($sql, $datos);
	}

	public function eliminarUsuarioHorario($datos){
		$sql = "DELETE FROM horario_usuario WHERE cod_horario = ? and cod_usuario = ?";
		return $this->db->update($sql, $datos);
	}
	
	public function eliminarHorarioUsuario($datos){
		$sql = "DELETE FROM horario_usuario WHERE cod_horario = ?";
		return $this->db->update($sql, $datos);
	}
}
?>