<?php
ini_set('display_errors', '1');
require_once("../public/fpdf/mc_table.php");
define('FPDF_FONTPATH', 'font/');
session_start();
class PDF extends FPDF {
	
   	/*function Header() {
      $this->Image('images/logooroluz.png',10,8,33);
      $this->Cell(100,10,'',0,1,'C');
   	}

	function Footer(){
		$this->SetY(-10);
		$this->SetFont('Arial','I',8);
		$this->Cell(0,10,'Pagina '.$this->PageNo(),0,0,'C');
	}*/
}
function modelo($modelo){
    require_once '../app/modelos/'.$modelo.'.php';
    return new $modelo();
}

$sucDe = $_GET['sucde'];
$sucA = $_GET['suca'];
$año = $_GET['a'];
$mes = $_GET['m'];

date_default_timezone_set('America/La_Paz');
$hora = date("H:i:s");
$fecha = date("Y-m-d");

$datos = array();
$modelo = modelo('Sucursal');
$listaSucursales = $modelo->listaSucursales($datos);
$modelo = modelo('Almacen');
$listaAlmacenes = $modelo->listaAlmacenes($datos);

$lista = "";
if($sucDe == "todos"){
	if($sucA == "todos"){
		$datos = array($mes, $año);
    	$modelo = modelo('Transferencia');
    	$lista = $modelo->reporteListaTransferencia($datos);
	}else{
		$datos = array($sucA, $mes, $año);
    	$modelo = modelo('Transferencia');
    	$lista = $modelo->reporteListaTransferenciaDestino($datos);
	}
}else{
	if($sucA == "todos"){
		$datos = array($sucDe, $mes, $año);
    	$modelo = modelo('Transferencia');
    	$lista = $modelo->reporteListaTransferenciaOrigen($datos);
	}else{
		$datos = array($sucDe, $sucA, $mes, $año);
    	$modelo = modelo('Transferencia');
    	$lista = $modelo->reporteListaTransferenciaAmbos($datos);
	}
}


for($i = 0 ; $i < sizeof($lista) ; $i++){
	$lista[$i]["fecha_traspaso_producto"] = date("d/m/Y", strtotime($lista[$i]["fecha_traspaso_producto"])).' '.$lista[$i]["hora_traspaso_producto"];

	for($j = 0 ; $j < sizeof($listaSucursales) ; $j++){
		if($listaSucursales[$j]["cod_sucursal"] == $lista[$i]["cod_almacenamiento_de"]){
			$lista[$i]["nombre_origen"] = $listaSucursales[$j]["nombre_sucursal"];
		}
		if($listaSucursales[$j]["cod_sucursal"] == $lista[$i]["cod_almacenamiento_a"]){
			$lista[$i]["nombre_destino"] = $listaSucursales[$j]["nombre_sucursal"];
		}
	}
	for($k = 0 ; $k < sizeof($listaAlmacenes) ; $k++){
		if($listaAlmacenes[$k]["cod_almacen"] == $lista[$i]["cod_almacenamiento_de"]){
			$lista[$i]["nombre_origen"] = $listaAlmacenes[$k]["nombre_almacen"];
		}
		if($listaAlmacenes[$k]["cod_almacen"] == $lista[$i]["cod_almacenamiento_a"]){
			$lista[$i]["nombre_destino"] = $listaAlmacenes[$k]["nombre_almacen"];
		}
	}
}

$nombreMes = "";
if($mes == 1){$nombreMes = "Enero";}
if($mes == 2){$nombreMes = "Febrero";}
if($mes == 3){$nombreMes = "Marzo";}
if($mes == 4){$nombreMes = "Abril";}
if($mes == 5){$nombreMes = "Mayo";}
if($mes == 6){$nombreMes = "Junio";}
if($mes == 7){$nombreMes = "Julio";}
if($mes == 8){$nombreMes = "Agosto";}
if($mes == 9){$nombreMes = "Septiembre";}
if($mes == 10){$nombreMes = "Octubre";}
if($mes == 11){$nombreMes = "Novimebre";}
if($mes == 12){$nombreMes = "Diciembre";}

$pdf = new PDF_MC_Table('L','mm',array(279.4,215.9));
$pdf -> AddPage();

$pdf -> SetTextColor(0, 0, 0);
$pdf->SetFont('Arial', '', 12);

