
<style>
table.subjects{
	border-collapse:collapse;
	background:#FFF;
	width: 100%;
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
	$Itemid = JRequest::getVar('Itemid');
	$reportid= JRequest::getVar('report');
	$r = $this->model->getCourse($this->courseid,$courserec);
	$model1=& $this->getModel('schoolcal');
	$model2=& $this->getModel('classattendance');
	$model3=& $this->getModel('classleave');
	$status=$this->model->getSchoolInfo($rec);
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');
?>
<?php
        $isModal = JRequest::getVar( 'print' ) == 1; // 'print=1' will only be present in the url of the modal window, not in the presentation of the page
        if( $isModal) {
                $href = '"#" onclick="window.print(); return false;"';
        } else {
                $href = 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no';
                $href = "window.open(this.href,'win2','".$href."'); return false;";
        $href = 'index.php/class-reports?controller=classreports&report=1&view=rclasstermreport&layout=student&task=studenttermreport&termid='.$this->trec->id.'&studentid='.$this->srec->id.'&courseid='.$this->courseid.'&report='.$reportid.'&tmpl=component&print=1 '.$href;
        }

?>
       <table style="border:none;" width="100%" border="0"><tr style="border:none;"><td class="report" style="border:none;" align="right"> <a href=<?php echo $href; ?> ><img src="<?php echo $iconsDir.'/printer.png'; ?>" alt="" style="width: 22px; height: 22px;" /></a></td></tr></table>


<?php
	$status=$this->model->getSchoolInfo($rec);
?>
<center>

                <h1 style="font-size:26px;"><strong><?php echo $rec->schoolname; ?></strong></h1><br>
                <h3><?php echo $rec->schooladdress; ?></h3>
</center>

<?php
	$r1link = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=classreports&view=rclasstermreport&layout=student&task=studenttermreport&termid='.$this->termid.'&studentid='.$this->studentid.'&courseid='.$this->courseid.'&report=1&Itemid='.$Itemid);
	$r2link = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=classreports&view=rclasstermreport&layout=student&task=studenttermreport&termid='.$this->termid.'&studentid='.$this->studentid.'&courseid='.$this->courseid.'&report=2&Itemid='.$Itemid);
	$r3link = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=classreports&view=rclasstermreport&layout=student&task=studenttermreport&termid='.$this->termid.'&studentid='.$this->studentid.'&courseid='.$this->courseid.'&report=3&Itemid='.$Itemid);

?>
 <div style="float:right;">
           <a href="<?php echo $r1link; ?>"><img src="<?php echo $iconsDir.'/report1.png'; ?>" alt="" style="width: 26px; height: 26px;" /></a>
           <a href="<?php echo $r2link; ?>"><img src="<?php echo $iconsDir.'/report2.png'; ?>" alt="" style="width: 26px; height: 26px;" /></a>
           <a href="<?php echo $r3link; ?>"><img src="<?php echo $iconsDir.'/report3.png'; ?>" alt="" style="width: 26px; height: 26px;" /></a>
</div>
<hr style="background-color:black;" />
<br />

<font size="3px" style="color:black;"><b>
<table width="100%" class="subjects" >
	<tr class="report">
		<td class="report">Class</td><td class="report" align="left"><?php echo $courserec->coursename; ?></td>
		<td class="report">Reg.No</td><td class="report"><?php echo $this->srec->registerno; ?></td>
	</tr>
	<tr class="report">
		<td class="report" >Term</td><td class="report"><?php echo $this->trec->term; ?></td>
		<td class="report">Student Name</td><td class="report"><?php echo $this->srec->firstname; ?></td>
	</tr>
</table></b></font>
</h2>
<br />
<center><b><font style="color:black; font-size:18px; font-family:Georgia;">Part-I: Academic Performance : Scholastic Areas</font></b></center>

<br>
<?php
//Report==1
if($this->reportid==1){
?> 
<table class="subjects">
<tr class="report">
<th class="report-list-title" >S#</th><th class="report-list-title" >Code</th><th class="report-list-title" >Subject Title</th>
<?php
//Table FIELDS Heading
foreach($this->subjects as $subject){
	$gradebook= $this->model->getGradeBook($subject->id,$this->courseid,$this->trec->id);
	//Heading 1st Row
	$overall = 0;
	$i=1;
	foreach($gradebook as $rec) {
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
		if($rec->bestof != 0) {
			if($gs >= $rec->bestof) $gs = $rec->bestof;
		}
		echo '<th class="report-list-title" colspan="'.($gs+1).'">'.$rec->title.'('.$rec->weightage.'%)</th>';
		$overall = $overall + $rec->weightage;
    	}
	break;
}
echo '<th class="report-list-title">'.$ngt.'</th>';
echo '<th colspan="2" class="report-list-title">Overall</th>';
echo '</tr><tr class="report"><th colspan="3" class="report-list-title" align="right">SubCategories--></th>';
//Heading 2nd Row
foreach($this->subjects as $subject){
	$gradebook= $this->model->getGradeBook($subject->id,$this->courseid,$this->trec->id);
	$i=1;
	$gt='1';
	$grouptotal=0;
	$ws = array();
        foreach($gradebook as $rec) {
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
			echo '<th class="report-list-title">'.$detail->code.'/<br>'.$detail->marks.'</th>';
			$ws[$i][$j] = $detail->marks; 	
			$j++;
		}
	}else {
		$j=1;
		foreach($details as $detail)
		{
			if($j > $rec->bestof) break;
			echo '<th class="report-list-title">'.$detail->code.'/<br>'.$detail->marks.'</th>';
			$ws[$i][$j] = $detail->marks; 	
			$j++;
		}
	}
	echo '<th class="report-list-title">'.$rec->code.'/<br>'.$rec->weightage.'</th>';
	$i++;
 }
 break;
}
echo '<th class="report-list-title">'.'Grade'.'</th>';
echo '<th class="report-list-title">'.$overall.'</th>';
echo '<th class="report-list-title">Grade</th>';
echo '</tr>';
#print_r($ws);
//Processing the records(marks)
$sno=1;
foreach($this->subjects as $subject) { //for each student
	echo '<tr class="report">';
	echo '<td class="report">'.$sno++.'</td>';
	echo '<td class="report">'.$subject->subjectcode.'</td>';
	echo '<td class="report">'.$subject->subjecttitle.'</td>';
	$overalltotal = 0;
	
	$i=1;
	$gradebook= $this->model->getGradeBook($subject->id,$this->courseid,$this->trec->id);
	$gtotal=0;
	$gmax=0;
	foreach($gradebook as $rec) { //for each category
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
			echo '<td class="report">'.$grec->letter.'</td>';
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
		        	$rs = $this->model->getScholasticAMarks($this->studentid,$detail->id,$mrec);
				if($rs){
					if($mrec->marks=='A')
					{
						echo '<td class="report" align="right">A</td>';
					}else{
						echo '<td class="report" align="right">'.round($mrec->marks,1).'</td>';
						$sum = $sum + $mrec->marks;
					}
				}else{
					echo '<td class="report" align="right">--</td>';
				}
			}
		}else{ //For number of subcategories
			$this->model->getScholasticAMarksByCategory($this->studentid,$rec->id,$rec->bestof,$marks);
			$j=1;
                        foreach($marks as $mark)
                        {
                                $maxtotal  = $maxtotal + $mark['max'];
                                $sum = $sum + $mark['marks'];
				//echo '->'.$mark['marks'].'->'.$mark['max'].'->'.$ws[$i][$j];
				$m = ($mark['marks']/$mark['max'])*$ws[$i][$j];
				$j++;
                                echo '<td class="report" align="right">'.round($m,1).'</td>';
                        }
			//Fill with -- if the student has not got all the marks
			if(count($marks) < $gs){
				$rem= $gs - count($marks);
				$k=1;
				while($k<=$rem){
                        	        echo '<td class="report" align="right">--</td>';
					$k++;
					$maxtotal = $maxtotal + $ws[$i][$j];
					$j++;
				}
			}
		}
		$i++;
		$gtotal = $gtotal + round($sum/$maxtotal*$rec->weightage,1);
		$gmax = $gmax + $rec->weightage;
		echo '<td class="report" align="right"><b>'.round($sum/$maxtotal*$rec->weightage,1).'</b></td>';		
		$overalltotal = $overalltotal + round($sum/$maxtotal*$rec->weightage);
	}
	$gg = $gtotal/$gmax * 100;
	$this->model->getFAGradeLetter(round($gg,0),$grec);
	echo '<td class="report"><b>'.$grec->letter.'</b></td>';
	echo '<td class="report" align="right"><b>'.round($overalltotal,0).'</b></td>';
	$this->model->getFAGradeLetter(round($overalltotal,0),$grec);
	echo '<td align="right" class="report"><b>'.$grec->letter.'</b></td>';
	echo '</tr>';
} 
?>
</table>
<?php
   }  



