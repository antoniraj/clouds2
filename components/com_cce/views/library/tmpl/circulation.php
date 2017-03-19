
<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/';
	$library = JURI::base() . 'components/com_cce/images/library/';
	$iconsDir1 = JURI::base() . 'components/com_cce/images/64X64/';
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


   $library1= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&layout=library&task=display&Itemid='.$smsItemid);
   $issuebook= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=circulation&view=circulation&layout=issuebook&task=view&Itemid='.$smsItemid);
   $returnbook= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=circulation&view=circulation&layout=returnbook&task=view&Itemid='.$smsItemid);
   $renewbook= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=circulation&view=circulation&layout=renewbook&task=view&Itemid='.$smsItemid);
   $approvestudentsmslink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=sms&view=sms&layout=smsaqueue&task=approvestudentsms&Itemid='.$smsItemid);
   $smsqlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=sms&view=sms&layout=smsqueue&task=smsqueue&Itemid='.$smsItemid);
   $studentsmsloglink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=sms&view=sms&layout=studentsmslog&task=studentsmslog&Itemid='.$smsItemid);
?>



<table width="100%" cellpadding="10">
        <tr style="border:none;">
                <td style="border:none;" align="right">
  <div style="float:left;">
           <img src="<?php echo $iconsDir.'/borrow.gif'; ?>" alt="" style="width: 64px; height: 64px;" />
        </div>
        <div style="float:left;">
                <h2></h2>
                <h2></h2>
                <h2></h2>
                <h1 class="item-page-title"> Circulation </h1>
        </div>

                       <div style="float:right;"> <a href="<?php echo $dashboardlink; ?>"><img src="<?php echo $iconsDir.'/1dashboard.png'; ?>" alt="Dash Board" style="width: 28px; height: 28px;" /></a><br />
			</div>
			<div style="float:right; width:10px;"> &nbsp;</div>
			<div style="float:right;">
                        <a href="<?php echo $library1; ?>"><img src="<?php echo $iconsDir.'/1library.png'; ?>" alt="Master" style="width: 34px; height: 34px;" /></a><br />
			</div>
                </td>
        </tr>
</table>
<br>
<br>
<br>
<div align="center">
			<div class="row-fluid">
				<div class="span3 show-grid">
				                <a href="<?php echo $issuebook; ?>"><img src="<?php echo $library.'/issuebook.png'; ?>" alt="BulkSMS" style="width: 100px; height: 100px;" /></a><br />
                        <a href="<?php echo $issuebook; ?>"><h2 class="item-page-title">Issue Book</h2></a>
        
				</div>
				<div class="span1"></div>
				<div class="span3 show-grid">
				            <a href="<?php echo $returnbook; ?>"><img src="<?php echo $library.'/returnbook.png'; ?>" alt="Group SMS" style="width: 100px; height: 100px;" /></a><br />
                        <a href="<?php echo $returnbook; ?>"><h2 class="item-page-title">Return Book</h2></a>
            
				</div>
				<div class="span1"></div>
				<div class="span3 show-grid">
				           <a href="<?php echo $renewbook; ?>"><img src="<?php echo $library.'/renewbook.png'; ?>" alt="SMS" style="width: 100px; height: 100px;" /></a><br />
                        <a href="<?php echo $renewbook; ?>"><h2 class="item-page-title">Books Renewal</h2></a>
            
				</div>
					<div class="span1"></div>
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

