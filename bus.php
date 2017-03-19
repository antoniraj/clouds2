 <?php 
 // Connects to your Database
 $route=$_REQUEST['route'];
 
 $flag=0;
 mysql_connect("localhost", "root", "") or die(mysql_error()); 
 mysql_select_db("addon") or die(mysql_error()); 
 $data = mysql_query("SELECT * FROM ya_trans_vdetails where route='".$route."'") 
 or die(mysql_error()); 
 while($info = mysql_fetch_array( $data )) 
 { 
 		$val=$info['vname'];
		echo $val.',';
 } 


  
 ?> 