<?php
// No direct access
   defined('_JEXEC') OR DIE('Access denied..');
   $app = JFactory::getApplication();
   $iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');
   $model = & $this->getModel('cce');
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

   $masterlink= JRoute::_("index.php?Itemid=".$masterItemid);
   $masterlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&Itemid='.$masterItemid);
   $studentslink=JRoute::_("index.php?Itemid=".$studentsItemid);
   $attendancelink=JRoute::_("index.php?Itemid=".$attendanceItemid);
   $newslink=JRoute::_("index.php?Itemid=".$newsItemid);
   $smslink=JRoute::_("index.php?Itemid=".$smsItemid);
   $gradeslink=JRoute::_("index.php?Itemid=".$gradesItemid);
?>
<h1 align="right">Master Information</h1>
<hr />
<table width="100%" cellpadding="10">
        <tr style="border:none;">
                <td style="border:none;" align="center">
                        <a href="<?php echo $masterlink; ?>"><img src="<?php echo $iconsDir.'/master.png'; ?>" alt="Master Data" style="width: 128px; height: 128px;" /></a><br />
                        <a href="<?php echo $masterlink; ?>"><h2>Master Data</h2></a>
                </td>
                <td style="border:none;" align="center">
                        <a href="<?php echo $studentslink; ?>"><img src="<?php echo $iconsDir.'/students.png'; ?>" alt="Terms" style="width: 128px; height: 128px;" /></a><br />
                        <a href="<?php echo $termslink; ?>"><h2>Search Students</h2></a>
                </td>
                <td style="border:none;" align="center">
                        <a href="<?php echo $courseslink; ?>"><img src="<?php echo $iconsDir.'/courses.png'; ?>" alt="Courses" style="width: 64px; height: 64px;" /></a><br />
                        <a href="<?php echo $courseslink; ?>"><h1>Courses</h1></a>
                </td>
                <td align="center" style="border:none;">
                        <a href="<?php echo $managesubjectslink; ?>"><img src="<?php echo $iconsDir.'/managesubjects.png'; ?>" alt="Manage Subjects" style="width: 64px; height: 64px;" /></a><br />
                        <a href="<?php echo $managesubjectslink; ?>"><h1>Manage Subjects</h1></a>
                </td>
	</tr>
	<tr style="border:none;">
                <td align="center" style="border:none;">
                        <a href="<?php echo $subjectslink; ?>"><img src="<?php echo $iconsDir.'/subjects.png'; ?>" alt="Subjects" style="width: 64px; height: 64px;" /></a><br />
                        <a href="<?php echo $subjectslink; ?>"><h1>Class Subjects</h1></a>
                </td>
                <td align="center" style="border:none;">
                        <a href="<?php echo $studentslink; ?>"><img src="<?php echo $iconsDir.'/students.png'; ?>" alt="Students" style="width: 64px; height: 64px;" /></a><br />
                        <a href="<?php echo $studentslink; ?>"><h1>Students</h1></a>
                </td>
                <td align="center" style="border:none;">
                        <a href="<?php echo $departmentslink; ?>"><img src="<?php echo $iconsDir.'/departments.png'; ?>" alt="Departments" style="width: 64px; height: 64px;" /></a><br />
                        <a href="<?php echo $departmentslink; ?>"><h1>Departments</h1></a>
                </td>
	</tr><tr style="border:none;">
                <td align="center" style="border:none;">
                        <a href="<?php echo $staffslink; ?>"><img src="<?php echo $iconsDir.'/staffs.png'; ?>" alt="Staff" style="width: 64px; height: 64px;" /></a><br />
                        <a href="<?php echo $staffslink; ?>"><h1>Manage Staff</h1></a>
                </td>
                <td align="center" style="border:none;">
                        <a href="<?php echo $classteacherslink; ?>"><img src="<?php echo $iconsDir.'/classteachers.png'; ?>" alt="Class Teachers" style="width: 64px; height: 64px;" /></a><br />
                        <a href="<?php echo $classteacherslink; ?>"><h1>Class Teachers</h1></a>
                </td>
                <td align="center" style="border:none;">
                        <a href="<?php echo $allotlink; ?>"><img src="<?php echo $iconsDir.'/subjectteachers.png'; ?>" alt="Subject Teachers" style="width: 64px; height: 64px;" /></a><br />
                        <a href="<?php echo $allotlink; ?>"><h1>Subject Teachers</h1></a>
                </td>
        </tr>