//Report 2
 if($this->reportid==2){ ?>

<table class="subjects">
<?php
//Table FIELDS Heading
foreach($this->subjects as $subject){
	$gradebook= $this->model->getGradeBook($subject->id,$this->courseid,$this->trec->id);
	//Heading 1st Row
	$overall = 0;
	$i=1;
	foreach($gradebook as $rec) {
		 //To calculate the group grade
		 if($i==1){
			$ngt = $rec->grouptag;
			$ogt = $rec->grouptag;
		}else{
			$ngt = $rec->grouptag;
		}
		$i++;
		if($ngt != $ogt){
		//	echo '<th class="report">'.$ogt.'</th>';
			$ogt = $ngt;
		}
		//To print proper headings
		$details=$this->model->getGradeBookDetails($rec->id);
	
		$gs = count($details);
		if($rec->bestof != 0) {
			if($gs >= $rec->bestof) $gs = $rec->bestof;
		}
		//echo '<th class="report" colspan="'.($gs+1).'">'.$rec->title.'('.$rec->weightage.'%)</th>';
		$overall = $overall + $rec->weightage;
    	}
	break;
}
//echo '<th class="report">'.$ngt.'</th>';
//echo '<th colspan="2" class="report">Overall</th>';

//Heading 2nd Row
echo '</tr><tr class="report"<th class="report-list-title" align="right">S#</th><th class="report-list-title" align="left">Code</th><th class="report-list-title" align="left">Subject Title</th>';
foreach($this->subjects as $subject){
	$gradebook= $this->model->getGradeBook($subject->id,$this->courseid,$this->trec->id);
	$i=1;
	$gt='1';
	$grouptotal=0;
	$ws = array();
        foreach($gradebook as $rec) {
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
		//	echo '<th class="report">'.$detail->code.'/'.$detail->marks.'</th>';
			$ws[$i][$j] = $detail->marks; 	
			$j++;
		}
	}else {
		$j=1;
		foreach($details as $detail)
		{
			if($j > $rec->bestof) break;
		//	echo '<th class="report">'.$detail->code.'/'.$detail->marks.'</th>';
			$ws[$i][$j] = $detail->marks; 	
			$j++;
		}
	}
	echo '<th class="report-list-title">'.$rec->code.'/'.$rec->weightage.'</th>';
	$i++;
 }
 break;
}
echo '<th class="report-list-title">'.'Grade'.'</th>';
echo '<th class="report-list-title">'.$overall.'</th>';
echo '<th class="report-list-title">Grade</th>';
echo '</tr>';
#print_r($ws);

