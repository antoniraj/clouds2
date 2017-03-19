<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
include_once('cce.php');

jimport( 'joomla.application.component.model' );

class CceModelSMS extends CceModelCce {
        function __construct(){
                parent::__construct();
        }


	//Delete a SMS or Cancel a SMS
        function deleteSMS($pid)
        {
                $q = 'DELETE FROM `#__studentsmslog` WHERE id ='.$pid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }


	//To get the student Log record using logid
	function getStudentSMSLogByID($psmsid,&$rec)
        {
                $q = "SELECT `id`,`smstext`,`smstype`,date_format(`smsdate`,'%d-%m-%Y') AS `fsmsdate`, `smstime`,`sentby`,`sentto`,`sids` FROM #__studentsmslog WHERE `id`=".$psmsid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
        }


	//To get the staffLog by logid
        function getStaffSMSLogByID($psmsid,&$rec)
        {
                $q = "SELECT `id`,`smstext`,`smstype`,date_format(`smsdate`,'%d-%m-%Y') AS `fsmsdate`, `smstime`,`sentby`,`sids` FROM #__staffsmslog WHERE `id`=".$psmsid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
        }


	//To get Student SMS Log which are pending and not sent
        function getStudentSMSLog(&$recs)
        {
                $q = "SELECT `id`,`smstext`,`smstype`,date_format(`smsdate`,'%d-%m-%Y') AS `fsmsdate`, `smstime`,`sentby`,`sentto`,`sids`,`status` FROM #__studentsmslog WHERE (`status` IN ('A','N')) AND (`aid` IN (SELECT `id` FROM `#__academicyears` WHERE `status` = 'Y')) ORDER BY fsmsdate DESC,smstime DESC";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $recs = $db->loadObjectList();
                if($recs==null)
                        return false;
                return true;
        }

	//To get Student SMS Log which are sent
	function getStudentSSMSLog(&$recs)
        {
                $q = "SELECT `id`,`smstext`,`smstype`,DATE(smsdate) AS `fsmsdate`, `smstime`,`sentby`,`sentto`,`sids`,`status` FROM #__studentsmslog WHERE (`status` IN ('S')) AND (`aid` IN (SELECT `id` FROM `#__academicyears` WHERE `status` = 'Y')) ORDER BY fsmsdate DESC, smstime DESC";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $recs = $db->loadObjectList();
                if($recs==null)
                        return false;
                return true;
        }



	//To get Student SMSs for approval i.e New Ready
	function getStudentASMSLog(&$recs)
        {
                $q = "SELECT `id`,`smstext`,`smstype`,date_format(`smsdate`,'%d-%m-%Y') AS `fsmsdate`, `smstime`,`sentby`,`sentto`,`sids`,`status` FROM #__studentsmslog WHERE (`status` = 'N') AND (`aid` IN (SELECT `id` FROM `#__academicyears` WHERE `status` = 'Y')) ORDER BY fsmsdate DESC, smstime DESC";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $recs = $db->loadObjectList();
                if($recs==null)
                        return false;
                return true;
        }


	//To get List of Staff SMS messages which are new and approved
	function getStaffSMSLog(&$recs)
        {
                $q = "SELECT `id`,`smstext`,`smstype`,date_format(`smsdate`,'%d-%m-%Y') AS `fsmsdate`, `smstime`,`sentby`,`sentto`,`status` FROM #__staffsmslog WHERE `status` IN ('A','N') AND `aid` IN (SELECT `id` FROM `#__academicyears` WHERE `status` = 'Y') ORDER BY fsmsdate DESC,smstime DESC";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $recs = $db->loadObjectList();
                if($recs==null)
                        return false;
                return true;
        }


	//To get Staff SMS messages which are new
	function getStaffASMSLog(&$recs)
        {
                $q = "SELECT `id`,`smstext`,`smstype`,date_format(`smsdate`,'%d-%m-%Y') AS `fsmsdate`, `smstime`,`sentby`,`sentto`,`status` FROM #__staffsmslog WHERE `status` IN ('N') AND `aid` IN (SELECT `id` FROM `#__academicyears` WHERE `status` = 'Y') ORDER BY fsmsdate DESC,smstime DESC";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $recs = $db->loadObjectList();
                if($recs==null)
                        return false;
                return true;
        }

	//To get status of  SMS messages of the given staff
        function getSMSLogByStaffID($staffid,&$recs)
        {
                $q = "SELECT `smslogid`,`status` FROM `#__staffsmsstatuslog` WHERE `sid`='.$staffid.' AND `smslogid` IN (SELECT `id` FROM `#__staffsmslog` WHERE `academicyearid` IN (SELECT `id` FROM `#__academicyears` WHERE `status`='Y'))";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $recs = $db->loadObjectList();
                if($recs==null) return false;
                return true;
        }


