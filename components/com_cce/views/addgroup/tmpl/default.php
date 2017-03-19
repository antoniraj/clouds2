<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	$Itemid = JRequest::getVar('Itemid');
	$from= JRequest::getVar('from');
	$iconsDir1 = JURI::base() . 'components/com_cce/images';
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');

   	$model = & $this->getModel('groups');
   
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

   	$xItemid = $model->getMenuItemid('master','Student Groups');
   	if($xItemid) ;
   	else{
        	$xItemid = $model->getMenuItemid('topmenu','Manage School');
   	}
   	$dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
   	$modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=master&Itemid='.$masterItemid);
   	$modulelink1= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=groupmembers&view=groupmembers&task=display&Itemid='.$masterItemid);

  	$link= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=groups&view=groups&task=display&Itemid='.$Itemid);

		$app =& JFactory::getApplication();
        	$pathway =& $app->getPathway(); 
	        $pathway->addItem('Home', $dashboardlink);
		if($from=='groupmembers'){
        		$pathway->addItem('Students',$modulelink1);
		        $pathway->addItem('Groups');
		}else{
		        $pathway->addItem('Settings', $modulelink);
		        $pathway->addItem('Groups', $link);
        		$pathway->addItem('Add/Update');
		}

?>

<form action="<?php echo JRoute::_('index.php?option=com_cce&controller=academicyears&view=addacademicyear&task=save&id='.$this->rec->id.'&Itemid='.$Itemid) ?>" class="form-horizontal" method="POST"  name="addform" id="addform" onsubmit="return checkform()">				
<div class="row-fluid sortable">
				<div class="box span6">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-edit"></i> Group Details</h2>
						<div class="box-icon">
							<button type="submit" class="btn btn-primary" name="Add" value="Add">Save</button>
						</div>
					</div>
					<div class="box-content">
						  <fieldset>
							   <div class="control-group">
								<label class="control-label" for="focusedInput">Group Code<span class="mandatory">*</span></label>
								<div class="controls">
								  <input class="focused" required="required" id="focusedInput" name="groupcode" type="text" value="<?php echo $this->rec->groupcode; ?>">
								</div>
							  </div>
		                      <div class="control-group">
								<label class="control-label" for="focusedInput">Group Name<span class="mandatory">*</span></label>
								<div class="controls">
								  <input class="focused" required="required" id="focusedInput" name="groupname" type="text" value="<?php echo $this->rec->groupname; ?>">
								</div>
							  </div>
							  
                              <div class="control-group">
							  <label class="control-label" for="textarea2">Purpose</label>
							  <div class="controls">
								<textarea id="textarea2" rows="3" name="purpose"><?php echo $this->rec->purpose; ?></textarea>
							  </div>
							 </div>
							 <div class="control-group">
							  <label class="control-label" for="textarea2">Description</label>
							  <div class="controls">
								<textarea id="textarea2" rows="3" name="description"><?php echo $this->rec->description; ?></textarea>
							  </div>
							 </div>
                             			<div class="form-actions">
							  <button type="submit" class="btn btn-primary" name="Add" value="Add">Save</button>
							</div>
						  </fieldset>
							<input type="hidden" name="option" value="<?php echo JRequest::getVar('option'); ?>" />
							<input type="hidden" id="id" name="id" value="<?php echo $this->rec->id; ?>" />
							<input type="hidden" id="view" name="view" value="addgroup" />
							<input type="hidden" name="from" value="<?php echo $from; ?>" />
							<input type="hidden" id="controller" name="controller" value="groups" />
							<input type="hidden" name="Itemid" id="Itemid" value="<?php echo $Itemid; ?>" />
							<input type="hidden" name="task" id="task" value="save" />

					</div>
				</div><!--/span-->

			</div><!--/row-->
					</form>   
