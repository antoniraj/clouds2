<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	$Itemid = JRequest::getVar('Itemid');
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');
?>
<div>
        <div style="float:left;">
           <img src="<?php echo $iconsDir.'/addsubject.png'; ?>" alt="" style="width: 64px; height: 64px;" />
        </div>
        <div>
                <div>&nbsp;</div>
                <h1>Add/Edit Subject</h1>
        </div>
</div>
<hr /> <br />


<form action="index.php" method="POST" name="addform" id="addform" onSubmit="return stest()">
	<table>
		<tr style="border:none;" >
			<td style="border:none;" >Subject Name</td>
			<td style="border:none;" >
				<input type="text" id="subjectname" name="subjectname" size="32" maxlength="50" value="<?php echo $this->rec->subjectname; ?>" />
			</td>
		</tr>
		<tr style="border:none;" >
			<td style="border:none;" >Subject Code</td>
			<td style="border:none;" >
			<input type="text" id="subjectcode" name="subjectcode" size="32" maxlength="15" value="<?php echo $this->rec->subjectcode;  ?>" />
			</td>
		</tr>
		<tr style="border:none;" >
			<td style="border:none;" >Hours/Week</td>
			<td style="border:none;" >
			<input type="text" id="hoursperweek" name="hoursperweek" size="32" maxlength="10" value="<?php echo $this->rec->hoursperweek;  ?>" />
			</td>
		</tr>
		<tr style="border:none;" ><td style="border:none;" ><input type="submit" class="button_save" value="Save" id="submit" name="submit" /></td></tr>
	</table>
	<input type="hidden" name="option" value="<?php echo JRequest::getVar('option'); ?>" />
	<input type="hidden" id="id" name="id" value="<?php echo $this->rec->id; ?>" />
	<input type="hidden" id="Itemid" name="Itemid" value="<?php echo $Itemid; ?>" />
	<input type="hidden" id="courseid" name="courseid" value="<?php echo $this->rec->cid; ?>" />
	<input type="hidden" id="controller" name="controller" value="subjects" />
	<input type="hidden" id="view" name="view" value="addsubject" />
	<input type="hidden" name="task" id="task" value="save" />
</form>
