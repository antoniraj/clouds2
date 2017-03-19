<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');

        $Itemid = JRequest::getVar('Itemid');
        $gseid= JRequest::getVar('gseid');
        $gsid= JRequest::getVar('gsid');

        $model = & $this->getModel('exams');

        if(isset($gseid)) {
                $htitle="Edit Grading System Entry";
                $task = "updategradingsystementry";
                $model->getGradingSystemEntry($gseid,$rec);
        }else{
                $htitle ="Add Grading System Entry";
                $task = "savegradingsystementry";
                $rec->from='';
                $rec->to='';
                $rec->letter='';
                $rec->points='';
                $rec->description='';
        }


	$iconsDir1 = JURI::base() . 'components/com_cce/images/64x64';
	$iconsDir = JURI::base() . 'components/com_cce/images/';
	$Itemid = JRequest::getVar('Itemid');
	$dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
   	$modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=grades&Itemid='.$masterItemid);

?>
<div class="row-fluid sortable">
	<div class="box span12">
		<div class="box-header well" data-original-title>
			<h2><i class="icon-edit"></i><?php echo $htitle; ?></h2>
		</div>
		<div class="box-content">
			<form action="<?php echo JRoute::_('index.php?option=com_cce&controller=exams&view=exams&task='.$task.'&id='.$rec->id.'&Itemid='.$Itemid) ?>" class="form-horizontal" method="POST"  name="addform" id="addform" onsubmit="return checkform()">				
				<fieldset>
					<div class="control-group">
						<label class="control-label" for="focusedInput">From</label>
						<div class="controls">
							<input class="input-xlarge focused" id="focusedInput" name="from" type="text" value="<?php echo $rec->from; ?>">
						</div>
					</div>

					<div class="control-group">
						<label class="control-label" for="focusedInput">To</label>
						<div class="controls">
							<input class="input-xlarge focused" id="focusedInput" name="to" type="text" value="<?php echo $rec->to; ?>">
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="focusedInput">Letter Grade</label>
						<div class="controls">
							<input class="input-xlarge focused" id="focusedInput" name="letter" type="text" value="<?php echo $rec->letter; ?>">
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="focusedInput">Grade Point</label>
						<div class="controls">
							<input class="input-xlarge focused" id="focusedInput" name="points" type="text" value="<?php echo $rec->points; ?>">
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="focusedInput">Description</label>
						<div class="controls">
							<input class="input-xlarge focused" id="focusedInput" name="description" type="text" value="<?php echo $rec->description; ?>">
						</div>
					</div>

					<div class="form-actions">
						<button type="submit" class="btn btn-primary" name="Add" value="Add">Save</button>
					</div>
				</fieldset>

				<input type="hidden" name="option" value="<?php echo JRequest::getVar('option'); ?>" />
				<input type="hidden" id="id" name="id" value="<?php echo $rec->id; ?>" />
				<input type="hidden" id="controller" name="exams" value="fagrades" />
				<input type="hidden" id="view" name="view" value="exams" />
				<input type="hidden" id="gsid" name="gsid" value="<?php echo $gsid; ?>" />
				<input type="hidden" name="task" id="task" value="<?php echo $task; ?>" />
				<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>"/>
			</form>   
		</div>
	</div>
</div>


