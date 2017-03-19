<script>
window.print();
</script>
<style>
table.subjects{
	border-collapse:collapse;
	background:#FFF;
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
	$r = $this->model->getCourse($this->courseid,$courserec);
	$terms = $this->model->getCurrentTerms();
	$model1=& $this->getModel('schoolcal');
	$model2=& $this->getModel('classattendance');
	$model3=& $this->getModel('classleave');
	$status=$this->model->getSchoolInfo($rec);
?>
<?php
        $isModal = JRequest::getVar( 'print' ) == 1; // 'print=1' will only be present in the url of the modal window, not in the presentation of the page
        if( $isModal) {
                $href = '"#" onclick="window.print(); return false;"';
        } else {
                $href = 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no';
                $href = "window.open(this.href,'win2','".$href."'); return false;";
                $href = '"index.php?option=com_cce&view=rclasstermreport&controller=classreports&layout=studentcons&task=studenttermreport&report=2&studentid='.$this->srec->id.'&courseid='.$this->courseid.'&tmpl=component&print=1" '.$href;
        }
?>

<div style="float:right;"><a href=<?php echo $href; ?> ><img src="<?php echo $iconsDir.'/printer.png'; ?>" alt="" style="width: 16px; height: 16px;" /></a></div>

<!--       <table width="100%" border="0"><tr><td align="right"> <a href=<?php echo $href; ?> ><img src="<?php echo $iconsDir.'/printer.png'; ?>" alt="" style="width: 22px; height: 22px;" /></a></td></tr></table>
-->
<?php
	$status=$this->model->getSchoolInfo($rec);
?>
<center>

                <h1 style="font-size:26px;"><strong><?php echo $rec->schoolname; ?></strong></h1><br>
                <h3><?php echo $rec->schooladdress; ?></h3>
</center>
<br />
<table class="subjects" width="100%">
	<tr>
		<td><b>Class</b></td><td align="left"><?php echo $courserec->coursename; ?></td>
		<td><b>Reg.No</b></td><td><?php echo $this->srec->registerno; ?></td>
	</tr>
	<tr>
		<td><b>Terms</b></td><td>All Terms</td>
		<td><b>Student Name</b></td><td><?php echo $this->srec->firstname; ?></td>
	</tr>
</table>
<br />
<center><h2>Part-I: Academic Performance :Scholastic Areas</h2></center>
<Br>

<?php
//Report 2
 if($this->reportid==2){ ?>

<table width="100%" class="subjects">
<?php

//Table FIELDS Heading
echo '<tr><th class="list-title" colspan="2" align="right">Terms--></th>';
foreach($terms as $term){
	echo '<th class="list-title" colspan="5">'.$term->term.'['.$term->months.']</th>';
}
echo '<th class="list-title" colspan="2">Overall</th></tr>';

//Heading 2nd Row
echo '</tr><tr><th class="list-title" align="right">S#</th><th class="list-title" align="left">Subject Title</th>';
//echo '</tr><tr><th class="list-title" align="right">S#</th><th class="list-title" align="left">Code</th><th class="list-title" align="left">Subject Title</th>';
foreach($this->subjects as $subject){
	foreach($terms as $term){
		$overall=0;
		$gradebook= $this->model->getGradeBook($subject->id,$this->courseid,$term->id);
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
				//echo '<th class="list-title">'.'Grade'.'</th>';
				$ogt = $ngt;
			}
			if($rec->bestof==0){
				$j=1;
				foreach($details as $detail)
				{
					//echo '<th class="list-title">'.$detail->code.'/'.$detail->marks.'</th>';
					$ws[$i][$j] = $detail->marks; 	
					$j++;
				}
			} else {
				$j=1;
				foreach($details as $detail)
				{
					if($j > $rec->bestof) break;
					//echo '<th class="list-title">'.$detail->code.'/'.$detail->marks.'</th>';
					$ws[$i][$j] = $detail->marks; 	
					$j++;
				}
			}
			echo '<th class="list-title">'.$rec->code.'/<br>'.$rec->weightage.'</th>';
			$overall = $overall+$rec->weightage;
			$i++;
 		}
	echo '<th class="list-title">'.'TOT/<br>'.$overall.'</th>';
	echo '<th class="list-title">Gra<br />de</th>';
	}//Term End
 		break;
}//Subject end
echo '<th class="list-title">'.'Grade'.'</th>';
echo '</tr>';

