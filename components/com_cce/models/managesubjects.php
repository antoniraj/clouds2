<?php
 
defined( '_JEXEC' ) or die( 'Restricted access' );
include_once('cce.php');
 
jimport( 'joomla.application.component.model' );
 
class CceModelManageSubjects extends CceModelCce
{

	function __construct(){
        	parent::__construct();
        }

	function getMSubject($pid,&$rec)
        {
                $q = 'SELECT `id`,`subjecttitle`,`subjectcode`,`subjecttype`,`acronym`,`credits`,`sessionduration`,`passmark`, `marks` FROM #__msubjects WHERE id ='.$pid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
        }

       function addMSubject($psubjecttitle,$psubjectcode,$psubjecttype,$pacronym,$pcredits,$psessionduration,$pmarks,$ppassmark)
       {
                $q = "INSERT INTO #__msubjects(`subjecttitle`,`subjectcode`,`subjecttype`,`credits`,`sessionduration`,`acronym`,`passmark`,`marks`) VALUES('".$psubjecttitle."','".$psubjectcode."','".$psubjecttype."',".$pcredits.",'".$psessionduration."','".$pacronym."','".$ppassmark."','".$pmarks."')";

                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

        function updateMSubject($id,$psubjecttitle,$psubjectcode,$psubjecttype,$pacronym,$pcredits,$psessionduration,$pmarks,$ppassmark)
        {
                $q = "UPDATE #__msubjects SET `subjecttitle`='".$psubjecttitle."', `subjecttype`='".$psubjecttype."', `subjectcode`='".$psubjectcode."',`marks`='".$pmarks."', `credits`='".$pcredits."', `sessionduration`='".$psessionduration."',`passmark`='".$ppassmark."', `acronym`='".$pacronym."' WHERE `id`='".$id."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }


        function deleteMSubjects($pids)
        {
                $ids = implode(',',$pids);
                $q = 'DELETE FROM #__msubjects WHERE `id` IN ('.$ids.')';
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }


        function getMSubjects()
        {
                $query = "SELECT `id`,`subjecttitle`,`subjectcode`,`subjecttype`,`credits`,`sessionduration`,`acronym`,`marks`,`passmark` FROM #__msubjects";
                $db = & JFactory::getDBO();
                $db->setQuery( $query );
                $subjects= $db->loadObjectList();
                return $subjects;
        }
	
	function getMSubjectIdsByCourse($courseid,&$recs)
        {
                $query = "SELECT `sid` FROM `#__coursesubjects` WHERE `cid` = ". $courseid ;
                $db = & JFactory::getDBO();
                $db->setQuery( $query );
                $recs= $db->loadObjectList();
                return true;
        }


        function getMSubjectsByCourse($courseid,&$recs)
        {
                $query = "SELECT `id`,`subjecttitle`,`subjectcode`,`subjecttype`,`credits`,`acronym`,`marks`,`passmark` FROM #__msubjects WHERE `id` IN (SELECT `sid` FROM `#__coursesubjects` WHERE `cid` = ". $courseid .")";
                $db = & JFactory::getDBO();
                $db->setQuery( $query );
                $recs= $db->loadObjectList();
                return true;
        }

	function getCurrentMSubjects(&$recs){
		$sql = "select DISTINCT (SELECT subjectcode FROM #__msubjects WHERE id=sid) as subjectcode,sid FROM #__coursesubjects where cid IN (SELECT id FROM #__courses where aid IN (SELECT id FROM #__academicyears WHERE status='Y'))";
                $db = & JFactory::getDBO();
                $db->setQuery( $sql );
                $recs= $db->loadObjectList();
                return true;
	}

	function getMSubjectTypes(&$recs){
		$sql = "select distinct subjecttype FROM #__msubjects";
                $db = & JFactory::getDBO();
                $db->setQuery( $sql );
                $recs= $db->loadObjectList();
                return true;
	}

	function getMSubjectActivitiesByCourseSubject($cid,$sid,$staffid,&$rec){
		$sql = "select id,sid,cid,subjectcode,stype,duration,hrs,coursecode from #__tt_activities WHERE cid='".$cid."' AND sid='".$sid."'";
		//$sql="select sid,cid, (select subjectcode from #__msubjects where id=sid) as subjectcode,(select subjecttype from #__msubjects where id=sid) as stype,(select sessionduration from #__msubjects where id=sid) as duration, (select credits from #__msubjects where id=sid) as hrs, (select code from #__courses where id = cid) as coursecode from #__coursesubjects where cid IN (SELECT id FROM #__courses WHERE aid IN (select id FROM #__academicyears where status = 'Y')) AND cid='".$cid."' AND sid='".$sid."'  ORDER BY coursecode,subjectcode";
                $db = & JFactory::getDBO();
                $db->setQuery( $sql );
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
		$sql="SELECT  courseid,subjectid,staffid FROM #__subjectteachers where subjectid ='".$sid."'and courseid='".$cid."' AND staffid='".$staffid."'";	
                $db->setQuery( $sql );
                $rec1 = $db->loadObject();
                if($rec1==null)
                        return false;
                return true;
	}

	function clearActivities($deptid){
                $q = "DELETE FROM #__tt_activities WHERE aid IN (SELECT id FROM #__academicyears WHERE status='Y') AND cid IN (SELECT courseid FROM #__departmentcourses  WHERE id='".$deptid."')";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
	}

	function resetClassConstraints($deptid){
                $q = "DELETE FROM #__class_not_available_slots WHERE aid IN (SELECT id FROM #__academicyears WHERE status='Y') AND classid IN (SELECT courseid FROM #__departmentcourses  WHERE departmentid='".$deptid."')";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
	}

	function resetStaffConstraints($deptid){
 		$q = "DELETE FROM #__staff_not_available_slots WHERE aid IN (SELECT id FROM #__academicyears where status='Y') AND staffid IN (SELECT staffid FROM #__subjectteachers WHERE courseid IN (SELECT courseid FROM #__departmentcourses WHERE departmentid='".$deptid."'))" ;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }


        function resetActivityBasicConstraints($deptid){
                $q="UPDATE #__tt_activities SET mindays='1', consecutive='0', rate='99.75', psrate='99.75' WHERE  aid IN  (SELECT id FROM #__academicyears WHERE status='Y') AND cid IN (SELECT courseid FROM #__departmentcourses WHERE departmentid='".$deptid."')";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }



        function resetActivityPrefSlots($deptid){
		$q="delete from #__activity_pref_slots WHERE aid IN (SELECT id FROM #__academicyears WHERE status='Y') AND actid IN (SELECT id  FROM #__tt_activities WHERE cid IN (SELECT courseid FROM #__departmentcourses WHERE departmentid='".$deptid."'))";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

	function resetActivityConstraints($deptid){
		$this->resetActivityBasicConstraints($deptid);
		$this->resetActivityPrefSlots($deptid);
		return true;
	}

	function initializeActivities($deptid){
		$this->clearActivities($deptid);
		$this->getMSubjectActivities($recs);
                $db = & JFactory::getDBO();
                $i=$this->getWorkloadMaxActivityAll($max)+1;
		foreach($recs as $rec){
			//if($rec->stype=="Practical") $mindays=2;
			//else 
			$mindays=1;
			$sql = "INSERT INTO #__tt_activities(id,sid,cid,subjectcode,stype,duration,hrs,coursecode,mindays,consecutive,rate,psrate,aid) VALUES('".$i++."','".$rec->sid."','".$rec->cid."','".$rec->subjectcode."','".$rec->stype."','".$rec->duration."','".$rec->hrs."','".$rec->coursecode."','".$mindays."','0','99.75','99.75',(SELECT id FROM #__academicyears WHERE status='Y'))";
                	$db->setQuery($sql);
                	if(!$db->query())
                        	return false;
		}
	        return true;
	}



     function refereshActivities($deptid){
               $this->getWorkloadMaxActivity($max);
		$this->getMSubjectActivities1($recs);
		//$drecs  = array_diff($recs,$recs1);
                $db = & JFactory::getDBO();
                $i=($max->mid)+1;
                foreach($recs as $rec){
			//if($rec->stype=="Practical") $mindays=2;
			///else
			$mindays=1;
			$rec->consecutive=0;
			$rec->rate=99.75;
			$sql = "INSERT INTO #__tt_activities(id,sid,cid,subjectcode,stype,duration,hrs,coursecode,mindays,consecutive,rate,psrate,aid) VALUES('".$i++."','".$rec->sid."','".$rec->cid."','".$rec->subjectcode."','".$rec->stype."','".$rec->duration."','".$rec->hrs."','".$rec->coursecode."','".$mindays."','".$rec->consecutive."','".$rec->rate."','".$rec->psrate."',(SELECT id FROM #__academicyears WHERE status='Y'))";
                        $db->setQuery($sql);
                        if(!$db->query()) {
				;
			}
                }
                return true;
        }


 	function getWorkloadMaxActivityAll(&$rec){
                $sql = "select max(id) as mid from #__tt_activities";
                $db = & JFactory::getDBO();
                $db->setQuery( $sql );
                $rec= $db->loadObject();
                return true;
        }

 	function getWorkloadMaxActivity(&$rec){
                $sql = "select max(id) as mid from #__tt_activities WHERE aid IN (select id FROM #__academicyears WHERE status='Y')";
                $db = & JFactory::getDBO();
                $db->setQuery( $sql );
                $rec= $db->loadObject();
                return true;
        }



	function getWorkloadActivities(&$recs){
		$sql = "select id,sid,cid,subjectcode,stype,duration,hrs,coursecode,rate,consecutive,mindays,psrate from #__tt_activities WHERE comid IS NULL AND  aid IN (select id FROM #__academicyears where status='Y')";
                $db = & JFactory::getDBO();
                $db->setQuery( $sql );
                $recs= $db->loadObjectList();
                return true;
	}

	function getCombinedClassIds(&$ids){
		$sql = "select DISTINCT comid,count(*) as total from #__tt_activities WHERE aid IN (select id FROM #__academicyears where status='Y') AND comid IS NOT NULL GROUP BY comid";
                $db = & JFactory::getDBO();
                $db->setQuery( $sql );
                $ids= $db->loadObjectList();
                return true;
	}

	function getWorkloadCombinedActivities($comid,&$recs){
		$sql = "select id,sid,cid,subjectcode,stype,duration,hrs,coursecode,rate,consecutive,mindays,psrate from #__tt_activities WHERE comid = '".$comid."' AND aid IN (select id FROM #__academicyears where status='Y')";
                $db = & JFactory::getDBO();
                $db->setQuery( $sql );
                $recs= $db->loadObjectList();
                return true;
	}

	function getWorkloadActivity($id,&$rec){
		$sql = "select id,sid,cid,subjectcode,stype,duration,hrs,coursecode,rate,consecutive,mindays,psrate from #__tt_activities where id='".$id."'";
                $db = & JFactory::getDBO();
                $db->setQuery( $sql );
                $rec= $db->loadObject();
                if($rec==null)
                        return false;
                return true;
	}

	function getMSubjectActivities(&$recs){
		$sql = "select sid,cid, (select subjectcode from #__msubjects where id=sid) as subjectcode,(select subjecttype from #__msubjects where id=sid) as stype,(select sessionduration from #__msubjects where id=sid) as duration, (select credits from #__msubjects where id=sid) as hrs, (select code from #__courses where id = cid) as coursecode from #__coursesubjects where cid IN (SELECT id FROM #__courses WHERE aid IN (select id FROM #__academicyears where status = 'Y')) ORDER BY coursecode,subjectcode";
                $db = & JFactory::getDBO();
                $db->setQuery( $sql );
                $recs= $db->loadObjectList();
                return true;
	}




        function getMSubjectActivities1(&$recs){
                $sql = "select sid,cid, (select subjectcode from #__msubjects where id=sid) as subjectcode,(select subjecttype from #__msubjects where id=sid) as stype,(select sessionduration from #__msubjects where id=sid) as duration, (select credits from #__msubjects where id=sid) as hrs, (select code from #__courses where id = cid) as coursecode from #__coursesubjects where cid IN (SELECT id FROM #__courses WHERE aid IN (select id FROM #__academicyears where status = 'Y')) AND ((cid,sid) NOT IN  (SELECT cid,sid FROM #__tt_activities)) ORDER BY coursecode,subjectcode";
                $db = & JFactory::getDBO();
                $db->setQuery( $sql );
                $recs= $db->loadObjectList();
                return true;
        }


	function getMSubjectStaffs($subjectid,$courseid,&$recs){
		$sql = "SELECT (SELECT staffcode FROM #__staffs where id = staffid) as staffcode FROM #__subjectteachers where subjectid ='".$subjectid."' AND courseid='".$courseid."'";
                $db = & JFactory::getDBO();
                $db->setQuery( $sql );
                $recs= $db->loadObjectList();
                return true;
	}

	function getWorkloadHrs($staffid,&$rec){
                $db = & JFactory::getDBO();
		$sql="SELECT sum((select credits FROM #__msubjects where id=subjectid)) as hrs FROM #__subjectteachers WHERE staffid = '".$staffid."' AND courseid IN (SELECT id FROM #__courses WHERE aid IN (SELECT id FROM #__academicyears where status='Y'))";
                $db->setQuery( $sql );
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
	}

}
