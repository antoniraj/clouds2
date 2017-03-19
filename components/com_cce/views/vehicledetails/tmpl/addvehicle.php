<?php



        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	$Dirhelp = JURI::base() . './components/com_cce/views';
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
   	$busroutelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=transport&Itemid='.$masterItemid);

  	$atlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=terms&view=terms&task=display&Itemid='.$atItemid);
     
  	$vehicledetails= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&layout=transportsettings&task=display&Itemid='.$atItemid);


  	$viewdetails= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=vehicledetails&view=vehicledetails&layout=default&task=display&Itemid='.$atItemid);



?>
<table width="100%" cellpadding="10">
        <tr style="border:none;">
                <td style="border:none;" align="left">
        <div style="float:left;">
           <img src="<?php echo $iconsDir.'/vehicledetails.png'; ?>" alt="" style="width: 64px; height: 64px;" />
        </div>
        <div style="float:left;">
                <div>&nbsp;</div>
                <h1 class="item-page-title">Vehicle Details</h1>
        </div>
                       <div style="float:right;"> <a href="<?php echo $dashboardlink; ?>"><img src="<?php echo $iconsDir1.'/1dashboard.png'; ?>" alt="Dash Board" style="width: 32px; height: 32px;" /></a><br />
			</div>
			<div style="float:right; width:10px;"> &nbsp;</div>
			<div style="float:right;">
                        <a href="<?php echo $busroutelink; ?>"><img src="<?php echo $iconsDir1.'/1transport.png'; ?>" alt="Master" style="width: 32px; height: 32px;" /></a><br />
			</div>
             <div style="float:right; width:10px;"> &nbsp;</div>
			<div style="float:right;">
                        <a href="<?php echo $vehicledetails; ?>"><img src="<?php echo $iconsDir1.'/settings.png'; ?>" alt="settings" style="width: 32px; height: 32px;" /></a><br />
			</div>
            <div style="float:right; width:10px;"> &nbsp;</div>
            <div style="float:right;">
                        <a href="<?php echo $viewdetails; ?>"><img src="<?php echo $iconsDir.'/vehicledetails.png'; ?>" alt="settings" style="width: 32px; height: 32px;" /></a><br />
			</div>

                </td>
        </tr>
</table>


			<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-edit"></i> Vehicle Details</h2>
						<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
						</div>
					</div>
					<div class="box-content">
							<form action="index.php" class="form-horizontal" method="POST" name="addform" id="addform" onSubmit="return stest()">
					
							<fieldset>
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Vehicle Number</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="focusedInput" type="text" name="vno" value="<?php echo $this->rec->vno; ?>">
								</div>
							  </div>
							   <div class="control-group">
								<label class="control-label" for="focusedInput">Vehicle Code</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="focusedInput" type="text" name="vcode" value="<?php echo $this->rec->vcode; ?>">
								</div>
							  </div>
							   <div class="control-group">
								<label class="control-label" for="focusedInput">No of Seats</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="focusedInput" type="text" name="noofseats" value="<?php echo $this->rec->noofseats; ?>">
								</div>
							  </div>
							  
							   <div class="control-group">
								<label class="control-label" for="focusedInput">Max. Allowed</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="focusedInput" type="text" name="max_seats" value="<?php echo $this->rec->max_seats; ?>">
								</div>
							  </div>
							  
							  
							 
							
							  <div class="control-group">
								<label class="control-label" for="selectError3">Plain Select</label>
								<div class="controls">
								  <select name="vtype" id="selectError" data-rel="chosen">
                                    <option value="0">Please Select Option</option>
                                    <option value="Contract" <?php if($this->rec->vtype=="Contract") echo 'selected="selected"'; ?> >Contract</option>
                                    <option value="Ownership" <?php if($this->rec->vtype=="Ownership") echo 'selected="selected"'; ?> >Ownership</option>
                               </select>
								</div>
							  </div>
							  <div class="control-group">
							  <label class="control-label" for="textarea2">Address</label>
							  <div class="controls">
								<textarea  name="address" id="textarea2" rows="4" cols="30"><?php echo $this->rec->address; ?></textarea>
							  </div>
							</div>
							  
							  
							 <div class="control-group">
								<label class="control-label" for="focusedInput">City</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="focusedInput" type="text" name="city" value="<?php echo $this->rec->city; ?>">
								</div>
							  </div>
							  <div class="control-group">
								<label class="control-label" for="focusedInput">State</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="focusedInput" type="text" name="state" value="<?php echo $this->rec->state; ?>">
								</div>
							  </div>
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Phone</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="focusedInput" type="text" name="phone" value="<?php echo $this->rec->phone; ?>">
								</div>
							  </div>
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Insurance</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="focusedInput" type="text" name="Insurance" value="<?php echo $this->rec->Insurance; ?>">
								</div>
							  </div>
						   <div class="control-group">
								<label class="control-label" for="focusedInput">Tax Remitted</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="focusedInput" type="text" name="tax" value="<?php echo $this->rec->tax; ?>">
								</div>
							  </div>
							   <div class="control-group">
								<label class="control-label" for="focusedInput">Permit</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="focusedInput" type="text" name="permit" value="<?php echo $this->rec->permit; ?>">
								</div>
								
								<div class="control-group">
								<label class="control-label">Status</label>
								<div class="controls">
								  <label class="radio">
									<input type="radio" name="status" <?php if($this->rec->status=="Active") echo 'checked="checked"'; ?> id="optionsRadios1" value="Active">
									Active
								  </label>
								  <div style="clear:both"></div>
								  <label class="radio">
									<input type="radio" name="status" <?php if($this->rec->status=="Inactive") echo 'checked="checked"'; ?> id="optionsRadios2" value="Inactive">
									Inactive
								  </label>
								</div>
							  </div>
							  </div>
							    <div class="control-group">
								<label class="control-label" for="focusedInput">Vehicle Color</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="focusedInput" type="text" name="color" value="<?php echo $this->rec->color; ?>">
								</div>
							  </div>

							  <div class="form-actions">
								<button type="submit" class="btn btn-primary" name="submit">Save</button>
								<button class="btn" name="cancel">Cancel</button>
							  </div>
							</fieldset>
							<input type="hidden" name="option" value="<?php echo JRequest::getVar('option'); ?>" />
							<input type="hidden" id="id" name="id" value="<?php echo $this->rec->id; ?>" />
							<input type="hidden" id="aid" name="aid" value="<?php echo $this->rec->aid; ?>" />
							<input type="hidden" id="view" name="view" value="vehicledetails" />
							<input type="hidden" id="controller" name="controller" value="vehicledetails" />
							<input type="hidden" name="Itemid" id="Itemid" value="<?php echo $Itemid; ?>" />
							<input type="hidden" name="task" id="task" value="save" />
							<input type="hidden" name="layout" id="layout" value="addvehicle" />	
													
						  </form>
					
					</div>
				</div><!--/span-->
			
			</div><!--/row-->
			
			
    
					<!-- content ends -->
			</div><!--/#content.span10-->
				</div><!--/fluid-row-->
				
		<hr>



		<footer>
			
			<p class="pull-right">Powered by: <a href="http://usman.it/free-responsive-admin-template">Addon</a></p>
		</footer>
		
	</div>



