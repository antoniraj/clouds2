<?php
// No direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
include_once('cce.php');
 
jimport( 'joomla.application.component.model' );
class CceModelGroups extends CceModelCce
{
	function __construct(){
        	parent::__construct();
        }


	function getGroup($pid,&$rec)
        {
                $q = "SELECT id,groupname,groupcode,purpose,description FROM #__studentgroups WHERE id ='".$pid."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
        }

        function addGroup($pgroupname,$pgroupcode,$ppurpose,$pdescription)
        {
                $q = "INSERT INTO #__studentgroups(groupname,groupcode,purpose,description,aid) VALUES('".$pgroupname."','".$pgroupcode."','".$ppurpose."','".$pdescription."',(SELECT id FROM #__academicyears WHERE status='Y'))";
        	$db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
		$q = "SELECT LAST_INSERT_ID() as gid";
		$db->setQuery($q);
                $obj = $db->loadObject();
                if($obj==null)
                        return false;
                return $obj->gid;
        }

        function updateGroup($id,$pgroupname,$pgroupcode,$ppurpose,$pdescription)
        {
                $q = "UPDATE #__studentgroups SET groupname='".$pgroupname."', groupcode='".$pgroupcode."', purpose='".$ppurpose."', description='".$pdescription."' WHERE id=".$id;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }


        function deleteGroup($pids)
        {
                $ids = implode(',',$pids);
                $q = 'DELETE FROM #__studentgroups WHERE id IN ('.$ids.')';
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

	function getGroups()
    	{
		$db =& JFactory::getDBO();
		$query = "SELECT id,groupname,groupcode,purpose,description FROM #__studentgroups WHERE aid = (SELECT id FROM #__academicyears WHERE status='Y')";
		$db->setQuery( $query );
		$groups = $db->loadObjectList();
		return $groups;
    	}

        function getGroupMembers($pgid){		
		$db =& JFactory::getDBO();
		$query ="SELECT id,registerno,firstname,middlename,lastname,dob,gender,bloodgroup,birthplace,nationality,mothertongue,caste,religion,addressline1,addressline2,city,state,pincode,country,phone,mobile,email,joinedclassid FROM `#__students` WHERE id IN (SELECT sid FROM `#__groupmembers` WHERE gid ='".$pgid."')";
		$db->setQuery($query);
		$members= $db->loadObjectList();
		return $members;
    	}


        function getCourseByGroup($studentid,$groupid,&$rec){		
		$db =& JFactory::getDBO();
		$query = "SELECT * FROM #__courses where aid in (select id from #__academicyears where status='Y') AND id IN (SELECT classid FROM #__studentclass WHERE studentid ='".$studentid."' and  studentid IN (SELECT sid FROM #__groupmembers WHERE gid='".$groupid."')) LIMIT 1";
		$db->setQuery($query);
		$rec= $db->loadObject();
                if($rec==null)
                        return false;
                return true;
		
    	}




       function assignGroupMember($pgid,$psid)
       {
                $q = "INSERT INTO #__groupmembers(gid,sid) VALUES(".$pgid.",".$psid.")";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

        function deleteGroupMember($pgid,$psid)
        {
                $q = 'DELETE FROM #__groupmembers WHERE gid = '.$pgid.' AND sid="'.$psid.'"';
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
	}

    
}

