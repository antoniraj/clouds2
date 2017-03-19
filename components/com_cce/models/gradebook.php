<?php

include_once('fagrades.php');
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.model' );
 
class CceModelGradeBook extends CceModelFAGrades
{

	function __construct(){
        	parent::__construct();
        }

	function getGradeBookEntry($pid,&$rec)
        {
                $q = 'SELECT `id`,`title`,`code`,`weightage`,`bestof`,`description`, `subjectid`, `courseid`,`termid`,`grouptag`,`gsno` FROM #__scholasticacategories WHERE id ='.$pid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
        }


       function addGradeBookEntry($ptitle,$pcode,$pweightage,$pbestof,$pdescription,$psubjectid,$pcourseid,$ptermid,$pgrouptag,$pgsno)
       {
		if($pbestof=='All') $pbestof=0;
                $q = "INSERT INTO #__scholasticacategories(`title`,`code`,`weightage`,`bestof`,`description`,`subjectid`,`courseid`,`termid`,`grouptag`,`gsno`) VALUES('".$ptitle."','".$pcode."','".$pweightage."',".$pbestof.",'".$pdescription."',".$psubjectid.",".$pcourseid.",".$ptermid.",'".$pgrouptag."',".$pgsno.")";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

	function getCategoryId($code,$sid,$cid,$termid,&$catid)
	{
                $q = "SELECT `id`FROM #__scholasticacategories WHERE subjectid =".$sid." AND `code`='".$code."' AND `courseid` = ".$cid." AND `termid`=".$termid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
		$catid=$rec->id;
                if($rec==null)
                        return false;
                return true;
	}

        function updateGradeBookEntry($id,$ptitle,$pcode,$pweightage,$pbestof,$pdescription,$pgrouptag,$pgsno)
        {
                $q = "UPDATE #__scholasticacategories SET `title`='".$ptitle."', `code`='".$pcode."', `weightage`='".$pweightage."', `bestof`='".$pbestof."', `description`='".$pdescription."', `grouptag`='".$pgrouptag."', `gsno`=".$pgsno." WHERE `id`=".$id;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }


        function deleteGradeBookEntry($pids)
        {
                $ids = implode(',',$pids);
                $q = 'DELETE FROM #__scholasticacategories WHERE `id` IN ('.$ids.')';
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }


        function getGradeBook($sid,$cid,$termid)
        {
                $query = "SELECT `id`,`title`,`code`,`weightage`,`bestof`,`description`,`subjectid`,`courseid`, `termid`, `grouptag`, `gsno` FROM #__scholasticacategories WHERE subjectid='".$sid."' AND `courseid`=".$cid." AND `termid`=".$termid." ORDER BY `grouptag`,`gsno`";            
                $db = & JFactory::getDBO();
                $db->setQuery( $query );
                $activities = $db->loadObjectList();
                return $activities;
        }


//GRADE BOOK ENTRY
	function getGradeBookDetailEntry($pid,&$rec) {
                $q = 'SELECT `id`,`title`,`code`,`marks`,`duedate`,`description` FROM #__scholasticacategorydetails WHERE id ='.$pid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null) return false;
                return true;
        }

       function addGradeBookDetailEntry($ptitle,$pcode,$pmarks,$pduedate,$pdescription,$pcatid) {
		$a = explode('-',$pduedate);
		$iduedate="$a[2]-$a[1]-$a[0]";
                $q = "INSERT INTO #__scholasticacategorydetails(`title`,`code`,`marks`,`duedate`,`description`,`categoryid`) VALUES('".$ptitle."','".$pcode."','".$pmarks ."','".$iduedate."','".$pdescription."',".$pcatid.")";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

        function updateGradeBookDetailEntry($id,$ptitle,$pcode,$pmarks,$pduedate,$pdescription)
        {
		$a = explode('-',$pduedate);
		$iduedate="$a[2]-$a[1]-$a[0]";
                $q = "UPDATE #__scholasticacategorydetails SET `title`='".$ptitle."', `code`='".$pcode."', `marks`='".$pmarks."', `duedate`='".$iduedate."', `description`='".$pdescription."' WHERE `id`=".$id;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }


        function deleteGradeBookDetailEntry($pid)
        {
                $q = 'DELETE FROM #__scholasticacategorydetails WHERE `id` IN ('.$pid.')';
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }


        function getGradeBookDetails($pcategoryid)
        {
                $query = "SELECT `id`,`title`,`code`,`marks`,`duedate`,`description` FROM #__scholasticacategorydetails WHERE categoryid=".$pcategoryid;
                $db = & JFactory::getDBO();
                $db->setQuery( $query );
                $recs= $db->loadObjectList();
                return $recs;
        }
}
