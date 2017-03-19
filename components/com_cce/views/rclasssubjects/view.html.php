<?php
// no direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.view');
 
/**
 * HTML View class for the HelloWorld Component
 *
 * @package    HelloWorld
 */
 
class CceViewRClassSubjects extends JView
{
    function display($courseid=null)
    {
	$model = &$this->getModel();
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

	$app =& JFactory::getApplication();
        $pathway =& $app->getPathway(); 
        $pathway->addItem('Classes', 'index.php?option=com_cce&controller=courses&task=showCourses&view=showcourses');
        $pathway->addItem($coursename); 
	
        parent::display($tpl);
    }
}

