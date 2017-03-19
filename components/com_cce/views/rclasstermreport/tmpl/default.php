
<style>
table.subjects{
	border-collapse:collapse;
	background:#FFF;
	width: 1024px;
	margin: auto;
}
table.subjects tr td{
	padding:7px;border:1px solid #919191;
	font-size:12px;
}
table.subjects tr th{
	background:#E8E8E8;
	padding:4px;
	border:1px solid #919191;
	font-size:14px;
	font-weight:bold;
	color: #000;
}
.exam{
	font-size:14px;
}
</style>

<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');
	$Itemid = JRequest::getVar('Itemid');
	$print = JRequest::getVar('print');
	$status=$this->model->getSchoolInfo($rec);
?>

<?php
 
		$ccelink = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=classreports&view=rclasstermreport&task=classtermreport&termid='.$this->trec->id.'&subjectid='.$this->subjectid.'&Itemid='.$Itemid.'&courseid='.$this->courseid.'&print=1&report='.$reportid.'&tmpl=component&Itemid='.$Itemid);
	
?>
      
<div>
        <div align="center">
                <div><h1 class="item-page-title" style="color:black;"><b><?php echo $rec->schoolname; ?></b></h1></div>
                <div><h3 class="item-page-title"  style="color:black;"><?php echo $rec->schooladdress; ?></h3></div>
        </div>
<?php
/*
	$r1link = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=classreports&view=rclasstermreport&task=classtermreport&termid='.$this->termid.'&subjectid='.$this->subjectid.'&courseid='.$this->courseid.'&report=1');
	$r2link = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=classreports&view=rclasstermreport&task=classtermreport&termid='.$this->termid.'&subjectid='.$this->subjectid.'&courseid='.$this->courseid.'&report=2');
	$r3link = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=classreports&view=rclasstermreport&task=classtermreport&termid='.$this->termid.'&subjectid='.$this->subjectid.'&courseid='.$this->courseid.'&report=3');
*/
?>
<!--
 <div style="float:right;">
           <a href="<?php echo $r1link; ?>"><img src="<?php echo $iconsDir.'/report1.png'; ?>" alt="" style="width: 36px; height: 36px;" /></a>
           <a href="<?php echo $r2link; ?>"><img src="<?php echo $iconsDir.'/report2.png'; ?>" alt="" style="width: 36px; height: 36px;" /></a>
           <a href="<?php echo $r3link; ?>"><img src="<?php echo $iconsDir.'/report3.png'; ?>" alt="" style="width: 36px; height: 36px;" /></a>
        </div>

</div>
-->
<div style="background-color:black;">
<hr />
</div>
<br />


<?php
//Report Heading
	$fdata = '<center><h1 class="item-page-title"  style="color:black;">['.$this->srec->subjectcode.']'.$this->srec->subjecttitle.'</h1><h3 class="item-page-title"  style="color:black;">['.$this->trec->term.']</h3></center>';
	echo $fdata;;
?>
 <br />

<div style="color:black;">
<table class="subjects">
<thead>
<tr> 
<th class="report-list-title">S#</th><th class="report-list-title" >Rno</th><th class="report-list-title" >NAME</th>
<?php

//Table FIELDS Heading

//Heading 1st Row
$overall = 0;
$i=1;
foreach($this->gradebook as $rec) {
	//To calculate the group grade
	if($i==1){
		$ngt = $rec->grouptag;
		$ogt = $rec->grouptag;
	}else{
		$ngt = $rec->grouptag;
	}
	$i++;
	if($ngt != $ogt){
		echo '<th class="report-list-title">'.$ogt.'</th>';
		$ogt = $ngt;
	}
	//To print proper headings
	$details=$this->model->getGradeBookDetails($rec->id);
	$gs = count($details);
	if($rec->bestof != 0) 
		if($gs >= $rec->bestof) $gs = $rec->bestof;
	echo '<th class="report-list-title" colspan="'.($gs+1).'">'.$rec->title.'('.$rec->weightage.'%)</th>';
	$overall = $overall + $rec->weightage;
}
echo '<th class="report-list-title">'.$rec->grouptag.'</th>';
echo '<th colspan="2" class="report-list-title">Overall</th>';
echo '</tr><tr><th colspan="3" class="report-list-title" align="right">SubCategories--></th>';
//Heading 2nd Row

