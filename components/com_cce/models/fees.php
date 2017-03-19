<?php
// No direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
include_once('cce.php');
 
jimport( 'joomla.application.component.model' );
class CceModelFees extends CceModelCce
{
	function __construct(){
        	parent::__construct();
        }

 function makeComma($input){
     if(strlen($input)<=2)
     { return $input; }
     $length=substr($input,0,strlen($input)-2);
     $formatted_input = makeComma($length).",".substr($input,-2);
     return $formatted_input;
 }

function formatInIndianStyle($num){
     $pos = strpos((string)$num, ".");
     if ($pos === false) {
        $decimalpart="00";
     }
     if (!($pos === false)) {
        $decimalpart= substr($num, $pos+1, 2); $num = substr($num,0,$pos);
     }

     if(strlen($num)>3 & strlen($num) <= 12){
         $last3digits = substr($num, -3 );
         $numexceptlastdigits = substr($num, 0, -3 );
         $formatted = $this->makeComma($numexceptlastdigits);
         $stringtoreturn = $formatted.",".$last3digits.".".$decimalpart ;
     }elseif(strlen($num)<=3){
        $stringtoreturn = $num.".".$decimalpart ;
     }elseif(strlen($num)>12){
        $stringtoreturn = number_format($num, 2);
     }

     if(substr($stringtoreturn,0,2)=="-,"){
        $stringtoreturn = "-".substr($stringtoreturn,2 );
     }

     return $stringtoreturn;
 }


	function getPaymentStatus($studentid,$fcid){
                $db =& JFactory::getDBO();
		$sql="select status from #__feecollectionmaster WHERE studentid ='".$studentid."' AND fcid='".$fcid."'";
                $db->setQuery( $sql );
                $srec= $db->loadObject();
                return $srec->status;
	}	

   	function getPaymentStatus1($studentid,$fcid,$gid){
                $db =& JFactory::getDBO();
                $sql="select status from #__feecollectionmaster WHERE studentid ='".$studentid."' AND gid='".$gid."' AND fcid='".$fcid."'";
                $db->setQuery( $sql );
                $srec= $db->loadObject();
                return $srec->status;
        }



        function getGroupIDs($studentid,$fcid){
                $db =& JFactory::getDBO();
                $sql="select gid from #__feecollectionmaster WHERE studentid ='".$studentid."' AND fcid='".$fcid."' AND gid IS NOT NULL";
                $db->setQuery( $sql );
                $srecs= $db->loadObjectList();
                return $srecs;
        }

	function getClassByStudent($studentid){
                $db =& JFactory::getDBO();
		$sql="select * from #__courses WHERE aid in (select id FROM #__academicyears where status='Y') and  id IN (SELECT classid FROM #__studentclass WHERE studentid='".$studentid."')";
                $db->setQuery( $sql );
                $class= $db->loadObject();
                return $class;
	}


       function getAllStudents() {
                $db =& JFactory::getDBO();
                $query = "SELECT * FROM #__students WHERE id IN (SELECT studentid FROM #__studentclass WHERE classid IN (SELECT id FROM #__courses WHERE aid IN (SELECT id FROM #__academicyears  WHERE status='Y'))) ORDER BY id";
                $db->setQuery( $query );
                $students = $db->loadObjectList();
                return $students;
        }

        function getCurrentGroups()
        {
                $db =& JFactory::getDBO();
                $query = "SELECT id,groupname,groupcode,purpose,description FROM #__studentgroups WHERE aid = (SELECT id FROM #__academicyears WHERE status='Y')";
                $db->setQuery( $query );
                $groups = $db->loadObjectList();
                return $groups;
        }



//Fee Categories
	function getFeeCategory($pid,&$rec) {
                $q = "SELECT id,name,description FROM #__feecategory WHERE id ='".$pid."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
        }



        function getFeeCategoryAmountByStudent($fcid,$studentid,&$amount) {
		$q = "SELECT sum(amount) as amount FROM #__feeparticulars WHERE fcid ='".$fcid."' AND (id IN (SELECT fpid FROM #__coursefeeparticular WHERE cid IN (SELECT classid FROM #__studentclass WHERE studentid='".$studentid."')) OR id IN (SELECT fpid FROM #__groupfeeparticular WHERE gid IN (SELECT gid FROM #__groupmembers WHERE sid ='".$studentid."')))";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                $amount=$rec->amount;
                return true;
        }

	

	function getFeeCategoryAmount($pid,&$amount) {
                $q = "SELECT sum(amount) AS amount FROM #__feeparticulars WHERE fcid ='".$pid."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
		$amount=$rec->amount;
                return true;
        }

