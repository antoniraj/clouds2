<?php
        defined('_JEXEC') OR DIE('Access denied..');
     	 header("Content-type: application/octet-stream");
     	 header("Pragma: no-cache");
     	 header("Expires: 0");


        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	$Itemid = JRequest::getVar('Itemid');
        $fromdate= JRequest::getVar('fromdate');
	if(!isset($fromdate)){
		$fromdate = date('d-m-Y');
	}
	$iconsDir1 = JURI::base() . 'components/com_cce/images';

   	$model = & $this->getModel('fees');
	$model->getSchoolInfo($screc);
	$recs= $model->getFeeCollectionDatewise($fromdate);

      	header("Content-Disposition: attachment; filename=dailycollection.xls")

?>

<table border="0">
	<tr>
		<td colspan="6" align="center">
			<h2><?php echo $screc->schoolname; ?>  </h2>
		</td>
	</tr>
	<tr>
		<td colspan="6" align="center">
			<h5><?php echo $screc->schooladdress; ?> </h5>
		</td>
	</tr>
	<tr>
		<td colspan="6" align="center">
			<h4><?php echo "DAILY COLLECTION [".$fromdate."]"; ?>  </h4>
		</td>
	</tr>
	<tr>
		<td >
		</td>
	</tr>
</table>


<table border="1" width="100%">
	<thead>
		<tr>
			<th width="10%">SNO</th>
			<th width="35%">STUDENT NAME</th>
			<th width="10%">CLASS</th>
			<th width="25%">FEEHEAD</th>
			<th width="10%">RECEIPTNO</th>
			<th width="10%">AMOUNT</th>
		</tr>
	</thead>   
<tbody>
<?php
	setlocale(LC_MONETARY,"en_IN");
	$i=1;
	$sum=0;
	foreach($recs as $rec) {
		echo '<tr style="height:30px;">';
		echo '<td>';
		printf("%02d",$i++);
		echo '</td>';
		echo '<td width="35%">';
		echo $rec->studentname;
		echo '</td>';
		echo '<td>';
		echo $rec->coursename;
		echo '</td>';
		echo '<td>';
		echo $rec->feetitle;
		echo '</td>';
		echo '<td style="text-align:center;" align="center">';
		echo $rec->receiptno;
		echo '</td>';
		echo '<td style="text-align: right;" align="right">';
		echo '<b style="font-family:Arial;"> &#8377;&nbsp;'.$model->formatInIndianStyle($rec->paidamount).'</b>';
		//echo '<b>'.money_format("%i",$rec->paidamount).'</b>';
		echo '</td>';
		$sum=$sum+$rec->paidamount;
//		echo '<td style="text-align:center;">';
//   		$canlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=fees&view=fees&task=display&layout=dailycollection&task=cancelreceipt&rno='.$rec->receiptno.'&Itemid='.$Itemid);
//		echo '<a href="'.$canlink.'">X</a>';	
//		echo '</td>';
		echo '</tr>';	
	}
?>
<tr>
<td style="text-align:right;" colspan="5" align="right"><b>TOTAL AMOUNT</b></td>
<td style="text-align:right;font: bold 18px verdana, serif;font-family:Arial;" align="right"> <b>&#8377;&nbsp; <?php echo $model->formatInIndianStyle($sum); ?> </b></td>
</tr>
</tbody>
</table>            
