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
        $fstid = JRequest::getVar('fstid');
        $fcid= JRequest::getVar('fcid');
        $accountid= JRequest::getVar('accountid');
	if(!isset($accountid)) $accountid="-1";


	$iconsDir1 = JURI::base() . 'components/com_cce/images';

//	setlocale(LC_ALL, "en_US.UTF-8");
 	setlocale(LC_MONETARY,"en_IN.UTF-8");
   	$model = & $this->getModel('fees');


	$link2= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=fees&view=fees&task=display&layout=reportgroupwiseexpected&Itemid='.$masterItemid);

	$screc=$model->getSchoolInfo();
	$rs = $model->getFeeStructure($fstid,$fsrec);
	$rs  = $model->getFeeCategory($fcid,$fcrec);

	$fsrecs = $model->getFeeStructures();
	$accounts = $model->getFeeAccounts();
	$fcrecs = $model->getFeeCategoriesByStructure($fstid);	
	$courses = $model->getFeeCategoryCourses($fcid);
	$fprecs = $model->getFeeParticulars1($accountid,$fcid);

	$cols = 5 + count($fprecs);
      	header("Content-Disposition: attachment; filename=actualfee.xls")

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
			<h4><?php echo "COLLECTED FEE - [".$fsrec->title."]"; ?>  </h4>
		</td>
	</tr>
	<tr>
		<td colspan="<?php echo $cols; ?>" align="center">
			<h4><?php echo $fcrec->name; ?>  </h4>
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
						<th align="center" valign="middle">CLASS</th>
						<th align="center" valign="middle">STRENGTH</th>
						<?php
							foreach($fprecs as  $head){
								echo '<th class="list-title" style="text-align:center;">'.$head->description.'<br />['.$head->amount.']</th>';
							}
						?>	
						<th align="center" valign="middle">CONS</th>
						<th align="center" valign="middle">NET AMOUNT</th>
					</tr>
				</thead>   
				<tbody>
<?php
	//setlocale(LC_MONETARY,"en_IN");
	$i=1;
	$cnsum=0;
	$nsum=0;
	$stcount=0;
	foreach($fprecs as $head){
		$csum[$head->id]=0;
		$sum[$head->id]=0;
	}

	$s_tot_con=0;
	foreach($courses as $course) {
		$scount=0;
		$cnsum=0;
		$model->getClassStrength($course->id,$scount);
		$stcount=$stcount+$scount;
		echo '<tr">';
		echo '<td align="center">';
			printf("%02d",$i++);
		echo '</td>';
		echo '<td>';
			echo $course->code;
		echo '</td>';
		echo '<td align="center">';
			echo $scount;
		echo '</td>';


		foreach($fprecs as $head){
	
			$r=$model->getClassParticularPaidAmount($course->id,$fcid,$head->id,$torec);
			if(!$r) $fpamount=0;
			else $fpamount=$torec->total;

			$sfpamount = $fpamount;
			//to find col wise sum
			$sum[$head->id]=$sum[$head->id]+($sfpamount);	
			$cnsum = $cnsum + $sfpamount;
			echo '<td align="right">';
				echo "&#8377;&nbsp;".$model->formatInIndianStyle($sfpamount);
			echo '</td>';
		}
	
		$rs = $model->getClassConcessionAmount($accountid,$fcid,$course->id,$conrec);
		if($rs) $tot_con = $conrec->amount;
		else $tot_con =0.0;
		$s_tot_con=$s_tot_con+$tot_con;
		echo '<td align="right">';
		//echo money_format("%i", $netsum);
			echo "&#8377;&nbsp;".$model->formatInIndianStyle($tot_con);
		echo '</td>';
		
		$nsum=$nsum+$cnsum;
	
		echo '<td align="right">';
		//echo money_format("%i", $netsum);
			echo "&#8377;&nbsp;".$model->formatInIndianStyle($cnsum);
		echo '</td>';
		echo '</tr>';	
	}
?>
<tr>
<td align="right" colspan="2"><b>TOTAL AMOUNT</b></td>
<td align="center"> <b> <?php echo $stcount; ?> </b></td>

<?php
foreach($fprecs as $head){  ?>
	<td align="right"> <b> <?php echo '&#8377;&nbsp;'.$model->formatInIndianStyle($sum[$head->id]); ?> </b></td>
<?php } 

?>
<td align="right"> <b> <?php echo '&#8377;&nbsp;'.$model->formatInIndianStyle($s_tot_con); ?> </b></td>
<td align="right"> <b> <?php echo '&#8377;&nbsp;'.$model->formatInIndianStyle($nsum); ?> </b></td>
</tr>
</tbody>
</table>            