        function addFeeCategory($name,$pdescription) {
                $q = "INSERT INTO #__feecategory(name,description,aid) VALUES('".$name."','".$pdescription."',(SELECT id FROM #__academicyears WHERE status='Y'))";
        	$db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

        function addFeeCategory1($name,$pdescription,&$fcid) {
                $q = "INSERT INTO #__feecategory(name,description,aid) VALUES('".$name."','".$pdescription."',(SELECT id FROM #__academicyears WHERE status='Y'))";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                $query = "SELECT id  FROM #__feecategory ORDER BY id DESC LIMIT 1";
                $db->setQuery( $query );
                $rec= $db->loadObject();
		$fcid=$rec->id;
                return true;
        }


        function updateFeeCategory($pid,$name,$pdescription) {
                $q = "UPDATE #__feecategory SET name='".$name."', description='".$pdescription."' WHERE id=".$pid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }


        function deleteFeeStructure($pfstid) {
		$rs=$this->deleteFeeCategoriesByFeeStructure($pfstid);
		if($rs){
	                $q = 'DELETE FROM #__feestructures WHERE id IN ('.$pfstid.')';
        	        $db = & JFactory::getDBO();
                	$db->setQuery($q);
	                if(!$db->query())
        	                return false;
                	return true;
		}else	return false;
        }

        function deleteFeeCategoriesByFeeStructure($pfstid) {
		$q = "DELETE FROM #__feecategory WHERE id IN (SELECT fcid FROM #__feecategorystructures WHERE fstid='".$pfstid."')";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }


        function deleteFeeCategory($pid) {
                $q = 'DELETE FROM #__feecategory WHERE id IN ('.$pid.')';
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

	function getFeeCategories() {
		$db =& JFactory::getDBO();
		$query = "SELECT id,name,description FROM #__feecategory WHERE aid = (SELECT id FROM #__academicyears WHERE status='Y')";
		$db->setQuery( $query );
		$res= $db->loadObjectList();
		return $res;
    	}




//Fee Particulars
        function getFeeParticular($ppid,&$rec) {
                $q = "SELECT id,name,description,amount,accountid,groupbased FROM #__feeparticulars WHERE id ='".$ppid."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
        }

	function addFeeParticular($pname,$pdescription,$pamount,$accountid,$pfcid,$gb) {
                $q = "INSERT INTO #__feeparticulars(name,description,amount,accountid,fcid,groupbased) VALUES('".$pname."','".$pdescription."','".$pamount."','".$accountid."','".$pfcid."','".$gb."')";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

        function updateFeeParticular1($pid,$pamount) {
                $q = "UPDATE #__feeparticulars SET amount='".$pamount."' WHERE id=".$pid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }


        function updateFeeParticular($pid,$pname,$pdescription,$accountid,$pamount,$gb) {
                $q = "UPDATE #__feeparticulars SET name='".$pname."', description='".$pdescription."', accountid='".$accountid."', amount='".$pamount."', groupbased='".$gb."' WHERE id=".$pid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }


        function deleteFeeParticular($pid) {
                $q = 'DELETE FROM #__feeparticulars WHERE id IN ('.$pid.')';
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query()){
			if($db->getErrorNum()) {
				//
			}

                        return false;
		}
                return true;
        }


        function getFeeParticularsByStudent($pfcid,$studentid) {
                $db =& JFactory::getDBO();
		$query = "SELECT * FROM #__feeparticulars WHERE fcid ='".$pfcid."' AND (id IN (SELECT fpid FROM #__coursefeeparticular WHERE cid IN (SELECT classid FROM #__studentclass WHERE studentid='".$studentid."')) OR id IN (SELECT fpid FROM #__groupfeeparticular WHERE gid IN (SELECT gid FROM #__groupmembers WHERE sid ='".$studentid."')))";
                $db->setQuery( $query );
                $res= $db->loadObjectList();
                return $res;
        }


	function getFeeParticulars($pfcid) {
                $db =& JFactory::getDBO();
                $query = "SELECT id,name,description, amount,accountid,groupbased  FROM #__feeparticulars WHERE fcid=".$pfcid;
                $db->setQuery( $query );
                $res= $db->loadObjectList();
                return $res;
        }

        function getFeeParticulars1($paccountid,$pfcid) {  //If all accounts selected then it is -1 otherwise id of account
                $db =& JFactory::getDBO();
		if($paccountid=="-1")
                	$query = "SELECT id,name,description, amount,accountid,groupbased  FROM #__feeparticulars WHERE fcid=".$pfcid;
		else
              		$query = "SELECT id,name,description, amount,accountid,groupbased  FROM #__feeparticulars WHERE accountid='".$paccountid."' AND fcid='".$pfcid."'";
                $db->setQuery( $query );
                $res= $db->loadObjectList();
                return $res;
        }


	function getFeeCategoryCourseParticulars($fcid,&$recs){
		$query = "SELECT id FROM #__feeparticulars WHERE fcid ='".$fcid."' AND groupbased='0' AND  fcid IN (SELECT id FROM #__feecategory WHERE aid IN (SELECT id FROM #__academicyears WHERE status='Y'))";
                $db =& JFactory::getDBO();
                $db->setQuery( $query );
                $recs = $db->loadObjectList();
                if($recs==null)
                        return false;
                return true;
	}

	function assignFeeCourseParticular($fpid,$cid){
                $q = "INSERT INTO #__coursefeeparticular(fpid,cid) VALUES(".$fpid.",".$cid.")";
        	$db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
	}


//Fee Accounts
	function addFeeAccount($ptitle,$pcode,$pfeeprefix,$preceiptno) {
                $q = "INSERT INTO #__feeaccounts(title,code,aid,feeprefix,receiptno) VALUES('".$ptitle."','".$pcode."',(SELECT id FROM #__academicyears WHERE status='Y' LIMIT 1),'".$pfeeprefix."','".$preceiptno."')";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }


        function getFeeAccount($ppid,&$rec) {
                $q = "SELECT id,title,code,aid,feeprefix,receiptno FROM #__feeaccounts WHERE id ='".$ppid."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
        }


        function deleteFeeAccount($pid) {
                $q = 'DELETE FROM #__feeaccounts WHERE id IN ('.$pid.')';
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

        function updateFeeAccount($pid,$ptitle,$pcode,$pfeeprefix,$preceiptno) {
                $q = "UPDATE #__feeaccounts SET title='".$ptitle."', code='".$pcode."', feeprefix='".$pfeeprefix."', receiptno='".$preceiptno."' WHERE id=".$pid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
	}

	function getFeeAccounts() {
                $db =& JFactory::getDBO();
                $query = "SELECT id,title,code,aid,feeprefix,receiptno  FROM #__feeaccounts WHERE aid IN (SELECT id FROM #__academicyears WHERE status='Y')";
                $db->setQuery( $query );
                $res= $db->loadObjectList();
                return $res;
        }

//Fee Courses
	function assignFeeCourse($fcid,$cid){
                $q = "INSERT INTO #__coursefeecategory(fcid,cid) VALUES(".$fcid.",".$cid.")";
        	$db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
	}

	function getFeeCategoryCourses($fcid){
		$db =& JFactory::getDBO();
		$query = "SELECT id,coursename,sectionname,code,assessmenttype, filename FROM #__courses WHERE id IN ( SELECT cid  FROM #__coursefeecategory WHERE fcid =".$fcid.")";
		$db->setQuery( $query );
		$res= $db->loadObjectList();
		return $res;
	}

        function getFeeCategoryParticularCourses($fpid){
                $db =& JFactory::getDBO();
                $query = "SELECT id,coursename,sectionname,code,assessmenttype, filename FROM #__courses WHERE id IN ( SELECT cid  FROM #__coursefeeparticular WHERE fpid =".$fpid.")";
                $db->setQuery( $query );
                $res= $db->loadObjectList();
                return $res;
        }



  	function getFeeCategoryGroups($fcid){
                $db =& JFactory::getDBO();
                $query = "SELECT id,groupcode,groupname FROM #__studentgroups WHERE id IN ( SELECT gid  FROM #__groupfeecategory WHERE fcid =".$fcid.")";
                $db->setQuery( $query );
                $res= $db->loadObjectList();
                return $res;
        }


        function getFeeParticularGroups($fpid){
                $db =& JFactory::getDBO();
                $query = "SELECT id,groupcode,groupname FROM #__studentgroups WHERE aid IN (SELECT id FROM #__academicyears WHERE status='Y')  AND id IN ( SELECT gid  FROM #__groupfeeparticular WHERE fpid =".$fpid.")";
                $db->setQuery( $query );
                $res= $db->loadObjectList();
                return $res;
        }



	function getGroupFineCollected($gid,$head,&$fine){
		$sql = "SELECT Sum(fine) as fine from #__feecollectionmaster where fcid IN (SELECT id FROM #__feecategory WHERE description='".$head."') and gid='".$gid."'";
                $db =& JFactory::getDBO();
                $db->setQuery( $sql);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                $fine=$rec->fine;
                return true;
	}


        function getGroupFeeCategoriesByHead($head,$gid){
                $db =& JFactory::getDBO();
                $query = "SELECT id,name,description FROM #__feecategory WHERE id IN (SELECT fcid FROM #__groupfeecategory WHERE gid='".$gid."') AND trim(description)=trim('".$head."')";
                $db->setQuery( $query );
                $res= $db->loadObjectList();
                return $res;
        }


        function getCourseFeeParticularsByHead($head,$cid){
                $db =& JFactory::getDBO();
//                $query = "SELECT id,name,description FROM #__feecategory WHERE id IN (SELECT fcid FROM #__coursefeecategory WHERE cid='".$cid."') AND trim(description)=trim('".$head."')";
		$query = " select * from #__feeparticulars WHERE trim(description) =trim('".$head."')  and id in (SELECT fpid FROM #__coursefeeparticular where cid ='".$cid."')";
                $db->setQuery( $query );
                $res= $db->loadObjectList();
                return $res;
        }


        function getCourseFeeParticular($accountid,$cid,$fpid,&$rec){
                $db =& JFactory::getDBO();
		if($accountid=="-1")
                	$query = "SELECT * FROM  #__feeparticulars WHERE id = '".$fpid."' AND id IN (SELECT fpid FROM #__coursefeeparticular WHERE cid ='".$cid."')";
		else
                	$query = "SELECT * FROM  #__feeparticulars WHERE accountid='".$accountid."' AND  id = '".$fpid."' AND id IN (SELECT fpid FROM #__coursefeeparticular WHERE cid ='".$cid."')";
                $db->setQuery( $query );
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
        }


        function getCourseFeeCategoriesByHead($head,$cid){
                $db =& JFactory::getDBO();
                $query = "SELECT id,name,description FROM #__feecategory WHERE id IN (SELECT fcid FROM #__coursefeecategory WHERE cid='".$cid."') AND trim(description)=trim('".$head."')";
                $db->setQuery( $query );
                $res= $db->loadObjectList();
                return $res;
        }


        function getGroupFeeHeads(){
                $db =& JFactory::getDBO();
                $query = "SELECT distinct description FROM #__feecategory_t WHERE groupbased = '1'";
                $db->setQuery( $query );
                $res= $db->loadObjectList();
                return $res;
        }


        function getFeeParticularHeads($accountid){
                $db =& JFactory::getDBO();
		if($accountid=="-1")
	                $query = "SELECT distinct description FROM #__feeparticulars WHERE accountid IN (SELECT id FROM #__feeaccounts WHERE aid IN (SELECT id FROM #__academicyears WHERE status='Y'))";
		else
	                $query = "SELECT distinct description FROM #__feeparticulars WHERE accountid IN ('".$accountid."')";
                $db->setQuery( $query );
                $res= $db->loadObjectList();
                return $res;
        }


        function getClassFeeHeads(){
                $db =& JFactory::getDBO();
                $query = "SELECT distinct description FROM #__feecategory_t WHERE groupbased='0'";
                $db->setQuery( $query );
                $res= $db->loadObjectList();
                return $res;
        }


	function getFeeHeads(){
                $db =& JFactory::getDBO();
                $query = "SELECT distinct description FROM #__feecategory_t";
                $db->setQuery( $query );
                $res= $db->loadObjectList();
                return $res;
	}


	function getCourseFeeCategories($cid){
                $db =& JFactory::getDBO();
                $query = "SELECT id,name,description FROM #__feecategory WHERE id IN (SELECT fcid FROM #__coursefeecategory WHERE cid = ".$cid.")";
                $db->setQuery( $query );
                $res= $db->loadObjectList();
                return $res;
        }

        function deleteFeeGroup($fcid,$gid)
        {
                $q = 'DELETE FROM #__groupfeecategory WHERE fcid='.$fcid.' AND gid='.$gid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

        function deleteFeeParticularGroup($fpid,$gid)
        {
                $q = 'DELETE FROM #__groupfeeparticular WHERE fpid='.$fpid.' AND gid='.$gid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }



        function deleteFeeCourse($fcid,$cid)
        {
                $q = "DELETE FROM #__coursefeecategory WHERE fcid='".$fcid."' AND cid='".$cid."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

        function deleteFeeCourseParticular($fpid,$cid)
        {
                $q = 'DELETE FROM #__coursefeeparticular WHERE fpid='.$fpid.' AND cid='.$cid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

    	function deleteFeeCourseParticulars($cid)
        {
                $q = 'DELETE FROM #__coursefeeparticular WHERE cid='.$cid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

        function deleteFeeCourseParticulars1($cid,$fcid)
        {
                $q = "DELETE FROM #__coursefeeparticular WHERE cid='".$cid."' AND fpid IN (SELECT id FROM #__feeparticulars where fcid ='".$fcid."')";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }




//Fee Discounts
	function getFeeCategoryDiscounts($fcid){
                $db =& JFactory::getDBO();
                $query = "SELECT id,scid,cid,discount FROM #__feediscounts WHERE fcid =".$fcid; 
                $db->setQuery( $query );
                $res= $db->loadObjectList();
                return $res;
	}

	function getStudentFeeCategoryDiscounts($scid,$cid,$fcid,&$amount){
                $db =& JFactory::getDBO();
                $query = "SELECT id,discount FROM #__feediscounts WHERE scid=".$scid." AND cid=".$cid." AND fcid =".$fcid; 
                $db->setQuery( $query );
                $res= $db->loadObject();
		if($res==null)
			return false;
		$amount=$res->discount;
                return true;
	}

        function addFeeDiscount($fcid,$scid,$cid,$discount)
        {
                $q = "INSERT INTO #__feediscounts(fcid,scid,cid,discount) VALUES(".$fcid.",".$scid.",".$cid.",".$discount.")";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

        function updateFeeDiscount($id,$discount)
        {
                $q = "UPDATE #__feediscounts SET discount=".$discount." WHERE id=".$id;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

        function deleteFeeDiscount($id)
        {
                $q = 'DELETE FROM #__feediscounts WHERE id='.$id;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

//Fee Concession
        function getFeeConcession($cid){
                $db =& JFactory::getDBO();
                $query = "SELECT id,studentid,fcid,amount FROM #__feeconcession WHERE cid =".$cid;
                $db->setQuery( $query );
                $res= $db->loadObjectList();
                return $res;
        }

        function getStudentFeeConcession($sid,$fcid,$cid,&$amount){
                $db =& JFactory::getDBO();
                $query = "SELECT id,amount FROM #__feeconcession WHERE studentid=".$sid." and fcid=".$fcid." and cid =".$cid;
                $db->setQuery( $query );
                $rec= $db->loadObject();
                if($rec==null)
                        return false;
		$amount=$rec->amount;
                return true;
        }


        function getStudentGroupFeeConcession($sid,$fcid,$gid,&$amount){
                $db =& JFactory::getDBO();
                $query = "SELECT id,amount FROM #__groupfeeconcession WHERE studentid=".$sid." and fcid=".$fcid." and gid =".$gid;
                $db->setQuery( $query );
                $rec= $db->loadObject();
                if($rec==null)
                        return false;
                $amount=$rec->amount;
                return true;
        }



        function addFeeConcession($fcid,$studentid,$cid,$amount) {
                $q = "INSERT INTO #__feeconcession(fcid,studentid,cid,amount) VALUES(".$fcid.",".$studentid.",".$cid.",".$amount.")";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }


        function addGroupFeeConcession($fcid,$studentid,$gid,$amount) {
                $q = "INSERT INTO #__groupfeeconcession(fcid,studentid,gid,amount) VALUES(".$fcid.",".$studentid.",".$gid.",".$amount.")";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

	function updateFeeConcession($id,$amount) {
                $q = "UPDATE #__feeconcession SET amount='".$amount."' WHERE id=".$id;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }


        function updateGroupFeeConcession1($fcid,$studentid,$gid,$amount) {
                $q = "UPDATE #__groupfeeconcession SET amount='".$amount."' WHERE fcid='".$fcid."' AND gid='".$gid."' AND studentid='".$studentid."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }


        function updateFeeConcession1($fcid,$studentid,$cid,$amount) {
                $q = "UPDATE #__feeconcession SET amount='".$amount."' WHERE fcid='".$fcid."' AND cid='".$cid."' AND studentid='".$studentid."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

        function deleteFeeConcession($id) {
                $q = 'DELETE FROM #__feeconcession WHERE id='.$id;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
	}

//Fee Schedule
        function addFeeSchedule($fcid,$cid,$fdate,$fine,$gid) {
		if($cid=="-") 
	                $q = "INSERT INTO #__feeschedule(fcid,fdate,fine,gid) VALUES(".$fcid.",'".$fdate."','".$fine."','".$gid."')";
		else
	                $q = "INSERT INTO #__feeschedule(fcid,cid,fdate,fine) VALUES(".$fcid.",".$cid.",'".$fdate."','".$fine."')";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }


        function getFineAmount1($gid,$fcid,&$fine){
                $query = "SELECT fine FROM #__feeschedule WHERE fdate < current_date AND gid =".$gid." AND fcid=".$fcid;
                $db =& JFactory::getDBO();
                $db->setQuery( $query );
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                $fine=$rec->fine;
                return true;
        }


	function getFineAmount($cid,$fcid,&$fine){
                $query = "SELECT fine FROM #__feeschedule WHERE fdate < current_date AND cid =".$cid." AND fcid=".$fcid;
                $db =& JFactory::getDBO();
                $db->setQuery( $query );
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
		$fine=$rec->fine;
                return true;
	}

        function getGroupFeeSchedule($gid,$fcid,&$rec){
                $query = "SELECT id,fcid,cid,fdate,fine,gid FROM #__feeschedule WHERE gid =".$gid." AND fcid=".$fcid;
                $db =& JFactory::getDBO();
                $db->setQuery( $query );
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
        }


	function getFeeSchedule($cid,$fcid,&$rec){
                $query = "SELECT id,fcid,cid,fdate,fine FROM #__feeschedule WHERE cid =".$cid." AND fcid=".$fcid;
                $db =& JFactory::getDBO();
                $db->setQuery( $query );
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
        }

        function updateFeeSchedule($id,$fdate,$fine) {
                $q = "UPDATE #__feeschedule SET fdate='".$fdate."', fine=".$fine."  WHERE id=".$id;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

	function getFeeSchedules(&$recs){
		$query = "SELECT id,fcid,cid,DATE_FORMAT(fdate,'%d %M, %Y') as fdate,fine,gid FROM #__feeschedule WHERE fcid IN (SELECT id FROM #__feecategory WHERE aid = (SELECT id FROM #__academicyears WHERE status='Y')) ORDER BY fdate ASC";
                $db =& JFactory::getDBO();
                $db->setQuery( $query );
                $recs = $db->loadObjectList();
                if($recs==null)
                        return false;
                return true;
	}

//Fee Amount - MASTER
        function getFeeMaster($fcid,$cid,$studentid,&$rec) {
                $q = "SELECT id,DATE_FORMAT(paiddate,'%d %M, %Y') as paiddate,fine,paidamount,status,remarks FROM #__feecollectionmaster WHERE fcid =".$fcid." AND cid=".$cid." AND studentid=".$studentid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
        }


  	function getFeeMaster1($fcid,$cid,$gid,$studentid,&$rec) {
                $q = "SELECT id,DATE_FORMAT(paiddate,'%d %M, %Y') as paiddate,fine,paidamount,status,remarks FROM #__feecollectionmaster WHERE fcid =".$fcid." AND cid='".$cid."' AND gid=".$gid." AND studentid=".$studentid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
        }



        function getFeeMasterDueList1($fcid,$gid,&$recs){
                $q = "SELECT studentid,remarks,paidamount  FROM #__feecollectionmaster WHERE fcid =".$fcid." AND gid='".$gid."' AND status='0'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $recs = $db->loadObjectList();
                if($recs==null)
                        return false;
                return true;
        }


	function getFeeMasterDueList($fcid,$cid,&$recs){
                $q = "SELECT studentid,remarks,paidamount  FROM #__feecollectionmaster WHERE fcid =".$fcid." AND cid=".$cid." AND status='0'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $recs = $db->loadObjectList();
                if($recs==null)
                        return false;
                return true;
	}


        function updateFeeMasterRemarks($mid,$remarks){
                $q = "UPDATE #__feecollectionmaster SET remarks='".$remarks."' WHERE id = ".$mid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
	}
	
        function updateFeeMasterStatus($fcid,$studentid,$cid,$fine,$discount,$concession){
                $q = "UPDATE #__feecollectionmaster SET status='1',fine='".$fine."', discount='".$discount."', concession='".$concession."' WHERE fcid = '".$fcid."' AND studentid = '".$studentid."' AND cid = '".$cid."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
	}

	
        function updateFeeMasterStatus1($fcid,$studentid,$cid,$gid,$fine,$discount,$concession){
                $q = "UPDATE #__feecollectionmaster SET status='1',fine=".$fine.", discount=".$discount.", concession=".$concession." WHERE fcid = ".$fcid." AND studentid = ".$studentid." AND gid='".$gid."' AND cid = ".$cid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }


	function insertFeeReceipt($fcid,$studentid,$cid){
                $q = "INSERT INTO #__feereceipt(fcid,studentid,courseid,cdate) VALUES(".$fcid.",".$studentid.",".$cid.",current_date)";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
	}


        function setNewReceiptNo($aid,$rno){
                $q = "UPDATE #__feeaccounts SET receiptno='".$rno."'where id=".$aid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }


	function getReceiptInfo($rno,&$rec){
                $q = "SELECT * FROM #__feecollectiontransaction WHERE receiptno='".$rno."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
	}

//Fee Amount - TRANS
	
        function addFeeTransaction($fcid,$studentid,$cid,$paidnow,$paymentmode,$chequeorddno,$chequeordddate,$bankdetails,$receiptno,&$obj){
                $q = "INSERT INTO #__feecollectiontransaction(fcid,studentid,cid,paiddate,paidamount,paymentmode,chequeorddno,chequeordddate,bankname,receiptno) VALUES(".$fcid.",".$studentid.",".$cid.",current_date,".$paidnow.",'".$paymentmode."','".$chequeorddno."','".$chequeordddate."','".$bankdetails."','".$receiptno."')";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
		$q = "SELECT LAST_INSERT_ID() as fctid";
		$db->setQuery($q);
                $obj = $db->loadObject();
                if($obj==null)
                        return false;
                return true;
		
	}


        function addFeeTransaction1($fcid,$studentid,$cid,$gid,$paidnow,$paymentmode,$chequeorddno,$chequeordddate,$bankdetails,$receiptno,&$obj){
                $q = "INSERT INTO #__feecollectiontransaction(fcid,studentid,cid,paiddate,paidamount,paymentmode,chequeorddno,chequeordddate,bankname,receiptno,gid) VALUES(".$fcid.",".$studentid.",".$cid.",current_date,".$paidnow.",'".$paymentmode."','".$chequeorddno."','".$chequeordddate."','".$bankdetails."','".$receiptno."','".$gid."')";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
		$q = "SELECT LAST_INSERT_ID() as fctid";
		$db->setQuery($q);
                $obj = $db->loadObject();
                if($obj==null)
                        return false;
                return true;

        }



        function getFeeTransaction($rno,&$rec) {
                $q = "SELECT DATE_FORMAT(paiddate,'%d %M, %Y') AS paiddate,receiptno,paidamount,paymentmode,chequeorddno,chequeordddate,bankname FROM #__feecollectiontransaction WHERE receiptno='".$rno."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
        }


        function getFeeTransactions($fcid,$cid,$studentid,&$recs) {
                $q = "SELECT DATE_FORMAT(paiddate,'%d %M, %Y') AS paiddate,receiptno,paidamount,paymentmode,chequeorddno,chequeordddate,bankname FROM #__feecollectiontransaction WHERE fcid =".$fcid." AND cid=".$cid." AND studentid=".$studentid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $recs = $db->loadObjectList();
                if($recs==null)
                        return false;
                return true;
        }



        function getFeeTransactions1($fcid,$cid,$studentid,$gid,&$recs) {
                $q = "SELECT DATE_FORMAT(paiddate,'%d %M, %Y') AS paiddate,receiptno,paidamount,paymentmode,chequeorddno,chequeordddate,bankname FROM #__feecollectiontransaction WHERE fcid =".$fcid." AND cid=".$cid." AND gid='".$gid."' AND studentid=".$studentid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $recs = $db->loadObjectList();
                if($recs==null)
                        return false;
                return true;
        }

	function getNewReceiptNo(&$rec){	
		$q="SELECT MAX(id)+1 AS newreceiptno FROM #__feereceipt";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
	}

//Fee Categories  temp
	function getFeeCategory_t($pid,&$rec) {
                $q = "SELECT id,name,description FROM #__feecategory_t WHERE id ='".$pid."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
        }
	function getFeeCategoryAmount_t($pid,&$amount) {
                $q = "SELECT sum(amount) AS amount FROM #__feeparticulars_t WHERE fcid ='".$pid."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
		$amount=$rec->amount;
                return true;
        }
        function addFeeCategory_t($name,$pdescription) {
                $q = "INSERT INTO #__feecategory_t(name,description,aid) VALUES('".$name."','".$pdescription."',(SELECT id FROM #__academicyears WHERE status='Y'))";
        	$db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }
        function updateFeeCategory_t($pid,$name,$pdescription) {
                $q = "UPDATE #__feecategory_t SET name='".$name."',  description='".$pdescription."' WHERE id=".$pid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }
        function deleteFeeCategory_t($pid) {
                $q = 'DELETE FROM #__feecategory_t WHERE id IN ('.$pid.')';
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }
	function getFeeCategories_t() {
		$db =& JFactory::getDBO();
		$query = "SELECT id,name,description FROM #__feecategory_t WHERE groupbased=0 and aid = (SELECT id FROM #__academicyears WHERE status='Y')";
		$db->setQuery( $query );
		$res= $db->loadObjectList();
		return $res;
    	}
        function getFeeCategories_tt() {
                $db =& JFactory::getDBO();
                $query = "SELECT id,name,description FROM #__feecategory_t WHERE aid = (SELECT id FROM #__academicyears WHERE status='Y')";
                $db->setQuery( $query );
                $res= $db->loadObjectList();
                return $res;
        }





//Fee Particulars  temp
        function getFeeParticular_t($ppid,&$rec) {
                $q = "SELECT id,name,description,accountid,amount,groupbased FROM #__feeparticulars_t WHERE id ='".$ppid."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
        }

	function addFeeParticular_t($pname,$pdescription,$pamount,$accountid,$pfcid,$pgroupbased) {
                $q = "INSERT INTO #__feeparticulars_t(name,description,amount,accountid,fcid,groupbased) VALUES('".$pname."','".$pdescription."','".$pamount."','".$accountid."','".$pfcid."','".$pgroupbased."')";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

        function updateFeeParticular_t($pid,$pname,$pdescription,$accountid,$pamount,$pgroupbased) {
                $q = "UPDATE #__feeparticulars_t SET name='".$pname."', description='".$pdescription."', accountid='".$accountid."', amount='".$pamount."', groupbased='".$pgroupbased."' where id=".$pid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

        function deleteFeeParticular_t($pid) {
                $q = 'DELETE FROM #__feeparticulars_t WHERE id IN ('.$pid.')';
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

	function cancelReceipt($rno){
                $q = "DELETE FROM #__feecollectiontransaction WHERE receiptno IN ('".$rno."')";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
	}

	function getFeeParticulars_t($pfcid) {
                $db =& JFactory::getDBO();
                $query = "SELECT id,name,description, accountid,amount,groupbased  FROM #__feeparticulars_t WHERE fcid=".$pfcid;
                $db->setQuery( $query );
                $res= $db->loadObjectList();
                return $res;
        }


//FEE STRUCTURES

     	function getFeeStructures() {
                $db =& JFactory::getDBO();
                $query = "SELECT id,title,aid  FROM #__feestructures where aid IN (SELECT id FROM ya_academicyears WHERE status='Y')";
                $db->setQuery( $query );
                $res= $db->loadObjectList();
                return $res;
        }


	function addFeeStructure($title,&$fstid) {
                $q = "INSERT INTO #__feestructures(title,aid) VALUES('".$title."',(SELECT id FROM #__academicyears WHERE status='Y'))";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                $query = "SELECT id  FROM #__feestructures ORDER BY id DESC LIMIT 1";
                $db->setQuery( $query );
                $res= $db->loadObject();
		$fstid=$res->id;
                return true;
	}


    	function getFeeStructure($fstid,&$rec) {
                $q = "SELECT id,title,aid FROM #__feestructures WHERE id ='".$fstid."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
        }

	function addFeeCategoryStructure($fstid,$fcid) {
                $q = "INSERT INTO #__feecategorystructures(fstid,fcid) VALUES('".$fstid."','".$fcid."')";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
	}

        function updateFeeStructure($pid,$title) {
                $q = "UPDATE #__feestructures SET title='".$title."' WHERE id='".$pid."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

        function getFeeCategoriesByStructure($fstid) {
                $db =& JFactory::getDBO();
                $query = "SELECT id,name,description FROM #__feecategory WHERE id IN (SELECT fcid FROM #__feecategorystructures WHERE fstid ='".$fstid."')";
                $db->setQuery( $query );
                $res= $db->loadObjectList();
                return $res;
        }
	
	function getFeeStructureByFeeCategory($fcid){
                $db =& JFactory::getDBO();
		$query = "select title from #__feestructures  WHERE id IN (SELECT fstid FROM ya_feecategorystructures where fcid IN(SELECT id FROM ya_feecategory where id='".$fcid."'))";
                $db->setQuery( $query );
                $recs= $db->loadObjectList();
                return $recs;
	}

	function getFeeCategoriesByStudent($studentid){
                $db =& JFactory::getDBO();
//		$sql="SELECT id,name,groupbased FROM #__feecategory WHERE aid IN (SELECT id FROM #__academicyears WHERE status='Y') AND (id IN (SELECT fcid FROM #__coursefeecategory WHERE cid IN (SELECT classid FROM #__studentclass WHERE studentid='".$studentid."'))) OR (id IN (SELECT fcid FROM #__groupfeecategory WHERE gid IN (SELECT gid FROM #__groupmembers WHERE sid='".$studentid."')))";
		$sql="SELECT id,name FROM #__feecategory WHERE aid IN (SELECT id FROM #__academicyears WHERE status='Y') AND id IN (SELECT fcid FROM #__coursefeecategory WHERE cid IN (SELECT classid FROM #__studentclass WHERE studentid='".$studentid."'))";
                $db->setQuery( $sql);
                $recs= $db->loadObjectList();
                return $recs;
	}


        function getGroupFeeCategoriesByStudent($studentid){
                $db =& JFactory::getDBO();
                $sql="SELECT id,name,groupbased FROM #__feecategory WHERE groupbased=1 and aid IN (SELECT id FROM #__academicyears WHERE status='Y') AND id IN (SELECT fcid FROM #__groupfeecategory WHERE gid IN (SELECT gid FROM #__groupmembers WHERE sid='".$studentid."'))";
                $db->setQuery( $sql);
                $recs= $db->loadObjectList();
                return $recs;
        }

        function getFeeCategoryGroups1($fcid){
                $db =& JFactory::getDBO();
		$sql = "SELECT groupcode,groupname,id from #__studentgroups where aid in (select id from #__academicyears where status='Y') AND id IN (SELECT gid FROM #__groupfeecategory WHERE fcid ='".$fcid."')";
                $db->setQuery( $sql);
                $recs= $db->loadObjectList();
                return $recs;
        }




        function getGroupCollectionDatewise($gid,$fcid,$fromdate,$todate){
                $db =& JFactory::getDBO();
                $sql= "SELECT count(*) as scount, sum(paidamount) as paidamount,sum(concession) as concession,sum(discount) as discount,sum(fine) as fine from #__feecollectionmaster where (gid = '".$gid."' ) AND (fcid='".$fcid."') AND (paidamount>0) AND (paiddate BETWEEN '".$fromdate."' AND '".$todate."')";
                $db->setQuery( $sql);
                $rec= $db->loadObject();
                return $rec;
        }


	function getClassCollectionDatewise($classid,$fcid,$fromdate,$todate){
                $db =& JFactory::getDBO();
		$sql= "SELECT count(*) as scount, sum(paidamount) as paidamount,sum(concession) as concession,sum(discount) as discount,sum(fine) as fine from ya_feecollectionmaster where (cid = '".$classid."' ) AND (fcid='".$fcid."') AND (paidamount>0) AND (paiddate BETWEEN '".$fromdate."' AND '".$todate."')";
                $db->setQuery( $sql);
                $rec= $db->loadObject();
                return $rec;
	}



	function getFeeCollectionDatewise($cdate){
		$sql="SELECT studentid,fcid,paidamount,(SELECT name FROM #__feecategory WHERE id=fcid) as feetitle,(SELECT code FROM #__courses where id=cid) as coursename, (select concat_ws(' ',firstname,middlename,lastname,initial) FROM #__students where id= studentid) as studentname,receiptno  FROM #__feecollectiontransaction where paiddate = '".$cdate."' ORDER BY cid";
                $db =& JFactory::getDBO();
                $db->setQuery( $sql);
                $recs= $db->loadObjectList();
                return $recs;

	}


	function getDatewiseCollection($head,$cdate,&$amount){
		$sql="SELECT sum(paidamount)  as amount from #__feecollectiontransaction WHERE paiddate = '".$cdate."' AND fcid IN (SELECT id FROM #__feecategory WHERE trim(description) = trim('".$head."'))";
                $db =& JFactory::getDBO();
                $db->setQuery( $sql);
                $res= $db->loadObject();
		$amount=$res->amount;
                return true;

	}

 	 function getDatewiseCollection1($fcid,$cdate,&$amount){
                $sql="SELECT sum(paidamount)  as amount from #__feecollectiontransaction WHERE paiddate = '".$cdate."' AND fcid ='".$fcid."'";
                $db =& JFactory::getDBO();
                $db->setQuery( $sql);
                $res= $db->loadObject();
                $amount=$res->amount;
                return true;
        }

	
	function getReceiptNo($studentid,$fcid,$cdate)
	{
                $db =& JFactory::getDBO();
		$sql="SELECT * FROM ya_feecollectionmaster where studentid='".$studentid."' AND fcid='".$fcid."' AND paiddate = '".$cdate."'";
                $db->setQuery( $sql);
                $rec= $db->loadObject();
                return $rec->receiptno;
	}


        function getGroupConcessionList(){
                $sql=" SELECT (SELECT firstname FROM ya_students WHere id=studentid) as studentname, (SELECT name FROM ya_feecategory WHERE id=fcid) as feetitle, (SELECT groupcode FROM ya_studentgroups WHERE id=gid) as groupname, amount, id FROM ya_groupfeeconcession WHERE gid IN (SELECT id FROM ya_studentgroups WHERE aid IN (SELECT id FROM ya_academicyears WHERE status='Y')) ORDER BY gid";
                $db =& JFactory::getDBO();
                $db->setQuery( $sql);
                $recs= $db->loadObjectList();
                return $recs;
        }


	function getConcessionList(){
		$sql=" SELECT (SELECT firstname FROM ya_students WHere id=studentid) as studentname, (SELECT name FROM ya_feecategory WHERE id=fcid) as feetitle, (SELECT code FROM ya_courses WHERE id=cid) as classname, amount, id FROM ya_feeconcession WHERE cid IN (SELECT id FROM ya_courses WHERE aid IN (SELECT id FROM ya_academicyears WHERE status='Y')) ORDER BY cid";
                $db =& JFactory::getDBO();
                $db->setQuery( $sql);
                $recs= $db->loadObjectList();
                return $recs;
	}

	function getAmountByClassHead($cid,$code){
		$sql = "SELECT fcid, sum(paidamount) as paidamount,sum(fine) as fine,sum(concession) as concession, sum(discount) as discount from #__feecollectionmaster where cid='".$cid."' and (gid is NULL OR gid=0) and fcid IN (SELECT id FROM ya_feecategory WHERE trim(description)=trim('".$code."'))";
                $db =& JFactory::getDBO();
                $db->setQuery( $sql);
                $rec= $db->loadObject();
                return $rec;
	}

        function getAmountByGroupHead($gid,$code){
                $sql = "SELECT fcid, sum(paidamount) as paidamount,sum(concession) as concession, sum(fine) as fine,sum(discount) as discount from ya_feecollectionmaster where gid='".$gid."' AND  fcid IN (SELECT id FROM ya_feecategory WHERE trim(description)=trim('".$code."'))";
                $db =& JFactory::getDBO();
                $db->setQuery( $sql);
                $rec= $db->loadObject();
                return $rec;
        }


	function getCurrentFeePrefix(){
		$sql = "SELECT feeprefix FROM #__academicyears WHERE status='Y'";
                $db =& JFactory::getDBO();
                $db->setQuery( $sql);
                $rec= $db->loadObject();
                return $rec;
	}


        function assignFeeGroup($fcid,$gid){
                $q = "INSERT INTO #__groupfeecategory(fcid,gid) VALUES(".$fcid.",".$gid.")";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

        function assignFeeParticularGroup($fpid,$gid){
                $q = "INSERT INTO #__groupfeeparticular(fpid,gid) VALUES(".$fpid.",".$gid.")";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }


	function getGroupMembersCountByClass($fpid,$cid,&$count){
		$sql = " SELECT count(*) as total FROM #__groupmembers where sid IN (SELECT studentid FROM #__studentclass WHERE classid ='".$cid."') and gid IN (SELECT gid FROM #__groupfeeparticular WHERE fpid = '".$fpid."')";	
                $db = & JFactory::getDBO();
                $db->setQuery($sql);
                $count = $db->loadObject()->total;
                if($count==null)
                        return false;
                return true;
	}


	function getGroupMembers($gid){
		$sql="SELECT * FROM #__students WHERE id IN (SELECT sid FROM #__groupmembers WHERE gid = '".$gid."')";
                $db =& JFactory::getDBO();
                $db->setQuery( $sql);
                $recs= $db->loadObjectList();
                return $recs;
	}

        function getGroupRec($pid,&$rec)
        {
                $q = "SELECT id,groupname,groupcode,purpose,description FROM #__studentgroups WHERE id ='".$pid."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
        }

//FEE CONCESSION AND PARTICULARS
	function addFeeTransactionParticular($fctid,$fpid,$amount) {
                $q = "INSERT INTO #__feetransactionparticulars(fctid,fpid,amount) VALUES('".$fctid."','".$fpid."','".$amount."')";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
	}

        function getFeeTransactionParticularAmount($fpid,$studentid,$cid,$fcid,&$rec)
        {
                $q = "select sum(amount) as amount from #__feetransactionparticulars WHERE fpid='".$fpid."' AND fctid IN (SELECT id FROM #__feecollectiontransaction WHERE studentid='".$studentid."' AND fcid='".$fcid."' AND cid='".$cid."') group by fpid";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
        }

        function getFeeTransactionParticulars($fctid,&$recs)
        {
                $q = "select fpid,amount from #__feetransactionparticulars WHERE fctid='".$fctid."'"; 
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $recs = $db->loadObjectList();
                if($recs==null)
                        return false;
                return true;
        }

	function addFeeParticularConcession($studentid,$fpid,$amount) {
                $q = "INSERT INTO #__feeparticularconcession(studentid,fpid,amount) VALUES('".$studentid."','".$fpid."','".$amount."')";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
	}
	function updateFeeParticularConcession($studentid,$fpid,$amount) {
                $q = "UPDATE #__feeparticularconcession SET amount='".$amount."' WHERE studentid='".$studentid."' AND fpid='".$fpid."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }
        function getFeeParticularConcession($studentid,$fpid,&$rec)
        {
                $q = "SELECT id,amount FROM #__feeparticularconcession WHERE studentid ='".$studentid."' AND fpid='".$fpid."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
        }

//FEE COLLECTION

        function getClassParticularPaidAmount($cid,$fcid,$fpid,&$rec)
        {
                $q = "SELECT fpid,sum(amount) as total  FROM #__feetransactionparticulars WHERE fpid= '".$fpid."' and fctid IN (SELECT id FROM #__feecollectiontransaction WHERE fcid = '".$fcid."' AND cid = '".$cid."')";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
        }

        function getStudentGroupCountByParticular($fpid,$studentid,&$rec)
        {
                $q = "SELECT count(*) as tot FROM #__groupfeeparticular where fpid = '".$fpid."' and gid in (select gid from #__groupmembers where sid='".$studentid."')";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
        }
	
        function getDateWiseFeeCollection($fdate,$tdate,&$recs)
        {
                $q = "SELECT paiddate,sum(paidamount) as paidamount  FROM #__feecollectiontransaction  WHERE paiddate BETWEEN '".$fdate."' AND '".$tdate."'  GROUP BY paiddate";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $recs = $db->loadObjectList();
                if($recs==null)
                        return false;
                return true;
        }

	function getClassConcessionAmount($acid, $fcid,$cid,&$rec){
		if($acid=="-1")
	                $q = "SELECT sum(amount) as amount FROM #__feeparticularconcession WHERE studentid IN (SELECT studentid FROM #__studentclass WHERE classid='".$cid."') AND fpid IN (SELECT id FROM #__feeparticulars WHERE fcid='".$fcid."')";
		else
	                $q = "SELECT sum(amount) as amount FROM #__feeparticularconcession WHERE studentid IN (SELECT studentid FROM #__studentclass WHERE classid='".$cid."') AND fpid IN (SELECT id FROM #__feeparticulars WHERE fcid='".$fcid."' AND accountid='".$acid."')";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
	}

        function getFeeCategoryPaidCount($fcid,&$rec)
        {
                $q = "SELECT count(*) AS tot FROM #__feecollectionmaster where paidamount > 0 and fcid='".$fcid."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
	}

}

