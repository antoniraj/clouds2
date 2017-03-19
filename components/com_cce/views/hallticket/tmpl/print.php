<?php

        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	$examid= JRequest::getVar('examid');
	$ttid= JRequest::getVar('ttid');
	$cid= JRequest::getVar('cid');
	$sid= JRequest::getVar('sid');

	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');
	$model = $this->model;
	$model1 = $this->model1;
	$model2 = $this->model2;
        $modelsms = & $this->getModel('sms');
	$courses=$model->getCurrentCourses();
	$exams =$model2->getTNGradeBook();
	$model2->getTNGradeBookEntry($examid,$erec);
	$timetablelist=$modelsms->getSMSTimetableList($examid,$list);
	$iconsDir1 = JURI::base() . 'components/com_cce/images';
   	$photoDir = JURI::base() . 'components/com_cce/studentsphoto/';
        $dashboardItemid = $model->getMenuItemid('manageschool','Dash Board');
        if($dashboardItemid) ;
        else{
                $dashboardItemid = $model->getMenuItemid('topmenu','Manage School');
        }
        $masterItemid = $model->getMenuItemid('manageschool','Master');
        if($masterItemid) ;
        else{
                $masterItemid = $model->getMenuItemid('topmenu','Manage School');
        }

	$model->getSchoolInfo($schoolinfo);


require('fpdf/fpdf.php');

class PDF extends FPDF
{
// Load data
function LoadData($file)
{
	// Read file lines
	$lines = file($file);
	$lines = array('adsfasf;asdfasf;asdfasdf;asdfasf');
	$data = array();
	foreach($lines as $line)
		$data[] = explode(';',trim($line));
	return $data;
}



// Page header
function HeaderTitle($arr)
{
        // Logo
    //    $this->Image('img2.PNG',9,10,30);
        // Arial bold 15
        // Move to the right
        $this->SetFont('Arial','B',15);
        $this->Cell(80);
        // Title
        $this->Cell(30,10,$arr[0],0,0,'C');
        $this->Ln(5);
        $this->Cell(80);
        $this->SetFont('Arial','B',9);
        $this->Cell(30,10,$arr[1],0,0,'C');
        $this->Ln(5);
        $this->Cell(80);
        $this->SetFont('Arial','B',10);
        $this->Cell(30,10,$arr[2],0,0,'C');
        $this->Ln(5);
        $this->Cell(80);
        $this->SetFont('Arial','B',12);
        $this->Cell(30,10,$arr[3],0,0,'C');
        $this->Ln(1);
        // Line break
	$this->Line(10,33,200,33);
        $this->Ln(15);
}



function StudentData($sobj,$class,$photo){
	$row=35;
	$gap=7;
	$fs=10;


	$this->Image($photo,150,38,40,42);
	$this->SetXY(150,$row+3);
        $this->Cell(40,42,'',1,0,'C');


	$this->SetXY(15,$row);
	$this->SetFont('Arial','',$fs);
	$this->write(10,'Student Name');
	$this->SetXY(60,$row);
	$this->write(10,':');
	$this->SetXY(70,$row);
	$this->SetFont('Arial','B',$fs);
	$this->write(10,$sobj->firstname);

	$row=$row+$gap;
	$this->SetXY(15,$row);
	$this->SetFont('Arial','',$fs);
	$this->write(10,'Gender');
	$this->SetXY(60,$row);
	$this->write(10,':');
	$this->SetXY(70,$row);
	$this->SetFont('Arial','B',$fs);
	$this->write(10,$sobj->gender);

	$row=$row+$gap;
	$this->SetXY(15,$row);
	$this->SetFont('Arial','',$fs);
	$this->write(10,'Date of Birth');
	$this->SetXY(60,$row);
	$this->write(10,':');
	$this->SetXY(70,$row);
	$this->SetFont('Arial','B',$fs);
	$this->write(10,JArrayHelper::indianDate($sobj->dob));

	$row=$row+$gap;
	$this->SetXY(15,$row);
	$this->SetFont('Arial','',$fs);
	$this->write(10,'Father Name');
	$this->SetXY(60,$row);
	$this->write(10,':');
	$this->SetXY(70,$row);
	$this->SetFont('Arial','B',$fs);
	$this->write(10,$sobj->pfathername);

	$row=$row+$gap;
	$this->SetXY(15,$row);
	$this->SetFont('Arial','',$fs);
	$this->write(10,'Class');
	$this->SetXY(60,$row);
	$this->write(10,':');
	$this->SetXY(70,$row);
	$this->SetFont('Arial','B',$fs);
	$this->write(10,$class);

	$row=$row+$gap+2;
	$this->SetXY(15,$row);
	$this->SetFont('Arial','',$fs);
	$this->write(10,'Student Sign');
	$this->SetXY(60,$row);
	$this->write(10,':');
	$this->SetXY(70,$row);
	$this->SetFont('Arial','B',$fs);
	$this->write(10,'');
        $this->Cell(60,9,'',1,0,'C');

	$row=$row+$gap+2;
	$this->SetXY(15,$row);
	$this->Ln(5);
        $this->SetFont('Arial','B',12);
        $this->Cell(80);
        // Title
        $this->Cell(30,10,'SCHEDULE OF EXAMINATION',0,0,'C');
	$this->SetFont('Arial','',$fs);
	$this->Ln();

}


// Better table
function ExamSchedule($header, $data,$ins)
{
	// Column widths
	$w = array(10, 20, 20,90,50);
	// Header
        $this->SetFont('Arial','B',10);
	for($i=0;$i<count($header);$i++)
		$this->Cell($w[$i],7,$header[$i],1,0,'C');
	$this->Ln();
        $this->SetFont('Arial','',10);
	// Data
	foreach($data as $row)
	{
		$rec = explode(":",$row);
		$this->Cell($w[0],7,$rec[0],1);
		$this->Cell($w[1],7,$rec[1],1);
		$this->Cell($w[2],7,$rec[2],1);
		$this->Cell($w[3],7,$rec[3],1);
		$this->Cell($w[4],7,$rec[4],1);
		$this->Ln();
	}
	$this->Ln(10);
        $this->SetFont('Arial','B',11);
	$this->Cell(10,7,'Signature of the Principal');
	$this->Ln(10);
        $this->SetFont('Arial','B',8);
	$this->Cell(10,7,'Instructions');
	$this->Ln(8);
        $this->SetFont('Arial','',8);
	$this->MultiCell(0,3,($ins));
	
	// Closing line
	//$this->Cell(array_sum($w),0,'','T');
}
}



