
<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');
	$Itemid=JRequest::getVar('Itemid');
	$staffid=JRequest::getVar('staffid');
	$fromdate=JRequest::getVar('fdate');
	$todate=JRequest::getVar('todate');
	
	if(!$fromdate) $fromdate=date('d-m-Y');
	if(!$todate) $todate=date('d-m-Y');
	$model = &$this->getModel('cce');
	$model1 = &$this->getModel('staffleave');
	$staffname=$model->getStaff($staffid,$srec);
	$from1date = JArrayHelper::mysqlformat($fromdate);
	$to1date = JArrayHelper::mysqlformat($todate);

        $iconsDir1 = JURI::base() . 'components/com_cce/images';
	$dashboardItemid = $model->getMenuItemid('manageschool','Dash Board');
        if($dashboardItemid) ;
        else{
                $dashboardItemid = $model->getMenuItemid('topmenu','Manage School');
        }
        $masterItemid = $model->getMenuItemid('master','Staff Details');
        if($masterItemid) ;
        else{
                $masterItemid = $model->getMenuItemid('topmenu','Manage School');
        }

        $dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
        $modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=staff&Itemid='.$masterItemid);


?>


<!--
TOP LINKS....DASHBOARD
-->
<table width="100%" cellpadding="10">
        <tr style="border:none;">
                <td style="border:none;" align="left">
        <div style="float:left;">
           <img src="<?php echo $iconsDir.'/staffleave.png'; ?>" alt="" style="width: 64px; height: 64px;" />
        </div>
        <div style="float:left;">
                <div>&nbsp;</div>
                <h1 class="item-page-title">Leave Register</h1>
        </div>
                       <div style="float:right;"> <a href="<?php echo $dashboardlink; ?>"><img src="<?php echo $iconsDir1.'/1dashboard.png'; ?>" alt="Dash Board" style="width: 48px; height: 48px;" /></a><br />
                        </div>
                        <div style="float:right; width:10px;"> &nbsp;</div>
                        <div style="float:right;">
                        <a href="<?php echo $modulelink; ?>"><img src="<?php echo $iconsDir1.'/1staff.png'; ?>" alt="Master" style="width: 48px; height: 48px;" /></a><br />
                        </div>
                </td>
        </tr>
</table>


<br />
<div class="box">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-th"></i> Leave Register</h2>
						<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
						</div>
					</div>
					<div class="box-content">
                  	<div class="row-fluid">
						<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce'); ?>" method="POST" name="adminForm">

							   <div class="control-group" >
								<label class="control-label" for="selectError">Staff Name</label>
								<div class="controls">
								  <select id="selectError" data-rel="chosen" name="staffid">
										<option value="">Select</option>
									<?php

											foreach($this->staffs as $staff) :
											echo "<option value=\"".$staff->id."\" ".($staff->id == $staffid ? "selected=\"yes\"" : "").">".$staff->firstname."</option>";
											endforeach;
									?>
								  </select>
								</div>
							  </div>

						<div class="control-group">
							  <label class="control-label" for="date01">From</label>
							  <div class="controls">
								<input type="text" class="datepicker" name="fdate" id="date01" value="<?php echo JArrayHelper::indianDate($fromdate); ?>">
							  </div>
							</div>


						<div class="control-group">
							  <label class="control-label" for="date02">To</label>
							  <div class="controls">
								<input type="text" class="datepicker" name="todate" id="date02" value="<?php echo JArrayHelper::indianDate($todate); ?>">
							  </div>
							</div>

<div class="form-actions">
       <button class="btn btn-primary" name="go" value="go"><i class="icon-upload"></i>Go</button>             
</div>	
        <input type="hidden" name="controller" value="staffs" >
        <input type="hidden" name="view" value="staffs" >
        <input type="hidden" name="layout" value="leave" >
        <input type="hidden" name="task" value="go" >
      	<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" >
</form>
</div>
	<?php  if(JRequest::getVar('go')!='go')return; ?>
<form action="<?php echo JRoute::_('index.php?option=com_cce'); ?>" method="POST" name="adminForm">
<table width="100%" class="TFtable table table-striped table-bordered">
<tr><th class="list-title" width="10%">S#</th><th class="list-title" width="20%">Date</th><th class="list-title" width="20%">Day</th><th class="list-title" width="25%">Leave(Morning)?</th><th class="list-title" width="25%">Leave(Evening)?</th></tr>
<?php
	//echo $from1date;
	//echo $to1date;
	$i=1;
	$toDate = new DateTime($to1date);
	$fromDate = new DateTime($from1date);
	//$span = $toDate->diff($fromDate);
	//if($fromDate < $toDate)
	//echo "Your subscription ends in {$span->format('%d')} days!";
	while($fromDate <= $toDate){
		echo '<tr>';
		echo '<td>'.$i.'</td>';
		echo '<td>'.$fromDate->format('d-m-Y').'</td>';
		echo '<td>'.$fromDate->format('D').'</td>';
		$s = $model1->getStaffLeaveByDateAndSession($staffid,$fromDate->format('Y-m-d'),'M',$xx);
		if(!$s) 
			echo '<td><input type="checkbox" name="lrec[]" value="n:'.$staffid.':'.$fromDate->format('Y-m-d').':M'.'" /></td>';
		else{ 
			echo '<td><input type="checkbox" name="lrec[]" checked="true" value="'.$xx[0]['id'].':'.$staffid.':'.$fromDate->format('Y-m-d').':M'.'" /></td>';
			$reason=$xx[0]['reason'];
		}
		$s = $model1->getStaffLeaveByDateAndSession($staffid,$fromDate->format('Y-m-d'),'E',$xx);
		if(!$s) 
			echo '<td><input type="checkbox" name="lrec[]" value="n:'.$staffid.':'.$fromDate->format('Y-m-d').':E'.'" /></td>';
		else{ 
			echo '<td><input type="checkbox" name="lrec[]" checked="true" value="'.$xx[0]['id'].':'.$staffid.':'.$fromDate->format('Y-m-d').':E'.'" /></td>';
			$reason=$xx[0]['reason'];
		}
		echo '</tr>';
		$fromDate->modify('+1 days');
		$i++;
	}
	echo '<tr><td colspan="2" align="right" style="vertical-align: middle;">Reason:</td><td colspan="3" style="vertical-align: middle;"><textarea name="reason" style="height: 60px;" rows="5" cols="50">'.$reason.'</textarea></td></tr>';
?>
</table>
						<div class="form-actions">
								<button type="submit" class="btn btn-primary"  name="save" value="Save" >Save</button>
							  </div>
        <input type="hidden" name="controller" value="staffs" >
        <input type="hidden" name="view" value="staffs" >
        <input type="hidden" name="layout" value="default" >
        <input type="hidden" name="task" value="saveleave" >
      	<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" >
        <input type="hidden" name="staffid" value="<?php echo $staffid; ?>" >
        <input type="hidden" name="fromdate" value="<?php echo $from1date; ?>" >
        <input type="hidden" name="todate" value="<?php echo $to1date; ?>" >
</form>
					</div>
					</div>
</div>

