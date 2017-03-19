<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');
	JHTML::script('validate.js', 'components/com_cce/js/');
	$Itemid = JRequest::getVar('Itemid');
	$courseid = JRequest::getVar('courseid');
	$studentid= JRequest::getVar('studentid');
	$mg= JRequest::getVar('mg');

	$GLOBALS['cgpa']=0;
	$GLOBALS['sub_count']=0;
	

	$iconsDir1 = JURI::base() . 'components/com_cce/images';

   	$model = & $this->getModel('exams');
	$courses = $model->getCurrentCourses();
	if(!isset($courseid)) $courseid=$courses[0]->id;

	$parts = $model->getCourseParts($courseid);
	
	$srecs  = $model->getStudents($courseid);

   	$dashboardItemid = $model->getMenuItemid('manageschool','Dash Board');
   	if($dashboardItemid) ;
   	else{
        	$dashboardItemid = $model->getMenuItemid('topmenu','Manage School');
   	}
	$masterItemid = $model->getMenuItemid('manageschool','Exams');
        if($masterItemid) ;
        else{
                $masterItemid = $model->getMenuItemid('topmenu','Manage School');
        }
   	$dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
   	$modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=fees&Itemid='.$masterItemid);

	$oldgbid='-1';

$gr=1; //To enable grade letter

?>


<b style="font: bold 15px Georgia, serif;">STUDENTS GRADE BOOK </b>
<div style="float:right;">
<table border="0" width="100%"><tr><td style="text-align:left;">
	<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce&controller=exams&view=exams&task=display&Itemid='.$Itemid); ?>" method="POST" name="adminForm">
	<select id="selectError" data-rel="chosen"  onchange="submit();"  style="width:100px;" name="courseid">
		<option value="">Select a Course</option>
		<?php
		foreach($courses as $course) :
			echo "<option value=\"".$course->id."\" ".($course->id == $courseid? "selected=\"yes\"" : "").">".$course->code."</option>";
		endforeach;
		?>
	</select>
     	<select id="selectError1" data-rel="chosen" onchange="submit();" style="width:250px;" name="studentid">
                <option value="">Select a Student</option>
                <?php
                foreach($srecs  as $srec) :
                        echo "<option value=\"".$srec->id."\" ".($srec->id == $studentid? "selected=\"yes\"" : "").">".$srec->firstname."</option>";
                endforeach;
                ?>
        </select>
     	<select id="selectError2" data-rel="chosen" onchange="submit();" style="width:200px;" name="mg">
        	<option value="1" <?php if($mg=="1") echo 'selected="yes"'; else echo ""; ?>>Show Marks with Grades</option>
        	<option value="2" <?php if($mg=="2") echo 'selected="yes"'; else echo ""; ?>>Show Marks only</option>
        	<option value="3" <?php if($mg=="3") echo 'selected="yes"'; else echo ""; ?>>Show Grades only</option>
        </select>

	<input type="hidden" name="view" value="exams" />

	<input type="hidden" name="controller" value="exams" />
	<input type="hidden" name="layout" value="showstudentsgradebook" />
	<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
	</form>
</td>
</tr></table>
</div>




