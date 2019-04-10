<?php
require_once 'Base.php';
class HuellaDactilar{
	private $db;
	public function __construct(){
		$this->db = new Base;
	}

	public function listaUsuarioHuellaDactilarEspecifico($datos){
		$sql = "SELECT * FROM huelladactilar WHERE cod_dedohuella = ? and cod_biometrico = ?";
		return $this->db->select($sql, $datos);
	}

	public function listaRegistroHorarioEspecifico($datos){
		$sql = "SELECT cod_reg_hr, fecha_reg_hr, entrada_horario_reg_hr, salida_horario_reg_hr, CONCAT(nombre_usuario, ' ', appat_usuario, ' ', apmat_usuario) as 'personal', observacion_entrada, observacion_salida, timediff(entrada_horario_reg_hr, salida_horario_reg_hr) as 'diferenciaHora' FROM registro_horario, usuario WHERE registro_horario.cod_usuario = usuario.cod_usuario and registro_horario.cod_usuario = ? and MONTH(fecha_reg_hr) = ? and YEAR(fecha_reg_hr) = ?;";
		return $this->db->select($sql, $datos);
	}

	public function listaRegistroHorario($datos){
		$sql = "SELECT cod_reg_hr, fecha_reg_hr, entrada_horario_reg_hr, salida_horario_reg_hr, CONCAT(nombre_usuario, ' ', appat_usuario, ' ', apmat_usuario) as 'personal', observacion_entrada, observacion_salida FROM registro_horario, usuario WHERE registro_horario.cod_usuario = usuario.cod_usuario and MONTH(fecha_reg_hr) = ? and YEAR(fecha_reg_hr) = ?;";
		return $this->db->select($sql, $datos);
	}

	public function ultimoRegistroHuella($datos){
		$sql = "SELECT * FROM registro_horario WHERE cod_usuario = ? ORDER BY cod_reg_hr desc LIMIT 1";
		return $this->db->select($sql, $datos);
	}
    
    public function inicioSoftware($datos){
		$sql = "INSERT INTO inicio_biometrico(fecha, hora, computadora) VALUES(?,?,?)";
		return $this->db->insert($sql, $datos);
	}

	public function finSoftware($datos){
		$sql = "INSERT INTO final_biometrico(fecha, hora, computadora) VALUES(?,?,?)";
		return $this->db->insert($sql, $datos);
	}

	public function registroEntrada($datos){
		$sql = "INSERT INTO registro_horario(cod_usuario, fecha_reg_hr, entrada_horario_reg_hr, conteo_horario_reg_hr, estado_actual_reg_hr, cadena) VALUES (?,?,?,?,?,?)";
		return $this->db->insert($sql, $datos);
	}

	public function registroSalida($datos){
		$sql = "INSERT INTO registro_horario(cod_usuario, fecha_reg_hr, salida_horario_reg_hr, conteo_horario_reg_hr, estado_actual_reg_hr, cadena) VALUES (?,?,?,?,?,?)";
		return $this->db->insert($sql, $datos);
	}

	public function actualizaRegistroSalida($datos){
		$sql = "UPDATE registro_horario SET salida_horario_reg_hr = ?, estado_actual_reg_hr = ? WHERE cod_reg_hr = ?";
		return $this->db->update($sql, $datos);
	}

	public function agregarObservacionEntrada($datos){
		$sql = "UPDATE registro_horario SET observacion_entrada = ? WHERE cod_reg_hr = ?";
		return $this->db->update($sql, $datos);
	}

	public function agregarObservacionSalida($datos){
		$sql = "UPDATE registro_horario SET observacion_salida = ? WHERE cod_reg_hr = ?";
		return $this->db->update($sql, $datos);
	}
}
?>