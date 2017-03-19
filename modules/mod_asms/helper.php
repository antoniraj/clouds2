<?php
class modASMSHelper
{
    function getSMSApproveList( $params )
    {
		$db =& JFactory::getDBO();
                $query = "SELECT `id`,`smstext`,`smstype`,date_format(`smsdate`,'%d-%m-%Y') AS `fsmsdate`, `smstime`,`sentby`,`sentto`,`sids`,`status` FROM #__studentsmslog WHERE (`status` = 'N') AND (`aid` IN (SELECT `id` FROM `#__academicyears` WHERE `status` = 'Y')) ORDER BY fsmsdate DESC, smstime DESC";
                $db->setQuery( $query );
                $recs = $db->loadObjectList();
		$i=1;
$s = '<table style="border-style:solid;border-width:1px; border-color:grey;" width="100%" cellspacing="2" cellpadding="3">';
		$s = $s.'<tr style="border:1px; border-color:grey;">';
		$s = $s.'<th style="border:1px; border-color:grey; background-color:#ff8200; color:white;">Date</th>';
		$s = $s.'<th style="border:1px; border-color:grey; background-color:#ff8200; color:white;">To</th>';
		$s = $s.'<th style="border:1px; border-color:grey; background-color:#ff8200; color:white;">Message</th>';
		$s = $s.'</tr>';
		foreach($recs as $rec)
		{
     			if($rec->status==='N')
        		{
				$s = $s.'<tr style="border:1px; border-color:grey;">';
					$s = $s.'<td style="border:1px; border-color:grey;">';
					$s = $s.$rec->fsmsdate;
					$s = $s.'</td>';
					$s = $s.'<td style="border:1px; border-color:grey;">';
					$s = $s.$rec->sentto;
					$s = $s.'</td>';
					//$s = $s.'<td style="border:none;">';
					//$s = $s.$rec->smstime;
					//$s = $s.'</td>';
					$s = $s.'<td style="border:1px; border-color:grey;"><b>';
					$s = $s.$rec->smstext;
					$s = $s.'</b></td>';
					//$s = $s.'<td style="border:none;">';
					//$s = $s.$rec->sentby;
					//$s = $s.'</td>';
        			$s = $s.'</tr>';
        		}
        		$i++;
		}
		$s = $s.'</table>';
                return $s;
	}
}
?>

