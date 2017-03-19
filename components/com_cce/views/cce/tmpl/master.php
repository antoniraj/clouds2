<?php
// No direct access
   defined('_JEXEC') OR DIE('Access denied..');
   $app = JFactory::getApplication();
   $iconsDir = JURI::base() . 'components/com_cce/images/64x64';

   $academicyearslink=JRoute::_("index.php?option=com_cce&controller=academicyears&view=academicyears");
   $termslink=JRoute::_("index.php?option=com_cce&controller=terms&view=terms");
   $courseslink=JRoute::_("index.php?option=com_cce&controller=courses&view=courses");
   $subjectslink=JRoute::_("index.php?option=com_cce&controller=subjects&view=subjects");
   $studentslink=JRoute::_("index.php?option=com_cce&controller=students&view=students");
   $departmentslink=JRoute::_("index.php?option=com_cce&controller=departments&view=departments");
   $staffslink=JRoute::_("index.php?option=com_cce&controller=staffs&view=staffs");
   $classteacherslink=JRoute::_("index.php?option=com_cce&controller=classteachers&view=classteachers");
   $allotlink=JRoute::_("index.php?option=com_cce&controller=subjects&view=subjectteachers");
   $managesubjectslink=JRoute::_("index.php?option=com_cce&controller=managesubjects&view=managesubjects");
?>
<h1>Master Information</h1>
<hr />
<table width="100%" cellpadding="10">
        <tr>
                <td align="center">
                        <a href="<?php echo $academicyearslink; ?>"><img src="<?php echo $iconsDir.'/academicyears.png'; ?>" alt="AcademicYears" style="width: 64px; height: 64px;" /></a><br />
                        <a href="<?php echo $academicyearslink; ?>"><h1>Academic Years</h1></a>
                </td>
                <td align="center">
                        <a href="<?php echo $termslink; ?>"><img src="<?php echo $iconsDir.'/terms.png'; ?>" alt="Terms" style="width: 64px; height: 64px;" /></a><br />
                        <a href="<?php echo $termslink; ?>"><h3>Current Term</h3></a>
                </td>
                <td align="center">
                        <a href="<?php echo $courseslink; ?>"><img src="<?php echo $iconsDir.'/courses.png'; ?>" alt="Courses" style="width: 64px; height: 64px;" /></a><br />
                        <a href="<?php echo $courseslink; ?>"><h1>Courses</h1></a>
                </td>
                <td align="center">
                        <a href="<?php echo $managesubjectslink; ?>"><img src="<?php echo $iconsDir.'/managesubjects.png'; ?>" alt="Manage Subjects" style="width: 64px; height: 64px;" /></a><br />
                        <a href="<?php echo $managesubjectslink; ?>"><h1>Manage Subjects</h1></a>
                </td>
	</tr>
	<tr>
                <td align="center">
                        <a href="<?php echo $subjectslink; ?>"><img src="<?php echo $iconsDir.'/subjects.png'; ?>" alt="Subjects" style="width: 64px; height: 64px;" /></a><br />
                        <a href="<?php echo $subjectslink; ?>"><h1>Class Subjects</h1></a>
                </td>
                <td align="center">
                        <a href="<?php echo $studentslink; ?>"><img src="<?php echo $iconsDir.'/students.png'; ?>" alt="Students" style="width: 64px; height: 64px;" /></a><br />
                        <a href="<?php echo $studentslink; ?>"><h1>Students</h1></a>
                </td>
                <td align="center">
                        <a href="<?php echo $departmentslink; ?>"><img src="<?php echo $iconsDir.'/departments.png'; ?>" alt="Departments" style="width: 64px; height: 64px;" /></a><br />
                        <a href="<?php echo $departmentslink; ?>"><h1>Departments</h1></a>
                </td>
	</tr><tr>
                <td align="center">
                        <a href="<?php echo $staffslink; ?>"><img src="<?php echo $iconsDir.'/staffs.png'; ?>" alt="Staff" style="width: 64px; height: 64px;" /></a><br />
                        <a href="<?php echo $staffslink; ?>"><h1>Manage Staff</h1></a>
                </td>
                <td align="center">
                        <a href="<?php echo $classteacherslink; ?>"><img src="<?php echo $iconsDir.'/classteachers.png'; ?>" alt="Class Teachers" style="width: 64px; height: 64px;" /></a><br />
                        <a href="<?php echo $classteacherslink; ?>"><h1>Class Teachers</h1></a>
                </td>
                <td align="center">
                        <a href="<?php echo $allotlink; ?>"><img src="<?php echo $iconsDir.'/subjectteachers.png'; ?>" alt="Subject Teachers" style="width: 64px; height: 64px;" /></a><br />
                        <a href="<?php echo $allotlink; ?>"><h1>Subject Teachers</h1></a>
                </td>
        </tr>
</table>
