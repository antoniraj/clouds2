<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	JHTML::script('validate.js', 'components/com_cce/js/');
	$Itemid = JRequest::getVar('Itemid');
	$courseid= JRequest::getVar('courseid');
	$model = & $this->getModel('classattendance');
	$model1 = & $this->getModel('classleave');
	$courses=$model->getCurrentCourses();
	$fdate = JRequest::getVar('fdate');
	$tdate = JRequest::getVar('tdate');
	if(!$fdate) $fdate=date('d-m-Y');
	if(!$tdate) $tdate=date('d-m-Y');
	$r=$model->getCourse($courseid,$rec);
	$students = $model->getStudents($courseid);
	$iconsDir1 = JURI::base() . 'components/com_cce/images';
        $dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
        $modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=attendance&Itemid='.$masterItemid);
	$app =& JFactory::getApplication();
        $pathway =& $app->getPathway(); 
        $pathway->addItem('Home', $dashboardlink);
        $pathway->addItem('Attendance',$modulelink);
        $pathway->addItem("Absentees by date");

		
?>


<?php
	
	$f1date=JArrayHelper::mysqlformat($fdate);
	$t1date=JArrayHelper::mysqlformat($tdate);
	
?>
<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-edit"></i> Students Attendance Report</h2>
<div class="pull-right">
<table border="0"><tr><td>
            <form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce'); ?>" method="POST" name="adminForm">
                            <label class="control-label" for="selectError">Select</label>
</td><td>
                                 <select id="selectError" data-rel="chosen" name="courseid">
                                       <option value="">Select</option>
                                       <?php
                                           foreach($courses as $course) :
                                              echo "<option value=\"".$course->id."\" ".($course->id == $courseid ? "selected=\"yes\"" : "").">".$course->code."</option>";
                                           endforeach;
                                       ?>
                                 </select>
</td>
<td>
                             <label class="control-label" for="date01">From</label>
</td><td>
                                  <input type="text" class="datepicker" name="fdate" id="fdate" value="<?php echo JArrayHelper::indianDate($fdate); ?>">
</td><td>
                             <label class="control-label" for="date01">To</label> </td><td>
                                  <input type="text" class="datepicker" id="tdate" name="tdate" value="<?php echo JArrayHelper::indianDate($tdate); ?>">
</td><td>
			          <button class="btn btn-primary" name="go" value="Go"><i class="icon-plus-sign icon-white"></i> Go</button></td></tr>

 		<input type="hidden" name="controller" value="attendancereports" >
              <input type="hidden" name="view" value="attendancereports" >
              <input type="hidden" name="layout" value="classattendance" >
              <input type="hidden" name="task" value="go" >
              <input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" >
            </form>
</table>
</div>


					</div>
					<div class="box-content">
<form action="<?php echo JRoute::_('index.php?option=com_cce'); ?>" method="POST" name="adminForm">
<table width="100%" class="table table-striped table-bordered bootstrap-datatable datatable">
  <thead>
<tr><th class="sorting_disabled" width="5%"><input type="checkbox" onchange="check()" name="chk[]" /></th><th width="15%">RegNo</th><th width="35%">Name</th><th width="10%">Working Days</th><th width="10%">Absent</th><th width="10%">Leave</th><th width="10%">Attendance(%)</th></tr>
</thead>
<?php
	$i=1;
	$model1=&$this->getModel('classleave');
	$r = $model->getTotalWorkingDays($f1date,$t1date,$wds);
	$r = $model->getTotalHalfWorkingDays($f1date,$t1date,$hads);
	foreach($students as $student){
		$r=$model->getAbsentDays($f1date,$t1date,$student->id,$abs);
		$r=$model1->getLeaveDays($f1date,$t1date,$student->id,$ls);
		
		$twds = $wds[0]['days'];
		$thwds = $hads[0]['hdays'];
		$tls = $ls[0]['ls'];
		$tabs = $abs[0]['abs'];
//echo '(('.$twds.'+('.$thwds.'/2'.')-'.$tabs.')/('.$twds.'+('.$thwds.'/2)))*100)';
		$percent = round(((($twds+($thwds/2))-$tabs/2)/($twds+($thwds/2)))*100,2);
		//$percent = round(((($twds+($thwds/2))-$tabs-$tls)/($twds+($thwds/2)))*100,2);
		echo '<tr>';
		echo '<td><input type="checkbox" name="cid[]" id="cid[]" value="'.$student->id.'" /></td>';
		echo '<td>'.$student->registerno.'</td>';
		echo '<td>'.$student->firstname.'</td>';
		echo '<td>'.($twds+$thwds/2).'</td>';
		echo '<td>'.round($tabs/2.0,1).'</td>';
		echo '<td>'.round($tls/2.0,1).'</td>';
		echo '<td>'.$percent.'</td>';
		echo '</tr>';
		$i++;
	}
?>
</table>

<table borde="0" width="100%" cellspacing="2" cellpadding="3">
<tr><td>SMS Message:</td><td>
<?php
	$editor =& JFactory::getEditor();
	$params = array( 'smilies'=> '0' ,
		'style'  => '1' ,
		'layer'  => '0' ,
		'table'  => '0' ,
		'clear_entities'=>'0'
	);
	echo $editor->display( 'smstext', $this->rec->smstext, '200', '200', '20', '20', false, null, null, null, $params );

?>
</td></tr>

</table>
<div class="form-actions">
  <button type="submit" class="btn btn-primary" value="Send" name="send">Send</button>
 
</div> 
	
<input type="hidden" name="controller" value="attendancereports" >
<input type="hidden" name="view" value="attendancereports" >
<input type="hidden" name="layout" value="classattendance" >
<input type="hidden" name="task" value="sendsms" >
<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" >

</form>
					</div>
				</div><!--/span-->
			
			</div><!--/row-->