//Processing the records(marks)
$sno=1;
foreach($this->subjects as $subject) { //for each student
	echo '<tr class="report"';
	echo '<td class="report">'.$sno++.'</td>';
	echo '<td class="report">'.$subject->subjectcode.'</td>';
	echo '<td class="report">'.$subject->subjecttitle.'</td>';
	$overalltotal = 0;
	
	$i=1;
	$gradebook= $this->model->getGradeBook($subject->id,$this->courseid,$this->trec->id);
	$gtotal=0;
	$gmax=0;
	foreach($gradebook as $rec) { //for each category
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
			echo '<td class="report"><center>'.$grec->letter.'</center></td>';
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
		        	$rs = $this->model->getScholasticAMarks($this->studentid,$detail->id,$mrec);
				if($rs){
					if($mrec->marks=='A')
					{
					//	echo '<td align="right">A</td>';
					}else{
					//	echo '<td align="right">'.round($mrec->marks,1).'</td>';
						$sum = $sum + $mrec->marks;
					}
				}else{
					//echo '<td align="right">--</td>';
				}
			}
		}else{ //For number of subcategories
			$this->model->getScholasticAMarksByCategory($this->studentid,$rec->id,$rec->bestof,$marks);
			$j=1;
                        foreach($marks as $mark)
                        {
                                $maxtotal  = $maxtotal + $mark['max'];
                                $sum = $sum + $mark['marks'];
				//echo '->'.$mark['marks'].'->'.$mark['max'].'->'.$ws[$i][$j];
				$m = ($mark['marks']/$mark['max'])*$ws[$i][$j];
				$j++;
                               // echo '<td align="right">'.round($m,1).'</td>';
                        }
			//Fill with -- if the student has not got all the marks
			if(count($marks) < $gs){
				$rem= $gs - count($marks);
				$k=1;
				while($k<=$rem){
                        	//        echo '<td align="right">--</td>';
					$k++;
					$maxtotal = $maxtotal + $ws[$i][$j];
					$j++;
				}
			}
		}
		$i++;
		$gtotal = $gtotal + round($sum/$maxtotal*$rec->weightage,1);
		$gmax = $gmax + $rec->weightage;
		echo '<td class="report" align="center"><b>'.round($sum/$maxtotal*$rec->weightage,1).'</b></td>';		
		$overalltotal = $overalltotal + round($sum/$maxtotal*$rec->weightage);
	}
	$gg = $gtotal/$gmax * 100;
	$this->model->getFAGradeLetter(round($gg,0),$grec);
	echo '<td class="report"><center><b>'.$grec->letter.'</b></center></td>';
	echo '<td align="center" class="report"><b>'.round($overalltotal,0).'</b></td>';
	$this->model->getFAGradeLetter(round($overalltotal,0),$grec);
	echo '<td align="center" class="report"><b>'.$grec->letter.'</b></td>';
	echo '</tr>';
} 
?>
</table>
<?php 

} 

