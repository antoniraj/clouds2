<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir1 = JURI::base() . 'components/com_cce/images/64x64';
	$iconsDir = JURI::base() . 'components/com_cce/images/';
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');

	$Itemid = JRequest::getVar('Itemid');
	$gbeid= JRequest::getVar('gbeid');
	$gbid= JRequest::getVar('gbid');
	$aflag= JRequest::getVar('aflag');
	$classid= JRequest::getVar('classid');
	$subjectid= JRequest::getVar('subjectid');
	$termid= JRequest::getVar('termid');
	
   	$model = & $this->getModel('exams');

	if(isset($gbeid) && ($aflag=="0")) {
		$htitle="Edit Grade Book Entry";
		$task = "updatesubjectgradebookentry";
		$model->getGradeBookEntry($gbeid,$rec);
	}
	if(isset($gbeid) && ($aflag=="1")) {
		$htitle ="Add Grade Book Entry";
		$task = "savesubjectgradebookentry";
		$rec->title='';
		$rec->code='';
		$rec->marks='';
	//	$rec->required='';
		$rec->description='';
		$rec->duedate=date('d-m-Y');
	}

	
	$dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
   	$modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=grades&Itemid='.$masterItemid);

?>


<script>
function goBack() {
    window.history.back();
}
</script>

<form action="<?php echo JRoute::_('index.php?option=com_cce&controller=exams&view=exams&task='.$task.'&id='.$rec->id.'&Itemid='.$Itemid) ?>" class="form-horizontal" method="POST"  name="addform" id="addform1">				
<div class="row-fluid sortable">
	<div class="box span12">
		<div class="box-header well" data-original-title>
			<h2><i class="icon-edit"></i><?php echo $htitle; ?></h2>
			<div class="box-icon">
					<button onclick="goBack()"  class="btn btn-warning">Go Back</button>
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
					<label class="control-label" for="focusedInput">Marks/Weightage</label>
					<div class="controls">
						<input class="input-xlarge focused" id="focusedInput" name="marks" required type="text" value="<?php echo $rec->weightage; ?>">
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="date01">Due Date</label>
					<div class="controls">
						<input type="text" class="input-xlarge datepicker" id="date01" name="duedate" value="<?php echo JArrayHelper::indianDate($rec->duedate); ?>">
					</div>
				</div>
<!--
				<div class="control-group">
					<label class="control-label" for="focusedInput">Required Entry?</label>
					<div class="controls">
						<select id="selectError6" data-rel="chosen" name="required">
							<option value="1" <?php if($rec->required=="1") echo 'selected="selected"'; ?>>Yes</option>
							<option value="0" <?php if($rec->required=="0") echo 'selected="selected"'; ?>>No</option>
						</select>
					</div>
				</div>
-->
                                <div class="control-group">
                                        <label class="control-label" for="focusedInput">Group Serial Number</label>
                                        <div class="controls">
                                                <input class="input-xlarge focused" id="focusedInput" name="gsno" type="text" value="<?php echo $rec->gsno; ?>">
                                        </div>
                                </div>
<!--
				<div class="control-group">
					<label class="control-label" for="focusedInput">Parent Subject</label>
					<div class="controls">
						<select id="selectError5" data-rel="chosen" name="parentid">
							<option value="">No Parent</option>
						<?php
						/*	$psubs = $model->getTGradeBookEntries($gbid);
							foreach($psubs as $psub){
								$sel='';
								if($rec->parentid==$psub->id) $sel='selected="selected"';
								echo '<option value="'.$psub->id.'" '.$sel.' ">'.$psub->title.'</option>';
							}
						*/?>
						</select>
					</div>
				</div>
-->

				<div class="control-group">
					<label class="control-label" for="focusedInput">Description</label>
					<div class="controls">
						<input class="input-xlarge focused" id="focusedInput" name="description" type="text" value="<?php echo $rec->description; ?>">
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
			<input type="hidden" name="gbid" value="<?php echo $gbid; ?>"/>
			<input type="hidden" name="gbeid" value="<?php echo $gbeid; ?>"/>
			<input type="hidden" name="parentid" value="<?php 
				if($aflag=="0")
					echo $rec->parentid;
				else
					echo $gbeid; 
			?>"/>
			<input type="hidden" name="classid" value="<?php echo $classid; ?>"/>
			<input type="hidden" name="termid" value="<?php echo $termid; ?>"/>
			<input type="hidden" name="subjectid" value="<?php echo $subjectid; ?>"/>
			<input type="hidden" name="required" value="1"/>
	
		</div>
	</div><!--/span-->
</div><!--/row-->
</form>   