//Processing the records(marks)
$sno=1;
foreach($this->subjects as $subject) { //for each student
	echo '<tr>';
	echo '<td>'.$sno++.'</td>';
//	echo '<td>'.$subject->subjectcode.'</td>';
	echo '<td>'.$subject->subjecttitle.'</td>';
	$aoveralltotal = 0;
	foreach($terms as $term){
		$i=1;
		$overalltotal=0;
		$gradebook= $this->model->getGradeBook($subject->id,$this->courseid,$term->id);
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
				//$this->model->getFAGradeLetter(round($gg,0),$grec);
				//echo '<td><center>'.$grec->letter.'</center></td>';
				//echo '<td><center>'.$gtotal.'</center></td>';
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
							//echo '<td align="right">A</td>';
						}else{
							//echo '<td align="right">'.round($mrec->marks,1).'</td>';
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
			echo '<td align="center"><b>'.round($sum/$maxtotal*$rec->weightage,0).'</b></td>';		
			$overalltotal = $overalltotal + round($sum/$maxtotal*$rec->weightage);
		}
		echo '<td align="center"><b>'.round($overalltotal,0).'</b></td>';
		$this->model->getFAGradeLetter(round($overalltotal,0),$grec);
		echo '<td><center><b>'.$grec->letter.'</b></center></td>';
		$aoveralltotal = $aoveralltotal+$overalltotal;
	}
	//$gg = $gtotal/$gmax * 100;
	//$this->model->getFAGradeLetter(round($gg,0),$grec);
	//echo '<td><center><b>'.$grec->letter.'</b></center></td>';
	//echo '<td align="center"><b>'.round($overalltotal,0).'</b></td>';
	$this->model->getFAGradeLetter(round($aoveralltotal/3,0),$grec);
	echo '<td align="center"><b>'.$grec->letter.'</b></td>';
	echo '</tr>';
} 
?>
</table>
<?php 

} 

