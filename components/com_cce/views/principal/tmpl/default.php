
<?php
	    $user =& JFactory::getUser();
	    $groups = $user->get('groups');
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
     include_once (JPATH_ROOT.DS.'components'.DS.'com_cce'.DS.'libchart'.DS.'classes'.DS.'libchart.php');
	$imagechart1 = JURI::base() . 'components/com_cce/libchart/attendance/';
	$Itemid = JRequest::getVar('Itemid');
	$model = & $this->getModel();
	$model4 = & $this->getModel('news');
	$courses=$model->getCurrentCourses();
	$cdate=date('d-m-Y');
	$staffphotoDir = JURI::base() . 'components/com_cce/staffphoto/';
 	$studentphotoDir = JURI::base() . 'components/com_cce/studentsphoto/';
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
		$userlog= JRoute::_('index.php?option=com_users&view=login', false);
		$model->countStudents($tstudents);
		$model->countstaff($tstaffs);	
		$model->countstudentabsentees($tabsent);
		$model->upcomingEvents($uevents);
	     foreach($groups as $group) {
		 if($group!=9)
		{
			?>
						<div class="alert alert-error">
							<button type="button" class="close" data-dismiss="alert">×</button>
							<strong>Oh Sorry!</strong>you do not have Permission to view this Page !
						</div>
						<a class="btn btn-info" href="<?php echo $userlog; ?>">
						<i class="icon icon-color icon-locked"></i>  
								Click here                                            
						</a>
		<?php
			return;
		}	
		}
