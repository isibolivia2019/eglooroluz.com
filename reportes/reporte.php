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

$pdf = new PDF_MC_Table('L','mm',array(279.4,215.9));
$pdf -> AddPage();

$pdf -> SetTextColor(0, 0, 0);
$pdf->SetFont('Arial', '', 12);

$border = array('');
$align = array('C');
$style = array('');
$pdf->SetWidths(array(80));

$pdf -> Cell(180, 10, "", 0, 0, 'C');
$empty = array("prueba");
$pdf->FancyRow($empty, $border, $align, $style);


$border = array("","","", "", "", "", "1", "", "", "1");
$align = array('C','C','C','C','C','C','C','C','C','C');
$style = array("","","", "", "", "", "B", "", "", "B");
$pdf->SetWidths(array(10,25,50,15,20,25,25,25,25,25));
$empty = array("","","", "", "", "", "", "", "", "");
$pdf->FancyRow($empty, $border, $align, $style);
	
$pdf -> Output();
?>