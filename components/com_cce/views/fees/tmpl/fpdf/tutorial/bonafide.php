<?php
require('../fpdf.php');

$ano=$_REQUEST['ano'];
$studentname=$_REQUEST['studentname'];
$fathername=$_REQUEST['fathername'];
$nationality=$_REQUEST['nationality'];
$religion=$_REQUEST['religion'];
$community=$_REQUEST['community'];
$sex=$_REQUEST['sex'];
$dob=$_REQUEST['dob'];
$pdf = new FPDF('L','mm',array(210,170));
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->SetXY(61,47); $pdf->Cell(15,3,$ano,0,1);
$pdf->SetFont('Arial','',10);
$pdf->SetXY(110,57); $pdf->Cell(15,3,$fathername,0,1);
$pdf->SetXY(168,220); $pdf->Cell(15,3,'Medium',0,1);
$pdf->Output();
?>
