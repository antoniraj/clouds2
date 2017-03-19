<?php
// no direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.view');
jimport('joomla.html.pagination');
 
 
class CceViewStudentstc extends JView
{
    function display($courseid = null)
    {
	$app    = JFactory::getApplication();
	$limit = $app->getUserStateFromRequest('cce.limit', 'limit', $app->getCfg('list_limit'), 'int');
	//$limitstart   = $app->getUserStateFromRequest('cce.limitstart', JRequest::getVar('start'), 0, 'int');
	$limitstart     = $app->getUserStateFromRequest('cce.limitstart', 'limitstart', 0, 'int');

        $model = &$this->getModel();
        $courses = $model->getCurrentCourses();
        $rs = $model->getCourse($courseid,$rec);
        $students = $model->getStudentsLimit($courseid,$limitstart,$limit);
        $coursename=$rec->coursename;
    
	foreach($courses as $value)
	{
		$cid[]=$value->id;
	}
	
    if($courseid)
    {
	$students1 = $model->getStudents($courseid);
	}
	else{
	$students1 = $model->getStudents($cid[0]);	
	}
	$total =count($students1);
	$page = new JPagination($total, $limitstart, $limit);
        $this->assignRef( 'courses', $courses);
        $this->assignRef( 'students', $students1);
        $this->assignRef( 'courseid', $courseid);
        $this->assignRef( 'coursename', $coursename);
        $this->assignRef( 'code', $rec->code);
        $this->assignRef( 'section', $rec->sectionname);
        $this->assignRef( 'pagination', $page);

        parent::display($tpl);
    }
   function printview($sid)
	{   
		$Itemid=JRequest::getVar('Itemid');
		$model = $this->getModel();
		$student = $model->getStudent($sid,$recs);
		   $this->assignRef( 'student',$recs);
		$app =& JFactory::getApplication();
	 parent::display();
	}
	
 }

