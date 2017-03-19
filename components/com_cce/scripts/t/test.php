#!/usr/bin/php
<?php


        function sms_balance(&$res){
                //Please Enter Your Details
//                $user="williamsundaram"; //your username
  //              $password="54321"; //your password
                //$mobilenumbers="919XXXXXXXXX"; //enter Mobile numbers comma seperated
                //$url="http://sms.ischoolcare.in/api/checkbalance.php";
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




	//RETURNS CODE  such as 1004, etc
        function sms_status_api($msgid,$mobiles,&$res){
                //Please Enter Your Details
                //$user="stannesmatric"; //your username
                //$mobilenumbers="919XXXXXXXXX"; //enter Mobile numbers comma seperated
                $mobilenumbers=$mobiles; //enter Mobile numbers comma seperated
                //$url="http://sms.ischoolcare.in/api/recdlr.php";
                $url="http://msg.santhagroups.com/app/miscapi/576a2d625b7e2/getDLR/".$msgid;
                //domain name: Domain name Replace With Your Domain  



                $ch = curl_init();
                if (!$ch){die("Couldn't initialize a cURL handle");}
                $ret = curl_setopt($ch, CURLOPT_URL,$url);
                curl_setopt ($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                // Timeout in seconds
                curl_setopt($ch, CURLOPT_TIMEOUT, 50);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
         //       curl_setopt ($ch, CURLOPT_POSTFIELDS,"user=$user&msgid=$msgid&phone=$mobilenumbers&msgtype=ndnd");
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
			$arr=json_decode($curlresponse,true);
                        $res=$arr[$mobiles];    //echo "Message Sent Succesfully" ;
                        return true;
                }

        }




        function sms_api($smstext,$mobiles,&$res){
                //Please Enter Your Details
                //$user="williamsundaram"; //your username
               // $password="54321"; //your password
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



	sms_status_api('api_5783392f291dd','9626113655',$res);
	echo $res;


	sms_balance($res);
	echo $res;

        sms_api("WELCOME IT'S A SAMPLE",'8489185006',$res);
	echo $res;


?>