//Report 3 
 if($this->reportid==3){ ?>

<table class="subjects" >
<?php
//Table FIELDS Heading
foreach($this->subjects as $subject){
	$gradebook= $this->model->getGradeBook($subject->id,$this->courseid,$this->trec->id);
	//Heading 1st Row
	$overall = 0;
	$i=1;
	foreach($gradebook as $rec) {
		 //To calculate the group grade
		 if($i==1){
			$ngt = $rec->grouptag;
			$ogt = $rec->grouptag;
		}else{
			$ngt = $rec->grouptag;
		}
		$i++;
		if($ngt != $ogt){
		//	echo '<th class="report">'.$ogt.'</th>';
			$ogt = $ngt;
		}
		//To print proper headings
		$details=$this->model->getGradeBookDetails($rec->id);
	
		$gs = count($details);
		if($rec->bestof != 0) {
			if($gs >= $rec->bestof) $gs = $rec->bestof;
		}
		//echo '<th class="report" colspan="'.($gs+1).'">'.$rec->title.'('.$rec->weightage.'%)</th>';
		$overall = $overall + $rec->weightage;
    	}
	break;
}
//echo '<th class="report">'.$ngt.'</th>';
//echo '<th colspan="2" class="report">Overall</th>';

//Heading 2nd Row
echo '</tr><tr class="report"<th class="report-list-title" align="right">S#</th><th class="report-list-title" align="left">Code</th><th class="report-list-title" align="left">Subject Title</th>';
foreach($this->subjects as $subject){
	$gradebook= $this->model->getGradeBook($subject->id,$this->courseid,$this->trec->id);
	$i=1;
	$gt='1';
	$grouptotal=0;
	$ws = array();
        foreach($gradebook as $rec) {
	 $details=$this->model->getGradeBookDetails($rec->id);
 	 if($i==1){
		$ngt = $rec->grouptag;
		$ogt = $rec->grouptag;
	 }else{
		$ngt = $rec->grouptag;
	 }

	 if($ngt != $ogt){
		echo '<th class="report-list-title">'.'FA'.'</th>';
		$ogt = $ngt;
	}
	if($rec->bestof==0){
		$j=1;
		foreach($details as $detail)
		{
		//	echo '<th class="report">'.$detail->code.'/'.$detail->marks.'</th>';
			$ws[$i][$j] = $detail->marks; 	
			$j++;
		}
	}else {
		$j=1;
		foreach($details as $detail)
		{
			if($j > $rec->bestof) break;
		//	echo '<th class="report">'.$detail->code.'/'.$detail->marks.'</th>';
			$ws[$i][$j] = $detail->marks; 	
			$j++;
		}
	}
//	echo '<th class="report">'.$rec->code.'/'.$rec->weightage.'</th>';
	$i++;
 }
 break;
}
echo '<th class="report-list-title">'.'SA'.'</th>';
//echo '<th class="report">'.$overall.'</th>';
echo '<th class="report-list-title">Overall Grade</th>';
echo '</tr>';
#print_r($ws);

//Processing the records(marks)
$sno=1;
foreach($this->subjects as $subject) { //for each student
	echo '<tr class="report"';
	echo '<td class="report">'.$sno++.'</td>';
	echo '<td class="report">'.$subject->subjectcode.'</td>';
	echo '<td class="report">'.$subject->subjecttitle.'</td>';
	$overalltotal = 0;
	
	$i=1;
	$gradebook= $this->model->getGradeBook($subject->id,$this->courseid,$this->trec->id);
	$gtotal=0;
	$gmax=0;
	foreach($gradebook as $rec) { //for each category
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
			echo '<td class="report"><b><center>'.$grec->letter.'</center></b></td>';
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
		        	$rs = $this->model->getScholasticAMarks($this->studentid,$detail->id,$mrec);
				if($rs){
					if($mrec->marks=='A')
					{
					//	echo '<td align="right">A</td>';
					}else{
					//	echo '<td align="right">'.round($mrec->marks,1).'</td>';
						$sum = $sum + $mrec->marks;
					}
				}else{
					//echo '<td align="right">--</td>';
				}
			}
		}else{ //For number of subcategories
			$this->model->getScholasticAMarksByCategory($this->studentid,$rec->id,$rec->bestof,$marks);
			$j=1;
                        foreach($marks as $mark)
                        {
                                $maxtotal  = $maxtotal + $mark['max'];
                                $sum = $sum + $mark['marks'];
				//echo '->'.$mark['marks'].'->'.$mark['max'].'->'.$ws[$i][$j];
				$m = ($mark['marks']/$mark['max'])*$ws[$i][$j];
				$j++;
                               // echo '<td align="right">'.round($m,1).'</td>';
                        }
			//Fill with -- if the student has not got all the marks
			if(count($marks) < $gs){
				$rem= $gs - count($marks);
				$k=1;
				while($k<=$rem){
                        	//        echo '<td align="right">--</td>';
					$k++;
					$maxtotal = $maxtotal + $ws[$i][$j];
					$j++;
				}
			}
		}
		$i++;
		$gtotal = $gtotal + round($sum/$maxtotal*$rec->weightage,1);
		$gmax = $gmax + $rec->weightage;
//		echo '<td align="center"><b>'.round($sum/$maxtotal*$rec->weightage,1).'</b></td>';		
		$overalltotal = $overalltotal + round($sum/$maxtotal*$rec->weightage);
	}
	$gg = $gtotal/$gmax * 100;
	$this->model->getFAGradeLetter(round($gg,0),$grec);
	echo '<td class="report"><center><b>'.$grec->letter.'</b></center></td>';
