<?php
require('fpdf.php');

$ano = $_REQUEST['sno'];
$gender= $_REQUEST['gen'];
$cdate=$_REQUEST['cdate'];
$title='CONDUCT CERTIFICATE';
$studentname=$_REQUEST['sname'];
$yearfrom=$_REQUEST['beginyear'];
$yearto=$_REQUEST['endyear'];
$stdfrom=$_REQUEST['beginclass'];
$stdto=$_REQUEST['endclass'];
$conduct=$_REQUEST['conduct'];
$prefix=$_REQUEST['prefix'];
$type1=$_REQUEST['print1'];
$type2=$_REQUEST['print2'];
if($type1)
	$type='1';
else	
	$type='2';


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
$pdf->SetFont('Arial','B',14);
$pdf->SetXY(40,38); $pdf->Cell(15,3,$ano,0,1);
$pdf->SetXY(165,38); $pdf->Cell(15,3,$cdate,0,1);

if($type=='1') {
	$pdf->Line(10,43,200,43);
}

$pdf->SetFont('Arial','B',22);
$pdf->SetXY(55,59); $pdf->Cell(15,3,$title,0,1);
$pdf->SetFont('Arial','',15);
$pdf->SetXY(35,75);
$pdf->write(10,'This is to certify that '.$prefix.' ');
$pdf->SetFont('Arial','B',17);
$pdf->write(10,$studentname);
$pdf->SetFont('Arial','',15);
$pdf->write(10,' was studying in this school from ');
$pdf->SetFont('Arial','B',17);
$pdf->write(10,$yearfrom." to ".$yearto);
$pdf->SetFont('Arial','',15);
$pdf->write(10,' in ');
$pdf->SetFont('Arial','B',17);
$pdf->write(10,$stdfrom);
$pdf->SetFont('Arial','',15);
$pdf->write(10," STD to ");
$pdf->SetFont('Arial','B',17);
$pdf->write(10,$stdto);
$pdf->SetFont('Arial','',15);
$pdf->write(10,' STD  and during this period '.$gender .' Conduct and Character was ');
$pdf->SetFont('Arial','B',17);
$pdf->write(10,$conduct);
$pdf->SetFont('Arial','',15);
$pdf->write(10,'.');
if($type=='1') {
	$pdf->SetFont('Arial','B',14);
	$pdf->SetXY(160,145); $pdf->Cell(15,3,"Principal",0,1);
	$pdf->Line(10,150,200,150);
}
$pdf->Output();
?>
