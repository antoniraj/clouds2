<?php
// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('joomla.application.component.controller');
require_once('helper.php'); 
class CCEControllerSMS extends JController {
	function sms_api($smstext,$mobiles){
return;
		//Please Enter Your Details
 	//	$user="stannesmatric"; //your username
 	//	$password="2015.icc"; //your password
 		//$mobilenumbers="919XXXXXXXXX"; //enter Mobile numbers comma seperated
 		$mobilenumbers=$mobiles; //enter Mobile numbers comma seperated
 		$message = $smstext; //enter Your Message 
 		$senderid="STANNE"; //Your senderid
 		$messagetype="normal"; //Type Of Your Message
		$url="http://bhashsms.com/api/sendmsg.php";
 		//domain name: Domain name Replace With Your Domain  

 		$message = urlencode($message);
 		$ch = curl_init(); 
 		if (!$ch){die("Couldn't initialize a cURL handle");}
 		$ret = curl_setopt($ch, CURLOPT_URL,$url);
 		curl_setopt ($ch, CURLOPT_POST, 1);
 		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);          
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
 		curl_setopt ($ch, CURLOPT_POSTFIELDS,"user=$user&pass=$password&sender=$senderid&phone=$mobilenumbers&text=$message&priority=ndnd&stype=normal");
// --User=$user&passwd=$password&mobilenumber=$mobilenumbers&message=$message&sid=$senderid&mtype=$messagetype");
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



    

