<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');
		$iconsDir1 = JURI::base() . 'components/com_cce/images/64x64';
	$iconsDir = JURI::base() . 'components/com_cce/images/';
	$Itemid = JRequest::getVar('Itemid');
	$dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
   	$modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=grades&Itemid='.$masterItemid);

?>
<div class="row-fluid">
<div class="span6"> 
   <div class="row-fluid">
   <div class="span1">
     <img src="<?php echo $iconsDir.'/fagrades.png'; ?>" alt="Template" style="width: 68px; height: 48px;" />

   </div>
   <div class="span6">
    <h1>Add FA Grade</h1>
   </div>
   </div>
 </div>
<div class="span6" align="right">
   <a href="<?php echo $modulelink; ?>"><img src="<?php echo $iconsDir.'/1results.png'; ?>" alt="Grades" style="width: 48px; height: 48px;" /></a> 

     <a href="<?php echo $dashboardlink; ?>"><img src="<?php echo $iconsDir1.'/1dashboard.png'; ?>" alt="Dash Board" style="width: 48px; height: 48px;" /></a> 
   
</div>

<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-edit"></i> FA Grade</h2>
						<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
						</div>
					</div>
					<div class="box-content">
						<form action="<?php echo JRoute::_('index.php?option=com_cce&controller=academicyears&view=addacademicyear&task=save&id='.$this->rec->id.'&Itemid='.$Itemid) ?>" class="form-horizontal" method="POST"  name="addform" id="addform" onsubmit="return checkform()">				
						  <fieldset>
		                      <div class="control-group">
								<label class="control-label" for="focusedInput">From</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="focusedInput" name="from" type="text" value="<?php echo $this->rec->from; ?>">
								</div>
							  </div>
							
                              <div class="control-group">
								<label class="control-label" for="focusedInput">To</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="focusedInput" name="to" type="text" value="<?php echo $this->rec->to; ?>">
								</div>
							  </div>
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Letter Grade</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="focusedInput" name="letter" type="text" value="<?php echo $this->rec->letter; ?>">
								</div>
							  </div>
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Grade Point</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="focusedInput" name="points" type="text" value="<?php echo $this->rec->points; ?>">
								</div>
							  </div>
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Description</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="focusedInput" name="description" type="text" value="<?php echo $this->rec->description; ?>">
								</div>
							  </div>
		
							<div class="form-actions">
							  <button type="submit" class="btn btn-primary" name="Add" value="Add">Save</button>
							  <button type="reset" class="btn">Cancel</button>
							</div>
						  </fieldset>
						  
                                <input type="hidden" name="option" value="<?php echo JRequest::getVar('option'); ?>" />
                    <input type="hidden" id="id" name="id" value="<?php echo $this->rec->id; ?>" />
                    <input type="hidden" id="controller" name="controller" value="fagrades" />
                    <input type="hidden" id="view" name="view" value="addfagrade" />
                    <input type="hidden" name="task" id="task" value="save" />
                    <input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>"/>
						</form>   

					</div>
				</div><!--/span-->

			</div><!--/row-->

</form>

