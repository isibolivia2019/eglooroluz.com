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

$per = $_GET['per'];
$año = $_GET['a'];
$mes = $_GET['m'];

date_default_timezone_set('America/La_Paz');
$hora = date("H:i:s");
$fecha = date("Y-m-d");

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

$datos = array($mes, $año, $per);
$modelo = modelo('HuellaDactilar');
$lista = $modelo->listaRegistroHorarioPersonal($datos);
for($i = 0 ; $i < sizeof($lista) ; $i++){
	$lista[$i]["fecha_reg_hr"] = date("d/m/Y", strtotime($lista[$i]["fecha_reg_hr"]));
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
if(sizeof($lista) > 0){
	$empty = array(utf8_decode(strtoupper($lista[0]['nombre_sucursal'])));
}else{
	$empty = array("SIN RESULTADOS");
}

$pdf->FancyRow($empty, $border, $align, $style);

$pdf -> SetTextColor(33, 152, 158);
$pdf->SetWidths(array(100));
$style = array('B');
$pdf -> SetFont('Arial','B', 20);
$pdf -> Cell(80, 15, "", 0, 0, 'C');
$empty = array(utf8_decode("REGISTRO DE HORARIO"));
$pdf->FancyRow($empty, $border, $align, $style);
$pdf->Ln(5);

$pdf -> SetDrawColor(33, 152, 158);
$pdf -> SetTextColor(0, 0, 0);

$pdf -> SetFont('Arial','B', 11);
$pdf -> Cell(260, 10, utf8_decode('MES DE '.strtoupper ($nombreMes)." DEL AÑO ".$año), 0, 1, 'C');
$pdf -> SetFont('Arial','B', 11);
$pdf->SetWidths(array(15,40,40,55,55,55));
$pdf->SetAligns(array('C','C','C','C','C','C'));
$pdf->Row(array('NRO.', 'FECHA', 'ENTRADA', 'SALIDA', 'PERSONAL', ''));

$totalMonto = 0;
for($i=0;$i<sizeof($lista);$i++){
	$pdf -> SetFont('Arial','', 11);
	$totalMonto = $totalMonto + $lista[$i]['monto_gasto'];

	$pdf->Row(array(($i + 1),
		utf8_decode($lista[$i]['fecha_reg_hr']),
		utf8_decode($lista[$i]['entrada_horario_reg_hr']),
		utf8_decode($lista[$i]['salida_horario_reg_hr']),
		utf8_decode($lista[$i]['personal']),
		utf8_decode("")
	)); 
}

$pdf -> Output();
?>