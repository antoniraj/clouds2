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
           <img src="<?php echo $iconsDir.'/addgradebookdetailentry.png'; ?>" alt="" style="width: 64px; height: 64px;" />
        </div>
        <div>
                <div>&nbsp;</div>
                <h1>Add Grade-Book Detail Entry</h1>
        </div>
</div>
<hr /> <br />


<form action="index.php" method="POST" name="addform" id="addform" onSubmit="return stest()">
	<table>
		<tr>
			<td>Title</td>
			<td>
				<input type="text" id="title" name="title" size="32" maxlength="20" value="<?php echo $this->rec->title; ?>" />
			</td>
		</tr>
		<tr>
			<td>ShortCode</td>
			<td>
			<input type="text" id="code" name="code" size="32" maxlength="15" value="<?php echo $this->rec->code;  ?>" />
			</td>
		</tr>
		<tr>
			<td>Marks</td>
			<td>
				<input type="text" id="marks" name="marks" size="32" maxlength="20" value="<?php echo $this->rec->marks; ?>" />
			</td>
		</tr>
		<tr>
                        <td >Due Date(DD-MM-YYYY)</td>
                        <td>
                        <?php
                                $a=explode('-',$this->rec->duedate);
                                $iduedate="$a[2]-$a[1]-$a[0]";
                                 echo JHTML::calendar($iduedate,'duedate','duedate','%d-%m-%Y');
                        ?>
                        </td>
                </tr>

		<tr>
			<td>Description</td>
			<td>
				<input type="text" id="description" name="description" size="32" maxlength="20" value="<?php echo $this->rec->description; ?>" />
			</td>
		</tr>
		<tr><td><input type="submit" class="button_save" value="Save" id="submit" name="submit" /></td></tr>
	</table>
	<input type="hidden" name="option" value="<?php echo JRequest::getVar('option'); ?>" />
	<input type="hidden" id="id" name="id" value="<?php echo $this->rec->id; ?>" />
	<input type="hidden" id="catid" name="catid" value="<?php echo $this->catid; ?>" />
	<input type="hidden" id="controller" name="controller" value="gradebook" />
	<input type="hidden" id="view" name="view" value="addgradebookdetailentry" />
	<input type="hidden" name="task" id="task" value="save" />
	<input type="hidden" name="subjectid" id="subjectid" value="<?php echo $this->subjectid; ?>" />
	<input type="hidden" name="courseid" id="courseid" value="<?php echo $this->courseid; ?>" />
	<input type="hidden" name="termid" id="termid" value="<?php echo $this->termid; ?>" />
	<input type="hidden" name="Itemid" id="Itemid" value="<?php echo $Itemid; ?>" />
</form>