$pdf = new PDF();
// Column headings
$header_title = array($schoolinfo->schoolname,$schoolinfo->schooladdress,$erec->title.' Examination','Hall Ticket');


$model->getStudent($sid,$sobj);
$model->getStudentClass($sid,$screc);
$fs=$model->getsiglestudentphoto($sobj->id,$file);
$ttrec = $modelsms->getSMSTimeTableListEntry($ttid,$trec);
$title = $trec->title;
$modelsms->getSMSTimeTableCourses($ttid,$ttcourses);
$r=$modelsms->getSMSTimeTableEntries($ttid,$ttrecs);


$pdf->SetFont('Arial','',14);
$pdf->AddPage();

$pdf->HeaderTitle($header_title);

$model->getsiglestudentphoto($sobj->id,$file);

//$str=$photoDir.$file->imagename;
//$pdf->StudentData($sobj,$screc->code,$str);


        $str = JPATH_COMPONENT.DS.'studentsphoto'.DS.$file->imagename;
        if(strlen($file->imagename)>0){
                $pdf->StudentData($sobj,$screc->code,$str);
        }else{
                $str1 = JPATH_COMPONENT.DS.'studentsphoto'.DS.'no-image.gif';
                $pdf->StudentData($sobj,$screc->code,$str1);
        }




$rf=0; //To find empty list
$r=$modelsms->getSMSTimeTableEntries($ttid,$ttrecs);
$i=1;
$recs = array();
foreach($ttrecs as $ttrec){
	if((strlen(trim($ttrec->fn))>1)&&(strlen(trim($ttrec->an))>1)) {
		$recs[]=$i++.':'.JArrayHelper::indianDate($ttrec->fdate).':Morning:'.htmlspecialchars($ttrec->fn).':';
		$recs[]=$i++.':'.JArrayHelper::indianDate($ttrec->fdate).':Evening:'.htmlspecialchars($ttrec->an).':';
	}else if((strlen(trim($ttrec->fn))>1)&&(strlen(trim($ttrec->an))<2)){
		$recs[] = $i++.':'.JArrayHelper::indianDate($ttrec->fdate).':Morning:'.htmlspecialchars($ttrec->fn).':';
	}else if((strlen(trim($ttrec->fn))>1)&&(strlen(trim($ttrec->an))<2)){
		$recs[] = $i++.':'.JArrayHelper::indianDate($ttrec->fdate).':Evening:'.htmlspecialchars($ttrec->an).':';
	} 
}


$eh=array('Sno','Date','Session','Subject Title','Signature of the Invigilator');
$pdf->ExamSchedule($eh,$recs,$erec->instructions);

//$pdf->BasicTable($header_title,$data);
//$pdf->AddPage();
//$pdf->ImprovedTable($header,$data);
//$pdf->AddPage();
//$pdf->FancyTable($header,$data);
$pdf->Output('/tmp/'.$sobj->id.'.pdf','D');
?>
