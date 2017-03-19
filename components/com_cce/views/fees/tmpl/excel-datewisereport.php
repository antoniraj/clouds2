<?php
        defined('_JEXEC') OR DIE('Access denied..');

     	 header("Content-type: application/octet-stream");
     	 header("Pragma: no-cache");
     	 header("Expires: 0");


        $app = JFactory::getApplication();

        $todate= JRequest::getVar('todate');
	if(!isset($todate)){
		$todate = date('d-m-Y');
	}
        $fromdate= JRequest::getVar('fromdate');
	if(!isset($fromdate)){
		$fromdate = date('01'.'-m-Y');
	}

   	$model = & $this->getModel('fees');
	$screc=$model->getSchoolInfo();
	
	$cols = 3 ;
      	header("Content-Disposition: attachment; filename=datewisereport.xls");
?>

<table border="0">
	<tr>
		<td colspan="<?php echo $cols; ?>" align="center">
			<h2><?php echo $screc->schoolname; ?>  </h2>
		</td>
	</tr>
	<tr>
		<td colspan="<?php echo $cols; ?>" align="center">
			<h5><?php echo $screc->schooladdress; ?> </h5>
		</td>
	</tr>
	<tr>
		<td colspan="<?php echo $cols; ?>" align="center">
			<h3><?php echo "DATEWISE FEE COLLECTION REPORT"; ?>  </h3>
		</td>
	</tr>
	<tr>
		<td colspan="<?php echo $cols; ?>" align="center">
			<h4><?php echo "$fromdate TO  $todate"; ?>  </h4>
		</td>
	</tr>
	<tr>
		<td >
		</td>
	</tr>
</table>


<table border="1">
<thead>
<tr>
<th align="center" valign="middle">SNO</th>
<th align="center" valign="middle">DATE</th>
<th align="center" valign="middle">AMOUNT</th>
</tr>
</thead>   
<tbody>

<?php
	setlocale(LC_MONETARY,"en_IN");
	$i=1;
	$gtsum=0;
	$fdate = date('Y-m-d',strtotime($fromdate));
	$tdate = date('Y-m-d',strtotime($todate));
	$model->getDateWiseFeeCollection($fdate,$tdate,$drecs);
	foreach($drecs as  $drec){
                echo '<tr style="height:30px;">';
                echo '<td align="center">';
	                printf("%02d",$i++);
                echo '</td>';
                echo '<td align="center">';
			$a=explode('-',$drec->paiddate);
			$c1date=$a[2].'-'.$a[1].'-'.$a[0];
                	echo $c1date;
                echo '</td>';
                echo '<td align="right">';
         	       echo '<b> &#8377;&nbsp;'.$model->formatInIndianStyle($drec->paidamount).'</b>';
                echo '</td>';
                echo '</tr>';
		$gtsum=$gtsum+$drec->paidamount;
	}
?>
<tr>
<td align="right" colspan="2"><b>TOTAL AMOUNT</b></td>
<td align="right"> <b> <?php echo '&#8377;&nbsp;'.$model->formatInIndianStyle($gtsum); ?> </b></td>
</tr>
</tbody>
</table>            

