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
	$fuel= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=fuelmanage&view=fuelmanage&layout=default&task=display&Itemid='.$atItemid);


  	$atlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=terms&view=terms&task=display&Itemid='.$atItemid);


?>
<!--
TOP LINKS....DASHBOARD
-->
<table width="100%" cellpadding="10">
        <tr style="border:none;">
                <td style="border:none;" align="left">
        <div style="float:left;">
           <img src="<?php echo $iconsDir1.'/fuel.png'; ?>" alt="" style="width: 64px; height: 64px;" />
        </div>
        <div style="float:left;">
                <div>&nbsp;</div>
                <h1 class="item-page-title">Add/Edit Fuel details</h1>
        </div>
                       <div style="float:right;"> <a href="<?php echo $dashboardlink; ?>"><img src="<?php echo $iconsDir1.'/1dashboard.png'; ?>" alt="Dash Board" style="width: 32px; height: 32px;" /></a><br />
			</div>
			<div style="float:right; width:10px;"> &nbsp;</div>
			<div style="float:right;">
                        <a href="<?php echo $busroutelink; ?>"><img src="<?php echo $iconsDir1.'/1transport.png'; ?>" alt="Master" style="width: 32px; height: 32px;" /></a><br />
			</div>

             <div style="float:right; width:10px;"> &nbsp;</div>
			<div style="float:right;">
                        <a href="<?php echo $fuel; ?>"><img src="<?php echo $iconsDir1.'/fuel.png'; ?>" alt="Academic Terms" style="width: 32px; height: 32px;" /></a><br />
			</div>
                </td>
        </tr>
</table>


<br />
<form action="index.php" method="POST" name="addform" id="addform" onSubmit="return stest()">
	<table>
		<tr style="border:none;" >
			<td style="border:none;" >Vehicle Code</td>
			 <td style="border:none;"><select name="vcode">
                        <option value="" selected="selected">...Select Vehicle...</option>
                              <?php foreach($this->vehicles as $veh) {  ?>
                                 <option value="<?php echo $veh->id; ?>" <?php if($this->rec->vcode==$veh->id) echo 'selected="selected"'; ?> ><?php echo $veh->vcode; ?></option>
                              <?php }?>                   
                          </select>
             </td>
   
		</tr>

        <tr style="border:none;" >
                        <td style="border:none;" >No of litres</td>
                        <td style="border:none;" >
                                <input type="text" id="cost" name="litres" size="32"  required="required" value="<?php echo $this->rec->litre; ?>" />
                        </td>
        </tr>
        <tr style="border:none;" >
                        <td style="border:none;" >Amount</td>
                        <td style="border:none;" >
                                <input type="text" id="cost" name="amount" size="32"  required="required" value="<?php echo $this->rec->amount; ?>" />
                        </td>
        </tr>
     
        <tr style="border:none;" >
                        <td style="border:none;" >date</td>
                         <td style="border:none;" >
                               <?php
						$a=explode('-',$this->rec->date);
						$idob="$a[0]-$a[1]-$a[2]";
						 echo JHTML::calendar($idob,'date','date','%y-%m-%d'); 
						?>
                        </td>
        </tr>

        
                
		<tr style="border:none;" ><td style="border:none;" ></td><td style="border:none;" ><input type="submit" class="button_save" value="Save" id="submit" name="submit" /></td></tr>
        
	</table>
	<input type="hidden" name="option" value="<?php echo JRequest::getVar('option'); ?>" />
	<input type="hidden" id="id" name="id" value="<?php echo $this->rec->id; ?>" />
	<input type="hidden" id="aid" name="aid" value="<?php echo $this->rec->aid; ?>" />
	<input type="hidden" id="view" name="view" value="fuelmanage" />
	<input type="hidden" id="controller" name="controller" value="fuelmanage" />
	<input type="hidden" name="Itemid" id="Itemid" value="<?php echo $Itemid; ?>" />
	<input type="hidden" name="task" id="task" value="save" />
    <input type="hidden" name="layout" id="layout" value="addfuel" />
</form>
