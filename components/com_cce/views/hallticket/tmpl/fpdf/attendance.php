<?php
require('fpdf.php');

$title='ATTENDANCE CERTIFICATE';
$studentname=$_REQUEST['sname'];
$ano = $_REQUEST['ano'];
$gender= $_REQUEST['gen'];
$class=$_REQUEST['class'];
$academicyear=$_REQUEST['academicyear'];
$workingdays=$_REQUEST['workingdays'];
$present=$_REQUEST['present'];
$percent=$_REQUEST['percent'];
$place=$_REQUEST['place'];
$type1=$_REQUEST['print1'];
$type2=$_REQUEST['print2'];
if($type1)
	$type='1';
else	
	$type='2';


$cdate=$_REQUEST['cdate'];
$schoolname=$_REQUEST['schoolname'];
$schooladdress=$_REQUEST['schooladdress'];


$pdf = new FPDF('L','mm',array(210,170));
$pdf->AddPage();
$pdf->SetFont('Arial','B',17);
$pdf->setMargins(20,20,20);
if($type=='1') {
	$pdf->SetXY(100,14); $pdf->Cell(15,3,$schoolname,0,1,'C');
	$pdf->SetFont('Arial','B',14);
	$pdf->SetXY(100,19); $pdf->Cell(15,3,$schooladdress,0,1,'C');

}
//$pdf->SetFont('Arial','B',14);
//$pdf->SetXY(40,38); $pdf->Cell(15,3,$ano,0,1);
//$pdf->SetXY(165,38); $pdf->Cell(15,3,$cdate,0,1);

if($type=='1') {
	$pdf->Line(10,43,200,43);
}

$row=60;
$gap=8;

$pdf->SetFont('Arial','B',22);
$pdf->SetXY(55,50); $pdf->Cell(15,3,$title,0,1);
$pdf->SetFont('Arial','',13);
$pdf->SetXY(15,$row);
$pdf->write(10,'1. Name of the Student ');
$pdf->SetXY(100,$row);
$pdf->write(10,':');
$pdf->SetXY(110,$row);
$pdf->SetFont('Arial','B',14);
$pdf->write(10,$studentname);

$row=$row+$gap;
$pdf->SetXY(15,$row);
$pdf->SetFont('Arial','',13);
$pdf->write(10,'2. Gender');
$pdf->SetXY(100,$row);
$pdf->write(10,':');
$pdf->SetXY(110,$row);
$pdf->SetFont('Arial','B',14);
$pdf->write(10,$gender);

$row=$row+$gap;
$pdf->SetXY(15,$row);
$pdf->SetFont('Arial','',13);
$pdf->write(10,'3. Admission No.');
$pdf->SetXY(100,$row);
$pdf->write(10,':');
$pdf->SetXY(110,$row);
$pdf->SetFont('Arial','B',14);
$pdf->write(10,$ano);

$row=$row+$gap;
$pdf->SetXY(15,$row);
$pdf->SetFont('Arial','',13);
$pdf->write(10,'4. Class & Section');
$pdf->SetXY(100,$row);
$pdf->write(10,':');
$pdf->SetXY(110,$row);
$pdf->SetFont('Arial','B',14);
$pdf->write(10,$class);

$row=$row+$gap;
$pdf->SetXY(15,$row);
$pdf->SetFont('Arial','',13);
$pdf->write(10,'5. Academic Year');
$pdf->SetXY(100,$row);
$pdf->write(10,':');
$pdf->SetXY(110,$row);
$pdf->SetFont('Arial','B',14);
$pdf->write(10,$academicyear);

$row=$row+$gap;
$pdf->SetXY(15,$row);
$pdf->SetFont('Arial','',13);
$pdf->write(10,'6. Working Days');
$pdf->SetXY(100,$row);
$pdf->write(10,':');
$pdf->SetXY(110,$row);
$pdf->SetFont('Arial','B',14);
$pdf->write(10,$workingdays);

$row=$row+$gap;
$pdf->SetXY(15,$row);
$pdf->SetFont('Arial','',13);
$pdf->write(10,'7. Number of Days Present');
$pdf->SetXY(100,$row);
$pdf->write(10,':');
$pdf->SetXY(110,$row);
$pdf->SetFont('Arial','B',14);
$pdf->write(10,$present);

$row=$row+$gap;
$pdf->SetXY(15,$row);
$pdf->SetFont('Arial','',13);
$pdf->write(10,'8. Percentage(%)');
$pdf->SetXY(100,$row);
$pdf->write(10,':');
$pdf->SetXY(110,$row);
$pdf->SetFont('Arial','B',14);
$pdf->write(10,$percent);

if($type=='1') {
	$pdf->SetFont('Arial','B',14);
	$pdf->SetXY(160,145); $pdf->Cell(15,3,"Principal",0,1);
	$pdf->Line(10,150,200,150);
}
$pdf->Output();
?>
