<?php

include_once('gradebook.php');
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.model' );
 
class CceModelMarks extends CceModelGradeBook
{

	function __construct(){
        	parent::__construct();
        }

	function getScholasticAMarksByCategory($psid,$pgid,$plimit,&$marks)
        {
                $q = 'SELECT `sacdid`, `marks`,(select marks FROM #__scholasticacategorydetails WHERE id=`sacdid`) as `max` FROM #__scholasticamarks WHERE studentid ='.$psid.' AND `marks` > -1 AND sacdid IN (select id FROM #__scholasticacategorydetails WHERE categoryid='.$pgid.') ORDER BY `marks`/`max`*5 DESC LIMIT '.$plimit;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $marks = $db->loadAssocList();
                if($marks==null)
                        return false;
                return true;
        }


	function getScholasticAMarks($psid,$psacdid,&$rec)
        {
                $q = 'SELECT `id`,`description`,`marks`,`comments`,`studentid`, `sacdid` FROM #__scholasticamarks WHERE studentid ='.$psid.' AND sacdid='.$psacdid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
		if($rec->marks==-1) $rec->marks='A';
                return true;
        }


       function addScholasticAMarks($pdescription,$pmarks,$pcomments,$pstudentid,$psacdid)
       {
		if (preg_match('/[a-z]/i', $pmarks)) $pmarks=-1;
                $q = "INSERT INTO #__scholasticamarks(`description`,`marks`,`comments`,`studentid`,`sacdid`) VALUES('".$pdescription."',".$pmarks.",'".$pcomments."','".$pstudentid."',".$psacdid.")";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

        function updateScholasticAMarks($pid,$pdescription,$pmarks,$pcomments)
        {
		if (preg_match('/[a-z]/i', $pmarks)) $pmarks=-1;
                $q = "UPDATE #__scholasticamarks SET `description`='".$pdescription."', `marks`=".$pmarks.", `comments`='".$pcomments."'  WHERE `id`=".$pid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

}