	function displaystudents() {
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


	function displayhomeworks()
        {
                $this->validateuser();
                //$courseid = JRequest::getVar('courseid');
                $document = JFactory::getDocument();
                $viewType = $document->getType();
                $viewName = JRequest::getCmd('view', $this->default_view);
                $viewLayout = JRequest::getCmd('layout', 'default');
                $view = $this->getView($viewName, $viewType, '', array('base_path'=> $this->basePath, 'layout' => $viewLayout));
                $model=& $this->getModel('sms');
                $model1=& $this->getModel('managesubjects');
                if($model==true){
                        $view->setModel($model,true);
                        $view->setModel($model1);
                }
                $view->setLayout($viewLayout);
                $view->homeworks();
        }



       function displaytestportions()
        {
                $this->validateuser();
                //$courseid = JRequest::getVar('courseid');
                $document = JFactory::getDocument();
                $viewType = $document->getType();
                $viewName = JRequest::getCmd('view', $this->default_view);
                $viewLayout = JRequest::getCmd('layout', 'default');
                $view = $this->getView($viewName, $viewType, '', array('base_path'=> $this->basePath, 'layout' => $viewLayout));
                $model=& $this->getModel('sms');
                $model1=& $this->getModel('managesubjects');
                if($model==true){
                        $view->setModel($model,true);
                        $view->setModel($model1);
                }
                $view->setLayout($viewLayout);
                $view->testportions();
        }



       function displayexamtimetable()
        {
                $this->validateuser();
                //$courseid = JRequest::getVar('courseid');
                $document = JFactory::getDocument();
                $viewType = $document->getType();
                $viewName = JRequest::getCmd('view', $this->default_view);
                $viewLayout = JRequest::getCmd('layout', 'default');
                $view = $this->getView($viewName, $viewType, '', array('base_path'=> $this->basePath, 'layout' => $viewLayout));
                $model=& $this->getModel('sms');
                $model1=& $this->getModel('managesubjects');
                $model2=& $this->getModel('tngradebook');
                if($model==true){
                        $view->setModel($model,true);
                        $view->setModel($model1);
                        $view->setModel($model2);
                }
                $view->setLayout($viewLayout);
                $view->examtimetable();
        }


        function individualstudentsms() {
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
                $view->individualstudentsms($courseid);
        }



        function sendtestportions(){
	        $this->validateuser();
        	$Itemid = JRequest::getVar('Itemid');
	        $user =& JFactory::getUser();
	        $model = & $this->getModel('sms');
        	$courses=$model->getCurrentCourses();
	        foreach($courses as $crec) {
        	        $model->getCurrentTestPortions($crec->id,$hrecs);
			if(count($hrecs)>0){
				$sids = array();
        	        	$students=$model->getStudents($crec->id);
	        	        foreach($students as $student) {
        	        	        $sids[]=$student->id;
	                	}
		                $studentsids = implode($sids,",");
                		$smstext="TP:".$crec->code."";
	        	        foreach($hrecs as  $hrec){
					if(strlen($hrec->testportion)>2)
	                        		$smstext=$smstext.'['.$hrec->acronym."]".$hrec->testportion.". ";
	                	}
	                	$logid = $model->logStudentSMS($smstext,'TestPortion SMS',$user->username,$crec->code,$studentsids);
	                        $q=$model->updateStudentASMSLog($logid,'A');
	        	}
		}
	        $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=sms&view=sms&task=display&layout=smsqueue&Itemid='.$Itemid.'&logid='.$logid,false);
        	$this->setRedirect($redirectTo);
        }


        function sendexamtimetable(){
                $this->validateuser();
                $Itemid = JRequest::getVar('Itemid');
                $examid= JRequest::getVar('examid');
                $user =& JFactory::getUser();
                $model = & $this->getModel('sms');
                $courses=$model->getCurrentCourses();
                foreach($courses as $crec) {
                        $model->getCurrentExamTimeTables($crec->id,$examid,$hrecs);
                        if(count($hrecs)>0){
                                $sids = array();
                                $students=$model->getStudents($crec->id);
                                foreach($students as $student) {
                                        $sids[]=$student->id;
                                }
                                $studentsids = implode($sids,",");
                                $smstext="ET:".$crec->code."";
                                foreach($hrecs as  $hrec){
                                        if(strlen($hrec->timings)>4)
                                                $smstext=$smstext.'['.$hrec->subjectcode."]".$hrec->timings.". ";
                                }
                                $logid = $model->logStudentSMS($smstext,'Exam Timetable SMS',$user->username,$crec->code,$studentsids);
                                $q=$model->updateStudentASMSLog($logid,'A');
                        }
                }
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=sms&view=sms&task=display&layout=smsqueue&Itemid='.$Itemid.'&logid='.$logid,false);
                $this->setRedirect($redirectTo);
        }


        function savetestmobile(){
                $testsmsfile = JPATH_COMPONENT.DS.'smstemp'.DS.'smsfile.txt';
                $data= JRequest::get('POST');
                touch($testsmsfile);
                file_put_contents($testsmsfile,$data['testsmsno']);
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=sms&controller=sms&task=smsqueue&layout=smsqueue&testsmsno='.$data['testsmsno'].'&Itemid='.$Itemid,false);
                $this->setRedirect($redirectTo,'Saved...!');
        }



        function savetestportions(){
                $savecmd = $_POST['Save'];
                $sendcmd = $_POST['Send'];

                $Itemid = JRequest::getVar('Itemid');
                $model = & $this->getModel('sms');
                $hws = $_POST['hw'];
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=sms&controller=sms&task=displaytestportions&layout=testportion&Itemid='.$Itemid,false);
                foreach ($hws as $key=>$val){
                        list($cid,$sid,$scode,$ef)=explode('$$',$key);
                        if(($ef=="0") && (strlen($val)>4))
                                $rs=$model->saveTestPortion($cid,$sid,$scode,$val);
                        if(($ef=="1"))
                                $rs = $model->updateTestPortion($cid,$sid,$val);
                }
  		if($sendcmd=='Send'){
                        $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=sms&view=sms&task=sendtestportions&layout=smsqueue&Itemid='.$Itemid,false);
                        $this->setRedirect($redirectTo);
                }
                if($savecmd=='Save'){
                        if($rs) $msg='Successfully saved...!';
                        else $msg='';
                        $this->setRedirect($redirectTo,$msg);
                }

        }



        function saveexamtimetable(){
                $savecmd = $_POST['Save'];
                $sendcmd = $_POST['Send'];
                $Gocmd = $_POST['Go'];
                $examid = $_POST['examid'];
                $Itemid = JRequest::getVar('Itemid');
		if($Gocmd=='Go'){
                	$examid = JRequest::getVar('examid');
                	$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=sms&controller=sms&task=displayexamtimetable&layout=examtimetable&examid='.$examid.'&Itemid='.$Itemid,false);
                        $this->setRedirect($redirectTo);
			return;
			
		}
                $model = & $this->getModel('sms');
                $timings= $_POST['hw'];
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=sms&controller=sms&task=displayexamtimetable&layout=examtimetable&examid='.$examid.'&Itemid='.$Itemid,false);
                foreach ($timings as $key=>$val){
                        list($cid,$sid,$eid,$scode,$ef)=explode('$$',$key);
                        if(($ef=="0") && (strlen($val)>8))
                                $rs=$model->saveExamTimeTable($cid,$sid,$eid,$scode,$val);
                        if(($ef=="1"))
                                $rs = $model->updateExamTimeTable($cid,$sid,$eid,$val);
                }
                if($sendcmd=='Send'){
                        $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=sms&view=sms&task=sendexamtimetable&layout=smsqueue&examid='.$examid.'&Itemid='.$Itemid,false);
                        $this->setRedirect($redirectTo);
                }
                if($savecmd=='Save'){
                        if($rs) $msg='Successfully saved...!';
                        else $msg='';
                        $this->setRedirect($redirectTo,$msg);
                }

        }



        function sendhomeworks(){
	        $this->validateuser();
        	$Itemid = JRequest::getVar('Itemid');
	        $user =& JFactory::getUser();
        	$smsdata = JRequest::get('POST');
	        $model = & $this->getModel('sms');
        	$courses=$model->getCurrentCourses();
	        foreach($courses as $crec) {
        	        $model->getCurrentHomeworks($crec->id,$hrecs);
			if(count($hrecs)>0){
				$sids = array();
	        	        $students=$model->getStudents($crec->id);
        	        	foreach($students as $student) {
                	        	$sids[]=$student->id;
	                	}
	        	        $studentsids = implode($sids,",");
        	        	$smstext="HW:".$crec->code."";
        	        	foreach($hrecs as  $hrec){
					if(strlen($hrec->homework)>2)
	                        		$smstext=$smstext.'['.$hrec->subjectcode."]".$hrec->homework."";
		                }
                		$logid = $model->logStudentSMS($smstext,'Homework SMS',$user->username,$crec->code,$studentsids);
                        	$q=$model->updateStudentASMSLog($logid,'A');
        		}
		}
	        $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=sms&view=sms&task=display&layout=smsqueue&Itemid='.$Itemid.'&logid='.$logid,false);
        	$this->setRedirect($redirectTo);
        }



        function savehomeworks(){
                $Itemid = JRequest::getVar('Itemid');
                $model = & $this->getModel('sms');
                $hws = $_POST['hw'];
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=sms&controller=sms&task=displayhomeworks&layout=homework&Itemid='.$Itemid,false);
                foreach ($hws as $key=>$val){
                        list($cid,$sid,$scode,$ef)=explode('$$',$key);
                        if(($ef=="0") && (strlen($val)>4))
                                $rs=$model->saveHomework($cid,$sid,$scode,$val);
                        if(($ef=="1"))
                                $rs = $model->updateHomework($cid,$sid,$val);
                }
                if($rs) $msg='Successfully saved...!';
                else $msg='';
                $this->setRedirect($redirectTo,$msg);
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
//Approve Directly
        	$q=$model->updateStudentASMSLog($logid,'A');

                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=sms&controller=sms&task=smsqueue&layout=smsqueue&Itemid='.$Itemid,false);

                $this->setRedirect($redirectTo,'Approved...!');

        }



//Logs for approval from today's absentees report
    function logtodaysabsenteessms()
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
        $model1 = & $this->getModel('classattendance');
        $model1->gettodayabsentees($trecs);
        $sids=array();
        $i=0;
        foreach($trecs as $trec) $sids[$i++]=$trec['studentid'];
       // $aColumn = JArrayHelper::getColumn($sids, 'studentid');
        $studentids = implode($sids,",");
        $logid = $model->logStudentSMS($smsdata['smstext'],'TodayAbsent',$user->username,'Absentees',$studentids);
        $q=$model->updateStudentASMSLog($logid,'A');
        $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=sms&view=sms&task=display&layout=smsqueue&category=sendstudentsbulksms&Itemid='.$Itemid.'&logid='.$logid,false);

        $this->setRedirect($redirectTo);

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
                $schoolinfo=$model1->getSchoolInfo();
                if(!$schoolinfo->smssending){
                        JError::raiseWarning(500,'SMS Sending is not enabled, Please enable in School Setup');
                        $this->setRedirect($redirectTo,'');
                        return;
                }
                $gensm = array('Male','male','M','m','MALE');
                $gensf = array('Female','female','F','f','FEMALE');
        	$logids = JRequest::getVar('cid',null,'default','array');

		$lc=count($logids);
		if($lc>0){
        	foreach($logids  as $logid){
                	$s = $model->getStudentSMSLogByID($logid,$rec);
	                $ids  = explode(",",$rec->sids);
        	        $persontype='';
                	foreach($ids as $id){
                        	$smstext=$rec->smstext;
	                        if($rec->sentto=='Staff'){
        	                        $persontype='f';
                	                $model->getStaff($id,$srec);
                        	        $mobile=$srec->mobile;
                        //      	echo $srec->staffcode."/".$rec->smstext.'/'.$srec->mobile.'<br />';
	                        }else{
        	                        $persontype='s';
                	                $model->getStudent($id,$srec);
                        	        if($srec->smsto=="F")
                                	        $mobile=$srec->mobile;
	                                else if($srec->smsto=="M")
        	                                $mobile=$srec->mmobile;
                	                else if($srec->smsto=="G")
                        	                $mobile=$srec->gmobile;
                                	else
                                        	$mobile=$srec->mobile;
	                                $model->getCourse($srec->joinedclassid,$crec);
        	                //      echo $srec->registerno."/".$rec->smstext.'/'.$srec->mobile.'<br />';
                	                        //$smstext=str_replace("NAME",$srec->firstname,$rec->smstext);
                        	         $cdate=date("d-m-Y");
                                	 if(in_array($srec->gender,$gensm))
                                        	$gender='Son';
	                                 else if(in_array($srec->gender,$gensf))
        	                                $gender='Daughter';
                	                 else
                        	                $gender='';
                                	if($rec->sentto=="Absentees"){
	                                       $smstext=str_replace("NAME",$srec->firstname,$smstext);
        	                               $smstext=str_replace("CLASS",$crec->code,$smstext);
                	                       $smstext=str_replace("GENDER",$gender,$smstext);
                        	               $smstext=str_replace("DATE",$cdate,$smstext);
                                	}
	                                if($rec->sentto=="Individual"){
        	                               $smstext=str_replace("NAME",$srec->firstname,$smstext);
                	                       $smstext=str_replace("CLASS",$crec->code,$smstext);
                        	               $smstext=str_replace("GENDER",$gender,$smstext);
                                	       $smstext=str_replace("DATE",$cdate,$smstext);
	                                }	
        	                }
                	        //$rs=$this->sms_api($smstext,$mobile);
                        	$rs=$model->log_sms_sent_q($smstext,$mobile,$persontype,$id,$logid);
	                        if($rs==false)
        	                        $q=$model->logStudentSMSStatus($logid,$id,"Y");
                	        else
                        	        $q=$model->logStudentSMSStatus($logid,$id,"N");
	                }
          	      	$q=$model->updateStudentASMSLog($logid,'S');
	        }
		}else{
	                JError::raiseWarning(500,'Please select a record..');
                        $this->setRedirect($redirectTo,'');
			return;
		}
                $this->setRedirect($redirectTo,'Message(s) Sent...');
	}

