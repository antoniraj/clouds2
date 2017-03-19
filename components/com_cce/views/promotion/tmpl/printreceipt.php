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
        $studentid= JRequest::getVar('studentid');
	$iconsDir1 = JURI::base() . 'components/com_cce/images';

   	$model = & $this->getModel('fees');
	$model->getSchoolInfo($school);
        $r=$model->getCourse($cid,$crec);
	if(!$r){ 
                JError::raiseWarning(500,'Could not load course details..');
		return;
	}
        $r=$model->getFeeCategory($fcid,$frec);
	if(!$r){ 
                JError::raiseWarning(500,'Could not load fee category details..');
		return;
	}
	$precs = $model->getFeeParticulars($fcid);
	if(!$precs){ 
                JError::raiseWarning(500,'Could not load fee particulars..');
		return;
	}
	$r=$model->getStudent($studentid,$srec);
	if(!$r){ 
                JError::raiseWarning(500,'Could not load student details..');
		return;
	}
        $model->getFeeTransactions($fcid,$cid,$studentid,$trecs);
	$r=$model->getFeeCategoryAmount($fcid,$feeamount);
	if(!$r){
		$feeamount=0;
	}
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
	$r=$model->getStudentFeeConcession($studentid,$fcid,$cid,$camount);
	if(!$r){
		$camount=0.0;
	}

	$r=$model->getFineAmount($cid,$fcid,$fine);
	if(!$r){
		$fine=0.0;
	}

	$netfee=($feeamount-($damount+$camount)+$fine );
	$r = $model->getFeeMaster($fcid,$cid,$studentid,$fmrec);
	if(!$r){
		$paidamount=0.0;
	}else{
		$paidamount=$fmrec->paidamount;
	}
	$due =  $netfee - $paidamount;

	echo '<center><h1>'.$school->schoolname.'</h1></center>';
	echo '<center><h3>'.$school->schooladdress.'</h3></center>';
	echo '<center><h2>Fee Receipt</h2></center>';
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
		echo '<tr><th width="5%"></th><th width="5%" class="list-title">S#</th><th width="35%">Particulars</th><th width="15%" align="right">Amount</th><th width="20%" align="right">Deductions</th><th width="5%"></th></tr>';
		$sno=1;
			foreach($precs as $prec){
		 	   echo '<tr>';
				echo '<td></td>';
				echo '<td >';
				echo $sno++;
				echo '</td>';
				echo '<td">';
					echo $prec->name;
				echo '</td>';
				echo '<td align="right">';
					printf("%.2f",$prec->amount);
				echo '</td>';
				echo '<td></td>';
			   echo '</tr>';
			}
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
			   $dsum=0;
			   	echo '<tr>';
				echo '<td></td>';
				echo '<td >';
				echo $sno++;
				echo '</td>';
					echo '<td>';
						echo "Discount";
					echo '</td>';
				echo '<td></td>';
					echo '<td align="right"> ';
						printf("%.2f",$damount);
					echo '</td>';
				echo '</tr>';
			   	echo '<tr>';
				echo '<td></td>';
				echo '<td >';
				echo $sno++;
				echo '</td>';
					echo '<td>';
						echo "Concession";
					echo '</td>';
				echo '<td></td>';
					echo '<td align="right">';
						printf("%.2f",$camount);
					echo '</td>';
				echo '</tr>';

			   echo '<tr>';
				echo '<td colspan="3" align="right">';
					echo "<b>Total Amount</b>";
				echo '</td>';
				echo '<td align="right">';
					printf("<hr /><b>%.2f</b><hr />",$feeamount+$fine);
				echo '</td>';
				$dsum = $damount+$camount;
					echo '<td align="right">';
						printf("<hr /><b>%.2f</b><hr />",$dsum);
					echo '</td>';
			   echo '</tr>';
			   echo '<tr>';
				echo '<td colspan="4" align="right">';
					echo "<b>Total Fee</b>";
				echo '</td>';
				echo '<td align="right">';
					printf("<b>%.2f</b><hr />",$netfee);
				echo '</td>';
			   echo '</tr>';
			   echo '</table>';
				echo '<br />';
				echo '<br />';
				echo '<br />';
				echo '<br />';
				echo '<br />';
				echo '<br />';
			echo '<table width="100%">';
			echo '<tr>';
			echo '<td align="left" width="50%">Paid Date: <b>'.$fmrec->paiddate.'</b></td>';
			echo '<td align="right" width="50%">Authorized Signatory</td>';
			echo '</tr></table>';
				echo '<hr />';
?>

