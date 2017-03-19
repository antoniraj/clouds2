<?php
    	defined('_JEXEC') OR DIE('Access denied..');
    	$app = JFactory::getApplication();
	JHTML::script('validate.js', 'components/com_cce/js/');
	$iconsDir = JURI::base() . 'components/com_cce/images/16x16';
	$Itemid = JRequest::getVar('Itemid');
	$classid= JRequest::getVar('courseid');
	$eon= JRequest::getVar('eon');
	if($eon){
		$editbuttontext="Turn Editing On";
		$eon=0;
	}else{
		$editbuttontext="Turn Editing Off";
		$eon=1;
	}
	$termid= JRequest::getVar('termid');
	$subjectid= JRequest::getVar('subjectid');
	$model=& $this->getModel('exams');
	$students = $model->getStudents($classid);
	$model->getGBSubject($subjectid,$sub);
	$model->getTTerm($termid,$trec);

	$maxHeadRows= $model->findHeadHeight($classid,$subjectid,$termid); //classid,$subjectid,$termid

?>


<style>
table {
    border-collapse: collapse;
}

table, th, td {
    border: 1px solid black;
}
</style>
<?php


//Queue Structure
class Ent{
	public $flag;
	public $id;
	public $status;
	public $isparent;
	public $subtotalfield;
};


//Print Heads
//Algorithm
// 1. Find Max Rows in head
// 2. Store all parents to queue
// 3. For each row 
//    3.1 

$gr=1; //To enable grade letter
$N =$maxHeadRows;
$precs = $model->getGradeBookParentEntries($classid,$subjectid,$termid);
$q=array();//Initialize the queue with all parents
$t=0;
foreach($precs as $prec){
	unset($obj);
	$obj = new Ent();
	$obj->flag=0;
	$obj->status=0;
	$obj->isparent=1;
	$obj->maxmarks=$prec->weightage;
	$obj->id=$prec->id;
	if($prec->subtotalfield!="1")
		$t = $t + $prec->weightage;
	else
		$obj->subtotalfield=$prec->subtotalfield;
	array_push($q,$obj);
}

