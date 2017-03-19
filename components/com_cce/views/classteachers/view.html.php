<?php
// no direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.view');
 
/**
 */
 
class CceViewClassTeachers extends JView
{
    function display($courseid = null)
    {
	$model = &$this->getModel();
	$courses = $model->getCurrentCourses();
	$rs = $model->getCourse($courseid,$rec);
	$classteachers = $model->getClassTeachers($courseid);
	$coursename=$rec->coursename;
	$code=$rec->code;
        $this->assignRef( 'courses', $courses);
        $this->assignRef( 'classteachers', $classteachers);
        $this->assignRef( 'courseid', $courseid);
        $this->assignRef( 'coursename', $coursename);
        $this->assignRef( 'code', $code);
        $this->assignRef( 'model', $model);
//	$app =& JFactory::getApplication();
  //      $pathway =& $app->getPathway(); 
    //    $pathway->addItem('CCE', 'index.php?option=com_cce&view=cce');
//	$pathway->addItem('Class Teachers'); 
        parent::display($tpl);
    }
}

