<?php
// no direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.view');
 
 
class CceViewRShowCourseProfileNormal extends JView
{
    function display($courseid)
    {
	$model = &$this->getModel();
	$Itemid = JRequest::getVar('Itemid');
	$students = $model->getStudents($courseid);
	$courses = $model->getCurrentCourses();
	$status = $model->getMSubjectsByCourse($courseid,$subjects);
	$classteachers = $model->getClassTeachers($courseid);
	$rs = $model->getCourse($courseid,$rec);
	$coursename=$rec->coursename;
        $this->assignRef( 'model', $model);
        $this->assignRef( 'students', $students);
        $this->assignRef( 'subjects', $subjects);
        $this->assignRef( 'classteachers', $classteachers);
        $this->assignRef( 'courseid', $courseid);
        $this->assignRef( 'coursename', $coursename);
		$this->assignRef( 'courses', $courses);
	    $this->assignRef( 'section', $rec->sectionname);

	$app =& JFactory::getApplication();
        $pathway =& $app->getPathway(); 
        //$pathway->addItem('Classes', 'index.php?option=com_cce&controller=classreports&task=display&view=coursereports&Itemid='.$Itemid);
        $pathway->addItem($coursename); 
	
        parent::display($tpl);
    }
}

