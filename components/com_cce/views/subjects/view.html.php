<?php
// no direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.view');
 
 
class CceViewSubjects extends JView
{
    function display($courseid = null)
    {
	$model = &$this->getModel();
	$courses = $model->getCurrentCourses();
	$rs = $model->getCourse($courseid,$rec);
	$rs = $model->getMSubjectsByCourse($courseid,$subjects);
	$coursename=$rec->coursename;
	$sectionname=$rec->sectionname;
	$code=$rec->code;
        $this->assignRef( 'courses', $courses);
        $this->assignRef( 'subjects', $subjects);
        $this->assignRef( 'courseid', $courseid);
        $this->assignRef( 'coursename', $coursename);
        $this->assignRef( 'sectionname', $sectionname);
        $this->assignRef( 'code', $code);
	//$app =& JFactory::getApplication();
        //$pathway =& $app->getPathway(); 
       // $pathway->addItem('CCE', 'index.php?option=com_cce&view=cce');
       // $pathway->addItem('Subjects');
 
        parent::display($tpl);
    }
 

}

