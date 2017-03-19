<?php
// No direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.model' );
class CceModelCce extends JModel
{
	function __construct(){
        	parent::__construct();
        }





	function logotitle(){
   		$iconsDir1 = JURI::base() . 'components/com_cce/images';
       		echo '<center><img src="'.$iconsDir1.'/addon.png'.'" alt="Addon" style="width: 300px; height: 30px;" /></center>';
		
	}

        function getMenuItemid($pmenutype='top',$ptitle='Portal',$ptemplate='malita')
        {
 //               $q = "SELECT id FROM #__menu where menutype='".$pmenutype."' and title='".$ptitle."'";
//		$q = "SELECT id FROM #__menu WHERE menutype='".$pmenutype."' AND title='".$ptitlea."' AND  template_style_id IN (SELECT id FROM #__template_styles where template LIKE '%".$ptemplate."%')";
		$q = "SELECT id FROM #__menu WHERE menutype='".'top'."' AND title='".'Portal'."' AND  template_style_id IN (SELECT id FROM #__template_styles where template LIKE '%".'malita'."%')";

                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return $rec->id;
        }


	function footer()
	{
   		$iconsDir1 = JURI::base() . 'components/com_cce/images';
		echo '<br />';
		echo '<br />';
		//echo '<img src="'.$iconsDir1.'/footer.png'.'" alt="footer">';
	}
	
	
	function setSchoolInfo($arrValues){
		$q = "UPDATE #__schoolinfo SET
                schoolname='".mysql_real_escape_string($arrValues['schoolname'])."',
				schooladdress='".$arrValues['schooladdress']."',
				schoolphone='".$arrValues['schoolphone']."',
				board='".$arrValues['board']."',
				educationdistrict='".$arrValues['educationdistrict']."',
				revenuedistrict='".$arrValues['revenuedistrict']."',
				showresult='".$arrValues['showresult']."',
				showgrades='".$arrValues['showgrades']."',
				smssending='".$arrValues['smssending']."',
				dateformat='".JArrayHelper::mysqlformat($arrValues['dateformat'])."'
				WHERE id=1";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
	}


	function getSchoolInfo(&$rec){
		  $q = "SELECT * FROM #__schoolinfo";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return $rec;
	}
	

  function savephoto($imagename,$sid,$scode,$time)
  {
	   $q = "INSERT INTO #__student_photo(imagename,sid,scode,time)VALUES('".$imagename."','".$sid."','".$scode."','".$time."')";
			    $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
	  
  }
        function addStaffPhoto($sid,$code){
                $db = & JFactory::getDBO();
                $dest = JPATH_COMPONENT.DS."staffphoto".DS.$code.'.png';
                $instr = fopen($dest,"rb");
                $image = addslashes(fread($instr,filesize($dest)));
                if (strlen($image) < 30000) {
                        $q = "insert into `#__staffphoto`(sid,imagedata) values (".$sid.", \"".$image."\")";
                        $db->setQuery($q);
                        if(!$db->query()){
                                return false;
                        } else {
                                return true;
                        }
                }else{
                        return false;
                }
        }
       function savestaffphoto($imagename,$scode,$staffid,$extention,$time)
  {
	   $q = "INSERT INTO #__staff_photo(image_name,scode,staffid,extention,time)VALUES('".$imagename."','".$scode."','".$staffid."','".$extention."','".$time."')";
			    $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
	  
  }
       function getsiglestudentphoto($sid,&$rec)
        {
                $q = "SELECT * FROM #__student_photo where sid = ".$sid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
        }
     
         function getsiglestaffphoto($staffid,&$rec)
        {
                $q = "SELECT * FROM #__staff_photo where staffid = ".$staffid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
        }
       
          function getusers(&$rec)
        {
                $q = "SELECT * FROM #__users";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObjectList();
                if($rec==null)
                        return false;
                return true;
        }
          function deletestudentPhotos($pids)
        {
                $ids = implode(',',$pids);
                $q = 'DELETE FROM #__student_photo WHERE sid IN ('.$ids.')';
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }
       function deletestaffphoto($pids)
        {
                $ids = implode(',',$pids);
                $q = 'DELETE FROM #__staff_photo WHERE staffid IN ('.$ids.')';
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }
         function updatesinglestaffphoto($pid)
        {
                $q = 'DELETE FROM #__staff_photo WHERE staffid='.$pid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }
         function updatesinglestudentphoto($sid)
        {
                $q = 'DELETE FROM #__student_photo WHERE sid='.$sid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }
        
/*Library settings*/
function addcategory($category)
       {
                $q = "INSERT INTO #__lib_bookcategory(categoryname)VALUES('".$category."')";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }



	 function getcat(&$rec)
        {
                $q = 'SELECT * FROM #__lib_bookcategory';
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObjectList();
                if($rec==null)
                        return false;
                return true;
        }
          function deletebookcategory($pid)
        {
       
                $q = 'DELETE FROM #__lib_bookcategory WHERE id='.$pid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }
        
        
 /*Library settings end*/
 
 /*Library manage books end*/
 		 function addbook($arrValues)
       {

                $q = "INSERT INTO #__lib_bookdetails(bookno,isbn,title,catid,author,edition,publisher,bookpos,shelfno)
				VALUES(
				'".$arrValues['bookno']."',
				'".$arrValues['isbn']."',
				'".$arrValues['title']."',
				'".$arrValues['catid']."',
				'".$arrValues['author']."',
				'".$arrValues['edition']."',
				'".$arrValues['publisher']."',
				'".$arrValues['bookpos']."',
				'".$arrValues['shelfno']."'
				)";
				//echo $q; exit; 
				
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return $db->insertid();
        }
 
