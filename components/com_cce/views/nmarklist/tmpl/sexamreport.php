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

	
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	$Itemid = JRequest::getVar('Itemid');
	$studentid= JRequest::getVar('studentid');
	$examid=JRequest::getVar('examid');
//	$staff=JRequest::getVar('staff');
	$courseid=JRequest::getVar('courseid');
$print=JRequest::getVar('print');
	$max=JRequest::getVar('max');
	$model1= & $this->getModel('managesubjects');
	$model3= & $this->getModel('nmarks');
	$status = $model1->getMSubjectsByCourse($courseid,$subjects);
	$r = $model1->getStudent($studentid,$ssrec);
?>
<?php
        $isModal = JRequest::getVar( 'print' ) == 1; // 'print=1' will only be present in the url of the modal window, not in the presentation of the page
        if( $isModal) {
                $href = '"#" onclick="window.print(); return false;"';
        } else {
                $href = 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no';
                $href = "window.open(this.href,'win2','".$href."'); return false;";
                $href = '"index.php?option=com_cce&view=nmarklist&controller=ngradebookmarks&layout=sexamreport&courseid='.$courseid.'&max='.$max.'&Itemid='.$Itemid.'&examid='.$examid.'&studentid='.$studentid.'&tmpl=component&print=1" '.$href;
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
<td width="46%">
<table class="examreport">
<tr><td>Student Name</td><td>:  <?php echo $ssrec->firstname; ?></td></tr>
<tr><td>Register No</td><td>: <?php echo $ssrec->registerno; ?></td></tr>
</table>
</td>
<td>
<h2><strong><?php echo $examrec->title; ?></strong></h2>
</td>
<td width="30%" align="right">
<table class="examreport">
<tr><td>Class</td><td>: <?php echo $this->crec->coursename.' ['.$this->crec->sectionname; ?>]</td></tr>
</table>

</td>
</tr>
</table>
<div style="border: 1px black solid;"></div>
<Br>

<table class="TFtable">
        <tr>
                <th width="5%">SNO</th>
                <th width="15%">CODE</th>
                <th width="40">SUBJECT TITLE</th>
                <th width="10%">MARK</th>
                <th width="10%">MAX.MARKS</th>
<?php
if($rec->showgrades=='1')
	echo '<th width="10%">GRADE</th>';
if($rec->showresult=='1')
        echo '<th width="10%">RESULT</th>';
?>
	</tr>
	<form method="post" action="index.php" name="adminform">
	<?php
		$i=1;
		$tot=0;
		$gtot=0;
		foreach($subjects as $subject)
		{

		        $this->model->getNMarks($studentid,$examid,$subject->id,$courseid,$mrec);
			
			//$mlink=JRoute::_('index.php?option=com_cce&controller=ngradebookmarks&task=addnmarks&view=nmarklist&marksid='.$mrec->id.'&studentid='.$student->id.'&subjectid='.$subjectid.'&examid='.$examid.'&max='.$max.'&firstname='.$student->firstname.'&atitle='.$examrec->title.'&rno='.$student->registerno.'&courseid='.$courseid);
			echo '<tr>';
			echo '<td>'.$i.'</td>';
			echo '<td>'.$subject->subjectcode.'</td>';	
			echo '<td>'.$subject->subjecttitle.'</a></td>';
			//echo '<td><a href="'.$mlink.'">'.$student->firstname.'</a></td>';
			echo '<td align="center">'.round($mrec->marks,0).'</td>';	
			//echo '<td><input type="text" name="marks[]" size="5px" maxlength="3" value="'.$mrec->marks.'"></td>';	
			echo '<td align="center">'.round($subject->marks,0).'</td>';
			//echo '<td><input type="text" name="comments[]" maxlength="100" size="20px"  value="'.$mrec->comments.'"></td>';
			$model3->getNormalGradeLetter($mrec->marks/$subject->marks*100,$gr);
		if($rec->showgrades=='1')
			echo '<td align="center">'.$gr->letter.'</td>';
			if($mrec->marks < $subject->passmark) $result='F';
			else $result='P';
		if($rec->showresult=='1')
			echo '<td align="center">'.$result.'</td>';
			echo '</tr>';
			$tot = $tot + $mrec->marks;
			$gtot = $gtot + $subject->marks;
			echo '<input type="hidden" name="sid[]" value="'.$studentid.'">';
			echo '<input type="hidden" name="mid[]" value="'.$mrec->id.'">';
			echo '<input type="hidden" name="rno[]" value="'.$studen->registerno.'">';
			$i++;
		}
		$percent=round($tot/$gtot*100,1);
		$r = $model3->getNormalGradeLetter(round($tot/$gtot*100,0),$grecc);
	?>
</table>
<br /><b>
<table width="100%">	
	<tr style="border:none; height:25px; font-size:15px;"><td style="border:none;" width="20%" align="left">Total Marks:</td><td style="border:none; width="10%"" align="left"><?php echo $tot.'/'.$gtot; ?></td></tr> 
	<tr style="border:none; height:25px; font-size:15px;" align="left"><td style="border:none;" align="left">Percentage(%):</td><td style="border:none;" align="left"><?php echo $percent; ?></td></tr> 
	<tr style="border:none; height:25px; font-size:15px;" align="left"><td style="border:none;" align="left">Grade:</td><td style="border:none;" align="left"><?php echo $grecc->letter; ?></td></tr> 
<!--	<tr><td colspan="7" align="right"><input type="submit" class="button_save" value="Save"></td></tr> 
	<input type="hidden" name="option" value="<?php echo JRequest::getVar('option'); ?>" />
	<input type="hidden" name="task" value="savemarkss" />
	<input type="hidden" id="view" name="view" value="nmarklist" />
	<input type="hidden" id="controller" name="controller" value="ngradebookmarks" />
	<input type="hidden" id="id" name="id" value="<?php echo $mrec->id; ?>" />
	<input type="hidden" id="courseid" name="courseid" value="<?php echo $courseid; ?>" />
	<input type="hidden" id="subjectid" name="subjectid" value="<?php echo $subjectid; ?>" />
	<input type="hidden" id="studentid" name="studentid" value="<?php echo $student->id; ?>" />
	<input type="hidden" id="examid" name="examid" value="<?php echo $examid; ?>" />
	<input type="hidden" id="max" name="max" value="<?php echo $max; ?>" />
	<input type="hidden" id="Itemid" name="Itemid" value="<?php echo $Itemid; ?>" />
	<input type="hidden" id="title" name="title" value="<?php echo $title; ?>" />
	</form>
-->
</table></b>
<br />
<br />
<br />
<br />
<br />
<div style="float: left; font-size:14px;"><i>Class Teacher</i></div>
<div style="font-size:14px;"><center><i>Principal</i></center></div>
<div style="float: right; font-size:14px;"><i>Parent</i></div>
<hr />
</div>
