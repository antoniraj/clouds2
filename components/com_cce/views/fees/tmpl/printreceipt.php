<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');
	$Itemid = JRequest::getVar('Itemid');
        $courseid= JRequest::getVar('courseid');
        $fcid= JRequest::getVar('fcid');
        $cid= JRequest::getVar('cid');
        $gid= JRequest::getVar('gid');
        $studentid= JRequest::getVar('studentid');
        $receiptno= JRequest::getVar('receiptno');
	$iconsDir1 = JURI::base() . 'components/com_cce/images';

   	$model = & $this->getModel('fees');
	$model->getSchoolInfo($school);


	$rs=$model->getReceiptInfo($receiptno,$rrec);
	if(!$rs){
                JError::raiseWarning(500,'Could not get Receipt Record ['.$receiptno.']..');
		return;
	}






        $r=$model->getCourse($rrec->cid,$crec);
	if(!$r){ 
                JError::raiseWarning(500,'Could not load course details..');
		return;
	}
        $r=$model->getFeeCategory($rrec->fcid,$frec);
	if(!$r){ 
                JError::raiseWarning(500,'Could not load fee category details..');
		return;
	}
	//$precs = $model->getFeeParticulars($rrec->fcid);
        $model->getFeeTransactionParticulars($rrec->id,$precs);
        //$precs = $model->getFeeParticularsByStudent($rrec->fcid,$studentid);
	if(!$precs){ 
                JError::raiseWarning(500,'Could not load fee particulars..');
		return;
	}
	$r=$model->getStudent($rrec->studentid,$srec);
	if(!$r){ 
                JError::raiseWarning(500,'Could not load student details..');
		return;
	}

	$feeamount=0;
	foreach($precs as $prec) $feeamount=$feeamount+$prec->amount;
/*
	$r=$model->getFeeCategoryAmount($rrec->fcid,$feeamount);
	if(!$r){
		$feeamount=0;
	}
*/
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

	if($gid>0)
		$r=$model->getStudentGroupFeeConcession($studentid,$fcid,$gid,$camount);
	else
		$r=$model->getStudentFeeConcession($studentid,$fcid,$cid,$camount);
	if(!$r){
		$camount=0.0;
	}


	if($gid>0)
		$r=$model->getFineAmount1($gid,$fcid,$fine);
	else
		$r=$model->getFineAmount($cid,$fcid,$fine);
	if(!$r){
		$fine=0.0;
	}


	$netfee=($feeamount-($damount+$camount)+$fine );

	if($gid>0)
		$r = $model->getFeeMaster1($fcid,$cid,$gid,$studentid,$fmrec);
	else
		$r = $model->getFeeMaster($fcid,$cid,$studentid,$fmrec);
	if(!$r){
		$paidamount=0.0;
	}else{
		$paidamount=$fmrec->paidamount;
	}

	$due =  $netfee - $paidamount;

	echo '<table width="25px" align="right" ><tr><td nowrap>'.$receiptno.'</td></tr></table>';
	echo '<table align="center" width="100%">';
	echo '<tr><td width="100%" style="text-algin:center">'.$school->schoolname.'</td></tr>';
	echo '<tr><td>'.$school->schooladdress.'</td></tr>';
	echo '<tr><td>Fee Receipt - </td></tr>';
	echo '</table>';
		echo '<table width="100%">';
			echo '<tr height="20px">';
				echo '<td width="20%">';
					echo 'Register No:';
				echo '</td>';
				echo '<td width="20%" align="left">';
					echo $srec->registerno;
				echo '</td>';
				echo '<td width="20%">';
					echo 'Student Name:';
				echo '</td>';
				echo '<td width="40%">';
					echo $srec->firstname;
				echo '</td>';
			echo '</tr>';
			echo '<tr>';
				echo '<td>';
					echo 'Class:';
				echo '</td>';
				echo '<td>';
					echo $crec->code;
				echo '</td>';
				echo '<td>';
				echo 'Student Category:';
				echo '</td>';
				echo '<td>';
				echo $scat;
				echo '</td>';
			echo '</tr>';
		echo '</table>';
		echo '<hr />';
		echo '<center><h2>'.$frec->name.'</h2></center>';
		echo '<table width="100%">';
		echo '<tr><th width="10%"></th><th width="10%" class="list-title">S#</th><th width="55%">Particulars</th><th width="25%" align="right">Amount</th></tr>';
		$sno=1;
			foreach($precs as $prec){
		 	   echo '<tr>';
				echo '<td></td>';
				echo '<td >';
				echo $sno++;
				echo '</td>';
				echo '<td">';
					$model->getFeeParticular($prec->fpid,$pprec);
					echo $pprec->name;
				echo '</td>';
				echo '<td align="right">';
					printf("%.2f",$prec->amount);
				echo '</td>';
				echo '<td></td>';
			   echo '</tr>';
			}
			if($fine>0){
				echo '<tr>';
				echo '<td></td>';
				echo '<td >';
				echo $sno++;
				echo '</td>';
					echo '<td>';
						echo "Late Fee";
					echo '</td>';
					echo '<td align="right">';
						printf("%.2f",$fine);
					echo '</td>';
				echo '</tr>';
			}
			   echo '<tr>';
				echo '<td colspan="4" align="center">';
		//			printf("<b>Due: %0.02f</b>",($netfee-($fmrec->paidamount-$trec->paidamount)));
					printf("<b>Amount Paid: %0.02f</b>",$rrec->paidamount);
				echo '</td>';
		//			printf("<b>Balance: %0.02f</b>",($netfee-$fmrec->paidamount));
			   echo '</tr>';
			   echo '</table>';
				echo '<br />';
				echo '<br />';
			echo '<table width="100%">';
			echo '<tr>';
			echo '<td align="left" width="50%">Paid Date: <b>'.JArrayHelper::indianDate($rrec->paiddate).'</b></td>';
			echo '<td align="right" width="50%">Authorized Signatory</td>';
			echo '</tr></table>';
				echo '<hr />';
?>
</form>

