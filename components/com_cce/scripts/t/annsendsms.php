#!/usr/bin/php
<?php


        function sms_balance(&$res){
                $url="http://msg.santhagroups.com/app/miscapi/576a2d625b7e2/getBalance/true/";
                //domain name: Domain name Replace With Your Domain  
                $ch = curl_init();
                if (!$ch){die("Couldn't initialize a cURL handle");}
                $ret = curl_setopt($ch, CURLOPT_URL,$url);
                curl_setopt ($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
               // curl_setopt ($ch, CURLOPT_POSTFIELDS,"user=$user&pass=$password");
                // Timeout in seconds
                curl_setopt($ch, CURLOPT_TIMEOUT, 50);
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



        function sms_api($smstext,$mobiles,&$res){
                //Please Enter Your Details
                $key="576a2d625b7e2"; //your username
                $type="text"; //your password
                //$mobilenumbers="919XXXXXXXXX"; //enter Mobile numbers comma seperated
                $mobilenumbers=$mobiles; //enter Mobile numbers comma seperated
                $message = urlencode($smstext);
                //$senderid="IACICC"; //Your senderid
                $senderid="STMARY"; //Your senderid
                //$url="http://msg.santhagroups.com/app/smsapi/index.php";
                $url="http://msg.santhagroups.com/app/smsapi/index.php?key=".$key."&type=".$type."&contacts=".$mobilenumbers."&senderid=".$senderid."&msg=".$message);
                //$url="http://bhashsms.com/api/sendmsg.php";
                //domain name: Domain name Replace With Your Domain  

                $ch = curl_init();
                if (!$ch){die("Couldn't initialize a cURL handle");}
                $ret = curl_setopt($ch, CURLOPT_URL,$url);
                curl_setopt ($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
//                curl_setopt ($ch, CURLOPT_POSTFIELDS,"key=$key&type=$type&senderid=$senderid&contacts=$mobilenumbers&msg=$message");
                // Timeout in seconds
                curl_setopt($ch, CURLOPT_TIMEOUT, 50);
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






	//START
	touch ('/tmp/anncheck');

	$vmobile='9486844736';

	$dir='/var/www/html/stannesmatrictvr.in/public_html/stannes/components/com_cce/smstemp/';
	$lockfile=$dir.'smslock';
	$readyfile=$dir.'smssent.txt';
	$runfile=$dir.'stop.txt';
	$logfile=$dir.'smserrorlog-'.date('Y-m-d').'.txt';

	if(file_exists($runfile)){
		echo 'Sending has been stoped..';
		exit;
	}


	//Running already?
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


	//user sent sms
	if(file_exists($readyfile)){
		echo "User has sent sms\n";
		//remove sent flag
		unlink($readyfile);
	}else{
		echo "No send flag\n";
		exit;
	}


        //Calculate the balance credits
        $credits=0;
        $ss=sms_balance($credits);
        echo "Credits:$credits\n";
        if($credits < 5) {
                echo "Low credits";
                $mm='Recharge credits immediately (credits < 5)';
                $sss=sms_api($mm,$vmobile,$resdata);
		touch($readyfile);
                exit;
        }

	//Process Starts
		
	//Create a lock file

	touch($lockfile);
	//store pid in the lock file
	$pid=getmypid()."\n"; 
	file_put_contents($lockfile, $pid);
	//while there are records to be processed repeatedly do
	include_once('/var/www/html/stannesmatrictvr.in/public_html/stannes/configuration.php');
	$obj = new JConfig();
 	$con = mysql_connect("localhost",$obj->user,$obj->password) or die(mysql_error());
        mysql_select_db($obj->db) or die(mysql_error());

        $sql = "SELECT id,smstext,mobile,cdate,ctime,logid,sid,stype,aid FROM $obj->dbprefix"."sms_sent_q";

        $result = mysql_query($sql);

	//Send Verification message
	$rrows = mysql_num_rows($result);



	$df=0;  //Number of processed failed records
	$ds=0;	//Number of successful records
	$db=0;	//Backed up (send failed) records

	$loghandle = fopen($logfile, 'a');

	$ff=1;
        while($row = mysql_fetch_array($result)){
		//If the stop file exits stop
		if(file_exists($runfile)){
			echo "Sending has been stoped..\n";
			$ff=0;
			touch($readyfile);
			break;
		}

		if($ff==1){
		//Send a test message to tester
			$stext1=$row['smstext'].'['.$rrows.']';
			$sss=sms_api($stext1,$vmobile,$resdata);
		//	$sss=sms_api($stext1,$pmobile,$resdata);
			//Wait for 5 mins
			for($c=1;$c<=10;$c++){
				sleep(1);
				echo "Waiting..\n";
				touch($lockfile);
			}
					
		}else{	
			sleep(1); //To avoid DoS
		}
		$ff++;

		//Calculate credits
		if(strlen($row['smstext'])>=160) $smsc=2;
		else $smsc=1;
		
		$credits = $credits - $smsc;
		if($credits < 5){
			$mm='Low credits < 5';
			$sss=sms_api($mm,$vmobile,$resdata);
			//remove lock file
			if($loghandle) fclose($loghandle);	
			unlink($lockfile);
			touch($readyfile);
			exit;
		}
	
		$resdata='Processed';
                $q = "INSERT INTO $obj->dbprefix"."sms_sent_status_q(`id`,`smstext`,`mobile`,`stype`,`cdate`,`ctime`,`sid`,`logid`,`aid`,`errorcode`,`errortext`,`hcode`) VALUES('".$row['id']."','".mysql_real_escape_string($row['smstext'])."','".$row['mobile']."','".$row['stype']."','".$row['cdate']."','".$row['ctime']."','".$row['sid']."','".$row['logid']."',(SELECT id FROM $obj->dbprefix"."academicyears WHERE status='Y'),'0','".mysql_real_escape_string($resdata)."','".md5($row['sid'].$row['cdate'].$row['smstext'].$row['stype'])."')";
		$result1 = mysql_query($q);
		
		$stext=$row['smstext'];
		if(mysql_affected_rows()>0){
			echo "Processed\n";
			//send sms
			$rs=sms_api($row['smstext'],$row['mobile'],$resdata);
			if($rs==false){
				echo "Send Failed: bk\n";
				//Failed records to 
                		$q3 = "INSERT INTO $obj->dbprefix"."sms_sent_q_bk(`id`,`smstext`,`mobile`,`stype`,`cdate`,`ctime`,`sid`,`logid`,`aid`) VALUES('".$row['id']."','".mysql_real_escape_string($row['smstext'])."','".$row['mobile']."','".$row['stype']."','".$row['cdate']."','".$row['ctime']."','".$row['sid']."','".$row['logid']."',(SELECT id FROM $obj->dbprefix"."academicyears WHERE status='Y'))";
				$result3 = mysql_query($q3);
				if(mysql_affected_rows()>0){
					echo "";
				}else{
					if($loghandle){
						fwrite($loghandle, $q3.'\n');
					}
				}
				$db++;
			}else{   //Update the msg id
				echo "Send Success: Updates msgid\n";
				$sql = "UPDATE $obj->dbprefix"."sms_sent_status_q SET `errortext`='".$resdata."' WHERE id='".$row['id']."'";
				$result4 = mysql_query($sql);
				$ds++;
			}
			
		}else{
			//put the record in a logfile and then delete
			echo "Record insert error: logs and deletes\n";
			if($loghandle){
				fwrite($loghandle, $q.'\n');
			}
			$q5="DELETE FROM $obj->dbprefix"."sms_sent_q WHERE id='".$row['id']."'";
			$result2 = mysql_query($q5);
			$df++;
		}
		touch($lockfile);
        }

	if($ff==1){
		echo "No Records\n";
	}
	if($loghandle) fclose($loghandle);	

	//Report the status	
	if($ds>0 || $df>0 || $db>0){
		$stext='REP:'.$stext.'[SS:'.$ds.'][IF:'.$df.'][SF:'.$db.']';
		$rs=sms_api($stext,$vmobile,$resdata);
	}

	//remove lock file
	unlink($lockfile);

	exit;
?>
