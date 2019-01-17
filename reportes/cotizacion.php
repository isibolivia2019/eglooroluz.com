<?php
require_once("fpdf/mc_table.php");
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

require_once("/home/eglooroluz/app/controladores/Cotizaciones.php");
require_once("/home/eglooroluz/app/controladores/Empresas.php");
$orden = $dato['orden'];
/*$mes = $dato['mes'];
$codSucursal = $dato['codSucursal'];
$nombreSucursal = $dato['nombreSucursal'];
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
if($mes == 12){$nombreMes = "Diciembre";}*/
$cotizacion = new Cotizaciones();
$datos = $cotizacion->cotizacionActual($orden);
$sucursal = $cotizacion->datosSucursales($datos[0]['cod_sucursal']);
$pdf = new PDF_MC_Table('L','mm',array(279.4,215.9));
$pdf -> AddPage();

$pdf -> SetTextColor(0, 0, 0);
$pdf->SetFont('Arial', '', 12);

$border = array('');
$align = array('C');
$style = array('');
$pdf->SetWidths(array(80));

$pdf -> Cell(180, 10, "", 0, 0, 'C');
$empty = array($sucursal[0]['nombre_sucursal']);
$pdf->FancyRow($empty, $border, $align, $style);

$pdf -> Cell(180, 10, "", 0, 0, 'C');
$empty = array($sucursal[0]['direccion_sucursal']);
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
$pdf->Row(array("FECHA :",  utf8_decode($datos[0]['fecha'])));
$pdf->Row(array( utf8_decode("EMPRESA / INSTITUCIÓN :"),  utf8_decode($datos[0]['empresa'])));
$pdf->Row(array( utf8_decode("ATENCIÓN :"),  utf8_decode($datos[0]['personal'])));
$pdf->Ln(10);

	$pdf -> SetFont('Arial','B', 10);
	$pdf->SetWidths(array(10,25,50,15,20,25,25,25,25,25));
	$pdf->SetAligns(array('C','C','C','C','C','C','C','C','C','C'));
	$pdf->Row(array('NRO', 'CODIGO', 'DETALLE', 'UNID.', 'CANTIDAD', 'PRECIO UNITARIO', 'TOTAL', 'DESCUENTO', 'PRECIO CON DESCUENTO', 'TOTAL CON DESCUENTO'));

	$totalSinDescuento = 0;
	$totalConDescuento = 0;

for($i=0;$i<sizeof($datos);$i++){
	$pdf -> SetFont('Arial','', 9);
	$totalSinDescuento = $totalSinDescuento + ($datos[$i]['precio_sugerido_venta'] * $datos[$i]['cant_producto']);
	$totalConDescuento = $totalConDescuento + $datos[$i]['total_unitario'];

	$pdf->Row(array(($i + 1), utf8_decode($datos[$i]['cod_item_producto']), utf8_decode($datos[$i]['nombre_producto']." ".$datos[$i]['descripcion_producto'].', color: '.$datos[$i]['color_producto']), utf8_decode('PIEZA'), utf8_decode($datos[$i]['cant_producto']), utf8_decode($datos[$i]['precio_sugerido_venta']), utf8_decode($datos[$i]['precio_sugerido_venta'] * $datos[$i]['cant_producto']), utf8_decode($datos[$i]['descuento_porcentaje_venta_producto']), utf8_decode($datos[$i]['total_unitario'] / $datos[$i]['cant_producto']), utf8_decode($datos[$i]['total_unitario']))); 
}
$border = array("","","", "", "", "", "1", "", "", "1");
$align = array('C','C','C','C','C','C','C','C','C','C');
$style = array("","","", "", "", "", "B", "", "", "B");
$pdf->SetWidths(array(10,25,50,15,20,25,25,25,25,25));
$empty = array("","","", "", "", "", $totalSinDescuento, "", "", $totalConDescuento);
$pdf->FancyRow($empty, $border, $align, $style);
	
	$pdf->Image("http://www.eglooroluz.com/public/imagenes/eglo.png", 10 ,10, 76 , 26,'PNG', 'http://www.eglooroluz.com');
$pdf -> Output();
?>