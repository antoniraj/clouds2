<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
        $templateDir = JURI::base() . 'templates/' . $app->getTemplate();
?>
<div>
        <div style="float:left;">
           <img src="<?php echo JURI::root().'templates/'.$app->getTemplate().'/images/64x64/addterm.png'; ?>" alt="" style="width: 64px; height: 64px;" />
        </div>
        <div>
                <div>&nbsp;</div>
                <h1>Add/Edit Test Marks</h1>
        </div>
</div>
<hr /> <br />
<!-- BACK BUTTON-->
<form action="index.php" method="post" name="backform">
	<div align="right"><input type="submit" name="Back" value="Back" /></div>
	<input type="hidden" name="referer" value="<?php echo base64_encode(@$_SERVER['HTTP_REFERER']); ?>" /> 
	<input type="hidden" name="option" value="com_cce" />
	<input type="hidden" name="controller" value="gradebookmarks" />
	<input type="hidden" name="task" value="back" />
</form>

<form action="index.php" method="POST" name="addform" id="addform" onSubmit="return stest()">
	<table class="school">
		<tr>
			<td>R.No</td>
			<td>
				<?php echo $this->rno; ?>
			</td>
		</tr>
		<tr>
			<td>Student Name</td>
			<td>
				<?php echo $this->firstname; ?>
			</td>
		</tr>
		<tr>
			<td>Assement Title</td>
			<td>
				<?php echo $this->atitle; ?> 
			</td>
		</tr>
		<tr>
			<td>Description</td>
			<td>
				<input type="text" id="description" name="description" size="50" maxlength="150" value="<?php echo $this->mrec->description; ?>" />
			</td>
		</tr>
		<tr>
			<td>Marks</td>
			<td>
			<select name="marks">
        		<?php
                		if($this->mrec->marks)
                        		echo '<option value="'.$this->mrec->marks.'">'.$this->mrec->marks.'</option>';
                		else
                        		echo '<option>--Select a mark--</option>';
                		for($i=0;$i<=$this->max;$i=$i+0.5)
                		{
                			echo '<option value="'.$i.'">'.$i.'</option>';
                		}
        		?>
        		</select>
			</td>
		</tr>
		<tr>
			<td>Comments</td>
			<td>
			<input type="text" id="comments" name="comments" size="50" maxlength="150" value="<?php echo $this->mrec->comments;  ?>" />
			</td>
		</tr>
		<tr><td><input type="submit" class="button_save" value="Save" id="submit" name="submit" /></td></tr>
	</table>
	<input type="hidden" name="option" value="<?php echo JRequest::getVar('option'); ?>" />
	<input type="hidden" id="id" name="id" value="<?php echo $this->marksid; ?>" />
	<input type="hidden" id="courseid" name="courseid" value="<?php echo $this->courseid; ?>" />
	<input type="hidden" id="subjectid" name="subjectid" value="<?php echo $this->subjectid; ?>" />
	<input type="hidden" id="studentid" name="studentid" value="<?php echo $this->studentid; ?>" />
	<input type="hidden" id="gid" name="gid" value="<?php echo $this->gid; ?>" />
	<input type="hidden" id="sacdid" name="sacdid" value="<?php echo $this->sacdid; ?>" />
	<input type="hidden" id="entryid" name="entryid" value="<?php echo $this->sacdid; ?>" />
	<input type="hidden" id="max" name="max" value="<?php echo $this->max; ?>" />
	<input type="hidden" id="termid" name="termid" value="<?php echo $this->termid; ?>" />
	<input type="hidden" id="view" name="view" value="marklist" />
	<input type="hidden" id="controller" name="controller" value="gradebookmarks" />
	<input type="hidden" name="task" id="task" value="savemarks" />
</form>
