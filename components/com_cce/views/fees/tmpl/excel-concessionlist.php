<?php
        defined('_JEXEC') OR DIE('Access denied..');

     	 header("Content-type: application/octet-stream");
     	 header("Pragma: no-cache");
     	 header("Expires: 0");

        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');
	$Itemid = JRequest::getVar('Itemid');
        $fromdate= JRequest::getVar('fromdate');
	$iconsDir1 = JURI::base() . 'components/com_cce/images';

	$a=explode('-',$fromdate);
	$fdate=$a[2].'-'.$a[1].'-'.$a[0];

   	$model = & $this->getModel('fees');
	$recs= $model->getConcessionList();

	$cols = 5 ;
      	header("Content-Disposition: attachment; filename=concessionlist.xls");
	
	$screc=$model->getSchoolInfo();
   	
	$link1= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=fees&view=fees&task=display&layout=groupconcessionlist&Itemid='.$masterItemid);
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
			<h4><?php echo "CONCESSION LIST"; ?>  </h4>
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
	<th align="center" valign="middle">STUDENT NAME</th>
	<th align="center" valign="middle">CLASS</th>
	<th align="center" valign="middle">FEEHEAD</th>
	<th align="center" valign="middle">AMOUNT</th>
</tr>
</thead>   
<tbody>
<?php
	setlocale(LC_MONETARY,"en_IN");
	$i=1;
	$sum=0;
	foreach($recs as $rec) {
		echo '<tr>';
		echo '<td align="centeR">';
		printf("%02d",$i++);
		echo '</td>';
		echo '<td>';
		echo $rec->studentname;
		echo '</td>';
		echo '<td>';
		echo $rec->classname;
		echo '</td>';
		echo '<td>';
		echo $rec->feetitle;
		echo '</td>';
		echo '<td align="right">';
		echo '<b>&#8377;&nbsp;'.$model->formatInIndianStyle($rec->amount).'</b>';
		$sum=$sum+$rec->amount;
		//echo '<b>'.money_format("%i",$rec->paidamount).'</b>';
		echo '</td>';
		echo '</tr>';	
	}
?>
<tr>
<td align="right" colspan="4"><b>TOTAL AMOUNT</b></td>
<td align="right"> <b>&#8377;&nbsp; <?php echo $model->formatInIndianStyle($sum); ?> </b></td>
</tr>
</tbody>
</table>            
