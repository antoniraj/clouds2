<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir1 = JURI::base() . 'components/com_cce/images/64x64';
	$iconsDir = JURI::base() . 'components/com_cce/images/';
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');

	$Itemid = JRequest::getVar('Itemid');
	$termid= JRequest::getVar('termid');
	$partid= JRequest::getVar('partid');
	$cbid= JRequest::getVar('cbid');
	
   	$model = & $this->getModel('exams');

	if(isset($termid)) {
		$htitle="Edit Term";
		$task = "updateterm";
		$model->getTTerm($termid,$rec);
	}else{
		$htitle ="Add Term";
		$task = "saveterm";
		$rec->term='';
		$rec->code='';
		$rec->months='';
		$rec->startdate='';
		$rec->stopdate='';
	}

	
	$dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
   	$modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=grades&Itemid='.$masterItemid);

?>

<form action="<?php echo JRoute::_('index.php?option=com_cce&controller=exams&view=exams&task=saveterm&id='.$rec->id.'&partid='.$partid.'&Itemid='.$Itemid) ?>" class="form-horizontal" method="POST"  name="addform" id="addform" onsubmit="return checkform()">				
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
						<input class="input-xlarge focused" id="focusedInput" required name="term" type="text" value="<?php echo $rec->term; ?>">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="focusedInput">Code</label>
					<div class="controls">
						<input class="input-xlarge focused" id="focusedInput" name="code" required type="text" value="<?php echo $rec->code; ?>">
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="focusedInput">Months</label>
					<div class="controls">
						<input class="input-xlarge focused" id="focusedInput" name="months" required type="text" value="<?php echo $rec->months; ?>">
					</div>
				</div>

				<div class="control-group">
                                	<label class="control-label" for="date01">Start Date<span class="mandatory">*</span></label>
                                       	<div class="controls">
                                       		<input type="text" class="datepicker"  required="required" id="date01" name="startdate" value="<?php echo JArrayHelper::indianDate($rec->startdate); ?>">
                                        </div>
                                 </div>

				<div class="control-group">
                                	<label class="control-label" for="date01">Stop Date<span class="mandatory">*</span></label>
                                       	<div class="controls">
                                       		<input type="text" class="datepicker"  required="required" id="date02" name="stopdate" value="<?php echo JArrayHelper::indianDate($rec->stopdate); ?>">
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
			<input type="hidden" name="partid" value="<?php echo $partid; ?>"/>
	
		</div>
	</div><!--/span-->
</div><!--/row-->
</form>   