//Report==2
if($this->reportid==2 || $this->reportid==3){
	echo "<br /><center><h1>Part-2: Co-Scholastic Areas</h1></center><br> ";
	$lsrecs=$this->model->getLSActivities();
	$avrecs=$this->model->getAttitudesAndValues();
	$carecs=$this->model->getCoScholasticAActivities();
	$cbrecs=$this->model->getCoScholasticBActivities();
	$m1=$this->getModel('cosmarks');
	$m2=$this->getModel('scholasticbgrades');

	$subjects = array('ls'=>array('Life Skills',$lsrecs),'av'=>array('Attitude and Values',$avrecs),'cosa'=>array('Wellness and Yoga/Holistic Exercise',$carecs),'cosb'=>array('Co-Curricular Activities',$cbrecs));
	echo '<table class="subjects">';
	//Row 1
	echo '<tr><th class="list-title" align="right">Terms--></th>';
	foreach($terms as $term){
		echo '<th class="list-title">'.$term->term.'['.$term->months.']</th>';
	}
	echo '<th class="list-title">Overall</th></tr>';
	//Row 2
	echo '<tr><th width="60%" class="list-title">Subject Area</th>';
	foreach($terms as $term){
		echo '<th class="list-title">'.$term->code.'- Grade</th>';
	}

	echo '<th width="40%" class="list-title">Grade</th></tr>';
	foreach($subjects as $key => $sub){
	   echo '<tr><td>'.$sub[0].'</td>';
	   $asum=0;
	   $acount=0;
	   foreach($terms as $term){
		$sum=0;
		foreach($sub[1] as $rec){
		//	echo "<tr>";
			if($key=='ls')
  				$r = $m1->getLSCoSMarks($this->studentid,$rec->id,$this->courseid,$term->id,$data);	
			if($key=='av')
  				$r = $m1->getAVCoSMarks($this->studentid,$rec->id,$this->courseid,$term->id,$data);	
			if($key=='cosa')
  				$r = $m1->getCoSAMarks($this->studentid,$rec->id,$this->courseid,$term->id,$data);	
			if($key=='cosb')
  				$r = $m1->getCoSBMarks($this->studentid,$rec->id,$this->courseid,$term->id,$data);	
		//	echo '<td>'.$rec->activitycode.'</td>';
		//	echo '<td>'.$rec->activityname.'</td>';
		//	$s=$m2->getScholasticBGradeLetter(round($data[0]['marks'],0),$grec);
		//	echo '<td>'.$grec->letter.'</td>';
			$sum=$sum+$data[0]['marks'];
		//	echo "</tr>";
		}
		$asum = $asum+$sum;
		$acount=$acount+count($sub[1]);
		$s1=$m2->getScholasticBGradeLetter(round($sum/count($sub[1]),0),$grec);
		//echo '<tr><td colspan="'.count($sub[1]).'">'.'<b>Overall Grade: '.$grec->letter.'</b></td></tr>';
		echo '<td><center><b>'.$grec->letter.'</b></center></td>';
	   }//Term End
	   $s1=$m2->getScholasticBGradeLetter(round($asum/$acount,0),$grec);
	   echo '<td><center><b>'.$grec->letter.'</b></center></td></tr>';
	}//Subject End
	echo '</table>';
}

?>

<br />
<br />

<table width="100%" class="subjects">
<tr><th class="list-title">Term Attendance</th>
<?php
	foreach($terms as $term){
		echo '<th class="list-title">'.$term->term.'</th>';
	}
?>
<th class="list-title">Overall</th></tr>
<tr><td width="50%">Number of Working Days</td>
<?php
	$sum=0;
	$tdays=array();
	foreach($terms as $term){
		$model1->getTotalWorkingDays($term->startdate,$term->stopdate,$wds);			
		$model1->getTotalHalfWorkingDays($term->startdate,$term->stopdate,$hds);			
		$tdays[$term->code]=($wds['0']['days']+($hds['0']['hdays'])/2);
		echo '<td>'.$tdays[$term->code].'</td>';
		$sum = $sum + $tdays[$term->code];
	}
	echo '<td>'.$sum.'</td>';
?>

</tr>
<tr><td>Student's Attendance</td>
<?php
	$sum1=0;
	$tadays=array();
	foreach($terms as $term){
		$model2->getAbsentDays($term->startdate,$term->stopdate,$this->srec->id,$abs);
		$model3->getLeaveDays($term->startdate,$term->stopdate,$this->srec->id,$ls);
		$adays = ($abs['0']['abs']/2)+($ls['0']['ls']/2);
		$tadays[$term->code]=$tdays[$term->code]-$adays;
		echo '<td>'.($tdays[$term->code]-$adays).'</td>';
		$sum1=$sum1+$adays;
	}
	echo '<td>'.($sum-$sum1).'</td>';
?>
</tr><tr><td>Percentage of Attendance</td>
<?php
	foreach($terms as $term){
		$percent = $tadays[$term->code]/$tdays[$term->code]*100;
		echo '<td>'.(round($percent,1)).'%</td>';
	}
	echo '<td>'.round(($sum-$sum1)/$sum*100,1).'%</td>';
?>
</tr></table>
<br />
<br />
<br />
<br />
<br />
<b><table width="100%">
<tr><td>Signature of Principal/Head Master</td><td>Signature of Teacher</td><td align="right">Signature of Parent</td></tr>
</table></b>
