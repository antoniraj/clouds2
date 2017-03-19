
<?php
        function sms_api($smstext,$mobiles,&$res){
                //Please Enter Your Details
                //$user="williamsundaram"; //your username
               // $password="54321"; //your password
                $user="stannesmatric"; //your username
                $password="2015.icc"; //your password
                //$mobilenumbers="919XXXXXXXXX"; //enter Mobile numbers comma seperated
                $mobilenumbers=$mobiles; //enter Mobile numbers comma seperated
                $message = $smstext; //enter Your Message 
                //$senderid="IACICC"; //Your senderid
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



?>
