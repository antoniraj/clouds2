<?php
//include_once('../../components/com_cce/models/cce.php');
class modRemindersHelper
{
    function getReport( $params )
    {

		//$obj = new CceModelCce;
		$db =& JFactory::getDBO();
                $query = "SELECT id,cdate,description FROM #__reminders WHERE length(description) >= 3  AND cdate >= current_date LIMIT 10";
                $db->setQuery( $query );
                $events = $db->loadObjectList();
		
		$s = '<table style="border-style:solid;border-width:1px; border-color:grey;" width="100%" cellspacing="2" cellpadding="3">';
		$s = $s.'<tr style="border:1px; border-color:grey;">';
		$s = $s.'<th style="border:1px; border-color:grey; background-color:#ff8200; color:white;">Date</th>';
		$s = $s.'<th style="border:1px; border-color:grey; background-color:#ff8200; color:white;">Day</th>';
		$s = $s.'<th style="border:1px; border-color:grey; background-color:#ff8200; color:white;">Programme</th>';
		$s = $s.'</tr>';
		foreach ($events as $event){
			$dte = new DateTime($event->cdate);
			list($y,$m,$d) = explode("-",$event->cdate);
			$cdate = $d."-".$m."-".$y;
			$s = $s.'<tr style="border:1px; border-color:grey;">';
			$s = $s.'<td style="border:1px; border-color:grey;"><b>';
			$s = $s.$cdate.'</b>';
			$s = $s.'</td>';
			$s = $s.'<td style="border:1px; border-color:grey;">';
			$s = $s.$dte->format('D').'</b>';
			$s = $s.'</td>';
			$s = $s.'<td style="border:1px; border-color:grey;">';
			$s = $s.$event->description;
			$s = $s.'</td>';
			$s = $s.'</tr>';
		}
		$s = $s.'</table>';
                return $s;
    }
}
?>