		function updatebook($arrValues)
       {
                $q = "UPDATE #__lib_bookdetails SET
                bookno='".$arrValues['bookno']."',
				isbn='".$arrValues['isbn']."',
				title='".$arrValues['title']."',
				catid='".$arrValues['catid']."',
				author='".$arrValues['author']."',
				edition='".$arrValues['edition']."',
				publisher='".$arrValues['publisher']."',
				bookpos='".$arrValues['bookpos']."',
				 shelfno='".$arrValues['shelfno']."' WHERE id= '".$arrValues['id']."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }
		function counttotalbooks($isbn,&$rec)
        {
                $db =& JFactory::getDBO();
                $query = "SELECT count(*) total FROM #__lib_bookdetails WHERE isbn='".$isbn."'";
                $db->setQuery( $query );
                $rec = $db->loadObject();
                return $rec;
        }
        function countavailablebooks($isbn,&$rec)
        {

                $db =& JFactory::getDBO();
                $query = "SELECT count(*) available FROM #__lib_bookstatus WHERE isbn='".$isbn."'";
                $db->setQuery( $query );
                $rec = $db->loadObject();
                return $rec;
        }
     function getbookdetails(&$rec)
        {
                $q = 'SELECT * FROM #__lib_bookdetails order by `title` ASC';
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObjectList();
                if($rec==null)
                        return false;
                return true;
        }
      function getbookbyid($pid,&$rec)
        {
                $q = 'SELECT * FROM #__lib_bookdetails where id='.$pid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
        }
         function deletebook($pids)
        {
                $ids = implode(',',$pids);
                $q = 'DELETE FROM #__lib_bookdetails WHERE id NOT IN (SELECT bookid from #__lib_bookstatus) AND id IN ('.$ids.')';
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $result = $db->query();
				$affectedRows = $db->getAffectedRows($result);
				return $affectedRows;
        }
          function deletestatus($borrowid)
        {
                $q = 'DELETE FROM #__lib_bookstatus WHERE ref_id='.$borrowid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }
         function deletemovementlog($pids)
        {
                $ids = implode(',',$pids);
                $q = 'DELETE FROM #__lib_bookstatus WHERE id IN ('.$ids.')';
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }
        
 /*Library manage books  end*/
 
 /*Library circulation starts*/
 
  function getbookbykey($key,&$rec)
        {
                $q = "SELECT * FROM #__lib_bookdetails where bookno ='".$key."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
        }
  function issuebook($arrValues)
       {

                $q = "INSERT INTO #__lib_issuebook(bookid,bookno,studentid,issuedate,duedate)
				VALUES(
				'".$arrValues['bookid']."',
				'".$arrValues['bookno']."',
				'".$arrValues['studentid']."',
				'".JArrayHelper::mysqlformat($arrValues['issuedate'])."',
				'".JArrayHelper::mysqlformat($arrValues['duedate'])."'
				)";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return $db->insertid();
        }
         function renewbook($arrValues)
       {

                $q = "INSERT INTO #__lib_renewbook(issuedid,bookid,studentid,renewaldate,duedate,bookno)
				VALUES(
				'".$arrValues['issuedid']."',
				'".$arrValues['bookid']."',
				'".$arrValues['studentid']."',
				'".JArrayHelper::mysqlformat($arrValues['renewaldate'])."',
				'".JArrayHelper::mysqlformat($arrValues['duedate'])."',
				'".$arrValues['bookno']."'
				)";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return $db->insertid();
        }
         function returnbook($arrValues)
       {

                $q = "INSERT INTO #__lib_returnbook(borrowid,status,returndate)
				VALUES(
				'".$arrValues['borrowid']."',
				'".$arrValues['status']."',
				'".JArrayHelper::mysqlformat($arrValues['returndate'])."'
				)";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return $db->insertid();
        }
        
        function insertbookstatus($bookid,$isbn,$bookno,$stu_id,$regno,$issuedate,$duedate,$bookstatus,$insertedid)
       {
                $q = "INSERT INTO #__lib_bookstatus(status,bookid,isbn,ref_id,bookno,studentid,regno,issuedate,duedate)
				VALUES(
				'".$bookstatus."',
				'".$bookid."',
				'".$isbn."',
				'".$insertedid."',
				'".$bookno."',
				'".$stu_id."',
				'".$regno."',
				'".$issuedate."',
				'".$duedate."'
				)";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }
        	function updatebookstatus($arrValues,$bookstatus,$insertedid)
       {
                $q = "UPDATE #__lib_bookstatus SET
				ref_id='".$insertedid."',
				status='".$bookstatus."',
				issuedate='".JArrayHelper::mysqlformat($arrValues['renewaldate'])."',
				duedate='".JArrayHelper::mysqlformat($arrValues['duedate'])."'
				WHERE ref_id= '".$arrValues['issuedid']."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }
         function getbookstatusbyid($bookid,&$rec)
        {
                $q = "SELECT status,bookid,isbn,ref_id,bookno,studentid,regno FROM #__lib_bookstatus where id='".$bookid."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
        }
		 function getstatusdbytodaydate(&$rec)
        {
				$today=date('Y-m-d');
                $q = "SELECT * FROM #__lib_bookstatus where duedate='".$today."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObjectList();
                if($rec==null)
                        return false;
                return true;
        }
		
            function getissueddate($refid,&$rec)
        {
                $q = 'SELECT * FROM #__lib_issuebook where id='.$refid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
        }
       function getrenewaldetails($refid,&$rec)
        {
                $q = 'SELECT * FROM #__lib_renewbook where id='.$refid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
        }
        function countbookshold($sid,&$rec)
        {
                $db =& JFactory::getDBO();
                $query = "SELECT count(*) as bookshold FROM #__lib_bookstatus WHERE studentid='".$sid."'";
                $db->setQuery( $query );
                $rec = $db->loadObject();
                return $rec;
        }
         function getbookstatus(&$rec)
        {
                $db =& JFactory::getDBO();
                $query = "SELECT * FROM #__lib_bookstatus";
                $db->setQuery( $query );
                $rec = $db->loadObjectList();
                if($rec==null)
                        return false;
                return true;
        }
 
 /*Library circulation ends*/
 
        
/* Transport set Route done by john paul*/
        function getRoutes(&$rec)
        {
                $q = "SELECT * FROM #__trans_destination";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObjectList();
                if($rec==null)
                        return false;
                return true;
        }
		 function countStops($routeid)
        {
                $q = "SELECT count(*) as n_stops,routeId,stopname,fare,m_arrival,e_arrival FROM #__trans_route where routeId = ".$routeid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return $rec;
        }
		 function getStops($routeid)
        {
                $q = "SELECT * FROM #__trans_route where routeId = ".$routeid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObjectList();
                if($rec==null)
                        return false;
                return $rec;
        }
	
	  function RouteEdit($pid,&$rec){
                $db = & JFactory::getDBO();
                $q = "select id,route,vid from `#__trans_destination` WHERE `id` = ".$pid;
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null) 
						return false;
                return true;
        }
		
	   function addRoute($arrValues)
       {
                $q = "INSERT INTO #__trans_destination(route,vid)
				VALUES(
				'".$arrValues['route']."',
				'".$arrValues['vid']."'
				)";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return $db->insertid();
        }
		function updateRoute($arrValues)
       {
                $q = "UPDATE #__trans_destination SET
				route='".$arrValues['route']."',
				vid='".$arrValues['vid']."' WHERE id= '".$arrValues['id']."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }
		 function addRdetails($arrValues)
       {
                $q = "INSERT INTO #__trans_route(routeId,stopname,fare,m_arrival,e_arrival)
				VALUES(
				'".$arrValues['routeId']."',
				'".$arrValues['stopname']."',
				'".$arrValues['fare']."',
				'".$arrValues['m_arrival']."',
				'".$arrValues['e_arrival']."'
				)";
				//echo $q; exit; 
				
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }
		

        function updateRdetails($arrValues)
        {
                $q = "UPDATE #__trans_route SET 
				routeId='".$arrValues['routeId']."',
				stopname='".$arrValues['stopname']."',
				fare='".$arrValues['fare']."',
				m_arrival='".$arrValues['m_arrival']."',
				e_arrival='".$arrValues['e_arrival']."'
				WHERE id = '".$arrValues['destId']."'";
				//echo $q; exit;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }


        function deletedestination($pids)
        {
                $ids = implode(',',$pids);
                $q = 'DELETE FROM #__trans_destination WHERE id IN ('.$ids.')';
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }
		 function deletedesandstops($pid)
        {

                $q = 'DELETE FROM #__trans_destination WHERE id='.$pid.' AND  id NOT IN(SELECT routeId from #__trans_route)';
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $result = $db->query();

				$affectedRows = $db->getAffectedRows($result);
				return $affectedRows;
        }
		 function deletestop($pid)
        {
                $q = 'DELETE FROM #__trans_route WHERE id='.$pid.' AND  id NOT IN(SELECT stopid from #__trans_student)';
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $result = $db->query();

				$affectedRows = $db->getAffectedRows($result);
				return $affectedRows;
        }
/* Transport vehicle details done by john paul*/

        function getvehicledetails(&$rec)
        {
                $q = "SELECT * FROM #__trans_vdetails";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObjectList();
                if($rec==null)
                        return false;
                return true;
        }
		 function addVdetails($vno,$vcode,$noofseats,$max_seats,$vtype,$address,$city,$state,$phone,$Insurance,$tax,$permit,$status,$color)
       {
                $q = "INSERT INTO #__trans_vdetails(vno,vcode,noofseats,max_seats,vtype,address,city,state,phone,Insurance,tax,permit,status,color)VALUES('".$vno."','".$vcode."',".$noofseats.",".$max_seats.",'".$vtype."','".$address."','".$city."','".$state."','".$phone."','".$Insurance."','".$tax."','".$permit."','".$status."','".$color."')";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }
		
		 function deleteVdetails($pids)
        {
                $ids = implode(',',$pids);
                $q = 'DELETE FROM #__trans_vdetails WHERE id IN ('.$ids.')';
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }
		 function vehicleEdit($pid,&$rec){
                $db = & JFactory::getDBO();
                $q = "select * from #__trans_vdetails WHERE `id` = ".$pid;
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null) 
						return false;
                return true;
        }
		 function getvehicle($vid)
        {
                $q = "SELECT * FROM #__trans_vdetails where id = ".$vid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return $rec;
        }
		 function updateVdetails($id,$vno,$vcode,$noofseats,$max_seats,$vtype,$address,$city,$state,$phone,$Insurance,$tax,$permit,$status,$color)
        {
                $q = "UPDATE #__trans_vdetails SET vno='".$vno."', vcode='".$vcode."',noofseats='".$noofseats."',max_seats='".$max_seats."',vtype='".$vtype."',address='".$address."',city='".$city."',state='".$state."',phone='".$phone."',Insurance='".$Insurance."', tax='".$tax."', permit='".$permit."',status='".$status."', color='".$color."' WHERE id=".$id;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }
		
/* Transport Driver details done by john paul*/		
	 function getdriverdetails(&$rec)
        {
                $q = "SELECT * FROM #__trans_driver";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObjectList();
                if($rec==null)
                        return false;
                return true;
        }
		 function addDdetails($Fname,$Lname,$address,$dob,$license,$Edate)
       {
                $q = "INSERT INTO #__trans_driver(Fname,Lname,address,dob,license,Edate)VALUES('".$Fname."','".$Lname."','".$address."','".$dob."','".$license."','".$Edate."')";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }
		 function getdriver($pid,&$rec){
                $db = & JFactory::getDBO();
                $q = "select * from #__trans_driver WHERE `id` = ".$pid;
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null) 
						return false;
                return true;
        }
		 function updateDdetails($id,$Fname,$Lname,$address,$dob,$license,$Edate)
        {
                $q = "UPDATE #__trans_driver SET Fname='".$Fname."', Lname='".$Lname."', address='".$address."', dob='".$dob."', license='".$license."',Edate='".$Edate."' WHERE id=".$id;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }
		 function deletedriver($pids)
        {
                $ids = implode(',',$pids);
                $q = 'DELETE FROM #__trans_driver WHERE id IN ('.$ids.')';
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }
/* Transport Allot student done by john paul*/		
		
	
		 function SearchRoutes($namekey)
        {
                $q = "SELECT * FROM #__trans_destination where id in (select routeId from #__trans_route where stopname LIKE '%".$namekey."%')";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObjectList();
                if($rec==null)
                        return false;
                return true;
        }
		 function checkstudent($sid)
        {
                $q = "SELECT * FROM #__students where id in(select st_id from #__trans_student where st_id='".$sid."')";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return $rec;
        }

      	 function add_trans_student($st_id,$vid,$stopid,$did,$date)
       {
                $q = "INSERT INTO #__trans_student(st_id,vid,stopid,did,date)VALUES('".$st_id."','".$vid."','".$stopid."','".$did."','".$date."')";
			    $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }
      	function getcountstudent($vid,$stopid)
        {
                $q = "SELECT count(*) as c_stud FROM #__trans_student where vid = ".$vid." AND stopid=".$stopid."";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return $rec;
        }
			function countseats($vid,$did)
        {
                $q = "SELECT count(*) as co FROM #__trans_student where vid = '".$vid."' AND did='".$did."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return $rec;
        }
		 function deleteallotstudent($pids)
        {
                $ids = implode(',',$pids);
                $q = 'DELETE FROM #__trans_student WHERE id IN ('.$ids.')';
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }
		 function searchStops($key)
        {       if($key)
				{
                $q = "SELECT * FROM #__trans_destination where id in(select routeId from #__trans_route where stopname LIKE '%".$key."%')";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObjectList();
                if($rec==null)
                        return false;
                return $rec;
				}
        }
		
	/* Transport Allot driver done by john paul*/	
		 function getalloteddriver(&$rec)
        {
                $q = "SELECT * FROM #__trans_allot_driver";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObjectList();
                if($rec==null)
                        return false;
                return true;
        }
      	 function allot_driver($did,$vid,$date)
       {
                $q = "INSERT INTO #__trans_allot_driver(did,vid,date)VALUES('".$did."','".$vid."','".$date."')";
			    $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }
		 function get_driver($did){
                $db = & JFactory::getDBO();
                $q = "select * from #__trans_driver WHERE `id` = ".$did;
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null) 
						return false;
                return $rec;
        }
		 function deleteallotdetails($pids)
        {
               $ids = implode(',',$pids);
                $q = 'DELETE FROM #__trans_allot_driver WHERE id IN ('.$ids.')';
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }
		 function getallot_vehicledetails(&$rec)
        {
                $q = "SELECT * FROM #__trans_vdetails where id NOT IN (SELECT vid from #__trans_allot_driver)";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObjectList();
                if($rec==null)
                        return false;
                return true;
        }
			 function getallot_driverdetails(&$rec)
        {
                $q = "SELECT * FROM #__trans_driver where id NOT IN (SELECT did from #__trans_allot_driver)";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObjectList();
                if($rec==null)
                        return false;
                return true;
        }
		
			
/* Transport Fee collection done by john paul*/
       	 function feecollection(&$rec)
        {
                $q = "SELECT * FROM #__trans_student";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObjectList();
                if($rec==null)
                        return false;
                return true;
        }
			 function fee_getstudent($st_id)
        {
                $q = "SELECT * FROM #__students where id =".$st_id;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return $rec;
        }
			 function fee_getvehicle($vid)
        {
                $q = "SELECT * FROM #__trans_vdetails where id = ".$vid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return $rec;
        }
			 function fee_getstops($did)
        {
                $q = "SELECT * FROM #__trans_route where id = ".$did;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return $rec;
        }
	 function feeStudents($key)
        {       if($key)
				{
                $q = "SELECT * FROM #__trans_student where st_id in(select id from #__students where firstname LIKE '%".$key."%' OR registerno='".$key."')";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObjectList();
                if($rec==null)
                        return false;
                return $rec;
				}
        }
      function gettransmonths(&$rec)
        {
                $q = "SELECT * FROM #__trans_month";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObjectList();
                if($rec==null)
                        return false;
                return true;
        }
      function showtransmonths($monthid)
        {
                $q = "SELECT * FROM #__trans_month where id=".$monthid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return $rec;
        }
            
  	 function getpayfee($storedid,$date)
        {

                $q = "SELECT count(*) as countpay,id,dateofpay FROM #__trans_payfee where storedid ='".$storedid."' AND dateofpay='".JArrayHelper::mysqlformat($date)."' ";

				$db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return $rec;
        }    
    function getfeestudents($storedid)
        {
                $q = "SELECT * FROM #__trans_student where id=".$storedid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;  function getStudentsLimit($pcid,$limitstart,$limit)
        {
                $db =& JFactory::getDBO();
                $query = "SELECT id,registerno,ano,adate,firstname,middlename,lastname,dob,gender,bloodgroup,birthplace,nationality,mothertongue,caste,religion,addressline1,addressline2,city,state,pincode,country,phone,mobile,email,categoryid FROM #__students WHERE id IN (SELECT studentid FROM #__studentclass WHERE classid = ".$pcid.") LIMIT $limitstart, $limit";
                $db->setQuery( $query );
                $students = $db->loadObjectList();
                return $students;
        }
                return $rec;
        }
  	 function addfeedetails($stored,$amount,$fine,$total,$date)
       {
                $q = "INSERT INTO #__trans_payfee(storedid,amount,fine,total,dateofpay)VALUES('".$stored."','".$amount."','".$fine."','".$total."','".$date."')";
			    $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return  $db->insertid();
        }
     function getpaidfee($pid,&$rec){
                $db = & JFactory::getDBO();
                $q = "select * from #__trans_payfee WHERE `id` = ".$pid;
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null) 
						return false;
                return true;
        }
    function getprintviewid($storedid,$date)
        {
                $q = "SELECT * FROM #__trans_payfee where storedid='".$storedid."' AND dateofpay='".$date."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return $rec;
        }
          function getallotedLimit($limitstart,$limit)
        {
                $db =& JFactory::getDBO();
                $query = "SELECT * FROM #__trans_student LIMIT $limitstart, $limit";
                $db->setQuery( $query );
                $students = $db->loadObjectList();
                return $students;
        }
/* Transport Fuel manage done by john paul*/		
 				