$i=1;
$gt='1';
$grouptotal=0;
$ws = array();
foreach($this->gradebook as $rec) {
	$details=$this->model->getGradeBookDetails($rec->id);
	if($i==1){
		$ngt = $rec->grouptag;
		$ogt = $rec->grouptag;
	}else{
		$ngt = $rec->grouptag;
	}

	if($ngt != $ogt){
		echo '<th class="report-list-title">'.'Grade'.'</th>';
		$ogt = $ngt;
	}
	if($rec->bestof==0){
		$j=1;
		foreach($details as $detail)
		{
			echo '<th class="report-list-title">'.$detail->code.'/'.$detail->marks.'</th>';
			$ws[$i][$j] = $detail->marks; 	
			$j++;
		}
	}else {
		$j=1;
		foreach($details as $detail)
		{
			if($j > $rec->bestof) break;
			echo '<th class="report-list-title">'.$detail->code.'/'.$detail->marks.'</th>';
			$ws[$i][$j] = $detail->marks; 	
			$j++;
		}
	}
	echo '<th class="report-list-title">'.$rec->code.'/'.$rec->weightage.'</th>';
	$i++;
}
echo '<th class="report-list-title">'.'Grade'.'</th>';
echo '<th>'.$overall.'</th>';
echo '<th>Grade</th></thead>';
echo '</tr>';
#print_r($ws);
//Processing the records(marks)
$sno=1;
foreach($this->students as $student) { //for each student
$gmax=0;
	echo '<tr>';
	echo '<td>'.$sno++.'</td>';
	echo '<td>'.$student->registerno.'</td>';
	echo '<td>'.$student->firstname.'</td>';
	$overalltotal = 0;
	
	$i=1;
	foreach($this->gradebook as $rec) { //for each category
		if($i==1){
			$ngt = $rec->grouptag;
			$ogt = $rec->grouptag;
			$gtotal=0;
		}else{
			$ngt = $rec->grouptag;
		}

		if($ngt != $ogt){
			$gg = $gtotal/$gmax * 100;
			$this->model->getFAGradeLetter(round($gg,0),$grec);
			echo '<td>'.$grec->letter.'</td>';
			$ogt = $ngt;
		}
		
		$sum=0;
		$maxtotal=0;
		$details=$this->model->getGradeBookDetails($rec->id);
		$gs = count($details);
		if(($gs >= $rec->bestof)&&($rec->bestof!=0)) $gs = $rec->bestof;
		//For best ALL sub-categories
		if($rec->bestof == 0){
	    		foreach($details as $detail) //for each subcategory
			{
				$maxtotal  = $maxtotal + $detail->marks;
		        	$rs = $this->model->getScholasticAMarks($student->id,$detail->id,$mrec);
				if($rs){
					if($mrec->marks=='A')
					{
						echo '<td align="right">A</td>';
					}else{
						echo '<td align="right">'.round($mrec->marks,1).'</td>';
						$sum = $sum + $mrec->marks;
					}
				}else{
					echo '<td align="right">--</td>';
				}
			}
		}else{ //For number of subcategories
			$this->model->getScholasticAMarksByCategory($student->id,$rec->id,$rec->bestof,$marks);
			$j=1;
                        foreach($marks as $mark)
                        {
                                $maxtotal  = $maxtotal + $mark['max'];
                                $sum = $sum + $mark['marks'];
				//echo '->'.$mark['marks'].'->'.$mark['max'].'->'.$ws[$i][$j];
				$m = ($mark['marks']/$mark['max'])*$ws[$i][$j];
				$j++;
                                echo '<td align="right">'.round($m,1).'</td>';
                        }
			//Fill with -- if the student has not got all the marks
			if(count($marks) < $gs){
				$rem= $gs - count($marks);
				$k=1;
				while($k<=$rem){
                        	        echo '<td align="right">--</td>';
					$k++;
					$maxtotal = $maxtotal + $ws[$i][$j];
					$j++;
				}
			}
		}
		$i++;
		$gtotal = $gtotal + round($sum/$maxtotal*$rec->weightage,1);
		$gmax = $gmax + $rec->weightage;
		echo '<td align="right"><b>'.round($sum/$maxtotal*$rec->weightage,1).'</b></td>';		
		$overalltotal = $overalltotal + round($sum/$maxtotal*$rec->weightage);
	}
	$gg = $gtotal/$gmax * 100;
	$this->model->getFAGradeLetter(round($gg,0),$grec);
	echo '<td><b>'.$grec->letter.'</b></td>';
	echo '<td align="right"><b>'.round($overalltotal,0).'</b></td>';
	$this->model->getFAGradeLetter(round($overalltotal,0),$grec);
	echo '<td align="right"><b>'.$grec->letter.'</b></td>';
	echo '</tr>';
} 
?>
</table>
<?php
// Open subscribers.txt for writing
$fh = fopen('/tmp/sample.html', 'a');
// Write the data
fwrite($fh, $fdata);
// Close the handle
fclose($fh);
?>
</div>
<div class="form-actions" align="right">
<?php if($print!=1) {?>
<a class="btn btn-primary" href="<?php echo $ccelink; ?>">
<i class="icon-print icon-white"></i>
Print
</a>
<?php }else {
	echo '<script>window.print();</script>';
} 
?>
</div>