?>


			<div class="sortable row-fluid">
				<a data-rel="tooltip" title="<?php echo $tstudents->totalstudents.'  Students.'; ?>" class="well span3 top-block" href="#">
					<span class="icon32 icon-green icon-users"></span>
					<div>Total Students</div>
					<div><?php echo $tstudents->totalstudents; ?></div>
					<span class="notification"><?php echo $tstudents->totalstudents; ?></span>
				</a>

				<a data-rel="tooltip" title="<?php echo $tstaffs->totalstaffs.'  Staffs.'; ?>" class="well span3 top-block" href="#">
					<span class="icon32 icon-red icon-user"></span>
					<div>Staff Members</div>
					<div><?php echo $tstaffs->totalstaffs; ?></div>
					<span class="notification green"><?php echo $tstaffs->totalstaffs; ?></span>
				</a>

				<a data-rel="tooltip" title="<?php echo count($tabsent).' Absentees'; ?>" class="well span3 top-block" href="#">
					<span class="icon32 icon-color icon-calendar"></span>
					<div>Absentees</div>
					<div><?php echo count($tabsent); ?></div>
					<span class="notification yellow"><?php echo count($tabsent); ?></span>
				</a>
				
				
				<a data-rel="tooltip" title="<?php echo date("l", strtotime($user->lastvisitDate)); ?>" class="well span3 top-block" href="#">
					<span class="icon32 icon-color icon-unlocked"></span>
					<div>Last Login</div>
					<div><?php echo date("d-m-Y", strtotime($user->lastvisitDate)); ?></div>
					<span class="notification red"><?php echo date("Y", strtotime($user->lastvisitDate)); ?></span>
				</a>
			</div>

			<div class="row-fluid sortable">
				<div class="box span4">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-list"></i> <strong>Today's Absentees</strong></h2>
						<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
						</div>
					</div>
					<div class="box-content" style="height:300px; overflow:auto;">
						<table class="table table-striped table-bordered">
							<thead>
								<tr>
								<th>Class</th>
								<th>Attendance</th>
								</tr>
								</thead>
								<tbody>
							<?php
							 $ccdate=JArrayHelper::mysqlformat($cdate);	 
								foreach($courses as $course)
									{
											$model->getAbsenteesByDate($course->id,$ccdate,$data);

							?>
					
                                <tr>
								<td>
									<?php echo $course->code;?>
								</td>
								<td><?php
										$presents=$model->getstudentpresent($ccdate,$course->id,$data1);
									 if($data1)
									 {
									  if(count($data)==0)
									  {
										  echo '<span class="label label-success">All present</span>'; 
									  } 
									  else{
										  echo '<span class="label label-warning">'.count($data).' Absentees</span>'; 
										}
									  }
									  else{
									   echo ' <span class="label label-important">Not taken</span>';
									  }
								    
									  ?> 
								  
								</td>
							</tr>
														
						  <?php
									}
						  ?>
						  </tbody>
							</table>
						
					</div>
				</div><!--/span-->
					
			
				<div class="box span4">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-user"></i> <strong>Class Teachers</strong></h2>
						<div class="box-icon">
								<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
						</div>
					</div>
				
					<div class="box-content">
						<div class="box-content" style="height:280px; overflow:auto;">
							<ul class="dashboard-list">
								<?php
								$staffs=$model->getStaffs();
								$model6=& $this->getModel('staffattendance');
								$todaydate=date('Y-m-d');
								foreach($staffs as $staff)
								{
								?>
								<li>
									<a href="#">
											<?php
								$filename=$model->getsiglestaffphoto($staff->id,$file);
						        if($file->image_name)
						        {
					     		?>
								<img src="<?php echo $staffphotoDir.$file->scode.'.'.$file->extention; ?>" class="dashboard-avatar" id="preview_img" alt="photo" />
							<?php
								}else{ ?>
								<img src="<?php echo $staffphotoDir.'no-image.gif'; ?>" class="dashboard-avatar" id="preview_img" alt="photo"  />
								<?php } ?>
								  </a>
										<strong>Name:</strong> <a href="#"><?php echo $staff->firstname.' '.$staff->middlename.' '.$staff->lastname;?>
									</a><br>
									<strong>Dept:</strong>
								  <?php 
									$model->getDepartment($staff->department,$dpt);
									echo $dpt->departmentname;
									?>           
									<br>
									<strong>Status:</strong> 
									<?php 
									$presents=$model6->getstaffpresent($ccdate,$data1);
									$model6->getStaffAbsenteeByid($staff->id,$ccdate,$staffabsent);
									if(!$data1)
									{
										echo '<span class="label label-warning">Not Taken</span>';
									}
									else{
										if(!$staffabsent)
										{
										echo '<span class="label label-success">Present</span>';
										}
										else{
										echo '<span class="label label-important">Absent</span>';
										}
									}
									?>
									
								</li>
								<?php
							}
								?>
							</ul>
						</div>
					</div>
				</div><!--/span-->		
			
			<div class="box span4">
					<div class="box-header well" data-original-title>
						<h2><i class="icon icon-color icon-date"></i> <strong>Upcoming Events</strong></h2>
						<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
						</div>
					</div>
				
					<div class="box-content">
						<div class="box-content" style="height:280px; overflow:auto;">
							<ul class="dashboard-list">
								<?php
								$todaydate=date('Y-m-d');
								foreach($uevents as $event)
								{
								?>
								<li>
									<div class="row-fluid">
									<div class="span4">
									<div  class="span8 label label-success pull-right">
										<div align="center">
										<?php echo date("F", strtotime($event->cdate)); ?><br>
										<?php echo '<span style="font-size:18px;font-weight:bold;">'.date("j", strtotime($event->cdate)).'</span>'; ?><br>
										<?php echo date("D", strtotime($event->cdate)); ?><br>
										</div>
										
									</div>
									</div>
									<div class="span8">
									<strong>Event  :</strong> <a href="#"><?php echo $event->description;?>
									</a><br>
									<strong>Day  :</strong> <?php echo $event->daytype; ?><br>
				
									</div>
									</div>
															
								</li>
								<?php
							}
								?>
							</ul>
						</div>
					</div>
				</div><!--/span-->		
				
				
			</div><!--/row-->

	<div class="row-fluid sortable">
				<div class="box span8">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-edit"></i><strong>SMS APPROVAL QUEUE</strong></h2>
						<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
						</div>
					</div>
					<div class="box-content">
						<table class="table table-striped table-bordered">
						  <thead>
							  <tr>
								  <th class="hidden-phone">S.No</th>
								  <th>Date</th>
								  <th class="hidden-phone">Time</th>
								  <th>Sms Text</th>
                                  <th>Sent By</th>
                                  <th class="hidden-phone">Sent To</th>
                                  <th width="15%">Approve</th>	
                                  <th width="15%">Reject</th>					
                              	  </tr>
						  </thead>   
						  <tbody>
