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
$pdf = new FPDF();
$pdf->SetTopMargin(10);
$pdf->AddPage();
$pdf->SetFont('Arial','B',12);
$pdf->SetXY(170,34); $pdf->Cell(15,3,$ano,0,1);
$pdf->SetXY(110,53); $pdf->Cell(15,3,$studentname,0,1);
$pdf->SetFont('Arial','',10);
$pdf->SetXY(110,57); $pdf->Cell(15,3,$fathername,0,1);
$pdf->SetXY(110,62); $pdf->Cell(15,3,$nationality.'-'.$religion,0,1);
$pdf->SetXY(110,66); $pdf->Cell(15,3,$community,0,1);
$pdf->SetXY(110,70); $pdf->Cell(15,3,$sex,0,1);
$pdf->SetXY(110,75); $pdf->Cell(15,3,$dob,0,1);
$pdf->SetXY(110,79); $pdf->Cell(15,3,'DOB IN WORDS',0,1);
$pdf->SetXY(110,86); $pdf->Cell(15,3,'Identification Mark1',0,1);
$pdf->SetXY(110,91); $pdf->Cell(15,3,'Identification Mark2',0,1);
$pdf->SetXY(110,95); $pdf->Cell(15,3,'Admitted Date-Admitted Class',0,1);
$pdf->SetXY(110,99); $pdf->Cell(15,3,'words',0,1);
$pdf->SetXY(110,103); $pdf->Cell(15,3,'Current Class',0,1);
$pdf->SetXY(110,113); $pdf->Cell(15,3,'--',0,1);
$pdf->SetXY(110,119); $pdf->Cell(15,3,'--',0,1);
$pdf->SetXY(110,132); $pdf->Cell(15,3,'--',0,1);
$pdf->SetXY(110,140); $pdf->Cell(15,3,'--',0,1);
$pdf->SetXY(110,144); $pdf->Cell(15,3,$x,0,1);
$pdf->SetXY(110,150); $pdf->Cell(15,3,'Qualified or not?',0,1);
$pdf->SetXY(110,154); $pdf->Cell(15,3,'Scholarships',0,1);
$pdf->SetXY(110,162); $pdf->Cell(15,3,'nature of Scholarships',0,1);
$pdf->SetXY(110,165); $pdf->Cell(15,3,'Medical Inspection',0,1);
$pdf->SetXY(110,169); $pdf->Cell(15,3,'--',0,1);
$pdf->SetXY(110,175); $pdf->Cell(15,3,'Left Date',0,1);
$pdf->SetXY(110,180); $pdf->Cell(15,3,'Conduct',0,1);
$pdf->SetXY(110,184); $pdf->Cell(15,3,'Date of Appl. TC',0,1);
$pdf->SetXY(110,195); $pdf->Cell(15,3,'Date TC',0,1);
$pdf->SetXY(110,200); $pdf->Cell(15,3,'--',0,1);
$pdf->SetXY(75,220); $pdf->Cell(15,3,'2015-2016',0,1);
$pdf->SetXY(110,220); $pdf->Cell(15,3,'VI STD',0,1);
$pdf->SetXY(140,220); $pdf->Cell(15,3,'First Language',0,1);
$pdf->SetXY(168,220); $pdf->Cell(15,3,'Medium',0,1);
$pdf->Output();
?>
