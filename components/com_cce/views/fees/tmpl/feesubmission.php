

<?php

//RELOAD THE PAGE WHEN BACK BUTTON IS PRESSED

// any valid date in the past
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
// always modified right now
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
// HTTP/1.1
header("Cache-Control: private, no-store, max-age=0, no-cache, must-revalidate, post-check=0, pre-check=0");
// HTTP/1.0
header("Pragma: no-cache");


        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');
	$Itemid = JRequest::getVar('Itemid');
	$insflag= JRequest::getVar('insflag');
        $courseid= JRequest::getVar('courseid');
        $fcid= JRequest::getVar('fcid');
        $cid= JRequest::getVar('cid');
        $gid= JRequest::getVar('gid');
        $studentid= JRequest::getVar('studentid');
        $groupbased= JRequest::getVar('groupbased');
        $receiptno= JRequest::getVar('receiptno');
	$iconsDir1 = JURI::base() . 'components/com_cce/images';

   	$model = & $this->getModel('fees');
        $r=$model->getCourse($cid,$crec);
	if(!$r){ 
                JError::raiseWarning(500,'Could not load course details..');
		return;
	}
	
	$fcrecs = $model->getFeeCategoriesByStudent($studentid);

	//Get FeePrefix
	$feeprefix=$model->getCurrentFeePrefix()->feeprefix;

	//Generate new Receipt number
	$st = $model->getNewReceiptNo($rno);   //TO VERIFY MAX(ID)+1
	if($st){
		if($rno->newreceiptno==NULL) {
			$receiptno=1;
		}else{
			$receiptno=$rno->newreceiptno;
		}
	}else { 
                JError::raiseWarning(500,'Could not generate receipt no..');
		return;
	}

        $r=$model->getFeeCategory($fcid,$frec);
	if(!$r){ 
                JError::raiseWarning(500,'Could not load fee category details..');
		return;
	}
	$precs = $model->getFeeParticularsByStudent($fcid,$studentid);
	if(!$precs){ 
                JError::raiseWarning(500,'Could not load fee particulars..');
		return;
	}
	$r=$model->getStudent($studentid,$srec);
	if(!$r){ 
                JError::raiseWarning(500,'Could not load student details..');
		return;
	}


//TO BE CONSIDERED
	if($gid>0 && $groupbased=="1")
        	$model->getFeeTransactions1($fcid,$cid,$studentid,$gid,$trecs);
	else
        	$model->getFeeTransactions($fcid,$cid,$studentid,$trecs);



//	$r=$model->getFeeCategoryAmount($fcid,$feeamount);
//	if(!$r){
//		$feeamount=0;
//	}

	$r=$model->getFeeCategoryAmountByStudent($fcid,$studentid,$feeamount);
	if(!$r){
		$feeamount=0;
	}



