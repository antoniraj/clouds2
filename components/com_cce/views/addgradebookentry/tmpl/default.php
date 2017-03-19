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
           <img src="<?php echo $iconsDir.'/addgradebookentry.png'; ?>" alt="" style="width: 64px; height: 64px;" />
        </div>
        <div>
                <div>&nbsp;</div>
                <h1>Add Grade-Book Entry</h1>
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
			<td>Short Code</td>
			<td>
			<input type="text" id="code" name="code" size="32" maxlength="15" value="<?php echo $this->rec->code;  ?>" />
			</td>
		</tr>
		<tr>
			<td>Weightage</td>
			<td>
				<input type="text" id="weightage" name="weightage" size="32" maxlength="20" value="<?php echo $this->rec->weightage; ?>" />
			</td>
		</tr>
		<tr>
                        <td>Number of Best Sub-Categories for the Weightage</td>
                        <td>
					<?php
                                                if($this->rec->bestof==0) $this->rec->bestof='All';
                                        ?>

				<select id="bestof" name="bestof">
                                	<option value="<?php echo $this->rec->bestof;  ?>"><?php echo $this->rec->bestof; ?></option>
	                                <option value="0">All</option>
        	                        <option value="1">1</option>
        	                        <option value="2">2</option>
        	                        <option value="3">3</option>
        	                        <option value="4">4</option>
        	                        <option value="5">5</option>
        	                        <option value="6">6</option>
        	                        <option value="7">7</option>
        	                        <option value="8">8</option>
        	                        <option value="9">9</option>
        	                        <option value="10">10</option>
        	                        <option value="11">11</option>
        	                        <option value="12">12</option>
        	                        <option value="13">13</option>
        	                        <option value="14">14</option>
        	                        <option value="15">15</option>
                	        </select>
                        </td>
                </tr>

		<tr>
			<td>Description</td>
			<td>
				<input type="text" id="description" name="description" size="32" maxlength="20" value="<?php echo $this->rec->description; ?>" />
			</td>
		</tr>
		<tr>
                        <td>Group Tag for Grading</td>
                        <td>
				<input type="text" id="grouptag" name="grouptag" size="32" maxlength="20" value="<?php echo $this->rec->grouptag; ?>" />
                        </td>
                </tr>
		<tr>
                        <td>Group SNO</td>
                        <td>
                                <select id="gsno" name="gsno">
                                        <option value="<?php echo $this->rec->gsno;  ?>"><?php echo $this->rec->gsno; ?></option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                </select>
                        </td>
                </tr>


		<tr><td><input type="submit" class="button_save" value="Save" id="submit" name="submit" /></td></tr>
	</table>
	<input type="hidden" name="option" value="<?php echo JRequest::getVar('option'); ?>" />
	<input type="hidden" id="id" name="id" value="<?php echo $this->rec->id; ?>" />
	<input type="hidden" id="controller" name="controller" value="gradebook" />
	<input type="hidden" id="view" name="view" value="addgradebookentry" />
	<input type="hidden" id="subjectid" name="subjectid" value="<?php echo $this->subjectid; ?>" />
	<input type="hidden" id="courseid" name="courseid" value="<?php echo $this->courseid; ?>" />
	<input type="hidden" id="termid" name="termid" value="<?php echo $this->termid; ?>" />
	<input type="hidden" name="task" id="task" value="save" />
	<input type="hidden" name="Itemid" id="Itemid" value="<?php echo $Itemid; ?>" />
</form>
