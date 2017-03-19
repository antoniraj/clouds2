<?php
// No direct access
   defined('_JEXEC') OR DIE('Access denied..');
   $app = JFactory::getApplication();
   $iconsDir = JURI::base() . 'components/com_cce/images/64x64';
   $iconsDir1 = JURI::base() . 'components/com_cce/images';

   $model = & $this->getModel('cce');
   $model = & $this->getModel('cce');
   $this->assignRef( 'model', $model);
   $Itemid=JRequest::getVar('Itemid');
   $app =& JFactory::getApplication();
   $pathway =& $app->getPathway();
   $pathway->addItem('Grades');
   $dashboardItemid = $model->getMenuItemid('topmenu','Portal');
   if($dashboardItemid) ;
   else{
   	$dashboardItemid = $model->getMenuItemid('manageschool','Home');	
   }
   $courseItemid = $model->getMenuItemid('master','Courses');
   if($courseItemid) ;
   else{
   	$courseItemid = $model->getMenuItemid('topmenu','Portal');	
   }

   $dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);

//Main
   $entermarkslink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=courses&view=showcourses&Itemid='.$courseItemid);
   $generatemarkslink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=classreports&view=coursereports&Itemid='.$courseItemid);
$promotionlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=promotion&view=promotion&task=display&layout=promotion&Itemid='.$Itemid);
   $promotionreportlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=promotion&view=promotion&task=display&layout=promotionreport&Itemid='.$Itemid);

//Normal Exams
   $normalexamslink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=tngradebook&view=tngradebook&Itemid='.$courseItemid);
   $normalgradeslink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=normalgrades&view=normalgrades&Itemid='.$courseItemid);

//CCE Settings
   $gradebooktemplatelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=tgradebook&view=tgradebook&Itemid='.$courseItemid);
   $faactivitieslink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=faactivities&view=faactivities&Itemid='.$courseItemid);
   $fagradeslink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=fagrades&view=fagrades&Itemid='.$courseItemid);
   $lsactivitieslink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=lsactivities&view=lsactivities&Itemid='.$courseItemid);
   $csaalink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=coscholasticaactivities&view=coscholasticaactivities&Itemid='.$courseItemid);
   $csbalink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=coscholasticbactivities&view=coscholasticbactivities&Itemid='.$courseItemid);
   $avlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=attitudesandvalues&view=attitudesandvalues&Itemid='.$courseItemid);
   $sbgradeslink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=scholasticbgrades&view=scholasticbgrades&Itemid='.$courseItemid);
   $hallticketlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=hallticket&view=hallticket&Itemid='.$courseItemid);
   $timetablelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=sms&view=sms&layout=examtimetable&task=displayexamtimetable&flag=exam&Itemid='.$courseItemid);
?>

	<div align="center">
<div class="alert alert-warning" align="left">
<span class="mytitle">Marks and Grades</span>
</div>	
<div class="row-fluid">
				<div class="span3 show-grid">
				          <a href="<?php echo $entermarkslink; ?>"><img src="<?php echo $iconsDir1.'/entermarks.png'; ?>" alt="Enter Marks" style="width: 100px; height: 100px;" /></a><br />
                        <a href="<?php echo $entermarkslink; ?>"><h2 class="item-page-title">Enter Marks</h2></a>
          
				</div>
				<div class="span3 show-grid">
				
				              <a href="<?php echo $generatemarkslink; ?>"><img src="<?php echo $iconsDir1.'/generatemarks.png'; ?>" alt="Marks Reports" style="width: 100px; height: 100px;" /></a><br />
                        <a href="<?php echo $generatemarkslink; ?>"><h2 class="item-page-title">Grades</h2></a>
         
				</div>
	         <div class="span3 show-grid">
				        <a href="<?php echo $promotionlink; ?>"><img src="<?php echo $iconsDir1.'/promotion.png'; ?>" alt="" style="width: 108px; height: 100px;" /></a><br />
                        <a href="<?php echo $promotionlink; ?>"><h2 class="item-page-title">Promotion & Transfer</h2></a>
				</div>
				<div class="span3 show-grid">
				              <a href="<?php echo $promotionreportlink; ?>"><img src="<?php echo $iconsDir1.'/promotionreport.png'; ?>" alt="" style="width: 100px; height: 100px;" /></a><br />
                        <a href="<?php echo $promotionreportlink; ?>"><h2 class="item-page-title">Promotion Report</h2></a>
				</div> 
</div>
<div class="alert alert-warning" align="left">
<span class="mytitle">Normal Exam Settings</span>
</div>