//DISCOUNT
	$r = $model->getStudentCategory($srec->categoryid,$scatrec);
	if($r){
		$scat=$scatrec->categorycode;
	}else{
		$scat="---";
	}

	$r = $model->getStudentFeeCategoryDiscounts($srec->categoryid,$cid,$fcid,$discount);
	if($r){
		$damount=$feeamount*($discount/100.0);
	}else{
		$damount=0.0;	
	}



	if($gid>0 && $groupbased=="1")
		$r=$model->getStudentGroupFeeConcession($studentid,$fcid,$gid,$camount);
	else
		$r=$model->getStudentFeeConcession($studentid,$fcid,$cid,$camount);
	if(!$r){
		$camount=0.0;
		$caddflag=1;
	}else $caddflag=0;





	if($gid>0) $r = $model->getFineAmount1($gid,$fcid,$fine);
	else $r=$model->getFineAmount($cid,$fcid,$fine);
	if(!$r){
		$fine=0.0;
	}




	$netfee=($feeamount-($damount+$camount)+$fine );
	if($gid>0 && $groupbased=="1")
		$r = $model->getFeeMaster1($fcid,$cid,$gid,$studentid,$fmrec);
	else
		$r = $model->getFeeMaster($fcid,$cid,$studentid,$fmrec);


	if(!$r){
		$paidamount=0.0;
	}else{
		$paidamount=$fmrec->paidamount;
	}
	//$due =  $netfee - $paidamount;

   	$dashboardItemid = $model->getMenuItemid('manageschool','Dash Board');
   	if($dashboardItemid) ;
   	else{
        	$dashboardItemid = $model->getMenuItemid('topmenu','Manage School');
   	}
	$masterItemid = $model->getMenuItemid('manageschool','Fees');
        if($masterItemid) ;
        else{
                $masterItemid = $model->getMenuItemid('topmenu','Manage School');
        }
   	$dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
   	$modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=fees&Itemid='.$masterItemid);
   	$feeschedulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=fees&view=fees&task=display&layout=feecollection&Itemid='.$masterItemid);
   	$feecollectionclasslink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=fees&view=fees&task=display&layout=feecollectionclasslist&&fcid='.$fcid.'&cid='.$cid.'&fsid=&Itemid='.$masterItemid);
   	$feecollectiongrouplink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=fees&view=fees&task=display&layout=feecollectiongrouplist&&fcid='.$fcid.'&gid='.$gid.'&fsid=&Itemid='.$masterItemid);
   	$instantlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=fees&view=fees&task=display&layout=instantcollection&fcid='.$fcid.'&cid='.$cid.'&courseid='.$cid.'&fsid=&Itemid='.$masterItemid);

	$app =& JFactory::getApplication();
        $pathway =& $app->getPathway(); 
        $pathway->addItem('Home', $dashboardlink);
        $pathway->addItem('Fees',$modulelink);
	if($insflag=="1"){
	        $pathway->addItem('Instant Collection',$instantlink);
	}else{
	        $pathway->addItem('Schedule',$feeschedulelink);
		if($groupbased=="1") 
	        	$pathway->addItem('Group',$feecollectiongrouplink);
		else
	        	$pathway->addItem('Class',$feecollectionclasslink);

	}
	$pathway->addItem('Paynow');

?>
<script>




$('body').on('change', '.con', function() {
    document.getElementById("consave").disabled = false;
    document.getElementById("paynow").disabled = true;
    var total=0;
    var i=0;
    $(".con").each(function(){
        quantity = parseInt($(this).val());
        if (!isNaN(quantity)) {
            total += quantity;
        }
	$(".bal").eq(i).attr('readonly',true);
	i++;
    });
    $('.total').val(total);
});


$('body').on('change', '.bal', function() {
    document.getElementById("consave").disabled = true;
//    document.getElementById("paynow").disabled = true;
    var total=0;
    var i=0;
    $(".bal").each(function(){
        quantity = parseInt($(this).val());
        if (!isNaN(quantity)) {
            total += quantity;
        }
	$(".con").eq(i).attr('readonly',true);
	i++;
    });
    $('.paidnow').val(total);
});


//$('body').on('change', '#paidnow', function() {
//	amount = parseInt($(this).val());
//	i=0;
  //  	$(".bal").each(function(){
//		x=$(".con").eq(i).val() ;
//		$(".bal").eq(i).val(x);
//		i++;
//	});
//});


</script>


<center><b style="font: bold 15px Georgia, serif;">FEE PAYMENT FORM</b> </center>

<?php
echo '<table class="table table-striped table-bordered">';
	echo '<tr height="20px">';
		echo '<td width="5%">';
			echo 'Reg No:';
		echo '</td>';
		echo '<td width="3%" align="left">';
			echo $srec->registerno;
		echo '</td>';
		echo '<td width="8%">';
			echo 'Student Name:';
		echo '</td>';
		echo '<td width="14%">';
			echo $srec->firstname;
		echo '</td>';
		echo '<td width="5%">';
			echo 'Class:';
		echo '</td>';
		echo '<td width="5%">';
			echo $crec->code;
		echo '</td>';
		echo '<td width="10%">';
			echo 'Student Category:';
		echo '</td>';
		echo '<td width="5%">';
			echo $scat;
		echo '</td>';
		echo '<td width="5%">';
