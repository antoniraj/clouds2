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



	$screc=$model->getSchoolInfo();
	$rs = $model->getFeeStructure($fstid,$fsrec);
	$rs  = $model->getFeeCategory($fcid,$fcrec);

	$fsrecs = $model->getFeeStructures();
	$accounts = $model->getFeeAccounts();
	$fcrecs = $model->getFeeCategoriesByStructure($fstid);	
	$courses = $model->getFeeCategoryCourses($fcid);
	$fprecs = $model->getFeeParticulars1($accountid,$fcid);
	
	$cols = 4 + count($fprecs);

      	header("Content-Disposition: attachment; filename=expected.xls")

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
			<h4><?php echo "EXPECTED FEES - [".$fsrec->title."]"; ?>  </h4>
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


<div class="pull-right">
</div>				
	<div class="row-fluid sortable">		
		<div class="box span12">
			<div class="box-content">
				<table border="1">
				<thead>
					<tr>
						<th align="center" valign="middle">SNO</th>
						<th align="center" valign="middle">CLASS</th>
						<th align="center" valign="middle">STRENGTH</th>
						<?php
							foreach($fprecs as  $head){
								if($head->groupbased=="1") $gbsym='*';
								else $gbsym='';
								echo '<th class="list-title" style="text-align:center;">'.$head->description.$gbsym.'<br />['.$head->amount.']</th>';
							}
						?>	
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

	foreach($courses as $course) {
		$scount=0;
		$cnsum=0;
		$model->getClassStrength($course->id,$scount);
		$stcount=$stcount+$scount;
		echo '<tr style="height:30px;" align="center">';
		echo '<td>';
			printf("%02d",$i++);
		echo '</td>';
		echo '<td>';
			echo $course->code;
		echo '</td>';
		echo '<td style="text-align:center;">';
			echo $scount;
		echo '</td>';
		foreach($fprecs as $head){
			if($head->groupbased=="1"){
				if(!$model->getGroupMembersCountByClass($head->id,$course->id,$scount))
					$scount = 0;
				$fpamount=$head->amount;
			}else{
				if($model->getCourseFeeParticular($accountid,$course->id,$head->id,$fprec)) 
					$fpamount=$fprec->amount;
				else 
					$fpamount=0;
			}
			$sfpamount = $scount * $fpamount;
			//to find col wise sum
			$sum[$head->id]=$sum[$head->id]+($sfpamount);	
			$cnsum = $cnsum + $sfpamount;
			echo '<td style="text-align:right;" align="right">';
				echo "&#8377;&nbsp;".$model->formatInIndianStyle($sfpamount)."";
			echo '</td>';
		}
		$nsum=$nsum+$cnsum;
	
		echo '<td style="text-align:right;" align="right">';
		//echo money_format("%i", $netsum);
			echo '<b>&#8377;&nbsp;'.$model->formatInIndianStyle($cnsum).'</b>';
		echo '</td>';
		echo '</tr>';	
	}
?>
<tr>
<td style="text-align:right;" colspan="2" align="right"><b>TOTAL AMOUNT</b></td>
<td style="text-align:right;font: bold 15px verdana, serif;" align="right"> <b> <?php echo $stcount; ?> </b></td>

<?php
foreach($fprecs as $head){  ?>
	<td style="text-align:right;font: bold 15px verdana, serif;font-family:Arial;" align="right"> <b> <?php echo '&#8377;&nbsp;'.$model->formatInIndianStyle($sum[$head->id]); ?> </b></td>
<?php } ?>
<td style="text-align:right;font: bold 15px verdana, serif;font-family:Arial;" align="right"> <b> <?php echo '&#8377;&nbsp;'.$model->formatInIndianStyle($nsum); ?> </b></td>
</tr>
</tbody>
</table>            
</div>
</div><!--/span-->
</div><!--/row-->

