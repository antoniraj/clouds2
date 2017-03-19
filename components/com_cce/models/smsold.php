<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
include_once('cce.php');

jimport( 'joomla.application.component.model' );

class CceModelSMS extends CceModelCce {
        function __construct(){
                parent::__construct();
        }

	function getStudentSMSLogByID($psmsid,&$rec)
        {
                $q = "SELECT `id`,`smstext`,`smstype`,date_format(`smsdate`,'%d-%d-%Y') AS `fsmsdate`, `smstime`,`sentby` FROM #__studentsmslog WHERE `id`=".$psmsid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
        }


        function getStaffSMSLogByID($psmsid,&$rec)
        {
                $q = "SELECT `id`,`smstext`,`smstype`,date_format(`smsdate`,'%d-%d-%Y') AS `fsmsdate`, `smstime`,`sentby` FROM #__staffsmslog WHERE `id`=".$psmsid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
        }

        function getStudentSMSLog(&$recs)
        {
                $q = "SELECT `id`,`smstext`,`smstype`,date_format(`smsdate`,'%d-%d-%Y') AS `fsmsdate`, `smstime`,`sentby`,`sentto`,`status` FROM #__studentsmslog WHERE `aid` IN (SELECT `id` FROM `#__academicyears` WHERE `status` = 'Y')";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $recs = $db->loadObjectList();
                if($recs==null)
                        return false;
                return true;
        }

	function getStaffSMSLog(&$recs)
        {
                $q = "SELECT `id`,`smstext`,`smstype`,date_format(`smsdate`,'%d-%d-%Y') AS `fsmsdate`, `smstime`,`sentby`,`sentto`,`status` FROM #__staffsmslog WHERE `aid` IN (SELECT `id` FROM `#__academicyears` WHERE `status` = 'Y')";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $recs = $db->loadObjectList();
                if($recs==null)
                        return false;
                return true;
        }


        function getSMSLogByStaffID($staffid,&$recs)
        {
                $q = "SELECT `smslogid`,`status` FROM `#__staffsmsstatuslog` WHERE `sid`='.$staffid.' AND `smslogid` IN (SELECT `id` FROM `#__staffsmslog` WHERE `academicyearid` IN (SELECT `id` FROM `#__academicyears` WHERE `status`='Y'))";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $recs = $db->loadObjectList();
                if($recs==null)
                        return false;
                return true;
        }


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


	function logStudentSMSStatus($plogid,$psid,$pstatus)
        {
                $q = "INSERT INTO #__studentsmsstatuslog(`smslogid`,`sid`,`status`) VALUES('".$plogid."','".$psid."','".$pstatus."')";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }


        function logStudentUpdateSMSStatus($plogid,$psid,$pstatus)
        {
                $q = "UPDATE #__studentsmsstatuslog SET `status`='".$pstatus."' WHERE `smslogid`='".$plogid."' AND `sid`='".$psid."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }


        function logStaffSMSStatus($plogid,$psid,$pstatus)
        {
                $q = "INSERT INTO #__staffsmsstatuslog(`smslogid`,`sid`,`status`) VALUES('".$plogid."','".$psid."','".$pstatus."')";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }


       function logStaffSMS($psmstext,$ptype,$psentby,$psentto)
       {
		$smsdate = date("Y-m-d");
		$smstime = date("h:i:s");
		$ptype='---';
                //$q = "INSERT INTO #__staffsmslog(`smstext`,`smstype`,`smsdate`,`smstime`,`sentby`) VALUES('".$psmstext."','".$ptype."','current_date','current_time','".$psentby."')";
                $q = "INSERT INTO `#__staffsmslog`(`smstext`,`smstype`,`smsdate`,`smstime`,`sentby`,`sentto`,`status`,`aid`) VALUES('".$psmstext."','".$ptype."','".$smsdate."','".$smstime."','".$psentby."','".$psentto."','N',(SELECT `id` FROM `#__academicyears` WHERE `status`='Y' LIMIT 1))";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
		$logid = $this->getStaffLogID($smsdate,$smstime,$psentby);
                return $logid;
        }



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

       function logStudentSMS($psmstext,$ptype,$psentby,$psentto)
       {
		$smsdate = date("Y-m-d");
		$smstime = date("h:i:s");
		$ptype='---';
                //$q = "INSERT INTO `#__studentsmslog`(`smstext`,`smstype`,`smsdate`,`smstime`,`sentby`) VALUES('".$psmstext."','".$ptype."',current_date,current_time,'".$psentby."')";
                $q = "INSERT INTO `#__studentsmslog`(`smstext`,`smstype`,`smsdate`,`smstime`,`sentby`,`sentto`,`status`,`aid`) VALUES('".$psmstext."','".$ptype."','".$smsdate."','".$smstime."','".$psentby."','".$psentto."','N',(SELECT `id` FROM `#__academicyears` WHERE `status`='Y' LIMIT 1))";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
		$logid = $this->getStudentLogID($smsdate,$smstime,$psentby);
                return $logid;
        }

}
