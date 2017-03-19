<?php
// no direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.view');
jimport('joomla.html.pagination');
 
 
class CceViewStudents extends JView
{
    function display($courseid = null)
    {
	$app    = JFactory::getApplication();
        $model = &$this->getModel();
        $courses = $model->getCurrentCourses();
        $rs = $model->getCourse($courseid,$rec);
        $coursename=$rec->coursename;
	$total =count($students);
	foreach($courses as $value)
	{
		$cid[]=$value->id;
	}
	
    if($courseid)
    {
		  $students = $model->getStudents($courseid);
		  $this->assignRef( 'courseid', $courseid);
	}
	else{
		   $students = $model->getStudents($cid[0]);
	      $this->assignRef( 'courseid', $cid[0]);
	}
	
	$page = new JPagination($total, $limitstart, $limit);
        $this->assignRef( 'courses', $courses);
        $this->assignRef( 'students', $students);
        $this->assignRef( 'coursename', $coursename);
        $this->assignRef( 'code', $rec->code);
        $this->assignRef( 'section', $rec->sectionname);
        $this->assignRef( 'pagination', $page);

        parent::display($tpl);
    }
}

