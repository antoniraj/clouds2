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
   	$busroutelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=transport&Itemid='.$masterItemid);
		$modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=vehicledetails&view=vehicledetails&layout=default&Itemid='.$masterItemid);
		$settings= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&layout=transportsettings&task=display&Itemid='.$atItemid);
	$driver= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=vehicledetails&view=vehicledetails&layout=default&task=display&Itemid='.$atItemid);


  	$atlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=terms&view=terms&task=display&Itemid='.$atItemid);


?>
<!--
TOP LINKS....DASHBOARD
-->
<table width="100%" cellpadding="10">
        <tr style="border:none;">
                <td style="border:none;" align="left">
        <div style="float:left;">
           <img src="<?php echo $iconsDir.'/vehicledetails.png'; ?>" alt="" style="width: 64px; height: 64px;" />
        </div>
        <div style="float:left;">
                <div>&nbsp;</div>
                <h1 class="item-page-title">Add/Edit Vehicle details</h1>
        </div>
                       <div style="float:right;"> <a href="<?php echo $dashboardlink; ?>"><img src="<?php echo $iconsDir1.'/1dashboard.png'; ?>" alt="Dash Board" style="width: 32px; height: 32px;" /></a><br />
			</div>
			<div style="float:right; width:10px;"> &nbsp;</div>
			<div style="float:right;">
                        <a href="<?php echo $busroutelink; ?>"><img src="<?php echo $iconsDir1.'/1transport.png'; ?>" alt="Master" style="width: 32px; height: 32px;" /></a><br />
			</div>
			 <div style="float:right; width:10px;"> &nbsp;</div>
			<div style="float:right;">
                        <a href="<?php echo $settings; ?>"><img src="<?php echo $iconsDir1.'/settings.png'; ?>" alt="Academic Terms" style="width: 32px; height: 32px;" /></a><br />
			</div>
             <div style="float:right; width:10px;"> &nbsp;</div>
			<div style="float:right;">
                        <a href="<?php echo $driver; ?>"><img src="<?php echo $iconsDir.'/vehicledetails.png'; ?>" alt="Academic Terms" style="width: 32px; height: 32px;" /></a><br />
			</div>
                </td>
        </tr>
</table>


