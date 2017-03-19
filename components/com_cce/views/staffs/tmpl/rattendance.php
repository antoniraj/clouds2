<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');
	$Itemid = JRequest::getVar('Itemid');
	$model = & $this->getModel('cce');
	$model1 = & $this->getModel('staffattendance');
	$model2 = & $this->getModel('staffleave');
	$deps=$model->getDepartments();
	$cdate = JRequest::getVar('cdate');
	if(!$cdate) $cdate=date('d-m-Y');
   	$iconsDir1 = JURI::base() . 'components/com_cce/images';
        $dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
        $modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=staff&Itemid='.$masterItemid);

?>

<div class="row-fluid adjustalert alert alert-warning">
<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce'); ?>" method="POST" name="adminForm">
							<div class="span8 pull-right control-group">
							<label class="control-label" for="selectError">Select Date</label>
								<div class="controls">
								  <div class="input-append">
									<input  class="input-xlarge datepicker" id="date01" onchange="submit();" style="width:200px;" size="16" type="text" name="cdate" value="<?php echo $cdate; ?>"><button class="btn" name="go" value="Go">Go!</button>
								  </div>
								</div>
								</div>
								  <div class="span2"><?php 
  $show1date = new DateTime($cdate);
 ?>
  <span style="font-size:15px;margin-top:15px;">
<?php //echo $show1date->format('dS F Y') ?>
</span></div>
        <input type="hidden" name="controller" value="staffs" >
        <input type="hidden" name="view" value="staffs" >
        <input type="hidden" name="layout" value="rattendance" >
        <input type="hidden" name="task" value="getdepartmentwiseattendancereport" >
      	<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" >

</form>
</div>

<?php
	$ccdate=JArrayHelper::mysqlformat($cdate);
	foreach($deps as $dep)
	{
		$rs=$model1->getDepartmentAbsenteesByDate($dep->id,$ccdate,$data);
		echo "<h1 class=\"item-page-title\">".$dep->departmentname."</h1>";
		
?>
<table width="100%" class="TFtable table table-striped table-bordered">
<tr><th class="list-title" width="10%">S#</th><th width="15%" class="list-title">Code</th> <th width="25%" class="list-title">First Name</th><th width="35%" class="list-title">Comments</th><th width="15%" class="list-title">Day</th></tr>
<?php
	
	$i=1;
	foreach($data as $rec){
		$r=$model->getStaff($rec->staffid,$srec);
		$flag=0;
        	$r1=$model2->getStaffLeaveByDateAndSession($srec->id,$ccdate,'M',$lrec);
		if($r1){
			$flag=1;
			$comment=$comment.'(leave-'.$lrec[0]['reason'].')';
		}
        	$r2=$model2->getStaffLeaveByDateAndSession($srec->id,$ccdate,'E',$l2rec);
		if($r2){
			if($flag==0)
				$comment=$comment.'(leave-'.$l2rec[0]['reason'].')';
		}
		if($r1 && $r2) $dc = 'Full Day';
		else if($r1) $dc = 'Morning only';
		else if($r2) $dc = 'Evening Only';
		echo '<tr>';
		echo '<td>'.$i++.'</td>';
		echo '<td>'.$srec->staffcode.'</td>';
		echo '<td>'.$srec->firstname.'</td>';
		echo '<td>'.$comment.'</td>';
		echo '<td>'.$dc.'</td>';
		echo '</tr>';
		$r1=$r2=false;
		$comment='';
		$dc='';
	}
	if($i==1){
		echo '<tr><td colspan="4" align="center">...No Absentees...</td></tr>';
	}
	echo '</table>';
}?>
