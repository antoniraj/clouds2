<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');
?>
<h1><center><?php echo $this->coursename; ?></center></h1>
<div>
        <div style="float:left;">
           <img src="<?php echo $iconsDir.'/courses.png'; ?>" alt="" style="width: 64px; height: 64px;" />
        </div>
        <div>
                <div>&nbsp;</div>
                <h2>Course Profile</h2>
        </div>
</div>

<hr /> <br />
<h2>Class Teacher(s)</h2>
<table border="0" cellspacing="5" cellpadding="5">
<tr><td>Staff Names:</td><td>
<?php 	
	foreach($this->classteachers as $cts)
	{
	 	$s=$this->model->getStaff($cts->staffid,$staffrec);
		echo "$staffrec->firstname&nbsp;$staffrec->middlename&nbsp;$staffrec->lastname";
		echo '<br/>';
	}
?>
</td>
</tr>
</table>
<br />
<h2><center>PART 1 - ACADEMIC PERFORMANCE: SCHOLASTIC AREAS</center></h2>
<h3>Subjects & Teacher(s):</h3>
<table border="0" cellspacing="5" cellpadding="5">
<tr><th class="list-title">Code</th><th class="list-title">Subject</th><th class="list-title">Subject Teacher</th><th class="list-title" colspan="3">Marks</th</tr>
<?php
	foreach($this->subjects as $subject)
	{
		echo '<tr>';
		echo '<td>';
		echo $subject->subjectcode;
		echo '</td>';
		echo '<td>';
		echo $subject->subjectname;
		echo '</td>';
		echo '<td>';
		$this->model->getSubjectTeachers($this->courseid,$subject->id,$staff);
		foreach($staff as $s)
		{
			echo $s->firstname;
			echo '<br />';
		}
		echo '</td>';
		$terms=$this->model -> getCurrentTerms();
		foreach($terms as $term)
		{	
			echo '<td>';
			$ccelink = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=gradebook&view=gradebook&task=display&termid='.$term->id.'&subjectid='.$subject->id.'&courseid='.$this->courseid);
			echo "<center>[<a href=\"$ccelink\">".$term->term."</a>]</center>";
			echo '</td>';
		}

		echo '</tr>';
	}
?>
</table>
<br />
<h2><center>PART 2 - CO-SCHOLASTIC AREAS</center></h2>
<table border="0" cellspacing="5" cellpadding="5">
<tr><th class="list-title">Area</th><th class="list-title" colspan="3">Enter Grades</th></tr>
<tr><td>Life Skills</td><td>[Term1]</td><td>[Term2]</td><td>[Term3]</td></tr>
<tr><td>Attitudes and Values</td><td>[Term1]</td><td>[Term2]</td><td>[Term3]</td></tr>
<tr><td>Wellness and Yoga/Holistic Exercise</td><td>[Term1]</td><td>[Term2]</td><td>[Term3]</td></tr>
<tr><td>Co-Curricular Activities</td><td>[Term1]</td><td>[Term2]</td><td>[Term3]</td></tr>
</table>


<br />
<h3>Students:</h3>
<table border="0" cellspacing="5" cellpadding="5">
<tr><th class="list-title">Rno</th><th class="list-title">Name</th></tr>
<?php
	foreach($this->students as $student)
	{
		echo '<tr>';
		echo '<td>';
		echo $student->registerno;
		echo '</td>';
		echo '<td>';
		echo $student->firstname;
		echo '</td>';
		echo '</tr>';
	}
?>
</table>