?>
<div style="float:left;">
<h2><?php echo strtoupper($sub->subjectcode.': '.$sub->subjecttitle).' GRADE BOOK [ '.$trec->term.' ]'; ?> </h2>
</div>
<?php
$editonlink= JRoute::_('index.php?option=com_cce&controller=exams&view=exams&layout=subjectgradebook&eon='.$eon.'&courseid='.$classid.'&termid='.$termid.'&subjectid='.$subjectid.'&Itemid='.$Itemid);
$close = JRoute::_('index.php?option=com_cce&controller=exams&view=exams&layout=showcoursegradebook&courseid='.$classid.'&Itemid='.$Itemid);
?>
<div align="right">
<a class="btn btn-small btn-info" style="width:100px;" href="<?php echo $editonlink; ?>"><i class="icon-plus-sign"></i><?php echo $editbuttontext; ?></a>
<a class="btn btn-small btn-warning" style="width:50px;" href="<?php echo $close; ?>"><i class="icon-minus-sign"></i>Cancel</a>
</div>
<br />
<?php
echo '<table   style="border: 1px solid black;" width="100%">';
for($i=0; $i<$N; $i++){
	echo '<tr>';
	if($i==0){
		echo '<td style="vertical-align:middle;text-align:center;" rowspan="'.$N.'"><b>SNO</b></td>';
		echo '<td style="vertical-align:middle;text-align:center;" rowspan="'.$N.'"><b>STUDENT NAME</b></td>';
	}
	$tq=array();
	while(count($q)>0){
		unset($pobj);
		$pobj = new Ent();
		$pobj = array_shift($q);
		$x=$pobj->flag;
		$model->getGradeBookEntry($pobj->id,$prec);
		if($x==0){
			$count = $model->countChildren($pobj->id,1); //To merge cols
			
			$activityaddlink =JRoute::_('index.php?option=com_cce&controller=exams&view=exams&layout=addeditsubjectgradebookentry&aflag=1&gbeid='.$prec->id.'&subjectid='.$subjectid.'&termid='.$termid.'&classid='.$classid.'&Itemid='.$Itemid);
			$activityeditlink =JRoute::_('index.php?option=com_cce&controller=exams&view=exams&layout=addeditsubjectgradebookentry&aflag=0&gbeid='.$prec->id.'&subjectid='.$subjectid.'&termid='.$termid.'&classid='.$classid.'&Itemid='.$Itemid);
			$activitydeletelink =JRoute::_('index.php?option=com_cce&controller=exams&view=exams&layout=subjectgradebook&task=deletesubjectgradebookentry&gbeid='.$prec->id.'&subjectid='.$subjectid.'&termid='.$termid.'&classid='.$classid.'&Itemid='.$Itemid);
			
			if($count==1){
				//merge rows
				$s=$N-$i;
				$markslink=JRoute::_('index.php?option=com_cce&controller=exams&view=exams&layout=marksentry&gbeid='.$prec->id.'&subjectid='.$subjectid.'&termid='.$termid.'&classid='.$classid.'&Itemid='.$Itemid);
				if($eon){
					echo '<td style="vertical-align:middle;text-align:center;" rowspan="'.$s.'">';
					
					if($prec->required=="1" || $prec->subtotalfield=="1"){
						echo '<b>'.$prec->code.'/'.$prec->weightage.'</b><br />';
					}else{
						echo '<b><a href="'.$activityeditlink.'">'.$prec->code.'/'.$prec->weightage.'</b><br />';
					}
					if($prec->subtotalfield!="1") 
						echo '<a href="'.$activityaddlink.'"><img src="'.$iconsDir.'/assign.png"></a>';
					if($prec->required=="0"){
						echo '&nbsp;<a href="'.$activitydeletelink.'" onclick="return confirm(\'Are you sure to delete this item?\');"><img src="'.$iconsDir.'/delete.png"></a>';	
					}
					echo '</td>';
				}else{
					if($prec->subtotalfield!="1")
						echo '<td style="vertical-align:middle;text-align:center;" rowspan="'.$s.'"><b><a class="btn btn-small btn-primary" style="width:15px;height:10px;" href="'.$markslink.'">'.$prec->code.'</a>/<br />'.$prec->weightage.'</b></td>';
					else
						echo '<td style="vertical-align:middle;text-align:center;" rowspan="'.$s.'"><b>'.$prec->code.'</a>/<br />'.$prec->weightage.'</b></td>';
				}
				if($pobj->isparent=="1" ){
					if($gr=="1" ){ //calculate grade
						echo '<td style="vertical-align:middle;text-align:center;" rowspan="'.$s.'"><b>'.$prec->code.'/<br />'.'Grade'.'</b></td>';
					}
				}
				$pobj->flag=1;
				$pobj->status=1;
				array_push($tq,$pobj);
			}else{
				
				if($pobj->isparent=="1"){
					if($gr=="1") {  //Calculate grade
						echo '<td style="vertical-align:middle;text-align:center;" colspan="'.($count+1).'"><b>'.$prec->title.'</b>';
					}else echo '<td style="vertical-align:middle;text-align:center;" colspan="'.($count).'"><b>'.$prec->title.'</b>';
				}else
					echo '<td style="vertical-align:middle;text-align:center;" colspan="'.$count.'"><b>'.$prec->title.'</b>';


				//Merge cols
				$cirecs = $model->getGradeBookChildEntries($pobj->id); //To process immediate children

				//To allow editing in the cells
				if($eon){
					$tcirecs = $model->getTGradeBookChildEntries($prec->tgradebookid); //To process immediate children
					if(count($tcirecs)=="0"){
						if($prec->required=="1"){
							//Only Add
							echo '<a href="'.$activityaddlink.'"><img src="'.$iconsDir.'/assign.png"></a>';
						}else{
							//ALL-ADD-EDIT-DELETE
							echo '<br /><a href="'.$activityaddlink.'"><img src="'.$iconsDir.'/assign.png"></a>';
							echo '<b><a href="'.$activityeditlink.'">'.$prec->code.'/'.$prec->weightage.'</b>';
							echo '&nbsp;<a href="'.$activitydeletelink.'" onclick="return confirm(\'Are you sure to delete this item?\');"><img src="'.$iconsDir.'/delete.png"></a>';	
						}
					}
				}	
				echo '</td>';
			
				foreach($cirecs  as $cirec){	
					unset($cobj);
					$cobj = new Ent();
					$cobj->id=$cirec->id;
					$cobj->flag=0;
					$cobj->status=0;
					$cobj->isparent=0;
					$cobj->maxmarks=$cirec->weightage;
					array_push($tq,$cobj);
				}
				//To create composite col
				$pobj->flag=2;  
				$pobj->status=0;  
				array_push($tq,$pobj);
			}
		}else{
			if($pobj->status=="0"){
				$x=$N-$i;
				if($pobj->isparent=="1"){
					echo '<td style="vertical-align:middle;text-align:center;background-color:;" rowspan="'.$x.'"><b>'.$prec->code.'/<br />'.$prec->weightage.'</b></td>';
					if($gr=="1") echo '<td style="vertical-align:middle;text-align:center;background-color:;" rowspan="'.$x.'"><b>'.$prec->code.'/<br />Grade</b></td>';
				}
				else
					echo '<td style="vertical-align:middle;text-align:center;background-color:;" rowspan="'.$x.'"><b>'.$prec->code.'/<br />'.$prec->weightage.'</b></td>';
				$pobj->status=1;
			}
			array_push($tq,$pobj);
		}
	}
	//For Total and Grade
	if($i==0){
		echo '<td style="vertical-align:middle;text-align:center;" rowspan="'.$N.'"><b>TOTAL/<br />'.$t.'</b></td>';
		if($gr=="1") echo '<td style="vertical-align:middle;text-align:center;" rowspan="'.$N.'"><b>Grade</b></td>';
	}
	echo '</tr>';
	$q = $tq;
}


