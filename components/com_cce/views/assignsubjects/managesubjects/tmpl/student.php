<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
?>
<div>
        <div style="float:left;">
           <img src="<?php echo $iconsDir.'/termreports.png'; ?>" alt="" style="width: 64px; height: 64px;" />
        </div>
        <div>
                <div>&nbsp;</div>
                <h1>STUDENT'S TERM REPORTS</h1>
        </div>
<?php
	$r1link = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=classreports&view=rclasstermreport&layout=student&task=studenttermreport&termid='.$this->termid.'&studentid='.$this->studentid.'&courseid='.$this->courseid.'&report=1');
	$r2link = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=classreports&view=rclasstermreport&layout=student&task=studenttermreport&termid='.$this->termid.'&studentid='.$this->studentid.'&courseid='.$this->courseid.'&report=2');
	$r3link = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=classreports&view=rclasstermreport&layout=student&task=studenttermreport&termid='.$this->termid.'&studentid='.$this->studentid.'&courseid='.$this->courseid.'&report=3');

?>
 <div style="float:right;">
           <a href="<?php echo $r1link; ?>"><img src="<?php echo $iconsDir.'/report1.png'; ?>" alt="" style="width: 36px; height: 36px;" /></a>
           <a href="<?php echo $r2link; ?>"><img src="<?php echo $iconsDir.'/report2.png'; ?>" alt="" style="width: 36px; height: 36px;" /></a>
           <a href="<?php echo $r3link; ?>"><img src="<?php echo $iconsDir.'/report3.png'; ?>" alt="" style="width: 36px; height: 36px;" /></a>
        </div>

</div>
<hr />
<br />
<br />
<br />
<?php
//Report Heading
	echo '<center><h1>['.$this->srec->registerno.']'.$this->srec->firstname.'</h1><h3>['.$this->trec->term.']</h3></center>';
?>
 <br />
<?php
if($this->reportid==1){
?> 
<table border="1" cellspacing="2" cellpadding="3">
<tr>
<th class="list-title" >SNO</th><th class="list-title" >Code</th><th class="list-title" >Subject Title</th>
<?php
//Table FIELDS Heading
foreach($this->subjects as $subject){
	$gradebook= $this->model->getGradeBook($subject->id,$this->trec->id);
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
			echo '<th class="list-title">'.$ogt.'</th>';
			$ogt = $ngt;
		}
		//To print proper headings
		$details=$this->model->getGradeBookDetails($rec->id);
	
		$gs = count($details);
		if($rec->bestof != 0) {
			if($gs >= $rec->bestof) $gs = $rec->bestof;
		}
		echo '<th class="list-title" colspan="'.($gs+1).'">'.$rec->title.'('.$rec->weightage.'%)</th>';
		$overall = $overall + $rec->weightage;
    	}
	break;
}
echo '<th class="list-title">'.$ngt.'</th>';
echo '<th colspan="2" class="list-title">Overall</th>';
echo '</tr><tr><th colspan="3" class="list-title" align="right">SubCategories--></th>';
//Heading 2nd Row
foreach($this->subjects as $subject){
	$gradebook= $this->model->getGradeBook($subject->id,$this->trec->id);
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
		echo '<th class="list-title">'.'Grade'.'</th>';
		$ogt = $ngt;
	}
	if($rec->bestof==0){
		$j=1;
		foreach($details as $detail)
		{
			echo '<th class="list-title">'.$detail->code.'/'.$detail->marks.'</th>';
			$ws[$i][$j] = $detail->marks; 	
			$j++;
		}
	}else {
		$j=1;
		foreach($details as $detail)
		{
			if($j > $rec->bestof) break;
			echo '<th class="list-title">'.$detail->code.'/'.$detail->marks.'</th>';
			$ws[$i][$j] = $detail->marks; 	
			$j++;
		}
	}
	echo '<th class="list-title">'.$rec->code.'/'.$rec->weightage.'</th>';
	$i++;
 }
 break;
}
echo '<th class="list-title">'.'Grade'.'</th>';
echo '<th class="list-title">'.$overall.'</th>';
echo '<th class="list-title">Grade</th>';
echo '</tr>';
#print_r($ws);
//Processing the records(marks)
$sno=1;
foreach($this->subjects as $subject) { //for each student
	echo '<tr>';
	echo '<td>'.$sno++.'</td>';
	echo '<td>'.$subject->subjectcode.'</td>';
	echo '<td>'.$subject->subjectname.'</td>';
	$overalltotal = 0;
	
	$i=1;
	$gradebook= $this->model->getGradeBook($subject->id,$this->trec->id);
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
		        	$rs = $this->model->getScholasticAMarks($this->studentid,$detail->id,&$mrec);
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
			$this->model->getScholasticAMarksByCategory($this->studentid,$rec->id,$rec->bestof,&$marks);
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
   }  



