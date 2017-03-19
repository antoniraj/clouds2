<?php

include_once('schoolcal.php');
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.model' );
 
class CceModelStaffAttendance extends CceModelSchoolCal {

	function __construct(){
        	parent::__construct();
        }

	function getStaffAbsentDays($pfrom,$pto,$psid,&$abs){
                $q = "SELECT count(*) AS `abs` FROM `#__staffattendance` WHERE `cdate` BETWEEN '".$pfrom."' AND '".$pto."' AND `staffid`=".$psid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $abs = $db->loadAssocList();
                if($abs==null)
                        return false;
                return true;
        }

        function getDepartmentAbsenteesByDate($depid,$pdate,&$data)
        {
                $q = "SELECT DISTINCT `staffid` FROM #__staffattendance WHERE `cdate` = '".$pdate."' AND staffid IN ( SELECT id FROM #__staffs WHERE department=".$depid.")";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $data = $db->loadObjectList();
                if($data==null)
                        return false;
                return true;
        }

        function getStaffAbsenteesByDateAndSession($pdate,$session,&$data)
        {
                $q = "SELECT `staffid` FROM #__staffattendance WHERE `cdate` = '".$pdate."' AND lower(`sessiontype`) =lower('".$session."')";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $data = $db->loadAssocList();
                if($data==null)
                        return false;
                return true;
        }

        function getStaffAbsenteeByDateAndSession($psid,$pdate,$session,&$data)
        {
                $q = "SELECT `staffid` FROM #__staffattendance WHERE `cdate` = '".$pdate."' AND lower(`sessiontype`) =lower('".$session."') AND staffid=".$psid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $data = $db->loadAssocList();
                if($data==null)
                        return false;
                return true;
        }

        function getStaffRegularAbsentees(&$recs)
	{
		$q = "SELECT `staffid`,round(count(*)/2,1) as abs FROM `#__staffattendance` WHERE `aid` IN (select `id` FROM `#__academicyears` where `status`='Y') group by `staffid` order by count(*) DESC";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $recs = $db->loadAssocList();
                if($recs==null)
                        return false;
                return true;
	}


       function addStaffAbsentee($pdate,$psid,$psession)
       {
                $q = "INSERT INTO #__staffattendance(`cdate`,`staffid`,`sessiontype`) VALUES('".$pdate."',".$psid.",'".$psession."')";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }
		function addstaffpresent($pdate)
       {
                $q = "INSERT INTO #__staffpresent(`date`) VALUES('".$pdate."')";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

        function deleteStaffAbsentee($pcdate,$psid,$psession)
        {
                $q = "DELETE FROM `#__staffattendance` WHERE `cdate`='".$pcdate."' AND `staffid`=".$psid." AND `sessiontype` ='".$psession."'" ;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

		function getstaffpresent($pdate,&$data)
        {
                $q = "SELECT `date` FROM #__staffpresent WHERE `date` = '".$pdate."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $data = $db->loadAssoc();
                if($data==null)
                        return false;
                return true;
        }
        function deleteStaffAbsentees($pcdate,$psession)
        {
                $q = "DELETE FROM `#__staffattendance` WHERE `cdate`='".$pcdate."' AND `sessiontype` ='".$psession."'" ;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }
         function getStaffAbsenteeByid($psid,$pdate,&$data)
        {
                $q = "SELECT `staffid` FROM #__staffattendance WHERE `cdate` = '".$pdate."' AND staffid=".$psid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $data = $db->loadAssoc();
                if($data==null)
                        return false;
                return true;
        }

}

