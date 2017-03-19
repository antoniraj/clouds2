<?php

include_once('normalgrades.php');
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.model' );
 
class CceModelNGradeBook extends CceModelNormalGrades
{

	function __construct(){
        	parent::__construct();
        }

	function getNGradeBookEntry($pid,&$rec) {
                $q = 'SELECT `id`,`title`,`code`,`marks`,`duedate`,`description` FROM #__ngradebook WHERE id ='.$pid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null) return false;
                return true;
        }

       function addNGradeBookEntry($ptitle,$pcode,$pmarks,$pduedate,$pdescription,$pcid,$psid) {
		///$a = explode('-',$pduedate);
		//$iduedate="$a[2]-$a[1]-$a[0]";
                $q = "INSERT INTO #__ngradebook(`title`,`code`,`marks`,`duedate`,`description`,`courseid`,`subjectid`) VALUES('".$ptitle."','".$pcode."','".$pmarks ."','".$pduedate."','".$pdescription."',".$pcid.",".$psid.")";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

        function updateNGradeBookEntry($id,$ptitle,$pcode,$pmarks,$pduedate,$pdescription)
        {
		$a = explode('-',$pduedate);
		$iduedate="$a[2]-$a[1]-$a[0]";
                $q = "UPDATE #__ngradebook SET `title`='".$ptitle."', `code`='".$pcode."', `marks`='".$pmarks."', `duedate`='".$iduedate."', `description`='".$pdescription."' WHERE `id`=".$id;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }


        function deleteNGradeBookEntry($pid)
        {
                $q = 'DELETE FROM #__ngradebook WHERE `id` IN ('.$pid.')';
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }


        function getNGradeBooks($pcid,$psid)
        {
                $query = "SELECT `id`,`title`,`code`,`marks`,`duedate`,`description` FROM #__ngradebook WHERE `courseid`=".$pcid." AND `subjectid`=".$psid;
                $db = & JFactory::getDBO();
                $db->setQuery( $query );
                $recs= $db->loadObjectList();
                return $recs;
        }
}