//Report 2
 if($this->reportid==2){ ?>
<table border="1" cellspacing="2" cellpadding="3">
<tr>
<th class="list-title" >SNO</th><th class="list-title" >Code</th><th class="list-title" >Subject Title</th>
<?php
//Table FIELDS Heading
foreach($this->subjects as $subject){
	$gradebook= $this->model->getGradeBook($subject->id,$this->trec->id);
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
		echo '<th class="list-title">'.$ogt.'</th>';
		$ogt = $ngt;
	}
	//To print proper headings
	$details=$this->model->getGradeBookDetails($rec->id);
	
	$gs = count($details);
	if($rec->bestof != 0) 
		if($gs >= $rec->bestof) $gs = $rec->bestof;
	//echo '<th class="list-title" >'.$rec->title.'('.$rec->weightage.'%)</th>';
	$overall = $overall + $rec->weightage;
    }
    break;
}
echo '<th class="list-title">'.$rec->grouptag.'</th>';
echo '<th class="list-title">Overall</th>';
//echo '</tr><tr><th colspan="3" class="list-title" align="right">SubCategories--></th>';
//Heading 2nd Row
foreach($this->subjects as $subject){
	$gradebook= $this->model->getGradeBook($subject->id,$this->trec->id);
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
	//	echo '<th class="list-title">'.'Grade'.'</th>';
		$ogt = $ngt;
	}
	if($rec->bestof==0){
		$j=1;
		foreach($details as $detail)
		{
	//		echo '<th class="list-title">'.$detail->code.'/'.$detail->marks.'</th>';
			$ws[$i][$j] = $detail->marks; 	
			$j++;
		}
	}else {
		$j=1;
		foreach($details as $detail)
		{
			if($j > $rec->bestof) break;
	//		echo '<th class="list-title">'.$detail->code.'/'.$detail->marks.'</th>';
			$ws[$i][$j] = $detail->marks; 	
			$j++;
		}
	}
	//echo '<th class="list-title">'.$rec->code.'/'.$rec->weightage.'</th>';
	$i++;
 }
 break;
}
//echo '<th class="list-title">'.'Grade'.'</th>';
//echo '<th class="list-title">'.$overall.'</th>';
//echo '<th class="list-title">Grade</th>';
//echo '</tr>';
#print_r($ws);
//Processing the records(marks)
$sno=1;
foreach($this->subjects as $subject) { //for each student
	echo '<tr>';
	echo '<td>'.$sno++.'</td>';
	echo '<td>'.$subject->subjectcode.'</td>';
	echo '<td>'.$subject->subjectname.'</td>';
	$overalltotal = 0;
	
	$i=1;
	$gradebook= $this->model->getGradeBook($subject->id,$this->trec->id);
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
			echo '<td align="center"><b>'.$grec->letter.'</b></td>';
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
		        	$rs = $this->model->getScholasticAMarks($this->studentid,$detail->id,&$mrec);
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
			$this->model->getScholasticAMarksByCategory($this->studentid,$rec->id,$rec->bestof,&$marks);
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
                        	 //       echo '<td align="right">--</td>';
					$k++;
					$maxtotal = $maxtotal + $ws[$i][$j];
					$j++;
				}
			}
		}
		$i++;
		$gtotal = $gtotal + round($sum/$maxtotal*$rec->weightage,1);
		$gmax = $gmax + $rec->weightage;
	//	echo '<td align="right"><b>'.round($sum/$maxtotal*$rec->weightage,1).'</b></td>';		
		$overalltotal = $overalltotal + round($sum/$maxtotal*$rec->weightage);
	}
	$gg = $gtotal/$gmax * 100;
	$this->model->getFAGradeLetter(round($gg,0),$grec);
	echo '<td align="center"><b>'.$grec->letter.'</b></td>';
	//echo '<td align="right"><b>'.round($overalltotal,0).'</b></td>';
	$this->model->getFAGradeLetter(round($overalltotal,0),$grec);
	echo '<td align="center"><b>'.$grec->letter.'</b></td>';
	echo '</tr>';
} 
?>
</table>

<?php } ?>


