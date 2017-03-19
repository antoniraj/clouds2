<?php
// no direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.view');
 
 
class CceViewSMS extends JView
{
    function display($tpl = null)
    {
//	$app =& JFactory::getApplication();
  //      $pathway =& $app->getPathway();
    //    $pathway->addItem('Manage School - Home', 'index.php?option=com_cce&view=cce');
      //  $pathway->addItem('SMS');
        parent::display($tpl);
    }


    function batchstudentsms($courseid=null){
        $model = &$this->getModel();
        $courses = $model->getCurrentCourses();
        $rs = $model->getCourse($courseid,$rec);
        $students = $model->getStudents($courseid);
        $coursename=$rec->coursename;
	
        $this->assignRef( 'courses', $courses);
        $this->assignRef( 'students', $students);
        $this->assignRef( 'courseid', $courseid);
        $this->assignRef( 'coursename', $coursename);

//	$app =& JFactory::getApplication();
  //      $pathway =& $app->getPathway();
    //    $pathway->addItem('Manage School - Home', 'index.php?option=com_cce&view=cce');
      //  $pathway->addItem('BatchSMS');
        parent::display($tpl);
    }


    function batchstaffsms(){
        $model = &$this->getModel();
        $staffs = $model->getStaffs();
        $this->assignRef( 'staffs', $staffs);
        //$app =& JFactory::getApplication();
       // $pathway =& $app->getPathway();
        //$pathway->addItem('Manage School - Home', 'index.php?option=com_cce&view=cce');
        //$pathway->addItem('BatchSMS');
        parent::display($tpl);
    }



  function groupstudentsms($groupid=null){
        $model = &$this->getModel();
        $groups = $model->getGroups();
        $rs = $model->getGroup($groupid,$rec);
        $students = $model->getGroupMembers($groupid);
        $groupname=$rec->groupname;

        $this->assignRef( 'groups', $groups);
        $this->assignRef( 'students', $students);
        $this->assignRef( 'groupid', $groupid);
        $this->assignRef( 'groupname', $groupname);

//        $app =& JFactory::getApplication();
  //      $pathway =& $app->getPathway();
    //    $pathway->addItem('Manage School - Home', 'index.php?option=com_cce&view=cce');
      //  $pathway->addItem('GroupSMS');
        parent::display($tpl);
    }


}

