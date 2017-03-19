<?php
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.model' );
 
class CceModelTNGradeBook extends JModel
{

	function __construct(){
        	parent::__construct();
        }

	function getTNGradeBookEntry($pid,&$rec)
        {
                $q = 'SELECT `id`,`title`,`code`,`marks`,`duedate`,`description`,`instructions` FROM #__tngradebook WHERE id ='.$pid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
        }


       function addTNGradeBookEntry($ptitle,$pcode,$pmarks,$pduedate,$pdescription,$pinstructions)
       {
                $q = "INSERT INTO #__tngradebook(`title`,`code`,`marks`,`duedate`,`description`,`instructions`,`aid`) VALUES('".mysql_escape_string($ptitle)."','".mysql_escape_string($pcode)."','".$pmarks ."','".$pduedate."','".mysql_escape_string($pdescription)."','".mysql_escape_string($pinstructions)."',(SELECT id FROM #__academicyears where status='Y'))";

                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

        function updateTNGradeBookEntry($id,$ptitle,$pcode,$pmarks,$pduedate,$pdescription,$pinstructions)
        {
		$a = explode('-',$pduedate);
		$iduedate="$a[2]-$a[1]-$a[0]";
                $q = "UPDATE #__tngradebook SET `title`='".mysql_escape_string($ptitle)."', `code`='".mysql_escape_string($pcode)."', `marks`='".$pmarks."', `duedate`='".$iduedate."', `description`='".mysql_escape_string($pdescription)."', `instructions`='".mysql_escape_string($pinstructions)."' WHERE `id`=".$id;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }


        function deleteTNGradeBookEntry($pids)
        {
                $ids = implode(',',$pids);
                $q = 'DELETE FROM #__tngradebook WHERE `id` IN ('.$ids.')';
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }


        function getTNGradeBook()
        {
                $query = "SELECT `id`,`title`,`code`,`marks`,`duedate`,`description` FROM #__tngradebook where aid IN (SELECT id FROM #__academicyears where status='Y')";
                $db = & JFactory::getDBO();
                $db->setQuery( $query );
                $recs= $db->loadObjectList();
                return $recs;
        }
}
