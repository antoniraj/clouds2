<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	$Itemid = JRequest::getVar('Itemid');
	$il= JRequest::getVar('includeleave1');
	if(!$il) $includeleave='1';
	
	else $includeleave='0';
	$model = & $this->getModel('classattendance');
	$model1 = & $this->getModel('classleave');
	$model->getRegularAbsentees($arecs);
		
?>
<div>
        <div style="float:left;">
           <img src="<?php echo $iconsDir.'/attendancereport.png'; ?>" alt="" style="width: 64px; height: 64px;" />
        </div>
        <div>
                <div>&nbsp;</div>
                <h1>Regular Absentees Report</h1>
        </div>
</div>





<form action="<?php echo JRoute::_('index.php?option=com_cce'); ?>" method="POST" name="adminForm">
<table style="border:none;" width="100%" cellspacing="2" cellpadding="3">
<tr style="border:none;"> <td align="right" style="border:none;">
<?php
	if($includeleave=='1') 
        	echo '<input style="width: 120px;" type="submit" name="includeleave1" value="Abs+Leave" class="button_go">';
	else
        	echo '<input style="width: 120px;" type="submit" name="includeleave0" value="Abs" class="button_go">';
?>
</td></tr>
        <input type="hidden" name="controller" value="attendancereports" >
        <input type="hidden" name="view" value="attendancereports" >
        <input type="hidden" name="layout" value="regularabsentees" >
        <input type="hidden" name="task" value="go" >
      	<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" >
</table>
</form>
<hr  />
<?php
	if($includeleave=='1') {
		echo '<h1>Number of Days of Absent without Leave</h1>';
	}else{
		echo '<h1>Number of Days of Absent(Leave+Absent)</h1>';
	}
?>
<table borde="0" width="100%" cellspacing="2" cellpadding="3">
<tr><th class="list-title" width="10%">S#</th><th width="15%" class="list-title">RegNo</th><th width="30%" class="list-title">Name</th><th width="15%" class="list-title">Class</th><th width="10%" class="list-title">No.of Days</th></tr>
<?php
	$i=1;
	foreach($arecs as $rec){
		$model->getStudent($rec['studentid'],$srec);
		$model1->getRegularLeaveTakersByID($rec['studentid'],$lrec);
		$model->getCourse($srec->joinedclassid,$crec);
		echo '<tr>';
		echo '<td>'.$i++.'</td>';
		echo '<td>'.$srec->registerno.'</td>';
		echo '<td>'.$srec->firstname.'</td>';
		echo '<td>'.$crec->coursename.'</td>';
		if($includeleave=='1')
			echo '<td>'.($rec['abs']-($lrec[0]['ls'])).'</td>';
		else
			echo '<td>'.($rec['abs']).'</td>';
		echo '</tr>';
	}
?>
</table>

