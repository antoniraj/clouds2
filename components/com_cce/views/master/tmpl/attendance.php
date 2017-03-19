<?php
// No direct access
   defined('_JEXEC') OR DIE('Access denied..');
   $app = JFactory::getApplication();
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');
   $iconsDir = JURI::base() . 'components/com_cce/images/64x64';
   $iconsDir1 = JURI::base() . 'components/com_cce/images';

   $model = & $this->getModel('cce');
 $model = & $this->getModel('cce');
   $this->assignRef( 'model', $model);
   $Itemid=JRequest::getVar('Itemid');
   $app =& JFactory::getApplication();
   $pathway =& $app->getPathway();
   $pathway->addItem('Attendance');
//   $model->logotitle();

   $dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);

   $alink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=classattendance&view=classattendance&layout=classattendance&task=display&Itemid='.$aItemid);
   $alink1= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=classattendance&view=classattendance&layout=quickattendance&task=display&Itemid='.$aItemid);
   $llink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=classleave&view=classleave&layout=classleave&task=display&Itemid='.$lItemid);

   $absenteesbydatelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=attendancereports&view=attendancereports&layout=absenteesbydate&task=display&Itemid='.$lItemid);
   $classattendancelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=attendancereports&view=attendancereports&layout=classattendance&task=display&Itemid='.$lItemid);
   $regularwithleavelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=attendancereports&view=attendancereports&layout=regularabsenteeswithleave&task=display&Itemid='.$lItemid);
   $regularwithoutleavelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=attendancereports&view=attendancereports&layout=regularabsenteeswithoutleave&task=display&Itemid='.$lItemid);
   $currentabsenteeslink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=attendancereports&view=attendancereports&layout=todayabsentees&task=display&Itemid='.$lItemid);
   $classeslink= JRoute::_('index.php?option=com_content&view=article&id=85');
   $classeslink1= JRoute::_('index.php?option=com_content&view=article&id=86');
   $classeslink2= JRoute::_('index.php?option=com_content&view=article&id=87');
   $last10link= JRoute::_('index.php?option=com_content&view=article&id=84');
?>


<div align="center">
<div class="alert alert-warning" align="left">
<span class="mytitle">Attendance</span>
</div>


	<div class="row-fluid">
				<div class="span2"></div>
				<div class="span3 show-grid">
				              <a href="<?php echo $alink; ?>"><img src="<?php echo $iconsDir1.'/attendanceregister.png'; ?>" alt="Attendance" style="width: 94px; height: 94px;" /></a><br />
                        <a href="<?php echo $alink; ?>"><h2 class="item-page-title">Attendance Register</h2></a>
				</div>
				<div class="span3 show-grid">
				              <a href="<?php echo $alink1; ?>"><img src="<?php echo $iconsDir1.'/attendanceregister.png'; ?>" alt="Attendance" style="width: 94px; height: 94px;" /></a><br />
                        <a href="<?php echo $alink1; ?>"><h2 class="item-page-title">Quick Attendance</h2></a>
				</div>
				<div class="span3 show-grid">
				            <a href="<?php echo $llink; ?>"><img src="<?php echo $iconsDir1.'/leaveregister.png'; ?>" alt="Leave" style="width: 94px; height: 94px;" /></a><br />
                        <a href="<?php echo $llink; ?>"><h2 class="item-page-title">Leave Register</h2></a>
             
				</div>
			</div>
<div class="alert alert-warning" align="left">
<span class="mytitle">Attendance Report</span>
</div>
	<div class="row-fluid">
				<div class="span2 show-grid">
				                 <a href="<?php echo $currentabsenteeslink; ?>"><img src="<?php echo $iconsDir1.'/textreport.png'; ?>" alt="Leave" style="width: 54px; height: 54px;" /></a><br />
	           <a href="<?php echo $currentabsenteeslink; ?>"><h2 class="item-page-title">Today's Absentees</h2></a>
				</div>
				<div class="span2 show-grid">
							<a href="<?php echo $absenteesbydatelink; ?>"><img src="<?php echo $iconsDir1.'/textreport.png'; ?>" alt="Attendance" style="width: 54px; height: 54px;" /></a>
						           <a href="<?php echo $absenteesbydatelink; ?>"><h2 class="item-page-title">Absentees By Date</h2></a>
            
				
				</div>
				<div class="span3 show-grid">
				                   <a href="<?php echo $classattendancelink; ?>"><img src="<?php echo $iconsDir1.'/textreport.png'; ?>" alt="Attendance" style="width: 54px; height: 54px;" /></a>
	            <a href="<?php echo $classattendancelink; ?>"><h2 class="item-page-title">Class Attendance Report</h2></a>
           
				</div>
				<div class="span2 show-grid">
				                  <a href="<?php echo $regularwithleavelink; ?>"><img src="<?php echo $iconsDir1.'/textreport.png'; ?>" alt="Leave" style="width: 54px; height: 54px;" /></a><br />
	                                         <a href="<?php echo $regularwithleavelink; ?>"><h2 class="item-page-title">Regular Absentees</h2></a>
           
				</div>
				<div class="span3 show-grid">
					                  <a href="<?php echo $regularwithoutleavelink; ?>"><img src="<?php echo $iconsDir1.'/textreport.png'; ?>" alt="Leave" style="width: 44px; height: 44px;" /></a><br />
	               <a href="<?php echo $regularwithoutleavelink; ?>"><h2 class="item-page-title">Regular Absentees (Unexcused)</h2></a>
         
				</div>
			</div>
		<div class="row-fluid">
				<div class="span2 show-grid">
			               <a href="<?php echo $classeslink2; ?>"><img src="<?php echo $iconsDir1.'/report.png'; ?>" alt="All Class Reports" style="width: 54px; height: 54px;" /></a>
                      <a href="<?php echo $classeslink2; ?>"><h2 class="item-page-title">Today's Report</h2></a>
				</div>
				<div class="span3 show-grid">
				          <a href="<?php echo $last10link; ?>"><img src="<?php echo $iconsDir1.'/report.png'; ?>" alt="Absentees in last 15 days" style="width: 54px; height: 54px;" /></a>
                              <a href="<?php echo $last10link; ?>"><h2 class="item-page-title">Absentees (Last 15 days)</h2></a>
             
				</div>
				<div class="span2 show-grid">
			               <a href="<?php echo $classeslink; ?>"><img src="<?php echo $iconsDir1.'/report.png'; ?>" alt="All Class Reports" style="width: 54px; height: 54px;" /></a>
                      <a href="<?php echo $classeslink; ?>"><h2 class="item-page-title">Classwise</h2></a>
				</div>
				<div class="span2 show-grid">
			               <a href="<?php echo $classeslink1; ?>"><img src="<?php echo $iconsDir1.'/report.png'; ?>" alt="All Class Reports" style="width: 54px; height: 54px;" /></a>
                      <a href="<?php echo $classeslink1; ?>"><h2 class="item-page-title">Overall Report</h2></a>
				</div>
				</div>
				
			</div>
	</div>		

<br />
<br />
<br />
