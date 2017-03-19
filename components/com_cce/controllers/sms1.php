<?php
// No direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport('joomla.application.component.controller');
 
require_once('helper.php'); 

class CCEControllerSMS extends JController
{

    function display()
    {
	if(! Helper::checkuser()){ 
		$redirectTo = JRoute::_('index.php?option=com_users?view=login',false);
        	$this->setRedirect($redirectTo,'Please Login...');
	}
    }

    function bulksms()
    {
	$this->display();
	$document = JFactory::getDocument();
	$viewType = $document->getType();
	$viewName = JRequest::getCmd('view', $this->default_view);
	$viewLayout = JRequest::getCmd('layout', 'default');
	$view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
	$model=& $this->getModel('sms');
	if($model==true){
		$view->setModel($model,true);
	}
	$view->setLayout($viewLayout);
	$view->display();
    }


    function updatemobile()
    {
        $this->display();
        $document = JFactory::getDocument();
        $viewType = $document->getType();
        $viewName = JRequest::getCmd('view', $this->default_view);
        $viewLayout = JRequest::getCmd('layout', 'default');
        $view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
        $model=& $this->getModel('sms');
        if($model==true){
                $view->setModel($model,true);
        }
        $view->setLayout($viewLayout);
        $view->display();
    }



    function batchsms()
    {
        $document = JFactory::getDocument();
        $viewType = $document->getType();
        $viewName = JRequest::getCmd('view', $this->default_view);
        $viewLayout = JRequest::getCmd('layout', 'default');
        $view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
        $model=& $this->getModel('sms');
        if($model==true){
                $view->setModel($model,true);
        }
        $view->setLayout($viewLayout);
        $view->display();
    }

    function studentindividualsms()
    {
        $document = JFactory::getDocument();
        $viewType = $document->getType();
        $viewName = JRequest::getCmd('view', $this->default_view);
        $viewLayout = JRequest::getCmd('layout', 'default');
        $view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
        $model=& $this->getModel('sms');
        if($model==true){
                $view->setModel($model,true);
        }
        $view->setLayout($viewLayout);
        $view->display();
    }
 
    function staffsms()
    {
        $document = JFactory::getDocument();
        $viewType = $document->getType();
        $viewName = JRequest::getCmd('view', $this->default_view);
        $viewLayout = JRequest::getCmd('layout', 'default');
        $view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
        $model=& $this->getModel('sms');
        if($model==true){
                $view->setModel($model,true);
        }
        $view->setLayout($viewLayout);
        $view->display();
    }

    function logbulksms()
    {
        $user =& JFactory::getUser();
        $smsdata = JRequest::get('POST');
        if($smsdata['smstext']==''){
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=sms&view=sms&task=bulksms&layout=bulksms',false);
                JError::raiseWarning(500,'Sorry, SMS message is empty...');
                $this->setRedirect($redirectTo,'Retry');
                return;
        }
        $model = & $this->getModel('sms');
        $logid = $model->logStudentSMS($smsdata['smstext'],'Fee',$user->username,'All Students');
	$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=sms&view=sms&task=bulksms&layout=smsqueue&logid='.$logid,false);
	$this->setRedirect($redirectTo);


    }
	
    function sendbulksms()
    {
	$user =& JFactory::getUser();
    	$smsdata = JRequest::get('POST');
	if($smsdata['smstext']==''){
		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=sms&view=sms&task=bulksms&layout=bulksms',false);
		JError::raiseWarning(500,'Sorry, SMS message is empty...');
		$this->setRedirect($redirectTo,'Retry');
		return;
	}
	$model = & $this->getModel('sms');
	$recs = $model->getCurrentStudents();
	$logid = $model->logStudentSMS($smsdata['smstext'],'Fee',$user->username,'All Students');
	foreach($recs as $rec)
	{
		//$rs = SMS_API($rec->pmobile,$smsdata['smstext']);
		$rs = true;
		if($rs===false)
			$q=$model->logStudentSMSStatus($logid,$rec->id,"Y");
		else
			$q=$model->logStudentSMSStatus($logid,$rec->id,"N");
	}
	$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=sms&view=sms&task=bulksms&layout=bulksmsreport&logid='.$logid,false);
	$this->setRedirect($redirectTo);
    }
 

    function updatestudentmobile()
    {
        $mobiledata = JRequest::get('POST');
        $model = & $this->getModel('sms');
        $q=$model->updateStudentMobile($mobiledata['sid'],$mobiledata['mobile']);
        $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=sms&view=sms&task=bulksms&layout=bulksmsreport&logid='.$mobiledata['logid'],false);
        $this->setRedirect($redirectTo);
	return;
    }

    function retry()
    {
        $smsdata = JRequest::get('POST');
        $model = & $this->getModel('sms');
        $logid = $smsdata['logid'];
	$model->getStudentSMSStatusLogByLID($logid,'N',$sids);
        foreach($sids as $sid)
        {
                //$rs = SMS_API($rec->pmobile,$smsdata['smstext']);
                $rs = true;
                if($rs===true)
                        $q=$model->logStudentUpdateSMSStatus($logid,$sid->sid,"Y");
        }
        $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=sms&view=sms&task=bulksms&layout=bulksmsreport&logid='.$logid,false);
        $this->setRedirect($redirectTo);
	
    }

    function smsqueue()
    {
        $document = JFactory::getDocument();
        $viewType = $document->getType();
        $viewName = JRequest::getCmd('view', $this->default_view);
        $viewLayout = JRequest::getCmd('layout', 'default');
        $view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
        $model=& $this->getModel('sms');
        if($model==true){
                $view->setModel($model,true);
        }
        $view->setLayout($viewLayout);
        $view->display();
    }


    function sendbatchsms()
    {
    }
 
    function sendstudentindividualsms()
    {
    }

    function sendstaffsms()
    {
    }
}

