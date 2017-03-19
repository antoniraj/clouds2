<?php
// No direct access
   defined('_JEXEC') OR DIE('Access denied..');
   $app = JFactory::getApplication();
   $iconsDir = JURI::base() . 'components/com_cce/images/64x64';
   $iconsDir1 = JURI::base() . 'components/com_cce/images';

   $model = & $this->getModel('cce');
   $this->assignRef( 'model', $model);
   $Itemid=JRequest::getVar('Itemid');
   $app =& JFactory::getApplication();
   $pathway =& $app->getPathway();
   $pathway->addItem('Students');
   $dashboardItemid = $model->getMenuItemid('topmenu','Portal');
   if($dashboardItemid) ;
   else{
   	$dashboardItemid = $model->getMenuItemid('manageschool','Home');	
   }
   $studentsItemid = $model->getMenuItemid('manageschool','Students');
   if($studentsItemid) ;
   else{
   	$studentsItemid = $model->getMenuItemid('topmenu','Portal');	
   }
   $gItemid = $model->getMenuItemid('assignments','Group Members');
   if($gItemid) ;
   else{
   	$gItemid = $model->getMenuItemid('topmenu','Portal');	
   }
   $searchItemid = $model->getMenuItemid('manageschool','Students');
   if($searchItemid) ;
   else{
   	$searchItemid = $model->getMenuItemid('topmenu','Portal');	
   }
   
    $reportItemid = $model->getMenuItemid('master','Courses');
   if($reportItemid) ;
   else{
   	$reportItemid = $model->getMenuItemid('topmenu','Portal');	
   }
    $tc = $model->getMenuItemid('master','Courses');
   if($tc) ;
   else{
   	$tc = $model->getMenuItemid('topmenu','Portal');	
   }

   $dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);

   $studentcategorylink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=studentcategories&view=studentcategories&task=display&Itemid='.$studentsItemid);
   $studentslink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=students&view=students&task=display&Itemid='.$studentsItemid);
   $glink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=groupmembers&view=groupmembers&task=display&Itemid='.$gItemid);
   $searchlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=studentprofile&view=studentprofile&layout=search&task=display&Itemid='.$searchItemid);
   $reportlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=creports&view=showstudents&Itemid='.$reportItemid);
   $tc= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=studentstc&view=studentstc&layout=default&task=display&Itemid='.$tc);

?>


<br />
<div align="center">
	<div class="row-fluid">
				<div class="span3 show-grid">
				             <a href="<?php echo $studentcategorylink; ?>"><img src="<?php echo $iconsDir1.'/studentcategories.png'; ?>" alt="" style="width: 100px; height: 100px;" /></a><br />
                        <a href="<?php echo $studentcategorylink; ?>"><h2 class="item-page-title">Students Categories</h2></a>
           
				</div>
				<div class="span3 show-grid">
				            <a href="<?php echo $studentslink; ?>"><img src="<?php echo $iconsDir.'/admission.jpeg'; ?>" alt="Students" style="width: 100px; height: 100px;" /></a><br />
                        <a href="<?php echo $studentslink; ?>"><h2 class="item-page-title">Students List</h2></a>
            
				</div>
				<div class="span3 show-grid">
				             <a href="<?php echo $glink; ?>"><img src="<?php echo $iconsDir.'/membership.png'; ?>" alt="Group Members" style="width: 100px; height: 100px;" /></a><br />
                        <a href="<?php echo $glink; ?>"><h2 class="item-page-title">Students' Groups</h2></a>
           
				</div>
			<!--	<div class="span3 show-grid">
				            <a href="<?php echo $reportlink; ?>"><img src="<?php echo $iconsDir.'/studentreport.png'; ?>" alt="Students Report" style="width: 100px; height: 100px;" /></a><br />
                        <a href="<?php echo $reportlink; ?>"><h2 class="item-page-title">Students Report</h2></a>
            
				</div>
			</div>
            <div class="row-fluid">  -->

			</div>

<br>
</div>