<?php
$model2 = $this->getModel('sms');
$s = $model2->getStudentASMSLog($recs);
$i=1;
foreach($recs as $rec)
{
	echo "<tr>";
	echo "<td class='hidden-phone'>$i</td><td>$rec->fsmsdate</td><td class='hidden-phone'>$rec->smstime</td><td>$rec->smstext</td><td>$rec->sentby</td><td class='hidden-phone'>$rec->sentto</td><td>";
	if($rec->status==='N')
	{
		?>
	<form action="index.php" method="POST" name="addform" id="addform" onSubmit="return stest()">
        <button class="btn btn-small btn-success" name="approve"  value="Approve"><i class="icon icon-darkgray icon-check"></i>  Approve</button>
		<input type="hidden" name="option" value="<?php echo JRequest::getVar('option'); ?>" />
		<input type="hidden" id="logid" name="logid" value="<?php echo $rec->id; ?>" />
		<input type="hidden" id="smstext" name="smstext" value="<?php echo $rec->smstext; ?>" />
		<input type="hidden" id="view" name="view" value="sms" />
		<input type="hidden" id="layout" name="layout" value="smsaqueue" />
		<input type="hidden" id="controller" name="controller" value="sms" />
		<input type="hidden" name="task" id="task" value="principalapprovestudentsms" />
		<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
	</form>
	<td>
		<form action="index.php" method="POST" name="addform" id="addform" >
	     <button class="btn btn-small btn-danger" name="cancel"  value="Cancel"><i class="icon-trash icon-white"></i>  Reject</button>
		<input type="hidden" name="option" value="<?php echo JRequest::getVar('option'); ?>" />
		<input type="hidden" id="logid" name="logid" value="<?php echo $rec->id; ?>" />
		<input type="hidden" id="view" name="view" value="sms" />
		<input type="hidden" id="layout" name="layout" value="smsaqueue" />
		<input type="hidden" id="controller" name="controller" value="sms" />
		<input type="hidden" name="task" id="task" value="rejectsms" />
		<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
	</form>
	</td>
		<?php	
	}
	echo "</td></tr>";
	$i++;
}
?>
							 </tbody>
					  </table>            
					</div>
                     

				</div><!--/span-->
				
				<div class="box span4">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-th"></i> <strong>Office Desk</strong></h2>
						<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
						</div>
					</div>
					<div class="box-content" >
						<div class="label label-info">
                    <?php
							$model3 = $this->getModel('officedesk');
							$model3->getDeskInfo($odesk);
							echo $odesk->message;
                    ?>          
                    </div>
                  </div>
				</div><!--/span-->
			</div><!--/row-->



