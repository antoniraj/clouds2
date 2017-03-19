<?php
        defined('_JEXEC') OR DIE('Access denied..');

     	 header("Content-type: application/octet-stream");
     	 header("Pragma: no-cache");
     	 header("Expires: 0");


        $app = JFactory::getApplication();

	$cid = JRequest::getVar('cid');
	$fcid = JRequest::getVar('fcid');
	$fsid = JRequest::getVar('fsid');

   	$model = & $this->getModel('fees');

        $model->getCourse($courseid,$crec);
	$r=$model->getFineAmount($cid,$fcid,$ofine);
	if(!$r){
		$fine=0.0;
	}
	$r=$model->getFeeCategoryAmount($fcid,$feeamount);
	if($r){
		;
	}else{
		$feeamount=0;
	}
	$screc=$model->getSchoolInfo();
	$students = $model->getStudents($cid);
	$r = $model->getFeeCategory($fcid,$frec);
	$r = $model->getCourse($cid,$crec);
	$fprecs = $model->getFeeParticulars($fcid);

	$cols = 7 + count($fprecs) ;
      	header("Content-Disposition: attachment; filename=".$crec->code."-duelist.xls");


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
			<h4><?php echo "LIST OF DEFAULTERS"; ?>  </h4>
		</td>
	</tr>
	<tr>
		<td colspan="<?php echo $cols; ?>" align="center">
			<h3><?php echo $crec->code .' ['.$frec->name.' ]'; ?>  </h3>
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
			<th align="center" valign="middle" width="5%">RNO</th>
			<th align="center" valign="middle" width="20%">NAME</th>
			<?php
			$s_head=array();
			foreach( $fprecs as $head){
				$s_head[$head->id]=0;
				if($head->groupbased=="1") $gb="*";
				else $gb='';
				echo '<th align="center" valign="middle">'.$head->description.$gb.'<br />'.$head->amount.'</th>';
			}
			?>

			<th align="center" valign="middle">CONS</th>
			<th align="center" valign="middle">NET.FEE</th>
			<th align="center" valign="middle">PAID</th>
			<th align="center" valign="middle">DUE</th>
		</tr>
    		</thead>
    		<tbody>
<?php
	$s_camount	= 0;	
	$s_netfee 	= 0;
	$s_paidamount	= 0;
	$s_due		= 0;
	$i=1;
	foreach($students as $student)
	{
		$r = $model->getFeeMaster($fcid,$cid,$student->id,$fprec);
		if($r){
			$paidamount=$fprec->paidamount;
		}else{
			$paidamount=0.0;
		}
		if($fprec->status=="1"){
			$fine = $fprec->fine;
		}else {
			$fine = $ofine;
		}
		$r=$model->getStudentFeeConcession($student->id,$fcid,$cid,$camount);
		if($r){
		}else{
			$camount=0.0;
		}
		
		$r=$model->getFeeCategoryAmountByStudent($fcid,$student->id,$feeamount);
		if($r){
			;
		}else{
			$feeamount=0;
		}

		if($fprec->status=="0"){
		//if($due>0){
		echo '<tr>';
		echo '<td>';
		echo $i++;
		echo '</td>';
		echo '<td>';
		echo $student->registerno;
		echo '</td>';
		echo '<td>';
		echo $student->firstname;
		echo '</td>';

		$p_due=0;
		foreach( $fprecs as $head){
			
			$gextraamount=0;
			if($head->groupbased=="1"){
        			$rss=$model->getStudentGroupCountByParticular($head->id,$student->id,$ttrec);
				if($rss){
					$gextraamount= $head->amount * ($ttrec->tot - 1);
					//$head->amount= $head->amount*($ttrec->tot);
				}	
			}


        		$rs=$model->getFeeTransactionParticularAmount($head->id,$student->id,$cid,$fcid,$ftpa);
			if($rs){
				$c_paidamount=$ftpa->amount;
			}else{
				$c_paidamount=0.0;
			}

			$cc_amount=0;
        		$rs = $model->getFeeParticularConcession($student->id,$head->id,$ccrec);
			if($rs)
				$cc_amount=$ccrec->amount;
			else
				$cc_amount=0.0;

			$p_due = (($head->amount+$gextraamount)-($c_paidamount+$cc_amount));
			echo '<td align="right">';
				printf("&#8377;&nbsp;%s", $model->formatInIndianStyle($p_due));
			echo '</td>';
			$s_head[$head->id] = $s_head[$head->id] + $p_due;
		}

		$netfee=(($feeamount+$gextraamount)-($damount+$camount)+$fine);
		$due =  $netfee - $paidamount;

		echo '<td align="right">';
		printf("&#8377;&nbsp;%s",$model->formatInIndianStyle($camount));
		echo '</td>';
		echo '<td align="right">';
		printf("<b>&#8377;&nbsp;%s</b>",$model->formatInIndianStyle($netfee));
		echo '</td>';
		echo '<td align="right">';
		printf("<b>&#8377;&nbsp;%s</b>",$model->formatInIndianStyle($paidamount));
		echo '</td>';
		echo '<td align="right">';
		printf("<b>&#8377;&nbsp;%s</b>",$model->formatInIndianStyle($due));
		echo '</td>';
		echo '</tr>';
		$s_camount	=	$s_camount + $camount;
		$s_netfee 	=	$s_netfee + $netfee;
		$s_paidamount	=	$s_paidamount + $paidamount;
		$s_due		=	$s_due + $due;
		} 
	}

		echo '<tr>';
		echo '<td align="right" colspan="3">';
			echo '<b>TOTAL AMOUNT</b>';
		echo '</td>';
		foreach($fprecs as $head){
			echo '<td align="right">';
				printf("<b>&#8377;&nbsp;%s</b>",$model->formatInIndianStyle( $s_head[$head->id]));
			echo '</td>';
		}

		echo '<td align="right">';
			printf("<b>&#8377;&nbsp;%s</b>",$model->formatInIndianStyle($s_camount));
		echo '</td>';
		echo '<td align="right">';
		printf("<b>&#8377;&nbsp;%s</b>",$model->formatInIndianStyle($s_netfee));
		echo '</td>';
		echo '<td align="right">';
		printf("<b>&#8377;&nbsp; %s</b>",$model->formatInIndianStyle($s_paidamount));
		echo '</td>';
		echo '<td align="right">';
		printf("<b>&#8377;&nbsp; %s</b>",$model->formatInIndianStyle($s_due));
		echo '</td>';
		echo '</tr>';
?>
    </tbody>
  </table>
*  Applicable for groups only.
