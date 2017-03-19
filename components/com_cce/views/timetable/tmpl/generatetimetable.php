<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
        $iconsDir = JURI::base() . 'components/com_cce/images/64x64';
        JHtml::stylesheet('styles.css','./components/com_cce/css/');
        JHTML::script('academicyear.js', 'components/com_cce/js/');
        $Itemid = JRequest::getVar('Itemid');
        $courseid= JRequest::getVar('courseid');
        $tttermid= JRequest::getVar('tttermid');
        $subjectid= JRequest::getVar('subjectid');

        $iconsDir1 = JURI::base() . 'components/com_cce/images';

        $model1 = & $this->getModel('managesubjects');
        $model = & $this->getModel('timetable');
	$terms = $model->getCurrentTimeTableTerms();
	$courses = $model->getCurrentCourses();
        $model->getCourse($courseid,$crec);
	$model->getTimeTableTerm($tttermid,$trec) ;
	$rs = $model1->getMSubjectsByCourse($courseid,$subjects);
	$sessions=$model->getCourseSessions($courseid,$tttermid);
	$days=$model->getCourseDays($courseid,$tttermid);

        $dashboardItemid = $model->getMenuItemid('manageschool','Dash Board');
        if($dashboardItemid) ;
        else{
                $dashboardItemid = $model->getMenuItemid('topmenu','Manage School');
        }
        $masterItemid = $model->getMenuItemid('manageschool','Time Table');
        if($masterItemid) ;
        else{
                $masterItemid = $model->getMenuItemid('topmenu','Manage School');
        }
        $ttItemid = $model->getMenuItemid('manageschool','Create Time Table');
        if($ttItemid) ;
        else{
                $ttItemid = $model->getMenuItemid('topmenu','Manage School');
        }
        $dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
        $modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=timetable&Itemid='.$masterItemid);
?>
						
<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce'); ?>" method="POST" name="adminForm">				
				<div class="box">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-edit"></i> <strong>Timetable Engine</strong></h2>
						<div class="pull-right">
							<button class="btn btn-primary" onclick="tend()" name="Save" value="Save"><i class="icon-plus-sign icon-white"></i> Generate</button>
						</div>
					</div>
<center><img id="theimage" src="<?php echo $iconsDir.'/working1.gif'; ?>" style="width: 600px; height: 400px;" ></center>
<br>
<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
<input type="hidden" name="tttermid" value="<?php echo $tttermid; ?>" />
<input type="hidden" name="courseid" value="<?php echo $courseid; ?>" />
<input type="hidden" name="task" value="generatetimetable" />
<input type="hidden" name="controller" value="timetable" />
<input type="hidden" name="view" value="timetable" />
<input type="hidden" name="layout" value="generatetimetable" />
 </form>	


					</div>

				</div><!--/span-->
			
			</div><!--/row-->
