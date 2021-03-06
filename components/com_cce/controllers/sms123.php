<?php
// No direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.controller');

require_once('helper.php'); 

class CCEControllerSMS extends JController
{
	function sms_api($smstext,$mobiles){
		//Please Enter Your Details
 		$user="T2013121003"; //your username
 		$password="suisna1978_M"; //your password
 		//$mobilenumbers="919XXXXXXXXX"; //enter Mobile numbers comma seperated
 		$mobilenumbers=$mobiles; //enter Mobile numbers comma seperated
 		$message = $smstext; //enter Your Message 
 		$senderid="TERESA"; //Your senderid
 		$messagetype="N"; //Type Of Your Message
		$url="http://info.bulksms-service.com/WebserviceSMS.aspx";
 		//domain name: Domain name Replace With Your Domain  
 		$message = urlencode($message);
 		$ch = curl_init(); 
 		if (!$ch){die("Couldn't initialize a cURL handle");}
 		$ret = curl_setopt($ch, CURLOPT_URL,$url);
 		curl_setopt ($ch, CURLOPT_POST, 1);
 		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);          
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
 		curl_setopt ($ch, CURLOPT_POSTFIELDS,"User=$user&passwd=$password&mobilenumber=$mobilenumbers&message=$message&sid=$senderid&mtype=$messagetype");
 		$ret = curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		//If you are behind proxy then please uncomment below line and provide your proxy ip with port.
		// $ret = curl_setopt($ch, CURLOPT_PROXY, "PROXY IP ADDRESS:PORT");
 		$curlresponse = curl_exec($ch); // execute
		if(curl_errno($ch))
        		echo 'curl error : '. curl_error($ch);

 		if (empty($ret)) {
    			// some kind of an error happened
    			die(curl_error($ch));
    			curl_close($ch); // close cURL handler
			return false;
 		} else {
    			$info = curl_getinfo($ch);
    			curl_close($ch); // close cURL handler
    			//echo "<br>";
        		echo $curlresponse;    //echo "Message Sent Succesfully" ;
			return true;
		}
	}



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
		$staffids = implode($ids,",");	
                $user =& JFactory::getUser();
                $form = JRequest::get('POST');
                $Itemid=JRequest::getVar('Itemid');
                if($ids==null){
                        $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=sms&controller=sms&task=smsqueue&layout=smsqueue&Itemid='.$Itemid,false);
                        JError::raiseWarning(500,'Please select a record..');
                        $this->setRedirect($redirectTo,'');
                        return;
                }
                $model = & $this->getModel('sms');
		//Common for all student and staff
                $logid = $model->logStudentSMS($form['smstext'],'General',$user->username,'Staff',$staffids);
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=sms&controller=sms&task=smsqueue&layout=smsqueue&Itemid='.$Itemid,false);
                $this->setRedirect($redirectTo,'Sent for Approval...!');
        }


  //Send Batch/CLass sms
        function sendstudentsms(){
			    $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=sms&view=sms&task=bulksms&layout=smsqueue&Itemid='.$Itemid.'&logid='.$logid,false);
                $this->validateuser();
                $Itemid = JRequest::getVar('Itemid');
                $category= JRequest::getVar('category');
                $user =& JFactory::getUser();
                $model = & $this->getModel('sms');
                 $model1 = & $this->getModel('cce');
                $logid = JRequest::getVar('logid');
                $s = $model->getStudentSMSLogByID($logid,$rec);
				$ids  = explode(",",$rec->sids);
				$schoolinfo=$model1->getSchoolInfo();
				if(!$schoolinfo->smssending)
				{
					   JError::raiseWarning(500,'SMS Sending is not enabled, Please enable in School Setup');
						$this->setRedirect($redirectTo,'');
						return;
				}
			foreach($ids as $id)
            {
			if($rec->sentto=='Staff'){
				$model->getStaff($id,$srec);
        		//	echo $srec->staffcode."/".$rec->smstext.'/'.$srec->mobile.'<br />';
			}else{ 
				$model->getStudent($id,$srec);
        		//	echo $srec->registerno."/".$rec->smstext.'/'.$srec->mobile.'<br />';
			}	

			$rs=$this->sms_api($rec->smstext,$srec->mobile);

            if($rs==false)
                		$q=$model->logStudentSMSStatus($logid,$id,"Y");	
			else
                		$q=$model->logStudentSMSStatus($logid,$id,"N");
                }
                $q=$model->updateStudentASMSLog($logid,'S');
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
		$sids = implode($ids,",");
                $user =& JFactory::getUser();
                $form = JRequest::get('POST');
                $Itemid=JRequest::getVar('Itemid');
                if($ids==null){
                        $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=sms&controller=sms&task=displaygroupstudents&layout=groupstudentsms&Itemid='.$Itemid,false);
                        JError::raiseWarning(500,'Please select a record..');
                        $this->setRedirect($redirectTo,'Retry...');
                        return;
                }
                $model = & $this->getModel('groups');
                $rs = $model->getGroup($form['groupid'],$rec);
			    $model1 = $this->getModel('sms');
                $logid = $model1->logStudentSMS($form['smstext'],'GroupSMS',$user->username,$rec->groupname,$sids);
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=sms&controller=sms&task=smsqueue&layout=smsqueue&Itemid='.$Itemid,false);
                $this->setRedirect($redirectTo,'To be approved...!');
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
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=sms&view=sms&task=bulksms&layout=batchstudentsms&Itemid='.$Itemid,false);
                JError::raiseWarning(500,'Sorry, SMS message is empty');
                $this->setRedirect($redirectTo,'');
                return;
        }
        $model = & $this->getModel('sms');
	$sids = $model->getCurrentStudentsIDs();
	$aColumn = JArrayHelper::getColumn($sids, 'studentid');
	$studentids = implode($aColumn,",");
        $logid = $model->logStudentSMS($smsdata['smstext'],'BulkSMS',$user->username,'All Students',$studentids);
	$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=sms&view=sms&task=display&layout=smsqueue&category=sendstudentsbulksms&Itemid='.$Itemid.'&logid='.$logid,false);
	$this->setRedirect($redirectTo);
    }
	