//	echo '<td align="center"><b>'.round($overalltotal,0).'</b></td>';
	$this->model->getFAGradeLetter(round($overalltotal,0),$grec);
	echo '<td class="report" align="center"><b>'.$grec->letter.'</b></td>';
	echo '</tr>';
} 
?>
</table>
<?php 
}

//Co-Scholastic Areas....
//Report==1
if($this->reportid==1){
	echo '<br /><center><b><font style="color:black; font-size:18px; font-family:Georgia;">Part-II: Co-Scholastic Areas</font></b></center>';
	$lsrecs=$this->model->getLSActivities();
	$avrecs=$this->model->getAttitudesAndValues();
	$carecs=$this->model->getCoScholasticAActivities();
	$cbrecs=$this->model->getCoScholasticBActivities();
	$m1=$this->getModel('cosmarks');
	$m2=$this->getModel('scholasticbgrades');

	$subjects = array('ls'=>array('Life Skills',$lsrecs),'av'=>array('Attitude and Values',$avrecs),'cosa'=>array('Wellness and Yoga/Holistic Exercise',$carecs),'cosb'=>array('Co-Curricular Activities',$cbrecs));
	foreach($subjects as $key => $sub){
		echo '<br><h3 class="report-item-page-title"><b>'.$sub[0].'</b></h2><br>'; 
		echo '<table class="subjects">';
		echo '<tr class="report"><th width="20%" class="report-list-title">Code</th><th width="60%" class="report-list-title">Title</th><th width="20%" class="report-list-title">Grade</th></tr>';
		$sum=0;
		foreach($sub[1] as $rec){
			echo '<tr class="report">';
			if($key=='ls')
  				$r = $m1->getLSCoSMarks($this->studentid,$rec->id,$this->courseid,$this->termid,$data);	
			if($key=='av')
  				$r = $m1->getAVCoSMarks($this->studentid,$rec->id,$this->courseid,$this->termid,$data);	
			if($key=='cosa')
  				$r = $m1->getCoSAMarks($this->studentid,$rec->id,$this->courseid,$this->termid,$data);	
			if($key=='cosb')
  				$r = $m1->getCoSBMarks($this->studentid,$rec->id,$this->courseid,$this->termid,$data);	
			echo '<td class="report">'.$rec->activitycode.'</td>';
			echo '<td class="report">'.$rec->activityname.'</td>';
			$s=$m2->getScholasticBGradeLetter(round($data[0]['marks'],0),$grec);
			echo '<td class="report">'.$grec->letter.'</td>';
			$sum=$sum+$data[0]['marks'];
			echo "</tr>";
		}
			$s1=$m2->getScholasticBGradeLetter(round($sum/count($sub[1]),0),$grec);
			echo '<tr class="report"<td class="report" colspan="'.count($sub[1]).'">'.'<b>Overall Grade: '.$grec->letter.'</b></td></tr>';
		echo '</table>';
	}
}
//Report==2
if($this->reportid==2 || $this->reportid==3){
		echo '<br /><center><b><font style="color:black; font-size:18px; font-family:Georgia;">Part-II: Co-Scholastic Areas</font></b></center><br>';
	$lsrecs=$this->model->getLSActivities();
	$avrecs=$this->model->getAttitudesAndValues();
	$carecs=$this->model->getCoScholasticAActivities();
	$cbrecs=$this->model->getCoScholasticBActivities();
	$m1=$this->getModel('cosmarks');
	$m2=$this->getModel('scholasticbgrades');

	$subjects = array('ls'=>array('Life Skills',$lsrecs),'av'=>array('Attitude and Values',$avrecs),'cosa'=>array('Wellness and Yoga/Holistic Exercise',$carecs),'cosb'=>array('Co-Curricular Activities',$cbrecs));
	echo '<table class="subjects">';
	echo '<tr class="report"><th width="60%" class="report-list-title">Subject Area</th><th width="40%" class="report-list-title">Grade</th></tr>';
	foreach($subjects as $key => $sub){
		$sum=0;
		foreach($sub[1] as $rec){
		//	echo "<tr class="report"";
			if($key=='ls')
  				$r = $m1->getLSCoSMarks($this->studentid,$rec->id,$this->courseid,$this->termid,$data);	
			if($key=='av')
  				$r = $m1->getAVCoSMarks($this->studentid,$rec->id,$this->courseid,$this->termid,$data);	
			if($key=='cosa')
  				$r = $m1->getCoSAMarks($this->studentid,$rec->id,$this->courseid,$this->termid,$data);	
			if($key=='cosb')
  				$r = $m1->getCoSBMarks($this->studentid,$rec->id,$this->courseid,$this->termid,$data);	
		//	echo '<td>'.$rec->activitycode.'</td>';
		//	echo '<td>'.$rec->activityname.'</td>';
		//	$s=$m2->getScholasticBGradeLetter(round($data[0]['marks'],0),$grec);
		//	echo '<td>'.$grec->letter.'</td>';
			$sum=$sum+$data[0]['marks'];
		//	echo "</tr>";
		}
		$s1=$m2->getScholasticBGradeLetter(round($sum/count($sub[1]),0),$grec);
		//echo '<tr class="report"<td colspan="'.count($sub[1]).'">'.'<b>Overall Grade: '.$grec->letter.'</b></td></tr>';
		echo '<tr class="report"><td class="report" style="color:black;">'.$sub[0].'</td><td class="report" style="color:black;"><center><b>'.$grec->letter.'</b></center></td></tr>';
	}
	echo '</table>';
}

