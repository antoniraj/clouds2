<?php
// No direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
include_once('cce.php');
 
jimport( 'joomla.application.component.model' );
class CceModelExams extends CceModelCce
{
	function __construct(){
        	parent::__construct();
        }


//GRADE BOOKS

	function getTGradeBooks(){
		$db =& JFactory::getDBO();
		$sql="select * from #__ex_t_gradebooks WHERE aid IN (SELECT id FROM #__academicyears WHERE status='Y')";
                $db->setQuery( $sql);
                $res= $db->loadObjectList();
                return $res;
	}	


	function getTGradeBook($gbid,&$rec) {
                $q = "SELECT * FROM #__ex_t_gradebooks WHERE id ='".$gbid."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
        }

        function addTGradeBook($title,&$gbid) {
                $q = "INSERT INTO #__ex_t_gradebooks(title,aid) VALUES('".mysql_real_escape_string($title)."',(SELECT id FROM #__academicyears WHERE status='Y'))";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
		$q = "SELECT LAST_INSERT_ID() as gbid";
                $db->setQuery($q);
                $obj = $db->loadObject();
                if($obj==null)
                        return false;
                $gbid=$obj->gbid;
                return true;
        }


	function deleteTGradeBook($gbid) {
                $q = "DELETE FROM #__ex_t_gradebooks WHERE id='".$gbid."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

	function updateTGradeBook($id,$title) {
                $q = "UPDATE #__ex_t_gradebooks SET title='".mysql_real_escape_string($title)."' WHERE id='".$id."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }







//GRADING SYSTEM
	function getGradingSystems(){
		$db =& JFactory::getDBO();
		$sql="select * from #__ex_t_gradingsystems WHERE aid IN (SELECT id FROM #__academicyears WHERE status='Y')";
                $db->setQuery( $sql);
                $res= $db->loadObjectList();
                return $res;
	}	


	function getGradingSystem($gsid,&$rec) {
                $q = "SELECT * FROM #__ex_t_gradingsystems WHERE id ='".$gsid."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
        }

        function addGradingSystem($title,&$gbid) {
                $q = "INSERT INTO #__ex_t_gradingsystems(title,aid) VALUES('".mysql_real_escape_string($title)."',(SELECT id FROM #__academicyears WHERE status='Y'))";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
		$q = "SELECT LAST_INSERT_ID() as gbid";
                $db->setQuery($q);
                $obj = $db->loadObject();
                if($obj==null)
                        return false;
                $gbid=$obj->gbid;
                return true;
        }


	function deleteGradingSystem($gsid) {
                $q = "DELETE FROM #__ex_t_gradingsystems WHERE id='".$gsid."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

	function updateGradingSystem($id,$title) {
                $q = "UPDATE #__ex_t_gradingsystems SET title='".mysql_real_escape_string($title)."' WHERE id='".$id."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }


	//GRADE BOOK ENTRIES


    	function getTGradeBookEntries($gbid){
                $db =& JFactory::getDBO();
                $sql="select * from #__ex_t_gradebookentries WHERE gid = '".$gbid."'";
                $db->setQuery( $sql);
                $res= $db->loadObjectList();
                return $res;
        }


        function getTGradeBookEntry($gbeid,&$rec) {
                $q = "SELECT * FROM #__ex_t_gradebookentries WHERE id ='".$gbeid."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
        }


       function addTGradeBookEntry($ptitle,$pcode,$pweightage,$pdescription,$pgsno,$required,$parentid,$duedate,$pgbid,$subtotal,&$gbeid) {
		if(strlen($parentid)>0){
			$q = "INSERT INTO #__ex_t_gradebookentries(`title`,`code`,`weightage`,`description`,`required`,`parentid`,`gsno`,`gid`,`duedate`) VALUES('".mysql_real_escape_string($ptitle)."','".mysql_real_escape_string($pcode)."','".$pweightage."','".mysql_real_escape_string($pdescription)."','".$required."','".$parentid."','".$pgsno."','".$pgbid."','".JArrayHelper::mysqlformat($duedate)."')";
		}else{
			$q = "INSERT INTO #__ex_t_gradebookentries(`title`,`code`,`weightage`,`description`,`required`,`gsno`,`gid`,`duedate`,`subtotalfield`) VALUES('".$ptitle."','".mysql_real_escape_string($pcode)."','".mysql_real_escape_string($pweightage)."','".mysql_real_escape_string($pdescription)."','".$required."','".$pgsno."','".$pgbid."','".JArrayHelper::mysqlformat($duedate)."','".$subtotal."')";
		}
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                $q = "SELECT LAST_INSERT_ID() as gbeid";
                $db->setQuery($q);
                $obj = $db->loadObject();
                if($obj==null)
                        return false;
                $gbeid=$obj->gbeid;
                return true;
        }

        function updateTGradeBookEntry($id,$ptitle,$pcode,$pweightage,$pdescription,$pgsno,$required,$parentid,$duedate,$gbid,$subtotalfield)
        {
		if(strlen($parentid)>0)
	                $q = "UPDATE #__ex_t_gradebookentries SET `title`='".mysql_real_escape_string($ptitle)."', `code`='".mysql_real_escape_string($pcode)."', `duedate`='".JArrayHelper::mysqlformat($duedate)."', `weightage`='".$pweightage."', `required`='".$required."', `parentid`='".$parentid."', `description`='".mysql_real_escape_string($pdescription)."',`gid`='".$gbid."',`gsno`='".$pgsno."'  WHERE `id`=".$id;
		else
	                $q = "UPDATE #__ex_t_gradebookentries SET `title`='".mysql_real_escape_string($ptitle)."', `code`='".mysql_real_escape_string($pcode)."', `duedate`='".JArrayHelper::mysqlformat($duedate)."', `weightage`='".$pweightage."', `required`='".$required."', `description`='".mysql_real_escape_string($pdescription)."',`gid`='".$gbid."',`gsno`='".$pgsno."',`subtotalfield`='".$subtotalfield."'  WHERE `id`=".$id;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

        function deleteTGradeBookEntry($pids)
        {
                $ids = implode(',',$pids);
                $q = 'DELETE FROM #__ex_t_gradebookentries WHERE `id` IN ('.$ids.')';
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

# To get the parents only (main subjects only)
        function getTGradeBookParentEntries($gid)
        {
                //$query = "SELECT `id`,`title`,`code`,`weightage`,`description`,`required`,`gsno`,`duedate`,`parentid`,`gid` FROM #__ex_t_gradebookentries WHERE gid='".$gid."' AND parentid IS NULL ORDER BY `gsno`" ;
                $query = "SELECT *  FROM #__ex_t_gradebookentries WHERE gid='".$gid."' AND parentid IS NULL ORDER BY `gsno`" ;
                $db = & JFactory::getDBO();
                $db->setQuery( $query );
                $recs = $db->loadObjectList();
                return $recs;
        }

#To get the children of a given subjectid(parentid)
        function getTGradeBookChildEntries($parentid){
                //$query = "SELECT `id`,`title`,`code`,`weightage`,`description`,`gsno`,`duedate`,`required`,`parentid`,`gid` FROM #__ex_t_gradebookentries WHERE parentid='".$parentid."' ORDER BY `gsno`" ;
                $query = "SELECT *  FROM #__ex_t_gradebookentries WHERE parentid='".$parentid."' ORDER BY `gsno`" ;
                $db = & JFactory::getDBO();
                $db->setQuery( $query );
                $recs = $db->loadObjectList();
                return $recs;
        }





//COURSE GRADE BOOK ENTRIES

# To get the parents only (main subjects only)
        function getGradeBookParentEntries($classid,$subjectid,$termid)
        {
                $query = "SELECT `id`,`title`,`code`,`weightage`,`description`,`gsno`,`required`,`duedate`,`parentid`,`classid`,`subjectid`,`termid`,`subtotalfield` FROM #__ex_gradebookentries WHERE subjectid='".$subjectid."' AND classid='".$classid."' AND termid='".$termid."' AND parentid IS NULL ORDER BY `gsno`" ;
                $db = & JFactory::getDBO();
                $db->setQuery( $query );
                $recs = $db->loadObjectList();
                return $recs;
        }

#To get the children of a given subjectid(parentid)
        function getGradeBookChildEntries($parentid){
                $query = "SELECT `id`,`title`,`code`,`weightage`,`description`,`gsno`,`duedate`,`parentid`,`classid`,`subjectid`,`termid` FROM #__ex_gradebookentries WHERE parentid='".$parentid."' ORDER BY `gsno`" ;
                $db = & JFactory::getDBO();
                $db->setQuery( $query );
                $recs = $db->loadObjectList();
                return $recs;
        }


	//GRADING SYSTEM ENTRIES
	function getGradingSystemEntries($gsid){
                $query = "SELECT * FROM #__ex_t_gradingsystementries WHERE gsid ='".$gsid."'" ;
                $db = & JFactory::getDBO();
                $db->setQuery( $query );
                $recs = $db->loadObjectList();
                return $recs;
	}
	

        function getGradingSystemEntry($pid,&$rec)
        {
                $q = 'SELECT `id`,`from`,`to`,`letter`,`description`,`points` FROM #__ex_t_gradingsystementries WHERE id ='.$pid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
        }

        function getGradingSystemEntryLetter($pmarks,&$rec)
        {
                $q = 'SELECT `id`,`from`,`to`,`letter`,`points`,`description` FROM #__ex_t_gradingsystementries WHERE `from` <= '.$pmarks.' AND `to` >= '.$pmarks;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
        }


       function addGradingSystemEntry($pfrom,$pto,$pletter,$pdescription,$ppoints,$gsid)
       {
                $q = "INSERT INTO #__ex_t_gradingsystementries(`from`,`to`,`letter`,`points`,`description`,`gsid`) VALUES('".$pfrom."','".$pto."','".$pletter."',".$ppoints.",'".$pdescription."','".$gsid."')";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

        function updateGradingSystemEntry($id,$pfrom,$pto,$pletter,$pdescription,$ppoints)
        {
                $q = "UPDATE #__ex_t_gradingsystementries SET `from`='".$pfrom."', `to`='".$pto."', `letter`='".$pletter."',`points`='".$ppoints."', `description`='".$pdescription."' WHERE `id`=".$id;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }


        function deleteGradingSystemEntry($pids)
        {
                $ids = implode(',',$pids);
                $q = 'DELETE FROM #__ex_t_gradingsystementries WHERE `id` IN ('.$ids.')';
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }


	
	//COURSE BOOKS

   	function getCourseBooks(){
                $db =& JFactory::getDBO();
                $sql="select * from #__ex_t_coursebooks WHERE aid IN (SELECT id FROM #__academicyears WHERE status='Y')";
                $db->setQuery( $sql);
                $res= $db->loadObjectList();
                return $res;
        }


        function getCourseBook($cbid,&$rec) {
                $q = "SELECT * FROM #__ex_t_coursebooks WHERE id ='".$cbid."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
        }

        function addCourseBook($title,&$cbid) {
                $q = "INSERT INTO #__ex_t_coursebooks(title,aid) VALUES('".mysql_real_escape_string($title)."',(SELECT id FROM #__academicyears WHERE status='Y'))";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                $q = "SELECT LAST_INSERT_ID() as cbid";
                $db->setQuery($q);
                $obj = $db->loadObject();
                if($obj==null)
                        return false;
                $cbid=$obj->cbid;
                return true;
        }


        function deleteCourseBook($cbid) {
                $q = "DELETE FROM #__ex_t_coursebooks WHERE id='".$cbid."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

        function updateCourseBook($id,$title) {
                $q = "UPDATE #__ex_t_coursebooks SET title='".mysql_real_escape_string($title)."' WHERE id='".$id."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
	}

	//PART
        function addPart($obj,&$partid) {
                $q = "INSERT INTO #__ex_t_parts(title,code,gpa,gs,gsno,academic,cbid) VALUES('".mysql_real_escape_string($obj['title'])."','".mysql_real_escape_string($obj['code'])."','".$obj['gpa']."','".$obj['gs']."','".$obj['gsno']."','".$obj['academic']."','".$obj['cbid']."')";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                $q = "SELECT LAST_INSERT_ID() as partid";
                $db->setQuery($q);
                $obj = $db->loadObject();
                if($obj==null)
                        return false;
                $partid=$obj->partid;
                return true;
        }


        function updatePart($obj) {
                $q = "UPDATE #__ex_t_parts SET title='".mysql_real_escape_string($obj['title'])."', code='".mysql_real_escape_string($obj['code'])."', gpa='".$obj['gpa']."',gs ='".$obj['gs']."',gsno='".$obj['gsno']."',academic='".$obj['academic']."',cbid='".$obj['cbid']."' WHERE id='".$obj['id']."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }


        function getParts($cbid){
                $db =& JFactory::getDBO();
                $sql="select * from #__ex_t_parts WHERE cbid ='".$cbid."' ORDER BY gsno";
                $db->setQuery( $sql);
                $res= $db->loadObjectList();
                return $res;
        }


        function getCourseParts($cid){
                $db =& JFactory::getDBO();
                $sql="select * from #__ex_t_parts WHERE cbid IN (SELECT cbid FROM #__ex_t_coursebookcourses WHERE courseid='".$cid."') ORDER BY gsno";
                $db->setQuery( $sql);
                $res= $db->loadObjectList();
                return $res;
        }


 	function getPart($partid,&$rec) {
                $q = "SELECT * FROM #__ex_t_parts WHERE id ='".$partid."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
        }



        function deletePart($pid) {
                $q = "DELETE FROM #__ex_t_parts WHERE id='".$pid."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

	//SUBJECTS	

      function getTSubjects($partid){
                $db =& JFactory::getDBO();
                $sql="select * from #__ex_tsubjects WHERE partid ='".$partid."' ORDER BY grouptag";
                $db->setQuery( $sql);
                $res= $db->loadObjectList();
                return $res;
        }


     	function updateTSubject($obj) {
		if(strlen($obj['parentid'])>0)
		        $q = "UPDATE #__ex_tsubjects  SET subjecttitle = '".mysql_real_escape_string($obj['subjecttitle'])."', subjectcode='".mysql_real_escape_string($obj['subjectcode'])."',acronym='".$obj['acronym']."',credits='".$obj['credits']."',marks='".$obj['marks']."',passmark='".$obj['passmark']."',subjecttype='".$obj['subjecttype']."',sessionduration='".$obj['sessionduration']."',grouptag='".$obj['grouptag']."', subjectcategory='".$obj['subjectcategory']."', parentid='".$obj['parentid']."' WHERE id='".$obj['id']."'";
		else
		        $q = "UPDATE #__ex_tsubjects  SET subjecttitle = '".mysql_real_escape_string($obj['subjecttitle'])."', subjectcode='".mysql_real_escape_string($obj['subjectcode'])."',acronym='".$obj['acronym']."',credits='".$obj['credits']."',marks='".$obj['marks']."',passmark='".$obj['passmark']."',subjecttype='".$obj['subjecttype']."',sessionduration='".$obj['sessionduration']."', subjectcategory='".$obj['subjectcategory']."',grouptag='".$obj['grouptag']."',parentid=NULL WHERE id='".$obj['id']."'";

                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

        function deleteTSubject($subjectid)
        {
                $q = "DELETE FROM #__ex_tsubjects WHERE id='".$subjectid."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }


     	function getTSubject($subjectid,&$rec) {
                $q = "SELECT * FROM #__ex_tsubjects WHERE id ='".$subjectid."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
        }


      	function getParentTSubjects($partid){
                $db =& JFactory::getDBO();
                $sql="select * from #__ex_tsubjects WHERE partid ='".$partid."' and parentid IS NULL  ORDER BY grouptag";
                $db->setQuery( $sql);
                $res= $db->loadObjectList();
                return $res;
        }

     	function getTSubjectChildEntries($parentid){
                $query = "SELECT * FROM #__ex_tsubjects WHERE parentid='".$parentid."' ORDER BY `grouptag`" ;
                $db = & JFactory::getDBO();
                $db->setQuery( $query );
                $recs = $db->loadObjectList();
                return $recs;
        }


	function addTSubject($obj,&$subjectid) {
		if(strlen($obj['parentid'])>0)
	                $q = "INSERT INTO #__ex_tsubjects(subjecttitle,subjectcode,acronym,credits,marks,passmark,subjecttype,sessionduration,subjectcategory,grouptag,partid,parentid) VALUES('".mysql_real_escape_string($obj['subjecttitle'])."','".mysql_real_escape_string($obj['subjectcode'])."','".$obj['acronym']."','".$obj['credits']."','".$obj['marks']."','".$obj['passmark']."','".$obj['subjecttype']."','".$obj['sessionduration']."','".$obj['subjectcategory']."','".$obj['grouptag']."','".$obj['partid']."','".$obj['parentid']."')";
		else
	                $q = "INSERT INTO #__ex_tsubjects(subjecttitle,subjectcode,acronym,credits,marks,passmark,subjecttype,sessionduration,subjectcategory,grouptag,partid) VALUES('".mysql_real_escape_string($obj['subjecttitle'])."','".mysql_real_escape_string($obj['subjectcode'])."','".$obj['acronym']."','".$obj['credits']."','".$obj['marks']."','".$obj['passmark']."','".$obj['subjecttype']."','".$obj['sessionduration']."','".$obj['subjectcategory']."','".$obj['grouptag']."','".$obj['partid']."')";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                $q = "SELECT LAST_INSERT_ID() as subjectid";
                $db->setQuery($q);
                $obj = $db->loadObject();
                if($obj==null)
                        return false;
                $subjectid=$obj->subjectid;
                return true;
        }



	//TERMS	
	function getTTerms($partid){
                $db =& JFactory::getDBO();
                $sql="select * from #__ex_t_terms WHERE partid ='".$partid."' ORDER BY startdate";
                $db->setQuery( $sql);
                $res= $db->loadObjectList();
                return $res;
        }

        function getTTerm($termid,&$rec) {
                $q = "SELECT * FROM #__ex_t_terms WHERE id ='".$termid."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
        }

        function addTTerm($obj) {
                $q = "INSERT INTO #__ex_t_terms(term,code,months,startdate,stopdate,partid) VALUES('".$obj['term']."','".$obj['code']."','".$obj['months']."','".JArrayHelper::mysqlformat($obj['startdate'])."','".JArrayHelper::mysqlformat($obj['stopdate'])."','".$obj['partid']."')";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

        function updateTTerm($sc) {
                $q = "UPDATE #__ex_t_terms SET term='".mysql_real_escape_string($sc['term'])."', code='".mysql_real_escape_string($sc['code'])."', months='".mysql_real_escape_string($sc['months'])."', startdate='".JArrayHelper::mysqlformat($sc['startdate'])."', stopdate='".JArrayHelper::mysqlformat($sc['stopdate'])."' WHERE id='".$sc['id']."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

     	function deleteTTerm($termid)
        {
                $q = "DELETE FROM #__ex_t_terms WHERE id='".$termid."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }




	//SUBJECT GRADE BOOK
        function getSubjectTermGradeBookDetails($subjectid,$termid,&$rec) {
                $q = "SELECT * FROM #__ex_t_gradebooks WHERE id IN (SELECT gbid FROM #__ex_t_subjecttermgradebook WHERE subjectid='".$subjectid."' AND termid='".$termid."')";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
        }

	function getSubjectTermGradeBook($subjectid,$termid,&$rec) {
                $q = "SELECT * FROM #__ex_t_subjecttermgradebook WHERE subjectid='".$subjectid."' AND termid='".$termid."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
        }

	function deleteSubjectGradeBook($subjectid,$termid)
	{
                $q = "DELETE FROM #__ex_t_subjecttermgradebook WHERE termid='".$termid."' AND subjectid='".$subjectid."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
	}


   	function addSubjectTermGradeBook($obj) {
                $q = "INSERT INTO #__ex_t_subjecttermgradebook(subjectid,termid,gbid) VALUES('".$obj['subjectid']."','".$obj['termid']."','".$obj['gbid']."')";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

	//SUBJECTS
	function getGBSubject($id,&$rec){
                $q = "SELECT * FROM #__ex_tsubjects WHERE id='".$id."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
	}

	//SUBJECT GRADING SYSTEM

        function getSubjectGradingSystem($subjectid,&$rec) {
                $q = "SELECT * FROM #__ex_t_subjectgradingsystem WHERE subjectid='".$subjectid."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
        }

        function deleteSubjectGradingSystem($subjectid,$gsid)
        {
                $q = "DELETE FROM #__ex_t_subjectgradingsystem WHERE gsid='".$gsid."' AND subjectid='".$subjectid."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }


        function addSubjectGradingSystem($obj) {
                $q = "INSERT INTO #__ex_t_subjectgradingsystem(subjectid,gsid) VALUES('".$obj['subjectid']."','".$obj['gsid']."')";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

	//COURSEE BOOK COURSEE
	function addCourseBookCourse($cid,$cbid){
                $q = "INSERT INTO #__ex_t_coursebookcourses(courseid,cbid) VALUES('".$cid."','".$cbid."')";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;

	}

	function getCourseBookCourses($cbid){
                $db =& JFactory::getDBO();
                $sql="SELECT * FROM #__courses WHERE id IN (select courseid from #__ex_t_coursebookcourses WHERE cbid ='".$cbid."') ORDER BY id ";
                $db->setQuery( $sql);
                $res= $db->loadObjectList();
                return $res;
	}

	function deleteCourseBookCourse($cid,$cbid)
        {
                $q = "DELETE FROM #__ex_t_coursebookcourses WHERE courseid='".$cid."' AND cbid='".$cbid."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

	//COURSE GRADE BOOK ENTRIES


        function getGradeBookEntry($cid,&$rec) {
                $q = 'SELECT *  FROM #__ex_gradebookentries WHERE id ='.$cid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
        }

function getGradeBookEntryIdTGBID($subjectid,$termid,$sgbid,&$rec)
{
                $q = 'SELECT * FROM #__ex_gradebookentries WHERE subjectid ='.$subjectid.' AND termid='.$termid.' AND tgradebookid='.$sgbid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
}

function getGradeBookEntryIdTGBID1($subjectid,$sgbid,&$rec)
{
                $q = 'SELECT * FROM #__ex_gradebookentries WHERE subjectid ='.$subjectid.' AND tgradebookid='.$sgbid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
}




	function getCourseGradeBookEntry($cid,$sid,$tid,$gbeid,&$rec){
		$q = "SELECT * FROM #__ex_gradebookentries WHERE classid='".$cid."' AND subjectid='".$sid."' AND termid='".$tid."' AND tgradebookid='".$gbeid."' LIMIT 1";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
	
	}


	function addCourseGradeBookParentEntry($cid,$sid,$tid,$title,$code,$weightage,$desc,$required,$gsno,$duedate,$gbeid,$subtotalfield,&$newparentid){
                $q = "INSERT INTO #__ex_gradebookentries(`classid`,`subjectid`,`termid`,`title`,`code`,`weightage`,`description`,`required`,`gsno`,`tgradebookid`,`duedate`,`subtotalfield`) VALUES('".$cid."','".$sid."','".$tid."','".mysql_real_escape_string($title)."','".mysql_real_escape_string($code)."','".$weightage."','".mysql_real_escape_string($desc)."','".$required."','".$gsno."','".$gbeid."','".JArrayHelper::mysqlformat($duedate)."','".$subtotalfield."')";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query()){
                	$rs = $this->getCourseGradeBookEntry($cid,$sid,$tid,$gbeid,$cgbrec); 
			if($rs){
				$newparentid = $cgbrec->id;
				return true;
			}else
				return false;
		}
		$q = "SELECT LAST_INSERT_ID() as npid";
                $db->setQuery($q);
                $obj = $db->loadObject();
                if($obj==null)
                        return false;
                $newparentid=$obj->npid;
                return true;
        }

        function addCourseGradeBookChildEntry($cid,$sid,$tid,$title,$code,$weightage,$desc,$required,$gsno,$duedate,$parentid,$gbeid,&$newparentid){
                $q = "INSERT INTO #__ex_gradebookentries(`classid`,`subjectid`,`termid`,`title`,`code`,`weightage`,`description`,`required`,`gsno`,`parentid`,`tgradebookid`,`duedate`) VALUES('".$cid."','".$sid."','".$tid."','".mysql_real_escape_string($title)."','".mysql_real_escape_string($code)."','".$weightage."','".mysql_real_escape_string($desc)."','".$required."','".$gsno."','".$parentid."','".$gbeid."','".JArrayHelper::mysqlformat($duedate)."')";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query()){
                        $rs = $this->getCourseGradeBookEntry($cid,$sid,$tid,$gbeid,$cgbrec);
                        if($rs){
                                $newparentid = $cgbrec->id;
                                return true;
                        }else
                                return false;
                }
                $q = "SELECT LAST_INSERT_ID() as npid";
                $db->setQuery($q);
                $obj = $db->loadObject();
                if($obj==null)
                        return false;
                $newparentid=$obj->npid;
                return true;
        }



        function findHeadHeight($classid,$subjectid,$termid){
                // Traverse level by level and count
                // Use two queues q1 and q2
                // initialize q1 with top parents ids
                // find childrend ids and put them in q2 and assign q2 to q1 and repeat until q1 becomes empty
                // 
                $precs = $this->getGradeBookParentEntries($classid,$subjectid,$termid);
                $q1=array();//Initialize the queue with all parents
                foreach($precs as $prec){
                        array_push($q1,$prec->id);
                }
                $c=0;
                while(count($q1)>0){
                        $c=$c+1;
                        $q2 = array();
                        foreach($q1 as $p){
                                $crecs = $this->getGradeBookChildEntries($p);
                                foreach($crecs as $crec){
                                        array_push($q2,$crec->id);
                                }
                        }
                        $q1 = $q2;
                }
                return ($c);
        }

//
        function getTerminalChildren($cid){
                $obj = new Ent();
                $obj->id=$cid;
                $obj->flag=0;
                $q = array($obj);
                $tq=array();
                $tf=1;
                while($tf==1){
                        $tq=array();
                        $tf=0;
                        while(count($q)>0){
                                unset($pobj);
                                $pobj = new Ent();
                                $pobj = array_shift($q);
                                $x=$pobj->flag;
                                if($x==0){
                                        $tf=1;
                                        $crecs = $this->getGradeBookChildEntries($pobj->id); //To process immediate children
                                        $ct = count($crecs);
                                        if($ct==0){
                                                $pobj->flag=1;
                                                array_push($tq,$pobj);
                                        }else{
                                                foreach($crecs  as $crec){
                                                        unset($cobj);
                                                        $cobj = new Ent();
                                                        $cobj->id = $crec->id;
                                                        $cobj->flag=0;
                                                        array_push($tq,$cobj);
                                                }
                                        }
                                }else{
                                        array_push($tq,$pobj);
                                }
                        }
                        $q = $tq;
                }
                return $tq;
        }


        function countChildren($cid,$c){
                $crecs = $this->getGradeBookChildEntries($cid); //To process immediate children
                if(count($crecs)==0)
                        return 1;
                foreach($crecs as $crec){
                        $c = $c + $this->countChildren($crec->id,1);
                }
                return $c;

        }

        function countTChildren($cid,$c){
                $crecs = $this->getTGradeBookChildEntries($cid); //To process immediate children
                if(count($crecs)==0)
                        return 1;
                foreach($crecs as $crec){
                        $c = $c + $this->countTChildren($crec->id,1);
                }
                return $c;

        }


//STUDENT MARKS

        function getStudentMark($studentid,$gbid,&$rec){
                $q = "SELECT  * FROM #__ex_studentmarks  WHERE studentid='".$studentid."' AND gbid ='".$gbid."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
        }

        function addStudentMark($arr=false) {
                $q = "INSERT INTO #__ex_studentmarks (`studentid`,`gbid`,`marks`,`comments`) VALUES('".$arr['studentid']."','".$arr['gbeid']."','".$arr['marks']."','".mysql_real_escape_string($arr['comments'])."')";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

        function updateStudentMark($arr=false) {
                $q = "UPDATE #__ex_studentmarks SET `marks` = '".$arr['marks']."', `comments`='".mysql_real_escape_string($arr['comments'])."' WHERE `studentid`='".$arr['studentid']."' AND gbid='".$arr['gbeid']."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }


        function getMarks($studentid,$gbid,$weight){
                $gbrecs = $this->getGradeBookChildEntries($gbid);
                if(count($gbrecs)==0){
                        $r = $this->getStudentMark($studentid,$gbid,$obj);
                        if($r){
                                return round($obj->marks,1);
                        }else{
                                return -1;
                        }
                }

                $sum=0.0;
                $sumt=0.0;
                foreach($gbrecs as $gbrec){
                        $m = $this->getMarks($studentid,$gbrec->id,$gbrec->weightage);
                        if($m=="-1") $m=0;
                        $sum = $sum + $m;
                        $sumt = $sumt + $gbrec->weightage;
                }
                $x=round((double)$sum/(double)$sumt*(double)$weight,1);
                return $x;
        }



	function deleteAllSubjectMarks($gbid){
                $q = "DELETE FROM #__ex_studentmarks where gbid='".$gbid."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
	}


        function getSubjectGradeBookEntry($cid,$sid,$tid,&$rec){
                $q = "SELECT * FROM #__ex_gradebookentries WHERE classid='".$cid."' AND subjectid='".$sid."' AND termid='".$tid."'  LIMIT 1";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;

        }


        function addSubjectGradeBookEntry($cid,$sid,$tid,$title,$code,$weightage,$desc,$required,$gsno,$duedate,$parentid,&$newparentid){
                $q = "INSERT INTO #__ex_gradebookentries(`classid`,`subjectid`,`termid`,`title`,`code`,`weightage`,`description`,`required`,`gsno`,`parentid`,`duedate`) VALUES('".$cid."','".$sid."','".$tid."','".mysql_real_escape_string($title)."','".mysql_real_escape_string($code)."','".$weightage."','".mysql_real_escape_string($desc)."','".$required."','".$gsno."','".$parentid."','".JArrayHelper::mysqlformat($duedate)."')";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query()){
                        $rs = $this->getSubjectGradeBookEntry($cid,$sid,$tid,$cgbrec);
                        if($rs){
                                $newparentid = $cgbrec->id;
                                return true;
                        }else
                                return false;
                }
                $q = "SELECT LAST_INSERT_ID() as npid";
                $db->setQuery($q);
                $obj = $db->loadObject();
                if($obj==null)
                        return false;
                $newparentid=$obj->npid;
                return true;
        }

	function deleteSubjectGradeBookEntry($gbeid){
                $q = "DELETE FROM #__ex_gradebookentries WHERE id='".$gbeid."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

	
	function updateSubjectGradeBookEntry($data){
		$q = "UPDATE #__ex_gradebookentries SET `title`='".mysql_real_escape_string($data['title'])."', `code`='".mysql_real_escape_string($data['code'])."', `duedate`='".JArrayHelper::mysqlformat($data['duedate'])."', `weightage`='".$data['marks']."', `description`='".mysql_real_escape_string($data['description'])."',`gsno`='".$data['gsno']."'  WHERE `id`=".$data['gbeid'];
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
	}



	function getSubjectGradeMaxMark($subjectid,&$rec){
		$q =  "selECT max(`to`) as max FROM #__ex_t_gradingsystementries WHERE gsid IN (SELECT gsid FROM #__ex_t_subjectgradingsystem WHERE subjectid='".$subjectid."')";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;

	}

	function getSubjectGradeLetter($subjectid,$mark,&$rec){
		$q = "SELECT * FROM #__ex_t_gradingsystementries WHERE ( '".$mark."' BETWEEN `from` AND `to`) AND  gsid  IN (SELECT gsid FROM #__ex_t_subjectgradingsystem WHERE subjectid='".$subjectid."') LIMIT 1";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;

	}
	


	function getGradeBookEntryIdByTgbid($tgbid,$subjectid,$termid,$classid,&$rec){
		$q= "SELECT * FROM #__ex_gradebookentries where tgradebookid='".$tgbid."' and subjectid='".$subjectid."' and termid='".$termid."' and classid='".$classid."'";
 		$db = & JFactory::getDBO();
               	$db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
	}


        function getGradeBookEntryIdByTgbid1($tgbid,$subjectid,$classid,&$rec){
                $q= "SELECT * FROM #__ex_gradebookentries where tgradebookid='".$tgbid."' and subjectid='".$subjectid."'  and classid='".$classid."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
        }



//SUB TOTAL

        function getSubTotalEntries($gbeid){
                $q= "SELECT sgbid FROM #__ex_t_subtotals where gbid='".$gbeid."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $recs = $db->loadObjectList();
                return $recs;
        }



        function deleteSubTotalFields($gbeid){
                $q = "DELETE FROM #__ex_t_subtotals WHERE gbid='".$gbeid."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

        function addSubTotalFields($gbeid,$sgbeid) {
                $q = "INSERT INTO #__ex_t_subtotals(`gbid`,`sgbid`) VALUES('".$gbeid."','".$sgbeid."')";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }


//SUMMARY FIELDS
	
        function getSummaryEntries($subjectid){
                $q= "SELECT * FROM #__ex_t_summary where subjectid='".$subjectid."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $recs = $db->loadObjectList();
                return $recs;
        }


        function getSummaryEntry($id,&$rec){
                $q= "SELECT * FROM #__ex_t_summary where id='".$id."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
        }



        function deleteSummaryEntry($sumid){
                $q = "DELETE FROM #__ex_t_summary WHERE id='".$sumid."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

        function addSummaryEntry($title,$code,$stype,$subjectid,&$summaryid) {
                $q = "INSERT INTO #__ex_t_summary(`title`,`code`,`summarytype`,`subjectid`) VALUES('".$title."','".$code."','".$stype."','".$subjectid."')";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
		$q = "SELECT LAST_INSERT_ID() as summaryid";
                $db->setQuery($q);
                $obj = $db->loadObject();
                if($obj==null)
                        return false;
                $summaryid=$obj->summaryid;
                return true;
        }


        function updateSummaryEntry($id,$title,$code,$stype,$subjectid) {
                $q = "UPDATE #__ex_t_summary SET `title`='".$title."', `code`='".$code."',`summarytype`='".$stype."' WHERE id='".$id."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }


        function addSummaryCols($sumid,$termid,$gbeid) {
                $q = "INSERT INTO #__ex_t_summarycols(`summaryid`,`termid`,`gbeid`) VALUES('".$sumid."','".$termid."','".$gbeid."')";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }


        function deleteSummaryColEntries($sumid){
                $q = "DELETE FROM #__ex_t_summarycols WHERE summaryid='".$sumid."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

	function getSummaryColEntries($sumid){
                $q= "SELECT * FROM #__ex_t_summarycols where summaryid='".$sumid."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $recs = $db->loadObjectList();
                if($recs==null)
                        return false;
		return $recs;
	}




}


