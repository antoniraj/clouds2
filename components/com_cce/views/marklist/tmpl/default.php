<?php
        defined('_JEXEC') OR DIE('Access denied..');
	
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	$Itemid = JRequest::getVar('Itemid');
	$profile = JRequest::getVar('profile');
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');

 	$iconsDir1 = JURI::base() . 'components/com_cce/images';
        $model = & $this->getModel();
        $dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
        $modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=grades&Itemid='.$masterItemid);
        $entermarkslink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=courses&view=showcourses&Itemid='.$masterItemid);
        $profilelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=courses&view=showcourseprofile&courseid='.$this->courseid.'&Itemid='.$masterItemid);
        $gradebooklink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=gradebook&view=gradebook&task=display&termid='.$this->termid.'&subjectid='.$this->subjectid.'&courseid='.$this->courseid.'&Itemid='.$masterItemid);
?>

<!-- TOP LINKS....DASHBOARD -->
<table width="100%" cellpadding="10">
        <tr style="border:none;"> <td style="border:none;" align="right">
  <div style="float:left;">
           <img src="<?php echo $iconsDir1.'/'.$this->filename; ?>" alt="" style="width: 64px; height: 64px;" />
        </div>
        <div style="float:left;">
                <h1 class="item-page-title"><?php echo $this->coursename; ?></h1>
                <?php echo '<center><h1 class="item-page-title">['.$this->srec->subjectcode.']'.$this->srec->subjecttitle.'</h1><h3 class="item-page-title">['.$this->trec->term.']['.$this->crec->code.']</h3></center>'; ?>
        </div>
                       <div style="float:right;"> <a href="<?php echo $dashboardlink; ?>"><img src="<?php echo $iconsDir1.'/1dashboard.png'; ?>" alt="Dash Board" style="width: 32px; height: 32px;" /></a><br /> </div>
                        <div style="float:right; width:10px;"> &nbsp;</div>
                        <div style="float:right;">
                        <a href="<?php echo $modulelink; ?>"><img src="<?php echo $iconsDir1.'/1results.png'; ?>" alt="Master" style="width: 32px; height: 32px;" /></a><br />
                        </div>
                        <div style="float:right; width:10px;"> &nbsp;</div>
                        <div style="float:right;">
                        <a href="<?php echo $entermarkslink; ?>"><img src="<?php echo $iconsDir1.'/entermarks.png'; ?>" alt="Enter Marks" style="width: 32px; height: 32px;" /></a><br />
                        </div>
                        <div style="float:right; width:10px;"> &nbsp;</div>
                        <div style="float:right;">
                        <a href="<?php echo $profilelink; ?>"><img src="<?php echo $iconsDir.'/report3.png'; ?>" alt="Profile" style="width: 32px; height: 32px;" /></a><br />
                        </div>
                        <div style="float:right; width:10px;"> &nbsp;</div>
                        <div style="float:right;">
                        <a href="<?php echo $gradebooklink; ?>"><img src="<?php echo $iconsDir1.'/gradebook.png'; ?>" alt="Gradebook" style="width: 32px; height: 32px;" /></a><br />
                        </div>
                </td>
        </tr>
</table>


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


<div class="alert alert-warning" align="left">
<span class="mytitle">
<?php
	$status=$this->model->getGradeBookEntry($this->gid,$grec);
	$this->model->getGradeBookDetailEntry($this->sacdid,$erec);

	echo $grec->title.'['.$grec->code.']/'.$erec->title;
	
?>
</span></span>
</div>
<br>
<table  class="table table-striped table-bordered">
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
				
		        $this->model->getScholasticAMarks($student->id,$this->sacdid,$mrec);
			$mlink=JRoute::_('index.php?option=com_cce&controller=gradebookmarks&task=addmarks&view=marklist&marksid='.$mrec->id.'&studentid='.$student->id.'&subjectid='.$this->subjectid.'&termid='.$this->termid.'&gid='.$this->gid.'&max='.$this->max.'&firstname='.$student->firstname.'&atitle='.$erec->title.'&rno='.$student->registerno.'&courseid='.$this->courseid.'&entryid='.$this->sacdid.'&sacdid='.$this->sacdid.'&profile='.$profile);
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
			echo '<input type="hidden" name="rno[]" value="'.$student->registerno.'">';
			$i++;
		}
	?>
	<tr><td colspan="7" align="right"><input type="submit" class="button_save" value="Save"></td></tr>
	<input type="hidden" name="option" value="<?php echo JRequest::getVar('option'); ?>" />
	<input type="hidden" name="task" value="savemarkss" />
	<input type="hidden" id="view" name="view" value="marklist" />
	<input type="hidden" id="controller" name="controller" value="gradebookmarks" />
	<input type="hidden" id="id" name="id" value="<?php echo $mrec->id; ?>" />
	<input type="hidden" id="courseid" name="courseid" value="<?php echo $this->courseid; ?>" />
	<input type="hidden" id="subjectid" name="subjectid" value="<?php echo $this->subjectid; ?>" />
	<input type="hidden" id="studentid" name="studentid" value="<?php echo $student->id; ?>" />
	<input type="hidden" id="gid" name="gid" value="<?php echo $this->gid; ?>" />
	<input type="hidden" id="sacdid" name="sacdid" value="<?php echo $this->sacdid; ?>" />
	<input type="hidden" id="entryid" name="entryid" value="<?php echo $this->sacdid; ?>" />
	<input type="hidden" id="max" name="max" value="<?php echo $this->max; ?>" />
	<input type="hidden" id="termid" name="termid" value="<?php echo $this->termid; ?>" />
	<input type="hidden" id="Itemid" name="Itemid" value="<?php echo $Itemid; ?>" />
	<input type="hidden" id="profile" name="profile" value="<?php echo $profile; ?>" />
	</form>
</table>
