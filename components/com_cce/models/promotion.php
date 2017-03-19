<?php
// No direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
include_once('cce.php');
 
jimport( 'joomla.application.component.model' );
class CceModelPromotion extends CceModelCce
{
	function __construct(){
        	parent::__construct();
        }

	function getPromotion($pcid,&$recs) {
                $q = "SELECT sid,status,newcid FROM #__promotion WHERE cid ='".$pcid."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $recs = $db->loadObjectList();
                if($recs==null)
                        return false;
                return true;
        }

	function getPromotionByStudent($pcid,$psid,&$rec) {
                $q = "SELECT status,newcid FROM #__promotion WHERE sid = '".$psid."' AND cid ='".$pcid."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
        }

	function getPromotedCount($pcid,&$count) {
                $q = "SELECT count(*) AS promoted FROM #__promotion WHERE status = '1' AND cid ='".$pcid."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
		$count=$rec->promoted;
                if($rec==null)
                        return false;
                return true;
        }

	function getNotPromotedCount($pcid,&$count) {
                $q = "SELECT count(*) AS npromoted FROM #__promotion WHERE status = '0' AND cid ='".$pcid."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
		$count=$rec->npromoted;
                if($rec==null)
                        return false;
                return true;
        }

        function addPromotion($cid,$sid,$status,$newcid) {
                $q = "INSERT INTO #__promotion(cid,sid,status,newcid) VALUES('".$cid."','".$sid."','".$status."','".$newcid."')";
        	$db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }



        function addPromotionStatus($cid,$status) {
                $q = "INSERT INTO #__promotionstatus(cid,status) VALUES('".$cid."','".$status."')";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }


        function deletePromotionStatus($pcid) {
                $q = 'DELETE FROM #__promotionstatus WHERE cid = '.$pcid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }


        function deletePromotion($pcid) {
                $q = 'DELETE FROM #__promotion WHERE cid = '.$pcid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

	function getPromotionStatus($pcid,&$status) {
		$db =& JFactory::getDBO();
		$query = "SELECT status FROM #__promotionstatus WHERE cid='".$pcid."'";
		$db->setQuery( $query );
		$rec= $db->loadObject();
		$status = $rec->status;
                if($rec==null)
                        return false;
                return true;
    	}



}
