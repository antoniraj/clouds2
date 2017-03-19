<?php
// No direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport('joomla.application.component.controller');
require_once('helper.php'); 
 
class CCEControllerAttendanceReports extends JController
{
    function validateuser()
    {
	if(! Helper::checkuser()){ 
                	$redirectTo = JRoute::_('index.php?option=com_users?view=login',false);
        		$this->setRedirect($redirectTo,'Please Login...');
	}
    }

    function display()
    {
	$this->validateuser();
	$document = JFactory::getDocument();
	$viewType = $document->getType();
	$viewName = JRequest::getCmd('view', $this->default_view);
	$viewLayout = JRequest::getCmd('layout', 'todayabsentees');
	$view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
	$model=& $this->getModel('classattendance');
	$model1=& $this->getModel('classleave');
	if($model==true){
		$view->setModel($model,true);
		$view->setModel($model1);
	}
	$view->setLayout($viewLayout);
	$view->display();
    }


        function sendsms()
    	{
		$ids = JRequest::getVar('cid',null,'default','array');
		$user =& JFactory::getUser();
		$form = JRequest::get('POST');
		$Itemid=JRequest::getVar('Itemid');
		if($ids==null){
			$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=attendancereports&view=attendancereports&layout=classattendance&task=display&Itemid='.$Itemid,false);
			JError::raiseWarning(500,'Please select a record..');
			$this->setRedirect($redirectTo,'');
			return;
		}
		$model = & $this->getModel('cce');
		foreach($ids as $sid){
			// $model->getStudent($sid,$rec);
			//API TO SEND SMS
			// echo $rec->registerno.'->'.$rec->firstname.'->'.$rec->mobile.'<br />';
		}
		$model1 = $this->getModel('sms');
		$logid = $model1->logStudentSMS($form['smstext'],'General',$user->username,'Attendance');
		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=sms&controller=sms&task=smsqueue&layout=smsqueue&Itemid='.$Itemid,false);
		$this->setRedirect($redirectTo,'');
	}
	  function go()
    	{
		$user =& JFactory::getUser();
		$form = JRequest::get('POST');
		$Itemid=JRequest::getVar('Itemid');
		if(!$form['courseid']){
			$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=attendancereports&view=attendancereports&layout=classattendance&task=display&Itemid='.$Itemid,false);
			JError::raiseWarning(500,'Please select any class!');
			$this->setRedirect($redirectTo,'');
			return;
		}
		$model = & $this->getModel('cce');
		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=attendancereports&view=attendancereports&layout=classattendance&task=display&courseid='.$form['courseid'].'&fdate='.$form['fdate'].'&tdate='.$tdate.'&Itemid='.$Itemid,false);
		$this->setRedirect($redirectTo,'');
	}

}
