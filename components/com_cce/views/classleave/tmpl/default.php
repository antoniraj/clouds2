
<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');
	JHTML::script('validate.js', 'components/com_cce/js/');
	$Itemid=JRequest::getVar('Itemid');
	$courseid=JRequest::getVar('courseid');
	$studentid=JRequest::getVar('studentid');
	$fromdate=JRequest::getVar('fromdate');
	$todate=JRequest::getVar('todate');
	if(!$fromdate) $fromdate=date('d-m-Y');
	if(!$todate) $todate=date('d-m-Y');
	$model = &$this->getModel();
	$courses = $model->getCurrentCourses();
	$rs = $model->getCourse($courseid,$rec);
	$students = $model->getStudents($courseid);
	$studentname=$model->getStudent($studentid,$srec);
	if(JRequest::getVar('go1')=='Ok')
		$studentid='';
        $iconsDir1 = JURI::base() . 'components/com_cce/images';
        $dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
        $modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=attendance&Itemid='.$masterItemid);
	$app =& JFactory::getApplication();
        $pathway =& $app->getPathway(); 
        $pathway->addItem('Home', $dashboardlink);
        $pathway->addItem('Attendance',$modulelink);
        $pathway->addItem("Leave Record");


?>
<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-edit"></i> Class Leave Resgister</h2>
						<div class="box-icon">
						</div>
					</div>
					<div class="box-content">
<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce'); ?>" method="POST" name="adminForm">
<div class="row-fluid">
<div class="span4">
							   <div class="control-group" >
								<label class="control-label" for="selectError">Select Class</label>
								<div class="controls">
								  <select id="selectError" data-rel="chosen" name="courseid" onChange="submit();">
										<option value="">Select</option>
									<?php

											foreach($courses as $course) :
											echo "<option value=\"".$course->id."\" ".($course->id == $courseid ? "selected=\"yes\"" : "").">".$course->code."</option>";
											endforeach;
									?>
								  </select>
								</div>
							  </div>
</div>
<div class="span3">

					<div class="control-group">
							  <label class="control-label" for="date01">Student Name</label>
							  <div class="controls">
								 <select id="selectError6" data-rel="chosen" name="studentid" onChange="submit();">
										<option value="">Select</option>
                                        <?php
										foreach($students as $student) :
											echo "<option value=\"".$student->id."\" ".($student->id == $studentid ? "selected=\"yes\"" : "").">".$student->firstname."</option>";
										endforeach;
										?>
							</select>
							  </div>
							</div>
</div>
</div>
<div class="row-fluid">
<div class="span4">
 							<div class="control-group">
							  <label class="control-label" for="date05">From Date</label>
							  <div class="controls">
								<input type="text" class="datepicker"  name="fromdate" value="<?php echo JArrayHelper::indianDate($fromdate); ?>">
							  </div>
							</div>
</div>
<div class="span3">
							<div class="control-group">
							  <label class="control-label" for="date01">To Date</label>
							  <div class="controls">
								<input type="text" class="datepicker"  name="todate" value="<?php echo JArrayHelper::indianDate($todate); ?>">
							  </div>
							</div>
</div>
</div>
<div class="form-actions">
<button class="btn btn-primary" name="go" value="Go"><i class="icon-plus-sign icon-white"></i> Go</button>
</div>

	     <input type="hidden" name="controller" value="classleave" >
        <input type="hidden" name="view" value="classleave" >
        <input type="hidden" name="layout" value="default" >
        <input type="hidden" name="task" value="go" >
      	<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" >
	 </form>			
<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce'); ?>" method="POST" name="adminForm">			
										
	<table class="table table-striped table-bordered bootstrap-datatable datatable">
	  <thead>
		  <tr>
			  <th>S.No</th>
			  <th>Date</th>
			  <th>Day</th>
			  <th>Leave[Morning]</th>
			  <th>Leave[Evening] <input type="checkbox" onchange="checkAll()" name="chk[]" /></th>
		  </tr>
	  </thead>   
	  <tbody>
<?php
	//echo $from1date;
	//echo $to1date;
	$i=1;
	$toDate = new DateTime($todate);
	$fromDate = new DateTime($fromdate);
	//$span = $toDate->diff($fromDate);
	//if($fromDate < $toDate)
	//echo "Your subscription ends in {$span->format('%d')} days!";
	while($fromDate <= $toDate){
		echo '<tr>';
		echo '<td>'.$i.'</td>';
		echo '<td>'.$fromDate->format('d-m-Y').'</td>';
		echo '<td>'.$fromDate->format('D').'</td>';
		$s = $model->getLeaveByDateAndSession($studentid,$fromDate->format('Y-m-d'),'M',$xx);
		if(!$s) 
			echo '<td><input type="checkbox" name="lrec[]" value="n:'.$studentid.':'.$courseid.':'.$fromDate->format('Y-m-d').':M'.'" /></td>';
		else{ 
			echo '<td><input type="checkbox" name="lrec[]" checked="true" value="'.$xx[0]['id'].':'.$studentid.':'.$courseid.':'.$fromDate->format('Y-m-d').':M'.'" /></td>';
			$reason=$xx[0]['reason'];
		}
		$s = $model->getLeaveByDateAndSession($studentid,$fromDate->format('Y-m-d'),'E',$xx);
		if(!$s) 
			echo '<td><input type="checkbox" name="lrec[]" value="n:'.$studentid.':'.$courseid.':'.$fromDate->format('Y-m-d').':E'.'" /></td>';
		else{ 
			echo '<td><input type="checkbox" name="lrec[]" checked="true" value="'.$xx[0]['id'].':'.$studentid.':'.$courseid.':'.$fromDate->format('Y-m-d').':E'.'" /></td>';
			$reason=$xx[0]['reason'];
		}
		echo '</tr>';
		$fromDate->modify('+1 days');
		$i++;
	}
	echo '<tr><td colspan="2" align="right" style="vertical-align: middle;">Reason:</td><td colspan="3" style="vertical-align: middle;"><textarea name="reason" style="height: 60px;" rows="5" cols="50">'.$reason.'</textarea></td></tr>';
?>
							 </tbody>
					  </table>            
			<div class="form-actions">		
			<button class="btn btn-primary" name="save" value="save"><i class="icon-plus-sign icon-white"></i> Save</button>		
			</div>	
			        <input type="hidden" name="controller" value="classleave" >
        <input type="hidden" name="view" value="classleave" >
        <input type="hidden" name="layout" value="default" >
        <input type="hidden" name="task" value="saveleave" >
      	<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" >
        <input type="hidden" name="courseid" value="<?php echo $courseid; ?>" >
        <input type="hidden" name="studentid" value="<?php echo $studentid; ?>" >
        <input type="hidden" name="fromdate" value="<?php echo $fromdate; ?>" >
        <input type="hidden" name="todate" value="<?php echo $todate; ?>" >
</form>
					</div>
				</div><!--/span-->
			
			</div><!--/row-->

