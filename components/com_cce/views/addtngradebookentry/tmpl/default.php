<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir1 = JURI::base() . 'components/com_cce/images/64x64';
	$iconsDir = JURI::base() . 'components/com_cce/images/';
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');
	$Itemid = JRequest::getVar('Itemid');
	$dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
   	$modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=grades&Itemid='.$masterItemid);
		$app =& JFactory::getApplication();
        	$pathway =& $app->getPathway(); 
        	$pathway->addItem('Dashboard',$dashboardlink);
        	$pathway->addItem('Exams&Grades',$modulelink);
        	$pathway->addItem('Examination','index.php?option=com_cce&controller=tngradebook&view=tngradebook&Itemid='.$Itemid);
        	$pathway->addItem('Add/Edit');

?>

<form action="<?php echo JRoute::_('index.php?option=com_cce&controller=academicyears&view=addacademicyear&task=save&id='.$this->rec->id.'&Itemid='.$Itemid) ?>" class="form-horizontal" method="POST"  name="addform" id="addform" onsubmit="return checkform()">				
<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-edit"></i>Add Examination</h2>
						<div class="box-icon">
							  <button type="submit" class="btn btn-primary" name="submit" value="Save">Save</button>
						</div>
					</div>
					<div class="box-content">
						  <fieldset>
		                      <div class="control-group">
								<label class="control-label" for="focusedInput">Title</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="focusedInput" name="title" type="text" value="<?php echo $this->rec->title; ?>">
								</div>
							  </div>
							 <div class="control-group">
								<label class="control-label" for="focusedInput">ShortCode</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="focusedInput" name="code" type="text" value="<?php echo $this->rec->code; ?>">
								</div>
							  </div>
                               <div class="control-group">
								<label class="control-label" for="focusedInput">Marks</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="focusedInput" name="marks" type="text" value="<?php echo $this->rec->marks; ?>">
								</div>
							  </div>
                             

							 
							<div class="control-group">
							  <label class="control-label" for="date01">Due Date</label>
							  <div class="controls">
								<input type="text" class="input-xlarge datepicker" id="date01" name="duedate" value="<?php echo $this->rec->duedate; ?>">
							  </div>
							</div>
                              				<div class="control-group">
								<label class="control-label" for="focusedInput">Description</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="focusedInput" name="description" type="text" value="<?php echo $this->rec->description; ?>">
								</div>
							  </div>
                              				<div class="control-group">
								<label class="control-label" for="focusedInput">Exam Instructions</label>
								<div class="controls">
								  <textarea style="width: 80%;" rows="15" name="instructions"><?php echo ltrim($this->rec->instructions); ?></textarea>
								</div>
							  </div>
                            
							
							<div class="form-actions">
							  <button type="submit" class="btn btn-primary" name="submit" value="Save">Save</button>
							</div>
						  </fieldset>
						  
						  
	<input type="hidden" name="option" value="<?php echo JRequest::getVar('option'); ?>" />
	<input type="hidden" id="id" name="id" value="<?php echo $this->rec->id; ?>" />
	<input type="hidden" id="controller" name="controller" value="tngradebook" />
	<input type="hidden" id="view" name="view" value="addtngradebookentry" />
	<input type="hidden" name="task" id="task" value="save" />
	<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>"/>

					</div>
				</div><!--/span-->

			</div><!--/row-->
</form>   