<div class="sortable row-fluid">
<div class="box span4">
					<div class="box-header well">
						<h2><i class="icon-th"></i> <strong>News</strong></h2>
						<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
						</div>
					</div>
					<div class="box-content"  style="height:200px;">
						<ul class="nav nav-tabs" id="myTab">
							<li class="active"><a href="#info"><strong>Student's News</strong></a></li>
							<li><a href="#custom"><strong>Staff's News</strong></a></li>
							<li><a href="#messages"><strong>Parent's News</strong></a></li>
						</ul>
						 
						<div id="myTabContent" class="tab-content">
							<div class="tab-pane active" id="info">
								<?php 
								$model4->getSideBarStudentNews($stnews);
									echo '<div class="alert alert-info">'.$stnews->newstext1.'</div>';
								?> 
							</div>
							<div class="tab-pane" id="custom">
							<?php 
								$model4->getSideBarStaffNews($staffnews);
								echo '<div class="alert alert-info">'.$staffnews->newstext2.'</div>';
								?> 
							</div>
							<div class="tab-pane" id="messages">
							 <?php 
								$model4->getSideBarParentNews($pnews);
								echo '<div class="alert alert-info">'.$pnews->newstext3.'</div>';
								?> 
						
							</div>
						</div>
					</div>
				</div><!--/span-->
					
				<div class="box span4">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-user"></i> <strong>Staff Birthdays</strong></h2>
						<div class="box-icon">
								<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
						</div>
					</div>
					<div class="box-content">
						<div class="box-content" style="height:180px; overflow:auto;">
							<ul class="dashboard-list">
								<?php
								$staffbirthdays=$model->getStaffBirthDays();
								if(!$staffbirthdays)
								{
									echo '<span class="label label-warning">No Birthday Celebrants today.</span>';
								}
								foreach($staffbirthdays as $staffb)
								{
								?>
								<li>
									<a href="#">
											<?php
								$filename=$model->getsiglestaffphoto($staffb->id,$file);
						        if($file->image_name)
						        {
					     		?>
								<img src="<?php echo $staffphotoDir.$file->scode.'.'.$file->extention; ?>" class="dashboard-avatar" id="preview_img" alt="photo" />
							<?php
								}else{ ?>
								<img src="<?php echo $staffphotoDir.'no-image.gif'; ?>" class="dashboard-avatar" id="preview_img" alt="photo"  />
								<?php } ?>
								  </a>
										<strong>Name:</strong> <a href="#"><?php echo $staffb->firstname.' '.$staffb->middlename.' '.$staffb->lastname;?>
									</a><br>
									<strong>Dob:</strong> <?php echo JArrayHelper::indianDate($staffb->dob); ?><br>
									<strong>Dept:</strong> <span class="label label-warning">
								  <?php 
									$model->getDepartment($staffb->department,$dpt);
									echo $dpt->departmentname;
									?>
									</span>                                  
								</li>
								<?php
							}
								?>
							</ul>
						</div>
					</div>
				</div><!--/span-->		
								<div class="box span4">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-user"></i> <strong>Student Birthdays</strong></h2>
						<div class="box-icon">
								<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
						</div>
					</div>
					<div class="box-content">
						<div class="box-content" style="height:180px; overflow:auto;">
							<ul class="dashboard-list">
								<?php
								$studentBirthDays=$model->getStudentBirthDays();
								if(!$studentBirthDays)
								{
									echo '<span class="label label-warning">No Birthday Celebrants today.</span>';
								}
								foreach($studentBirthDays as $studentb)
								{
								?>
								<li>
									<a href="#">
											<?php
								$filename=$model->getsiglestudentphoto($studentb->id,$file);
						        if($file->imagename)
						        {
					     		?>
								<img src="<?php echo $studentphotoDir.trim($file->imagename); ?>" class="dashboard-avatar" id="preview_img" alt="photo" />
							<?php
								}else{ ?>
								<img src="<?php echo $studentphotoDir.'no-image.gif'; ?>" class="dashboard-avatar" id="preview_img" alt="photo"  />
								<?php } ?>
								  </a>
										<strong>Name:</strong> <a href="#"><?php echo $studentb->firstname.' '.$studentb->middlename.' '.$studentb->lastname;?>
									</a><br>
									<strong>Dob:</strong> <?php echo JArrayHelper::indianDate($studentb->dob); ?><br>
									<strong>Gender:</strong> <span class="label label-warning"><?php echo $studentb->gender; ?></span>                                  
								</li>
								<?php
							}
								?>
							</ul>
						</div>
					</div>
				</div><!--/span-->					
				
</div>