<?php
	//RECURSIVE FUNCTION TO DISPLAY THE SUBJECTS
	function displaySubjects($part,$prec,$model,$psno,$csno,$l,$terms,$cbid,$courseid,$studentid,$Itemid,$mg){
		if($mg=="1"){
			$gr=1;   //Enable Grades also
			$mr=1;
		}else if($mg=="2"){
			$gr="0";
			$mr="1";
		}else if($mg=="3"){
			$gr="1";
			$mr="0";
		}else{
			$gr="1";
			$mr="1";
		}


		//TABLE HEADINGS 
		$r1 = $model->getSubjectGradeMaxMark($prec->id,$gmax);

		if($psno==1){	
			$hs0= '<table border="1" width="100%"><tr style="background-color:grey;"><td rowspan="2" width="4%" style="text-align:center;"><b>SNO</b></td><td rowspan="2" width="10%" style="text-align:center;"><b>Subject</b></td><td rowspan="2" width="6%" style="text-align:center;"><b>Code</b></td>';
			$hs= '<tr style="background-color:;">';
		} else	{
			$hs0= '</table><br /><table border="1" width="100%"><tr <tr style="background-color:grey;"><td rowspan="2" width="4%"><b>SNO</b></td><td rowspan="2" width="10%"><b>Subject</b></td><td rowspan="2" width="6%"><b>Code</b></td>';
			$hs= '<tr>';
		}


			//To Display Terms and Grade Books
			$gtotal1=0;
			foreach($terms as $term){
//			$hs=$hs. '<td>';
//			$hs=$hs. '<table width="100%" cellpadding="0" cellspacing="0"  border="0">';
//			$hs=$hs. '<tr>';
				$rs=$model->getSubjectTermGradeBook($prec->id,$term->id,$gbrec);
				if($rs){
					$newgbid=$newgbid.$gbrec->gbid;
					
					$pprecs = $model->getTGradeBookParentEntries($gbrec->gbid);

					$termc=count($pprecs);
					if($mr=="1"&&$gr=="1"){
						$termcc=(($termc*2)+2);
						$w1=$w=(80/($termcc));
					}else{
						$termcc=($termc+1);
						$w1=$w=(80/$termcc);
					}
						
					$hs0=$hs0. '<td colspan="'.$termcc.'" style="text-align:center;background-color:grey;"><b>'.$term->term.'</b></td>';
	

$w=$w1='';

					$tot=0;
					foreach($pprecs as $pprec){
						if($mr=="1"){
							$hs=$hs. '<td style="background-color:grey;width:'.$w.'%; text-align:center;">';
							$hs=$hs. $pprec->code.'<br />/'.$pprec->weightage;
							$hs=$hs.'</td>'; 
						}
						if($gr=="1")
							$hs=$hs. '<td style="background-color:grey;width:'.$w.'%;text-align:center;">'.$pprec->code.'<br />GR'.'</td>'; //Grade Letter 
						if($pprec->subtotalfield!=1)
							$tot=$tot+$pprec->weightage;
					}
					$gtotal1=$gtotal1+$tot;
					if($mr=="1"){
						$hs=$hs. '<td style="background-color:grey;width:'.$w.'%;text-align:center;">';
						$hs=$hs. 'TOT/'.round($tot,0);
						$hs=$hs. '</td>'; 
					}
					if($gr=="1"){
						$hs=$hs. '<td style="background-color:grey;width:'.$w.'%;text-align:center;">';
						$hs=$hs. 'GR';
						$hs=$hs. '</td>'; 
					}
				}
//			$hs=$hs. '</tr>';
//			$hs=$hs. '</table>';
//			$hs=$hs. '</td>';
			}

			//To display the Summary Columns
		    if(count($terms)>1){	//required if more than one term
			$serecs = $model->getSummaryEntries($prec->id);

//			$hs=$hs. '<td>';
//			$hs=$hs. '<table width="100%" cellpadding="0" border="0">';
//			$hs=$hs. '<tr>';
				$overallc=count($serecs);
				if($mr!="1" && $gr=="1" && $part->gpa!="1"){  $overallcc=$overallc+1; $w=(80/($overallcc)); }
				if($mr!="1" && $gr=="1" && $part->gpa=="1"){ $overallcc=$overallc+2; $w=(80/($overallcc));  }

				if($mr=="1" && $gr!="1" && $part->gpa!="1"){ $overallcc=$overallc+1; $w=(80/($overallcc)); }
				if($mr=="1" && $gr!="1" && $part->gpa=="1"){ $overallcc=$overallc+2; $w=(80/($overallcc)); }

				if($mr=="1" && $gr=="1" && $part->gpa!="1"){ $overallcc=$overallc*2+2; $w=(80/($overallcc)); }
				if($mr=="1" && $gr=="1" && $part->gpa=="1"){ $overallcc=$overallc*2+3; $w=(80/($overallcc)); }

				$hs0=$hs0. '<td colspan="'.$overallcc.'" style="background-color:grey;text-align:center;"><b>Overall Grade</b></td></tr>';
$w='';
				foreach($serecs as $serec){
					if($mr=="1"){
						$hs=$hs. '<td style="background-color:grey;width:'.$w.'%;text-align:center;">';
						$hs=$hs. $serec->code;
						$hs=$hs. '</td>';
					}
					if($gr=="1"){
						$hs=$hs. '<td style="background-color:grey;width:'.$w.'%;text-align:center;">';
						$hs=$hs. $serec->code.'<br />GR';
						$hs=$hs. '</td>';
					}
				}

				if($mr=="1"){
					$hs=$hs. '<td style="background-color:grey;width:'.$w.'%;text-align:center;">';
					$hs=$hs. 'TOT';
					$hs=$hs. '</td>';
				}
				if($gr=="1"){
					$hs=$hs. '<td style="background-color:grey;width:'.$w.'%;text-align:center;">';
					$hs=$hs. 'GR';
					$hs=$hs. '</td>';
				}
				if($part->gpa=="1"){
					$hs=$hs. '<td style="background-color:grey;width:'.$w.'%;text-align:center;">';
					$hs=$hs. 'GP';
					$hs=$hs. '</td>';
				}
//				$hs=$hs. '</tr>';
//				$hs=$hs. '</table>';
//				$hs=$hs. '</td>';
			}

			$hs=$hs. '</tr>';


			if(md5($GLOBALS['oldgbid']) != md5($newgbid)){
				$GLOBALS['oldgbid']=$newgbid;
				$fs=$hs0.$hs;
			}else{
				$fs='';
			}
			//END OF TABLE HEADINGS


			$fs=$fs. '<tr>';
			$fs=$fs. '<td>';
				if($csno==''){
					$fs = $fs."$psno";
				}else{
				        $fs = $fs. $psno.'.'.$csno;
				}
			$fs = $fs .'</td>';
			$fs = $fs .'<td align="left" width="20%">';
				$sp='';
				for($i=0;$i<$l;$i++) $sp=$sp.'&nbsp;&nbsp;&nbsp;';
				$fs=$fs.$sp.$prec->subjecttitle;
			$fs=$fs.'</td>';
			$fs=$fs.'<td>'.$prec->subjectcode.'</td>';

			//$fs='';

			$gtotal=0;
			$ggtotal=0;
			foreach($terms as $term){
//				$fs=$fs. '<td>';
//				$fs=$fs. '<table width="100%" cellpadding="0" border="0">';
//				$fs=$fs. '<tr>';
				$rs=$model->getSubjectTermGradeBook($prec->id,$term->id,$gbrec);
				if($rs){
					$pprecs = $model->getTGradeBookParentEntries($gbrec->gbid);
					$w=(80/(count($pprecs)*2+2));
					$tot1=0;
					$gtot1=0;
					foreach($pprecs as $pprec){
						$model->getGradeBookEntryIdByTgbid($pprec->id,$prec->id,$term->id,$courseid,$xrec);
						//Get Marks
						if($pprec->subtotalfield=="1"){
						        //find subtotal
				                        //$model->getGradeBookEntry($pprec->id,$gbrec);
				                        $ssrecs = $model->getSubTotalEntries($pprec->id);
				                        $subsum=0;
				                        $tsum=0;
				                        foreach($ssrecs as $ssrec){
                                				$r = $model->getGradeBookEntryIdTGBID($prec->id,$term->id,$ssrec->sgbid,$cgbrec);
				                                if($r){
                                				        $ma = $model->getMarks($studentid,$cgbrec->id,$cgbrec->weightage);
				                                        if($ma=="-1") $ma=0;
                                				        $subsum+=$ma;
				                                        $tsum+=$cgbrec->weightage;
                                				}
                        				}
				                        $marks=($subsum/$tsum)*$pprec->weightage;
						}else
							$marks = $model->getMarks($studentid,$xrec->id,$pprec->weightage);


						
						if($marks=="-1") $marks="-";
						else $marks=round($marks,1);
						if($pprec->subtotalfield!="1"){
							$tot1=$tot1+$marks;
							$gtot1=$gtot1+$pprec->weightage;
						}
						if($mr=="1"){
							$fs=$fs. '<td style="width:'.$w1.'%;text-align:center;">';
							$fs=$fs. $marks;
							$fs=$fs. '</td>';
						}

						if($gr=="1") {
                                        		$r=$model->getSubjectGradeLetter($prec->id,round((($marks/$pprec->weightage)*$gmax->max),0),$grec);
                                        		if($r=="true" && $r1=="true" && $marks != '-')
                                                		$fs=$fs. "<td style=\"width:'.$w1.'%;text-align:center;\"><b>".$grec->letter."</b></td>";
                                        		else
                                                		$fs=$fs. "<td style=\"width:'.$w1.'%;text-align:center;\"><b>-</b></td>";
                                		}



			//			$fs=$fs. '<td style="width:'.$w.'%;text-align:center;">'.'X'.'</td>'; //Grade Letter
					}
					$gtotal=$gtotal+$tot1;
					$ggtotal=$ggtotal+$gtot1;
					if($mr=="1"){
						$fs=$fs. '<td style="width:'.$w1.'%;text-align:center;">';
						$fs=$fs.$tot1;
						$fs=$fs.'</td>';
					}
					if($gr=="1"){	
						//$r1 = $model->getSubjectGradeMaxMark($prec->id,$gmax);
						$r=$model->getSubjectGradeLetter($prec->id,round((($tot1/$gtot1)*$gmax->max),0),$grec);
						//echo '<br />'.$tot1.'/'.$gtot1.'*'.$gmax->max.'='.$tot1/$gtot1*$gmax->max;
						$fs=$fs. '<td style="width:'.$w1.'%;text-align:center;">';
						$fs=$fs.'<b>'.$grec->letter.'</b>';
						$fs=$fs.'</td>';
					}
				
				}	
//				$fs=$fs. '</tr>';
//				$fs=$fs. '</table>';
//				$fs=$fs. '</td>';
			}




			//PROCESS SUMMARY COLS
		     if(count($terms)>1){
//			$fs=$fs. '<td>';
//			$fs=$fs. '<table width="100%" cellpadding="0" border="0">';
//			$fs=$fs. '<tr>';

				if($mr!="1" && $gr=="1" && $part->gpa!="1")  $w=(80/(count($serecs)+1));
				if($mr1="1" && $gr=="1" && $part->gpa=="1")  $w=(80/(count($serecs)+1+1));

				if($mr=="1" && $gr!="1" && $part->gpa!="1")  $w=(80/(count($serecs)+1));
				if($mr=="1" && $gr!="1" && $part->gpa=="1")  $w=(80/(count($serecs)+1+1));

				if($mr=="1" && $gr=="1" && $part->gpa!="1")  $w=(80/(count($serecs)+2+1+1));
				if($mr=="1" && $gr=="1" && $part->gpa=="1")  $w=(80/(count($serecs)+2+1+1+1));

$w='';


				$gtotal2=0;
				$ggtotal2=0;
                                foreach($serecs as $serec){
					$seobjs = $model->getSummaryColEntries($serec->id);
					$tot1=0;
					$gtot1=0;
					$sc_sum=0;
					foreach($seobjs as $seobj){
						//Get T Grade Book Entry
				        	$model->getTGradeBookEntry($seobj->gbeid,$gberec) ;

						//Get Actual Subject Grade Book Entry by Template GB Entry ID
						$model->getGradeBookEntryIdByTgbid($seobj->gbeid,$prec->id,$seobj->termid,$courseid,$xrec);
                                                if($gberec->subtotalfield=="1"){
                                                        //find subtotal
                                                        //$model->getGradeBookEntry($pprec->id,$gbrec);
                                                        $ssrecs = $model->getSubTotalEntries($gberec->id);
                                                        $subsum=0;
                                                        $tsum=0;
                                                        foreach($ssrecs as $ssrec){
                                                                $r = $model->getGradeBookEntryIdTGBID($prec->id,$seobj->termid,$ssrec->sgbid,$cgbrec);
                                                                if($r){
                                                                        $ma = $model->getMarks($studentid,$cgbrec->id,$cgbrec->weightage);
                                                                        if($ma=="-1") $ma=0;
                                                                        $subsum+=$ma;
                                                                        $tsum+=$cgbrec->weightage;
                                                                }
                                                        }
                                                        $marks=($subsum/$tsum)*$gberec->weightage;
                                                }else
                                                        $marks = $model->getMarks($studentid,$xrec->id,$gberec->weightage);

                                                if($marks=="-1") $marks="0";
                                                else $marks=round($marks,1);
                                                if($gberec->subtotalfield!="1"){
                                                        $tot1=$tot1+$marks;
                                                }
						$sc_sum=$sc_sum+$marks;
                                                $gtot1=$gtot1+$gberec->weightage;

					}//END FOR

					if($serec->summarytype==2){
						$sc_sum = $sc_sum/count($seobjs);
					}

				

                                        if($mr=="1"){
                                                $fs=$fs. '<td style="width:'.$w.'%;text-align:center;">';
                                                $fs=$fs.$sc_sum;
                                                $fs=$fs.'</td>';
                                        }
                                        if($gr=="1"){
						$r=$model->getSubjectGradeLetter($prec->id,round((($sc_sum/$gtot1)*100),0),$grec);
						//echo '<br />'.$tot1.'/'.$gtot1.'*'.$gmax->max.'='.$tot1/$gtot1*$gmax->max;
						$fs=$fs. '<td style="width:'.$w.'%;text-align:center;">';
						$fs=$fs. '<b>'.$grec->letter.'</b>';
                                                $fs=$fs. '</td>';
                                        }
					$gtotal2+=$sc_sum;
					$ggtotal2+=$gtot1;
                                }

				if($gtotal2==0 && $ggtotal2==0){
					$gtotal2=$gtotal;
					$ggtotal2=$ggtotal;
				}

				$r=$model->getSubjectGradeLetter($prec->id,round(($gtotal2/$ggtotal2)*100,0),$grec);
				if($mr=="1"){
					$fs=$fs.'<td style="width:'.$w.'%;text-align:center;">';
					$fs=$fs.$gtotal2;
					$fs=$fs.'</td>';
				}
				if($gr=="1"){
					//echo '<br />'.$gtotal.'/'.$ggtotal.'*'.$gmax->max.'='.$gtotal/$ggtotal*$gmax->max;
					$fs=$fs.'<td style="width:'.$w.'%;text-align:center;">';
					$fs=$fs.'<b>'.$grec->letter.'</b>';
					$fs=$fs.'</td>';

				}
				if($part->gpa=="1"){
					$fs=$fs.'<td style="width:'.$w.'%;text-align:center;">';
					if($grec->points<="0")
						$fs=$fs.'<b>'.'--'.'</b>';
					else
						$fs=$fs.'<b>'.$grec->points.'</b>';
					$fs=$fs.'</td>';
					if($prec->subjectcategory=="1"){
						$GLOBALS['cgpa'] = $GLOBALS['cgpa'] + $grec->points;
						$GLOBALS['sub_count'] = $GLOBALS['sub_count'] + 1;
					}
				}
//			$fs=$fs. '</tr>';
//			$fs=$fs. '</table>';
//			$fs=$fs. '</td>';
			}
		//	echo $fs;
		$fs=$fs.'</tr>';
		$GLOBALS['html']=$GLOBALS['html'].$fs;

		$crecs = $model->getTSubjectChildEntries($prec->id);
		if(count($crecs)==0){
			return;
		}
		$csno=1;
		$l++;
		foreach($crecs as $crec){
			displaySubjects($part,$crec,$model,$psno,$csno++,$l,$terms,$cbid,$courseid,$studentid,$Itemid,$mg);
		}
	}


