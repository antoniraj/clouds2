<?php
// No direct access
   defined('_JEXEC') OR DIE('Access denied..');
   $app = JFactory::getApplication();
   $iconsDir = JURI::base() . 'components/com_cce/images/64x64';
   $iconsDir1 = JURI::base() . 'components/com_cce/images';

	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');

   $model = & $this->getModel('cce');
 $model = & $this->getModel('cce');
   $this->assignRef( 'model', $model);
   $Itemid=JRequest::getVar('Itemid');
   $app =& JFactory::getApplication();
   $pathway =& $app->getPathway();
   $pathway->addItem('Courses');
   $dashboardItemid = $model->getMenuItemid('topmenu','Portal');
   if($dashboardItemid) ;
   else{
   	$dashboardItemid = $model->getMenuItemid('manageschool','Home');	
   }
   $courseItemid = $model->getMenuItemid('master','Courses');
   if($courseItemid) ;
   else{
   	$courseItemid = $model->getMenuItemid('topmenu','Portal');	
   }
   $subjectteacherItemid = $model->getMenuItemid('assignments','Subject Teachers');
   if($subjectteacherItemid) ;
   else{
   	$subjectteacherItemid = $model->getMenuItemid('topmenu','Portal');	
   }
   $classteacherItemid = $model->getMenuItemid('assignments','Class Teachers');
   if($classteacherItemid) ;
   else{
   	$classteacherItemid = $model->getMenuItemid('topmenu','Portal');	
   }
   $csItemid = $model->getMenuItemid('master','Course Subjects');
   if($csItemid) ;
   else{
   	$csItemid = $model->getMenuItemid('topmenu','Portal');	
   }

   $dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);

   $courselink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=courses&view=courses&task=display&Itemid='.$courseItemid);
   $deplink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=departments&view=departments&task=departmentcourses&layout=departmentcourses&Itemid='.$courseItemid);
   $cslink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=subjects&view=subjects&task=display&Itemid='.$csItemid);
   $subjectteacherlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=subjects&view=subjectteachers&task=display&Itemid='.$subjectteacherItemid);
   $classteacherlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=classteachers&view=classteachers&task=display&Itemid='.$classteacherItemid);

?>


<br>
<div align="center">
<div class="row-fluid">
				<div class="span3 show-grid">
				              <a href="<?php echo $courselink; ?>"><img src="<?php echo $iconsDir.'/courses.png'; ?>" alt="Courses" style="width: 84px; height: 84px;" /></a><br />
                        <a href="<?php echo $courselink; ?>"><h2 class="item-page-title">Course Details</h2></a>
				</div>
				<div class="span3 show-grid">
				              <a href="<?php echo $deplink; ?>"><img src="<?php echo $iconsDir.'/courses.png'; ?>" alt="Courses" style="width: 84px; height: 84px;" /></a><br />
                        <a href="<?php echo $deplink; ?>"><h2 class="item-page-title">Department Courses</h2></a>
				</div>
				<div class="span3 show-grid">
				           <a href="<?php echo $cslink; ?>"><img src="<?php echo $iconsDir.'/coursesubjects.png'; ?>" alt="Course Subjects" style="width: 80px; height: 80px;" /></a><br />
                        <a href="<?php echo $cslink; ?>"><h2 class="item-page-title">Course Subjects</h2></a>
            
				</div>
				<div class="span3 show-grid">
				         <a href="<?php echo $subjectteacherlink; ?>"><img src="<?php echo $iconsDir.'/subjectteachers.png'; ?>" alt="Subject Teacher" style="width: 80px; height: 80px;" /></a><br />
                        <a href="<?php echo $subjectteacherlink; ?>"><h2 class="item-page-title">Subject Teachers</h2></a>
              
				</div>
			</div>
<div class="row-fluid">
				<div class="span3 show-grid">
				         <a href="<?php echo $classteacherlink; ?>"><img src="<?php echo $iconsDir.'/classteacher.png'; ?>" alt="Class Teachers" style="width: 80px; height: 80px;" /></a><br />
                        <a href="<?php echo $classteacherlink; ?>"><h2 class="item-page-title">Class Teachers </h2></a>
              
				</div>
			</div>
			</div>
			
<br>
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
</div>