<div class="row-fluid sortable">


				<div class="box span7">
						<form class="form-horizontal" method="POST" action="index.php">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-user"></i> <strong>Search Student</strong></h2>
						<div class="box-icon">
								<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
						</div>
					</div>
					<div class="box-content"  style="height:210px; overflow:auto;">
				<table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead>
							  <tr>
								  <th>Photo</th>
								  <th>Reg.No</th>
								  <th>Name</th>
								  <th>Class</th>
								  <th>Operation</th>
							  </tr>
						  </thead>   
						  <tbody>
							  <?php
							  $studentBirthDays=$model->getallStudent($getall);
							foreach($getall as $student) {
								$studentBirthDays=$model->getCourse($student->joinedclassid,$studentclass);
                      	         $link = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=studentprofile&controller=studentprofile&layout=profile&id='.$student->id);

                      	?>
							  
							<tr>
								<td>
								<?php
								$filename=$model->getsiglestudentphoto($student->id,$file);
						        if($file->imagename)
						        {
					     		?>
								<img src="<?php echo $studentphotoDir.trim($file->imagename); ?>" class="dashboard-avatar" id="preview_img" alt="photo" />
							<?php
								}else{ ?>
								<img src="<?php echo $studentphotoDir.'no-image.gif'; ?>" class="dashboard-avatar" id="preview_img" alt="photo"  />
								<?php } ?>	
								 </td>
								<td class="center"><?php echo $student->registerno ?></td>
								<td class="center"><?php echo $student->firstname.' '.$student->middlename.' '.$student->lastname; ?></td>
								<td class="center"><?php echo $studentclass->code; ?></td>
								<?php
								 echo '<td class="center hidden-phone">';
								 echo '<a class="btn btn-info" href="'.$link.'">';
								 echo '<i class="icon-zoom-in icon-white"></i>  View	</a>';
								 echo '</td>';
								?>
							</tr>
							<?php
								}
							?>
							 </tbody>
					  </table>            
					</div>
					</form>
				</div><!--/span-->		
				<div class="box span5">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-user"></i> <strong>Email to Staff</strong></h2>
						<div class="box-icon">
								<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
						</div>
					</div>
					<div class="box-content" style="height:230px; overflow:auto;">
									<form class="form-horizontal" method="POST" action="index.php">
										<BR>
								 <div class="control-group">
								<label class="control-label" for="selectError1">Select Staff</label>
								<div class="controls">
								  <select id="selectError1" multiple data-rel="chosen" name="To[]">
									<?php
								foreach($staffs as $staff)
								{
									echo '<option value="'.$staff->id.'">'.$staff->firstname.' '.$staff->middlename.'</option>';
								}
								?>
								  </select>
								</div>
							  </div>
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Subject</label>
								<div class="controls">
								  <input class="focused" id="focusedInput" type="text" name="subject" value="">
								</div>
							  </div>
					
							   <div class="control-group">
								<label class="control-label" for="selectError1">Message</label>
								<div class="controls">
								  <textarea class="autogrow" name="message"></textarea>
								</div>
							  </div>
							  <div class="form-actions">
								<button type="submit" class="btn btn-primary" name="send" value="send">Send Message</button>
								
							  </div>
								<input type="hidden" name="option" value="<?php echo JRequest::getVar('option'); ?>" />
								<input type="hidden" id="id" name="id" value="<?php echo $this->rec->id; ?>" />
								<input type="hidden" id="from" name="from" value="<?php echo $user->email; ?>" />
								<input type="hidden" id="view" name="view" value="principal" />
								<input type="hidden" id="Itemid" name="Itemid" value="<?php echo $Itemid; ?>" />
								<input type="hidden" id="controller" name="controller" value="sendmail" />
								<input type="hidden" name="task" id="task" value="Sendmail" />
					</div>
					</form>
				</div><!--/span-->							
</div>



<?php
	$il= JRequest::getVar('includeleave1');
	if(!$il) $includeleave='1';
	else $includeleave='0';
	$model = & $this->getModel('classattendance');
	$model1 = & $this->getModel('classleave');
	$model->gettodayabsentees($trecs);
?>


	<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-user"></i>  Today's Absentees</h2>
					
							<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
						</div>
					</div>
					<div class="box-content">
						<table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead>
							  <tr>
								  <th><input type="checkbox" value=""></th>
								  <th>Reg. No</th>
								  <th>Name</th>
								  <th>Class</th>
								  <th>Session</th>
							  </tr>
						  </thead>   
						  <tbody>
							  <?php
						$i=1;
							foreach($trecs as $rec){
								$model->getStudent($rec['studentid'],$srec);
								$model1->getRegularLeaveTakersByID($rec['studentid'],$lrec);
								$model->getCourse($srec->joinedclassid,$crec);
								echo '<tr>';
								echo '<td>'.$i++.'</td>';
								echo '<td>'.$srec->registerno.'</td>';
								echo '<td>'.$srec->firstname.'</td>';
								echo '<td>'.$crec->code.'</td>';
										if($rec['sessiontype']=='M' AND $rec['day']==1)
										{
											echo '<td><span class="label label-warning">Morning</span></td>';
										}
										else if($rec['day']==3 or $rec['day']==2)
										{
											echo '<td><span class="label label-success">Whole Day</span></td>';
										}
										else if($rec['sessiontype']=='E' AND $rec['day']==1)
										{
											echo '<td><span class="label label-important">Evening</span></td>';
										}
										else{
											echo '<td></td>';
											}
										
								echo '</tr>';
							}

                            ?>
							 </tbody>
					  </table>            
					</div>

				</div><!--/span-->
			
			</div><!--/row-->

