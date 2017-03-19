<?php

class Links{

$bulksmslink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=sms&view=sms&layout=bulksms&task=bulksms&Itemid='.$smsItemid);
   $batchstudentsmslink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=sms&view=sms&layout=batchstudentsms&task=displaystudents&Itemid='.$smsItemid);
   $groupstudentsmslink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=sms&view=sms&layout=groupstudentsms&task=displaygroupstudents&Itemid='.$smsItemid);
   $staffsmslink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=sms&view=sms&layout=batchstaffsms&task=displaystaff&Itemid='.$smsItemid);
   $approvestudentsmslink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=sms&view=sms&layout=smsaqueue&task=approvestudentsms&Itemid='.$smsItemid);
   $smsqlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=sms&view=sms&layout=smsqueue&task=smsqueue&Itemid='.$smsItemid);
   $studentsmsloglink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=sms&view=sms&layout=studentsmslog&task=studentsmslog&Itemid='.$smsItemid);
   $todaysabslink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=attendancereports&view=attendancereports&layout=todayabsentees&task=display&fl=1&Itemid='.$lItemid);
   $hwlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=sms&view=sms&layout=homework&task=displayhomeworks&Itemid='.$smsItemid);
   $indlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=sms&view=sms&layout=individualstudentsms&task=individualstudentsms&Itemid='.$smsItemid);
   $tplink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=sms&view=sms&layout=testportion&task=displaytestportions&Itemid='.$smsItemid);

	function links(){
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
<?php
}
}

?>
