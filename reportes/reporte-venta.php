<?php
require_once("../public/fpdf/mc_table.php");
define('FPDF_FONTPATH', 'font/');
ini_set('display_errors', '1');
session_start();
class PDF extends FPDF {
	
   	function Header() {
      $this->Image('images/logooroluz.png',10,8,33);
      $this->Cell(100,10,'',0,1,'C');
   	}

	function Footer(){
		$this->SetY(-10);
		$this->SetFont('Arial','I',8);
		$this->Cell(0,10,'Pagina '.$this->PageNo(),0,0,'C');
   	}
}
function modelo($modelo){
    require_once '../app/modelos/'.$modelo.'.php';
    return new $modelo();
}

$sucursal = $_GET['suc'];
$año = $_GET['a'];
$mes = $_GET['m'];

date_default_timezone_set('America/La_Paz');
$hora = date("H:i:s");
$fecha = date("Y-m-d");

$datos = array($sucursal, $mes, $año);
    $modelo = modelo('Venta');
    $lista = $modelo->reporteListaVentas($datos);
    for($i = 0 ; $i < sizeof($lista) ; $i++){
        $lista[$i]["fecha_venta_producto"] = date("d/m/Y", strtotime($lista[$i]["fecha_venta_producto"])).' '.$lista[$i]["hora_venta_producto"];
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
$pdf -> Cell(180, 10, "", 0, 0, 'C');
$empty = array(utf8_decode(strtoupper($lista[0]['nombre_sucursal'])));
$pdf->FancyRow($empty, $border, $align, $style);

$pdf -> SetTextColor(33, 152, 158);
$pdf->SetWidths(array(100));
$style = array('B');
$pdf -> SetFont('Arial','B', 20);
$pdf -> Cell(80, 15, "", 0, 0, 'C');
$empty = array("REPORTE DE VENTAS");
$pdf->FancyRow($empty, $border, $align, $style);
$pdf->Ln(5);

$pdf -> SetDrawColor(33, 152, 158);
$pdf -> SetTextColor(0, 0, 0);

$pdf -> SetFont('Arial','B', 11);
$pdf -> Cell(260, 10, utf8_decode('VENTAS DEL MES DE '.strtoupper ($nombreMes)." DEL AÑO ".$año), 0, 1, 'C');
$pdf -> SetFont('Arial','B', 10);
$pdf->SetWidths(array(10,20,25,17,20,25,25,25,25,25,23,22));
$pdf->SetAligns(array('C','C','C','C','C','C','C','C','C','C','C','C'));
$pdf->Row(array(utf8_decode('N°'),'FECHA HORA','PRODUCTO','CANT.', 'DESC.','COSTO UNIT. DE ADQUISION','PRECIO UNIT. DE VENTA','GANANCIA UNIT.','COSTO TOTAL DE ADQ.','COSTO TOTAL DE VENTA.','GANANCIA TOTAL.','PERSONAL'));

$totalCosto = 0;
$totalPrecio = 0;
$totalGanancia = 0;
$totalCant = 0;
for($i=0;$i<sizeof($lista);$i++){
	$pdf -> SetFont('Arial','', 10);
	$res = $lista[$i]['total_venta_producto'] / $lista[$i]['cant_venta_producto'];
	$totalCant = $totalCant + $lista[$i]['cant_venta_producto'];
	$totalCosto = $totalCosto + ($lista[$i]['compra_unit_producto'] * $lista[$i]['cant_venta_producto']);
	$totalPrecio = $totalPrecio + $lista[$i]['total_venta_producto'];
	$totalGanancia = $totalGanancia + (($res - $lista[$i]['compra_unit_producto']) * $lista[$i]['cant_venta_producto']);
	
	$pdf->Row(array(($i + 1),
		utf8_decode($lista[$i]['fecha_venta_producto']),
		utf8_decode('#'.$lista[$i]['cod_item_producto'].' '.$lista[$i]['nombre_producto']),
		utf8_decode($lista[$i]['cant_venta_producto'].' Uds.'),
		utf8_decode($lista[$i]['descuento_porcentaje_venta_producto'].' %'),
		utf8_decode('$us '.$lista[$i]['compra_unit_producto']),
		utf8_decode('$us '.$res),
		utf8_decode('$us '.($res - $lista[$i]['compra_unit_producto'])),
		utf8_decode('$us '.($lista[$i]['compra_unit_producto'] * $lista[$i]['cant_venta_producto'])),
		utf8_decode('$us '.$lista[$i]['total_venta_producto']),
		utf8_decode('$us '.(($res - $lista[$i]['compra_unit_producto']) * $lista[$i]['cant_venta_producto'])),
		utf8_decode($lista[$i]['personal'])
	)); 
}
$pdf -> SetFont('Arial','B', 12);
$border = array("","","", "1", "", "","","","1","1","1","",);
$align = array('C','C','C','C','C','C','C','C','C','C','C','C');
$style = array("","","", "B", "", "","","","B", "B", "B", "");
$pdf->SetWidths(array(10,20,25,17,20,25,25,25,25,25,23,22));
$empty = array("","","", $totalCant." Uds.", "", "","","", '$us. '.$totalCosto, '$us. '.$totalPrecio, '$us. '.$totalGanancia, "");
$pdf->FancyRow($empty, $border, $align, $style);

$pdf -> Output();
?>