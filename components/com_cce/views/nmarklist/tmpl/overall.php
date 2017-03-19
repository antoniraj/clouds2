
<style type="text/css">
	.TFtable{
		width:100%; 
		border-collapse:collapse; 
		background:#FFF;
	}
	.TFtable td{ 
		padding:7px; border:#4e95f4 1px solid;
	}
	.TFtable th{ 
		background:#E8E8E8;
		padding:4px;
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
	$studentid= JRequest::getVar('studentid');
	$examid=JRequest::getVar('examid');
	$courseid=JRequest::getVar('courseid');
	$model1= & $this->getModel('managesubjects');
	$print=JRequest::getVar('print');
	$status = $model1->getMSubjectsByCourse($courseid,$subjects);
	$m7= & $this->getModel('tngradebook');
	$m8= & $this->getModel('nmarks');
	$r = $m8->getStudent($studentid,$ssrec);
        $exams=$m7->getTNGradeBook();
	$m8->getSchoolInfo($schoolrec);
?>
<?php
        $isModal = JRequest::getVar( 'print' ) == 1; // 'print=1' will only be present in the url of the modal window, not in the presentation of the page
        if( $isModal) {
                $href = '"#" onclick="window.print(); return false;"';
        } else {
                $href = 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no';
                $href = "window.open(this.href,'win2','".$href."'); return false;";
                $href = '"index.php?option=com_cce&view=nmarklist&controller=ngradebookmarks&layout=overall&courseid='.$courseid.'&Itemid='.$Itemid.'&studentid='.$studentid.'&tmpl=component&print=1" '.$href;
        }
 if($print!=1)
 {
?>
<div align="right">
<a href=<?php echo $href; ?> ><span title="Print" class="icon32 icon-green icon-print"></span></a>
</div>
<?php
}
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
<td width="45%">
<table class="examreport">
<tr><td><b>Student Name</b></td><td>:  <?php echo $ssrec->firstname; ?></td></tr>
<tr><td><b>Register No</b></td><td>: <?php echo $ssrec->registerno; ?></td></tr>
</table>
</td>
<td>
<h2><strong>Grade Book</strong></h2>
</td>
<td width="30%" align="right">
<table class="examreport">
<tr><td><b>Class</b></td><td>: <?php echo $this->crec->coursename.' ['.$this->crec->sectionname; ?>]</td></tr>
</table>

</td>
</tr>
</table>
<div style="border: 1px black solid;"></div>
<Br>
<table class="TFtable">
        <tr>
                <th width="2%">#</th>
                <th width="5%">CODE</th>
                <th width="30">SUBJECT TITLE</th>
        <?php
		foreach($exams as $exam){
			echo '<th width="10%">'.$exam->code.'/<br />'.$exam->marks.'</th>';	

		}
	?>
                <th  width="10">%</th>
	<?php	if($schoolrec->showgrades=='1') ?>
                <th   width="10">Grade</th>
	</tr>
	<?php
		foreach($exams as $exam){
			$a[$exam->id]=0;
			$b[$exam->id] = 'P';
		}
		$ptot=0;
		$i=1;
		foreach($subjects as $subject)
		{
			echo '<tr>';
			echo '<td>'.$i.'</td>';
			echo '<td>'.$subject->subjectcode.'</td>';	
			echo '<td>'.$subject->subjecttitle.'</a></td>';
			$tot=0;
			$gtot=0;
			
			foreach($exams as $exam){
		       		$m8->getNMarks($studentid,$exam->id,$subject->id,$courseid,$mmrec);
				$ma = $mmrec->marks/$subject->marks*$exam->marks;	
				$a[$exam->id] += $ma;
				if(($b[$exam->id]=='P') &&  ($mmrec->marks < $subject->passmark)) 
					$b[$exam->id] = 'F';
				echo '<td align="center">'.round($ma,0).'</td>';	
//				echo '<td align="center">'.round($subject->marks,0).'</td>';
				$tot = $tot + $mmrec->marks;
				$gtot = $gtot + $exam->marks;
			}
			$percent=round($tot/$gtot*100,1);
			$ptot = $ptot+$percent;
			$r = $m8->getNormalGradeLetter($percent,$grd);
			echo '<td align="center">'.$percent.'</td>';
			if($schoolrec->showgrades=='1')
				echo '<td align="center">'.$grd->letter.'</td>';
			echo '</tr>';
			$i++;
		}
		$cnt = count($subjects);
		echo '<tr><td align="right" colspan="3"><b>Total</b></td>';
		foreach($exams as $exam)
			echo '<td><center>'.$a[$exam->id].'</center></td>';
		echo '<td><center>'.$ptot.'</center></td>';
		echo '<td><center>---</center></td>';
		echo '</tr>';
		echo '<tr><td align="right" colspan="3"><b>Average</b></td>';
		foreach($exams as $exam)
			echo '<td><center>'.round($a[$exam->id]/$cnt,1).'</center></td>';
		echo '<td><center>'.round($ptot/$cnt,1).'</center></td>';
		echo '<td><center>---</center></td>';
		echo '</tr>';
		echo '<tr><td align="right" colspan="3"><b>Grade</b></td>';
		foreach($exams as $exam){
			$p=round(($a[$exam->id]/($cnt*$exam->marks)*100),1);
			$r = $m8->getNormalGradeLetter($p,$grd);
			echo '<td><center>'.$grd->letter.'</center></td>';
		}
		$r = $m8->getNormalGradeLetter(($ptot/$cnt),$grd);
		echo '<td><center>'.$grd->letter.'</center></td>';
		echo '<td><center>---</center></td>';
		echo '</tr>';
		if($schoolrec->showresult==1){
		echo '<tr><td align="right" colspan="3"><b>Result</b></td>';
			foreach($exams as $exam)
				echo '<td><center>'.$b[$exam->id].'</center></td>';
			echo '<td><center>---</center></td>';
			echo '<td><center>---</center></td>';
			echo '</tr>';
		}
	?>


</table>
<br />
<br />
<br />
<br />
<br />
<div style="float: left; font-size:14px;"><i>Class Teacher</i></div>
<div style="font-size:14px;"><center><i>Principal</i></center></div>
<div style="float: right; font-size:14px;"><i>Parent</i></div>
<hr />

