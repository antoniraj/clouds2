<?php
// No direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.controller');

require_once('helper.php'); 

class CCEControllerSMS extends JController
{

	function validateuser()
	{
		if(! Helper::checkuser()){ 
			$redirectTo = JRoute::_('index.php?option=com_users?view=login',false);
	        	$this->setRedirect($redirectTo,'Please Login...');
			return;
		}
	}

   	function display() {
		$this->validateuser();
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

	function bulksms()
    	{
		$this->validateuser();
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

        function displaygroupstudents()
        {
                $this->validateuser();
                //$courseid = JRequest::getVar('courseid');
                $document = JFactory::getDocument();
                $viewType = $document->getType();
                $viewName = JRequest::getCmd('view', $this->default_view);
                $viewLayout = JRequest::getCmd('layout', 'default');
                $groupid= $_POST['groups'];
$view = $this->getView($viewName, $viewType, '', array('base_path'=> $this->basePath, 'layout' => $viewLayout));
                $model=& $this->getModel('groups');
                $model1=& $this->getModel('sms');
                if($model==true){
                        $view->setModel($model,true);
                        $view->setModel($model1);
                }
                $view->setLayout($viewLayout);
                $view->groupstudentsms($groupid);
        }

    
	function displaystudents()
    	{
        	$this->validateuser();
		$courseid= JRequest::getVar('courses');
		//$courseid = JRequest::getVar('courseid');
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
	        $view->batchstudentsms($courseid);
    	}


	function displaystaff()
        {
                $this->validateuser();
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
                $view->batchstaffsms();
        }

	//Send Staff SMS
	function sendbatchstaffsms(){
                $ids = JRequest::getVar('cid',null,'default','array');
                $user =& JFactory::getUser();
                $form = JRequest::get('POST');
                $Itemid=JRequest::getVar('Itemid');
                if($ids==null){
                        $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=sms&controller=sms&task=smsqueue&layout=smsqueue&Itemid='.$Itemid,false);
                        JError::raiseWarning(500,'Please select a record..');
                        $this->setRedirect($redirectTo,'Retry...');
                        return;
                }
                $model = & $this->getModel('sms');

                foreach($ids as $sid){
                        $model->getStaff($sid,$rec);
                        //API TO SEND SMS
                 //       echo $rec->staffcode.'->'.$rec->firstname.'->'.$rec->mobile.'<br />';
                }
		//Common for all student and staff
                $logid = $model->logStudentSMS($form['smstext'],'General',$user->username,'Staff');
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=sms&controller=sms&task=smsqueue&layout=smsqueue&Itemid='.$Itemid,false);
                $this->setRedirect($redirectTo,'SMS Sent...!');
        }


  //Send Batch/CLass sms
        function sendstudentsms(){
                $this->validateuser();
                $Itemid = JRequest::getVar('Itemid');
                $category= JRequest::getVar('category');
echo $category;return;
                $user =& JFactory::getUser();
                $model = & $this->getModel('sms');
                $logid = JRequest::getVar('logid');
                $s = $model->getStudentSMSLogByID($logid,$rec);
                echo $rec->sids;return;

                foreach($students as $student)
                {
        //      echo $student->registerno."/".$rec->smstext.'/'.$student->mobile.'<br />';

                //$rs = SMS_API($rec->pmobile,$smsdata['smstext']);
                //$rs = true;
                //if($rs===false)
                //      $q=$model->logStudentSMSStatus($logid,$student->id,"Y");
                //else
                //      $q=$model->logStudentSMSStatus($logid,$student->id,"N");
                }
                $q=$model->updateStudentASMSLog($logid,'S');
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=sms&view=sms&task=bulksms&layout=smsqueue&Itemid='.$Itemid.'&logid='.$logid,false);
                $this->setRedirect($redirectTo);
        }



	//Send Batch/CLass sms
   	function sendstudentsbatchsms(){
		$this->validateuser();
        	$Itemid = JRequest::getVar('Itemid');
        	$user =& JFactory::getUser();
        	$model = & $this->getModel('sms');
        	$logid = JRequest::getVar('logid');
        	$s = $model->getStudentSMSLogByID($logid,$rec);
		echo $rec->sids;return;

        	foreach($students as $student)
        	{
        //      echo $student->registerno."/".$rec->smstext.'/'.$student->mobile.'<br />';

                //$rs = SMS_API($rec->pmobile,$smsdata['smstext']);
                //$rs = true;
                //if($rs===false)
                //      $q=$model->logStudentSMSStatus($logid,$student->id,"Y");
                //else
                //      $q=$model->logStudentSMSStatus($logid,$student->id,"N");
        	}
        	$q=$model->updateStudentASMSLog($logid,'S');
        	$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=sms&view=sms&task=bulksms&layout=smsqueue&Itemid='.$Itemid.'&logid='.$logid,false);
        	$this->setRedirect($redirectTo);
	}

	//Send Group SMS for students
	function sendgroupstudentsms(){
                $ids = JRequest::getVar('cid',null,'default','array');
                $user =& JFactory::getUser();
                $form = JRequest::get('POST');
                $Itemid=JRequest::getVar('Itemid');
                if($ids==null){
                        $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=sms&controller=sms&task=smsqueue&layout=smsqueue&Itemid='.$Itemid,false);
                        JError::raiseWarning(500,'Please select a record..');
                        $this->setRedirect($redirectTo,'Retry...');
                        return;
                }
                $model = & $this->getModel('groups');

                foreach($ids as $sid){
                       // $model->getStudent($sid,$rec);
                        //API TO SEND SMS
                       // echo $rec->registerno.'->'.$rec->firstname.'->'.$rec->mobile.'<br />';
                }
                $rs = $model->getGroup($form['groupid'],$rec);
		$model1 = $this->getModel('sms');
                $logid = $model1->logStudentSMS($form['smstext'],'General',$user->username,$rec->groupname);
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=sms&controller=sms&task=smsqueue&layout=smsqueue&Itemid='.$Itemid,false);
                $this->setRedirect($redirectTo,'SMS Sent...!');
        }



    	function updatemobile()
    	{
		$this->validateuser();
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
	$this->validateuser();
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
	$this->validateuser();
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
	$this->validateuser();
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


//called from bulksms view to log for approval
    function logbulksms()
    {
	$this->validateuser();
	$Itemid = JRequest::getVar('Itemid');
        $user =& JFactory::getUser();
        $smsdata = JRequest::get('POST');
        if($smsdata['smstext']==''){
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=sms&view=sms&task=bulksms&layout=bulksms&Itemid='.$Itemid,false);
                JError::raiseWarning(500,'Sorry, SMS message is empty...');
                $this->setRedirect($redirectTo,'Retry');
                return;
        }
        $model = & $this->getModel('sms');
        $logid = $model->logStudentSMS($smsdata['smstext'],'---',$user->username,'All Students');
	$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=sms&view=sms&task=bulksms&layout=smsqueue&category=sendstudentsbulksms&Itemid='.$Itemid.'&logid='.$logid,false);
	$this->setRedirect($redirectTo);
    }
	
//This function just logs the message along with the ids of the students into the 
//log for approval
    function logstudentsbatchsms()
    {
        $this->validateuser();
        $Itemid = JRequest::getVar('Itemid');
        $user =& JFactory::getUser();
        $smsdata = JRequest::get('POST');
	$studentsids = implode($smsdata['cid'],",");	
        if($smsdata['smstext']==''){
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=sms&view=sms&task=batchstudentsms&layout=batchstudentsms&Itemid='.$Itemid,false);
                JError::raiseWarning(500,'Sorry, SMS message is empty...');
                $this->setRedirect($redirectTo,'Retry');
                return;
        }
        $model = & $this->getModel('sms');
	$logid = $model->logStudentSMS($smsdata['smstext'],'Batch SMS',$user->username,$smsdata['to'],$studentsids);
	
        $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=sms&view=sms&layout=smsqueue&category=sendstudentsbatchsms&Itemid='.$Itemid.'&logid='.$logid,false);
        $this->setRedirect($redirectTo);
    }

//Status can be: N - New, A - Approved,  S - Sent
    //Studets Bulk SMS function
    function sendstudentsbulksms()
    {
	$this->validateuser();
	$Itemid = JRequest::getVar('Itemid');
	$user =& JFactory::getUser();
	$model = & $this->getModel('sms');
	$students = $model->getCurrentStudents();
	$logid = JRequest::getVar('logid');
	$s = $model->getStudentSMSLogByID($logid,$rec);
	foreach($students as $student)
	{
	//	echo $student->registerno."/".$rec->smstext.'/'.$student->mobile.'<br />';
		
		//$rs = SMS_API($rec->pmobile,$smsdata['smstext']);
		//$rs = true;
		//if($rs===false)
		//	$q=$model->logStudentSMSStatus($logid,$student->id,"Y");
		//else
		//	$q=$model->logStudentSMSStatus($logid,$student->id,"N");
	}
        $q=$model->updateStudentASMSLog($logid,'S');
	$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=sms&view=sms&task=bulksms&layout=smsqueue&Itemid='.$Itemid.'&logid='.$logid,false);
	$this->setRedirect($redirectTo);
    }
 

    function updatestudentmobile()
    {
	$this->validateuser();
        $mobiledata = JRequest::get('POST');
        $model = & $this->getModel('sms');
        $q=$model->updateStudentMobile($mobiledata['sid'],$mobiledata['mobile']);
        $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=sms&view=sms&task=bulksms&layout=bulksmsreport&logid='.$mobiledata['logid'],false);
        $this->setRedirect($redirectTo);
	return;
    }


//when the approve button is pressed, the status is updated here.
    function approvestudentsms()
    {
	$this->validateuser();
	$Itemid = JRequest::getVar('Itemid');
        $data = JRequest::get('POST');
        $model = & $this->getModel('sms');
        $q=$model->updateStudentASMSLog($data['logid'],'A');
        $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=sms&view=sms&task=display&layout=smsaqueue&Itemid='.$Itemid.'&logid='.$data['logid'],false);
        $this->setRedirect($redirectTo);
        return;
    }


    function retry()
    {
	$this->validateuser();
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
	$this->validateuser();
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
	$this->validateuser();
    }
 
    function sendstudentindividualsms()
    {
	$this->validateuser();
    }

    function sendstaffsms()
    {
	$this->validateuser();
    }


    function deletesms(){
	$this->validateuser();
        $Itemid = JRequest::getVar('Itemid');
        $user =& JFactory::getUser();
        $smsdata = JRequest::get('POST');
        $model = & $this->getModel('sms');
        $model->deleteSMS($smsdata['logid']);
        $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=sms&view=sms&task=bulksms&layout=smsqueue&Itemid='.$Itemid.'&logid='.$logid,false);
        $this->setRedirect($redirectTo);
    }
}

