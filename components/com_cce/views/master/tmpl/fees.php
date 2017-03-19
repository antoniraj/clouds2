<?php
// No direct access
   defined('_JEXEC') OR DIE('Access denied..');
   $app = JFactory::getApplication();
   $iconsDir = JURI::base() . 'components/com_cce/images/fee';
   $iconsDir1 = JURI::base() . 'components/com_cce/images';
	$Itemid = JRequest::getVar('Itemid');

   $model = & $this->getModel('cce');
   $model = & $this->getModel('cce');
   $this->assignRef( 'model', $model);
   $Itemid=JRequest::getVar('Itemid');
   $app =& JFactory::getApplication();
   $pathway =& $app->getPathway();
   $pathway->addItem('Fees');
   $dashboardItemid = $model->getMenuItemid('topmenu','Portal');
   if($dashboardItemid) ;
   else{
   	$dashboardItemid = $model->getMenuItemid('manageschool','Home');	
   }
   $feeItemid = $model->getMenuItemid('topmenu','fees1');
   if($feeItemid) ;
   else{
   	$feeItemid = $model->getMenuItemid('topmenu','Portal');	
   }

   $dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);

   $feeheadslink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=fees&view=fees&task=display&layout=feeheads&Itemid='.$feeItemid);
   $feeparticularslink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=fees&view=fees&task=display&layout=feecategory&cmdf=0&Itemid='.$feeItemid);
   $feestructurelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=fees&view=fees&task=display&layout=feestructure&Itemid='.$feeItemid);
   $feediscountslink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=fees&view=fees&task=display&layout=discounts&Itemid='.$Itemid);
   $feeconcessionlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=fees&view=fees&task=display&layout=feeconcession&Itemid='.$Itemid);
   $feeschedulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=fees&view=fees&task=display&layout=feeschedule&Itemid='.$Itemid);
   $feecollectionlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=fees&view=fees&task=display&layout=feecollection&Itemid='.$Itemid);
   $feeduelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=fees&view=fees&task=display&layout=feeduelist&`Itemid='.$Itemid);
   $reportlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=fees&view=fees&task=display&layout=reportclasswiseexpected&`Itemid='.$Itemid);
   $greportlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=fees&view=fees&task=display&layout=reportgroupwiseexpected&`Itemid='.$Itemid);
   $instantlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=fees&view=fees&task=display&layout=instantcollection&Itemid='.$Itemid);
   $dailylink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=fees&view=fees&task=display&layout=dailycollection&Itemid='.$Itemid);
   $classreportlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=fees&view=fees&task=display&layout=classwisereport&Itemid='.$Itemid);
   $concessionlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=fees&view=fees&task=display&layout=concessionlist&Itemid='.$Itemid);
   $pendinglink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=fees&view=fees&task=display&layout=pendingpayment&Itemid='.$Itemid);
   $datewiselink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=fees&view=fees&task=display&layout=datewisereport&Itemid='.$Itemid);


?>


<div align="center">
	<div class="row-fluid">
		<div class="span3 show-grid">
			<a href="<?php echo $feeparticularslink; ?>"><img src="<?php echo $iconsDir.'/feeparticulars.png'; ?>" alt="Courses" style="width: 84px; height: 84px;" /></a><br />
                        <a title="Fee Particulars" data-rel="tooltip" href="<?php echo $feeparticularslink; ?>"><h2 class="item-page-title">Define Fee Structures</h2></a>       
		</div>
		<div class="span3 show-grid">
			<a href="<?php echo $feestructurelink; ?>"><img src="<?php echo $iconsDir.'/feestructure.png'; ?>" alt="Course Subjects" style="width: 80px; height: 80px;" /></a><br />
                        <a title="Fee Structure" data-rel="tooltip" href="<?php echo $feestructurelink; ?>"><h2 class="item-page-title">Get Fee Structure</h2></a>
		</div>
		<div class="span3 show-grid">
			<a href="<?php echo $feediscountslink; ?>"><img src="<?php echo $iconsDir.'/feediscounts.png'; ?>" alt="Subject Teacher" style="width: 80px; height: 80px;" /></a><br />
                        <a title="Fee discounts" data-rel="tooltip" href="<?php echo $feediscountslink; ?>"><h2 class="item-page-title">Fee Discounts</h2></a>
		</div>
		<div class="span3 show-grid">
			<a href="<?php echo $feeconcessionlink; ?>"><img src="<?php echo $iconsDir.'/feeconcession.png'; ?>" alt="Class Teachers" style="width: 80px; height: 80px;" /></a><br />
                        <a title="Fee Concession" data-rel="tooltip" href="<?php echo $feeconcessionlink; ?>"><h2 class="item-page-title">Fee Concession</h2></a>
		</div>
		</div>
		<div class="row-fluid">
		<div class="span4 show-grid">
			<a href="<?php echo $feeschedulelink; ?>"><img src="<?php echo $iconsDir.'/feeschedule.png'; ?>" alt="Fee Shedule" style="width: 100px; height: 100px;" /></a><br />
                        <a title="Fee Shedule" data-rel="tooltip" href="<?php echo $feeschedulelink; ?>"><h2 class="item-page-title">Fee Shedule</h2></a>
		</div>
		<div class="span4 show-grid">
			<a href="<?php echo $feecollectionlink; ?>"><img src="<?php echo $iconsDir1.'/feecollection.png'; ?>" alt="Fee Collection" style="width: 100px; height: 100px;" /></a><br />
                        <a title="Attendance" data-rel="tooltip" href="<?php echo $feecollectionlink; ?>"><h2 class="item-page-title">Fee Collection </h2></a>
		</div>
			<div class="span4 show-grid">
				<a href="<?php echo $instantlink; ?>"><img src="<?php echo $iconsDir1.'/instant.png'; ?>" alt="Instant" style="width: 100px; height: 100px;" /></a><br />
                        	<a title="Attendance" data-rel="tooltip" href="<?php echo $instantlink; ?>"><h2 class="item-page-title">Instant Fee Collection </h2></a>
			</div>
		</div>
		<div class="row-fluid">
			<div class="span3 show-grid">
				<a href="<?php echo $reportlink; ?>"><img src="<?php echo $iconsDir1.'/report.png'; ?>" alt="Reports" style="width: 100px; height: 100px;" /></a><br />
                        	<a title="Attendance" data-rel="tooltip" href="<?php echo $reportlink; ?>"><h2 class="item-page-title">Report: Expected Fee</h2></a>
			</div>
		<div class="span3 show-grid">
			<a href="<?php echo $pendinglink; ?>"><img src="<?php echo $iconsDir1.'/pending.png'; ?>" alt="Fee Collection" style="width: 100px; height: 100px;" /></a><br />
                        <a title="Attendance" data-rel="tooltip" href="<?php echo $pendinglink; ?>"><h2 class="item-page-title">Report: Actucal Fee</h2></a>
		</div>
		<div class="span3 show-grid">
			<a href="<?php echo $classreportlink; ?>"><img src="<?php echo $iconsDir1.'/feecollection.png'; ?>" alt="Fee Collection" style="width: 100px; height: 100px;" /></a><br />
                        <a title="Attendance" data-rel="tooltip" href="<?php echo $classreportlink; ?>"><h2 class="item-page-title">Report: Headwise Collection</h2></a>
		</div>
		<div class="span3 show-grid">
			<a href="<?php echo $dailylink; ?>"><img src="<?php echo $iconsDir1.'/daily.png'; ?>" alt="Fee Collection" style="width: 100px; height: 100px;" /></a><br />
                        <a title="Attendance" data-rel="tooltip" href="<?php echo $dailylink; ?>"><h2 class="item-page-title">Report: Daily Collection</h2></a>
		</div>
		</div>
		<div class="row-fluid">
		<div class="span3 show-grid">
			<a href="<?php echo $concessionlink; ?>"><img src="<?php echo $iconsDir1.'/concession.png'; ?>" alt="Fee Collection" style="width: 100px; height: 100px;" /></a><br />
                        <a title="Attendance" data-rel="tooltip" href="<?php echo $concessionlink; ?>"><h2 class="item-page-title">Report: Concession List</h2></a>
		</div>
		<div class="span3 show-grid">
			<a href="<?php echo $feeduelink; ?>"><img src="<?php echo $iconsDir1.'/file.jpg'; ?>" alt="Fee Collection" style="width: 100px; height: 100px;" /></a><br />
                        <a title="Attendance" data-rel="tooltip" href="<?php echo $feeduelink; ?>"><h2 class="item-page-title">Report: Due List </h2></a>
		</div>
		<div class="span3 show-grid">
			<a href="<?php echo $datewiselink; ?>"><img src="<?php echo $iconsDir1.'/file.jpg'; ?>" alt="Fee Collection" style="width: 100px; height: 100px;" /></a><br />
                        <a title="Attendance" data-rel="tooltip" href="<?php echo $datewiselink; ?>"><h2 class="item-page-title">Report: Datewise Collection </h2></a>
		</div>

		</div>
<br>
<br>	
	</div>
