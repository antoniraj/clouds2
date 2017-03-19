<?php

include_once('ngradebook.php');
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.model' );
 
class CceModelNMarks extends CceModelNGradeBook
{

	function __construct(){
        	parent::__construct();
        }

       function addNMarks($pmarks,$pcomments,$pstudentid,$pexamid,$psubjectid,$pcourseid)
       {
		if (preg_match('/[a-z]/i', $pmarks)) $pmarks=-1;
                $q = "INSERT INTO #__nmarks(`marks`,`comments`,`studentid`,`examid`,`subjectid`,`courseid`) VALUES(".$pmarks.",'".$pcomments."','".$pstudentid."',".$pexamid.",".$psubjectid.",".$pcourseid.")";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

        function updateNMarks($pid,$pmarks,$pcomments)
        {
		if (preg_match('/[a-z]/i', $pmarks)) $pmarks=-1;
                $q = "UPDATE #__nmarks SET `marks`=".$pmarks.", `comments`='".$pcomments."'  WHERE `id`=".$pid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

        function getNMarks($sid,$examid,$subjectid,$courseid,&$rec)
        {
                $q = 'SELECT `id`,`marks`,`comments` FROM #__nmarks WHERE studentid ='.$sid.' AND examid='.$examid.' AND subjectid='.$subjectid.' AND courseid='. $courseid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                if($rec->marks==-1) $rec->marks='A';
                return true;
        }


}