?>







<?php 
//DISPLAY PARTS -> TERMS -> SUBJECTS
foreach ($parts as $part){
	$GLOBALS['html']='';
	$GLOBALS['oldgbid']=-1;
	$terms = $model->getTTerms($part->id);
	$srecs = $model->getTSubjects($part->id);
?>
<div class="row-fluid sortable">
	<div class="box span12">
		<div class="box-header well" data-original-title>
			<i class="icon-edit"></i> <?php echo $part->title; ?>
			<div class="box-icon">
				<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
			</div>
		</div>
		<div class="box-content">
		<!--	<table class="stable" cellpadding="0" cellspacing="0" border="1" width="100%">
			<tbody> -->
  			<?php
                                        $precs=$model->getParentTSubjects($part->id);
                                        $j=1;
                                        if($precs){
                                                foreach($precs as $prec){
                                                        displaySubjects($part,$prec,$model,$j++,'',0,$terms,$cbid,$courseid,$studentid,$Itemid,$mg);
                                                }
                                        }
                                        $i++;

					echo $GLOBALS['html'];

					if($part->gpa=="1"){
						printf("<tr><td colspan=\"46\" style=\"text-align:right;\"><b>Cumulative Grade Point Average(CGPA): %.2f </b></td></tr>",($GLOBALS['cgpa']/$GLOBALS['sub_count']));
						printf("<tr><td colspan=\"46\" style=\"text-align:right;\"><b>Overall Indicative Percentage of Marks(9.5xCGPA): %.2f </b></td></tr>",(9.5*($GLOBALS['cgpa']/$GLOBALS['sub_count'])));
					}
                                ?>

			</tbody>

			</table>
		</div>
	</div>
</div>
<?php
} //END FOR

?>