//This function just logs the message along with the ids of the students into the 
//log for approval
    function logstudentsbatchsms()
    {
        $this->validateuser();
        $Itemid = JRequest::getVar('Itemid');
          $courseid = JRequest::getVar('courseid');
        $user =& JFactory::getUser();
        $smsdata = JRequest::get('POST');
		$ids = JRequest::getVar('cid',null,'default','array');
		if(!$ids[0]){

	         $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=sms&view=sms&task=displaystudents&layout=batchstudentsms&courseid='.$courseid.'&Itemid='.$Itemid,false);
       		 JError::raiseWarning(500,'Please select any student');
                $this->setRedirect($redirectTo,'');
			return;
		}
		$studentsids = implode($smsdata['cid'],",");	
        if($smsdata['smstext']==''){
			
	         $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=sms&view=sms&task=displaystudents&layout=batchstudentsms&courseid='.$courseid.'&Itemid='.$Itemid,false);
      
                 JError::raiseWarning(500,'Sorry, SMS message is empty...');
                $this->setRedirect($redirectTo,'');
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
     function principalapprovestudentsms()
    {
	$this->validateuser();
	$Itemid = JRequest::getVar('Itemid');
        $data = JRequest::get('POST');
        $model = & $this->getModel('sms');
        $q=$model->updateStudentASMSLog($data['logid'],'A');
        $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=principal&view=principal&task=display&layout=default&Itemid='.$Itemid.'&logid='.$data['logid'],false);
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
    function rejectsms(){
	$this->validateuser();
        $Itemid = JRequest::getVar('Itemid');
        $user =& JFactory::getUser();
        $smsdata = JRequest::get('POST');
        $model = & $this->getModel('sms');
        $model->deleteSMS($smsdata['logid']);
        $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=sms&view=sms&task=bulksms&layout=smsaqueue&Itemid='.$Itemid.'&logid='.$logid,false);
        $this->setRedirect($redirectTo);
    }
}

