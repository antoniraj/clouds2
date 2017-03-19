
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
		
		 	$modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=setroute&Itemid='.$atItemid);
             $transport= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=transport&view=transport&task=display&Itemid='.$atItemid);
			 
  	$settings= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&layout=transportsettings&task=display&Itemid='.$atItemid);
	$driver= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=driverdetails&view=driverdetails&layout=default&task=display&Itemid='.$atItemid);

 
  	$atlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=terms&view=terms&task=display&Itemid='.$atItemid);

?>
<script language="javascript">
  	function myFunction()
	{
			var x = document.getElementById("route").selectedIndex;
			var val =document.getElementsByTagName("option")[x].value;
			if(val == 'new')
			{
					document.getElementById("route").style.display = 'none';
					document.getElementById("area").style.display = 'block';
			}
	}
</script>
<!--
TOP LINKS....DASHBOARD
-->
<table width="100%" cellpadding="10">
        <tr style="border:none;">
                <td style="border:none;" align="left">
        <div style="float:left;">
           <img src="<?php echo $iconsDir1.'/driver.png'; ?>" alt="" style="width: 64px; height: 64px;" />
        </div>
        <div style="float:left;">
                <div>&nbsp;</div>
                <h1 class="item-page-title">Add/Edit Driver details</h1>
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
                        <a href="<?php echo $driver; ?>"><img src="<?php echo $iconsDir1.'/driver.png'; ?>" alt="Academic Terms" style="width: 32px; height: 32px;" /></a><br />
			</div>
                </td>
        </tr>
</table>


<br />
<form action="index.php" method="POST" name="addform" id="addform" onSubmit="return stest()">
	<table>
		<tr style="border:none;" >
			<td style="border:none;" >Firstname</td>
			<td style="border:none;" >
				<input type="text" id="destination" name="Fname" size="32" required="required"	 value="<?php echo $this->rec->Fname; ?>" />
			</td>
		</tr>
		<tr style="border:none;" >
                        <td style="border:none;" >Lastname</td>
                        <td style="border:none;" >
                                <input type="text" id="cost" name="Lname" size="32"  value="<?php echo $this->rec->Lname; ?>" />
                        </td>
                </tr>

        <tr style="border:none;" >
                        <td style="border:none;" >Address</td>
                        <td style="border:none;" >
                               <textarea name="address" cols="25"><?php echo $this->rec->address; ?></textarea>
                        </td>
                </tr>
             <tr style="border:none;" >
                        <td style="border:none;" >DOB</td>
                        <td style="border:none;" >
                               <?php
						$a=explode('-',$this->rec->dob);
						$idob="$a[2]-$a[1]-$a[0]";
						 echo JHTML::calendar($idob,'dob','dob','%d-%m-%Y'); 
						?>
                        </td>
                </tr>
                
            <tr style="border:none;" >
                        <td style="border:none;" >License No</td>
                        <td style="border:none;" >
                                <input type="text" id="cost" name="license" size="32"  value="<?php echo $this->rec->license; ?>" />
                        </td>
          </tr>
             <tr style="border:none;" >
                        <td style="border:none;" >Expiry Date</td>
                        <td style="border:none;" >
                               <?php
						$a=explode('-',$this->rec->Edate);
						$iadate="$a[2]-$a[1]-$a[0]";
						 echo JHTML::calendar($iadate,'Edate','Edate','%d-%m-%Y'); 
						?>
                        </td>
                </tr>
                
        <tr style="border:none;" ><td style="border:none;" ></td><td style="border:none;" ><input type="submit" class="button_save" value="Save" id="submit" name="submit" /></td></tr>
	</table>
	<input type="hidden" name="option" value="<?php echo JRequest::getVar('option'); ?>" />
	<input type="hidden" id="id" name="id" value="<?php echo $this->rec->id; ?>" />
	<input type="hidden" id="aid" name="aid" value="<?php echo $this->rec->aid; ?>" />
	<input type="hidden" id="view" name="view" value="driverdetails" />
	<input type="hidden" id="controller" name="controller" value="driverdetails" />
	<input type="hidden" name="Itemid" id="Itemid" value="<?php echo $Itemid; ?>" />
	<input type="hidden" name="task" id="task" value="save" />
    <input type="hidden" name="layout" id="layout" value="adddriver" />
</form>
