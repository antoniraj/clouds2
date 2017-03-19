<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	$Itemid = JRequest::getVar('Itemid');
	$iconsDir1 = JURI::base() . 'components/com_cce/images';
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');

   	$model = & $this->getModel('cce');
   
    include_once (JPATH_ROOT.DS.'components'.DS.'com_cce'.DS.'views'.DS.'includecss.php');
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

   	$deptItemid = $model->getMenuItemid('master','Departments');
   	if($deptItemid) ;
   	else{
        	$deptItemid = $model->getMenuItemid('topmenu','Manage School');
   	}
   	$dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
   	$modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=master&Itemid='.$masterItemid);

  	$deptlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=departments&view=departments&task=display&Itemid='.$deptItemid);


?>

<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-edit"></i> Add Department</h2>
						<div class="box-icon">
						</div>
					</div>
					<div class="box-content">
						<form action="<?php echo JRoute::_('index.php?option=com_cce&controller=academicyears&view=addacademicyear&task=save&id='.$this->rec->id.'&Itemid='.$Itemid) ?>" class="form-horizontal" method="POST"  name="addform" id="addform" onsubmit="return checkform()">				
						  <fieldset>
							    <div class="control-group">
								<label class="control-label" for="focusedInput">Code<span class="mandatory">*</span></label>
								<div class="controls">
								  <input class="input-xlarge focused" required="required" id="focusedInput" name="departmentcode" type="text" value="<?php echo $this->rec->departmentcode; ?>">
								</div>
							  </div>
		                      <div class="control-group">
								<label class="control-label" for="focusedInput">Name<span class="mandatory">*</span></label>
								<div class="controls">
								  <input class="input-xlarge focused" required="required" id="focusedInput" name="departmentname" type="text" value="<?php echo $this->rec->departmentname; ?>">
								</div>
							  </div>
							 
							  
							<div class="form-actions">
							  <button type="submit" class="btn btn-primary" name="Add" value="Add">Save</button>
							</div>
						  </fieldset>
						<input type="hidden" name="option" value="<?php echo JRequest::getVar('option'); ?>" />
						<input type="hidden" id="id" name="id" value="<?php echo $this->rec->id; ?>" />
						<input type="hidden" id="controller" name="controller" value="departments" />
						<input type="hidden" id="view" name="view" value="adddepartment" />
						<input type="hidden" id="Itemid" name="Itemid" value="<?php echo $Itemid; ?>" />
						<input type="hidden" name="task" id="task" value="save" />
						</form>   

					</div>
				</div><!--/span-->

			</div><!--/row-->

	
<?php
 include_once (JPATH_ROOT.DS.'components'.DS.'com_cce'.DS.'views'.DS.'includejs.php');
?>