?>
<form class="form-horizontal" action="<?php echo JRoute::_('index.php'); ?>" method="post" name="adminForm">
        <select id="selectError" data-rel="chosen" onchange="submit();" style="width:300px;" name="fcid">
                <?php
                foreach($fcrecs as $fcrec) :
                        echo "<option value=\"".$fcrec->id."\" ".($fcrec->id == $fcid ? "selected=\"yes\"" : "").">".$fcrec->name."</option>";
                endforeach;
                ?>
        </select>
<!--    <button class="btn btn-small btn-warning" value="go" name="Go"> <i class="icon-edit icon-white"></i>Go</button> -->
        <input type="hidden" name="view" value="fees" />
        <input type="hidden" name="controller" value="fees" />
        <input type="hidden" name="layout" value="feesubmission" />
        <input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
        <input type="hidden" name="courseid" value="<?php echo $courseid; ?>" />
        <input type="hidden" name="cid" value="<?php echo $cid; ?>" />
        <input type="hidden" name="studentid" value="<?php echo $studentid; ?>" />
        <input type="hidden" name="task" value="display"/>
</form>
<?php
		echo '</td>';
	echo '</tr>';
echo '</table>';
echo '<hr />';
?>

<table border="0" width="100%">
<tr>
<td style="text-align:left; vertical-align:top;">
<div class="alert alert-warning" align="left">
	<span class="mytitle"><?php echo $frec->name; ?></span>
</div>

<form action="<?php echo JRoute::_('index.php'); ?>" method="POST" name="adminForm">
<?php
echo '<table class="table table-striped table-bordered">';
	echo '<thead>';
		echo '<tr><th width="5%">S#</th><th width="25%">Particulars</th><th width="10%" align="right">Amount</th><th width="10%" align="right">Concession</th><th width="10%" align="right">Paid</th><th width="10%" align="right">To Pay</th></tr></thead>';
		$sno=1;
		$gextraamount=0; //to find same member in two different groups for single particular so should be chared twice.
		foreach($precs as $prec){
			
			
		echo '<tr>';
			echo '<td>';
				echo $sno++;
			echo '</td>';
			echo '<td>';
				echo $prec->name;
			echo '</td>';	
			echo '<td style="text-align:right;">';
			$gextraamount=0;
			if($prec->groupbased=="1"){
        			$rss=$model->getStudentGroupCountByParticular($prec->id,$studentid,$ttrec);
				if($rss){
					$gextraamount= $prec->amount * ($ttrec->tot - 1);
					$prec->amount=$prec->amount*$ttrec->tot;
				}	
			}
				printf("%.2f",$prec->amount);
			echo '</td>';
			
			$pconid="-1";
			$pconamount=0;
			$rs=$model->getFeeParticularConcession($studentid,$prec->id,$fpcrec);
			if($rs){
				$pconamount=$fpcrec->amount;
				$pconid=$fpcrec->id;
			}	
			$c_paidamount=0;
        		$rs=$model->getFeeTransactionParticularAmount($prec->id,$studentid,$cid,$fcid,$ftpa);
			if($rs){
				$c_paidamount=$ftpa->amount;
			}
			$c_balamount=$prec->amount-$pconamount-$c_paidamount;
			if($c_balamount>0){
				printf('<td style="text-align:right;"><input style="width:100px;text-align:right;" class="con" type="text" name="conn['.$studentid.'$$'.$prec->id.'$$'.$pconid.']" value="%.2f" /></td>',$pconamount);
			}else{
				printf('<td style="text-align:right;">%.2f</td>',$pconamount);
			}
			printf('<td style="text-align:right;">%.2f</td>',$c_paidamount);
			if($c_balamount>0){
				printf('<td style="text-align:right;"><input style="width:100px;text-align:right;" class="bal" type="text" name="bala['.$prec->accountid.'$$'.$prec->id.']" value="%.2f" /></td>',$c_balamount);
			}else{
				printf('<td style="text-align:right;">%.2f</td>',$c_balamount);
			}
		echo '</tr>';
		}
		$due =  ($netfee+$gextraamount) - $paidamount;
	//	echo '<tr>';
	//		echo '<td>';
	//			echo $sno++;
	//		echo '</td>';
	//		echo '<td>';
	//			echo "Late Fee";
	//		echo '</td>';
	//		echo '<td style="text-align:right;">';
	//			printf("%.2f",$fine);
	//		echo '</td>';
	//		echo '<td></td>';
	//		echo '<td></td>';
	//		echo '<td></td>';
	//	echo '</tr>';
		$dsum=0;
		echo '<tr>';
			echo '<td>';
	//			echo $sno++;
			echo '</td>';
			echo '<td>';
	//			echo "Discount (Deduction)";
			echo '</td>';
			echo '<td style="text-align:right;">';
	//		printf("(-) %.2f",$damount);
			echo '</td>';
			echo '<td>';