	 function getfuels(&$rec)
        {
                $q = "SELECT * FROM #__trans_fuel";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObjectList();
                if($rec==null)
                        return false;
                return true;
        }
		
	 function fuelEdit($pid,&$rec){
                $db = & JFactory::getDBO();
                $q = "select * from #__trans_fuel WHERE `id` = ".$pid;
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null) 
						return false;
                return true;
        }
    function addFdetails($vcode,$litre,$amount,$date)
       {
                $q = "INSERT INTO #__trans_fuel(vcode,litre,amount,date)VALUES('".$vcode."','".$litre."','".$amount."','".$date."')";
			    $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }
		
	 function deleteFdetails($pids)
        {
                $ids = implode(',',$pids);
                $q = 'DELETE FROM #__trans_fuel WHERE id IN ('.$ids.')';
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }	
    function updateFdetails($id,$vcode,$litre,$amount,$date)
        {
                $q = "UPDATE #__trans_fuel SET vcode='".$vcode."',litre='".$litre."',amount='".$amount."',date='".$date."' WHERE id=".$id;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }	
		
		
		
	function updateStudentPhoto($sid,$regno){
		$s = $this->getStudentPhotoId($sid);
		if($s==false){
			$s=$this->addStudentPhoto($sid,$regno);
			return $s;
		}
		$db = & JFactory::getDBO();
		$dest = JPATH_COMPONENT.DS."studentsphoto".DS.$regno.'.png';
		$instr = fopen($dest,"rb");
                $image = addslashes(fread($instr,filesize($dest)));
                if (strlen($image) < 30000) {
                        $q="update `#__studentsphoto` SET imagedata=\"".$image."\" WHERE `sid`=".$sid;
			$db->setQuery($q);
			if(!$db->query()){
				return false;
        		} else {
                		return true;	
        		}
                } else {
                        return false;
                }
	}

	function updateStaffPhoto($sid,$code){
                $s = $this->getStaffPhotoId($sid);
                if($s==false){
                        $s=$this->addStaffPhoto($sid,$code);
                        return $s;
                }
                $db = & JFactory::getDBO();
                $dest = JPATH_COMPONENT.DS."staffphoto".DS.$code.'.png';
                $instr = fopen($dest,"rb");
                $image = addslashes(fread($instr,filesize($dest)));
                if (strlen($image) < 30000) {
                        $q="update `#__staffphoto` SET imagedata=\"".$image."\" WHERE `sid`=".$sid;
                        $db->setQuery($q);
                        if(!$db->query()){
                                return false;
                        } else {
                                return true;
                        }
                } else {
                        return false;
                }
        }

        function getStaffPhotoId($sid){
                $db = & JFactory::getDBO();
                $q = "select sid from `#__staffphoto` WHERE `sid` = ".$sid;
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null) return false;
                else return true;
        }



        function getStudentPhotoId($sid){
		$db = & JFactory::getDBO();
		$q = "select sid from `#__studentsphoto` WHERE `sid` = ".$sid;
		$db->setQuery($q);
                $rec = $db->loadObject();
		if($rec==null) return false;
		else return true;
	}

        function getStudentPhoto($sid,$regno){
		$db = & JFactory::getDBO();
		$q = "select * from `#__studentsphoto` WHERE `sid` = ".$sid;
		$db->setQuery($q);
                $rec = $db->loadObject();
		$dest = JPATH_COMPONENT.DS."studentsphoto".DS.$regno.".png";
		if($rec!=null){
			$bytes = $rec->imagedata;
		} else {
			$src = JPATH_COMPONENT.DS."studentsphoto".DS."dummy.png";
        		// Put up a dummy picture
        		$instr = fopen($src,"rb");
        		$bytes = fread($instr,filesize($src));
		}
		file_put_contents($dest,$bytes);
		return $dest;
	}



	function getAcademicYear($pid,&$rec)
	{
		$q = 'SELECT id,academicyear,startdate,stopdate,status,feeprefix FROM #__academicyears WHERE id ='.$pid;
		$db = & JFactory::getDBO();
		$db->setQuery($q);
		$rec = $db->loadObject();
		if($rec==null)
			return false;
		return true;
	}

       function addAcademicYear($arrayvalues)
       {
		$ac1=date('Y', strtotime($arrayvalues['startdate']));
		$ac2=date('Y', strtotime($arrayvalues['stopdate']));
		$academicyear=$ac1.'-'.$ac2;
		$q = "INSERT INTO #__academicyears(academicyear,startdate,stopdate,feeprefix,status) 
		VALUES('".$academicyear."','".$arrayvalues['startdate']."','".$arrayvalues['stopdate']."','".$arrayvalues['feeprefix']."','".$arrayvalues['status']."')";
		$db = & JFactory::getDBO();
		$db->setQuery($q);
		if(!$db->query())
			return false;
		return true;
	}

	function updateAcademicYear($arrayvalues)
	{
		$ac1=date('Y', strtotime($arrayvalues['startdate']));
		$ac2=date('Y', strtotime($arrayvalues['stopdate']));
		$academicyear=$ac1.'-'.$ac2;
		$q = "UPDATE #__academicyears SET academicyear='".$academicyear."', 
		startdate='".$arrayvalues['startdate']."', 
		stopdate='".$arrayvalues['stopdate']."', 
		feeprefix='".$arrayvalues['feeprefix']."', 
		status='".$arrayvalues['status']."' WHERE id=".$arrayvalues['id'];
		$db = & JFactory::getDBO();
		$db->setQuery($q);
		if(!$db->query())
			return false;
		return true;
	}

	function setCurrentAcademicYear($id)
	{
		$q = "UPDATE #__academicyears SET status='N'";
		$db = & JFactory::getDBO();
		$db->setQuery($q);
		if(!$db->query())
			return false;
		$q = "UPDATE #__academicyears SET status='Y' WHERE id=".$id;
		$db = & JFactory::getDBO();
		$db->setQuery($q);
		if(!$db->query())
			return false;
		return true;
	}
    
	function setotherAcademicYear($id)
	{
		$q = "UPDATE #__academicyears SET status='N'";
		$db = & JFactory::getDBO();
		$db->setQuery($q);
		if(!$db->query())
			return false;
		return true;
	}


	function deleteAcademicYear($pids)
	{
		$ids = implode(',',$pids);
		$q = 'DELETE FROM #__academicyears WHERE id IN ('.$ids.')';
		$db = & JFactory::getDBO();
		$db->setQuery($q);
		if(!$db->query())
			return false;
		return true;
	}

	function getTerm($pid,&$rec) {
                $q = 'SELECT id,term,code,months,startdate,stopdate,aid FROM #__terms WHERE id ='.$pid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
        }

       function addTerm($pterm,$pcode,$pmonths,$pstartdate,$pstopdate,$paid)
       {

                $q = "INSERT INTO #__terms(term,code,months,startdate,stopdate,aid) VALUES('".$pterm."','".$pcode."','".$pmonths."','".$pstartdate."','".$pstopdate."','".$paid."')";
        	$db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

        function updateTerm($id,$pterm,$pcode,$pmonths,$pstartdate,$pstopdate)
        {

                $q = "UPDATE #__terms SET term='".$pterm."', code='".$pcode."', months='".$pmonths."', startdate='".$pstartdate."',stopdate='".$pstopdate."'  WHERE id=".$id;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

        function deleteTerm($pids)
        {
                $ids = implode(',',$pids);
                $q = 'DELETE FROM #__terms WHERE id IN ('.$ids.')';
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }


	function getAcademicYears()
    	{
		$db =& JFactory::getDBO();
		$query = 'SELECT id,academicyear,startdate,stopdate,feeprefix,status FROM #__academicyears';
		$db->setQuery( $query );
		$academicyears = $db->loadObjectList();
		return $academicyears;
    	}

	function getCurrentTerms()
    	{
		$db =& JFactory::getDBO();
		$query = "SELECT id,term,months,code,startdate,stopdate FROM #__terms WHERE aid IN (SELECT id FROM #__academicyears WHERE status='Y')";
		$db->setQuery( $query );
		$terms = $db->loadObjectList();
		return $terms;
    	}
    
    	function getCurrentAcademicYear()
    	{
		$db =& JFactory::getDBO();
		$query = "SELECT id,academicyear FROM #__academicyears WHERE status='Y'";
		$db->setQuery( $query );
		$cy = $db->loadObjectList();
		return $cy;
	}

	function getCurrentAcademicYear1()
        {
                $db =& JFactory::getDBO();
                $query = "SELECT id,academicyear FROM #__academicyears WHERE status='Y'";
                $db->setQuery( $query );
                $cy = $db->loadObject();
                return $cy->academicyear;
        }



//Courses

        function getCourses($paid)
        {
                $db =& JFactory::getDBO();
                $query = "SELECT id,coursename,sectionname,code,assessmenttype, filename,courseno  FROM #__courses WHERE aid = ".$paid." ORDER BY courseno";
                $db->setQuery( $query );
                $courses = $db->loadObjectList();
                return $courses;
        }


        function getCurrentCourses()
        {
                $db =& JFactory::getDBO();
                $query = "SELECT id,coursename,sectionname,code,filename,assessmenttype,courseno FROM #__courses WHERE aid IN (SELECT id FROM #__academicyears WHERE status='Y')";
                $db->setQuery( $query );
                $courses = $db->loadObjectList();
                return $courses;
        }


  	function getCoursebyStudent($psid,&$rec)
        {
                $q = "select * from ya_courses where aid IN (SELECT id FROM ya_academicyears where status='Y') AND id  IN (select classid FROM ya_studentclass where studentid='".$psid."')";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
        }


        function getCourse($pid,&$rec)
        {
                $q = 'SELECT id,coursename,sectionname,code,aid,assessmenttype,courseno,filename FROM #__courses WHERE id ='.$pid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
        }

       function addCourse($pcourse,$psectionname,$pcode,$passessmenttype,$pfilename,$paid,$pcourseno)
       {
                $q = "INSERT INTO #__courses(coursename,sectionname,code,assessmenttype,filename,aid,courseno) VALUES('".$pcourse."','".$psectionname."','".$pcode."','".$passessmenttype."','".$pfilename."','".$paid."','".$pcourseno."')";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

        function updateCourse($id,$pcourse,$psectionname,$pcode,$passessmenttype,$pfilename,$pcourseno)
        {
                $q = "UPDATE #__courses SET coursename='".$pcourse."', sectionname='".$psectionname."', courseno='".$pcourseno."', code='".$pcode."', filename='".$pfilename."', assessmenttype='".$passessmenttype."' WHERE id=".$id;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }


        function deleteCourse($pids)
        {
                $ids = implode(',',$pids);
                $q = 'DELETE FROM #__courses WHERE id IN ('.$ids.')';
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }



//Subjects
	function getCourseId($psid)
	{
		
	}



        function getSubjects($pcid)
        {
                $db =& JFactory::getDBO();
                $query = "SELECT id,subjectname,subjectcode,hoursperweek FROM #__subjects WHERE cid =".$pcid;
                $db->setQuery( $query );
                $subjects = $db->loadObjectList();
                return $subjects;
        }

        function getSubject($pid,&$rec)
        {
                $q = 'SELECT id,subjectname,subjectcode,hoursperweek,cid FROM #__subjects WHERE id ='.$pid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
        }

       function getSubjectId($pcid,$psubjectcode,&$sid)
       {
                $q = "SELECT id FROM #__subjects WHERE cid =".$pcid." AND subjectcode='".$psubjectcode."'";;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
		$sid=$rec->id;
                return true;
       }

       function addSubject($psubjectname,$psubjectcode,$phoursperweek,$pcid)
       {
                $q = "INSERT INTO #__subjects(subjectname,subjectcode,hoursperweek,cid) VALUES('".$psubjectname."','".$psubjectcode."','".$phoursperweek."','".$pcid."')";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

        function updateSubject($id,$psubjectname,$psubjectcode,$phoursperweek)
        {
                $q = "UPDATE #__subjects SET subjectname='".$psubjectname."', subjectcode='".$psubjectcode."',hoursperweek='".$phoursperweek."' WHERE id=".$id;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }


        function deleteSubject($pids)
        {
                $ids = implode(',',$pids);
                $q = 'DELETE FROM #__subjects WHERE id IN ('.$ids.')';
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

       function assignCourseSubject($pcid,$psid)
       {
                $q = "INSERT INTO #__coursesubjects(cid,sid) VALUES(".$pcid.",".$psid.")";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

        function deleteCourseSubject($pcid,$psid)
        {
                $ids = implode(',',$pids);
                $q = 'DELETE FROM #__coursesubjects WHERE cid = '.$pcid.' AND sid='.$psid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

       function getCourseSubjectIds($pcid,$psid,&$ids)
       {
                $q = "SELECT id FROM #__coursesubjects WHERE cid =".$pcid." AND sid=".$psid."'";;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $ids = $db->loadObjectList();
                if($ids==null)
                        return false;
                return true;
       }




//Subject Teachers
	function getSubjectTeachers($pcourseid,$psubjectid,&$rec)
	{
                $q = 'SELECT id,staffcode,firstname,middlename,lastname,dob,gender,bloodgroup,doj,nationality,qualification,jobtitle,department,category,position,grade,experienceinfo,totalexperience,status,maritalstatus,fathername,mothername,addressline1,addressline2,city,state,pincode,country,phone,mobile,email FROM #__staffs WHERE id IN (SELECT staffid FROM #__subjectteachers WHERE courseid =  '.$pcourseid.' AND subjectid = '.$psubjectid.')';
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObjectList();
                if($rec==null)
                        return false;
                return true;
        }
	
	function getAllClassTeachers(&$recs){
		$sql="SELECT distinct staffid from #__classteachers where classid in (SELECT id FROM #__courses WHERE aid in (select id from #__academicyears where status='Y'))";
                $db = & JFactory::getDBO();
                $db->setQuery($sql);
                $recs = $db->loadObjectList();
                if($recs==null)
                        return false;
                return true;
	}
		
		

//Students

        function getCurrentStudents()
        {
                $db =& JFactory::getDBO();
                $query = "SELECT id,registerno,ano,adate,firstname,middlename,lastname,dob,gender,bloodgroup,birthplace,nationality,mothertongue,caste,religion,addressline1,addressline2,city,state,pincode,country,pfathername,phone,mobile,email,mothername,mphone,mmobile,memail,categoryid FROM #__students WHERE id IN (SELECT studentid FROM #__studentclass WHERE classid IN (SELECT id FROM #__courses WHERE aid IN (SELECT id FROM #__academicyears WHERE status='Y'))) ORDER BY registerno";
                $db->setQuery( $query );
                $students = $db->loadObjectList();
                return $students;
        }


        function getCurrentStudentsIDs()
        {
                $db =& JFactory::getDBO();
                $query = "SELECT studentid FROM #__studentclass WHERE classid IN (SELECT id FROM #__courses WHERE aid IN (SELECT id FROM #__academicyears WHERE status='Y'))";
                $db->setQuery( $query );
                $students = $db->loadAssocList();
                return $students;
        }



//        function getCurrentStudents()
  //      {
    //            $db =& JFactory::getDBO();
      //          $query = "SELECT id,registerno,firstname,middlename,lastname,dob,gender,bloodgroup,birthplace,nationality,mothertongue,caste,religion,addressline1,addressline2,city,state,pincode,country,phone,mobile,email,pfathername,pmothername,pphone,pmobile,pemail FROM #__students WHERE joinedacademicyearid IN (SELECT id FROM #__academicyears WHERE status='Y') ORDER BY joinedclassid";
        //        $db->setQuery( $query );
          //      $students = $db->loadObjectList();
            //    return $students;
       // }


//       function getStudents($pcid)
//       {
//                $db =& JFactory::getDBO();
//                $query = "SELECT id,registerno,firstname,middlename,lastname,dob,gender,bloodgroup,birthplace,nationality,mothertongue,caste,religion,addressline1,addressline2,city,state,pincode,country,phone,mobile,email FROM #__students WHERE joinedclassid =".$pcid;
//                $db->setQuery( $query );
//                $students = $db->loadObjectList();
//                return $students;
//        }



        function getCdatecount($prefix)
        {
                $db =& JFactory::getDBO();
                 $query = 'SELECT cdate, count(distinct studentid) AS total FROM '.$prefix.'classattendance GROUP BY cdate ORDER BY cdate DESC LIMIT 30';
				 $db->setQuery( $query );
                $students = $db->loadObjectList();
                return $students;
        }
         function getStudents($pcid)
        {
                $db =& JFactory::getDBO();
                $query = "SELECT * FROM #__students WHERE id IN (SELECT studentid FROM #__studentclass WHERE classid = ".$pcid.") ORDER BY registerno";
                $db->setQuery( $query );
                $students = $db->loadObjectList();
                return $students;
        }
        

         function getStudentbyrollno($rollno,&$rec)
        {
                $q = "SELECT * FROM #__students WHERE registerno='".$rollno."' AND id IN (SELECT studentid FROM #__studentclass WHERE classid IN (SELECT id FROM #__courses WHERE aid IN (SELECT id FROM #__academicyears WHERE status='Y')))";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return $rec;
        }
          function countStudents(&$rec)
        {
                $db =& JFactory::getDBO();
                $query = "SELECT count(*) as totalstudents FROM #__students WHERE id IN (SELECT studentid FROM #__studentclass WHERE classid IN (SELECT id FROM #__courses WHERE aid IN (SELECT id FROM #__academicyears WHERE status='Y'))) ";
                $db->setQuery( $query );
                $rec = $db->loadObject();
                return $rec;
        }

        function getStudentBirthDays()
        {
                $db =& JFactory::getDBO();
                $query = "SELECT * FROM `#__students`  WHERE right(dob,5) = right(current_date,5)"; 
                 $db->setQuery( $query );
                $students = $db->loadObjectList();
                return $students;
        }


        function getStudentsLimit($pcid,$limitstart,$limit)
        {
                $db =& JFactory::getDBO();
                $query = "SELECT id,registerno,ano,adate,firstname,middlename,lastname,dob,gender,bloodgroup,birthplace,nationality,mothertongue,caste,religion,addressline1,addressline2,city,state,pincode,country,phone,mobile,email,categoryid FROM #__students WHERE id IN (SELECT studentid FROM #__studentclass WHERE classid = ".$pcid.") LIMIT $limitstart, $limit";
                $db->setQuery( $query );
                $students = $db->loadObjectList();
                return $students;
        }


        function searchStudents($pnamekey)
        {
		if(!$pnamekey) return;
                $db =& JFactory::getDBO();
                $query = "SELECT * FROM #__students WHERE (firstname LIKE '%".$pnamekey."%' OR lastname LIKE '%".$pnamekey."%') AND id IN (SELECT studentid FROM #__studentclass WHERE classid IN (SELECT id FROM #__courses WHERE aid IN (SELECT id FROM #__academicyears WHERE status='Y'))) ";
                $db->setQuery( $query );
                $students = $db->loadObjectList();
                return $students;
        }
		function getstudentsbycaste($type)
        {
		if(!$type) return;
                $db =& JFactory::getDBO();
                $query = "SELECT * FROM #__students WHERE (caste LIKE '%".$type."%') AND id IN (SELECT studentid FROM #__studentclass WHERE classid IN (SELECT id FROM #__courses WHERE aid IN (SELECT id FROM #__academicyears WHERE status='Y'))) ";
                $db->setQuery( $query );
                $students = $db->loadObjectList();
                return $students;
        }



        function getStudent($pid,&$rec)
        {
                $q = 'SELECT * FROM #__students WHERE id ='.$pid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
        }

	function getNationality($nid){
		$q = 'SELECT countryname FROM #__countries where id='.$nid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return $rec->countryname;
	
	}

        function getallStudent(&$rec)
        {
                $q = "SELECT * FROM #__students where id IN (SELECT studentid FROM #__studentclass WHERE classid IN (SELECT id FROM #__courses WHERE aid IN (SELECT id FROM #__academicyears WHERE status='Y')))";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObjectList();
                if($rec==null)
                        return false;
                return true;
        }


//Student Class
	function addStudentClass($pcid,$psid)
        {
                $q = "INSERT INTO #__studentclass(classid,studentid) VALUES(".$pcid.",".$psid.")";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }


 	function getStudentClass($pid, &$rec){
                $q = 'SELECT id,coursename,sectionname,code,aid,assessmenttype FROM #__courses WHERE (aid IN (SELECT id FROM #__academicyears WHERE status=\'Y\')) AND (id IN (SELECT classid FROM #__studentclass WHERE studentid ='.$pid.'))';
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
	}



//Student Admission
       function addStudent($registerno,$ano,$adate,$admittedclass,$firstname,$middlename,$lastname,$dob,$gender,$bloodgroup,$birthplace,$nationality,$mothertongue,$caste,$religion,$addressline1,$addressline2,$city,$state,$pincode,$country,$fathername,$phone,$mobile,$email,$focc,$mothername,$mphone,$mmobile,$memail,$mocc,$gname,$gphone,$gmobile,$gocc,$smsto,$idmark,$idmark2,$aadharno,$catid,$medium,$lang1,$lang2,$lang3,$studentas,$community,$modeoftransport,$passportno,$disability,$disadvantagedgroup,$fdob,$fincome,$mdob,$mincome,$emergency,$courseid)
       {
          $q = "INSERT INTO #__students(registerno,ano,adate,admittedclass,firstname,middlename,lastname,dob,gender,bloodgroup,birthplace,nationality,mothertongue,caste,religion,addressline1,addressline2,city,state,pincode,country,pfathername,phone,mobile,email,mothername,mphone,mmobile,memail,categoryid,joinedclassid,joinedacademicyearid,focc,mocc,gname,gphone,gmobile,gocc,smsto,aadharno,identificationmark,identificationmark2,medium,lang1,lang2,lang3,studentas,community,modeoftransport,passportno,disability,disadvantagedgroup,fdob,fincome,mdob,mincome,emergency) VALUES('".mysql_escape_string(htmlspecialchars($registerno))."','".mysql_escape_string(htmlspecialchars($ano))."','".$adate."','".mysql_escape_string(htmlspecialchars($admittedclass))."','".mysql_escape_string(htmlspecialchars($firstname))."','".mysql_escape_string(htmlspecialchars($middlename))."','".mysql_escape_string(htmlspecialchars($lastname))."','".$dob."','".$gender."','".$bloodgroup."','".mysql_escape_string(htmlspecialchars($birthplace))."','".$nationality."','".mysql_escape_string(htmlspecialchars($mothertongue))."','".mysql_escape_string(htmlspecialchars($caste))."','".mysql_escape_string(htmlspecialchars($religion))."','".mysql_escape_string(htmlspecialchars($addressline1))."','".mysql_escape_string(htmlspecialchars($addressline2))."','".mysql_escape_string(htmlspecialchars($city))."','".mysql_escape_string(htmlspecialchars($state))."','".mysql_escape_string(htmlspecialchars($pincode))."','".$country."','".mysql_escape_string(htmlspecialchars($fathername))."','".mysql_escape_string(htmlspecialchars($phone))."','".mysql_escape_string(htmlspecialchars($mobile))."','".mysql_escape_string(htmlspecialchars($email))."','".mysql_escape_string(htmlspecialchars($mothername))."','".mysql_escape_string(htmlspecialchars($mphone))."','".mysql_escape_string(htmlspecialchars($mmobile))."','".mysql_escape_string(htmlspecialchars($memail))."','".$catid."','".$courseid."',(SELECT id FROM #__academicyears WHERE status='Y'),'".mysql_escape_string(htmlspecialchars($focc))."','".mysql_escape_string(htmlspecialchars($mocc))."','".mysql_escape_string(htmlspecialchars($gname))."','".mysql_escape_string(htmlspecialchars($gphone))."','".mysql_escape_string(htmlspecialchars($gmobile))."','".mysql_escape_string(htmlspecialchars($gocc))."','".$smsto."','".mysql_escape_string(htmlspecialchars($aadharno))."','".mysql_escape_string(htmlspecialchars($idmark))."','".mysql_escape_string(htmlspecialchars($idmark2))."','".mysql_escape_string(htmlspecialchars($medium))."','".mysql_escape_string(htmlspecialchars($lang1))."','".mysql_escape_string(htmlspecialchars($lang2))."','".mysql_escape_string(htmlspecialchars($lang3))."','".$studentas."','".mysql_escape_string(htmlspecialchars($community))."','".mysql_escape_string(htmlspecialchars($modeoftransport))."','".mysql_escape_string(htmlspecialchars($passportno))."','".mysql_escape_string(htmlspecialchars($disability))."','".mysql_escape_string(htmlspecialchars($disadvantagedgroup))."','".$fdob."','".$fincome."','".$mdob."','".$mincome."','".$emergency."')";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
		$q="SELECT `id` FROM `#__students` WHERE `registerno`='".$registerno."' AND `joinedclassid` = '".$courseid."'";
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;	
		$s = $this->addStudentClass($courseid,$rec->id);
		//log the error
                return $rec->id;
        }
        

        function updateStudent($id,$registerno,$ano,$adate,$admittedclass,$firstname,$middlename,$lastname,$dob,$gender,$bloodgroup,$birthplace,$nationality,$mothertongue,$caste,$religion,$addressline1,$addressline2,$city,$state,$pincode,$country,$fathername,$phone,$mobile,$email,$focc,$mothername,$mphone,$mmobile,$memail,$mocc,$gname,$gphone,$gmobile,$gocc,$smsto,$catid,$idmark,$idmark2,$aadharno,$medium,$lang1,$lang2,$lang3,$studentas,$community,$modeoftransport,$passportno,$disability,$disadvantagedgroup,$fdob,$fincome,$mdob,$mincome,$emergency)
        {
                $q = "UPDATE #__students SET ano='".mysql_escape_string(htmlspecialchars($ano))."', adate='".$adate."', admittedclass='".mysql_escape_string(htmlspecialchars($admittedclass))."', firstname='".mysql_escape_string(htmlspecialchars($firstname))."', registerno='".mysql_escape_string(htmlspecialchars($registerno))."',middlename='".mysql_escape_string(htmlspecialchars($middlename))."', lastname='".mysql_escape_string(htmlspecialchars($lastname))."',dob='".$dob."',gender='".$gender."',bloodgroup='".$bloodgroup."',birthplace='".mysql_escape_string(htmlspecialchars($birthplace))."',nationality='".$nationality."',mothertongue='".mysql_escape_string(htmlspecialchars($mothertongue))."',smsto='".$smsto."', caste='".mysql_escape_string(htmlspecialchars($caste))."',religion='".mysql_escape_string(htmlspecialchars($religion))."',addressline1='".mysql_escape_string(htmlspecialchars($addressline1))."',addressline2='".mysql_escape_string(htmlspecialchars($addressline2))."',city='".mysql_escape_string(htmlspecialchars($city))."',state='".$state."',pincode='".mysql_escape_string(htmlspecialchars($pincode))."',country='".$country."',pfathername='".mysql_escape_string(htmlspecialchars($fathername))."', phone='".mysql_escape_string(htmlspecialchars($phone))."',mobile='".mysql_escape_string(htmlspecialchars($mobile))."',email='".mysql_escape_string(htmlspecialchars($email))."', mothername='".mysql_escape_string(htmlspecialchars($mothername))."', mphone='".mysql_escape_string(htmlspecialchars($mphone))."', mmobile='".mysql_escape_string(htmlspecialchars($mmobile))."', memail='".mysql_escape_string(htmlspecialchars($memail))."', categoryid='".$catid."',focc='".mysql_escape_string(htmlspecialchars($focc))."',mocc='".mysql_escape_string(htmlspecialchars($mocc))."',gname='".mysql_escape_string(htmlspecialchars($gname))."',gphone='".mysql_escape_string(htmlspecialchars($gphone))."',gmobile='".mysql_escape_string(htmlspecialchars($gmobile))."',gocc='".mysql_escape_string(htmlspecialchars($gocc))."', medium='".mysql_escape_string(htmlspecialchars($medium))."',lang1='".mysql_escape_string(htmlspecialchars($lang1))."',lang2='".mysql_escape_string(htmlspecialchars($lang2))."', lang3='".mysql_escape_string(htmlspecialchars($lang3))."',studentas='".$studentas."', aadharno='".mysql_escape_string(htmlspecialchars($aadharno))."', identificationmark='".mysql_escape_string(htmlspecialchars($idmark))."',identificationmark2='".mysql_escape_string(htmlspecialchars($idmark2))."', community='".mysql_escape_string(htmlspecialchars($community))."', modeoftransport='".mysql_escape_string(htmlspecialchars($modeoftransport))."', passportno='".mysql_escape_string(htmlspecialchars($passportno))."', disability='".mysql_escape_string(htmlspecialchars($disability))."', disadvantagedgroup='".mysql_escape_string(htmlspecialchars($disadvantagedgroup))."', fdob='".$fdob."',fincome='".mysql_escape_string(htmlspecialchars($fincome))."', mdob='".mysql_escape_string(htmlspecialchars($mdob))."', mincome='".mysql_escape_string(htmlspecialchars($mincome))."',emergency='".$emergency."' WHERE id=".$id;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

        function deleteStudent($pids)
        {
                $ids = implode(',',$pids);
                $q = 'DELETE FROM #__students WHERE id IN ('.$ids.')';
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }


        function removeStudentsFromClass($pids,$pcid)
        {
                $ids = implode(',',$pids);
                $q = 'DELETE FROM #__studentclass WHERE studentid IN ('.$ids.') AND classid='.$pcid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }


        function discontinueStudent($pids,$pcid)
        {
                $ids = implode(',',$pids);
                $q  = 'UPDATE #__students SET leftacademicyearid = (SELECT id FROM #__academicyears WHERE status=\'Y\'), leftclassid = '.$pcid.' WHERE id IN ('.$ids.')';
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }


//Student Promotion


        function getThisAcademicYear(&$rec)
        {
                $db =& JFactory::getDBO();
                $query = "SELECT id,academicyear,startdate,stopdate,status FROM #__academicyears WHERE status='Y'";
                $db->setQuery( $query );
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
        }


        function getNextAcademicYear(&$rec)
        {
                $q = "SELECT id,academicyear,startdate,stopdate,status FROM #__academicyears WHERE academicyear > (SELECT academicyear FROM #__academicyears WHERE status='Y') LIMIT 1";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
        }
        
//Country

	function getCountries()
	{
		$query = "SELECT id,countryname FROM #__countries";
                $db = & JFactory::getDBO();
                $db->setQuery( $query );
                $countries = $db->loadObjectList();
                return $countries;
        }


        function getCountryName($pid)
        {
                $q = 'SELECT countryname FROM #__countries WHERE id ='.$pid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $c = $db->loadObject();
                return $c->countryname;
        }

//Staffs


	function getACLGroupID($groupname)
	{
                $db =& JFactory::getDBO();
                $q = "SELECT id FROM #__usergroups WHERE title='".$groupname."'";
                $db->setQuery( $q );
                $rec = $db->loadObject();
                return $rec->id;
	}


    	function getStaffCodes(&$recs)
        {
                $db =& JFactory::getDBO();
                $query = "SELECT id,staffcode FROM #__staffs ORDER BY firstname";
                $db->setQuery( $query );
                $recs = $db->loadObjectList();
                return true;
        }


        function getStaffs()
        {
                $db =& JFactory::getDBO();
                $query = "SELECT id,hprefix,staffcode,firstname,middlename,lastname,dob,gender,bloodgroup,doj,nationality,qualification,jobtitle,department,category,position,grade,experienceinfo,totalexperience,status,maritalstatus,fathername,mothername,addressline1,addressline2,city,state,pincode,country,phone,mobile,email FROM #__staffs ORDER BY firstname";
                $db->setQuery( $query );
                $staffs = $db->loadObjectList();
                return $staffs;
        }

	function getStaffBirthDays()
        {
                $db =& JFactory::getDBO();
                $query = "SELECT id,hprefix,staffcode,firstname,middlename,lastname,dob,gender,bloodgroup,doj,nationality,qualification,jobtitle,department,category,position,grade,experienceinfo,totalexperience,status,maritalstatus,fathername,mothername,addressline1,addressline2,city,state,pincode,country,phone,mobile,email FROM #__staffs WHERE right(dob,5) = right(current_date,5)";
               // $query = "SELECT * FROM `#__staffs` WHERE  DAYOFYEAR(curdate()) <= dayofyear(`dob`) AND DAYOFYEAR(curdate()) +50 >= dayofyear(`dob`) ORDER BY dob LIMIT 30"; 
                $db->setQuery( $query );
                $staffs = $db->loadObjectList();
                return $staffs;
        }

	function getStaffIdByCode($staffcode)
	{
                $db =& JFactory::getDBO();
		$q = "SELECT `id` FROM `#__staffs` WHERE lower(`staffcode`) = lower('".$staffcode."')";
                $db->setQuery( $q );
                $staffid = $db->loadObject();
                return $staffid->id;
	}
		function countstaff(&$rec)
        {
                $q = 'SELECT count(*) as totalstaffs FROM #__staffs';
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
        }

        function getStaff($pid,&$rec)
        {
                $q = 'SELECT id,hprefix,staffcode,firstname,middlename,lastname,dob,gender,bloodgroup,doj,nationality,qualification,jobtitle,department,category,position,grade,experienceinfo,totalexperience,status,maritalstatus,fathername,mothername,addressline1,addressline2,city,state,pincode,country,phone,mobile,email FROM #__staffs WHERE id='.$pid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
        }

       function addStaff($hprefix,$staffcode,$firstname,$middlename,$lastname,$dob,$gender,$bloodgroup,$doj,$nationality,$qualification,$jobtitle,$department,$category,$position,$grade,$experienceinfo,$totalexperience,$status,$maritalstatus,$fathername,$mothername,$addressline1,$addressline2,$city,$state,$pincode,$country,$phone,$mobile,$email)
       {

          $q = "INSERT INTO #__staffs(hprefix,staffcode,firstname,middlename,lastname,dob,gender,bloodgroup,doj,nationality,qualification,jobtitle,department,category,position,grade,experienceinfo,totalexperience,status,maritalstatus,fathername,mothername,addressline1,addressline2,city,state,pincode,country,phone,mobile,email) VALUES('".$hprefix."','".mysql_escape_string(htmlspecialchars($staffcode))."','".mysql_escape_string(htmlspecialchars($firstname))."','".mysql_escape_string(htmlspecialchars($middlename))."','".mysql_escape_string(htmlspecialchars($lastname))."','".$dob."','".$gender."','".$bloodgroup."','".$doj."','".$nationality."','".mysql_escape_string(htmlspecialchars($qualification))."','".mysql_escape_string(htmlspecialchars($jobtitle))."','".$department."','".$category."','".$position."','".$grade."','".mysql_escape_string(htmlspecialchars($experienceinfo))."','".$totalexperience."','".$status."','".$maritalstatus."','".mysql_escape_string(htmlspecialchars($fathername))."','".mysql_escape_string(htmlspecialchars($mothername))."','".mysql_escape_string(htmlspecialchars($addressline1))."','".mysql_escape_string(htmlspecialchars($addressline2))."','".mysql_escape_string(htmlspecialchars($city))."','".$state."','".$pincode."','".$country."','".mysql_escape_string(htmlspecialchars($phone))."','".mysql_escape_string(htmlspecialchars($mobile))."','".mysql_escape_string(htmlspecialchars($email))."')";

                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return $db->insertid();
				
        }
        

        function updateStaff($id,$hprefix,$staffcode,$firstname,$middlename,$lastname,$dob,$gender,$bloodgroup,$doj,$nationality,$qualification,$jobtitle,$department,$category,$position,$grade,$experienceinfo,$totalexperience,$status,$maritalstatus,$fathername,$mothername,$addressline1,$addressline2,$city,$state,$pincode,$country,$phone,$mobile,$email)
        {
                $q = "UPDATE #__staffs SET hprefix='".$hprefix."', firstname='".mysql_escape_string(htmlspecialchars($firstname))."', staffcode='".mysql_escape_string(htmlspecialchars($staffcode))."',middlename='".mysql_escape_string(htmlspecialchars($middlename))."', lastname='".mysql_escape_string(htmlspecialchars($lastname))."',dob='".$dob."',gender='".$gender."',bloodgroup='".$bloodgroup."',doj='".mysql_escape_string(htmlspecialchars($doj))."',nationality='".$nationality."',qualification='".mysql_escape_string(htmlspecialchars($qualification))."',jobtitle='".mysql_escape_string(htmlspecialchars($jobtitle))."',department='".$department."',category='".$category."',position='".$position."',grade='".$grade."',experienceinfo='".mysql_escape_string(htmlspecialchars($experienceinfo))."',totalexperience='".$totalexperience."',status='".$status."',maritalstatus='".$maritalstatus."',fathername='".mysql_escape_string(htmlspecialchars($fathername))."',mothername='".mysql_escape_string(htmlspecialchars($mothername))."',addressline1='".mysql_escape_string(htmlspecialchars($addressline1))."',addressline2='".mysql_escape_string(htmlspecialchars($addressline2))."',city='".mysql_escape_string(htmlspecialchars($city))."',state='".$state."',pincode='".mysql_escape_string(htmlspecialchars($pincode))."',country='".$country."',phone='".mysql_escape_string(htmlspecialchars($phone))."',mobile='".mysql_escape_string(htmlspecialchars($mobile))."',email='".mysql_escape_string(htmlspecialchars($email))."' WHERE id=".$id;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }


        function deleteStaff($pids)
        {
                $ids = implode(',',$pids);
                $q = 'DELETE FROM #__staffs WHERE id IN ('.$ids.')';
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
	}
	
//Student Categories	
	function getStudentCategory($pid,&$rec)
        {
                $q = 'SELECT id,categoryname,categorycode FROM #__studentcategories WHERE id ='.$pid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
        }


	function addStudentCategory($pname,$pcode)
        {
                $q = "INSERT INTO #__studentcategories(categoryname,categorycode) VALUES('".$pname."','".$pcode."')";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

        function updateStudentCategory($id,$pname,$pcode)
        {
                $q = "UPDATE #__studentcategories SET categoryname='".$pname."',categorycode='".$pcode."' WHERE id=".$id;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

        function deleteStudentCategory($pids)
        {
                $ids = implode(',',$pids);
                $q = 'DELETE FROM #__studentcategories WHERE id IN ('.$ids.')';
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

        function getStudentCategories()
        {
                $query = "SELECT id,categoryname,categorycode FROM #__studentcategories";
                $db = & JFactory::getDBO();
                $db->setQuery( $query );
                $departments = $db->loadObjectList();
                return $departments;
        }




//Departments
        function getDepartment($pid,&$rec)
        {
                $q = 'SELECT id,departmentname,departmentcode FROM #__staffdepartments WHERE id ='.$pid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
        }


       function addDepartment($pdepartment,$pdepartmentcode)
       {
                $q = "INSERT INTO #__staffdepartments(departmentname,departmentcode,aid) VALUES('".$pdepartment."','".$pdepartmentcode."',(SELECT id FROM #__academicyears WHERE status='Y'))";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

	function addDepartmentCourse($pcourseid,$pdepartmentid)
	{
                $q = "INSERT INTO #__departmentcourses(courseid,departmentid) VALUES('".$pcourseid."','".$pdepartmentid."')";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }


	function deleteDepartmentCourse($pcourseid,$pdepartmentid){
                $q = "DELETE FROM #__departmentcourses WHERE departmentid='".$pdepartmentid."' AND courseid='".$pcourseid."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
	}

        function updateDepartment($id,$pdepartment,$pdepartmentcode)
        {
                $q = "UPDATE #__staffdepartments SET departmentname='".$pdepartment."', departmentcode='".$pdepartmentcode."' WHERE id=".$id;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }


        function deleteDepartment($pids)
        {
                $ids = implode(',',$pids);
                $q = 'DELETE FROM #__staffdepartments WHERE id IN ('.$ids.')';
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }


        function getDepartments()
        {
		$query = "SELECT id,departmentname,departmentcode FROM #__staffdepartments WHERE aid IN (SELECT id FROM #__academicyears WHERE status='Y')";
                $db = & JFactory::getDBO();
                $db->setQuery( $query );
                $departments = $db->loadObjectList();
                return $departments;
        }



	function getDepartmentCourses($departmentid)
	{
		$query = "SELECT courseid FROM #__departmentcourses WHERE departmentid='".$departmentid."'";
                $db = & JFactory::getDBO();
                $db->setQuery( $query );
                $courseids = $db->loadObjectList();
                return $courseids;
	}

        function getDepartmentName($pid)
        {
                $q = 'SELECT departmentname FROM #__staffdepartments WHERE id ='.$pid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $d = $db->loadObject();
                return $d->departmentname;
        }

	function getCategories()
        {
                $query = "SELECT id,categoryname FROM #__staffcategories";
                $db = & JFactory::getDBO();
                $db->setQuery( $query );
                $categories = $db->loadObjectList();
                return $categories;
        }


        function getCategoryName($pid)
        {
                $q = 'SELECT categoryname FROM #__staffcategories WHERE id ='.$pid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $d = $db->loadObject();
                return $d->categoryname;
        }

        function getPositions()
        {       
                $query = "SELECT id,positionname FROM #__staffpositions";
                $db = & JFactory::getDBO();
                $db->setQuery( $query );
                $positions = $db->loadObjectList();
                return $positions;
        }


        function getPositionName($pid)
        {
                $q = 'SELECT positionname FROM #__staffpositions WHERE id ='.$pid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $d = $db->loadObject();
                return $c->positionname;
        }

        function getGrades()
        {       
                $query = "SELECT id,gradename FROM #__staffgrades";
                $db = & JFactory::getDBO();
                $db->setQuery( $query );
                $grades = $db->loadObjectList();
                return $grades;
        }


        function getGradeName($pid)
        {
                $q = 'SELECT gradename FROM #__staffgrades WHERE id ='.$pid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $d = $db->loadObject();
                return $c->gradename;
        }


//ClassTeachers
        function getClassTeachers($pcid)
        {
                $db =& JFactory::getDBO();
                $query = "SELECT id,staffid,classid FROM #__classteachers WHERE classid =".$pcid;
                $db->setQuery( $query );
                $records = $db->loadObjectList();
                return $records;
        }

        function getTeacherClasses($pstaffid)
        {
                $db =& JFactory::getDBO();
                $query = "SELECT classid FROM #__classteachers WHERE staffid =".$pstaffid;
                $db->setQuery( $query );
                $classids = $db->loadObjectList();
                return $classids;
        }




        function getTeacherCourseSubjects($pcourseid,$pstaffid,&$subjects)
        {
                $db =& JFactory::getDBO();
		$query = 'SELECT `id`,`subjecttitle`,`subjectcode`,`subjecttype`,`acronym`,`credits`,`passmark`, `marks` FROM #__msubjects WHERE id IN (SELECT subjectid FROM #__subjectteachers WHERE staffid = '.$pstaffid.' AND courseid = '.$pcourseid.')';
                $db->setQuery( $query );
                $subjects = $db->loadObjectList();
                return $subjects;
        }

       function addClassTeacher($pstaffid,$pclassid)
       {
                $q = "INSERT INTO #__classteachers(classid,staffid) VALUES('".$pclassid."','".$pstaffid."')";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

        function deleteClassTeacher($pids)
        {
                $ids = implode(',',$pids);
                $q = 'DELETE FROM #__classteachers WHERE id IN ('.$ids.')';
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }


       function addSubjectTeacher($pcourseid,$psubjectid,$pstaffid)
       {
                $q = "INSERT INTO #__subjectteachers(courseid,subjectid,staffid) VALUES('".$pcourseid."','".$psubjectid."','".$pstaffid."')";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }


        function deleteSubjectTeacher($pcourseid,$psubjectid,$pstaffid)
        {
                $q = 'DELETE FROM #__subjectteachers WHERE courseid='.$pcourseid.' AND subjectid='.$psubjectid.' AND staffid='.$pstaffid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }
//FAACTIVITIES
	function getFAActivity($pid,&$rec)
        {
                $q = 'SELECT id,activityname,activitycode,description FROM #__faactivities WHERE id ='.$pid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
        }


       function addFAActivity($pactivity,$pactivitycode,$pdescription)
       {
                $q = "INSERT INTO #__faactivities(activityname,activitycode,description) VALUES('".$pactivity."','".$pactivitycode."','".$pdescription."')";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

        function updateFAActivity($id,$pactivity,$pactivitycode,$pdescription)
        {
                $q = "UPDATE #__faactivities SET activityname='".$pactivity."', activitycode='".$pactivitycode."', description='".$pdescription."' WHERE id=".$id;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }


        function deleteFAActivity($pids)
        {
                $ids = implode(',',$pids);
                $q = 'DELETE FROM #__faactivities WHERE id IN ('.$ids.')';
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }


        function getFAActivities()
        {
                $query = "SELECT id,activityname,activitycode,description FROM #__faactivities";
                $db = & JFactory::getDBO();
                $db->setQuery( $query );
                $activities = $db->loadObjectList();
                return $activities;
        }
                                   
//LSACTIVITIES
	function getLSActivity($pid,&$rec)
        {
                $q = 'SELECT id,activityname,activitycode,description FROM #__lsactivities WHERE id ='.$pid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
        }


       function addLSActivity($pactivity,$pactivitycode,$pdescription)
       {
                $q = "INSERT INTO #__lsactivities(activityname,activitycode,description) VALUES('".$pactivity."','".$pactivitycode."','".$pdescription."')";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

        function updateLSActivity($id,$pactivity,$pactivitycode,$pdescription)
        {
                $q = "UPDATE #__lsactivities SET activityname='".$pactivity."', activitycode='".$pactivitycode."', description='".$pdescription."' WHERE id=".$id;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }


        function deleteLSActivity($pids)
        {
                $ids = implode(',',$pids);
                $q = 'DELETE FROM #__lsactivities WHERE id IN ('.$ids.')';
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }


        function getLSActivities()
        {
                $query = "SELECT id,activityname,activitycode,description FROM #__lsactivities";
                $db = & JFactory::getDBO();
                $db->setQuery( $query );
                $activities = $db->loadObjectList();
                return $activities;
        }
	
	function getAttitudeAndValue($pid,&$rec)
        {
                $q = 'SELECT id,activityname,activitycode,description FROM #__attitudesandvalues WHERE id ='.$pid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
        }


       function addAttitudeAndValue($pactivity,$pactivitycode,$pdescription)
       {
                $q = "INSERT INTO #__attitudesandvalues(activityname,activitycode,description) VALUES('".$pactivity."','".$pactivitycode."','".$pdescription."')";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

	function updateAttitudeAndValue($id,$pactivity,$pactivitycode,$pdescription)
        {
                $q = "UPDATE #__attitudesandvalues SET activityname='".$pactivity."', activitycode='".$pactivitycode."', description='".$pdescription."' WHERE id=".$id;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }


        function deleteAttitudeAndValue($pids)
        {
                $ids = implode(',',$pids);
                $q = 'DELETE FROM #__attitudesandvalues WHERE id IN ('.$ids.')';
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

        function getAttitudesAndValues()
        {
                $query = "SELECT id,activityname,activitycode,description FROM #__attitudesandvalues";
                $db = & JFactory::getDBO();
                $db->setQuery( $query );
                $activities = $db->loadObjectList();
                return $activities;
        }

	function getCoScholasticAActivity($pid,&$rec)
        {
                $q = 'SELECT id,activityname,activitycode,description FROM #__coscholasticaactivities WHERE id ='.$pid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
        }


       function addCoScholasticAActivity($pactivity,$pactivitycode,$pdescription)
       {
                $q = "INSERT INTO #__coscholasticaactivities(activityname,activitycode,description) VALUES('".$pactivity."','".$pactivitycode."','".$pdescription."')";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

        function updateCoScholasticAActivity($id,$pactivity,$pactivitycode,$pdescription)
        {
                $q = "UPDATE #__coscholasticaactivities SET activityname='".$pactivity."', activitycode='".$pactivitycode."', description='".$pdescription."' WHERE id=".$id;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }


        function deleteCoScholasticAActivity($pids)
        {
                $ids = implode(',',$pids);
                $q = 'DELETE FROM #__coscholasticaactivities WHERE id IN ('.$ids.')';
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }


        function getCoScholasticAActivities()
        {
                $query = "SELECT id,activityname,activitycode,description FROM #__coscholasticaactivities";
                $db = & JFactory::getDBO();
                $db->setQuery( $query );
                $activities = $db->loadObjectList();
                return $activities;
        }

	function getCoScholasticBActivity($pid,&$rec)
        {
                $q = 'SELECT id,activityname,activitycode,description FROM #__coscholasticbactivities WHERE id ='.$pid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
        }


       function addCoScholasticBActivity($pactivity,$pactivitycode,$pdescription)
       {
                $q = "INSERT INTO #__coscholasticbactivities(activityname,activitycode,description) VALUES('".$pactivity."','".$pactivitycode."','".$pdescription."')";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

        function updateCoScholasticBActivity($id,$pactivity,$pactivitycode,$pdescription)
        {
                $q = "UPDATE #__coscholasticbactivities SET activityname='".$pactivity."', activitycode='".$pactivitycode."', description='".$pdescription."' WHERE id=".$id;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }


        function deleteCoScholasticBActivity($pids)
        {
                $ids = implode(',',$pids);
                $q = 'DELETE FROM #__coscholasticbactivities WHERE id IN ('.$ids.')';
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }


        function getCoScholasticBActivities()
        {
                $query = "SELECT id,activityname,activitycode,description FROM #__coscholasticbactivities";
                $db = & JFactory::getDBO();
                $db->setQuery( $query );
                $activities = $db->loadObjectList();
                return $activities;
        }

        function getClassTotal(&$recs)
        {
                $query = "select classid,(SELECT code FROM #__courses where id = classid) as coursecode, count(studentid) as classtotal from #__studentclass group by classid having classid IN (SELECT id FROM #__courses where aid IN (SELECT id FROM #__academicyears WHERE status='Y'));";
                $db = & JFactory::getDBO();
                $db->setQuery( $query );
                $recs = $db->loadObjectList();
                return true;
	}

        function getClassStrength($classid,&$total)
        {
                $query = "select classid,count(*) as total from #__studentclass WHERE classid='".$classid."'";
                $db = & JFactory::getDBO();
                $db->setQuery( $query );
                $total = $db->loadObject()->total;
                return true;
	}

        function getClassTotal1(&$recs)
        {
                $query = "(SELECT id FROM #__courses where aid IN (SELECT id FROM #__academicyears WHERE status='Y'));";
                $db = & JFactory::getDBO();
                $db->setQuery( $query );
                $recs = $db->loadObjectList();
                return true;
	}
	


}
