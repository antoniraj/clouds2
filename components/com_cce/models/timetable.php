<?php
// No direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
include_once('cce.php');
 
jimport( 'joomla.application.component.model' );
class CceModelTimeTable extends CceModelCce
{
	function __construct(){
        	parent::__construct();
        }

//Time Table Terms

        function getTimeTableTerm($pid,&$rec) {
                $q = 'SELECT id,term,code,months,startdate,stopdate,aid FROM #__timetableterms WHERE id ='.$pid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
        }


        function getCurrentTimeTableTerms()
        {
                $db =& JFactory::getDBO();
                $query = "SELECT id,term,months,code,startdate,stopdate FROM #__timetableterms WHERE aid IN (SELECT id FROM #__academicyears WHERE status='Y')";
                $db->setQuery( $query );
                $terms = $db->loadObjectList();
                return $terms;
        }


       function addTimeTableTerm($pterm,$pcode,$pmonths,$pstartdate,$pstopdate,$paid)
       {
     
                $q = "INSERT INTO #__timetableterms(term,code,months,startdate,stopdate,aid) VALUES('".$pterm."','".$pcode."','".$pmonths."','".$pstartdate."','".$pstopdate."','".$paid."')";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

        function updateTimeTableTerm($id,$pterm,$pcode,$pmonths,$pstartdate,$pstopdate)
        {

                $q = "UPDATE #__timetableterms SET term='".$pterm."', code='".$pcode."', months='".$pmonths."', startdate='".$pstartdate."',stopdate='".$pstopdate."'  WHERE id=".$id;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

        function deleteTimeTableTerm($pids)
        {
                $ids = implode(',',$pids);
                $q = 'DELETE FROM #__timetableterms WHERE id IN ('.$ids.')';
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }




//Session Categories
	function getSessionCategory($pid,&$rec)
        {
                $q = "SELECT id,description FROM #__sessiontypes WHERE id ='".$pid."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
        }

	function getSessionCategoriesByDate($pdate,&$recs)
        {
		list($d,$m,$y) = explode('-',$pdate);
		$pidate=$y.'-'.$m.'-'.$d;
                $q = "SELECT DISTINCT sid FROM #__coursesessions where termid IN (SELECT id FROM #__timetableterms where startdate <='".$pidate."' AND stopdate >= '".$pidate."')";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $recs = $db->loadObjectList();
                if($rec==null)
                        return false;
                return true;
        }


        function getSessionCategoriesByStaff($pstaffid,$ptermid,&$recs)
        {
		$q = "SELECT DISTINCT sid FROM #__coursesessions WHERE cid IN (SELECT courseid FROM #__subjectteachers where staffid=".$pstaffid.") AND termid=".$ptermid;

                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $recs = $db->loadObjectList();
                if($rec==null)
                        return false;
                return true;
        }


        function addSessionCategory($pdescription)
        {
                $q = "INSERT INTO #__sessiontypes(description,aid) VALUES('".$pdescription."',(SELECT id FROM #__academicyears WHERE status='Y'))";
        	$db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

        function updateSessionCategory($pid,$pdescription)
        {
                $q = "UPDATE #__sessiontypes SET description='".$pdescription."' WHERE id=".$pid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

        function deleteSessionCategory($pid)
        {
                $q = 'DELETE FROM #__sessiontypes WHERE id IN ('.$pid.')';
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

	function getSessionCategories()
    	{
		$db =& JFactory::getDBO();
		$query = "SELECT id,description FROM #__sessiontypes WHERE aid = (SELECT id FROM #__academicyears WHERE status='Y')";
		$db->setQuery( $query );
		$res= $db->loadObjectList();
		return $res;
    	}




//Session Timings
        function getSession($pstid,&$rec)
        {
                $q = "SELECT id,title,code,start,stop,break FROM #__sessiontimings WHERE id ='".$pstid."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
        }


       function getSessionByCode($pscode,&$rec)
        {
                $q = "SELECT id,title,code,TIME_FORMAT(start,'%H:%i') as start,TIME_FORMAT(stop,'%H:%i') as stop FROM #__sessiontimings WHERE code ='".$pscode."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
        }

	function addSession($ptitle,$pcode,$pstart,$pstop,$pbreak)
        {
                $q = "INSERT INTO #__sessiontimings(title,code,start,stop,break) VALUES('".$ptitle."','".$pcode."','".$pstart."','".$pstop."','".$pbreak."')";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

        function updateSession($pid,$ptitle,$pcode,$pstart,$pstop,$pbreak)
        {
                $q = "UPDATE #__sessiontimings SET title='".$ptitle."', code='".$pcode."', start='".$pstart."', stop='".$pstop."', break='".$pbreak."'  WHERE id=".$pid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }


        function deleteSession($pid)
        {
                $q = 'DELETE FROM #__sessiontimings WHERE id IN ('.$pid.')';
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

	function getSessions()
        {
                $db =& JFactory::getDBO();
               $query = "SELECT id,title,code,start,stop,break  FROM #__sessiontimings";
                $db->setQuery( $query );
                $res= $db->loadObjectList();
                return $res;
        }


//Session Courses

	function assignSessionCourse($scid,$cid,$termid){
                $q = "INSERT INTO #__coursesessions(sid,cid,termid) VALUES(".$scid.",".$cid.",".$termid.")";
        	$db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
	}

	function getSessionCourses($scid){
		$db =& JFactory::getDBO();
		$query = "SELECT id,sid,cid,termid FROM #__coursesessions WHERE sid =".$scid;
		$db->setQuery( $query );
		$res= $db->loadObjectList();
		return $res;
	}


	function getCourseSessions($cid,$termid){
                $db =& JFactory::getDBO();
                $query = "SELECT id,title,code,TIME_FORMAT(start,'%H:%i%p') as start,TIME_FORMAT(stop,'%H:%i%p') as stop  FROM #__sessiontimings WHERE sid IN (SELECT sid FROM #__coursesessions WHERE termid=".$termid." AND cid = ".$cid.")";
                $db->setQuery( $query );
                $res= $db->loadObjectList();
                return $res;
        }


        function deleteSessionCourse($scid,$cid,$termid)
        {
                $q = 'DELETE FROM #__coursesessions WHERE sid='.$scid.' AND cid='.$cid.' AND termid='.$termid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

	function getCourseidsByDate($pdate,$scid){
		list($d,$m,$y) = explode('-',$pdate);
		$pidate=$y.'-'.$m.'-'.$d;
                $db =& JFactory::getDBO();
		$query = "SELECT DISTINCT cid FROM #__coursesessions where sid=".$scid." and termid IN (SELECT id FROM #__timetableterms where startdate <='".$pidate."' AND stopdate >= '".$pidate."')";
                $db->setQuery( $query );
                $res= $db->loadObjectList();
                return $res;
        }



//Day Order Categories
	function getDayCategory($pid,&$rec)
        {
                $q = "SELECT id,description FROM #__daycategory WHERE id ='".$pid."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
        }


        function addDayCategory($pdescription)
        {
                $q = "INSERT INTO #__daycategory(description,aid) VALUES('".$pdescription."',(SELECT id FROM #__academicyears WHERE status='Y'))";
        	$db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

        function updateDayCategory($pid,$pdescription)
        {
                $q = "UPDATE #__daycategory SET description='".$pdescription."' WHERE id=".$pid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

        function deleteDayCategory($pid)
        {
                $q = 'DELETE FROM #__daycategory WHERE id IN ('.$pid.')';
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

	function getDayCategories()
    	{
		$db =& JFactory::getDBO();
		$query = "SELECT id,description FROM #__daycategory WHERE aid = (SELECT id FROM #__academicyears WHERE status='Y')";
		$db->setQuery( $query );
		$res= $db->loadObjectList();
		return $res;
    	}




//Days
        function getDay($pddid,&$rec)
        {
                $q = "SELECT id,title,code,active FROM #__days WHERE id ='".$pddid."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
        }

        function getDayByDate($pdate,&$rec)
        {
		list($day,$month,$year) = explode("-",$pdate);
		$pidate=$year."-".$month."-".$day;	
                $q = "SELECT id,title,code,active FROM #__days where id IN (SELECT dayorder FROM #__schoolcal WHERE cdate ='".$pidate."')";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
        }



	function addDay($ptitle,$pcode,$pactive)
        {
                $q = "INSERT INTO #__days(title,code,active) VALUES('".$ptitle."','".$pcode."','".$pactive."')";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

        function updateDay($pid,$ptitle,$pcode,$pactive)
        {
                $q = "UPDATE #__days SET title='".$ptitle."', code='".$pcode."', active='".$pactive."' WHERE id=".$pid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }


        function deleteDay($pid)
        {
                $q = 'DELETE FROM #__days WHERE id IN ('.$pid.')';
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

	function getDaysByStaff($pstaffid,$ptermid,&$recs)
        {
                $q = "SELECT DISTINCT dcid FROM #__daycourses WHERE cid IN (SELECT courseid FROM #__subjectteachers where staffid=".$pstaffid.") AND termid=".$ptermid .' LIMIT 1';
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $recs = $db->loadObjectList();
                if($rec==null)
                        return false;
                return true;
        }

	function getDays()
        {
                $db =& JFactory::getDBO();
                $query = "SELECT id,title,code,active FROM #__days";
                $db->setQuery( $query );
                $res= $db->loadObjectList();
                return $res;
        }

	function getAllDays()
        {
                $db =& JFactory::getDBO();
                $query = "SELECT id,title,code,active FROM #__days";
                $db->setQuery( $query );
                $res= $db->loadObjectList();
                return $res;
        }

//Day ORder Courses

	function assignDayCourse($sdid,$cid,$termid){
                $q = "INSERT INTO #__daycourses(dcid,cid,termid) VALUES(".$sdid.",".$cid.",".$termid.")";
        	$db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
	}

	function getDayCourses($sdid){
		$db =& JFactory::getDBO();
		$query = 'SELECT id,dcid,cid,termid FROM #__daycourses WHERE dcid ='.$sdid;
		$db->setQuery( $query );
		$res= $db->loadObjectList();
		return $res;
	}

        function deleteDayCourse($sdid,$cid,$termid)
        {
                $q = 'DELETE FROM #__daycourses WHERE termid='.$termid.' AND dcid='.$sdid.' AND cid='.$cid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }
	
	function getCourseDays($cid){
                $db =& JFactory::getDBO();
                $query = "SELECT id,title,code,active FROM #__days WHERE dcid IN (SELECT dcid FROM #__daycourses WHERE cid =".$cid.")";
                $db->setQuery( $query );
                $res= $db->loadObjectList();
                return $res;
        }


        function getSessions1(&$recs){
                $db =& JFactory::getDBO();
                $query = "SELECT id,code FROM #__sessiontimings ORDER BY code ";
                $db->setQuery( $query );
                $recs= $db->loadObjectList();
                return true;
        }


        function getBreakSessions(&$recs){
                $db =& JFactory::getDBO();
                $query = "SELECT id,code FROM #__sessiontimings WHERE break='1' ORDER BY code ";
                $db->setQuery( $query );
                $recs= $db->loadObjectList();
                return true;
        }

	
	function getDays1(&$recs){
                $db =& JFactory::getDBO();
                $query = "SELECT id,code FROM #__days";
                $db->setQuery( $query );
                $recs= $db->loadObjectList();
                return true;
        }


	function getStaffByDepartment($did,&$recs){
                $db =& JFactory::getDBO();
                $query = "SELECT * FROM #__staffs WHERE id IN (SELECT DISTINCT staffid FROM #__subjectteachers WHERE courseid IN (SELECT courseid FROM #__departmentcourses where departmentid = '".$did."'))";
                $db->setQuery( $query );
                $recs= $db->loadObjectList();
                return true;
	}

//Time Table

        function addTimeTableEntry($termid,$courseid,$dayid,$sessionid,$subjectid,$staffid){
                $q = "INSERT INTO #__timetable(termid,courseid,dayid,sessionid,subjectid,staffid) VALUES(".$termid.",".$courseid.",".$dayid.",".$sessionid.",".$subjectid.",".$staffid.")";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

	function deleteTTEntry($termid,$courseid,$dayid,$sessionid,$subjectid)
        {
                $q = 'DELETE FROM #__timetable WHERE termid='.$termid.' AND courseid='.$courseid.' AND dayid='.$dayid.' AND sessionid='.$sessionid.' AND subjectid='.$subjectid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }


	function deleteTTStaffEntry($termid,$courseid,$dayid,$sessionid,$subjectid,$staffid)
        {
                $q = 'DELETE FROM #__timetable WHERE termid='.$termid.' AND courseid='.$courseid.' AND dayid='.$dayid.' AND sessionid='.$sessionid.' AND subjectid='.$subjectid.' AND staffid='.$staffid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }


        function deleteTimeTableEntry($pid)
        {
                $q = 'DELETE FROM #__timetable WHERE id='.$pid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

        function getTimeTableEntry($termid,$courseid,$dayid,$sessionid){
                $db =& JFactory::getDBO();
                $query = 'SELECT subjectid,staffid FROM #__timetable WHERE termid='.$termid.' AND courseid='.$courseid.' AND dayid='.$dayid.' AND sessionid='.$sessionid;
                $db->setQuery( $query );
                $res= $db->loadObjectList();
                return $res;
        }
        
	function checkStaffEntry($termid,$dayid,$sessionid,$staffid){
                $db =& JFactory::getDBO();
                $query = 'SELECT * FROM #__timetable WHERE termid='.$termid.' AND dayid='.$dayid.' AND sessionid='.$sessionid.' AND staffid='.$staffid;
                $db->setQuery( $query );
                $res= $db->loadObjectList();
                return $res;
	}

	function getAllotedCredits($termid,$courseid,$subjectid){
                $db =& JFactory::getDBO();
                $query = 'SELECT count(DISTINCT termid,courseid,subjectid,sessionid,dayid) AS total FROM #__timetable WHERE termid='.$termid.' AND courseid='.$courseid.' AND subjectid='.$subjectid;
                $db->setQuery( $query );
                $res= $db->loadObject();
                return $res;
	}

	function getTTSubjectid($courseid,$sessionid,$dayid,&$rec){
                $db =& JFactory::getDBO();
                $query = 'SELECT subjectid FROM #__timetable WHERE sessionid='.$sessionid.' AND courseid='.$courseid.' AND dayid='.$dayid.' LIMIT 1';
                $db->setQuery( $query );
                $rec= $db->loadObject();
                if(!$rec)
                        return false;
                return true;
	}	

	function getTTStaffids($courseid,$sessionid,$dayid,$subjectid){
                $db =& JFactory::getDBO();
                $query = 'SELECT staffid FROM #__timetable WHERE courseid='.$courseid.' AND dayid='.$dayid.' AND sessionid='.$sessionid.' AND subjectid='.$subjectid;
                $db->setQuery( $query );
                $res= $db->loadObjectList();
                return $res;
	}

	function getTTEntryByStaff($ptermid,$pstaffid,$psessionid,$pdayid,&$rec){
                $db =& JFactory::getDBO();
                $query = "SELECT courseid,subjectid FROM #__timetable WHERE staffid=".$pstaffid." AND termid=".$ptermid." AND dayid=".$pdayid." AND sessionid=".$psessionid;
                $db->setQuery( $query );
                $rec= $db->loadObject();
                if(!$rec)
                        return false;
                return true;
	}

	function getTTTermidByDate($pdate,&$rec){
                $db =& JFactory::getDBO();
		list($day,$month,$year) = explode("-",$pdate);
		$pidate=$year."-".$month."-".$day;	
                $query = "SELECT id FROM #__timetableterms where startdate <='".$pidate."' AND stopdate >= '".$pidate."' LIMIT 1";
                $db->setQuery( $query );
                $rec= $db->loadObject();
                if(!$rec)
                        return false;
                return true;
	}


	function storetimetable(){
		$count=0;
             	$ttdir = JPATH_SITE.DS.'tt/timetables/tt/';
                $db =& JFactory::getDBO();
                $sql="DELETE FROM timetableactivities WHERE aid IN (SELECT id FROM #__academicyears WHERE status='Y')";
                $db->setQuery( $sql);
                if(!$db->query()) return false;
		$ttxml = simplexml_load_file($ttdir."tt_activities.xml");
		foreach($ttxml->Activity as $tt) {
			$actxml = simplexml_load_file($ttdir."tt_data_and_timetable.fet");
        		foreach($actxml->Activities_List->Activity as $act) {
                		if("$tt->Id"=="$act->Id"){
        			//printf("%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s\n", $act->Students,$act->Activity_Tag,$act->Teacher,$act->Subject,$act->Id,$act->Duration,$act->Total_Duration, $act->Activity_Group_Id,$tt->Day,$tt->Hour,$tt->Room);
                        		foreach($act->Students as $students){
                                		foreach($act->Teacher as $staff){
                                        		$sql=sprintf("INSERT INTO timetableactivities (classcode,activitytag,staffcode,subjectcode,activityid,duration,totalduration,activitygroup,day,period,roomno,aid) VALUES('%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s',(SELECT id FROM #__academicyears WHERE status='Y'))", $students,$act->Activity_Tag,$staff,$act->Subject,$act->Id,$act->Duration,$act->Total_Duration, $act->Activity_Group_Id,$tt->Day,$tt->Hour,$tt->Room);
//        						$this->addTimeTableEntry($termid,$courseid,$dayid,$sessionid,$subjectid,$staffid){
                					$db->setQuery( $sql);
                					if(!$db->query()){
								$count++;
								$s=$s.$sql.'<br />';
							}
                                		}
                        		}
                		}
        		}
		}
		return $count;
	}

	function getTimetableActivityByClass($classcode,$daycode,$periodcode,&$recs)
	{
                $db =& JFactory::getDBO();
		$sql="SELECT day,period,subjectcode,staffcode,classcode,activitytag,duration,totalduration,roomno FROM timetableactivities where (aid IN (SELECT id FROM #__academicyears WHERE status='Y')) AND classcode='".$classcode."' AND day = '".$daycode."' AND period='".$periodcode."'";
                $db->setQuery( $sql );
                $recs= $db->loadObjectList();
	}

	function getTimetableEntryByStaff($staffid,$daycode,$periodcode,&$recs)
	{
                $db =& JFactory::getDBO();
		$sql="SELECT day,period,subjectcode,staffcode,classcode,activitytag,duration,totalduration,roomno FROM timetableactivities where (aid IN (SELECT id FROM #__academicyears WHERE status='Y')) AND staffcode IN (SELECT staffcode FROM #__staffs WHERE id ='".$staffid."') AND day = '".$daycode."' AND period='".$periodcode."'";
                $db->setQuery( $sql );
                $recs= $db->loadObjectList();
		return true;
	}

        function getTimetableEntryByClassDay($classcode,$daycode,$periodcode,&$recs)
        {
                $db =& JFactory::getDBO();
                $sql="SELECT day,period,subjectcode,staffcode,classcode,activitytag,duration,totalduration,roomno FROM timetableactivities WHERE (aid IN (SELECT id FROM #__academicyears WHERE status='Y')) AND classcode='".$classcode."' AND day = '".$daycode."' AND period='".$periodcode."'";
                $db->setQuery( $sql );
                $recs= $db->loadObjectList();
                return true;
        }


  	function updateactivityconstraint($activityid,$obj)
        {
                $q = "UPDATE #__tt_activities SET duration='".$obj->duration."', mindays='".$obj->mindays."', consecutive='".$obj->consecutive."', rate='".$obj->rate."', psrate='".$obj->psrate."'  WHERE id='".$activityid."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

  	function saveactivitytimings($activityid,$slots)
        {
                $db = & JFactory::getDBO();
		$sql="DELETE FROM #__activity_pref_slots WHERE actid='".$activityid."'";
                $db->setQuery($sql);
                if(!$db->query());
		
		foreach($slots as $slot){
			list($daycode,$sessioncode)=explode('-',$slot);
			$sql=sprintf("INSERT INTO #__activity_pref_slots (actid,daycode,sessioncode,aid) VALUES('%s','%s','%s',(SELECT id FROM #__academicyears WHERE status='Y'))", $activityid,$daycode,$sessioncode);
			$db->setQuery( $sql);
			if(!$db->query())
				return false;
		}
		return true;
	}

        function getactivitytimingslot($activityid,$daycode,$sessioncode)
        {
                $db =& JFactory::getDBO();
                $sql="SELECT actid FROM #__activity_pref_slots WHERE actid='".$activityid."' AND daycode='".$daycode."' AND sessioncode = '".$sessioncode."'";
                $db->setQuery( $sql );
                $recs= $db->loadObjectList();
		if(count($recs)>0)
	                return true;
		else 
			return false;

	}

	function getactivitytimingslots($activityid,&$recs)
        {
                $db =& JFactory::getDBO();
                $sql="SELECT actid,daycode,sessioncode FROM #__activity_pref_slots WHERE actid='".$activityid."' ORDER BY daycode";
                $db->setQuery( $sql );
                $recs= $db->loadObjectList();
                if(count($recs)>0)
                        return true;
                else
                        return false;

        }



  	function saveteachernotavailableslots($staffid,$slots)
        {
                $db = & JFactory::getDBO();
                $sql="DELETE FROM #__staff_not_available_slots WHERE aid IN (SELECT id FROM #__academicyears WHERE status='Y') AND staffid='".$staffid."'";
                $db->setQuery($sql);
                if(!$db->query());

                foreach($slots as $slot){
                        list($daycode,$sessioncode)=explode('-',$slot);
                        $sql=sprintf("INSERT INTO #__staff_not_available_slots (staffid,daycode,sessioncode,aid) VALUES('%s','%s','%s',(SELECT id FROM #__academicyears WHERE status='Y'))", $staffid,$daycode,$sessioncode);
                        $db->setQuery( $sql);
                        if(!$db->query())
                                return false;
                }
                return true;
        }


        function getteachernotavailableslots($staffid,&$recs)
        {
                $db =& JFactory::getDBO();
                $sql="SELECT staffid,daycode,sessioncode,aid FROM #__staff_not_available_slots WHERE aid IN (SELECT id FROM #__academicyears WHERE status='Y') AND staffid='".$staffid."' ORDER BY daycode";
                $db->setQuery( $sql );
                $recs= $db->loadObjectList();
                if(count($recs)>0)
                        return true;
                else
                        return false;

        }


      	function getteachernotavailableslot($teacherid,$daycode,$sessioncode)
        {
                $db =& JFactory::getDBO();
                $sql="SELECT staffid FROM #__staff_not_available_slots WHERE aid IN (SELECT id FROM #__academicyears where status='Y') AND staffid='".$teacherid."' AND daycode='".$daycode."' AND sessioncode = '".$sessioncode."'";
                $db->setQuery( $sql );
                $recs= $db->loadObjectList();
                if(count($recs)>0)
                        return true;
                else
                        return false;

        }



        function saveclassnotavailableslots($classid,$slots)
        {
                $db = & JFactory::getDBO();
                $sql="DELETE FROM #__class_not_available_slots WHERE classid='".$classid."'";
                $db->setQuery($sql);
                if(!$db->query());

                foreach($slots as $slot){
                        list($daycode,$sessioncode)=explode('-',$slot);
                        $sql=sprintf("INSERT INTO #__class_not_available_slots (classid,daycode,sessioncode,aid) VALUES('%s','%s','%s',(SELECT id FROM #__academicyears WHERE status='Y'))", $classid,$daycode,$sessioncode);
                        $db->setQuery( $sql);
                        if(!$db->query())
                                return false;
                }
                return true;
        }


        function getclassnotavailableslots($classid,&$recs)
        {
                $db =& JFactory::getDBO();
                $sql="SELECT classid,daycode,sessioncode FROM #__class_not_available_slots WHERE classid='".$classid."' ORDER BY daycode";
                $db->setQuery( $sql );
                $recs= $db->loadObjectList();
                if(count($recs)>0)
                        return true;
                else
                        return false;

        }


        function getclassnotavailableslot($classid,$daycode,$sessioncode)
        {
                $db =& JFactory::getDBO();
                $sql="SELECT classid FROM #__class_not_available_slots WHERE classid='".$classid."' AND daycode='".$daycode."' AND sessioncode = '".$sessioncode."'";
                $db->setQuery( $sql );
                $recs= $db->loadObjectList();
                if(count($recs)>0)
                        return true;
                else
                        return false;

        }


	function getMaxComid(&$rec){
		$q="SELECT MAX(comid) AS comid FROM #__tt_activities WHERE aid IN (SELECT id FROM #__academicyears WHERE status='Y')";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
	}

	function combineclasses($ids){
		$this->getMaxComid($crec);
		if($crec->comid=='NULL') $comid=1;
		else $comid=$crec->comid+1;
                $q = "UPDATE #__tt_activities SET comid='".$comid."'  WHERE id IN (".implode(",",$ids).")";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
		return true;
	}

	function getCombinedId($id,&$rec){
		$q="SELECT comid FROM #__tt_activities WHERE id='".$id."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
	}

	function deletecombinedclasses($id){
                $q = "UPDATE #__tt_activities SET comid = NULL WHERE comid ='".$id."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
		return true;
	}

}

