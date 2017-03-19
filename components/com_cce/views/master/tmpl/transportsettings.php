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
   $courseItemid = $model->getMenuItemid('master','Transport');
   if($courseItemid) ;
   else{
   	$courseItemid = $model->getMenuItemid('topmenu','Portal');	
   }

   $dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
    	$busroutelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=transport&Itemid='.$masterItemid);
		
   $vehicledetails= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=vehicledetails&view=vehicledetails&layout=default&task=display&Itemid='.$courseItemid);
   $busroute= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=transportroutes&view=transportroutes&layout=default&task=display&Itemid='.$courseItemid);
   
   $driver= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=driverdetails&view=driverdetails&layout=default&Itemid='.$courseItemid);
   $allotdriver= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=allotdriver&view=allotdriver&layout=default&task=display&Itemid='.$courseItemid);
	
	 $settings= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=courses&view=courses&task=display&Itemid='.$courseItemid);

?>


<!--
TOP LINKS....DASHBOARD
-->

<table width="100%" cellpadding="10">
        <tr style="border:none;">
                <td style="border:none;" align="left">
        <div style="float:left;">
           <img src="<?php echo $iconsDir1.'/settings.png'; ?>" alt="" style="width: 64px; height: 64px;" />
        </div>
        <div style="float:left;">
                <div>&nbsp;</div>
                <h1 class="item-page-title">Transport</h1>
        </div>
                       <div style="float:right;"> <a href="<?php echo $dashboardlink; ?>"><img src="<?php echo $iconsDir1.'/1dashboard.png'; ?>" alt="Dash Board" style="width: 32px; height: 32px;" /></a><br />
			</div>
            <div style="float:right; width:10px;"> &nbsp;</div>
			<div style="float:right;">
                        <a href="<?php echo $busroutelink; ?>"><img src="<?php echo $iconsDir1.'/1transport.png'; ?>" alt="Master" style="width: 32px; height: 32px;" /></a><br />
			</div>
		
</td>
</tr>
</table>
		<br />
        <br />
        <Br />
               
<div align="center">
	<div class="row-fluid">
				<div class="span3 show-grid">
				          <a href="<?php echo $vehicledetails; ?>"><img src="<?php echo $iconsDir.'/vehicledetails.png'; ?>" alt="Fee Collection" style="width: 100px; height: 100px;" /></a><br />
                        <a href="<?php echo $vehicledetails; ?>"><h2 class="item-page-title">Vehicle Details</h2></a>
           
				</div>
				<div class="span3 show-grid">
				             <a href="<?php echo $busroute; ?>busroute"><img src="<?php echo $iconsDir.'/busroute.png'; ?>" alt="Courses" style="width: 100px; height: 100px;" /></a><br />
                        <a href="<?php echo $busroute; ?>"><h2 class="item-page-title"> Set Route</h2></a>
          
				</div>
				<div class="span3 show-grid">
				        <a href="<?php echo $driver; ?>"><img src="<?php echo $iconsDir1.'/driver.png'; ?>" alt="Settings" style="width: 100px; height: 100px;" /></a><br />
                        <a href="<?php echo $driver; ?>"><h2 class="item-page-title">Driver Details</h2></a>
              
				</div>
				<div class="span3 show-grid">
				      <a href="<?php echo $allotdriver; ?>"><img src="<?php echo $iconsDir1.'/buslog.png'; ?>" alt="Courses" style="width: 100px; height: 100px;" /></a><br />
                        <a href="<?php echo $allotdriver; ?>"><h2 class="item-page-title">Allot Driver</h2></a>
                 
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
