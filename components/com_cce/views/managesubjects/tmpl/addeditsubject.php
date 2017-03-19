<?php
        defined('_JEXEC') OR DIE('Access denied..');
	JHtml::_('behavior.tooltip');
	JHtml::_('behavior.formvalidation');
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	$Itemid = JRequest::getVar('Itemid');
   
    include_once (JPATH_ROOT.DS.'components'.DS.'com_cce'.DS.'views'.DS.'includecss.php');
	$iconsDir1 = JURI::base() . 'components/com_cce/images';

   	$model = & $this->getModel('managesubjects');

   	$dashboardItemid = $model->getMenuItemid('manageschool','Dash Board');
   	if($dashboardItemid) ;
   	else{
        	$dashboardItemid = $model->getMenuItemid('topmenu','Manage School');
   	}
	$masterItemid = $model->getMenuItemid('manageschool','Master');
        if($masterItemid) ;
        else{
                $masterItemid = $model->getMenuItemid('topmenu','Manage School');
        }

   	$subItemid = $model->getMenuItemid('master','Manage Subjects');
   	if($subItemid) ;
   	else{
        	$subItemid = $model->getMenuItemid('topmenu','Manage School');
   	}
   	$dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
   	$modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=master&Itemid='.$masterItemid);

  	$sublink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=managesubjects&view=managesubjects&task=display&Itemid='.$subItemid);
	$app =& JFactory::getApplication();
        $pathway =& $app->getPathway(); 
        $pathway->addItem('Home', $dashboardlink);
        $pathway->addItem('Master Settings',$modulelink);
        $pathway->addItem('Manage Subjects',$sublink);
        $pathway->addItem('Add/Edit Subject');


?>
<form action="<?php echo JRoute::_('index.php?option=com_cce&controller=academicyears&view=addacademicyear&task=save&id='.$this->rec->id.'&Itemid='.$Itemid) ?>" class="form-horizontal" method="POST"  name="addform" id="addform" onsubmit="return checkform()">				
<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-edit"></i> Subject Details</h2>
						<div class="box-icon">
							<button type="submit" class="btn btn-primary" name="Add" value="Add">Save</button>
						</div>
					</div>
					<div class="box-content">
						  <fieldset>
		                      <div class="control-group">
								<label class="control-label" for="focusedInput">Subject Title<span class="mandatory">*</span></label>
								<div class="controls">
								  <input class="input-xlarge focused" required="required" id="focusedInput" name="subjecttitle" type="text" value="<?php echo $this->rec->subjecttitle; ?>">
								</div>
							  </div>
							   <div class="control-group">
								<label class="control-label" for="focusedInput">Subject Code<span class="mandatory">*</span></label>
								<div class="controls">
								  <input class="input-xlarge focused"required="required"  id="focusedInput" name="subjectcode" type="text" value="<?php echo $this->rec->subjectcode; ?>">
								</div>
							  </div>
							   <div class="control-group">
								<label class="control-label" for="focusedInput">Subject Type<span class="mandatory">*</span></label>
								<div class="controls">
								<select id="selectError5" data-rel="chosen" name="subjecttype">
                                                                        <option value="Theory" <?php if($this->rec->subjecttype=="Theory") echo 'selected="selected"'; ?>>Theory</option>
                                                                        <option value="Practical" <?php if($this->rec->subjecttype=="Practical") echo 'selected="selected"'; ?>>Practical</option>
								</select>
								</div>
							  </div>
							   <div class="control-group">
								<label class="control-label" for="focusedInput">Acronym</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="focusedInput" name="acronym" type="text" value="<?php echo $this->rec->acronym; ?>">
								</div>
							  </div>
							   <div class="control-group">
								<label class="control-label" for="focusedInput">Pass Marks<span class="mandatory">*</span></label>
								<div class="controls">
								  <input class="input-xlarge focused" required="required" id="focusedInput" name="passmark" type="text" value="<?php echo ($this->rec->passmark)?$this->rec->passmark:"35"; ?>">
								</div>
							  </div>
							   <div class="control-group">
								<label class="control-label" for="focusedInput">Max.Marks<span class="mandatory">*</span></label>
								<div class="controls">
								  <input class="input-xlarge focused" required="required" id="focusedInput" name="marks" type="text" value="<?php echo ($this->rec->marks)?$this->rec->marks:"100"; ?>">
								</div>
							  </div>
							   <div class="control-group">
								<label class="control-label" for="focusedInput">Credits OR Hours/Week</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="focusedInput" name="credits" type="text" value="<?php echo ($this->rec->credits)?$this->rec->credits:"5"; ?>">
								</div>
							  </div>
							   <div class="control-group">
								<label class="control-label" for="focusedInput">Session Duration</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="focusedInput" name="sessionduration" type="text" value="<?php echo ($this->rec->sessionduration)?$this->rec->sessionduration:"1"; ?>">
								</div>
							  </div>
							  
							
							<div class="form-actions">
							  <button type="submit" class="btn btn-primary" name="Add" value="Add">Save</button>
							</div>
						  </fieldset>
	<input type="hidden" name="option" value="<?php echo JRequest::getVar('option'); ?>" />
        <input type="hidden" id="id" name="id" value="<?php echo $this->rec->id; ?>" />
        <input type="hidden" id="controller" name="controller" value="managesubjects" />
        <input type="hidden" id="view" name="view" value="managesubjects" />
        <input type="hidden" id="Itemid" name="Itemid" value="<?php echo $Itemid; ?>" />
        <input type="hidden" name="task" id="task" value="save" />
						</form>   

					</div>
				</div><!--/span-->

			</div><!--/row-->
</form>


<?php
 include_once (JPATH_ROOT.DS.'components'.DS.'com_cce'.DS.'views'.DS.'includejs.php');
?>
