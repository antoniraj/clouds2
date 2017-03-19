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
   $pathway->addItem('Transport');
   include_once (JPATH_ROOT.DS.'components'.DS.'com_cce'.DS.'views'.DS.'includecss.php');
   $dashboardItemid = $model->getMenuItemid('topmenu','Portal');
   if($dashboardItemid) ;
   else{
   	$dashboardItemid = $model->getMenuItemid('manageschool','Home');	
   }
   $courseItemid = $model->getMenuItemid('master','Transport');
   if($courseItemid) ;
   else{
   	$courseItemid = $model->getMenuItemid('topmenu','Portal');	
   }

   $dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
 $feecollection= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=feecollection&view=feecollection&layout=default&task=display&Itemid='.$courseItemid);
   
   $busroute= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=transport&view=transport&Itemid='.$courseItemid);
    $vehicledetails= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=vehicledetails&view=vehicledetails&task=display&Itemid='.$courseItemid);
		 $allotment= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=studentprofile&view=studentprofile&layout=transportdetails&Itemid='.$courseItemid);
	 $fuel= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=fuelmanage&view=fuelmanage&layout=default&task=display&Itemid='.$courseItemid);

	 $settings= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&layout=transportsettings&Itemid='.$courseItemid);
   $listallroutes= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=allotstudent&view=allotstudent&layout=viewroutes&Itemid='.$courseItemid);

?>

        <Br />
<div align="center">
	<div class="row-fluid">
				<div class="span3 show-grid">
				          <a href="<?php echo $feecollection; ?>"><img src="<?php echo $iconsDir1.'/feecollection.png'; ?>" alt="Fee Collection" style="width: 100px; height: 100px;" /></a><br />
                        <a href="<?php echo $feecollection; ?>"><h2 class="item-page-title">Fee Collection</h2></a>
           
				</div>
				<div class="span3 show-grid">
				             <a href="<?php echo $allotment; ?>"><img src="<?php echo $iconsDir1.'/allotment.png'; ?>" alt="Courses" style="width: 100px; height: 100px;" /></a><br />
                        <a href="<?php echo $allotment; ?>"><h2 class="item-page-title"> Allotment</h2></a>
          
				</div>
				<div class="span3 show-grid">
				        <a href="<?php echo $settings; ?>"><img src="<?php echo $iconsDir1.'/settings.png'; ?>" alt="Settings" style="width: 100px; height: 100px;" /></a><br />
                        <a href="<?php echo $settings; ?>"><h2 class="item-page-title">Settings</h2></a>
              
				</div>
				<div class="span3 show-grid">
				      <a href="<?php echo $fuel; ?>"><img src="<?php echo $iconsDir1.'/fuel.png'; ?>" alt="Courses" style="width: 100px; height: 100px;" /></a><br />
                        <a href="<?php echo $fuel; ?>"><h2 class="item-page-title">Fuel Maintanance</h2></a>
                 
				</div>
			</div>

        
		<br />
        <br />
        <Br />
                
		
        
		<br />
        <br />
        <Br />
                
		<br />
        <br />
        <Br />
</div>