//Table Body
$i=1;
foreach($students as $student){
	echo "<tr>";
	echo '<td style="vertical-align:middle;text-align:center;">'.$i++.'</td>';
	echo '<td style="vertical-align:middle;text-align:left;">'.$student->firstname.' '.$student->middlename.' '.$student->lastname.' '.$student->initial.'</td>';
	$tot = 0;
	$ttot = 0;
	foreach($tq as  $rec){
	    if($rec->flag!=0){
		if($rec->subtotalfield=="1"){
			//find subtotal
			$model->getGradeBookEntry($rec->id,$gbrec);
			$ssrecs = $model->getSubTotalEntries($gbrec->tgradebookid);
			$subsum=0;
			$tsum=0;
			foreach($ssrecs as $ssrec){
				$r = $model->getGradeBookEntryIdTGBID($subjectid,$termid,$ssrec->sgbid,$cgbrec);
				if($r){
					$ma = $model->getMarks($student->id,$cgbrec->id,$cgbrec->weightage);
					if($ma=="-1") $ma=0;
					$subsum+=$ma;
					$tsum+=$cgbrec->weightage;
				}
				
			}
			$marks=($subsum/$tsum)*$gbrec->weightage;
		}else{
			$marks = $model->getMarks($student->id,$rec->id,$rec->maxmarks);
		}
		if($marks=="-1") $marks="-";
		else $marks=round($marks,1);
		if($rec->flag==2 || $rec->isparent=="1"){
			if($rec->isparent=="1"){		
				echo "<td align=\"center\" style=\"background-color:;\"><b>".ceil($marks)."</b></td>";		
				if($rec->subtotalfield!="1"){
					$tot = $tot + ceil($marks);
					$ttot = $ttot + $rec->maxmarks;
				}
				if($gr=="1") {
					$r1 = $model->getSubjectGradeMaxMark($subjectid,$gmax);
					$r=$model->getSubjectGradeLetter($subjectid,ceil(($marks/$rec->maxmarks)*$gmax->max),$grec);
					if($r=="true" && $r1=="true")
						echo "<td align=\"center\" style=\"background-color:;\"><b>".$grec->letter."</b></td>";		
					else
						echo "<td align=\"center\" style=\"background-color:;\"><b>-</b></td>";		
				}
			}else{
				echo "<td align=\"center\" style=\"background-color:;\"><b>".ceil($marks)."</b></td>";		
			}
		}
		else 
			echo "<td align=\"center\">".ceil($marks)."</td>"; //getMarks($rec->id,$sid);		
	    }
	}
	echo "<td align=\"center\">".ceil($tot)."</td>";
	if($gr=="1"){
		$r1 = $model->getSubjectGradeMaxMark($subjectid,$gmax);
		$r=$model->getSubjectGradeLetter($subjectid,ceil(($tot/$ttot)*$gmax->max),$grec);
		if($r=="true" && $r1=="true"){
			echo "<td align=\"center\">".$grec->letter."</td>";
		}else{
			echo "<td align=\"center\">-</td>";
		}
	}
	echo "</tr>";
}//END Student



echo '</table>';		
?>

