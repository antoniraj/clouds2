<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	$Itemid = JRequest::getVar('Itemid');
	$sid = JRequest::getVar('sid');
	
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');
    $namekey = JRequest::getVar('namekey');
    
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
		$routeimage= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=setroute&Itemid='.$atItemid);


  	$allotment= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=studentprofile&view=studentprofile&layout=transportdetails&task=display&Itemid='.$atItemid);


?>
<!--
TOP LINKS....DASHBOARD
-->

<table width="100%" cellpadding="10">
  <tr style="border:none;">
    <td style="border:none;" align="left"><div style="float:left;"> <img src="<?php echo $iconsDir1.'/listroutes.jpg'; ?>" alt="" style="width: 64px; height: 64px;" /> </div>
      <div style="float:left;">
        <div>&nbsp;</div>
        <h1 class="item-page-title">Transport Route Details</h1>
      </div>
      <div style="float:right;"> <a href="<?php echo $dashboardlink; ?>"><img src="<?php echo $iconsDir1.'/1dashboard.png'; ?>" alt="Dash Board" style="width: 32px; height: 32px;" /></a><br />
      </div>
      <div style="float:right; width:10px;"> &nbsp;</div>
      <div style="float:right;"> <a href="<?php echo $busroutelink; ?>"><img src="<?php echo $iconsDir1.'/1transport.png'; ?>" alt="Master" style="width: 32px; height: 32px;" /></a><br />
      </div>
      
      </td>
  </tr>
</table>
<br />
<form action="" method="POST" name="addform" id="addform">

  <div style="float: right;">
    <div style="float:right;"> Enter a portion of the stop Name:
      <input type="text" name="namekey" id="namekey" onChange="submit();" value="<?php echo $namekey; ?>" />
      <input type="submit" class="button_go" value="Search" name="search" />
    </div>
  </div>
 	<input type="hidden" id="Itemid" name="Itemid" value="<?php echo $Itemid; ?>" />
	<input type="hidden" id="controller" name="controller" value="studentprofile" />
	<input type="hidden" id="view" name="view" value="studentprofile" />
	<input type="hidden" name="task" id="task" value="display" />
</form>
<br />
<br />
<form action="<?php echo JRoute::_('index.php?option=com_cce&controller=allotstudent&view=allotstudent&layout=searchstudent&task=display&Itemid='.$courseItemid); ?>" method="POST" name="adminForm">

<br />
<br />
<table>
  <tr>
    <th class="list-title">Destination</th>
    <th class="list-title">Stop Name</th>
    <th class="list-title">Vehicle Code</th>
    <th class="list-title">Fare</th>
    <th class="list-title">Available Seats</th>
     <th class="list-title">No of Students</th>
    <th class="list-title">Marning Arrival</th>
    <th class="list-title">Evening Arrival</th>

  </tr>
  <?php
		if($this->routes){
		   $sno=1;
                   foreach($this->routes as $rec) {
				 	 
          
	   $vehicle = $model->getvehicle($rec->vid); 
	   $stops = $model->getStops($rec->id);
	    $c_seats = $model->countseats($vehicle->id);
		$available=(int)$vehicle->max_seats - $c_seats->co;
			foreach($stops as $stop)
			{ 
                  $check=43;
				
				  $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=allotstudent&controller=allotstudent&layout=searchstudent&task=display&a_seats='.$available.'&vid='.$vehicle->id.'&stopid='.$stop->id.'&did='.$rec->id,false);
                  $c_student = $model->getcountstudent($vehicle->id,$stop->id);
				   $cou=(int)count($c_student)-1;
			       echo "<tr style='height:30px;'>";
				   echo "<td>$rec->route</td>";
				   echo '<td><h4 style="">'.$stop->stopname.'</h4></td>';
				   echo '<td>'.$vehicle->vcode.'</td>';
				   echo '<td>'.$stop->fare.'</td>';
				   echo '<td align="center" style="color:#2d9c5c;">'.$available.'</td>';
				   echo '<td align="center">'.$c_student->c_stud.'</td>';
					echo '<td>'.$stop->m_arrival.'</td>';
					echo '<td>'.$stop->e_arrival.'</td>';
				   echo '</tr>';
 
				   
			}
			echo '<tr> </tr>';
			?>
  <?php 
		  }
		}else{?>
  <tr>
    <td colspan="13" align="center">... No details .... </td>
  </tr>
  <?php }
	 ?>
</table>
 </form>