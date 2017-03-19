<?php

include_once('schoolcal.php');
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.model' );
 
class CceModelClassLeave extends CceModelSchoolCal
{

	function __construct(){
        	parent::__construct();
        }

	function getRegularLeaveTakers(&$recs)
        {
                //$q = "SELECT `studentid`,round(count(*)/2,1) as ls FROM `#__classleave` WHERE `studentid` IN (SELECT `studentid` FROM `#__students` WHERE `joinedacademicyearid` IN (select `id` FROM `#__academicyears` where `status`='Y')) group by `studentid` order by count(*) DESC";
                $q = "SELECT `studentid`,round(count(*)/2,1) as ls FROM `#__classleave` WHERE `studentid` IN (SELECT `studentid` FROM `#__studentclass` WHERE `classid` IN (SELECT `id` FROM #_courses WHERE `aid` IN (select `id` FROM `#__academicyears` where `status`='Y'))) group by `studentid` order by count(*) DESC";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $recs = $db->loadAssocList();
                if($recs==null)
                        return false;
                return true;

        }


	function getRegularLeaveTakersByID($psid,&$recs)
        {
		$q="SELECT `studentid`,round(count(*)/2,1) as ls FROM `#__classleave` WHERE `studentid` = '".$psid."' and `studentid` IN (SELECT `studentid` FROM `#__studentclass` WHERE `classid` IN(select `id` FROM `#__courses` WHERE `aid` = (SELECT `id` FROM `#__academicyears` where `status`='Y'))) group by `studentid` order by count(*) DESC";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $recs = $db->loadAssocList();
                if($recs==null)
                        return false;
                return true;

        }

	function getLeaveDays($pfrom,$pto,$psid,&$ls){
                $q = "SELECT count(*) AS `ls` FROM `#__classleave` WHERE `cdate` BETWEEN '".$pfrom."' AND '".$pto."' AND `studentid`=".$psid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $ls = $db->loadAssocList();
                if($ls==null)
                        return false;
                return true;
        }


        function getLeaveByDateAndSession($psid,$pdate,$session,&$data)
        {
                $q = "SELECT `id`,`reason` FROM #__classleave WHERE `studentid` = ".$psid." AND `cdate` = '".$pdate."' AND lower(`sessiontype`) =lower('".$session."')";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $data = $db->loadAssocList();
                if($data==null)
                        return false;
                return true;
        }


	function getLeaveByDate($pdate,&$data)
        {
                $q = 'SELECT `studentid`,`sessiontype` FROM #__classleave WHERE `cdate` = \''.$pdate.'\'';
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $data = $db->loadAssocList();
                if($data==null)
                        return false;
                return true;
        }
		function gettodayabsentees($psid,&$recs)
        {
		       $q="SELECT `studentid` FROM `#__classattendance WHERE `studentid` = '".$psid."' and `studentid` IN (SELECT `studentid` FROM `#__studentclass` WHERE `classid` IN(select `id` FROM `#__courses` WHERE `aid` = (SELECT `id` FROM `#__academicyears` where `status`='Y'))) group by `studentid` order by count(*) DESC";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $recs = $db->loadAssocList();
                if($recs==null)
                        return false;
                return true;

        }
        function getAbsenteesByDatewithpermission($classid,$pdate,&$data)
        {
                $q = 'SELECT `studentid`,`sessiontype`,`reason`,count(*) AS `day` FROM #__classleave WHERE `cdate` = \''.$pdate.'\' AND `classid` = '.$classid.' GROUP BY `studentid`';
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $data = $db->loadAssocList();
                if($data==null)
                        return false;
                return true;
        }
  

       function addLeave($pdate,$psid,$pclassid,$psession,$reason)
       {
                $q = "INSERT INTO #__classleave(`cdate`,`studentid`,`classid`,`sessiontype`,`reason`) VALUES('".$pdate."',".$psid.",".$pclassid.",'".$psession."','".$reason."')";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }


        function deleteLeaveByID($pid)
        {
                $q = "DELETE FROM `#__classleave` WHERE `id`=".$pid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }


        function deleteLeave($fromdate,$todate,$psid)
        {
                $q = "DELETE FROM `#__classleave` WHERE (`cdate` BETWEEN '".$fromdate."' AND '".$todate."') AND `studentid`=".$psid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }
}

