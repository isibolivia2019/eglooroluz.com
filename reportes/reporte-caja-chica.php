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
echo "fecha:".$fecha.":=";
echo "usuario:".$_SESSION['personal'].":=";
$datos = array($sucursal, $mes, $año);
$modelo = modelo('CajaChica');
$lista = $modelo->reporteListaCajaChica($datos);
for($i = 0 ; $i < sizeof($lista) ; $i++){
    $lista[$i]["fecha"] = date("d/m/Y", strtotime($lista[$i]["fecha"])).' '.$lista[$i]["hora"];
    //$lista[$i]["monto_gasto"] = 'Bs. '.$lista[$i]["monto_gasto"];
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
$empty = array(utf8_decode('usuario'));
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
$empty = array("REPORTE DE CAJA CHICA");
$pdf->FancyRow($empty, $border, $align, $style);
$pdf->Ln(5);

$pdf -> SetDrawColor(33, 152, 158);
$pdf -> SetTextColor(0, 0, 0);

$pdf -> SetFont('Arial','B', 11);
$pdf -> Cell(260, 10, utf8_decode('CAJA CHICA DEL MES DE '.strtoupper ($nombreMes)." DEL AÑO ".$año), 0, 1, 'C');
$pdf -> SetFont('Arial','B', 11);
$pdf->SetWidths(array(15,40,40,55,55,55));
$pdf->SetAligns(array('C','C','C','C','C','C'));
$pdf->Row(array('NRO.', 'FECHA / HORA', 'MONTO GASTO', 'DETALLE', 'COMPROBANTE', 'PERSONAL'));

$totalMonto = 0;
for($i=0;$i<sizeof($lista);$i++){
	$pdf -> SetFont('Arial','', 11);
	$totalMonto = $totalMonto + $lista[$i]['monto_gasto'];

	$pdf->Row(array(($i + 1),
		utf8_decode($lista[$i]['fecha']),
		utf8_decode('Bs. '.$lista[$i]['monto_gasto']),
		utf8_decode($lista[$i]['detalle']),
		utf8_decode($lista[$i]['comprobante']),
		utf8_decode($lista[$i]['personal'])
	)); 
}
$pdf -> SetFont('Arial','B', 13);
$border = array("","","1", "", "", "");
$align = array('C','C','C','C','C','C');
$style = array("","","B", "", "", "");
$pdf->SetWidths(array(15,40,40,45,45,45));
$empty = array("","","Bs. ".$totalMonto, "", "", "");
$pdf->FancyRow($empty, $border, $align, $style);

$pdf -> Output();
?>