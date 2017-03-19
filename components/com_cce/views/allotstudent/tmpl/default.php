
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
	$namekey = JRequest::getVar('namekey');
	$searchstops =$model->searchStops($namekey);
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
    <td style="border:none;" align="left"><div style="float:left;"> <img src="<?php echo $iconsDir.'/student.jpeg'; ?>" alt="" style="width: 64px; height: 64px;" /> </div>
      <div style="float:left;">
        <div>&nbsp;</div>
        <h1 class="item-page-title">Transport Route Details</h1>
      </div>
      <div style="float:right;"> <a href="<?php echo $dashboardlink; ?>"><img src="<?php echo $iconsDir1.'/1dashboard.png'; ?>" alt="Dash Board" style="width: 32px; height: 32px;" /></a><br />
      </div>
      <div style="float:right; width:10px;"> &nbsp;</div>
      <div style="float:right;"> <a href="<?php echo $busroutelink; ?>"><img src="<?php echo $iconsDir1.'/1transport.png'; ?>" alt="Master" style="width: 32px; height: 32px;" /></a><br />
      </div>
      <div style="float:right; width:10px;"> &nbsp;</div>
      <div style="float:right;"> <a href="<?php echo $allotment; ?>"><img src="<?php echo $iconsDir1.'/allotment.png'; ?>" alt="settings" style="width: 32px; height: 32px;" /></a><br />
      </div></td>
  </tr>
</table>
<div class="row-fluid sortable">
  <div class="box span12">
    <div class="box-header well" data-original-title>
      <h2><i class="icon-edit"></i> Allot Route</h2>
      <div class="box-icon"> <a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a> <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a> </div>
    </div>
    <div class="box-content">
      <table class="table table-striped table-bordered bootstrap-datatable datatable">
        <thead>
          <tr>
            <th><span class="icon icon-color icon-triangle-ns"></span>Destination</th>
            <th><span class="icon icon-color icon-triangle-ns"></span>Stop Name</th>
            <th> <span class="icon icon-color icon-triangle-ns"></span>Vehicle Code</th>
            <th><span class="icon icon-color icon-triangle-ns"></span>Fare</th>
            <th><span class="icon icon-color icon-triangle-ns"></span>Available Seats</th>
            <th> <span class="icon icon-color icon-triangle-ns"></span>No of Students</th>
            <th> <span class="icon icon-color icon-triangle-ns"></span>Marning Arrival</th>
            <th> <span class="icon icon-color icon-triangle-ns"></span>Evening Arrival</th>
            <th><span class="icon icon-color icon-triangle-ns"></span>Operation</th>
          </tr>
        </thead>
        <tbody>
          <?php
         if($this->routes)
		   {    
           foreach($this->routes as $rec) {
         
	   $vehicle = $model->getvehicle($rec->vid); 
	   $stops = $model->getStops($rec->id);
	    $c_seats = $model->countseats($vehicle->id,$rec->id);
		$available=(int)$vehicle->max_seats - $c_seats->co;
				  $i=1;
			foreach($stops as $stop)
			{ 
                  $check=43;
		
				  $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=allotstudent&controller=allotstudent&layout=searchstudent&task=display&a_seats='.$available.'&vid='.$vehicle->id.'&stopid='.$stop->id.'&did='.$rec->id,false);
                  $c_student = $model->getcountstudent($vehicle->id,$stop->id);
				   $cou=(int)count($c_student)-1;
			       echo "<tr style='height:30px;'>";
				   echo "<td>$rec->route</td>";
				   echo '<td><h4 style=""><span style="color:green;">[stop '.$i.']  </span>'.$stop->stopname.'</h4></td>';
				   echo '<td>'.$vehicle->vcode.'</td>';
				   echo '<td>'.$stop->fare.'</td>';
				   echo '<td align="center" style="color:#2d9c5c;">'.$available.'</td>';
				   echo '<td align="center">'.$c_student->c_stud.'</td>';
					echo '<td>'.$stop->m_arrival.'</td>';
					echo '<td>'.$stop->e_arrival.'</td>';
  					echo  '<td><a class="btn btn-info" href="'.$redirectTo.'">';
					echo '<i class="icon icon-color icon-user"></i> Allot</a></td>';
				   echo '</tr>';
 		
					$i++;			   
			}
		   }
		   }
            
             ?>
        </tbody>
      </table>
    </div>
  </div>
  <!--/span--> 
  
</div>
<!--/row--> 

