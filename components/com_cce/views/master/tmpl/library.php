<?php
// No direct access
   defined('_JEXEC') OR DIE('Access denied..');
   $app = JFactory::getApplication();
   $iconsDir = JURI::base() . 'components/com_cce/images/64x64';
    $library = JURI::base() . 'components/com_cce/images/library';
   $iconsDir1 = JURI::base() . 'components/com_cce/images';

   $model = & $this->getModel('cce');
 $model = & $this->getModel('cce');
   $this->assignRef( 'model', $model);
   $Itemid=JRequest::getVar('Itemid');
   $app =& JFactory::getApplication();
   $pathway =& $app->getPathway();
   $pathway->addItem('Library');
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
   $circulation= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=library&view=library&layout=circulation&task=display&Itemid='.$smsItemid);
   $managebooks= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=library&view=library&layout=managebooks&task=display&Itemid='.$smsItemid);
   $settings= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=library&view=library&layout=settings&task=display&Itemid='.$smsItemid);
   $movementlog= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=librarymanagebooks&view=librarymanagebooks&layout=movementlog&task=view&Itemid='.$smsItemid);
   $mastersearch= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=librarymanagebooks&view=librarymanagebooks&layout=mastersearch&task=view&Itemid='.$smsItemid);
   $todaysdue= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=librarymanagebooks&view=librarymanagebooks&layout=todaysdue&task=view&Itemid='.$smsItemid);

  ?>



<br>

<div align="center">
			<div class="row-fluid">
				<div class="span3 show-grid">
				                <a href="<?php echo $circulation; ?>"><img src="<?php echo $iconsDir1.'/borrow.gif'; ?>" alt="BulkSMS" style="width: 100px; height: 100px;" /></a><br />
                        <a href="<?php echo $circulation; ?>"><h2 class="item-page-title">Circulation</h2></a>
        
				</div> 
				<div class="span3 show-grid">
				            <a href="<?php echo $managebooks; ?>"><img src="<?php echo $iconsDir1.'/book.png'; ?>" alt="Group SMS" style="width: 100px; height: 100px;" /></a><br />
                        <a href="<?php echo $managebooks; ?>"><h2 class="item-page-title">Manage Books</h2></a>
            
				</div>
				<div class="span3 show-grid">
				           <a href="<?php echo $settings; ?>"><img src="<?php echo $iconsDir1.'/libsettings.png'; ?>" alt="SMS" style="width: 100px; height: 100px;" /></a><br />
                        <a href="<?php echo $settings; ?>"><h2 class="item-page-title">Settings</h2></a>
            
				</div>
				<div class="span3 show-grid">
				           <a href="<?php echo $movementlog; ?>"><img src="<?php echo $library.'/movementlog.png'; ?>" alt="SMS" style="width: 100px; height: 100px;" /></a><br />
                        <a href="<?php echo $movementlog; ?>"><h2 class="item-page-title">Movement Log</h2></a>
            
				</div>
			</div>
            <div class="row-fluid">
				<div class="span3 show-grid">
				                <a href="<?php echo $mastersearch; ?>"><img src="<?php echo $library.'/searchbook.png'; ?>" alt="BulkSMS" style="width: 100px; height: 100px;" /></a><br />
                        <a href="<?php echo $mastersearch; ?>"><h2 class="item-page-title">Search Book</h2></a>
        
				</div>

                <div class="span3 show-grid">
				            <a href="<?php echo $todaysdue; ?>"><img src="<?php echo $library.'/todaydue.png'; ?>" alt="Group SMS" style="width: 100px; height: 100px;" /></a><br />
                        <a href="<?php echo $todaysdue; ?>"><h2 class="item-page-title">Today's Due List</h2></a>
            
				</div>
				
			</div>
</div>