if($fmrec->status=='0')
	echo '<p style="text-align:right;" ><button class="btn btn-small btn-success"  id="consave" value="Save" name="Save"> <i class="icon-edit icon-white"></i> Save</button></p>';
			echo '</td>';
			echo '<td></td>';
			echo '<td></td>';
		echo '</tr>';
		echo '<tr>';
			echo '<td colspan="2" style="text-align:right;font-size:15pt;">';
				echo "<b>Total Amount</b>";
			echo '</td>';
			echo '<td style="text-align:right;">';
				printf("<b  style=\"font-size: 15pt\">%.2f</b><hr />",$feeamount+$fine+$gextraamount);
			echo '</td>';
			echo '<td style="text-align:right;">';
			if($fmrec->status=='1')
				printf('<b style="font-size:15pt;">%.2f</b>',$camount);
			else{
				echo '<input type="text" readonly style="width:120px;font-size: 15pt;font-weight:bold;color: #000;text-align:right;" class="total" name="concession" value="'.$camount.'" />';
			}
			echo '</td>';
			echo '<td style="text-align:right;">';
				printf("<b  style=\"font-size: 15pt\">%.2f</b><hr />",$paidamount);
			echo '</td>';
			echo '<td style="text-align:right;">';
				printf("<b  style=\"font-size: 15pt\">%.2f</b><hr />",$due);
			echo '</td>';
		echo '</tr>';
	echo '</table>';
