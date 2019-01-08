<?php
ini_set('display_errors', '1');
$action = '';

if (isset($_POST['action'])) {
    $action = $_POST['action'];
    switch ($action) {
        case 'autentificacionUsuario' :
            autentificacionUsuario();
            break;
        case 'listaUsuario' :
        listaUsuario();
            break;
    }
}

function modelo($modelo){
    require_once '../modelos/'.$modelo.'.php';
    return new $modelo();
}

function autentificacionUsuario(){
    $usuario = $_POST['usuario'];
    $pass = $_POST['pass'];
    $datos = array($usuario, $pass);
    $usuarioModelo = modelo('Usuario');
    $usuario = $usuarioModelo->autentificacionUsuario($datos);
    echo json_encode($usuario);
}

function listaUsuario(){
    $datos = array();
    $usuarioModelo = modelo('Usuario');
    $lista = $usuarioModelo->listaUsuario($datos);

    $data = array();
    $data = ['data' => $lista];
/*while( $row=mysqli_fetch_array($lista) ) {  // preparing an array
    $nestedData=array(); 
	$nestedData[] = $row["nombre_usuario"];
    $nestedData[] = $row["telefono_usuario"];
    $nestedData[] = $row["telefono_usuario"];
    /*$nestedData[] = '<td><center>
                     <a href="editar.php?id='.$row['id'].'"  data-toggle="tooltip" title="Editar datos" class="btn btn-sm btn-info"> <i class="menu-icon icon-pencil"></i> </a>
                     <a href="index.php?action=delete&id='.$row['id'].'"  data-toggle="tooltip" title="Eliminar" class="btn btn-sm btn-danger"> <i class="menu-icon icon-trash"></i> </a>
				     </center></td>';	
	
	$data[] = $nestedData;
    
}*/
/*for($i = 0 ; $i < sizeof($lista) ; $i++ ){
    $dato = array();
    $dato[] = $lista[$i]["nombre_usuario"];
    $dato[] = $lista[$i]["telefono_usuario"];
    $dato[] = $lista[$i]["telefono_usuario"];
    $data[] = $dato;
}*/
//$data[] = ["juan","12313","3232"];



    /*$json_data = array(
        "draw"            => intval( sizeof($lista) ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
		"recordsTotal"    => intval( sizeof($lista) ),  // total number of records
		"recordsFiltered" => intval( sizeof($lista) ), // total number of records after searching, if there is no searching then totalFiltered = totalData
        "data"            => $data   // total data array
    );*/
    echo json_encode($data);
}
?>