<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');
	$Itemid = JRequest::getVar('Itemid');
	$sdid= JRequest::getVar('sdid');
	
	$iconsDir1 = JURI::base() . 'components/com_cce/images';

   	$model = & $this->getModel('timetable');
	$rs = $model->getDayCategory($sdid,$rec);
	if($rs==false) {
		$rec->id = -1;
		$rec->description='';
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
	$sdItemid = $model->getMenuItemid('manageschool','Day Category');
        if($sdItemid) ;
        else{
                $sdItemid = $model->getMenuItemid('topmenu','Manage School');
        }
   	$dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
   	$modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=timetable&Itemid='.$masterItemid);
   	$sdlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=timetable&view=timetable&task=display&layout=daycategory&Itemid='.$Itemid);



?>
<!-- TOP LINKS....DASHBOARD -->
<table width="100%" cellpadding="10">
        <tr style="border:none;">
                <td style="border:none;" align="left">
		<div style="float:left">
                        <img src="<?php echo $iconsDir.'/adddaycategory.png'; ?>" alt="" style="width: 44px; height: 44px;" />
		</div>
		<div style="float:left">
			<h1 class="item-page-title" align="left">Add Day Category</h1>
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
                </td>
        </tr>
</table>

<br />

<form action="index.php" method="POST" name="addform" id="addform" onSubmit="return stest()">
        <table>
                <tr style="border:none;" >
                        <td align="right" style="border:none;" >Category Description
                                <input type="text" id="description" name="description" size="55" maxlength="100" value="<?php echo $rec->description; ?>" />
				<input type="submit" class="button_save" value="Save" id="submit" name="submit" />
			</td>
		</tr>
        </table>
        <input type="hidden" name="option" value="<?php echo JRequest::getVar('option'); ?>" />
        <input type="hidden" id="id" name="id" value="<?php echo $rec->id; ?>" />
        <input type="hidden" id="view" name="view" value="timetable" />
        <input type="hidden" id="controller" name="controller" value="timetable" />
        <input type="hidden" name="Itemid" id="Itemid" value="<?php echo $Itemid; ?>" />
        <input type="hidden" name="task" id="task" value="savedaycategory" />
        <input type="hidden" name="layout" id="layout" value="daycategory" />
</form>

