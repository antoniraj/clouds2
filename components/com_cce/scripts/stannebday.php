#!/usr/bin/php
<?php
	
	function sms_api($smstext,$mobiles,&$res){
		//Please Enter Your Details
 		$user="stannesmatric"; //your username
 		$password="2015.icc"; //your password
 		//$mobilenumbers="919XXXXXXXXX"; //enter Mobile numbers comma seperated
 		$mobilenumbers=$mobiles; //enter Mobile numbers comma seperated
 		$message = $smstext; //enter Your Message 
 		$senderid="STANNE"; //Your senderid
 		$messagetype="normal"; //Type Of Your Message
		$url="http://bhashsms.com/api/sendmsg.php";
 		//domain name: Domain name Replace With Your Domain  

 		$message = urlencode($message);
 		$ch = curl_init(); 
 		if (!$ch){die("Couldn't initialize a cURL handle");}
 		$ret = curl_setopt($ch, CURLOPT_URL,$url);
 		curl_setopt ($ch, CURLOPT_POST, 1);
 		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);          
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
 		curl_setopt ($ch, CURLOPT_POSTFIELDS,"user=$user&pass=$password&sender=$senderid&phone=$mobilenumbers&text=$message&priority=ndnd&stype=normal");
		// Timeout in seconds
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
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



	//Process Starts
		
	//while there are records to be processed repeatedly do
	include_once('/var/www/html/stannesmatrictvr.in/public_html/icc/configuration.php');
	$obj = new JConfig();
 	$con = mysql_connect("localhost",$obj->user,$obj->password) or die(mysql_error());
        mysql_select_db($obj->db) or die(mysql_error());

        $sql = "SELECT id,smstext,mobile,cdate,ctime,logid,sid,stype,aid FROM $obj->dbprefix"."sms_sent_q";

        $result = mysql_query($sql);


        while($row = mysql_fetch_array($result)){
		//send sms
	//	$rs=sms_api($row['smstext'],$row['mobile'],$resdata);
		echo "Message sent";
		$rs=true;
		if($rs==true){
                	$q = "INSERT INTO $obj->dbprefix"."sms_sent_status_q(`id`,`smstext`,`mobile`,`stype`,`cdate`,`ctime`,`sid`,`logid`,`aid`,`errorcode`,`errortext`) VALUES('".$row['id']."','".$row['smstext']."','".$row['mobile']."','".$row['stype']."','".$row['cdate']."','".$row['ctime']."','".$row['sid']."','".$row['logid']."',(SELECT id FROM ya_academicyears WHERE status='Y'),'0','".$resdata."')";
		}else{
                	$q = "INSERT INTO $obj->dbprefix"."sms_sent_status_q(`id`,`smstext`,`mobile`,`stype`,`cdate`,`ctime`,`sid`,`logid`,`aid`,`errorcode`,`errortext`) VALUES('".$row['id']."','".$row['smstext']."','".$row['mobile']."','".$row['stype']."','".$row['cdate']."','".$row['ctime']."','".$row['sid']."','".$row['logid']."',(SELECT id FROM ya_academicyears WHERE status='Y'),'1','".$resdata."')";
		}
		$result1 = mysql_query($q);
		if(mysql_affected_rows()>0){
			echo 'Suucess \n';
		}else{	
			echo 'Something went wrong..!\n';	
		//	$rs=sms_api($row['smstext'],$row['mobile'],$resdata);
		}
		sleep(2);

        }

	exit;
?>

