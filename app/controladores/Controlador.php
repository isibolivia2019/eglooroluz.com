<?php
class Controlador{
	public function modelo($modelo){
		require_once 'app/modelos/'.$modelo.'.php';
		return new $modelo();
	}

	/*public function vista($vista, $dato = []){
		if(file_exists('../app/vistas/'.$vista.'.php')){
			require_once '../app/vistas/'.$vista.'.php';
		}else{
			die('La Vista no Existe');
		}
	}*/
}
?>