<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');
    JHTML::script('validate.js', 'components/com_cce/js/');
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	$Itemid = JRequest::getVar('Itemid');
	$model = &$this->getModel('cce');
	$model2 = &$this->getModel('schoolcal');
	$model1 = &$this->getModel('staffattendance');
	$session =JRequest::getVar('session');
	if(!$session) $session='M';
	$cdate=JRequest::getVar('cdate');
	if(!$cdate) $cdate=date('d-m-Y');
    $c1date=JArrayHelper::mysqlformat($cdate);
	$showdate=JArrayHelper::indianDate($cdate);
	$rs = $model2->getCalEntry($c1date,$cal);

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

<table width="100%" cellpadding="10">
        <tr style="border:none;">
                <td style="border:none;" align="left">
        <div style="float:left;">
           <img src="<?php echo $iconsDir.'/staffattendance.png'; ?>" alt="" style="width: 64px; height: 64px;" />
        </div>
        <div style="float:left;">
                <div>&nbsp;</div>
                <h1 class="item-page-title">Staff Attendance</h1>
        </div>

                       <div style="float:right;"> <a href="<?php echo $dashboardlink; ?>"><img src="<?php echo $iconsDir1.'/1dashboard.png'; ?>" alt="Dash Board" style="width: 32px; height: 32px;" /></a><br />
			</div>
			<div style="float:right; width:10px;"> &nbsp;</div>
			<div style="float:right;">
                        <a href="<?php echo $modulelink; ?>"><img src="<?php echo $iconsDir1.'/1staff.png'; ?>" alt="Staff" style="width: 32px; height: 32px;" /></a><br />
			</div>
                </td>
        </tr>
</table>



<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-edit"></i> Staff Attendance</h2>
						<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
						</div>
					</div>
					<div class="box-content">
<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce'); ?>" method="POST" name="adminForm">
<div class="row-fluid">
<div class="span4">
 							<div class="control-group">
							  <label class="control-label" for="date05">Date</label>
							  <div class="controls">
								<input type="text" class="datepicker"  name="cdate" value="<?php echo JArrayHelper::indianDate($cdate); ?>">
							  </div>
							</div>
</div>
<div class="span4">
							<div class="control-group">
							  <label class="control-label" for="date01">Session</label>
							  <div class="controls">
							  <select onChange="submit();" data-rel="chosen"  style="width: 90px; height: 23px;" name="session">
	<?php
                if($session=='M'){
                        echo '<option value="M">Morning</option>';
                	echo '<option value="E">Evening</option>';
		}else if($session=='E'){
                        echo '<option value="E">Evening</option>';
                	echo '<option value="M">Morning</option>';
		}else{
                	echo '<option value="M">Morning</option>';
                        echo '<option value="E">Evening</option>';
		}
	?>
        </select>
							  </div>
							</div>
</div>
<div class="span3">
<button class="btn btn-primary" name="go" value="Go"><i class="icon-plus-sign icon-white"></i> Go</button>
        <input type="hidden" name="controller" value="staffs" >
        <input type="hidden" name="view" value="staffs" >
        <input type="hidden" name="layout" value="attendance" >
        <input type="hidden" name="task" value="go" >
      	<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" >
	 </form>		
</div>
</div>

<br />

<form action="<?php echo JRoute::_('index.php?option=com_cce'); ?>" method="POST" name="adminForm">
<table borde="0" width="100%" cellspacing="2" style="border:none;" cellpadding="3">
<?php
	list($d,$m,$y) = explode("-",$cdate);
	$dte = new DateTime("$y-$m-$d");
	
?>
<tr style="border:none;"><td style="border:none;"><h1 class="item-page-title"><?php echo "$cdate".'['.$dte->format('D').']</h1></td><td style="border:none;" align="right"><h2 class="item-page-title">'.$cal[0]['description'].'['.$cal[0]['daytype'].']'; ?></h2></td></tr>
</table>
<table class="table table-striped table-bordered" width="100%" cellspacing="2" cellpadding="3">
<tr><th class="list-title" width="10%">S#</th><th class="list-title" width="15%">StaffCode</th><th class="list-title" width="40%">Staff Name</th><th class="list-title" width="30%">Present?</th></tr>
<?php
	$i=1;
	if($this->staffs){
           foreach($this->staffs as $staff) {
		echo '<tr>';
		echo '<td>'.$i.'</td>';
		echo '<td>'.$staff->staffcode.'</td>';
		echo '<td>'.$staff->firstname.'</td>';
		echo '<td>';
		
		$s = $model1->getStaffAbsenteeByDateAndSession($staff->id,$c1date,$session,$xx);
		if($s)
                	echo '<input type="checkbox" name="present[]" value="'.$staff->id.'" />';
		else
                	echo '<input type="checkbox" name="present[]" checked="true" value="'.$staff->id.'" />';
                echo '<input type="hidden" name="sids[]" value="'.$staff->id.'" />';
		echo '</td>';
		echo '</tr>';
		$i++;
	  }
        }
	
?>
</table>
<br />
<div class="form-actions" align="right">
							  <button type="submit" class="btn btn-primary" name="save" value="Save">Save</button>	
			</div>
        <input type="hidden" name="controller" value="staffs" >
        <input type="hidden" name="view" value="staffs" >
        <input type="hidden" name="layout" value="attendance" >
        <input type="hidden" name="task" value="saveabsentees" >
      	<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" >
      	<input type="hidden" name="cdate" value="<?php echo $cdate; ?>" >
        <input type="hidden" name="session" value="<?php echo $session; ?>" >
</form>

</div>
</div>
</div>
