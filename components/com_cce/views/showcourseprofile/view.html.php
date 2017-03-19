<?php
// no direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.view');
 
/**
 */
 
class CceViewShowCourseProfile extends JView
{
    function display($courseid=null)
    {
	$model = &$this->getModel();
	$Itemid = JRequest::getVar('Itemid');
	$students = $model->getStudents($courseid);
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
        $this->assignRef( 'code', $rec->code);

	$app =& JFactory::getApplication();
        $pathway =& $app->getPathway(); 
 //       $pathway->addItem('Classes', 'index.php?option=com_cce&controller=courses&task=showCourses&view=showcourses&Itemid='.$Itemid);
        $pathway->addItem($coursename); 
	
        parent::display($tpl);
    }
}

