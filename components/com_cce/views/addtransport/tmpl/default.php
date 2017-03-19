
<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	$Itemid = JRequest::getVar('Itemid');
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');
	JHTML::script('validate.js', 'components/com_cce/js/');
    JHTML::script('jquery.js', 'components/com_cce/js/');
	$namekey = JRequest::getVar('id');
	$name = JRequest::getVar('name');
   
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
		$modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=vehicledetails&view=vehicledetails&Itemid='.$masterItemid);

  	$atlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=terms&view=terms&task=display&Itemid='.$atItemid);


?>

<script language="javascript">
  	function myFunction()
	{ 
			
			var x = document.getElementById("route").selectedIndex;
			var val =document.getElementsByTagName("option")[x].value;
			var clientList = document.getElementById("dropdown2");
			clientList.options.length = 0;
			url = 'http://localhost/Addon/transport.php?route='+val;
			bus = 'http://localhost/Addon/bus.php?route='+val;

			$.post( url, function( data ) {
				var str = data;
				var str_array = str.split(',');

				var select = document.getElementById('dropdown2');
				for(var i=0; i<str_array.length-1; i++)
				{
				   	
  					select.options[i] = new Option(str_array[i], str_array[i]);  //new Option("Text", "Value")
					
					}
				});
			$.post( bus, function( data ) {
				var arr = data.split(',');

				var sel = document.getElementById('vehicle');
				for(var i=0; i<arr.length-1; i++)
				{
				   	
  					sel.options[i] = new Option(arr[i], arr[i]);  //new Option("Text", "Value")
					
					}
				});
	}
</script>
<script language="javascript">
	function myFunction()
	{ 
			
			var x = document.getElementById("route").selectedIndex;
			var val =document.getElementsByTagName("option")[x].value;
			var clientList = document.getElementById("dropdown2");
			clientList.options.length = 0;
			url = 'http://localhost/Addon/transport.php?route='+val;

			$.post( url, function( data ) {
				var str = data;
				var str_array = str.split(',');

				var select = document.getElementById('dropdown2');
				for(var i=0; i<str_array.length-1; i++)
				{
				   	
  					select.options[i] = new Option(str_array[i], str_array[i]);  //new Option("Text", "Value")
					
					}
				});
		
	}
</script>
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
                        <a href="<?php echo $modulelink; ?>"><img src="<?php echo $iconsDir.'/vehicledetails.png'; ?>" alt="Academic Terms" style="width: 32px; height: 32px;" /></a><br />
			</div>
                </td>
        </tr>
</table>


<br />
<form action="index.php" method="POST" name="addform" id="addform" onSubmit="return stest()">
	<table>
		<tr style="border:none;" >
			<td style="border:none;" >Username</td>
			<td style="border:none;" >
				<input type="text"  name="uname" size="32"  value="<?php echo $name ?>" readonly />
			</td>
		</tr>
		
        <tr style="border:none;" >
			<td style="border:none;" >Route</td>
			<td style="border:none;" >
         <select name="vid">
          <option value="0">Please Select Option</option>
          <?php foreach($this->stops as $stop) {  ?>
         	 <option value="<?php echo $stop->id; ?>" <?php if($this->rec->sid==$stop->id) echo 'selected="selected"'; ?> ><?php echo $stop->stopname; ?></option>
          <?php }?>
          
        </select>
			</td>
		</tr>
        <tr style="border:none;" >
                        <td style="border:none;" >Destination</td>
                        <td style="border:none;" >
                                <select id="dropdown2">
                                  <option value="select">...Select Destination...</option>
								</select>
                        </td>
                </tr>
        <tr style="border:none;" >
                        <td style="border:none;" >Vehicle</td>
                        <td style="border:none;" >
                               <select name="vehicle" id="vehicle">
            			
          					  </select>
                        </td>
                </tr>
          
                <tr style="border:none;" >
                        <td style="border:none;" >Fare</td>
                        <td style="border:none;" >
                                <input type="text" id="cost" name="color" size="32"  required="required" value="<?php echo $this->rec->color; ?>" />
                        </td>
                </tr>
                
                
		<tr style="border:none;" ><td style="border:none;" ></td><td style="border:none;" ><input type="submit" class="button_save" value="Save" id="submit" name="submit" /></td></tr>
        
	</table>
	<input type="hidden" name="option" value="<?php echo JRequest::getVar('option'); ?>" />
	<input type="hidden" id="id" name="id" value="<?php echo $this->rec->id; ?>" />
	<input type="hidden" id="aid" name="aid" value="<?php echo $this->rec->aid; ?>" />
	<input type="hidden" id="view" name="view" value="addvehicledetails" />
	<input type="hidden" id="controller" name="controller" value="vehicledetails" />
	<input type="hidden" name="Itemid" id="Itemid" value="<?php echo $Itemid; ?>" />
	<input type="hidden" name="task" id="task" value="save" />
</form>
