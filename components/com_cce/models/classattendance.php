<?php

include_once('schoolcal.php');
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.model' );
 
class CceModelClassAttendance extends CceModelSchoolCal
{

	function __construct(){
        	parent::__construct();
        }

	function getAbsentDays($pfrom,$pto,$psid,&$abs){
                $q = "SELECT count(*) AS `abs` FROM `#__classattendance` WHERE `cdate` BETWEEN '".$pfrom."' AND '".$pto."' AND `studentid`=".$psid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $abs = $db->loadAssocList();
                if($abs==null)
                        return false;
                return true;
        }

        function getAbsenteesByDateAndSession($pdate,$session,&$data)
        {
                $q = "SELECT `studentid` FROM #__classattendance WHERE `cdate` = '".$pdate."' AND lower(`sessiontype`) =lower('".$session."')";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $data = $db->loadAssocList();
                if($data==null)
                        return false;
                return true;
        }

        function getAbsenteeByDateAndSession($psid,$pdate,$session,&$data)
        {
                $q = "SELECT `studentid` FROM #__classattendance WHERE `cdate` = '".$pdate."' AND lower(`sessiontype`) =lower('".$session."') AND studentid=".$psid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $data = $db->loadAssocList();
                if($data==null)
                        return false;
                return true;
        }



        function getAbsenteesByClassDate($pclassid,$pdate,&$data)
        {
		$q = "SELECT `studentid`,`sessiontype` FROM #__classattendance where classid=".$pclassid." and cdate='".$pdate."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $data = $db->loadAssocList();
                if($data==null)
                        return false;
                return true;
        }
        
        function countstudentabsentees(&$data)
        {
			$tdate=date('Y-m-d');
			$q = "SELECT * FROM #__classattendance where cdate='".$tdate."' Group By `studentid`";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $data = $db->loadObjectList();
                if($data==null)
                        return false;
                return true;
        }
         function getAbsenteesByClassDateandsid($sid,$pclassid,$pdate,&$data)
        {
		$q = "SELECT `studentid`,`sessiontype`,count(*) AS `day` FROM #__classattendance where classid=".$pclassid." and cdate='".$pdate."' AND `studentid`='".$sid."' GROUP BY `studentid`";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $data = $db->loadAssocList();
                if($data==null)
                        return false;
                return true;
        }

	

	function getAbsenteesByDate($classid,$pdate,&$data)
        {
                $q = 'SELECT `studentid`,`sessiontype`,count(*) AS `day` FROM #__classattendance WHERE `cdate` = \''.$pdate.'\' AND `classid` = '.$classid.' GROUP BY `studentid`';
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $data = $db->loadAssocList();
                if($data==null)
                        return false;
                return true;
        }
        
	
	function gettodayabsentees(&$data)
        {
				$tdate=date('Y-m-d');
                $q = 'SELECT `studentid`,`sessiontype`,`classid`,count(*) AS `day` FROM #__classattendance WHERE `cdate` = \''.$tdate.'\' GROUP BY `studentid`';
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $data = $db->loadAssocList();
                if($data==null)
                        return false;
                return true;
        }
     function getstudentpresent($pdate,$classid,&$data)
        {
                $q = 'SELECT `courseid`,`date` FROM #__studentpresent WHERE `date` = \''.$pdate.'\' AND `courseid` = '.$classid.'';
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $data = $db->loadAssoc();
                if($data==null)
                        return false;
                return true;
        }


       function addAbsentee($pdate,$psid,$pclassid,$psession)
       {
                $q = "INSERT INTO #__classattendance(`cdate`,`studentid`,`classid`,`sessiontype`) VALUES('".$pdate."',".$psid.",".$pclassid.",'".$psession."')";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }
     function studentpresent($pdate,$pclassid)
       {

                $q = "INSERT INTO #__studentpresent(`date`,`courseid`) VALUES('".$pdate."',".$pclassid.")";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }


	function deleteAbsentees($pcdate,$pclassid,$psession)
        {
                $q = "DELETE FROM `#__classattendance` WHERE `cdate`='".$pcdate."' AND `classid`=".$pclassid." AND `sessiontype` ='".$psession."'" ;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }
/*
        function getRegularAbsentees(&$recs)
        {
                $q = "SELECT `studentid`,round(count(*)/2,1) as abs FROM `#__classattendance` WHERE `studentid` IN (SELECT `id` FROM `#__students` WHERE `joinedclassid` IN (SELECT `id` from `#__courses` where `aid` IN(select `id` FROM `#__academicyears` where `status`='Y'))) group by `studentid` order by count(*) DESC";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $recs = $db->loadAssocList();
                if($recs==null)
                        return false;
                return true;

        }

*/
        function getRegularAbsentees(&$recs)
	{
		$q = "SELECT `studentid`,round(count(*)/2,1) as abs FROM `#__classattendance` WHERE `studentid` IN (SELECT `studentid` FROM `#__studentclass` WHERE `classid` IN (SELECT `id` from `#__courses` where `aid` IN(select `id` FROM `#__academicyears` where `status`='Y'))) group by `studentid` order by count(*) DESC";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $recs = $db->loadAssocList();
                if($recs==null)
                        return false;
                return true;
	
	}

        function deleteAbsentee($pcdate,$psid,$pclassid,$psession)
        {
                $q = "DELETE FROM `#__classattendance` WHERE `cdate`='".$pcdate."' AND `studentid`=".$psid." AND `classid`=".$pclassid." AND `sessiontype` ='".$psession."'" ;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }
}