        function sendtestsms(){
                $testsmsno  = JRequest::getVar('testsmsno');
                $testsmstext = JRequest::getVar('testsmstext');
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=sms&view=sms&task=display&layout=smsqueue&Itemid='.$Itemid,false);
                if($testsmsno){
                        $rs = $this->sms_api($testsmstext,$testsmsno);
                        if($rs) $msg='Message Sent...';
                        else $msg='Message failed...';
                        $this->setRedirect($redirectTo,$msg);
                }else{
                        JError::raiseWarning(500,'Please enter Test SMS Mobile number..');
                        $this->setRedirect($redirectTo);
                }
        }






  //Send Batch/CLass sms

 /*       function sendstudentsms(){
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
		if(!$schoolinfo->smssending){
			JError::raiseWarning(500,'SMS Sending is not enabled, Please enable in School Setup');
			$this->setRedirect($redirectTo,'');
			return;
		}
 		$gensm = array('Male','male','M','m');
                $gensf = array('Female','female','F','f');

		$persontype='';
		foreach($ids as $id){
			$smstext=$rec->smstext;

			if($rec->sentto=='Staff'){
				$persontype='f';
				$model->getStaff($id,$srec);
                                $mobile=$srec->mobile;
        		//	echo $srec->staffcode."/".$rec->smstext.'/'.$srec->mobile.'<br />';
			}else{ 
				$persontype='s';
				$model->getStudent($id,$srec);
                                $mobile =$srec->mobile;
                                $model->getCourse($srec->joinedclassid,$crec);
        		//	echo $srec->registerno."/".$rec->smstext.'/'.$srec->mobile.'<br />';
				if($rec->sentto=="Absentees"){
         			       if($srec->smsto=="F")
                                                $mobile=$srec->mobile;
                                       else if($srec->smsto=="M")
                                                $mobile=$srec->mmobile;
                                       else if($srec->smsto=="G")
                                                $mobile=$srec->gmobile;
                                       else   $mobile=$srec->mobile;
                                        //$smstext=str_replace("NAME",$srec->firstname,$rec->smstext);
                                       $cdate=date("d-m-Y");
                                       if(in_array($srec->gender,$gensm))
                                                $gender='Son';
                                       else if(in_array($srec->gender,$gensf))
                                                $gender='Daughter';
                                       else
                                                $gender='';
                                       $smstext= sprintf("Dear Parents,\n Your %s %s [%s] is absent today %s. \nPrincipal",$gender,$srec->firstname,$crec->code,$cdate);
                                }

			}	
			//$rs=$this->sms_api($smstext,$mobile);
			$rs=$model->log_sms_sent_q($smstext,$mobile,$persontype,$id,$logid);
			if($rs==false)
                		$q=$model->logStudentSMSStatus($logid,$id,"Y");	
			else
                		$q=$model->logStudentSMSStatus($logid,$id,"N");
                }

                $q=$model->updateStudentASMSLog($logid,'S');
                $this->setRedirect($redirectTo);
        }
*/


