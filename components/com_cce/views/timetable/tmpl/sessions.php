<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');
	$Itemid = JRequest::getVar('Itemid');
	
	$iconsDir1 = JURI::base() . 'components/com_cce/images';

   	$model = & $this->getModel('timetable');

   	$dashboardItemid = $model->getMenuItemid('manageschool','Dash Board');
   	if($dashboardItemid) ;
   	else{
        	$dashboardItemid = $model->getMenuItemid('topmenu','Manage School');
   	}
	$masterItemid = $model->getMenuItemid('manageschool','Time Table');
        if($masterItemid) ;
        else{
                $masterItemid = $model->getMenuItemid('topmenu','Manage School');
        }
   	$dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
   	$modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=timetable&Itemid='.$masterItemid);



?>
<!--
TOP LINKS....DASHBOARD
-->
<table width="100%" cellpadding="10">
        <tr style="border:none;">
                <td style="border:none;" align="left">
		<div style="float:left">
                        <img src="<?php echo $iconsDir.'/sessions.png'; ?>" alt="TimeTable" style="width: 44px; height: 44px;" />
		</div>
		<div style="float:left">
			<h1 class="item-page-title" align="left">Sessions Management(Class Timings)</h1>
		</div>
                       <div style="float:right;"> <a href="<?php echo $dashboardlink; ?>"><img src="<?php echo $iconsDir1.'/1dashboard.png'; ?>" alt="Dash Board" style="width: 32px; height: 32px;" /></a><br />
			</div>
			<div style="float:right; width:10px;"> &nbsp;</div>
			<div style="float:right;">
                        <a href="<?php echo $modulelink; ?>"><img src="<?php echo $iconsDir1.'/timetable.png'; ?>" alt="TimeTable" style="width: 32px; height: 32px;" /></a><br />
			</div>
                </td>
        </tr>
</table>




<br />
<table border="0" cellspacing="2" width="100%" cellpadding="3">
<tr>
        <th class="list-title">OPTION</th>
        <th class="list-title" width="20%">SESSION TITLE</th>
        <th class="list-title" width="20%">CODE</th>
        <th class="list-title" width="20%">START</th>
        <th class="list-title" width="20%">STOP</th>
</tr>
</table>
