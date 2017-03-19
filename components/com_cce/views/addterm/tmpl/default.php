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

   	$atItemid = $model->getMenuItemid('master','Academic Terms');
   	if($atItemid) ;
   	else{
        	$atItemid = $model->getMenuItemid('topmenu','Manage School');
   	}
   	$dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
   	$modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=master&Itemid='.$masterItemid);

  	$atlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=terms&view=terms&task=display&Itemid='.$atItemid);


?>
<!--
TOP LINKS....DASHBOARD
-->
<table width="100%" cellpadding="10">
        <tr style="border:none;">
                <td style="border:none;" align="left">
        <div style="float:left;">
           <img src="<?php echo $iconsDir.'/addterm.png'; ?>" alt="" style="width: 64px; height: 64px;" />
        </div>
        <div style="float:left;">
                <div>&nbsp;</div>
                <h1 class="item-page-title">Add/Edit Academic Term</h1>
        </div>
                       <div style="float:right;"> <a href="<?php echo $dashboardlink; ?>"><img src="<?php echo $iconsDir1.'/1dashboard.png'; ?>" alt="Dash Board" style="width: 32px; height: 32px;" /></a><br />
			</div>
			<div style="float:right; width:10px;"> &nbsp;</div>
			<div style="float:right;">
                        <a href="<?php echo $modulelink; ?>"><img src="<?php echo $iconsDir1.'/1master.png'; ?>" alt="Master" style="width: 32px; height: 32px;" /></a><br />
			</div>
			<div style="float:right; width:10px;"> &nbsp;</div>
			<div style="float:right;">
                        <a href="<?php echo $atlink; ?>"><img src="<?php echo $iconsDir.'/terms.jpg'; ?>" alt="Academic Terms" style="width: 32px; height: 32px;" /></a><br />
			</div>
                </td>
        </tr>
</table>


<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-edit"></i> Add Term</h2>
						<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
						</div>
					</div>
					<div class="box-content">
						<form action="<?php echo JRoute::_('index.php?option=com_cce&controller=academicyears&view=addacademicyear&task=save&id='.$this->rec->id.'&Itemid='.$Itemid) ?>" class="form-horizontal" method="POST"  name="addform" id="addform" onsubmit="return checkform()">				
						  <fieldset>
							   <div class="control-group">
								<label class="control-label" for="focusedInput">Code<span class="mandatory">*</span></label>
								<div class="controls">
								  <input class="input-xlarge focused" required="required" id="focusedInput" name="code" type="text" value="<?php echo $this->rec->code; ?>">
								</div>
							  </div>
							     <div class="control-group">
								<label class="control-label" for="focusedInput">Description<span class="mandatory">*</span></label>
								<div class="controls">
								  <input class="input-xlarge focused" required="required" id="focusedInput" name="term" type="text" value="<?php echo $this->rec->term; ?>">
								</div>
							  </div>
							
							<div class="control-group">
							  <label class="control-label" for="date01">Start Date<span class="mandatory">*</span></label>
							  <div class="controls">
								<input type="text" class="input-xlarge datepicker" required="required" id="date01" name="startdate" value="<?php echo $this->rec->startdate ?>">
							  </div>
							</div>
							<div class="control-group">
							  <label class="control-label" for="date01">End Date<span class="mandatory">*</span></label>
							  <div class="controls">
								<input type="text" class="input-xlarge datepicker" required="required" id="date02" name="stopdate" value="<?php echo $this->rec->stopdate ?>">
							  </div>
							</div>
							<div class="form-actions">
							  <button type="submit" class="btn btn-primary" name="Add" value="Add">Save</button>
							  <button type="reset" class="btn">Cancel</button>
							</div>
						  </fieldset>
						  
												  
							<input type="hidden" name="option" value="<?php echo JRequest::getVar('option'); ?>" />
							<input type="hidden" id="id" name="id" value="<?php echo $this->rec->id; ?>" />
							<input type="hidden" id="view" name="view" value="addterm" />
							<input type="hidden" id="aid" name="aid" value="<?php echo $this->rec->aid; ?>" />
							<input type="hidden" id="Itemid" name="Itemid" value="<?php echo $Itemid; ?>" />
							<input type="hidden" id="controller" name="controller" value="terms" />
							<input type="hidden" name="task" id="task" value="save" />
						</form>   

					</div>
				</div><!--/span-->

			</div><!--/row-->

</form>