 function logindividualstudentsms() {
        $this->validateuser();
        $Itemid = JRequest::getVar('Itemid');
        $courseid = JRequest::getVar('courseid');
        $coursecode= JRequest::getVar('to');
        $user =& JFactory::getUser();
        $smsdata = JRequest::get('POST');
        $sids = JRequest::getVar('cid',null,'default','array');
        $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=sms&view=sms&task=individualstudentsms&layout=individualstudentsms&courseid='.$courseid.'&Itemid='.$Itemid,false);
        if($smsdata['smstext']==''){
                JError::raiseWarning(500,'Sorry, SMS message is empty...');
                $this->setRedirect($redirectTo,'');
                return;
        }
        if(count($sids)<1){
                JError::raiseWarning(500,'Sorry, Please select students...');
                $this->setRedirect($redirectTo,'');
                return;
        }
        $model = & $this->getModel('sms');
        $studentsids = implode($sids,",");
        $logid = $model->logStudentSMS($smsdata['smstext'],'Individual SMS',$user->username,'Individual',$studentsids);
        $q=$model->updateStudentASMSLog($logid,'A');
        $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=sms&view=sms&layout=smsqueue&Itemid='.$Itemid.'&logid='.$logid,false);
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
        	$q=$model1->updateStudentASMSLog($logid,'A');

                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=sms&controller=sms&task=smsqueue&layout=smsqueue&Itemid='.$Itemid,false);

                $this->setRedirect($redirectTo,'Approved...!');

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
        $q=$model->updateStudentASMSLog($logid,'A');

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

		$ids = JRequest::getVar('courses',null,'default','array');

		if(!$ids[0]){



	         $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=sms&view=sms&task=displaystudents&layout=batchstudentsms&courseid='.$courseid.'&Itemid='.$Itemid,false);

       		 JError::raiseWarning(500,'Please select any course');

                $this->setRedirect($redirectTo,'');

			return;

		}	

        if($smsdata['smstext']==''){

			

	         $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=sms&view=sms&task=displaystudents&layout=batchstudentsms&courseid='.$courseid.'&Itemid='.$Itemid,false);

      

                 JError::raiseWarning(500,'Sorry, SMS message is empty...');

                $this->setRedirect($redirectTo,'');

                return;

        }

        $model = & $this->getModel('sms');

		foreach($ids as $id)

		{

			$model->getCourse($id,$co);

			$students=$model->getStudents($co->id);

				$cid[]=$co->code;

			foreach($students as $student)

			{

				

					$sids[]=$student->id;

			}

				

		}



		echo  $studentsids = implode($sids,",");
		
		 $corsecodes = implode($cid,",");

	

		$logid = $model->logStudentSMS($smsdata['smstext'],'Batch SMS',$user->username,$corsecodes,$studentsids);
        	$q=$model->updateStudentASMSLog($logid,'A');

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

        $logid= JRequest::getVar('logid');

        $model = & $this->getModel('sms');

        $model->deleteSMS($logid);

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




