<?php
// No direct access
   defined('_JEXEC') OR DIE('Access denied..');
   $app = JFactory::getApplication();
   $iconsDir = JURI::base() . 'components/com_cce/images/64x64';
   $iconsDir1 = JURI::base() . 'components/com_cce/images';

   $model = & $this->getModel('cce');
   
   $dashboardItemid = $model->getMenuItemid('topmenu','Portal');
   if($dashboardItemid) ;
   else{
   	$dashboardItemid = $model->getMenuItemid('manageschool','Home');	
   }
   $staffItemid = $model->getMenuItemid('manageschool','master');
   if($staffItemid) ;
   else{
   	$staffItemid = $model->getMenuItemid('topmenu','Portal');	
   }

   $dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);

   $stafflink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=staffs&view=staffs&task=display&Itemid='.$staffItemid);
   $alink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=staffs&view=staffs&layout=attendance&task=display&Itemid='.$staffItemid);
   $llink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=staffs&view=staffs&layout=leave&task=display&Itemid='.$staffItemid);
   $areportlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=staffs&view=staffs&layout=rattendance&task=display&Itemid='.$staffItemid);
        $app =& JFactory::getApplication();
        $pathway =& $app->getPathway();
        $pathway->addItem('Staff');
?>

<br>

<div align="center">
<div class="row-fluid">
				<div class="span3 show-grid"">
				          <a href="<?php echo $stafflink; ?>"><img src="<?php echo $iconsDir.'/staff.png'; ?>" alt="Staff" style="width: 100px; height: 100px;" /></a><br />
                        <a href="<?php echo $stafflink; ?>"><h2 class="item-page-title">Staff Details</h2></a>
           
				</div>
				<div class="span3 show-grid"">
				                <a href="<?php echo $alink; ?>"><img src="<?php echo $iconsDir.'/staffattendance.png'; ?>" alt="Staff Attendance" style="width: 96px; height: 96px;" /></a><br />
                        <a href="<?php echo $alink; ?>"><h2 class="item-page-title">Staff Attendance</h2></a>
       
				</div>
				<div class="span3 show-grid"">
				            <a href="<?php echo $llink; ?>"><img src="<?php echo $iconsDir.'/staffleave.png'; ?>" alt="Staff Leave" style="width: 100px; height: 100px;" /></a><br />
                        <a href="<?php echo $llink; ?>"><h2 class="item-page-title">Staff Leave</h2></a>
         
				</div>
				<div class="span3 show-grid"">
				             <a href="<?php echo $areportlink; ?>"><img src="<?php echo $iconsDir.'/absent.png'; ?>" alt="Staff" style="width: 100px; height: 100px;" /></a><br />
                        <a href="<?php echo $areportlink; ?>"><h2 class="item-page-title">Absentees</h2></a>
           
				</div>
			</div>

<Br>
<br>
</div>

