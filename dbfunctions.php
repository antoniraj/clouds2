<?php
 	function getCourse($pid,&$rec)
        {
                $q = 'SELECT id,coursename,sectionname,code,aid,assessmenttype FROM #__courses WHERE id ='.$pid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
        }
 
	function getCourses(&$recs)
        {
                $q = "SELECT id,coursename,sectionname,code,aid,assessmenttype FROM #__courses WHERE aid = (SELECT id FROM #__academicyears WHERE status='Y')";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $recs = $db->loadObjectList();
                if($recs==null)
                        return false;
                return true;
        }

	function getDates(&$recs)
        {
                $q = "SELECT cdate FROM #__schoolcal WHERE (daytype='WD' OR daytype='HAD') AND (cdate <= current_date) AND (cdate >= (SELECT startdate FROM #__academicyears WHERE status='Y'))";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $recs = $db->loadObjectList();
                if($recs==null)
                        return false;
                return true;
        }
	
	function getClassWeeklyAbsentees($classid,$from,$to,&$rec)
        {
		$q="SELECT classid, count(distinct studentid) AS total FROM #__classattendance where cdate BETWEEN '".$from."' and '".$to."' AND classid=".$classid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
	}
?>
