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
   $pathway->addItem('SMS');


   $dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
   $bulksmslink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=sms&view=sms&layout=bulksms&task=bulksms&Itemid='.$smsItemid);
   $batchstudentsmslink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=sms&view=sms&layout=batchstudentsms&task=displaystudents&Itemid='.$smsItemid);
   $groupstudentsmslink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=sms&view=sms&layout=groupstudentsms&task=displaygroupstudents&Itemid='.$smsItemid);
   $staffsmslink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=sms&view=sms&layout=batchstaffsms&task=displaystaff&Itemid='.$smsItemid);
   $approvestudentsmslink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=sms&view=sms&layout=smsaqueue&task=approvestudentsms&Itemid='.$smsItemid);
   $smsqlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=sms&view=sms&layout=smsqueue&task=smsqueue&Itemid='.$smsItemid);
   $studentsmsloglink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=sms&view=sms&layout=studentsmslog&task=studentsmslog&Itemid='.$smsItemid);
   $todaysabslink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=attendancereports&view=attendancereports&layout=todayabsentees&fl=1&task=display&Itemid='.$lItemid);
   $hwlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=sms&view=sms&layout=homework&task=displayhomeworks&Itemid='.$smsItemid);
   $tplink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=sms&view=sms&layout=testportion&task=displaytestportions&Itemid='.$smsItemid);
   $indlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=sms&view=sms&layout=individualstudentsms&task=individualstudentsms&Itemid='.$smsItemid);
?>


<b style="font: bold 15px Georgia, serif;">SMS MODULE</b>
<div class="pull-right">
<a class="btn btn-mini btn-success" href="<?php echo $bulksmslink; ?>"><i class="icon-edit icon-white"></i>Bulk SMS</a>
<a class="btn btn-mini btn-info" href="<?php echo $batchstudentsmslink; ?>"><i class="icon-edit icon-white"></i>Batch SMS</a>
<a class="btn btn-mini btn-primary" href="<?php echo $groupstudentsmslink; ?>"><i class="icon-edit icon-white"></i>Group SMS</a>
<a class="btn btn-mini btn-warning" href="<?php echo $indlink; ?>"><i class="icon-edit icon-white"></i>Individual SMS</a>
<a class="btn btn-mini btn-danger" href="<?php echo $hwlink; ?>"><i class="icon-edit icon-white"></i>Homework SMS</a>
<a class="btn btn-mini btn-success" href="<?php echo $tplink; ?>"><i class="icon-edit icon-white"></i>Test Portion SMS</a>
<a class="btn btn-mini btn-info" href="<?php echo $todaysabslink; ?>"><i class="icon-edit icon-white"></i>Today's Absentees SMS</a>
<a class="btn btn-mini btn-primary" href="<?php echo $staffsmslink; ?>"><i class="icon-edit icon-white"></i>Staff SMS</a>
<a class="btn btn-mini btn-warning" href="<?php echo $smsqlink; ?>"><i class="icon-edit icon-white"></i>SMS QUEUE</a>
<a class="btn btn-mini btn-danger" href="<?php echo $approvestudentsmslink; ?>"><i class="icon-edit icon-white"></i>APPROVE QUEUE</a>
<a class="btn btn-mini btn-info" href="<?php echo $studentsmsloglink; ?>"><i class="icon-edit icon-white"></i>SMS LOG</a>
</div>
<hr />

<br />
<br />
<br />
<br />
<div align="center">
	<div class="row-fluid">
				<div class="span2 show-grid">
				                <a href="<?php echo $bulksmslink; ?>"><img src="<?php echo $iconsDir.'/bulksms.png'; ?>" alt="BulkSMS" style="width: 100px; height: 80px;" /></a><br />
                        <a href="<?php echo $bulksmslink; ?>"><h2 class="item-page-title">Bulk SMS</h2></a>
        
				</div>
				<div class="span2 show-grid">
				            <a href="<?php echo $groupstudentsmslink; ?>"><img src="<?php echo $iconsDir.'/groupsms.png'; ?>" alt="Group SMS" style="width: 80px; height: 80px;" /></a><br />
                        <a href="<?php echo $groupstudentsmslink; ?>"><h2 class="item-page-title">Group SMS</h2></a>
            
				</div>
				<div class="span2 show-grid">
				           <a href="<?php echo $batchstudentsmslink; ?>"><img src="<?php echo $iconsDir.'/studentssms.png'; ?>" alt="SMS" style="width: 80px; height: 80px;" /></a><br />
                        <a href="<?php echo $batchstudentsmslink; ?>"><h2 class="item-page-title">Class SMS</h2></a>
				</div>
				<div class="span2 show-grid">
				           <a href="<?php echo $hwlink; ?>"><img src="<?php echo $iconsDir.'/subjects.png'; ?>" alt="SMS" style="width: 80px; height: 80px;" /></a><br />
                        <a href="<?php echo $hwlink; ?>"><h2 class="item-page-title">Homework</h2></a>
				</div>
				<div class="span2 show-grid">
				           <a href="<?php echo $todaysabslink; ?>"><img src="<?php echo $iconsDir.'/studentssms.png'; ?>" alt="SMS" style="width: 80px; height: 80px;" /></a><br />
                        <a href="<?php echo $todaysabslink; ?>"><h2 class="item-page-title">Absentees</h2></a>
				</div>
				<div class="span2 show-grid">
				            <a href="<?php echo $staffsmslink; ?>"><img src="<?php echo $iconsDir.'/staffsms.png'; ?>" alt="STAFF SMS" style="width: 80px; height: 80px;" /></a><br />
                        <a href="<?php echo $staffsmslink; ?>"><h2 class="item-page-title">Staff SMS</h2></a>
            
				</div>
			</div>
	<div class="row-fluid">
				<div class="span2 show-grid">
				            <a href="<?php echo $indlink; ?>"><img src="<?php echo $iconsDir.'/staffsms.png'; ?>" alt="STAFF SMS" style="width: 80px; height: 80px;" /></a><br />
                        <a href="<?php echo $indlink; ?>"><h2 class="item-page-title">Individaul SMS</h2></a>
				</div>
            
				<div class="span3 show-grid">
				             <a href="<?php echo $approvestudentsmslink; ?>"><img src="<?php echo $iconsDir.'/approvesms.png'; ?>" alt="Approve SMS" style="width: 80px; height: 80px;" /></a><br />
                        <a href="<?php echo $approvestudentsmslink; ?>"><h2 class="item-page-title">Approve SMS</h2></a>
          
				</div>
				<div class="span3 show-grid">
				            <a href="<?php echo $smsqlink; ?>"><img src="<?php echo $iconsDir.'/smsqueue.png'; ?>" alt="SMS Queue" style="width: 80px; height: 80px;" /></a><br />
                        <a href="<?php echo $smsqlink; ?>"><h2 class="item-page-title">SMS Queue</h2></a>
            
				</div>
				<div class="span3 show-grid">
				          <a href="<?php echo $studentsmsloglink; ?>"><img src="<?php echo $iconsDir.'/logsms.png'; ?>" alt="SMS Log" style="width: 80px; height: 80px;" /></a><br />
                        <a href="<?php echo $studentsmsloglink; ?>"><h2 class="item-page-title">SMS Log</h2></a>
               
				</div>
		
			</div>
<br>
<br>
<br>
</div>
