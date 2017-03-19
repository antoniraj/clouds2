<?php
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.model' );
 
class CceModelTGradeBook extends JModel
{

	function __construct(){
        	parent::__construct();
        }

	function getTGradeBookEntry($pid,&$rec)
        {
                $q = 'SELECT `id`,`title`,`code`,`weightage`,`bestof`,`description`,`grouptag`,`gsno` FROM #__tgradebook WHERE id ='.$pid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
        }


       function addTGradeBookEntry($ptitle,$pcode,$pweightage,$pbestof,$pdescription,$pgrouptag,$pgsno)
       {
                $q = "INSERT INTO #__tgradebook(`title`,`code`,`weightage`,`bestof`,`description`,`grouptag`,`gsno`) VALUES('".$ptitle."','".$pcode."','".$pweightage."','".$pbestof."','".$pdescription."','".$pgrouptag."',".$pgsno.")";

                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

        function updateTGradeBookEntry($id,$ptitle,$pcode,$pweightage,$pbestof,$pdescription,$pgrouptag,$pgsno)
        {
                $q = "UPDATE #__tgradebook SET `title`='".$ptitle."', `code`='".$pcode."', `weightage`='".$pweightage."', `bestof`='".$pbestof."', `description`='".$pdescription."',`grouptag`='".$pgrouptag."',`gsno`=".$pgsno." WHERE `id`=".$id;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }


        function deleteTGradeBookEntry($pids)
        {
                $ids = implode(',',$pids);
                $q = 'DELETE FROM #__tgradebook WHERE `id` IN ('.$ids.')';
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }


        function getTGradeBook()
        {
                $query = "SELECT `id`,`title`,`code`,`weightage`,`bestof`,`description`,`grouptag`,`gsno` FROM #__tgradebook ORDER BY `grouptag`,`gsno`" ;
                $db = & JFactory::getDBO();
                $db->setQuery( $query );
                $activities = $db->loadObjectList();
                return $activities;
        }


//GRADE BOOK ENTRY
	function getTGradeBookDetailEntry($pid,&$rec)
        {
                $q = 'SELECT `id`,`title`,`code`,`marks`,`duedate`,`description` FROM #__tgradebookentries WHERE id ='.$pid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
        }


       function addTGradeBookDetailEntry($ptitle,$pcode,$pmarks,$pduedate,$pdescription,$pcatid)
       {

                $q = "INSERT INTO #__tgradebookentries(`title`,`code`,`marks`,`duedate`,`description`,`categoryid`) VALUES('".$ptitle."','".$pcode."','".$pmarks ."','".$pduedate."','".$pdescription."',".$pcatid.")";

                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

        function updateTGradeBookDetailEntry($id,$ptitle,$pcode,$pmarks,$pduedate,$pdescription)
        {
                $q = "UPDATE #__tgradebookentries SET `title`='".$ptitle."', `code`='".$pcode."', `marks`='".$pmarks."', `duedate`='".$pduedate."', `description`='".$pdescription."' WHERE `id`=".$id;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }


        function deleteTGradeBookDetailEntry($pid)
        {
                $q = 'DELETE FROM #__tgradebookentries WHERE `id` IN ('.$pid.')';
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }


        function getTGradeBookDetails($pcategoryid)
        {
                $query = "SELECT `id`,`title`,`code`,`marks`,`duedate`,`description` FROM #__tgradebookentries WHERE categoryid=".$pcategoryid;
                $db = & JFactory::getDBO();
                $db->setQuery( $query );
                $recs= $db->loadObjectList();
                return $recs;
        }
}
