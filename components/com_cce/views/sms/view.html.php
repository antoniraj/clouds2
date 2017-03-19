<?php
// no direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.view');
 
 
class CceViewSMS extends JView
{
	
	function showlinks(){
		$bulksmslink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=sms&view=sms&layout=bulksms&task=bulksms&Itemid='.$smsItemid);
		$batchstudentsmslink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=sms&view=sms&layout=batchstudentsms&task=displaystudents&Itemid='.$smsItemid);
		$groupstudentsmslink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=sms&view=sms&layout=groupstudentsms&task=displaygroupstudents&Itemid='.$smsItemid);
		$staffsmslink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=sms&view=sms&layout=batchstaffsms&task=displaystaff&Itemid='.$smsItemid);
		$approvestudentsmslink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=sms&view=sms&layout=smsaqueue&task=approvestudentsms&Itemid='.$smsItemid);
		$smsqlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=sms&view=sms&layout=smsqueue&task=smsqueue&Itemid='.$smsItemid);
		$studentsmsloglink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=sms&view=sms&layout=studentsmslog&task=studentsmslog&Itemid='.$smsItemid);
		$todaysabslink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=attendancereports&view=attendancereports&layout=todayabsentees&task=display&fl=1&Itemid='.$lItemid);
		$hwlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=sms&view=sms&layout=homework&task=displayhomeworks&Itemid='.$smsItemid);
		$indlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=sms&view=sms&layout=individualstudentsms&task=individualstudentsms&Itemid='.$smsItemid);
		$tplink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=sms&view=sms&layout=testportion&task=displaytestportions&Itemid='.$smsItemid);
		$examlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=sms&view=sms&layout=examtimetable&task=displayexamtimetable&Itemid='.$smsItemid);
echo '<div class="pull-right">';
echo '<a class="btn btn-mini btn-success" href="'.$bulksmslink.'"><i class="icon-edit icon-white"></i>Bulk SMS</a>';
echo '<a class="btn btn-mini btn-info" href="'.$batchstudentsmslink.'"><i class="icon-edit icon-white"></i>Batch SMS</a>';
echo '<a class="btn btn-mini btn-primary" href="'.$groupstudentsmslink.'"><i class="icon-edit icon-white"></i>Group SMS</a>';
echo '<a class="btn btn-mini btn-warning" href="'.$indlink.'"><i class="icon-edit icon-white"></i>Individual SMS</a>';
echo '<a class="btn btn-mini btn-danger" href="'.$hwlink.'"><i class="icon-edit icon-white"></i>Homework SMS</a>';
echo '<a class="btn btn-mini btn-success" href="'.$tplink.'"><i class="icon-edit icon-white"></i>Test Portion SMS</a>';
echo '<a class="btn btn-mini btn-primary" href="'.$examlink.'"><i class="icon-edit icon-white"></i>Exam Timetable</a>';
echo '<a class="btn btn-mini btn-info" href="'.$todaysabslink.'"><i class="icon-edit icon-white"></i>Today\'s Absentees SMS</a>';
echo '<a class="btn btn-mini btn-primary" href="'.$staffsmslink.'"><i class="icon-edit icon-white"></i>Staff SMS</a>';
echo '<a class="btn btn-mini btn-warning" href="'.$smsqlink.'"><i class="icon-edit icon-white"></i>SMS QUEUE</a>';
echo '<!-- <a class="btn btn-mini btn-danger" href="'.$approvestudentsmslink.'"><i class="icon-edit icon-white"></i>APPROVE QUEUE</a> -->';
echo '<a class="btn btn-mini btn-info" href="'.$studentsmsloglink.'"><i class="icon-edit icon-white"></i>SMS LOG</a>';
echo '</div>';
	}

    function display($tpl = null)
    {
//	$app =& JFactory::getApplication();
  //      $pathway =& $app->getPathway();
    //    $pathway->addItem('Manage School - Home', 'index.php?option=com_cce&view=cce');
      //  $pathway->addItem('SMS');
        parent::display($tpl);
    }


        function testportions($tpl=null){
                $model = &$this->getModel();
                $model1 = &$this->getModel('managesubjects');
                $this->assignRef( 'model', $model);
                $this->assignRef( 'model1', $model1);
                parent::display($tpl);
        }

        function examtimetable($tpl=null){
                $model = &$this->getModel();
                $model1 = &$this->getModel('managesubjects');
                $model2 = &$this->getModel('tngradebook');
                $this->assignRef( 'model', $model);
                $this->assignRef( 'model1', $model1);
                $this->assignRef( 'model2', $model2);
                parent::display($tpl);
        }


        function homeworks($tpl=null){
                $model = &$this->getModel();
                $model1 = &$this->getModel('managesubjects');
                $this->assignRef( 'model', $model);
                $this->assignRef( 'model1', $model1);
                parent::display($tpl);
        }

 function individualstudentsms($courseid=null){
        $model = &$this->getModel();
        $courses = $model->getCurrentCourses();
        $rs = $model->getCourse($courseid,$rec);
        $students = $model->getStudents($courseid);
        $coursename=$rec->coursename;
        $code=$rec->code;

        $this->assignRef( 'courses', $courses);
        $this->assignRef( 'students', $students);
        $this->assignRef( 'courseid', $courseid);
        $this->assignRef( 'coursename', $coursename);
        $this->assignRef( 'code', $code);

//      $app =& JFactory::getApplication();
  //      $pathway =& $app->getPathway();
    //    $pathway->addItem('Manage School - Home', 'index.php?option=com_cce&view=cce');
      //  $pathway->addItem('BatchSMS');
        parent::display($tpl);
    }



    function batchstudentsms($courseid=null){
        $model = &$this->getModel();
        $courses = $model->getCurrentCourses();
        $rs = $model->getCourse($courseid,$rec);
        $students = $model->getStudents($courseid);
        $coursename=$rec->coursename;
        $code=$rec->code;
	
        $this->assignRef( 'courses', $courses);
        $this->assignRef( 'students', $students);
        $this->assignRef( 'courseid', $courseid);
        $this->assignRef( 'coursename', $coursename);
        $this->assignRef( 'code', $code);

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
        $this->assignRef( 'model', $model);
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