?>
</td>
<?php if($fmrec->status=="0" || $fmrec->status==NULL){ ?>
<td style="text-align:left; vertical-align:top;">
<div class="alert alert-warning" align="">
	<span class="mytitle">Payment Options</span>
</div>
<?php
echo '<table class="table table-striped table-bordered">';
	echo '<tr>';
		echo '<td>';
			echo "Payment Mode";
		echo '</td>';
		echo '<td>'; ?>
			<select id="paymentmode" name="paymentmode" style="width:300px;">
				<option value="Cash">Cash</option>
				<option value="Cheque">Cheque</option>
				<option value="DD">DD</option>
			</select>
<?php
		echo '</td>';
	echo '</tr>';
	echo '<tr>';
		echo '<td>';
			echo "Cheque/DD No:";
		echo '</td>';
		echo '<td>';
			echo '<input type="text" value="" name="chequeorddno" id="chequeorddno" style="width:300px;" />';
		echo '</td>';
	echo '</tr>';
	echo '<tr>';
		echo '<td>';
			echo "Cheque/DD Date:";
		echo '</td>';
		echo '<td>';
			//echo '<input type="text" value="" name="chequeordddate" id="chequeordddate" size="60px" />';
			echo JHTML::calendar($chequeordddate,'chequeordddate','chequeordddate','%d-%m-%Y'); 
		echo '</td>';
	echo '</tr>';
	echo '<tr>';
		echo '<td>';
			echo "Bank Details:";
		echo '</td>';
		echo '<td>';
			echo '<input type="text" value="" name="bankdetails" id="bankdetails" style="width: 300px;" />';
		echo '</td>';
	echo '</tr>';
$rtype=2;
if($rtype==1){
	echo '<tr>';
		echo '<td>';
			echo "Receipt No:";
		echo '</td>';
		echo '<td>';
			echo $feeprefix.'-'.'<input type="text" style="font-size: 15pt; text-align:left;width:120px;" value="'.$receiptno.'" name="receiptno" id="receiptno" />';
		echo '</td>';
	echo '</tr>';
}
	echo '<tr>';
		echo '<td>';
			echo "Amount:(Rs.)";
		echo '</td>';
		echo '<td>';
			printf( '<input type="text" class="paidnow" readonly style="font-size: 15pt; font-weight:bold; color: #000; text-align:right;width:150px;" value="%.2f" name="paidnow" id="paidnow" />',$due);
		echo '</td>';
	echo '</tr>';
	echo '<tr>';
		echo '<td>';
		echo '</td>';
		echo '<td>';
//			echo '<input type="submit" name="paynow" id="paynow" class="button_save" value="Pay Now" />';
			echo '<button class="btn btn-small btn-danger"  id="paynow"  value="pay" name="pay"> <i class="icon-edit icon-white"></i> Pay Now</button>';
		echo '</td>';
?>


<input type="hidden" id="view" name="view" value="fees" />
<input type="hidden" id="controller" name="controller" value="fees" />
<!-- <input type="hidden" name="task" id="task" value="savedeductions" /> -->
<input type="hidden" name="layout" id="layout" value="feesubmission" />
<input type="hidden" name="Itemid" id="Itemid" value="<?php echo $Itemid; ?>" />
<input type="hidden" name="caddflag" id="caddflag" value="<?php echo $caddflag; ?>" />
<input type="hidden" name="cid" id="cid" value="<?php echo $cid; ?>" />
<input type="hidden" name="fcid" id="fcid" value="<?php echo $fcid; ?>" />
<input type="hidden" name="groupbased" id="groupbased" value="<?php echo $groupbased; ?>" />
<input type="hidden" name="gid" value="<?php echo $gid; ?>" />
<input type="hidden" name="studentid" id="studentid" value="<?php echo $studentid; ?>" />
<input type="hidden" name="regno" id="regno" value="<?php echo $srec->registerno; ?>" />
		
		<input type="hidden" name="task" id="task" value="savefeetransaction" />
		<input type="hidden" name="gid" id="gid" value="<?php echo $gid; ?>" />
		<input type="hidden" name="balance" id="balance" value="<?php echo $due; ?>" />
		<input type="hidden" name="fine" id="fine" value="<?php echo $fine; ?>" />
	<!--	<input type="hidden" name="concession" id="concession" value="<?php echo $camount; ?>" /> -->
		<input type="hidden" name="discount" id="discount" value="<?php echo $damount; ?>" />
		<input type="hidden" name="fmid" id="fmid" value="<?php echo $fmrec->id; ?>" />
		<input type="hidden" name="insflag" value="<?php echo $insflag; ?>" />
	</form>
<?php
	echo '</tr>';
echo '</table>';
echo '</td>';
}else{

}

?>




<!--
TRANSACTION SUMMARY
-->

</tr><tr><td colspan="2">
<div class="alert alert-warning" align="">
	<span class="mytitle">Transaction Summary</span>
