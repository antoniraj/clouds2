<?php
// No direct access
   defined('_JEXEC') OR DIE('Access denied..');
   $app = JFactory::getApplication();
   $iconsDir = JURI::base() . 'components/com_cce/images/64x64';
   $iconsDir1 = JURI::base() . 'components/com_cce/images';

	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');

   $model = & $this->getModel('cce');
  $model = & $this->getModel('cce');
   $this->assignRef( 'model', $model);
   $Itemid=JRequest::getVar('Itemid');
   $app =& JFactory::getApplication();
   $pathway =& $app->getPathway();
   $pathway->addItem('Timetable');
   $dashboardItemid = $model->getMenuItemid('topmenu','Portal');
   if($dashboardItemid) ;
   else{
   	$dashboardItemid = $model->getMenuItemid('manageschool','Home');	
   }
   $timetableItemid = $model->getMenuItemid('master','TimeTable');
   if($timetableItemid) ;
   else{
   	$timetableItemid = $model->getMenuItemid('topmenu','Portal');	
   }

//Sessions 
   $sessionsItemid = $model->getMenuItemid('assignments','Sessions');
   if($sessionsItemid) ;
   else{
   	$sessionsItemid = $model->getMenuItemid('topmenu','Portal');	
   }
//Create Week Days
   $daycategoryItemid = $model->getMenuItemid('master','Day Category');
   if($daycategoryItemid) ;
   else{
   	$daycategoryItemid = $model->getMenuItemid('topmenu','Portal');	
   }

//Create Time Table
   $createtimetableItemid = $model->getMenuItemid('assignments','Create Time Table');
   if($createtimetableItemid) ;
   else{
   	$createtimetableItemid = $model->getMenuItemid('topmenu','Portal');	
   }

//View Class Time Tables
   $classtimetableItemid = $model->getMenuItemid('master','View Class Time Table');
   if($classtimetableItemid) ;
   else{
   	$classtimetableItemid = $model->getMenuItemid('topmenu','Portal');	
   }

//View Teacher Time Tables
   $teachertimetableItemid = $model->getMenuItemid('master','View Teacher Time Table');
   if($teachertimetableItemid) ;
   else{
   	$teachertimetableItemid = $model->getMenuItemid('topmenu','Portal');	
   }



//View Institutional Time Table 
   $institutetimetableItemid = $model->getMenuItemid('master','View Institutional Time Table');
   if($instituetimetableItemid) ;
   else{
   	$institutetimetableItemid = $model->getMenuItemid('topmenu','Portal');	
   }



//Home
   $dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);

//Inputs for time table
   $sessionslink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=timetable&view=timetable&task=display&layout=sessioncategory&Itemid='.$sessionsItemid);
   $termlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=timetableterms&view=timetableterms&task=display&Itemid='.$sessionsItemid);
   $daycategorylink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=timetable&view=timetable&task=display&layout=daycategory&Itemid='.$daycategoryItemid);
   $createtimetablelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=timetable&view=timetable&task=display&layout=createtimetable&Itemid='.$createtimetableItemid);
   $workloadlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=timetable&view=timetable&task=display&layout=workload&Itemid='.$createtimetableItemid);
   $generatetimetablelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=timetable&view=timetable&task=display&layout=generatetimetable&Itemid='.$createtimetableItemid);

//Reports
   $classtimetablelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=timetable&view=timetable&task=display&layout=classtimetable&Itemid='.$classtimetableItemid);
   $teachertimetablelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=timetable&view=timetable&task=display&layout=teachertimetable&Itemid='.$teachertimetableItemid);
   $institutetimetablelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=timetable&view=timetable&task=display&layout=institutetimetable&Itemid='.$institutetimetableItemid);

?>

<br />


<div align="center">
<div class="row-fluid">
<!--
				<div class="span3 show-grid">
				                  <a href="<?php echo $termlink; ?>"><img src="<?php echo $iconsDir.'/timetableterms.png'; ?>" alt="Terms" style="width: 84px; height: 84px;" /></a><br />
                        <a href="<?php echo $termlink; ?>"><h2 class="item-page-title">Terms</h2></a>
     
				</div>
-->
				<div class="span3 show-grid">
				               <a href="<?php echo $sessionslink; ?>"><img src="<?php echo $iconsDir.'/sessions.png'; ?>" alt="Subject Teacher" style="width: 84px; height: 84px;" /></a><br />
                        <a href="<?php echo $sessionslink; ?>"><h2 class="item-page-title">Sessions Types</h2></a>
        
				</div>
				<div class="span3 show-grid">
				              <a href="<?php echo $daycategorylink; ?>"><img src="<?php echo $iconsDir.'/weekdays.png'; ?>" alt="WeekDays" style="width: 84px; height: 84px;" /></a><br />
                        <a href="<?php echo $daycategorylink; ?>"><h2 class="item-page-title">Dayorder Types</h2></a>
          
				</div>
				<div class="span3 show-grid">
				              <a href="<?php echo $workloadlink; ?>"><img src="<?php echo $iconsDir1.'/constraints.png'; ?>" alt="Workload" style="width: 84px; height: 84px;" /></a><br />
                        <a href="<?php echo $workloadlink; ?>"><h2 class="item-page-title">Contraints</h2></a>
          
				</div>
				<div class="span3 show-grid">
				              <a href="<?php echo $generatetimetablelink; ?>"><img src="<?php echo $iconsDir.'/createtimetable.png'; ?>" alt="Generate Time Tables" style="width: 84px; height: 84px;" /></a><br />
                        <a href="<?php echo $generatetimetablelink; ?>"><h2 class="item-page-title">Generate Time Tables </h2></a>
          
				</div>
<!--
				<div class="span3 show-grid">
				              <a href="<?php echo $createtimetablelink; ?>"><img src="<?php echo $iconsDir.'/createtimetable.png'; ?>" alt="Create Time Tables" style="width: 84px; height: 84px;" /></a><br />
                        <a href="<?php echo $createtimetablelink; ?>"><h2 class="item-page-title">Create Time Tables </h2></a>
          
				</div>
-->
			</div>
			
			<div class="row-fluid">
				<div class="span3 show-grid">
				                <a href="<?php echo $classtimetablelink; ?>"><img src="<?php echo $iconsDir.'/classtimetable.png'; ?>" alt="ViewClassTimeTable" style="width: 84px; height: 84px;" /></a><br />
                        <a href="<?php echo $classtimetablelink; ?>"><h2 class="item-page-title">Class Time Table</h2></a>
        
				</div>
				<div class="span3 show-grid">
				             <a href="<?php echo $teachertimetablelink; ?>"><img src="<?php echo $iconsDir.'/teachertimetable.png'; ?>" alt="ViewTeacherTimeTable" style="width: 84px; height: 84px;" /></a><br />
                        <a href="<?php echo $teachertimetablelink; ?>"><h2 class="item-page-title">Teacher Time Table</h2></a>
           
				</div>
				<div class="span3 show-grid">
				            <a href="<?php echo $institutetimetablelink; ?>"><img src="<?php echo $iconsDir.'/institutetimetable.png'; ?>" alt="ViewInstituteTimeTable" style="width: 84px; height: 84px;" /></a><br />
                        <a href="<?php echo $institutetimetablelink; ?>"><h2 class="item-page-title">Institutional Time Table</h2></a>
            
				</div>
				
			</div>
			

<br>
<br>

<br>
<br>

<br>
</div>
