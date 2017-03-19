<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	$Itemid = JRequest::getVar('Itemid');
	$model = & $this->getModel('classattendance');
	$model1 = & $this->getModel('classleave');
	$courses=$model->getCurrentCourses();
	$cdate = JRequest::getVar('cdate');
	if(!$cdate) $cdate=date('d-m-Y');
   	$iconsDir1 = JURI::base() . 'components/com_cce/images';


        $dashboardItemid = $model->getMenuItemid('manageschool','Dash Board');
        if($dashboardItemid) ;
        else{
                $dashboardItemid = $model->getMenuItemid('topmenu','Manage School');
        }
        $masterItemid = $model->getMenuItemid('attendance','Absentees By Date');
        if($masterItemid) ;
        else{
                $masterItemid = $model->getMenuItemid('topmenu','Manage School');
        }

        $dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
        $modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=attendance&Itemid='.$masterItemid);

	$app =& JFactory::getApplication();
        $pathway =& $app->getPathway(); 
        $pathway->addItem('Home', $dashboardlink);
        $pathway->addItem('Attendance',$modulelink);
        $pathway->addItem("Absentees by date");

?>


<?php
   
   $ccdate=JArrayHelper::mysqlformat($cdate);

  ?>
	<div class="row-fluid">
			         <div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-edit"></i> <strong>Absentees List</strong></h2>
						<div class="box-icon">
<div class="pull-right">
<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce'); ?>" method="POST" name="adminForm">
<label class="control-label" for="selectError">Select Date</label>
<div class="controls">
<div class="input-append">
<input  class="input-xlarge datepicker" id="date01" onchange="submit();" style="width:200px;" size="16" type="text" name="cdate" value="<?php echo $cdate; ?>"><button class="btn" name="go" value="Go">Go!</button>
</div>
</div>
<input type="hidden" name="controller" value="attendancereports" >
<input type="hidden" name="view" value="attendancereports" >
<input type="hidden" name="layout" value="absenteesbydate" >
<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" >
</form>
</div>

						</div>
					</div>
					<div class="box-content">
						<table  class="table  bootstrap-datatable datatable">
							  <thead>
								  <tr>
									  <th>Reg.No</th>
									  <th>Name</th>
									  <th>Class</th>
									  <th>Session</th>
									  <th>Reason</th>                                          
								  </tr>
							  </thead>   
							  <tbody>
								  <?php
							foreach($courses as $course){
								$model->getAbsenteesByDate($course->id,$ccdate,$data);
								$r=$model1->getAbsenteesByDatewithpermission($course->id,$ccdate,$lrec);
									$i=1;
									foreach($data as $rec){
										$r=$model->getStudent($rec['studentid'],$srec);
										echo '<tr>';
										echo '<td>'.$srec->registerno.'</td>';
										echo '<td>'.$srec->firstname.'</td>';
										echo '<td>'.$course->coursename.'-'.$course->sectionname.'</td>';
										if($rec['sessiontype']=='M' AND $rec['day']==1) {
											echo '<td><span class="label label-warning">Morning</span></td>';
										}
										else if($rec['day']=='3' or $rec['day']=='2') {
											echo '<td><span class="label label-success">Whole Day</span></td>';
										}
										else if($rec['sessiontype']=='E' AND $rec['day']==1) {
											echo '<td><span class="label label-important">Evening</span></td>';
										}
										else{
											echo '<td></td>';
										}
										echo '<td></td></tr>';
									}
							}	?>  
							  </tbody>
						 </table>  

    </div>
  </div>
  <!--/span--> 
</div>
<!--/row-->