	//To get status of  SMS messages of the given student
	function getSMSLogByStudentID($studentid,&$recs)
        {
                $q = "SELECT `smslogid`,`status` FROM `#__studentsmsstatuslog` WHERE `sid`='.$studentid.' AND `smslogid` IN (SELECT `id` FROM `#__studentsmslog` WHERE `academicyearid` IN (SELECT `id` FROM `#__academicyears` WHERE `status`='Y'))";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $recs = $db->loadObjectList();
                if($recs==null)
                        return false;
                return true;

        }

	//To get STaff sms log based on logid and status
        function getStaffSMSStatusLogByLID($plogid,$pstatus,&$staffids)
        {
                $q = "SELECT `sid` FROM `#__staffsmsstatuslog` WHERE `smslogid`='".$plogid."' AND `status`='".$pstatus."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $staffids = $db->loadObjectList();
                if($staffids==null)
                        return false;
                return true;
        }

	//To get Student sms log based on login and status
        function getStudentSMSStatusLogByLID($plogid,$pstatus,&$studentids)
        {
                $q = "SELECT `sid` FROM `#__studentsmsstatuslog` WHERE `smslogid`='".$plogid."' AND `status`='".$pstatus."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $studentids = $db->loadObjectList();
                if($studentids==null)
                        return false;
                return true;
        }

	//To log student sms status for each student
	function logStudentSMSStatus($plogid,$psid,$pstatus)
        {
                $q = "INSERT INTO #__studentsmsstatuslog(`smslogid`,`sid`,`status`) VALUES('".$plogid."','".$psid."','".$pstatus."')";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }


	//To update status of student sms log
        function logStudentUpdateSMSStatus($plogid,$psid,$pstatus)
        {
                $q = "UPDATE #__studentsmsstatuslog SET `status`='".$pstatus."' WHERE `smslogid`='".$plogid."' AND `sid`='".$psid."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }


	//To log staff sms status for each staff
        function logStaffSMSStatus($plogid,$psid,$pstatus)
        {
                $q = "INSERT INTO #__staffsmsstatuslog(`smslogid`,`sid`,`status`) VALUES('".$plogid."','".$psid."','".$pstatus."')";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

	//To log staff sms
       function logStaffSMS($psmstext,$ptype,$psentby,$psentto)
       {
		$smsdate = date("Y-m-d");
		$smstime = date("h:i:s");
		$ptype='---';
                //$q = "INSERT INTO #__staffsmslog(`smstext`,`smstype`,`smsdate`,`smstime`,`sentby`) VALUES('".$psmstext."','".$ptype."','current_date','current_time','".$psentby."')";
                $q = "INSERT INTO `#__staffsmslog`(`smstext`,`smstype`,`smsdate`,`smstime`,`sentby`,`sentto`,`status`,`aid`) VALUES('".mysql_real_escape_string($psmstext)."','".$ptype."','".$smsdate."','".$smstime."','".$psentby."','".$psentto."','N',(SELECT `id` FROM `#__academicyears` WHERE `status`='Y' LIMIT 1))";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
		$logid = $this->getStaffLogID($smsdate,$smstime,$psentby);
                return $logid;
        }


	//to get a logid based on date time and sentby for staff
        function getStaffLogID($pdate,$ptime,$psentby)
        {
                $q = "SELECT `id` FROM `#__staffsmslog` WHERE `smsdate`='".$pdate."' AND `smstime`='".$ptime."' AND `sentby`='".$psentby."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $id = $db->loadObject();
                if($id==null)
                        return false;
                return $id;
        }


	//to get a logid based on date time and sentby for student
	function getStudentLogID($pdate,$ptime,$psentby)
	{
                $q = "SELECT `id` FROM `#__studentsmslog` WHERE `smsdate`='".$pdate."' AND `smstime`='".$ptime."' AND `sentby`='".$psentby."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $obj = $db->loadObject();
                if($obj==null)
                        return false;
                return $obj->id;
	}

	//To log student sms
       function logStudentSMS($psmstext,$ptype,$psentby,$psentto,$psids)
       {
		$smsdate = date("Y-m-d");
		$smstime = date("h:i:s");
		$ptype='---';
                //$q = "INSERT INTO `#__studentsmslog`(`smstext`,`smstype`,`smsdate`,`smstime`,`sentby`) VALUES('".$psmstext."','".$ptype."',current_date,current_time,'".$psentby."')";
                $q = "INSERT INTO `#__studentsmslog`(`smstext`,`smstype`,`smsdate`,`smstime`,`sentby`,`sentto`,`sids`,`status`,`aid`) VALUES('".mysql_real_escape_string($psmstext)."','".$ptype."','".$smsdate."','".$smstime."','".$psentby."','".$psentto."','".$psids."','N',(SELECT `id` FROM `#__academicyears` WHERE `status`='Y' LIMIT 1))";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
		$logid = $this->getStudentLogID($smsdate,$smstime,$psentby);
                return $logid;
        }
        
	//To update the student sms status
	function updateStudentASMSLog($logid,$pstatus)
	{
		$q = "UPDATE `#__studentsmslog` SET `status` = '".$pstatus."' WHERE `id`=". $logid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
	}
	

}
