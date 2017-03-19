<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	$photoDir = JURI::base() . 'components/com_cce/staffphoto/';
	$model = &$this->getModel();
        $user =& JFactory::getUser();
	$staffid = $model->getStaffIdByCode($user->username);
	$Itemid= JRequest::getVar('Itemid');
	$classes = $model->getCurrentCourses();	
	$r = $model->getStaff($staffid,$srec);	
?>
<div>
        <div style="float:right;">
           <img src="<?php echo $photoDir.'/'.$srec->staffcode.'.jpg'; ?>" width="100" height="130" alt="" />
        </div>
        <div style="float:left;">
                <div>&nbsp;</div>
                <div>&nbsp;</div>
                <h1>Welcome&nbsp;<?php echo $srec->hprefix.' '.$srec->firstname; ?>...!</h1>
                <div>&nbsp;</div>
                <div><h1>My Subjects</h1></div>
        </div>
</div>
<hr /> <br />
<div>
<?php

	$model2=& $this->getModel('tngradebook');
        $exams=$model2->getTNGradeBook();
        $terms=$model -> getCurrentTerms();
	foreach($classes as $class){
		$ss = $model->getTeacherCourseSubjects($class->id,$staffid,$subjects);
		if($ss){
			//echo '<h1>'.$class->code.'</h1>';
			foreach($subjects as $subject)
			{
				echo '<div style="float:left; padding-bottom:35px; padding-left:30px; width:40%;">';
				echo '<font size="5" style="font-family: georgia,verdana" color="darkmagenta">'.$class->coursename.'-'.$class->sectionname.'</font>';
                		echo '<h1>'.$subject->subjectcode.'-'.$subject->subjecttitle.'</h1>';
		                $model->getSubjectTeachers($this->courseid,$subject->id,$staff);
				if($class->assessmenttype=="CCE"){
	                		foreach($terms as $term)
        	        		{
                			        $ccelink = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=gradebook&view=gradebook&task=display&termid='.$term->id.'&subjectid='.$subject->id.'&courseid='.$class->id.'&Itemid='.$Itemid.'&profile=1');
						$rccelink = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=classreports&view=rclasstermreport&task=classtermreport&termid='.$term->id.'&subjectid='.$subject->id.'&courseid='.$class->id.'&Itemid='.$Itemid.'&profile=1');
			                        //echo "<h3><a href=\"$ccelink\">".$term->term."</a></h3>";
          					echo '<h3><a href="'.$ccelink.'">'.$term->term.'<img src="'.$iconsDir.'/entermarks.png'.'" alt="Enter Marks" style="width: 32px; height: 42px;" /></a><a href="'.$rccelink.'"><img src="'.$iconsDir.'/generatemarks.png'.'" alt="Generate Marks" style="width: 32px; height: 42px;" /></a></h3>';
                			}
				}
				if($class->assessmenttype=="Normal"){
					foreach($exams as $exam)
					{
						$link = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=ngradebookmarks&view=nmarklist&layout=default&max='.$subject->marks.'&title='.$exam->title.'&examid='.$exam->id.'&subjectid='.$subject->id.'&courseid='.$class->id.'&Itemid='.$Itemid.'&profile=1');
                        			$rlink = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=ngradebookmarks&view=nmarklist&layout=examreport&max='.$subject->marks.'&passmark='.$subject->passmark.'&title='.$exam->title.'&examid='.$exam->id.'&staff='.$srec->firstname.'&subjectid='.$subject->id.'&courseid='.$class->id.'&Itemid='.$Itemid.'&profile=1');
          					echo '<h3><a href="'.$link.'">'.$exam->title.'<img src="'.$iconsDir.'/entermarks.png'.'" alt="Enter Marks" style="width: 32px; height: 42px;" /></a><a href="'.$rlink.'"><img src="'.$iconsDir.'/generatemarks.png'.'" alt="Generate Marks" style="width: 32px; height: 42px;" /></a></h3>';
					//		echo "<h3><a href=\"$link\">".$exam->title."</a></h3>";
					}
				}
				echo '</div>';
			}
		}
	}

?>


</div>
