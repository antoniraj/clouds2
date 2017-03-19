<?php

include_once('cce.php');
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.model' );
 
class CceModelCoSMarks extends CceModelCce
{

	function __construct(){
        	parent::__construct();
        }

	function getLSCoSMarks($psid,$paid,$pcid,$ptid,&$data)
        {
                $q = 'SELECT `id`, `marks`,`indicators` FROM #__lsmarks WHERE studentid ='.$psid.' AND activityid ='.$paid.' AND classid='.$pcid.' AND termid='.$ptid ;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $data = $db->loadAssocList();
                if($data==null)
                        return false;
                return true;
        }


       function addLSCoSMarks($psid,$paid,$pcid,$ptid,$pmarks,$pindicators)
       {
		if (preg_match('/[a-z]/i', $pmarks)) $pmarks=-1;
                $q = "INSERT INTO #__lsmarks(`studentid`,`activityid`,`classid`,`termid`,`marks`,`indicators`) VALUES('".$psid."','".$paid."','".$pcid."','".$ptid."','".$pmarks."','".$pindicators."')";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

        function updateLSCoSMarks($psid,$paid,$pcid,$ptid,$pmarks,$pindicators)
        {
		if (preg_match('/[a-z]/i', $pmarks)) $pmarks=-1;
                $q = "UPDATE #__lsmarks SET `indicators`='".$pindicators."', `marks`='".$pmarks."' WHERE studentid =".$psid." AND activityid =".$paid." AND classid=".$pcid." AND termid=".$ptid ;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }


        function updateLSCoSMarksid($pid,$pmarks,$pindicators)
        {
                if (preg_match('/[a-z]/i', $pmarks)) $pmarks=-1;
                $q = "UPDATE #__lsmarks SET `indicators`='".$pindicators."', `marks`='".$pmarks."' WHERE `id` =".$pid ;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

	function getAVCoSMarks($psid,$paid,$pcid,$ptid,&$data)
        {
                $q = 'SELECT `id`, `marks`,`indicators` FROM #__avmarks WHERE studentid ='.$psid.' AND activityid ='.$paid.' AND classid='.$pcid.' AND termid='.$ptid ;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $data = $db->loadAssocList();
                if($data==null)
                        return false;
                return true;
        }


       function addAVCoSMarks($psid,$paid,$pcid,$ptid,$pmarks,$pindicators)
       {
		if (preg_match('/[a-z]/i', $pmarks)) $pmarks=-1;
                $q = "INSERT INTO #__avmarks(`studentid`,`activityid`,`classid`,`termid`,`marks`,`indicators`) VALUES('".$psid."','".$paid."','".$pcid."','".$ptid."','".$pmarks."','".$pindicators."')";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

        function updateAVCoSMarks($psid,$paid,$pcid,$ptid,$pmarks,$pindicators)
        {
		if (preg_match('/[a-z]/i', $pmarks)) $pmarks=-1;
                $q = "UPDATE #__avmarks SET `indicators`='".$pindicators."', `marks`='".$pmarks."' WHERE studentid =".$psid." AND activityid =".$paid." AND classid=".$pcid." AND termid=".$ptid ;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }


        function updateAVCoSMarksid($pid,$pmarks,$pindicators)
        {
                if (preg_match('/[a-z]/i', $pmarks)) $pmarks=-1;
                $q = "UPDATE #__avmarks SET `indicators`='".$pindicators."', `marks`='".$pmarks."' WHERE `id` =".$pid ;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }


	function getCoSAMarks($psid,$paid,$pcid,$ptid,&$data)
        {
                $q = 'SELECT `id`, `marks`,`indicators` FROM #__cosamarks WHERE studentid ='.$psid.' AND activityid ='.$paid.' AND classid='.$pcid.' AND termid='.$ptid ;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $data = $db->loadAssocList();
                if($data==null)
                        return false;
                return true;
        }


       function addCoSAMarks($psid,$paid,$pcid,$ptid,$pmarks,$pindicators)
       {
		if (preg_match('/[a-z]/i', $pmarks)) $pmarks=-1;
                $q = "INSERT INTO #__cosamarks(`studentid`,`activityid`,`classid`,`termid`,`marks`,`indicators`) VALUES('".$psid."','".$paid."','".$pcid."','".$ptid."','".$pmarks."','".$pindicators."')";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

        function updateCoSAMarks($psid,$paid,$pcid,$ptid,$pmarks,$pindicators)
        {
		if (preg_match('/[a-z]/i', $pmarks)) $pmarks=-1;
                $q = "UPDATE #__cosamarks SET `indicators`='".$pindicators."', `marks`='".$pmarks."' WHERE studentid =".$psid." AND activityid =".$paid." AND classid=".$pcid." AND termid=".$ptid ;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }


        function updateCoSAMarksid($pid,$pmarks,$pindicators)
        {
                if (preg_match('/[a-z]/i', $pmarks)) $pmarks=-1;
                $q = "UPDATE #__cosamarks SET `indicators`='".$pindicators."', `marks`='".$pmarks."' WHERE `id` =".$pid ;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }


	function getCoSBMarks($psid,$paid,$pcid,$ptid,&$data)
        {
                $q = 'SELECT `id`, `marks`,`indicators` FROM #__cosbmarks WHERE studentid ='.$psid.' AND activityid ='.$paid.' AND classid='.$pcid.' AND termid='.$ptid ;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $data = $db->loadAssocList();
                if($data==null)
                        return false;
                return true;
        }


       function addCoSBMarks($psid,$paid,$pcid,$ptid,$pmarks,$pindicators)
       {
		if (preg_match('/[a-z]/i', $pmarks)) $pmarks=-1;
                $q = "INSERT INTO #__cosbmarks(`studentid`,`activityid`,`classid`,`termid`,`marks`,`indicators`) VALUES('".$psid."','".$paid."','".$pcid."','".$ptid."','".$pmarks."','".$pindicators."')";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

        function updateCoSBMarks($psid,$paid,$pcid,$ptid,$pmarks,$pindicators)
        {
		if (preg_match('/[a-z]/i', $pmarks)) $pmarks=-1;
                $q = "UPDATE #__cosbmarks SET `indicators`='".$pindicators."', `marks`='".$pmarks."' WHERE studentid =".$psid." AND activityid =".$paid." AND classid=".$pcid." AND termid=".$ptid ;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }


        function updateCoSBMarksid($pid,$pmarks,$pindicators)
        {
                if (preg_match('/[a-z]/i', $pmarks)) $pmarks=-1;
                $q = "UPDATE #__cosbmarks SET `indicators`='".$pindicators."', `marks`='".$pmarks."' WHERE `id` =".$pid ;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }


}