</div>
<?php
$i=1;
echo '<table class="table table-striped table-bordered">';
	echo '<thead>';
	echo '<tr>';
		echo '<th>S#</th>';
		echo '<th>PaidDate</th>';
		echo '<th>Payment Mode</th>';
		echo '<th>ReceiptNo</th>';
		echo '<th>Cheque/DD No</th>';
		echo '<th>Cheque/DD Date</th>';
		echo '<th>Bank Details</th>';
		echo '<th>Amount</th>';
		echo '<th>Cancel</th>';
	echo '</tr>';
	echo '</thead>';
	foreach( $trecs as $trec){
	echo '<tr>';
		echo '<td>';
			echo $i++;
		echo '</td>';
		echo '<td>';
			echo $trec->paiddate;
		echo '</td>';
		echo '<td>';
			echo $trec->paymentmode;
		echo '</td>';
		echo '<td>'; 
?>
		<form action="<?php echo JRoute::_('index.php'); ?>" method="POST" name="adminForm"> <?php
                echo '<input type="submit" class="button_save" name="printreceipt" id="printreceipt" value="'.$trec->receiptno.'-Print" />'; ?>
                                <input type="hidden" id="view" name="view" value="fees" />
                                <input type="hidden" id="controller" name="controller" value="fees" />
                                <input type="hidden" name="task" id="task" value="printfeereceipt" />
                                <input type="hidden" name="layout" id="layout" value="feecollectionclasslist" />
                                <input type="hidden" name="Itemid" id="Itemid" value="<?php echo $Itemid; ?>" />
                                <input type="hidden" name="cid" id="cid" value="<?php echo $cid; ?>" />
                                <input type="hidden" name="balance" id="balance" value="<?php echo $due; ?>" />
        			<input type="hidden" name="gid" value="<?php echo $gid; ?>" />
				<input type="hidden" name="groupbased" id="groupbased" value="<?php echo $groupbased; ?>" />
                                <input type="hidden" name="fine" id="fine" value="<?php echo $fine; ?>" />
                                <input type="hidden" name="concession" id="concession" value="<?php echo $camount; ?>" />
                                <input type="hidden" name="discount" id="discount" value="<?php echo $damount; ?>" />
                                <input type="hidden" name="fcid" id="fcid" value="<?php echo $fcid; ?>" />
                                <input type="hidden" name="studentid" id="studentid" value="<?php echo $studentid; ?>" />
                                <input type="hidden" name="receiptno" id="receiptno" value="<?php echo $trec->receiptno; ?>" />
                                <input type="hidden" name="regno" id="regno" value="<?php echo $srec->registerno; ?>" />
                        </form>
<?php

		echo '</td>';
		if($trec->paymentmode!='Cash'){
		echo '<td>';
			echo $trec->chequeorddno;
		echo '</td>';
		echo '<td>';
			echo $trec->chequeordddate;
		echo '</td>';
		echo '<td>';
			echo $trec->bankname;
		echo '</td>';
		}else{
		echo '<td>';
			echo '-';
		echo '</td>';
		echo '<td>';
			echo '-';
		echo '</td>';
		echo '<td>';
			echo '-';
		echo '</td>';
		}
		echo '<td style="text-align:right;">';
			printf("%.2f", $trec->paidamount);
		echo '</td>';	
		echo '<td style="text-align:center;">';
   		//$canlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=fees&view=fees&task=display&layout=feesubmission&task=cancelreceipt&rno='.$trec->receiptno.'&Itemid='.$Itemid);
   		$canlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=fees&view=fees&task=cancelreceipt&rno='.$trec->receiptno.'&fcid='.$fcid.'&cid='.$cid.'&studentid='.$studentid.'&Itemid='.$Itemid);

		echo '<a class="btn btn-small btn-danger" href="'.$canlink.'">X</a>';	
		echo '</td>';
	echo '</tr>';
}
echo '</table>';
?>
</td>
</tr>
</table>
<script>
//document.getElementById("paidnow").disabled = true;
document.getElementById("consave").disabled = true;
document.getElementById("paynow").disabled = false;
</script>
