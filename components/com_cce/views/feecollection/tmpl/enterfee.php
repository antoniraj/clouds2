<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	$Itemid = JRequest::getVar('Itemid');
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHtml::stylesheet('transport.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');

	$iconsDir1 = JURI::base() . 'components/com_cce/images';

   	$model = & $this->getModel('cce');
     	$stored = JRequest::getVar('storedid');
     $date = JRequest::getVar('date');
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
		$feecollection= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=feecollection&view=feecollection&layout=default&task=display&Itemid='.$atItemid);
	$driver= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=vehicledetails&view=vehicledetails&layout=default&task=display&Itemid='.$atItemid);


  	$atlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=terms&view=terms&task=display&Itemid='.$atItemid);


?>
<!--
TOP LINKS....DASHBOARD
-->
<table width="100%" cellpadding="0">
        <tr style="border:none;">
                <td style="border:none;" align="left">
        <div style="float:left;">
           <img src="<?php echo $iconsDir1.'/feecollection.png'; ?>" alt="" style="width: 64px; height: 64px;" />
        </div>
        <div style="float:left;">
                <div>&nbsp;</div>
                <h1 class="item-page-title">Pay Fee</h1>
        </div>
                       <div style="float:right;"> <a href="<?php echo $dashboardlink; ?>"><img src="<?php echo $iconsDir1.'/1dashboard.png'; ?>" alt="Dash Board" style="width: 32px; height: 32px;" /></a><br />
			</div>
			<div style="float:right; width:10px;"> &nbsp;</div>
			<div style="float:right;">
                        <a href="<?php echo $busroutelink; ?>"><img src="<?php echo $iconsDir1.'/1transport.png'; ?>" alt="Master" style="width: 32px; height: 32px;" /></a><br />
			</div>
			 <div style="float:right; width:10px;"> &nbsp;</div>
			<div style="float:right;">
                        <a href="<?php echo $feecollection; ?>"><img src="<?php echo $iconsDir1.'/feecollection.png'; ?>" alt="Academic Terms" style="width: 32px; height: 32px;" /></a><br />
			</div>
                </td>
        </tr>
</table>


<br />
<?php
			
				 $fee = $model->getfeestudents($stored);
				 $students=$model->fee_getstudent($fee->st_id); 
				 $vehicles = $model->fee_getvehicle($fee->vid);
				 $pay = $model->showtransmonths($date);
				 $stops = $model->fee_getstops($fee->stopid);
				  $course=$model->getStudentClass($fee->st_id,$recs);
				  
?>


<div style="margin-left:280px;">	
<div id="month">
		<div id="logo">
		
	      	<h3 style="float:right;margin-top:10px;"><span style="color:#000;">Date: </span><?php echo JArrayHelper::indianDate($date); ?></h3>
		</div>
	  
</div>
</div>
<form action="index.php" method="POST" name="addform" id="addform" onSubmit="return stest()">
<div class="enterfee">
	<div class="first">
<table>	
		<?php
					echo '<tr><td><pre>Name   :</td><td>'.$students->firstname.'</pre></td></tr>';
				echo '<tr><td><pre>Reg.No :</td><td>'.$students->registerno.'</pre></td></tr>';
				echo '<tr><td><pre>Gender :</td><td>'.$students->gender.'</pre></td></tr>';
				echo '<tr><td><pre>Mobile :</td><td>'.$students->mobile.'</pre></td></tr>';
				 
		?>
</table>

<div class="third">
     <table>
     <tr>
     <th>Stop Name</th><th>Marning Arrival</th><th>Evening Arrival</th></tr>
         <?php
				
				echo '<tr><td>'.$stops->stopname.'</td>';
				echo '<td>'.$stops->m_arrival.'</td>';
				echo '<td>'.$stops->e_arrival.'</td></tr>';
				 
		?>
		
		</table>
   <div align="left" style="margin-top:20px;"><table><tr><td>Amount :</td><td><input type="text" value="<?php echo $stops->fare; ?>" name="amount" /></td></tr></table></div>
   
	<div align="right" style="margin-top:20px;"><input type="submit"class="button_save" value="Pay" id="submit" name="submit" /></div>
</div>
	
</div>
<div class="second">

<table>	
		<?php
				
				echo '<tr><td><pre>Joined Date :</td><td>'.$fee->date.'</pre></td></tr>';
				echo '<tr><td><pre>Class       :</td><td>'.$recs->code.'</pre></td></tr>';
				echo '<tr><td><pre>Address     :</td><td>'.$students->addressline2.'</pre></td></tr>';
				echo '<tr><td><pre>City        :</td><td>'.$students->city.'</pre></td></tr>';
		?>
</table>

</div>
</div>
	
	<input type="hidden" name="option" value="<?php echo JRequest::getVar('option'); ?>" />
	<input type="hidden" id="id" name="id" value="<?php echo $this->rec->id; ?>" />
	<input type="hidden" id="stored" name="stored" value="<?php echo $stored; ?>" />
	<input type="hidden" id="date" name="date" value="<?php echo $date; ?>" />
	<input type="hidden" id="view" name="view" value="feecollection" />
	<input type="hidden" id="controller" name="controller" value="feecollection" />
	<input type="hidden" name="Itemid" id="Itemid" value="<?php echo $Itemid; ?>" />
	<input type="hidden" name="task" id="task" value="save" />
    <input type="hidden" name="layout" id="layout" value="enterfee" />
</form>