<br />
<form action="index.php" method="POST" name="addform" id="addform" onSubmit="return stest()">
	<table>
		<tr style="border:none;" >
			<td style="border:none;" >Vehicle Number</td>
			<td style="border:none;" >
				<input type="text"  name="vno" size="32" required="required"	 value="<?php echo $this->rec->vno; ?>" />
			</td>
		</tr>
		<tr style="border:none;" >
                        <td style="border:none;" >Vehicle Code</td>
                        <td style="border:none;" >
                                <input type="text" id="cost" name="vcode" size="32"  required="required" value="<?php echo $this->rec->vcode; ?>" />
                        </td>
                </tr>


        <tr style="border:none;" >
                        <td style="border:none;" >No of Seats</td>
                        <td style="border:none;" >
                                <input type="text" id="cost" name="noofseats" size="32"  required="required" value="<?php echo $this->rec->noofseats; ?>" />
                        </td>
        </tr>
        <tr style="border:none;" >
                        <td style="border:none;" >Max. Allowed</td>
                        <td style="border:none;" >
                                <input type="text" id="cost" name="max_seats" size="32"  required="required" value="<?php echo $this->rec->max_seats; ?>" />
                        </td>
        </tr>
        <tr style="border:none;" >
                        <td style="border:none;" >Vehicle Type</td>
                        <td style="border:none;" >
                             <select name="vtype">
                                    <option value="0">Please Select Option</option>
                                    <option value="Contract" <?php if($this->rec->vtype=="Contract") echo 'selected="selected"'; ?> >Contract</option>
                                    <option value="Ownership" <?php if($this->rec->vtype=="Ownership") echo 'selected="selected"'; ?> >Ownership</option>
                               </select>
                         </td>
        </tr>
        <tr style="border:none;" >
                        <td style="border:none;" >Address</td>
                        <td style="border:none;" >
                                <textarea name="address" cols="25"><?php echo $this->rec->address; ?></textarea>
                        </td>
        </tr>
        <tr style="border:none;" >
                        <td style="border:none;" >City</td>
                        <td style="border:none;" >
                                <input type="text" id="cost" name="city" size="32"   value="<?php echo $this->rec->city; ?>" />
                        </td>
        </tr>
         <tr style="border:none;" >
                        <td style="border:none;" >State</td>
                        <td style="border:none;" >
                                <input type="text" id="cost" name="state" size="32"  value="<?php echo $this->rec->state; ?>" />
                        </td>
        </tr>
         <tr style="border:none;" >
                        <td style="border:none;" >Phone</td>
                        <td style="border:none;" >
                                <input type="text" id="cost" name="phone" size="32" value="<?php echo $this->rec->phone; ?>" />
                        </td>
        </tr>
        <tr style="border:none;" >
                        <td style="border:none;" >Insurance</td>
                        <td style="border:none;" >
                                <input type="text" id="cost" name="Insurance" size="32"  value="<?php echo $this->rec->Insurance; ?>" />
                        </td>
        </tr>
         <tr style="border:none;" >
                        <td style="border:none;" >Tax Remitted</td>
                        <td style="border:none;" >
                                <input type="text" id="cost" name="tax" size="32"  value="<?php echo $this->rec->tax; ?>" />
                        </td>
        </tr>
         </tr>
         <tr style="border:none;" >
                        <td style="border:none;" >Permit</td>
                        <td style="border:none;" >
                                <input type="text" id="cost" name="permit" size="32"  value="<?php echo $this->rec->permit; ?>" />
                        </td>
        </tr>
                
                <tr style="border:none;" >
                        <td style="border:none;" >Status</td>
                        <td style="border:none;" >
                              <?php 
							  		if($this->rec->status=="Active")
							  		{
							  	 		 
							     echo '<input type="radio"  name="status" required="required" checked="checked"  value="Active" />Active';
								 echo '<input type="radio"  name="status" required="required"  value="Inactive" />Inactive';
									}
									else if($this->rec->status=="Inactive"){
								echo '<input type="radio"  name="status" required="required"  value="Active" />Active';	
								echo '<input type="radio"  name="status" required="required" checked="checked" value="Inactive" />Inactive
			    ';
									}
									else{
										echo '<input type="radio"  name="status" required="required" checked="checked" value="Active" />Active
			    				<input type="radio"  name="status" required="required"  value="Inactive" />Inactive
			    ';		
									}
							  
							  ?>
								
                          </td>
                </tr>
                <tr style="border:none;" >
                        <td style="border:none;" >Vehicle color</td>
                        <td style="border:none;" >
                                <input type="text" id="cost" name="color" size="32"  required="required" value="<?php echo $this->rec->color; ?>" />
                        </td>
                </tr>
                
                
		<tr style="border:none;" ><td style="border:none;" ></td><td style="border:none;" ><input type="submit" class="button_save" value="Save" id="submit" name="submit" /></td></tr>
        
	</table>
	<input type="hidden" name="option" value="<?php echo JRequest::getVar('option'); ?>" />
	<input type="hidden" id="id" name="id" value="<?php echo $this->rec->id; ?>" />
	<input type="hidden" id="aid" name="aid" value="<?php echo $this->rec->aid; ?>" />
	<input type="hidden" id="view" name="view" value="vehicledetails" />
	<input type="hidden" id="controller" name="controller" value="vehicledetails" />
	<input type="hidden" name="Itemid" id="Itemid" value="<?php echo $Itemid; ?>" />
	<input type="hidden" name="task" id="task" value="save" />
    <input type="hidden" name="layout" id="layout" value="addvehicle" />
</form>
