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
   $pathway->addItem('Master Settings','index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=master');
   $dashboardItemid = $model->getMenuItemid('topmenu','Portal');
   if($dashboardItemid) ;
   else{
   	$dashboardItemid = $model->getMenuItemid('manageschool','Home');	
   }
   $ayItemid = $model->getMenuItemid('master','Academic Years');
   if($ayItemid) ;
   else{
   	$ayItemid = $model->getMenuItemid('topmenu','Portal');	
   }
   $atItemid = $model->getMenuItemid('master','Academic Terms');
   if($atItemid) ;
   else{
   	$atItemid = $model->getMenuItemid('topmenu','Portal');	
   }
   $calItemid = $model->getMenuItemid('master','Calendar');
   if($calItemid) ;
   else{
   	$calItemid = $model->getMenuItemid('topmenu','Portal');	
   }
   $deptItemid = $model->getMenuItemid('master','Departments');
   if($deptItemid) ;
   else{
   	$deptItemid = $model->getMenuItemid('topmenu','Portal');	
   }
   $subItemid = $model->getMenuItemid('master','Manage Subjects');
   if($subItemid) ;
   else{
   	$subItemid = $model->getMenuItemid('topmenu','Portal');	
   }
   $groupItemid = $model->getMenuItemid('master','Student Groups');
   if($groupItemid) ;
   else{
   	$groupItemid = $model->getMenuItemid('topmenu','Portal');	
   }

   $dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);

   $aylink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=academicyears&view=academicyears&task=display&Itemid='.$ayItemid);
   $atlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=terms&view=terms&task=display&Itemid='.$atItemid);
   $callink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=schoolcal&view=schoolcal&task=display&Itemid='.$calItemid);
   $deptlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=departments&view=departments&task=display&Itemid='.$deptItemid);
   $sublink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=managesubjects&view=managesubjects&task=display&Itemid='.$subItemid);
   $grouplink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=groups&view=groups&task=display&Itemid='.$groupItemid);
   $schoolsetup= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=schoolsetup&Itemid='.$groupItemid);
  $courselink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=courses&view=courses&task=display&Itemid='.$courseItemid);
   $feeheadslink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=fees&view=fees&task=display&layout=feeheads&Itemid='.$feeItemid);
 
?>

<br>
<div align="center">
	<div class="row-fluid">
				<div class="span3 show-grid">
				         <a href="<?php echo $schoolsetup; ?>"><img src="<?php echo $iconsDir1.'/schoolsetup.png'; ?>" alt="School Setup" style="width: 100px; height: 100px;" /></a><br />
                        <a href="<?php echo $schoolsetup; ?>"><h2 class="item-page-title">School Setup</h2></a>
             
				</div>
				<div class="span3 show-grid">
				          <a href="<?php echo $aylink; ?>"><img src="<?php echo $iconsDir.'/academicyears.png'; ?>" alt="Academicyears" style="width: 100px; height: 100px;" /></a><br />
                        <a href="<?php echo $aylink; ?>"><h2 class="item-page-title">Academic Years</h2></a>
             
				</div>
				<div class="span3 show-grid">
				      <a href="<?php echo $atlink; ?>"><img src="<?php echo $iconsDir.'/terms.jpg'; ?>" alt="Academicterms" style="width: 100px; height: 100px;" /></a><br />
                        <a href="<?php echo $atlink; ?>"><h2 class="item-page-title">Academic Terms</h2></a>
                
				</div>
				<div class="span3 show-grid">
				          <a href="<?php echo $deptlink; ?>"><img src="<?php echo $iconsDir.'/departments.jpg'; ?>" alt="Departments" style="width: 100px; height: 100px;" /></a><br />
                        <a href="<?php echo $deptlink; ?>"><h2 class="item-page-title">Departments</h2></a>
             
				</div>
			</div>
          		<div class="row-fluid">
				<div class="span3 show-grid">
				             <a href="<?php echo $sublink; ?>"><img src="<?php echo $iconsDir.'/managesubjects.png'; ?>" alt="Subjects" style="width: 100px; height: 100px;" /></a><br />
                        <a href="<?php echo $sublink; ?>"><h2 class="item-page-title">Subjects</h2></a>
         
				</div>
				<div class="span3 show-grid">
				         <a href="<?php echo $grouplink; ?>"><img src="<?php echo $iconsDir.'/groups.png'; ?>" alt="Groups" style="width: 100px; height: 100px;" /></a><br />
                        <a href="<?php echo $grouplink; ?>"><h2 class="item-page-title">Groups</h2></a>
				</div>
				<div class="span3 show-grid">
				              <a href="<?php echo $feeheadslink; ?>"><img src="<?php echo $iconsDir1.'/feeparticulars.png'; ?>" alt="heads" style="width: 84px; height: 84px;" /></a><br />
                        <a title="Fee Heads" data-rel="tooltip" href="<?php echo $feeheadslink; ?>"><h2 class="item-page-title">Fee Heads</h2></a>
				</div>
				<div class="span3 show-grid">
	     	             <a href="<?php echo $callink; ?>"><img src="<?php echo $iconsDir1.'/Calendar.png'; ?>" alt="Calendar" style="width: 100px; height: 100px;" /></a><br />
                        <a href="<?php echo $callink; ?>"><h2 class="item-page-title">Calendar</h2></a>
           
				</div>
			</div>

<br>
<br>
</div>
