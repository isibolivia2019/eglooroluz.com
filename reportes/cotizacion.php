<?php
require_once("../public/fpdf/mc_table.php");
define('FPDF_FONTPATH', 'font/');
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

$nro = $_GET['nro'];

$nombreMes = "";
/*if($mes == 1){$nombreMes = "Enero";}
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
if($mes == 12){$nombreMes = "Diciembre";}*/

$datos = array($nro);
$modelo = modelo('Cotizacion');
$lista = $modelo->listaCotizacionNroOrden($datos);

$datos = array($lista[0]['cod_sucursal']);
$modelo = modelo('Sucursal');
$listaSucursal = $modelo->sucursalEspecifico($datos);

$pdf = new PDF_MC_Table('L','mm',array(279.4,215.9));
$pdf -> AddPage();

$pdf -> SetTextColor(0, 0, 0);
$pdf->SetFont('Arial', '', 12);

$border = array('');
$align = array('C');
$style = array('');
$pdf->SetWidths(array(80));

$pdf -> Cell(180, 10, "", 0, 0, 'C');
$empty = array($listaSucursal[0]['nombre_sucursal']);
$pdf->FancyRow($empty, $border, $align, $style);

$pdf -> Cell(180, 10, "", 0, 0, 'C');
$empty = array($listaSucursal[0]['direccion_sucursal']);
$pdf->FancyRow($empty, $border, $align, $style);

$pdf -> Cell(180, 10, "", 0, 0, 'C');
$empty = array($listaSucursal[0]['telefono']);
$pdf->FancyRow($empty, $border, $align, $style);

$pdf -> SetTextColor(33, 152, 158);
$pdf->SetWidths(array(60));
$style = array('B');
$pdf -> SetFont('Arial','B', 20);
$pdf -> Cell(100, 15, "", 0, 0, 'C');
$empty = array("EGLO");
$pdf->FancyRow($empty, $border, $align, $style);
$pdf->Ln(2);
$pdf -> Cell(100, 15, "", 0, 0, 'C');
$empty = array("COTIZACION");
$pdf->FancyRow($empty, $border, $align, $style);
$pdf->Ln(10);

$pdf -> SetDrawColor(33, 152, 158);
$pdf -> SetTextColor(0, 0, 0);

$pdf -> SetFont('Arial','B', 11);
$pdf->SetWidths(array(100, 145));
$pdf->SetAligns(array('L','C'));

$fec = date("d/m/Y", strtotime($lista[0]["fecha"]));
$fec = explode("/", $fec);
$nombreMes = "";
if($fec[1] == 1){$nombreMes = "Enero";}
if($fec[1] == 2){$nombreMes = "Febrero";}
if($fec[1] == 3){$nombreMes = "Marzo";}
if($fec[1] == 4){$nombreMes = "Abril";}
if($fec[1] == 5){$nombreMes = "Mayo";}
if($fec[1] == 6){$nombreMes = "Junio";}
if($fec[1] == 7){$nombreMes = "Julio";}
if($fec[1] == 8){$nombreMes = "Agosto";}
if($fec[1] == 9){$nombreMes = "Septiembre";}
if($fec[1] == 10){$nombreMes = "Octubre";}
if($fec[1] == 11){$nombreMes = "Novimebre";}
if($fec[1] == 12){$nombreMes = "Diciembre";}
$pdf->Row(array("FECHA :",  utf8_decode($fec[0]." de ".$nombreMes." de ".$fec[2] )));
$pdf->Row(array( utf8_decode("EMPRESA / INSTITUCIÓN :"), utf8_decode($lista[0]['empresa'])));
$pdf->Row(array( utf8_decode("ATENCIÓN :"),  utf8_decode($lista[0]['personal'])));
$pdf->Ln(10);

$pdf -> SetFont('Arial','B', 10);
$pdf->SetWidths(array(10,25,45,18,23,25,25,25,25,25));
$pdf->SetAligns(array('C','C','C','C','C','C','C','C','C','C'));
$pdf->Row(array('NRO', 'CODIGO', 'DETALLE', 'UNID.', 'CANTIDAD', 'PRECIO UNITARIO', 'TOTAL', 'DESCUENTO', 'PRECIO CON DESCUENTO', 'TOTAL CON DESCUENTO'));
$totalSinDescuento = 0;
$totalConDescuento = 0;

for($i=0;$i<sizeof($lista);$i++){
	$pdf -> SetFont('Arial','', 10);
	$totalSinDescuento = $totalSinDescuento + ($lista[$i]['sugerido'] * $lista[$i]['cant_producto']);
	$totalConDescuento = $totalConDescuento + round(($lista[$i]['total_unitario'] * $lista[$i]['cant_producto']),2);

	$pdf->Row(array(
		($i + 1),
		utf8_decode('#'.$lista[$i]['cod_item_producto']),
		utf8_decode($lista[$i]['nombre_producto']." ".$lista[$i]['descripcion_producto'].', color: '.$lista[$i]['color_producto']), 
		utf8_decode('PIEZA'), utf8_decode($lista[$i]['cant_producto']),
		utf8_decode('$us '.round($lista[$i]['sugerido'],2)),
		utf8_decode('$us '.round(($lista[$i]['sugerido'] * $lista[$i]['cant_producto']),2)),
		utf8_decode($lista[$i]['descuento_porcentaje_venta_producto']." %"),
		utf8_decode('$us '.round($lista[$i]['total_unitario'],2)),
		utf8_decode('$us '.round(($lista[$i]['total_unitario'] * $lista[$i]['cant_producto']),2))
	)); 
}
$pdf -> SetFont('Arial','', 11);
$border = array("","","", "", "", "", "1", "", "", "1");
$align = array('C','C','C','C','C','C','C','C','C','C');
$style = array("","","", "", "", "", "B", "", "", "B");
$pdf->SetWidths(array(10,25,45,18,23,25,25,25,25,25));
$empty = array("","","", "", "", "", '$us '.round($totalSinDescuento,2), "", "", '$us '.round($totalConDescuento,2));
$pdf->FancyRow($empty, $border, $align, $style);

$pdf -> SetFont('Arial','', 10);
$pdf -> Cell(260, 10, utf8_decode(''), 0, 1, 'L');
$pdf -> Cell(260, 10, utf8_decode('Esta cotización es válida por 10 días a partir de la fecha de emisión.'), 0, 1, 'L');

	
$pdf->Image("../public/imagenes/sistema/eglo.png", 10 ,10, 76 , 26,'PNG', 'http://www.eglooroluz.com');
$pdf -> Output();
?>