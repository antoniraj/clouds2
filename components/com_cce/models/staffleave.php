<?php

include_once('schoolcal.php');
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.model' );
 
class CceModelStaffLeave extends CceModelSchoolCal
{

	function __construct(){
        	parent::__construct();
        }


	function getStaffLeaveDays($pfrom,$pto,$psid,&$ls){
                $q = "SELECT count(*) AS `ls` FROM `#__staffleave` WHERE `cdate` BETWEEN '".$pfrom."' AND '".$pto."' AND `staffid`=".$psid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $ls = $db->loadAssocList();
                if($ls==null)
                        return false;
                return true;
        }


        function getStaffLeaveByDateAndSession($psid,$pdate,$session,&$data)
        {
                $q = "SELECT `id`,`reason` FROM #__staffleave WHERE `staffid` = ".$psid." AND `cdate` = '".$pdate."' AND lower(`sessiontype`) =lower('".$session."')";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $data = $db->loadAssocList();
                if($data==null)
                        return false;
                return true;
        }


	function getStaffLeaveByDate($pdate,&$data)
        {
                $q = 'SELECT `staffid`,`sessiontype` FROM #__staffleave WHERE `cdate` = \''.$pdate.'\'';
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $data = $db->loadAssocList();
                if($data==null)
                        return false;
                return true;
        }


       function addStaffLeave($pdate,$psid,$psession,$reason)
       {
                $q = "INSERT INTO #__staffleave(`cdate`,`staffid`,`sessiontype`,`reason`) VALUES('".$pdate."',".$psid.",'".$psession."','".$reason."')";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }


        function deleteStaffLeaveByID($pid)
        {
                $q = "DELETE FROM `#__staffleave` WHERE `id`=".$pid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }


        function deleteStaffLeave($fromdate,$todate,$psid)
        {
                $q = "DELETE FROM `#__staffleave` WHERE (`cdate` BETWEEN '".$fromdate."' AND '".$todate."') AND `staffid`=".$psid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }
}

