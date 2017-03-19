<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');
	$Itemid = JRequest::getVar('Itemid');
	$sdid= JRequest::getVar('sdid');
	$ddid= JRequest::getVar('ddid');
	
	$iconsDir1 = JURI::base() . 'components/com_cce/images';

   	$model = & $this->getModel('timetable');
	$rs = $model->getDay($ddid,$rec);
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
	$ddItemid = $model->getMenuItemid('manageschool','Day Orders');
        if($ddItemid) ;
        else{
                $ddItemid = $model->getMenuItemid('topmenu','Manage School');
        }
   	$dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
   	$modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=timetable&Itemid='.$masterItemid);
   	$sdlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=timetable&view=timetable&task=display&layout=daycategory&sdid='.$sdid.'&Itemid='.$Itemid);
   	$ddlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=timetable&view=timetable&task=display&layout=days&sdid='.$sdid.'&Itemid='.$Itemid);



?>
<!-- TOP LINKS....DASHBOARD -->
<table width="100%" cellpadding="10">
        <tr style="border:none;">
                <td style="border:none;" align="left">
		<div style="float:left">
                        <img src="<?php echo $iconsDir.'/addday.png'; ?>" alt="" style="width: 44px; height: 44px;" />
		</div>
		<div style="float:left">
			<h1 class="item-page-title" align="left">Add/Edit Day (Day Order)</h1>
		</div>
                       <div style="float:right;"> <a href="<?php echo $dashboardlink; ?>"><img src="<?php echo $iconsDir1.'/1dashboard.png'; ?>" alt="Dash Board" style="width: 32px; height: 32px;" /></a><br />
			</div>
			<div style="float:right; width:10px;"> &nbsp;</div>
			<div style="float:right;">
                        <a href="<?php echo $modulelink; ?>"><img src="<?php echo $iconsDir1.'/timetable.png'; ?>" alt="TimeTable" style="width: 32px; height: 32px;" /></a><br />
			</div>
			<div style="float:right; width:10px;"> &nbsp;</div>
			<div style="float:right;">
                        <a href="<?php echo $sdlink; ?>"><img src="<?php echo $iconsDir.'/daycategory.png'; ?>" alt="Category" style="width: 32px; height: 32px;" /></a><br />
			</div>
			<div style="float:right; width:10px;"> &nbsp;</div>
			<div style="float:right;">
                        <a href="<?php echo $ddlink; ?>"><img src="<?php echo $iconsDir.'/days.png'; ?>" alt="days" style="width: 32px; height: 32px;" /></a><br />
			</div>
                </td>
        </tr>
</table>

<br />

<form action="index.php" method="POST" name="addform" id="addform" onSubmit="return stest()">
<center>
	<table width="100%" cellpadding="10">
                <tr style="border:none;" >
                        <td align="right" style="border:none;" >Day Title</td>
                        <td align="left" style="border:none;" >
                                <input type="text" id="title" name="title" size="32" maxlength="100" value="<?php echo $rec->title; ?>" />
			</td>
		</tr>
                <tr style="border:none;" >
                        <td align="right" style="border:none;" >Code</td>
                        <td align="left" style="border:none;" >
                                <input type="text" id="code" name="code" size="32" maxlength="10" value="<?php echo $rec->code; ?>" />
			</td>
		</tr>
                <tr style="border:none;" >
                        <td align="right" style="border:none;" >Active?</td>
                        <td align="left" style="border:none;" >
                                <input type="text" id="active" name="active" size="32" maxlength="1" value="<?php echo $rec->active; ?>" />
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
        <input type="hidden" name="sdid" id="sdid" value="<?php echo $sdid; ?>" />
        <input type="hidden" name="ddid" id="ddid" value="<?php echo $ddid; ?>" />
        <input type="hidden" name="task" id="task" value="saveday" />
        <input type="hidden" name="layout" id="layout" value="days" />
</form>

