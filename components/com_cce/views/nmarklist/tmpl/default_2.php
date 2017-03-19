<?php
        defined('_JEXEC') OR DIE('Access denied..');

	
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	$Itemid = JRequest::getVar('Itemid');
?>
<!--
<div>
        <div style="float:left;">
           <img src="<?php echo $iconsDir.'/64x64/gradebook.png'; ?>" alt="" style="width: 64px; height: 64px;" />
        </div>
        <div>
                <div>&nbsp;</div>
        </div>
</div>
-->
<!-- BACK Button -->
<!--
<form action="index.php" method="post" name="backform">
	<div align="right"><input type="submit" name="Back" value="Back" /></div>
	<input type="hidden" name="referer" value="<?php echo base64_encode(@$_SERVER['HTTP_REFERER']); ?>" /> 
	<input type="hidden" name="option" value="com_cce" />
	<input type="hidden" name="controller" value="gradebookmarks" />
	<input type="hidden" name="task" value="back" />
</form>
-->

<?php
	//$status=$this->model->getNGradeBook($this->examid,$examrec);
	echo '<center><h1>'.$this->crec->coursename.'-'.$this->crec->sectionname.'['.$this->trec->term.']</h1></center>';
	echo '<center><h2>['.$this->srec->subjectcode.']'.$this->srec->subjecttitle.'</h2></center>';
	echo '<center><h3>'.$rec->title.'['.$exam->code.']/'.$examrec->title.'</h3></center>';
?>
<hr /> <br />
<table class="school" border="1" cellspacing="2" cellpadding="3">
        <tr>
                <th class="list-title" width="7%">SNO</th>
                <th class="list-title" width="10%">RNO</th>
                <th class="list-title" width="25%">NAME</th>
                <th class="list-title" width="8%">MARK/<?php echo $this->max; ?></th>
                <th class="list-title" width="10%">DESCRIPTION</th>
                <th class="list-title" width="10%">COMMENTS</th>
	</tr>
	<form method="post" action="index.php" name="adminform">
	<?php
		$i=1;
		foreach($this->students as $student)
		{
		        $this->model->getNMarks($student->id,$this->examid,$mrec);
			$mlink=JRoute::_('index.php?option=com_cce&controller=ngradebookmarks&task=addmarks&view=marklist&marksid='.$mrec->id.'&studentid='.$student->id.'&subjectid='.$this->subjectid.'&examid='.$this->examid.'&max='.$this->max.'&firstname='.$student->firstname.'&atitle='.$examrec->title.'&rno='.$student->registerno.'&courseid='.$this->courseid);
			echo '<tr>';
			echo '<td>'.$i.'</td>';
			echo '<td>'.$student->registerno.'</td>';	
			echo '<td><a href="'.$mlink.'">'.$student->firstname.'</a></td>';
			echo '<td><input type="text" name="marks[]" size="5px" maxlength="3" value="'.$mrec->marks.'"></td>';	
			echo '<td><input type="text" name="desc[]" size="20px" maxlength="250" value="'.$mrec->description.'"></td>';
			echo '<td><input type="text" name="comments[]" maxlength="100" size="20px"  value="'.$mrec->comments.'"></td>';
			echo '</tr>';
			echo '<input type="hidden" name="sid[]" value="'.$student->id.'">';
			echo '<input type="hidden" name="mid[]" value="'.$mrec->id.'">';
			echo '<input type="hidden" name="rno[]" value="'.$studen->registerno.'">';
			$i++;
		}
	?>
	<tr><td colspan="7" align="right"><input type="submit" class="button_save" value="Save"></td></tr>
	<input type="hidden" name="option" value="<?php echo JRequest::getVar('option'); ?>" />
	<input type="hidden" name="task" value="savemarkss" />
	<input type="hidden" id="view" name="view" value="nmarklist" />
	<input type="hidden" id="controller" name="controller" value="ngradebookmarks" />
	<input type="hidden" id="id" name="id" value="<?php echo $mrec->id; ?>" />
	<input type="hidden" id="courseid" name="courseid" value="<?php echo $this->courseid; ?>" />
	<input type="hidden" id="subjectid" name="subjectid" value="<?php echo $this->subjectid; ?>" />
	<input type="hidden" id="studentid" name="studentid" value="<?php echo $student->id; ?>" />
	<input type="hidden" id="examid" name="examid" value="<?php echo $this->examid; ?>" />
	<input type="hidden" id="max" name="max" value="<?php echo $this->max; ?>" />
	<input type="hidden" id="Itemid" name="Itemid" value="<?php echo $Itemid; ?>" />
	</form>
</table>
