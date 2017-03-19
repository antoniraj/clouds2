<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir1 = JURI::base() . 'components/com_cce/images/64x64';
	$iconsDir = JURI::base() . 'components/com_cce/images/';
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');

	$Itemid = JRequest::getVar('Itemid');
	$partid= JRequest::getVar('partid');
	$cbid= JRequest::getVar('cbid');
	
   	$model = & $this->getModel('exams');

	if(isset($partid)) {
		$htitle="Edit Part";
		$task = "updatepart";
		$model->getPart($partid,$rec);
	}else{
		$htitle ="Add Part";
		$task = "savepart";
		$rec->title='';
		$rec->code='';
		$rec->gpa='';
		$rec->gs='';
		$rec->gsno='';
		$rec->academic='';
	}

	
	$dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
   	$modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=grades&Itemid='.$masterItemid);

?>

<form action="<?php echo JRoute::_('index.php?option=com_cce&controller=exams&view=exams&task='.$task.'&id='.$rec->id.'&Itemid='.$Itemid) ?>" class="form-horizontal" method="POST"  name="addform" id="addform" onsubmit="return checkform()">				
<div class="row-fluid sortable">
	<div class="box span12">
		<div class="box-header well" data-original-title>
			<h2><i class="icon-edit"></i><?php echo $htitle; ?></h2>
			<div class="box-icon">
				<button type="submit" class="btn btn-primary" name="submit" value="Save">Save</button>
			</div>
		</div>
		<div class="box-content">
			<fieldset>
				<div class="control-group">
					<label class="control-label" for="focusedInput">Title</label>
					<div class="controls">
						<input class="input-xlarge focused" id="focusedInput" required name="title" type="text" value="<?php echo $rec->title; ?>">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="focusedInput">Short Code</label>
					<div class="controls">
						<input class="input-xlarge focused" id="focusedInput" name="code" required type="text" value="<?php echo $rec->code; ?>">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="focusedInput">GPA?</label>
					<div class="controls">
						<select id="selectError6" data-rel="chosen" name="gpa">
							<option value="1" <?php if($rec->gpa=="1") echo 'selected="selected"'; ?>>Yes</option>
							<option value="0" <?php if($rec->gpa=="0") echo 'selected="selected"'; ?>>No</option>
						</select>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="focusedInput">Grading System?</label>
					<div class="controls">
						<select id="selectError7" data-rel="chosen" name="gs">
							<option value="1" <?php if($rec->gs=="1") echo 'selected="selected"'; ?>>Yes</option>
							<option value="0" <?php if($rec->gs=="0") echo 'selected="selected"'; ?>>No</option>
						</select>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="focusedInput">Academic?</label>
					<div class="controls">
						<select id="selectError8" data-rel="chosen" name="academic">
							<option value="1" <?php if($rec->academic=="1") echo 'selected="selected"'; ?>>Yes</option>
							<option value="0" <?php if($rec->academic=="0") echo 'selected="selected"'; ?>>No</option>
						</select>
					</div>
				</div>
                                <div class="control-group">
                                        <label class="control-label" for="focusedInput">Group Serial Number</label>
                                        <div class="controls">
                                                <input class="input-xlarge focused" id="focusedInput" name="gsno" type="text" value="<?php echo $rec->gsno; ?>" />
                                        </div>
                                </div>

				<div class="form-actions">
					<button type="submit" class="btn btn-primary" name="submit" value="Save">Save</button>
				</div>
			</fieldset>

						  
			<input type="hidden" name="option" value="<?php echo JRequest::getVar('option'); ?>" />
			<input type="hidden" id="id" name="id" value="<?php echo $rec->id; ?>" />
			<input type="hidden" id="controller" name="controller" value="exams" />
			<input type="hidden" id="view" name="view" value="exams" />
			<input type="hidden" name="task" id="task" value="<?php echo $task; ?>" />
			<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>"/>
			<input type="hidden" name="cbid" value="<?php echo $cbid; ?>"/>
	
		</div>
	</div><!--/span-->
</div><!--/row-->
</form>   

