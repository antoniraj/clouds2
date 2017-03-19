<?php
// no direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.view');
jimport('joomla.html.pagination');
 
 
class CceViewShowstudents extends JView
{
    function display($courseid = null)
    {
	$app    = JFactory::getApplication();

        $model = &$this->getModel();
        $subjectmodel= &$this->getModel('managesubjects');
        $courses = $model->getCurrentCourses();
        $rs = $model->getCourse($courseid,$rec);
        $coursename=$rec->coursename;
	$students1 = $model->getStudents($courseid);
	$total =count($students1);
	$page = new JPagination($total, $limitstart, $limit);
        $this->assignRef( 'courses', $courses);
        $this->assignRef( 'students', $students1);
        $this->assignRef( 'srec', $srec);
        $this->assignRef( 'courseid', $courseid);
        $this->assignRef( 'coursename', $coursename);
        $this->assignRef( 'code', $rec->code);
        $this->assignRef( 'section', $rec->sectionname);

        parent::display($tpl);
    }
    function stu_Report($reportkey,$type)
    {
		$app    = JFactory::getApplication();
        $model = &$this->getModel();
        if($type=="class")
        {
		$stu = $model->getStudents($reportkey);
		}
		else{
        $stu = $model->getstudentsbycaste($reportkey);
		}
        $this->assignRef( 'students', $stu);
        $this->assignRef( 're_type', $type);
        $this->assignRef( 'reportkey', $reportkey);
         parent::display($tpl);
	}
    
}