</table>
<?php
   $faactivitieslink=JRoute::_("index.php?option=com_cce&controller=faactivities&view=faactivities");
   $fagradeslink=JRoute::_("index.php?option=com_cce&controller=fagrades&view=fagrades");
   $lsactivitieslink=JRoute::_("index.php?option=com_cce&controller=lsactivities&view=lsactivities");
   $attitudesandvalueslink=JRoute::_("index.php?option=com_cce&controller=attitudesandvalues&view=attitudesandvalues");
   $coscholasticaactivitieslink=JRoute::_("index.php?option=com_cce&controller=coscholasticaactivities&view=coscholasticaactivities");
   $coscholasticbactivitieslink=JRoute::_("index.php?option=com_cce&controller=coscholasticbactivities&view=coscholasticbactivities");
   $scholasticbgradeslink=JRoute::_("index.php?option=com_cce&controller=scholasticbgrades&view=scholasticbgrades");
   $tgradebooklink=JRoute::_("index.php?option=com_cce&controller=tgradebook&view=tgradebook");
?>
<br />
<h1>CCE-Master Information</h1>
<hr />
<table width="100%" cellpadding="10">
        <tr>
                <td align="center">
                        <a href="<?php echo $faactivitieslink; ?>"><img src="<?php echo $iconsDir.'/faactivities.png'; ?>" alt="FA Activities" style="width: 64px; height: 64px;" /></a><br />
                        <a href="<?php echo $faactivitieslink; ?>"><h1>FA Activities</h1></a>
                </td>
                <td align="center">
                        <a href="<?php echo $fagradeslink; ?>"><img src="<?php echo $iconsDir.'/fagrades.png'; ?>" alt="FA Grades" style="width: 64px; height: 64px;" /></a><br />
                        <a href="<?php echo $fagradeslink; ?>"><h1>FA Grades</h1></a>
                </td>
                <td align="center">
                        <a href="<?php echo $lsactivitieslink; ?>"><img src="<?php echo $iconsDir.'/lsactivities.png'; ?>" alt="Life Skills" style="width: 64px; height: 64px;" /></a><br />
                        <a href="<?php echo $lsactivitieslink; ?>"><h1>Life Skills</h1></a>
                </td>
	</tr><tr>
                <td align="center">
                        <a href="<?php echo $attitudesandvalueslink; ?>"><img src="<?php echo $iconsDir.'/attitudesandvalues.png'; ?>" alt="Attitude and Values" style="width: 64px; height: 64px;" /></a><br />
                        <a href="<?php echo $attitudesandvalueslink; ?>"><h1>Attitude and Values</h1></a>
                </td>
                <td align="center">
                        <a href="<?php echo $coscholasticaactivitieslink; ?>"><img src="<?php echo $iconsDir.'/coscholasticaactivities.png'; ?>" alt="CoScholastic-A Activities" style="width: 64px; height: 64px;" /></a><br />
                        <a href="<?php echo $coscholasticaactivitieslink; ?>"><h1>CoScholastic-A Activities</h1></a>
                </td>
                <td align="center">
                        <a href="<?php echo $coscholasticbactivitieslink; ?>"><img src="<?php echo $iconsDir.'/coscholasticbactivities.png'; ?>" alt="CoScholastic-B Activities" style="width: 64px; height: 64px;" /></a><br />
                        <a href="<?php echo $coscholasticbactivitieslink; ?>"><h1>CoScholastic-B Activities</h1></a>
                </td>
	</tr><tr>
                <td align="center">
                        <a href="<?php echo $scholasticbgradeslink; ?>"><img src="<?php echo $iconsDir.'/scholasticbgrades.png'; ?>" alt="Scholastic-B grades" style="width: 64px; height: 64px;" /></a><br />
                        <a href="<?php echo $scholasticbgradeslink; ?>"><h1>Scholastic-B Grades</h1></a>
                </td>
                <td align="center">
                        <a href="<?php echo $tgradebooklink; ?>"><img src="<?php echo $iconsDir.'/tgradebook.png'; ?>" alt="Grade Book Template" style="width: 64px; height: 64px;" /></a><br />
                        <a href="<?php echo $tgradebooklink; ?>"><h1>Grade Book Template</h1></a>
                </td>
                <td align="center">
                </td>
	</tr>
</table>
