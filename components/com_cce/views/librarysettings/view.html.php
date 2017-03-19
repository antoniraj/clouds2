<?php
 
// no direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.view');
 
 
class CceViewLibrarysettings extends JView
{
    function display($tpl = null)
    {
		
	 $model1 = & $this->getModel('cce');
	
	 $status = $model1->getcat($cat);
        $this->assignRef( 'cat', $cat );

        parent::display($tpl);
    }
    function studentdetailsview($courseid = null)
    {

        $model = &$this->getModel();
        
        $courses = $model->getCurrentCourses();
        
        $rs = $model->getCourse($courseid,$rec);
        $students = $model->getStudentsLimit($courseid,$limitstart,$limit);
        $coursename=$rec->coursename;
	$students1 = $model->getStudents($courseid);
	$total =count($students1);
	
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
	 $this->assignRef( 'cid', $cid[0]);
	}
	
        $this->assignRef( 'courses', $courses);
        $this->assignRef( 'students', $students1);
        $this->assignRef( 'courseid', $courseid);
        $this->assignRef( 'coursename', $coursename);
        $this->assignRef( 'code', $rec->code);
        $this->assignRef( 'section', $rec->sectionname);

        parent::display($tpl);
    }
    
}

