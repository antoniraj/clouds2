#!/usr/bin/php
<?php
	
	function sms_status_api($msgid,$mobiles,&$res){
		//Please Enter Your Details
		//$user="stannesmatric"; //your username
 		//$mobilenumbers="919XXXXXXXXX"; //enter Mobile numbers comma seperated
 		$mobilenumbers=$mobiles; //enter Mobile numbers comma seperated
		//$url="http://sms.ischoolcare.in/api/recdlr.php";
 		//domain name: Domain name Replace With Your Domain  



 		$ch = curl_init(); 
 		if (!$ch){die("Couldn't initialize a cURL handle");}
 		$ret = curl_setopt($ch, CURLOPT_URL,$url);
 		curl_setopt ($ch, CURLOPT_POST, 1);
 		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);          
		// Timeout in seconds
		curl_setopt($ch, CURLOPT_TIMEOUT, 50);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
 		curl_setopt ($ch, CURLOPT_POSTFIELDS,"user=$user&msgid=$msgid&phone=$mobilenumbers&msgtype=ndnd");
 		$ret = curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		//If you are behind proxy then please uncomment below line and provide your proxy ip with port.
		// $ret = curl_setopt($ch, CURLOPT_PROXY, "PROXY IP ADDRESS:PORT");
 		$curlresponse = curl_exec($ch); // execute
		if(curl_errno($ch))
        		echo 'curl error : '. curl_error($ch);

 		if (empty($ret)) {
    			// some kind of an error happened
    			//die(curl_error($ch));
			$res=curl_error($ch);
    			curl_close($ch); // close cURL handler
			return false;
 		} else {
    			$info = curl_getinfo($ch);
    			curl_close($ch); // close cURL handler
    			//echo "<br>";
        		$res=$curlresponse;    //echo "Message Sent Succesfully" ;
			return true;
		}
		
	}





	$lockfile='/tmp/smsstatuslock';
	//If lock file exists
	// bool file_exists ( string $filename )
	if(file_exists($lockfile)){
		//Is it older than 1 min?
		$mtime=filemtime($lockfile);
		$ctime=time();
		$oldt = $ctime-$mtime;
		if($oldt > 60){
			$pid=file_get_contents($lockfile);
			//kill the process
			exec("kill -9 $pid");
		
			//remove lock file
			unlink($lockfile);
		}else{
			//Already running
			//exit this process
			exit;
		}
	}

	//Process Starts
		
	//Create a lock file

	touch($lockfile);
	//store pid in the lock file
	$pid=getmypid()."\n"; 
	file_put_contents($lockfile, $pid);
	//while there are records to be processed repeatedly do
	include_once('/var/www/html/stannesmatrictvr.in/public_html/icc/configuration.php');
	$obj = new JConfig();
 	$con = mysql_connect("localhost",$obj->user,$obj->password) or die(mysql_error());
        mysql_select_db($obj->db) or die(mysql_error());

        $sql = "SELECT id,smstext,mobile,cdate,ctime,logid,sid,stype,aid,errortext FROM $obj->dbprefix"."sms_sent_status_q WHERE errorcode='0' OR errorcode='1'";

        $result = mysql_query($sql);


        while($row = mysql_fetch_array($result)){
		//send sms
		$rs=sms_status_api($row['errortext'],$row['mobile'],$resdata);
		if($rs==true){
                	$q = "UPDATE $obj->dbprefix"."sms_sent_status_q SET `errorcode`='2', `errortext`='".$resdata."' WHERE id='".$row['id']."'";
		}else{
                	$q = "UPDATE $obj->dbprefix"."sms_sent_status_q SET `errorcode`='3', `errortext`='".$resdata."' WHERE id='".$row['id']."'";
		}
		$result1 = mysql_query($q);
		touch($lockfile);
        }

	//remove lock file
	unlink($lockfile);

	exit;


?>

