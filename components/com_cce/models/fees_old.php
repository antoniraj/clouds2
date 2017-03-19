<?php
// No direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
include_once('cce.php');
 
jimport( 'joomla.application.component.model' );
class CceModelFees extends CceModelCce
{
	function __construct(){
        	parent::__construct();
        }

//Fee Categories
	function getFeeCategory($pid,&$rec)
        {
                $q = "SELECT id,name,description FROM #__feecategory WHERE id ='".$pid."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
        }

        function addFeeCategory($name,$pdescription)
        {
                $q = "INSERT INTO #__feecategory(name,description,aid) VALUES('".$name."','".$pdescription."',(SELECT id FROM #__academicyears WHERE status='Y'))";
        	$db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

        function updateFeeCategory($pid,$name,$pdescription)
        {
                $q = "UPDATE #__feecategory SET name='".$name."', description='".$pdescription."' WHERE id=".$pid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

        function deleteFeeCategory($pid)
        {
                $q = 'DELETE FROM #__feecategory WHERE id IN ('.$pid.')';
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

	function getFeeCategories()
    	{
		$db =& JFactory::getDBO();
		$query = "SELECT id,name,description FROM #__feecategory WHERE aid = (SELECT id FROM #__academicyears WHERE status='Y')";
		$db->setQuery( $query );
		$res= $db->loadObjectList();
		return $res;
    	}




//Fee Particulars
        function getFeeParticular($ppid,&$rec)
        {
                $q = "SELECT id,name,description,amount FROM #__feeparticulars WHERE id ='".$ppid."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
        }

	function addFeeParticular($pname,$pdescription,$pamount,$pfcid)
        {
                $q = "INSERT INTO #__feeparticulars(name,description,amount,fcid) VALUES('".$pname."','".$pdescription."','".$pamount."',".$pfcid.")";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

        function updateFeeParticular($pid,$pname,$pdescription,$pamount)
        {
                $q = "UPDATE #__feeparticulars SET name='".$pname."', description='".$pdescription."', amount='".$pamount."' WHERE id=".$pid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }


        function deleteFeeParticular($pid)
        {
                $q = 'DELETE FROM #__feeparticulars WHERE id IN ('.$pid.')';
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

	function getFeeParticulars($pfcid)
        {
                $db =& JFactory::getDBO();
                $query = "SELECT id,name,description, amount  FROM #__feeparticulars WHERE fcid=".$pfcid;
                $db->setQuery( $query );
                $res= $db->loadObjectList();
                return $res;
        }


//Fee Courses

	function assignFeeCourse($fcid,$cid){
                $q = "INSERT INTO #__coursefeecategory(fcid,cid) VALUES(".$fcid.",".$cid.")";
        	$db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
	}

	function getFeeCategoryCourses($fcid){
		$db =& JFactory::getDBO();
		$query = "SELECT id,coursename,sectionname,code,assessmenttype, filename FROM #__courses WHERE id IN ( SELECT cid  FROM #__coursefeecategory WHERE fcid =".$fcid.")";
		$db->setQuery( $query );
		$res= $db->loadObjectList();
		return $res;
	}


	function getCourseFeeCategories($cid){
                $db =& JFactory::getDBO();
                $query = "SELECT id,name,description FROM #__feecategory WHERE id IN (SELECT fcid FROM #__coursefeecategory WHERE cid = ".$cid.")";
                $db->setQuery( $query );
                $res= $db->loadObjectList();
                return $res;
        }


        function deleteFeeCourse($fcid,$cid)
        {
                $q = 'DELETE FROM #__coursefeecategory WHERE fcid='.$fcid.' AND cid='.$cid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

//Fee Discounts
	function getFeeCategoryDiscounts($fcid){
                $db =& JFactory::getDBO();
                $query = "SELECT id,scid,cid,discount FROM #__feediscounts WHERE fcid =".$fcid; 
                $db->setQuery( $query );
                $res= $db->loadObjectList();
                return $res;
	}

        function addFeeDiscount($fcid,$scid,$cid,$discount)
        {
                $q = "INSERT INTO #__feediscounts(fcid,scid,cid,discount) VALUES(".$fcid.",".$scid.",".$cid.",".$discount.")";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

        function updateFeeDiscount($id,$discount)
        {
                $q = "UPDATE #__feediscounts SET discount=".$discount." WHERE id=".$id;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

        function deleteFeeDiscount($id)
        {
                $q = 'DELETE FROM #__feediscounts WHERE id='.$id;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }



}