$border = array('');
$align = array('C');
$style = array('B');
$pdf->SetWidths(array(80));

$pdf -> Cell(180, 10, "", 0, 0, 'C');
$empty = array("Reporte impreso por :");
$pdf->FancyRow($empty, $border, $align, $style);

$pdf -> Cell(180, 10, "", 0, 0, 'C');
$empty = array(utf8_decode($_SESSION['personal']));
$pdf->FancyRow($empty, $border, $align, $style);

$pdf -> Cell(180, 10, "", 0, 0, 'C');
$empty = array(utf8_decode("Fecha: ".date("d/m/Y", strtotime($fecha))." - Hora: ".$hora));
$pdf->FancyRow($empty, $border, $align, $style);

$pdf -> SetTextColor(33, 152, 158);
$pdf->SetWidths(array(180));
$style = array('B');
$pdf -> SetFont('Arial','B', 20);
$pdf -> Cell(40, 15, "", 0, 0, 'C');
$empty = array(utf8_decode("REPORTE DE TRANSFERENCIAS"));
$pdf->FancyRow($empty, $border, $align, $style);
$pdf->Ln(5);

$pdf -> SetDrawColor(33, 152, 158);
$pdf -> SetTextColor(0, 0, 0);

$pdf -> SetFont('Arial','B', 11);
$pdf -> Cell(260, 10, utf8_decode('TRANSFERENCIAS DEL MES DE '.strtoupper ($nombreMes)." DEL AÑO ".$año), 0, 1, 'C');

if($sucDe == "todos"){
	if($sucA == "todos"){
		$pdf -> Cell(260, 10, utf8_decode(strtoupper('TODOS LOS TRASPASOS')), 0, 1, 'C');
	}else{
		$pdf -> Cell(260, 10, utf8_decode(strtoupper('ORIGEN: TODOS --> DESTINO: '.$lista[0]["nombre_destino"])), 0, 1, 'C');
	}
}else{
	if($sucA == "todos"){
		$pdf -> Cell(260, 10, utf8_decode(strtoupper('ORIGEN: '.$lista[0]["nombre_origen"].' --> DESTINO: TODOS')), 0, 1, 'C');
	}else{
		$pdf -> Cell(260, 10, utf8_decode(strtoupper('ORIGEN: '.$lista[0]["nombre_origen"].' --> DESTINO: '.$lista[0]["nombre_destino"])), 0, 1, 'C');
	}
}

$pdf -> SetFont('Arial','B', 11);
$pdf->SetWidths(array(10,25,30,30,30,17,25,25,40,30));
$pdf->SetAligns(array('C','C','C','C','C','C','C','C','C','C'));
$pdf->Row(array(utf8_decode('N°'), 'FECHA HORA', 'ORIGEN', 'DESTINO', 'PRODUCTO', 'CANT.', 'COSTO DE ADQ.', 'PRECIO DE VENTA', 'OBSERVACION', 'PERSONAL'));

$cant = 0;
$total = 0;
for($i=0;$i<sizeof($lista);$i++){
	$pdf -> SetFont('Arial','', 11);
	$cant = $cant + $lista[$i]['cantidad_producto'];
	$pdf->Row(array(($i + 1),
		utf8_decode($lista[$i]['fecha_traspaso_producto']),
		utf8_decode($lista[$i]['nombre_origen']),
		utf8_decode($lista[$i]['nombre_destino']),
		utf8_decode("#".$lista[$i]['cod_item_producto']." ".$lista[$i]['nombre_producto']),
		utf8_decode($lista[$i]['cantidad_producto']." Uds."),
		utf8_decode('$us '.$lista[$i]["compra_unit_producto"]),
		utf8_decode('$us '.$lista[$i]['precio_sugerido_venta']),
		utf8_decode($lista[$i]['observacion_traspaso_producto']),
		utf8_decode($lista[$i]['personal'])
	)); 
}
$pdf -> SetFont('Arial','B', 13);
$border = array("","","", "", "", "1","", "", "", "");
$align = array('C','C','C','C','C','C','C','C','C','C');
$style = array("","","", "", "","B", "", "", "");
$pdf->SetWidths(array(10,25,30,30,30,17,25,25,40,30));
$empty = array("","", "", "", "", $cant." Uds.", "", "", "", "");
$pdf->FancyRow($empty, $border, $align, $style);

$pdf -> Output();
?>