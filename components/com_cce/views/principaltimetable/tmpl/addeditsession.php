<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');
	$Itemid = JRequest::getVar('Itemid');
	$scid= JRequest::getVar('scid');
	$stid= JRequest::getVar('stid');
	
	$iconsDir1 = JURI::base() . 'components/com_cce/images';

   	$model = & $this->getModel('timetable');
	$rs = $model->getSession($stid,$rec);
	if($rs==false) {
		$rec->id = -1;
		$rec->code='';
		$rec->title='';
		$rec->start='';
		$rec->stop='';
	}

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
	$stItemid = $model->getMenuItemid('manageschool','Session Timings');
        if($stItemid) ;
        else{
                $stItemid = $model->getMenuItemid('topmenu','Manage School');
        }
   	$dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
   	$modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=timetable&Itemid='.$masterItemid);
   	$sclink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=timetable&view=timetable&task=display&layout=sessioncategory&scid='.$scid.'&Itemid='.$Itemid);
   	$stlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=timetable&view=timetable&task=display&layout=sessiontimings&scid='.$scid.'&Itemid='.$Itemid);



?>
<!-- TOP LINKS....DASHBOARD -->
<table width="100%" cellpadding="10">
        <tr style="border:none;">
                <td style="border:none;" align="left">
		<div style="float:left">
                        <img src="<?php echo $iconsDir.'/sessiontimings.png'; ?>" alt="TimeTable" style="width: 44px; height: 44px;" />
		</div>
		<div style="float:left">
			<h1 class="item-page-title" align="left">Add/Edit Session (Class Timings)</h1>
		</div>
                       <div style="float:right;"> <a href="<?php echo $dashboardlink; ?>"><img src="<?php echo $iconsDir1.'/1dashboard.png'; ?>" alt="Dash Board" style="width: 32px; height: 32px;" /></a><br />
			</div>
			<div style="float:right; width:10px;"> &nbsp;</div>
			<div style="float:right;">
                        <a href="<?php echo $modulelink; ?>"><img src="<?php echo $iconsDir1.'/timetable.png'; ?>" alt="TimeTable" style="width: 32px; height: 32px;" /></a><br />
			</div>
			<div style="float:right; width:10px;"> &nbsp;</div>
			<div style="float:right;">
                        <a href="<?php echo $sclink; ?>"><img src="<?php echo $iconsDir.'/sessions.png'; ?>" alt="Sessions" style="width: 32px; height: 32px;" /></a><br />
			</div>
			<div style="float:right; width:10px;"> &nbsp;</div>
			<div style="float:right;">
                        <a href="<?php echo $stlink; ?>"><img src="<?php echo $iconsDir.'/sessiontimings.png'; ?>" alt="Sessionstimings" style="width: 32px; height: 32px;" /></a><br />
			</div>
                </td>
        </tr>
</table>

<br />

<form action="index.php" method="POST" name="addform" id="addform" onSubmit="return stest()">
<center>
	<table width="100%" cellpadding="10">
                <tr style="border:none;" >
                        <td align="right" style="border:none;" >Session Title</td>
                        <td align="left" style="border:none;" >
                                <input type="text" id="title" name="title" size="32" maxlength="100" value="<?php echo $rec->title; ?>" />
			</td>
		</tr>
                <tr style="border:none;" >
                        <td align="right" style="border:none;" >Session Code </td>
                        <td align="left" style="border:none;" >
                                <input type="text" id="code" name="code" size="32" maxlength="10" value="<?php echo $rec->code; ?>" />
			</td>
		</tr>
                <tr style="border:none;" >
                        <td align="right" style="border:none;" >Start Time(HH:MM AM/PM)</td>
                        <td align="left" style="border:none;" >
                                <input type="text" id="start" name="start" size="32" maxlength="10" value="<?php echo $rec->start; ?>" />
			</td>
		</tr>
                <tr style="border:none;" >
                        <td align="right" style="border:none;" >Stop Time(HH:MM AM/PM)</td>
                        <td align="left" style="border:none;" >
                                <input type="text" id="stop" name="stop" size="32" maxlength="10" value="<?php echo $rec->stop; ?>" />
			</td>
		</tr>
                <tr style="border:none;" >
                        <td align="center" style="border:none;" >
			<input type="submit" class="button_save" value="Save" id="submit" name="submit" />
			</td>
		</tr>
        </table>
</center>
        <input type="hidden" name="option" value="<?php echo JRequest::getVar('option'); ?>" />
        <input type="hidden" id="id" name="id" value="<?php echo $rec->id; ?>" />
        <input type="hidden" id="view" name="view" value="timetable" />
        <input type="hidden" id="controller" name="controller" value="timetable" />
        <input type="hidden" name="Itemid" id="Itemid" value="<?php echo $Itemid; ?>" />
        <input type="hidden" name="scid" id="scid" value="<?php echo $scid; ?>" />
        <input type="hidden" name="stid" id="stid" value="<?php echo $stid; ?>" />
        <input type="hidden" name="task" id="task" value="savesession" />
        <input type="hidden" name="layout" id="layout" value="sessiontimings" />
</form>

