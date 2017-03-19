<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
include_once('cce.php');

jimport( 'joomla.application.component.model' );

class CceModelSMS extends CceModelCce {
        function __construct(){
                parent::__construct();
        }



        function saveExamTimeTable($cid,$sid,$eid,$scode,$timings){
                $q = "INSERT INTO #__examtimetables(`classid`,`subjectid`,`examid`,`subjectcode`,`timings`) VALUES('".$cid."','".$sid."','".$eid."','".$scode."','".mysql_real_escape_string($timings)."')";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

        function updateExamTimeTable($cid,$sid,$eid,$timings){
                $q = "UPDATE #__examtimetables SET `timings`='".mysql_real_escape_string($timings)."' WHERE classid='".$cid."' AND subjectid='".$sid."' AND examid='".$eid."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }



       function getExamTimeTable($classid,$subjectid,$eid,&$rec)
        {
                $q = "SELECT `id`,`subjectcode`,`timings` FROM #__examtimetables WHERE `classid`='".$classid."' AND examid='".$eid."' AND `subjectid`='".$subjectid."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
        }



       function getCurrentExamTimeTables($classid,$eid,&$recs)
        {
                $q="SELECT `id`,`subjectcode`,`timings` FROM #__examtimetables WHERE examid='".$eid."' AND `classid`='".$classid."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $recs = $db->loadObjectList();
                if($recs==null)
                        return false;
                return true;
        }


        function saveTestPortion($cid,$sid,$scode,$hw){
                $q = "INSERT INTO #__testportions(`classid`,`subjectid`,`subjectcode`,`cdate`,`testportion`) VALUES('".$cid."','".$sid."','".$scode."',CURRENT_DATE,'".mysql_real_escape_string($hw)."')";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

        function updateTestPortion($cid,$sid,$hw){
                $q = "UPDATE #__testportions SET `testportion`='".mysql_real_escape_string($hw)."' WHERE classid='".$cid."' AND subjectid='".$sid."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }



       function getTestPortion($classid,$subjectid,&$rec)
        {
                $q = "SELECT `id`,`subjectcode`,`testportion`,date_format(`cdate`,'%d-%m-%Y') AS `cdate` FROM #__testportions WHERE `classid`='".$classid."' AND cdate=CURRENT_DATE AND `subjectid`='".$subjectid."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
        }


       function getCurrentTestPortions($classid,&$recs)
        {
                $q="SELECT `id`,`subjectcode`,`testportion`,date_format(`cdate`,'%d-%m-%Y') AS `cdate` FROM #__testportions WHERE cdate=CURRENT_DATE AND `classid`='".$classid."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $recs = $db->loadObjectList();
                if($recs==null)
                        return false;
                return true;
        }


        function saveHomework($cid,$sid,$scode,$hw){
                $q = "INSERT INTO #__homeworks(`classid`,`subjectid`,`subjectcode`,`cdate`,`homework`) VALUES('".$cid."','".$sid."','".$scode."',CURRENT_DATE,'".mysql_real_escape_string($hw)."')";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

        function updateHomework($cid,$sid,$hw){
                $q = "UPDATE #__homeworks SET `homework`='".mysql_real_escape_string($hw)."' WHERE classid='".$cid."' AND subjectid='".$sid."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }


       function getHomework($classid,$subjectid,&$rec)
        {
                $q = "SELECT `id`,`subjectcode`,`homework`,date_format(`cdate`,'%d-%m-%Y') AS `cdate` FROM #__homeworks WHERE `classid`='".$classid."' AND cdate=CURRENT_DATE AND `subjectid`='".$subjectid."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
        }


       function getCurrentHomeworks($classid,&$recs)
        {
                $q="SELECT `id`,`subjectcode`,`homework`,date_format(`cdate`,'%d-%m-%Y') AS `cdate` FROM #__homeworks WHERE cdate=CURRENT_DATE AND `classid`='".$classid."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $recs = $db->loadObjectList();
                if($recs==null)
                        return false;
                return true;
        }


        function getSMSSentStatusQSent($logid,&$recs){
                $q = "SELECT * FROM #__sms_sent_status_q WHERE `logid`=".$logid." AND errortext!='DELIVRD' AND errortext!='Sent'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $recs = $db->loadObjectList();
                if($recs==null)
                        return false;
                return true;
        }



	function getSMSSentStatusQAll($logid,&$recs){
                $q = "SELECT * FROM #__sms_sent_status_q WHERE `logid`=".$logid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $recs = $db->loadObjectList();
                if($recs==null)
                        return false;
                return true;
	}

	function rep_smslog($logid,&$tot,&$del,&$failed){
                $q = "SELECT count(*) as tot FROM #__sms_sent_status_q WHERE `logid`=".$logid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
		$tot=$rec->tot;
                $q = "SELECT count(*) as del FROM #__sms_sent_status_q WHERE `logid`='".$logid."' AND (`errortext`='DELIVRD' OR `errortext`='Sent')";
                $db->setQuery($q);
                $rec = $db->loadObject();
		$del=$rec->del;
                $q = "SELECT count(*) as sent FROM #__sms_sent_status_q WHERE `logid`='".$logid."' AND  (`errortext`!='DELIVRD' AND `errortext`!='Sent')";
                $db->setQuery($q);
                $rec = $db->loadObject();
		$failed=$rec->sent;
                if($rec==null)
                        return false;
                return true;
	}



	function log_sms_sent_q($smstext,$mobile,$persontype,$id,$logid){
                $q = "INSERT INTO #__sms_sent_q(`smstext`,`mobile`,`stype`,`cdate`,`ctime`,`sid`,`logid`,`aid`) VALUES('".mysql_real_escape_string($smstext)."','".$mobile."','".$persontype."',CURRENT_DATE,CURRENT_TIME,'".$id."','".$logid."',(SELECT id FROM ya_academicyears WHERE status='Y'))";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
	}

	function log_sms_sent_status_q($id,$smstext,$mobile,$persontype,$sid,$logid,$eno,$etext){
                $q = "INSERT INTO #__sms_sent_status_q(`id`,`smstext`,`mobile`,`stype`,`cdate`,`ctime`,`sid`,`logid`,`aid`,`errorcode`,`errortext`) VALUES('".$id."','".mysql_real_escape_string($smstext)."','".$mobile."','".$persontype."','".$sid."','".$logid."',(SELECT id FROM ya_academicyears WHERE status='Y'),'".$eno."','".$etext."')";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
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
                $q = "SELECT `id`,`smstext`,`smstype`,date_format(`smsdate`,'%d-%m-%Y') AS `fsmsdate`, `smstime`,`sentby`,`sentto`,`sids`,`status` FROM #__studentsmslog WHERE (`status` IN ('A','N')) AND (`aid` IN (SELECT `id` FROM `#__academicyears` WHERE `status` = 'Y')) ORDER BY id DESC";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $recs = $db->loadObjectList();
                if($recs==null)
                        return false;
                return true;
        }

	//To get Student SMS Log which are sent
	function getStudentSSMSLog($fdate,&$recs)
        {
                $q = "SELECT `id`,`smstext`,`smstype`,DATE(smsdate) AS `fsmsdate`, `smstime`,`sentby`,`sentto`,`sids`,`status` FROM #__studentsmslog WHERE (`status` IN ('S')) AND (`aid` IN (SELECT `id` FROM `#__academicyears` WHERE `status` = 'Y') AND smsdate='".$fdate."') ORDER BY id DESC";
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
		$q = "SELECT LAST_INSERT_ID() as logid";
		$db->setQuery($q);
                $obj = $db->loadObject();
                if($obj==null)
                        return false;
                return $obj->logid;
        }


	function addSMSTimeTableTitle($title,$examid){
                $q = "INSERT INTO `#__sms_timetablelist`(`title`,`examid`) VALUES('".mysql_real_escape_string(trim($title))."','".$examid."')";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
		$q = "SELECT LAST_INSERT_ID() as ttid";
		$db->setQuery($q);
                $obj = $db->loadObject();
                if($obj==null)
                        return false;
                return $obj->ttid;
	}

	function  updateSMSTimeTableTitle($title,$ttid)   {
                $q = "UPDATE `#__sms_timetablelist` SET `title` = '".mysql_real_escape_string(trim($title))."' WHERE `id`='". $ttid."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }


        function  deleteSMSTimeTableEntry($ttid)   {
                $q = "DELETE FROM `#__sms_timetable`  WHERE `id`='". $ttid."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }


	function deleteSMSTimeTableCourses($ttid){
                $q = "DELETE FROM `#__sms_timetablecourses` WHERE ttid='".$ttid."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
		return true;
	}

        function getSMSTimetableCourses($ttid,$courseid,&$list){
                $q = "SELECT `courseid` FROM `#__sms_timetablecourses` WHERE `ttid`='".$ttid."' AND courseid='".$courseid."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $list = $db->loadObjectList();
                if($list==null)
                        return false;
                return true;
        }


	function saveSMSTimeTableCourses($ttid,$courseid){
                $q = "INSERT INTO `#__sms_timetablecourses`(`ttid`,`courseid`) VALUES('".$ttid."','".$courseid."')";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
		return true;
	}


	function getSMSTimeTableListEntry($ttid,&$obj)
        {
                $q = "SELECT `title` FROM `#__sms_timetablelist` WHERE `id`='".$ttid."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $obj = $db->loadObject();
                if($obj==null)
                        return false;
                return true;
        }



	function getSMSTimetableList($examid,&$list){
                $q = "SELECT `id`,`title` FROM `#__sms_timetablelist` WHERE `examid`='".$examid."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $list = $db->loadObjectList();
                if($list==null)
                        return false;
                return true;
        }

	function getSMSTimeTableEntry($ttid,$sno,&$obj){
                $q = "SELECT `id`,`sno`,`fdate`,`fn`,`an`,`ttid` FROM `#__sms_timetable` WHERE `ttid`='".$ttid."' AND sno='".$sno."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $obj = $db->loadObject();
                if($obj==null)
                        return false;
                return true;
	}

        function getSMSTimeTableEntries($ttid,&$objs){
                $q = "SELECT `id`,`sno`,`fdate`,`fn`,`an`,`ttid` FROM `#__sms_timetable` WHERE `ttid`='".$ttid."' ORDER BY fdate";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $objs = $db->loadObjectList();
                if($objs==null)
                        return false;
                return true;
        }

	function  saveSMSExamTimeTable($i,$fdate,$fn,$an,$ttid)	{
                $q = "INSERT INTO #__sms_timetable(`sno`,`fdate`,`fn`,`an`,`ttid`) VALUES('".$i."','".$fdate."','".mysql_real_escape_string(trim($fn))."','".mysql_real_escape_string(trim($an))."','".$ttid."')";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
	}
	function  updateSMSExamTimeTable($tid,$fdate,$fn,$an)	{
		$q = "UPDATE `#__sms_timetable` SET `fdate` = '".$fdate."', `fn`='".mysql_real_escape_string(trim($fn))."', `an`='".mysql_real_escape_string(trim($an))."' WHERE `id`='". $tid."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
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
                $q = "INSERT INTO `#__studentsmslog`(`smstext`,`smstype`,`smsdate`,`smstime`,`sentby`,`sentto`,`sids`,`status`,`aid`,`smshash`) VALUES('".mysql_real_escape_string($psmstext)."','".$ptype."','".$smsdate."','".$smstime."','".$psentby."','".$psentto."','".$psids."','N',(SELECT `id` FROM `#__academicyears` WHERE `status`='Y' LIMIT 1),'".md5($smsdate.$psmstext.$psentto.$psids)."')";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
		$q = "SELECT LAST_INSERT_ID() as logid";
		$db->setQuery($q);
                $obj = $db->loadObject();
                if($obj==null)
                        return false;
                return $obj->logid;
	//	$logid = $this->getStudentLogID($smsdate,$smstime,$psentby);
          //      return $logid;
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

