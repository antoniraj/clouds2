<?php
// No direct access
   defined('_JEXEC') OR DIE('Access denied..');
   $app = JFactory::getApplication();
   $iconsDir = JURI::base() . 'components/com_cce/images/64x64';
   $iconsDir1 = JURI::base() . 'components/com_cce/images';

   $model = & $this->getModel('cce');
   $model1 = & $this->getModel('classattendance');
   
   $masterItemid = $model->getMenuItemid('manageschool','Master');
   if($masterItemid) ;
   else{
   	$masterItemid = $model->getMenuItemid('manageschool','Home');	
   }
   $studentsItemid = $model->getMenuItemid('manageschool','Students');
   if($studentsItemid) ;
   else{
   	$studentsItemid = $model->getMenuItemid('manageschool','Home');	
   }
   $staffItemid = $model->getMenuItemid('manageschool','Master');
   if($staffItemid) ;
   else{
   	$staffItemid = $model->getMenuItemid('manageschool','Home');	
   }
   $courseItemid = $model->getMenuItemid('manageschool','Master');
   if($courseItemid) ;
   else{
   	$courseItemid = $model->getMenuItemid('manageschool','Home');	
   }
   $attendanceItemid = $model->getMenuItemid('manageschool','Attendance');
   if($attendanceItemid) ;
   else{
   	$attendanceItemid = $model->getMenuItemid('manageschool','Home');	
   }
   $gradesItemid = $model->getMenuItemid('manageschool','Grades');
   if($gradesItemid) ;
   else{
   	$gradesItemid = $model->getMenuItemid('manageschool','Home');	
   }
   $smsItemid = $model->getMenuItemid('manageschool','SMS');
   if($smsItemid) ;
   else{
   	$smsItemid = $model->getMenuItemid('manageschool','Home');	
   }
   $newsItemid = $model->getMenuItemid('manageschool','News');
   if($newsItemid) ;
   else{
   	$newsItemid = $model->getMenuItemid('manageschool','Home');	
   }
   $feeItemid = $model->getMenuItemid('topmenu','fees1');
   if($feeItemid) ;
   else{
   	$feeItemid = $model->getMenuItemid('manageschool','Home');	
   }
   $libraryItemid = $model->getMenuItemid('manageschool','Library');
   if($libraryItemid) ;
   else{
   	$libraryItemid = $model->getMenuItemid('manageschool','Home');	
   }
   $transportItemid = $model->getMenuItemid('manageschool','Transport');
   if($transportItemid) ;
   else{
   	$transportItemid = $model->getMenuItemid('manageschool','Home');	
   }
   $timetableItemid = $model->getMenuItemid('manageschool','TimeTable');
   if($timetableItemid) ;
   else{
   	$timetableItemid = $model->getMenuItemid('manageschool','Home');	
   }

   $masterlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=master&Itemid='.$masterItemid);
   $studentslink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=students&Itemid='.$studentsItemid);
   $stafflink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=staff&Itemid='.$staffItemid);
   $courselink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=courses&Itemid='.$courseItemid);
   $attendancelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=attendance&Itemid='.$attendanceItemid);
   $newslink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=news&Itemid='.$newsItemid);
   $smslink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=sms&view=sms&task=display&layout=smsqueue&Itemid='.$smsItemid);
   //$smslink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=sms&Itemid='.$smsItemid);
   $gradeslink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=grades&Itemid='.$gradesItemid);
   $feelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=fees&Itemid='.$feeItemid);
   $transportlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=transport&Itemid='.$transportItemid);
   $librarylink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=library&Itemid='.$libraryItemid);
   $timetablelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=timetable&Itemid='.$timetableItemid);
	$model->countStudents($tstudents);
	$model->countstaff($tstaffs);	
	$model1->countstudentabsentees($tabsent);
	    $user =& JFactory::getUser();	

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
					<div><?php echo date($user->lastvisitDate); ?></div>
					<!-- <span class="notification red"><?php echo $user->lastvisitDate; ?></span>  -->
				</a>
			</div>
  <div align="center">               
	<div class="row-fluid">
				<div class="span3 show-grid">
				 <a  href="<?php echo $masterlink; ?>"><img src="<?php echo $iconsDir1.'/1master.png'; ?>" alt="Master Data" style="width: 100px; height: 100px;" /></a><br />
                 <a title="Master Settings" data-rel="tooltip" href="<?php echo $masterlink; ?>"><h2 class="item-page-title">Master Settings</h2></a>
				</div>
				<div class="span3 show-grid">
				 <a href="<?php echo $studentslink; ?>"><img src="<?php echo $iconsDir1.'/1students.png'; ?>" alt="Students" style="width: 100px; height: 100px;" /></a><br />
                        <a title="Students" data-rel="tooltip" href="<?php echo $studentslink; ?>"><h2 class="item-page-title">Students</h2></a>
               
				</div>
				<div class="span3 show-grid">
				  <a href="<?php echo $stafflink; ?>"><img src="<?php echo $iconsDir1.'/1staff.png'; ?>" alt="Staff" style="width:100px; height: 100px;" /></a><br />
                  <a title="Staff" data-rel="tooltip" href="<?php echo $stafflink; ?>"><h2 class="item-page-title">Staff</h2></a>
               
				</div>
				<div class="span3 show-grid">
				  <a href="<?php echo $courselink; ?>"><img src="<?php echo $iconsDir1.'/1courses.png'; ?>" alt="Courses" style="width: 100px; height: 100px;" /></a><br />
                        <a title="Courses" data-rel="tooltip" href="<?php echo $courselink; ?>"><h2 class="item-page-title">Courses</h2></a>
               
				</div>
	</div>
    
    	<div class="row-fluid">
				<div class="span3 show-grid">
				        <a href="<?php echo $timetablelink; ?>"><img src="<?php echo $iconsDir1.'/timetable.png'; ?>" alt="Time Table" style="width: 100px; height: 100px;" /></a><br />
                        <a title="Time Table" data-rel="tooltip" href="<?php echo $timetablelink; ?>"><h2 class="item-page-title">Time Table</h2></a>
             
				</div>
				<div class="span3 show-grid">
				    <a href="<?php echo $attendancelink; ?>"><img src="<?php echo $iconsDir1.'/1attendance.png'; ?>" alt="Attendance" style="width: 100px; height: 100px;" /></a><br />
                        <a title="Attendance" data-rel="tooltip" href="<?php echo $attendancelink; ?>"><h2 class="item-page-title">Attendance</h2></a>
              
				</div>
				<div class="span3 show-grid">
				           <a href="<?php echo $gradeslink; ?>"><img src="<?php echo $iconsDir1.'/1results.png'; ?>" alt="Grades" style="width: 100px; height: 100px;" /></a><br />
                        <a title="Grades" data-rel="tooltip" href="<?php echo $gradeslink; ?>"><h2 class="item-page-title">Exams & Grades</h2></a>
           
				</div>
				<div class="span3 show-grid">
				     <a href="<?php echo $smslink; ?>"><img src="<?php echo $iconsDir1.'/1sms.png'; ?>" alt="SMS" style="width: 100px; height: 100px;" /></a><br />
                        <a title="SMS" data-rel="tooltip" href="<?php echo $smslink; ?>"><h2 class="item-page-title">SMS</h2></a>
              
				</div>
			</div>
     	<div class="row-fluid">
				<div class="span3 show-grid">
				         <a href="<?php echo $newslink; ?>"><img src="<?php echo $iconsDir1.'/1news.png'; ?>" alt="News" style="width: 100px; height: 100px;" /></a><br />
                        <a title="News" data-rel="tooltip" href="<?php echo $newslink; ?>"><h2 class="item-page-title">News</h2></a>
          
				</div>
				<div class="span3 show-grid">
				         <a href="<?php echo $feelink; ?>"><img src="<?php echo $iconsDir1.'/1fee.png'; ?>" alt="Fees" style="width: 100px; height: 100px;" /></a><br />
                        <a title="Fees" data-rel="tooltip" href="<?php echo $feelink; ?>"><h2 class="item-page-title">Fees</h2></a>
              </div>
				<div class="span3 show-grid">
				        <a href="<?php echo $librarylink; ?>"><img src="<?php echo $iconsDir1.'/1library.png'; ?>" alt="Library" style="width: 100px; height: 100px;" /></a><br />
                        <a title="Library" data-rel="tooltip" href="<?php echo $librarylink; ?>"><h2 class="item-page-title">Library</h2></a>
            
				</div>
				<div class="span3 show-grid">
				          <a href="<?php echo $transportlink; ?>"><img src="<?php echo $iconsDir1.'/1transport.png'; ?>" alt="Transport" style="width: 100px; height: 100px;" /></a><br />
                        <a title="Transport" data-rel="tooltip" href="<?php echo $transportlink; ?>"><h2 class="item-page-title">Transport</h2></a>
             
				</div>
			</div>

</div>
