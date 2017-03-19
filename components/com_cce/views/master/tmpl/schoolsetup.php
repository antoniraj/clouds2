
<?php
	defined('_JEXEC') OR DIE('Access denied..');
	$app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	$Itemid = JRequest::getVar('Itemid');

	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');

	$iconsDir1 = JURI::base() . 'components/com_cce/images';

   	$model = & $this->getModel('cce');

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

   	$ayItemid = $model->getMenuItemid('master','Academic Years');
   	if($ayItemid) ;
   	else{
        	$ayItemid = $model->getMenuItemid('topmenu','Manage School');
   	}
   	$dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
   	$modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=master&Itemid='.$masterItemid);

  	$aylink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=academicyears&view=academicyears&task=display&Itemid='.$ayItemid);


?>

<table width="100%" cellpadding="10">
        <tr style="border:none;">
                <td style="border:none;" align="left">
        <div style="float:left;">
           <img src="<?php echo $iconsDir1.'/schoolsetup.png'; ?>" alt="" style="width: 64px; height: 64px;" />
        </div>
        <div style="float:left;">
		<div>&nbsp;</div>
                <h1 class="item-page-title">School Setup</h1>
        </div>
                       <div style="float:right;"> <a href="<?php echo $dashboardlink; ?>"><img src="<?php echo $iconsDir1.'/1dashboard.png'; ?>" alt="Dash Board" style="width: 32px; height: 32px;" /></a><br />
			</div>
			<div style="float:right; width:10px;"> &nbsp;</div>
			<div style="float:right;">
                        <a href="<?php echo $modulelink; ?>"><img src="<?php echo $iconsDir1.'/1master.png'; ?>" alt="Master" style="width: 40px; height: 40px;" /></a><br />
			</div>
		
                </td>
        </tr>
</table>



<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-edit"></i> School Setup</h2>
						<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
						</div>
					</div>
					<div class="box-content">
						<form action="<?php echo JRoute::_('index.php?option=com_cce&controller=academicyears&view=addacademicyear&task=save&id='.$this->rec->id.'&Itemid='.$Itemid) ?>" class="form-horizontal" method="POST"  name="addform" id="addform" onsubmit="return checkform()">				
						  <fieldset>
		                      <div class="control-group">
								<label class="control-label" for="focusedInput">School Name</label>
								<div class="controls">
								  <input class="focused" id="focusedInput" name="schoolname" type="text" value="<?php echo $this->rec->schoolname; ?>">
								</div>
							  </div>
							       <div class="control-group">
								<label class="control-label" for="focusedInput">School Phone</label>
								<div class="controls">
								  <input class="focused" id="focusedInput" name="schoolphone" type="text" value="<?php echo $this->rec->schoolphone; ?>">
								</div>
							  </div>
							       <div class="control-group">
								<label class="control-label" for="focusedInput">School Address</label>
								<div class="controls">
								  <textarea name="schooladdress" cols="25" rows="5"><?php echo $this->rec->schooladdress; ?></textarea>
								</div>
		                      			     <div class="control-group">
								<label class="control-label" for="focusedInput">Education Board Title</label>
								<div class="controls">
								  <input class="focused" id="focusedInput" name="board" type="text" value="<?php echo $this->rec->board; ?>">
								</div>
							  </div>
		                      			     <div class="control-group">
								<label class="control-label" for="focusedInput">Education District</label>
								<div class="controls">
								  <input class="focused" id="focusedInput" name="educationdistrict" type="text" value="<?php echo $this->rec->educationdistrict; ?>">
								</div>
							  </div>
		                      			     <div class="control-group">
								<label class="control-label" for="focusedInput">Revenue District</label>
								<div class="controls">
								  <input class="focused" id="focusedInput" name="revenuedistrict" type="text" value="<?php echo $this->rec->revenuedistrict; ?>">
								</div>
							  </div>
						
							 	<div class="control-group">
							  <label class="control-label">Show Result</label>
							  <div class="controls">
								<input data-no-uniform="true" type="checkbox" class="iphone-toggle" name="showresult" <?php if($this->rec->showresult=="1") echo 'checked="checked"'; ?> value="1">
							  </div>
							</div>
								<div class="control-group">
							  <label class="control-label">Show Grades</label>
							  <div class="controls">
								<input data-no-uniform="true" type="checkbox" class="iphone-toggle" name="showgrades" <?php if($this->rec->showgrades=="1") echo 'checked="checked"'; ?> value="1">
							  </div>
							</div> 
							<div class="control-group">
							  <label class="control-label">SMS Sending</label>
							  <div class="controls">
								<input data-no-uniform="true" type="checkbox" class="iphone-toggle" name="smssending" <?php if($this->rec->smssending=="1") echo 'checked="checked"'; ?> value="1">
							  </div>
							</div>
							<div class="form-actions">
							  <button type="submit" class="btn btn-primary" name="Apply" value="Apply">Apply</button>
							</div>
						  </fieldset>
						  
	<input type="hidden" name="option" value="<?php echo JRequest::getVar('option'); ?>" />
	<input type="hidden" id="id" name="id" value="<?php echo $this->rec->id; ?>" />
	<input type="hidden" id="view" name="view" value="master" />
	<input type="hidden" id="Itemid" name="Itemid" value="<?php echo $Itemid; ?>" />
	<input type="hidden" id="controller" name="controller" value="master" />
	<input type="hidden" name="task" id="task" value="schoolSetup" />
						</form>   

					</div>
				</div><!--/span-->

			</div><!--/row-->


