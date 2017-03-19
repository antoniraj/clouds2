
<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	$Itemid = JRequest::getVar('Itemid');
	$model = & $this->getModel();
	$model4 = & $this->getModel('news');
	$courses=$model->getCurrentCourses();
	$cdate=date('d-m-Y');
	$staffphotoDir = JURI::base() . 'components/com_cce/staffphoto/';
 	$studentphotoDir = JURI::base() . 'components/com_cce/studentsphoto/';
        $dashboardItemid = $model->getMenuItemid('manageschool','Dash Board');
        if($dashboardItemid) ;
        else{
                $dashboardItemid = $model->getMenuItemid('topmenu','Manage School');
        }
        $masterItemid = $model->getMenuItemid('attendance','Absentees By Date');
        if($masterItemid) ;
        else{
                $masterItemid = $model->getMenuItemid('topmenu','Manage School');
        }

   $dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);


   $bulksmslink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=sms&view=sms&layout=bulksms&task=bulksms&Itemid='.$smsItemid);
   $batchstudentsmslink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=sms&view=sms&layout=batchstudentsms&task=displaystudents&Itemid='.$smsItemid);
   $groupstudentsmslink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=sms&view=sms&layout=groupstudentsms&task=displaygroupstudents&Itemid='.$smsItemid);
   $staffsmslink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=sms&view=sms&layout=batchstaffsms&task=displaystaff&Itemid='.$smsItemid);
   $approvestudentsmslink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=sms&view=sms&layout=smsaqueue&task=approvestudentsms&Itemid='.$smsItemid);
   $smsqlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=sms&view=sms&layout=smsqueue&task=smsqueue&Itemid='.$smsItemid);
   $studentsmsloglink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=sms&view=sms&layout=studentsmslog&task=studentsmslog&Itemid='.$smsItemid);
?>



<table width="100%" cellpadding="10">
        <tr style="border:none;">
                <td style="border:none;" align="left">
			<div style="float:left;">
                        <img src="<?php echo $iconsDir1.'/1library.png'; ?>" alt="SMS" style="width: 60px; height: 60px;" />
			</div>
			<h2></h2>
			<div style="float:left;">
			<h1 class="item-page-title" align="left">Library</h1>
			</div>
                </td>
                <td style="border:none;" align="right">
                        <a href="<?php echo $dashboardlink; ?>"><img src="<?php echo $iconsDir1.'/1dashboard.png'; ?>" alt="Dash Board" style="width: 32px; height: 32px;" /></a><br />
                </td>
	</tr>
</table>
<br>
<br>
<br>
<div class="span12">
			<div class="row-fluid show-grid">
				<div class="span4">
				                <a href="<?php echo $bulksmslink; ?>"><img src="<?php echo $iconsDir1.'/borrow.gif'; ?>" alt="BulkSMS" style="width: 100px; height: 100px;" /></a><br />
                        <a href="<?php echo $bulksmslink; ?>"><h2 class="item-page-title">Circulation</h2></a>
        
				</div>
				<div class="span4">
				            <a href="<?php echo $groupstudentsmslink; ?>"><img src="<?php echo $iconsDir1.'/book.png'; ?>" alt="Group SMS" style="width: 100px; height: 100px;" /></a><br />
                        <a href="<?php echo $groupstudentsmslink; ?>"><h2 class="item-page-title">Manage Books</h2></a>
            
				</div>
				<div class="span4">
				           <a href="<?php echo $batchstudentsmslink; ?>"><img src="<?php echo $iconsDir1.'/libsettings.png'; ?>" alt="SMS" style="width: 100px; height: 100px;" /></a><br />
                        <a href="<?php echo $batchstudentsmslink; ?>"><h2 class="item-page-title">Settings</h2></a>
            
				</div>
			</div>

<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>

</div>

