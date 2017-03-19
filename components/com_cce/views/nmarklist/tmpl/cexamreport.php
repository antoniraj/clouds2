<style>
table.subjects{
	border-collapse:collapse;
	background:#FFF;
}
table.subjects tr td{
	padding:4px;border:1px solid #919191;
	font-size:12px;
}
table.subjects thead tr th{
	background:#E8E8E8;
	padding:5px;
	border:1px solid #919191;
	font-size:14px;
	font-weight:bold;
}
</style>
<?php
    defined('_JEXEC') OR DIE('Access denied..');
    
    $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	$Itemid = JRequest::getVar('Itemid');
	$examid=JRequest::getVar('examid');
	$courseid=JRequest::getVar('courseid');
	$title=JRequest::getVar('title');
	$print=JRequest::getVar('print');
	$model1= & $this->getModel('managesubjects');
	$model3= & $this->getModel('nmarks');
	$status = $model1->getMSubjectsByCourse($courseid,$subjects);
	$students = $model1->getStudents($courseid);
	
?>
<?php
        $isModal = JRequest::getVar( 'print' ) == 1; // 'print=1' will only be present in the url of the modal window, not in the presentation of the page
        if( $isModal) {
                $href = '"#" onclick="window.print(); return false;"';
        } else {
                $href = 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no';
                $href = "window.open(this.href,'win2','".$href."'); return false;";
                $href = '"index.php?option=com_cce&view=nmarklist&controller=ngradebookmarks&layout=cexamreport&title='.$title.'&courseid='.$courseid.'&Itemid='.$Itemid.'&examid='.$examid.'&tmpl=component&print=1" '.$href;
        }
    if($print!=1)
{    
?>
<div align="right">
<a href=<?php echo $href; ?> ><span title="Print" class="icon32 icon-green icon-print"></span></a>
</div>
<?php
}
	$model2=& $this->getModel('tngradebook');
	$status=$model2->getTNGradeBookEntry($examid,$examrec);
	$status=$this->model->getSchoolInfo($rec);

?>
<center>

                <h1 style="font-size:26px;"><strong><?php echo $rec->schoolname; ?></strong></h1><br>
                <h3><?php echo $rec->schooladdress; ?></h3>
</center>
<br />
<br />
<table class="exam" width="100%">
<tr>
<td width="50%">
<table class="examreport">
<tr><td>Class</td><td>:  <?php echo $this->crec->coursename.'-'.$this->crec->sectionname; ?></td></tr>
</table>
</td>
<td width="50%" align="right">
<table class="examreport">
<tr><td>Examination</td><td>:  <?php echo $title; ?></td></tr>
</table>

</td>
</tr>
</table>


<hr /> <br />

		<table class="subjects" width="100%">
		<thead>
        <tr>
                <th width="3%">S#</th>
                <th width="7%">Reg.No</th>
                <th width="30%">Student Name</th>
	<?php
	$gtot=0;
	foreach($subjects as $subject){
        	echo '<th width="7%">'.$subject->subjectcode.'/<br />'.round($subject->marks,0).'</th>';
		$gtot = $gtot + $subject->marks;
	}
	echo '<th width="5%">Total/<br />'.$gtot.'</th>';
	echo '<th width="5%">Per<br />(%)</th>';
	echo '<th width="5%">Grade</th>';
	if($rec->showresult=="1")
		echo '<th width="5%">RES</th>';
	echo '</tr></thead>';
	$i=1;
	foreach($students as $student){
		$tot=0;
		echo '<tr>';
		echo '<td>'.$i.'</td>';
		echo '<td>'.$student->registerno.'</td>';	
		echo '<td>'.$student->firstname.'</td>';	
		$result='P';
		foreach($subjects as $subject)
		{

		        $this->model->getNMarks($student->id,$examid,$subject->id,$courseid,$mrec);
			
			//echo '<td><a href="'.$mlink.'">'.$student->firstname.'</a></td>';
			echo '<td align="center">'.$mrec->marks.'</td>';	
			$tot = $tot + $mrec->marks;
			if($mrec->marks<$subject->passmark) $result='F';
		}
		$i++;
		$percent=round($tot/$gtot*100,2);
		$r = $model3->getNormalGradeLetter(round($tot/$gtot*100,0),$grecc);
		echo '<td>'.$tot.'</td>';
		echo '<td>'.$percent.'</td>';
		echo '<td>'.$grecc->letter.'</td>';
		if($rec->showresult=="1")
			echo '<td>'.$result.'</td>';
		echo '</tr>';
	}
	?>
	
</table>
<br />
<br />
<br />
<div style="float: left;"><i>Class Teacher</i></div>
<div style="float: right;"><i>Principal</i></div>

