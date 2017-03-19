<?php
    	defined('_JEXEC') OR DIE('Access denied..');
    	$app = JFactory::getApplication();
	JHTML::script('validate.js', 'components/com_cce/js/');
	$Itemid = JRequest::getVar('Itemid');
	$model=& $this->getModel('exams');

	$classid= 7; //11; //7
	$subjectid= 4;//1; //4
	$termid= 2; //3; //2
	$maxHeadRows= $model->findHeadHeight('7','4','2'); //classid,$subjectid,$termid

	$r = $model->getMarks('2068','20','10');  //studentid,gbid,max
//	echo $r;

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
};


//Print Heads
//Algorithm
// 1. Find Max Rows in head
// 2. Store all parents to queue
// 3. For each row 
//    3.1 

$gr=0; //To enable grade letter
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
	$t = $t + $prec->weightage;
	array_push($q,$obj);
}



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
			if($count==1){
				//merge rows
				$s=$N-$i;
				echo '<td style="vertical-align:middle;text-align:center;" rowspan="'.$s.'"><b>'.$prec->code.'/<br />'.$prec->weightage.'</b></td>';
				if($pobj->isparent=="1"){
					if($gr=="1"){ //calculate grade
						echo '<td style="vertical-align:middle;text-align:center;" rowspan="'.$s.'"><b>'.$prec->code.'/<br />'.'Grade'.'</b></td>';
					}
				}
				$pobj->flag=1;
				$pobj->status=1;
				array_push($tq,$pobj);
			}else{
				//Merge cols
				$cirecs = $model->getGradeBookChildEntries($pobj->id); //To process immediate children
				if($pobj->isparent=="1"){
					if($gr=="1") {  //Calculate grade
						echo '<td style="vertical-align:middle;text-align:center;" colspan="'.($count+1).'"><b>'.$prec->title.'</b></td>';
					}else echo '<td style="vertical-align:middle;text-align:center;" colspan="'.($count).'"><b>'.$prec->title.'</b></td>';
				}else
					echo '<td style="vertical-align:middle;text-align:center;" colspan="'.$count.'"><b>'.$prec->title.'</b></td>';
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

for($i=1; $i<10; $i++){
	echo "<tr>";
	echo '<td style="vertical-align:middle;text-align:center;">SNO</td>';
	echo '<td style="vertical-align:middle;text-align:center;">STUDENT NAME</td>';
	$tot = 0;
	foreach($tq as  $rec){
		if($rec->flag!=0){
		$marks = $model->getMarks('2068',$rec->id,$rec->maxmarks);
		if($marks=="-1") $marks="-";
		else $marks=round($marks,1);
		if($rec->flag==2 || $rec->isparent=="1"){
			if($rec->isparent=="1"){		
				echo "<td align=\"center\" style=\"background-color:;\"><b>".$marks."</b></td>";		
				$tot = $tot + $marks;
				if($gr=="1") echo "<td align=\"center\" style=\"background-color:;\"><b>".'G'.$marks."</b></td>";		
			}else{
				echo "<td align=\"center\" style=\"background-color:;\"><b>".$marks."</b></td>";		
			}
		}
		else 
			echo "<td align=\"center\">".$marks."</td>"; //getMarks($rec->id,$sid);		
	}
	}
	echo "<td align=\"center\">".$tot."</td>";
	if($gr=="1") echo "<td align=\"center\">G.X</td>";
	echo "</tr>";
}

echo '</table>';		
?>

