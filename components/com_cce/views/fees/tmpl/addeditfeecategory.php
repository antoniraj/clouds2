<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');
	$Itemid = JRequest::getVar('Itemid');
	$fcid= JRequest::getVar('fcid');
	$fstid= JRequest::getVar('fstid');
	$eon= JRequest::getVar('eon');
	
	$iconsDir1 = JURI::base() . 'components/com_cce/images';

   	$model = & $this->getModel('fees');
	$rs = $model->getFeeCategory($fcid,$rec);
	if($rs==false) {
		$rec->id = -1;
		$rec->description='';
	}

   	$dashboardItemid = $model->getMenuItemid('manageschool','Dash Board');
   	if($dashboardItemid) ;
   	else{
        	$dashboardItemid = $model->getMenuItemid('topmenu','Manage School');
   	}
	$masterItemid = $model->getMenuItemid('manageschool','Time Table');
        if($masterItemid) ;
        else{
                $masterItemid = $model->getMenuItemid('topmenu','Manage School');
        }
	$fcItemid = $model->getMenuItemid('manageschool','Fee Category');
        if($fcItemid) ;
        else{
                $fcItemid = $model->getMenuItemid('topmenu','Manage School');
        }
   	$dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
   	$modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=fees&Itemid='.$masterItemid);
   	$fclink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=fees&view=fees&task=display&layout=feecategory&eon='.$eon.'&fstid='.$fstid.'&Itemid='.$Itemid);

	$app =& JFactory::getApplication();
        $pathway =& $app->getPathway(); 
        $pathway->addItem('Home', $dashboardlink);
        $pathway->addItem('Fees',$modulelink);
        $pathway->addItem('Fee Structures',$fclink);
        $pathway->addItem('Edit Fee Head' );


?>
						<form action="<?php echo JRoute::_('index.php?option=com_cce&controller=academicyears&view=addacademicyear&task=save&id='.$this->rec->id.'&Itemid='.$Itemid) ?>" class="form-horizontal" method="POST"  name="addform" id="addform" onsubmit="return checkform()">				

<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-edit"></i> Fee Category</h2>
						<div class="box-icon">
							  <button type="submit" class="btn btn-primary" name="submit" value="Save">Save</button>
						</div>
					</div>
					<div class="box-content">
						  <fieldset>
		                      <div class="control-group">
								<label class="control-label" for="focusedInput">Category Name</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="focusedInput" name="name" type="text" value="<?php echo $rec->name; ?>">
								</div>
							  </div>
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Category Code</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="focusedInput" name="description" type="text" value="<?php echo $rec->description; ?>">
								</div>
							  </div>

							<div class="form-actions">
							  <button type="submit" class="btn btn-primary" name="submit" value="Save">Save</button>
							  <button type="reset" class="btn">Cancel</button>
							</div>
						  </fieldset>
						  
						  
        <input type="hidden" name="option" value="<?php echo JRequest::getVar('option'); ?>" />
        <input type="hidden" id="id" name="id" value="<?php echo $rec->id; ?>" />
        <input type="hidden" id="view" name="view" value="fees" />
        <input type="hidden" id="controller" name="controller" value="fees" />
        <input type="hidden" name="Itemid" id="Itemid" value="<?php echo $Itemid; ?>" />
        <input type="hidden" name="fstid" id="fstid" value="<?php echo $fstid; ?>" />
        <input type="hidden" name="eon" id="eon" value="<?php echo $eon; ?>" />
        <input type="hidden" name="task" id="task" value="savefeecategory" />
        <input type="hidden" name="layout" id="layout" value="feecategory" />
						</form>   

					</div>
				</div><!--/span-->

			</div><!--/row-->

</form>
