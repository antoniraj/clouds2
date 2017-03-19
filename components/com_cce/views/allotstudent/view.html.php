<?php
// no direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.view');
jimport('joomla.html.pagination');
 
 
class CceViewAllotstudent extends JView
{
     function display($tpl = null)
    {   
    $model = &$this->getModel();
	$noofmembers = $model->feecollection($rec);
   $mon = $model->gettransmonths($months);
        $this->assignRef( 'months', $months);
		$app    = JFactory::getApplication();
	$limit = $app->getUserStateFromRequest('cce.limit', 'limit', $app->getCfg('list_limit'), 'int');
	//$limitstart   = $app->getUserStateFromRequest('cce.limitstart', JRequest::getVar('start'), 0, 'int');
	$limitstart     = $app->getUserStateFromRequest('cce.limitstart', 'limitstart', 0, 'int');
	$total =count($noofmembers);
	 $getlimit = $model->getallotedLimit($limitstart,$limit);
  $page = new JPagination($total, $limitstart, $limit);
		 $this->assignRef( 'pagination', $page);
		 $this->assignRef( 'list', $getlimit);
	    $model = $this->getModel();
		$status = $model->getRoutes($rec);
		$this->assignRef('routes',$rec);
	    $status = $model->getvehicledetails($recs);
		$this->assignRef('vehicles',$recs);
		$document = &JFactory::getDocument();
		parent::display();
		
    }
	function displayEdit($id)
	{   
		
		$Itemid=JRequest::getVar('Itemid');
		$model = $this->getModel();
		$status = $model->vehicleEdit($id,$recs);
		$this->assignRef(rec,$recs);
	
		$status = $model->getMroutes($rec);
		$this->assignRef('mroutes',$rec);
		$app =& JFactory::getApplication();
		parent::display();
	}
	 function search($courseid = null)
    {
	$app    = JFactory::getApplication();
     $model = &$this->getModel();
        $courses = $model->getCurrentCourses();
        $rs = $model->getCourse($courseid,$rec);
        $coursename=$rec->coursename;
	$students1 = $model->getStudents($courseid);
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
	function displayStop($namekey)
	{   
		$Itemid=JRequest::getVar('Itemid');
		$model = $this->getModel();
		$status = $model->SearchRoutes($recs);
		$this->assignRef('routes',$recs);
		parent::display($tpl);
	}
	
}

