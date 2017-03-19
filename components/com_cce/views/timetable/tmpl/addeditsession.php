
<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');
	$Itemid = JRequest::getVar('Itemid');
	$scid= JRequest::getVar('scid');
	$stid= JRequest::getVar('stid');
	$iconsDir1 = JURI::base() . 'components/com_cce/images';
	JHtml::_('stylesheet', 'components/com_cce/libraries/charisma/css/bootstrap-timepicker.min.css');
   	$model = & $this->getModel('timetable');
	$rs = $model->getSession($stid,$rec);
	if($rs==false) {
		$rec->id = -1;
		$rec->code='';
		$rec->title='';
		$rec->start='';
		$rec->stop='';
		$rec->break='0';
	}

   	$dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
   	$modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=timetable&Itemid='.$masterItemid);
   	$sclink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=timetable&view=timetable&task=display&layout=sessioncategory&scid='.$scid.'&Itemid='.$Itemid);
   	$stlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=timetable&view=timetable&task=display&layout=sessiontimings&scid='.$scid.'&Itemid='.$Itemid);

?>
<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-edit"></i> Add/Edit Session</h2>
						<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
						</div>
					</div>
					<div class="box-content">
						<form action="<?php echo JRoute::_('index.php?option=com_cce&controller=academicyears&view=addacademicyear&task=save&id='.$rec->id.'&Itemid='.$Itemid) ?>" class="form-horizontal" method="POST"  name="addform" id="addform" onsubmit="return checkform()">				
						  <fieldset>
							   <div class="control-group">
								<label class="control-label" for="focusedInput">Session Title<span class="mandatory">*</span></label>
								<div class="controls">
								  <input class="focused" required="required" id="focusedInput" name="title" type="text" value="<?php echo $rec->title; ?>">
								</div>
							  </div>
							     <div class="control-group">
								<label class="control-label" for="focusedInput">Session Code<span class="mandatory">*</span></label>
								<div class="controls">
								  <input class="focused" required="required" id="focusedInput" name="code" type="text" value="<?php echo $rec->code; ?>">
								</div>
							  </div>
							
							<div class="control-group">
							  <label class="control-label" for="date01">Start Time(HH:MM AM/PM)<span class="mandatory">*</span></label>
									 <div class="controls">
										<input required="required" type="text" name="start" value="<?php echo $rec->start; ?>">
									</div>
							</div>
							<div class="control-group">
							  <label class="control-label" for="date01">Stop Time(HH:MM AM/PM)<span class="mandatory">*</span></label>
									 <div class="controls">
										<input required="required" type="text" name="stop" value="<?php echo $rec->stop; ?>" >
									</div>
							</div>
							<div class="control-group">
							  <label class="control-label" for="date01">Break?<span class="mandatory">*</span></label>
									 <div class="controls">
								<?php
									if($rec->break=='1')
										echo '<input type="checkbox" name="break" checked="true" value="1" >';
									else
										echo '<input type="checkbox" name="break"  value="0" >';
							?>
									</div>
							</div>
							<div class="form-actions">
							  <button type="submit" class="btn btn-primary" name="Add" value="Save">Save</button>
							</div>
						  </fieldset>
						  
																  
						<input type="hidden" name="option" value="<?php echo JRequest::getVar('option'); ?>" />
						<input type="hidden" id="id" name="id" value="<?php echo $rec->id; ?>" />
						<input type="hidden" id="view" name="view" value="timetable" />
						<input type="hidden" id="controller" name="controller" value="timetable" />
						<input type="hidden" name="Itemid" id="Itemid" value="<?php echo $Itemid; ?>" />
						<input type="hidden" name="scid" id="scid" value="<?php echo $scid; ?>" />
						<input type="hidden" name="stid" id="stid" value="<?php echo $stid; ?>" />
						<input type="hidden" name="task" id="task" value="savesession" />
						<input type="hidden" name="layout" id="layout" value="sessiontimings" />
						</form>   

					</div>
				</div><!--/span-->

			</div><!--/row-->
</form>