?>

<br />
<br />
	
<centeR><h2 class="report-item-page-title"><b>Term Attendance</b></h2></center>
<br>
<table width="100%" class="subjects">
<tr class="report"><td class="report" style="color:black;" width="14%">Number of Working Days</td>
<?php
        $model1->getTotalWorkingDays($this->trec->startdate,$this->trec->stopdate,$wds);
	$model1->getTotalHalfWorkingDays($this->trec->startdate,$this->trec->stopdate,$hds);
        $tdays=($wds['0']['days']+($hds['0']['hdays'])/2);
        echo '<td class="report" style="color:black;" width="70%">'.$tdays.'</td>';
?>

</tr>

<td class="report" style="color:black;">Student's Attendance</td>
<?php
	$model2->getAbsentDays($term->startdate,$term->stopdate,$this->srec->id,$abs);
        $model3->getLeaveDays($term->startdate,$term->stopdate,$this->srec->id,$ls);
        $adays = ($abs['0']['abs']/2)+($ls['0']['ls']/2);
        $tadays=$tdays-$adays;
        echo '<td class="report" style="color:black;">'.($tdays-$adays).'</td>';
?>
</tr>
<tr class="report"><td class="report" style="color:black;">Percentage of Attendance</td>
<?php
        $percent = $tadays/$tdays*100;
        echo '<td class="report" style="color:black;">'.(round($percent,1)).'%</td>';
?>
</tr>
</table>
<br />
<br />
<br />
<b><table width="100%">
<tr class="report" style="border:none;"><td class="report" style="color:black; border:none;">Signature of Principal/Head Master</td><td style="border:none; color:black;">Signature of Teacher</td><td style="border:none; color:black;"align="right">Signature of Parent</td></tr>
</table></b>