<div class="row-fluid">
				<div class="span3 show-grid">
					<a href="<?php echo $normalexamslink; ?>"><img src="<?php echo $iconsDir1.'/normalexams.png'; ?>" alt="Normal Exams" style="width: 100px; height: 100px;" /></a><br />
	                        	<a href="<?php echo $normalexamslink; ?>"><h2 class="item-page-title">Examinations</h2></a>
				</div>
				<div class="span3 show-grid">
					<a href="<?php echo $timetablelink; ?>"><img src="<?php echo $iconsDir1.'/examtimetable.png'; ?>" alt="Normal Exam Grades" style="width: 100px; height: 100px;" /></a><br />
                        		<a href="<?php echo $timetablelink; ?>"><h2 class="item-page-title">Exam Time Table</h2></a>
				</div>
				<div class="span3 show-grid">
					<a href="<?php echo $hallticketlink; ?>"><img src="<?php echo $iconsDir1.'/hallticket.png'; ?>" alt="Normal Exam Grades" style="width: 100px; height: 100px;" /></a><br />
                        		<a href="<?php echo $hallticketlink; ?>"><h2 class="item-page-title">Hall Ticket</h2></a>
				</div>
				<div class="span3 show-grid">
					<a href="<?php echo $normalgradeslink; ?>"><img src="<?php echo $iconsDir1.'/normalgrades.png'; ?>" alt="Normal Exam Grades" style="width: 100px; height: 100px;" /></a><br />
                        		<a href="<?php echo $normalgradeslink; ?>"><h2 class="item-page-title">Grades Settings</h2></a>
				</div>
			</div>


<div class="alert alert-warning" align="left">
<span class="mytitle">CCE Examination Settings</span>
</div>
<div class="row-fluid">
				<div class="span3 show-grid">
				                <a href="<?php echo $gradebooktemplatelink; ?>"><img src="<?php echo $iconsDir1.'/gradebooktemplate.png'; ?>" alt="Grade Book Template" style="width: 64px; height: 64px;" /></a><br />
                        <a href="<?php echo $gradebooktemplatelink; ?>"><h2 class="item-page-title">Grade Book Template</h2></a>
        
				</div>
				<div class="span3 show-grid">
				             <a href="<?php echo $faactivitieslink; ?>"><img src="<?php echo $iconsDir1.'/faactivities.png'; ?>" alt="FA Activities" style="width: 64px; height: 64px;" /></a><br />
                        <a href="<?php echo $faactivitieslink; ?>"><h2 class="item-page-title">FA Activities</h2></a>
           
				</div>
				<div class="span3 show-grid">
				            <a href="<?php echo $fagradeslink; ?>"><img src="<?php echo $iconsDir1.'/fagrades.png'; ?>" alt="FA Grades" style="width: 64px; height: 64px;" /></a><br />
                        <a href="<?php echo $fagradeslink; ?>"><h2 class="item-page-title">FA Grades</h2></a>
            
				</div>
				<div class="span3 show-grid">
				             <a href="<?php echo $lsactivitieslink; ?>"><img src="<?php echo $iconsDir1.'/lifeskills.png'; ?>" alt="Life Skills" style="width: 64px; height: 64px;" /></a><br />
                        <a href="<?php echo $lsactivitieslink; ?>"><h2 class="item-page-title">Life Skills</h2></a>
           
				</div>
			</div>
<div class="row-fluid">
				<div class="span3 show-grid">
				           <a href="<?php echo $avlink; ?>"><img src="<?php echo $iconsDir1.'/attitudeandvalues.png'; ?>" alt="Attitude and Values" style="width: 64px; height: 64px;" /></a><br />
                        <a href="<?php echo $avlink; ?>"><h2 class="item-page-title">Attitude and Values</h2></a>
            
				</div>
				<div class="span3 show-grid">
				             <a href="<?php echo $csaalink; ?>"><img src="<?php echo $iconsDir1.'/csaa.png'; ?>" alt="Co-Scholastic-A Activities" style="width: 64px; height: 64px;" /></a><br />
                        <a href="<?php echo $csaalink; ?>"><h2 class="item-page-title">Co-Scholastic-A Activities</h2></a>
           
				</div>
				<div class="span3 show-grid">
				             <a href="<?php echo $csbalink; ?>"><img src="<?php echo $iconsDir1.'/csba.png'; ?>" alt="Co-Scholastic-B Activities" style="width: 64px; height: 64px;" /></a><br />
                        <a href="<?php echo $csbalink; ?>"><h2 class="item-page-title">Co-Scholastic-B Activities</h2></a>
          
				</div>
				<div class="span3 show-grid">
				           <a href="<?php echo $sbgradeslink; ?>"><img src="<?php echo $iconsDir1.'/sbgrades.png'; ?>" alt="Scholastic-B Grades" style="width: 64px; height: 64px;" /></a><br />
                        <a href="<?php echo $sbgradeslink; ?>"><h2 class="item-page-title">Scholastic-B Grades</h2></a>
             
				</div>

</div>
</div>
