<?php
// No direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
include_once('cce.php');
 
jimport( 'joomla.application.component.model' );
class CceModelSendmail extends CceModelCce
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

        function sentmail($pgroupname,$pgroupcode,$ppurpose,$pdescription)
        {
                $q = "INSERT INTO #__studentgroups(groupname,groupcode,purpose,description,aid) VALUES('".$pgroupname."','".$pgroupcode."','".$ppurpose."','".$pdescription."',(SELECT id FROM #__academicyears WHERE status='Y'))";
        	$db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
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
                $q = 'DELETE FROM #__groupmembers WHERE gid = '.$pgid.' AND sid='.$psid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
	}

    
}

