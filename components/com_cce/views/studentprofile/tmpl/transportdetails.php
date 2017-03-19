<?php
// No direct access
   defined('_JEXEC') OR DIE('Access denied..');
   $app = JFactory::getApplication();
   $iconsDir = JURI::base() . 'components/com_cce/images/64x64';
   $iconsDir1 = JURI::base() . 'components/com_cce/images';

   $model = & $this->getModel('cce');
   
   
    $dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
	$busroutelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=transport&Itemid='.$masterItemid);
	 $user= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=allotstudent&view=allotstudent&layout=default&task=display&Itemid='.$courseItemid);
	
	 $vehiclefee= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=courses&view=courses&task=display&Itemid='.$courseItemid);
    $transportmanage= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=allotstudent&view=allotstudent&layout=managestudentstaff&task=display&Itemid='.$courseItemid);

?>


<!--
TOP LINKS....DASHBOARD
-->

<table width="100%" cellpadding="10">
        <tr style="border:none;">
                <td style="border:none;" align="left">
        <div style="float:left;">
           <img src="<?php echo $iconsDir1.'/allotment.png'; ?>" alt="" style="width: 64px; height: 64px;" />
        </div>
        <div style="float:left;">
                <div>&nbsp;</div>
                <h1 class="item-page-title">Student Allotment</h1>
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
<br>
<br>
<br>

<div align="center">
			<div class="row-fluid">
				<div class="span2"></div>
				<div class="span3 show-grid">
				                <a href="<?php echo $user; ?>"><img src="<?php echo $iconsDir1.'/1students.png'; ?>" alt="Allot Stu" style="width: 100px; height: 100px;" /></a><br />
                        <a href="<?php echo $user; ?>"><h2 class="item-page-title">Allot Student</h2></a>
        
				</div>
						<div class="span1"></div>
				<div class="span3 show-grid">
				            <a href="<?php echo $transportmanage; ?>"><img src="<?php echo $iconsDir1.'/transportmanage.png'; ?>" alt="Group SMS" style="width: 100px; height: 100px;" /></a><br />
                        <a href="<?php echo $transportmanage; ?>"><h2 class="item-page-title">Manage transport</h2></a>
            
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

</div>
