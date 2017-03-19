<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');
	$Itemid = JRequest::getVar('Itemid');
	$cid = JRequest::getVar('cid');
	$fcid = JRequest::getVar('fcid');
	$fsid = JRequest::getVar('fsid');
	$iconsDir1 = JURI::base() . 'components/com_cce/images';

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
	$students = $model->getStudents($cid);
	$r = $model->getFeeCategory($fcid,$frec);
	$r = $model->getCourse($cid,$crec);
	$fprecs = $model->getFeeParticulars($fcid);
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
   	$feeschedulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=fees&view=fees&task=display&layout=feeduelist&Itemid='.$masterItemid);
	$app =& JFactory::getApplication();
        $pathway =& $app->getPathway(); 
   	$dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
   	$modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=fees&Itemid='.$masterItemid);
   	$duelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=fees&view=fees&task=display&layout=feeduelist&Itemid='.$masterItemid);
        $pathway->addItem('Home', $dashboardlink);
        $pathway->addItem('Fees',$modulelink);
        $pathway->addItem('Fee Schedule',$duelink);
        $pathway->addItem('Due List');

	$execllink = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=fees&task=display&layout=excel-feedueclasslist&controller=fees&tmpl=component&cid='.$cid.'&fcid='.$fcid.'&fsid='.$fsid);
?>


<CENTER><b style="font: bold 18px verdana, serif;">FEE COLLECTION  [<?php echo  $crec->coursename.'-'.$crec->sectionname; ?>]</b></CENTER>
<CENTER><b style="font: bold 14px verdana, serif;"><?php echo  $frec->name; ?></b></CENTER>

<div class="row-fluid sortable">
<div class="box span12">
<div class="box-content">
  <table class="table table-striped table-bordered bootstrap-datatable datatable">
    <thead>
<tr><th style="text-align:center;">RNO</th>
<th style="text-align:center;" width="15%">NAME</th>
<?php
$s_head=array();
foreach( $fprecs as $head){
	$s_head[$head->id]=0;
	if($head->groupbased=="1") $gb="*";
	else $gb='';
	echo '<th style="text-align:center;">'.$head->description.$gb.'<br />'.$head->amount.'</th>';
}
?>
<th style="text-align:center;">NET.FEE</th>
<th style="text-align:center;">PAID</th>
<th style="text-align:center;">DUE</th>
<th style="text-align:center;">TO PAY</th>
<th style="text-align:center;">OPTION</th>
</tr>
    </thead>
    <tbody>
<?php
	$s_camount	= 0;	
	$s_netfee 	= 0;
	$s_paidamount	= 0;
	$s_due		= 0;
	foreach($students as $student)
	{
?>
<script>
$('body').on('blur', '.bal-<?php echo $student->id; ?>', function() {
    var total=0;
    var i=0;
    $(".bal-<?php echo $student->id; ?>").each(function(){
        quantity = parseInt($(this).val());
        if (!isNaN(quantity)) {
            total += quantity;
        }
        i++;
    });
    $('.paidnow-<?php echo $student->id; ?>').val(total);
});
</script>
<?php

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

   			$slink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=fees&view=fees&layout=feesubmission&fcid='.$fcid.'&cid='.$cid.'&studentid='.$student->id.'&fsid='.$fsid.'&Itemid='.$Itemid);
		//if($due>0){
		echo '<tr>';
		echo '<td>';
		echo $student->registerno;
		echo '</td>';
		echo '<td>';
			echo '<a href="'.$slink.'">'.$student->firstname.' '.$student->middlename.' '.$student->lastname.' '.$student->initial.'</a>';
		echo '</td>';

		?> <form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce&controller=fees&task=savefeetransaction'); ?>" method="post" name="adminForm" > <?php
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
			echo '<td style="text-align:right;">';
			if($fprec->status=="0")
				if($p_due>0)
					//printf("<input type=\"text\" class=\"bal-$student->id\" id=\"bal-$student->id\" style=\"width:50px;text-align:right;\" value=\"%s\" name=\".$student->id.'-'.$head->id.'-'.$fcid\"", ($p_due));
					printf("<input style=\"width:100px;text-align:right;\" class=\"bal-$student->id\" type=\"text\" name=\"bala[".$head->accountid."$$".$head->id."]\" value=\"%.2f\" />",$p_due);
				else
					printf("<input style=\"width:100px;text-align:right;\" readonly class=\"bal-$student->id\" type=\"text\" name=\"bala[".$head->accountid."$$".$head->id."]\" value=\"%.2f\" />",$p_due);
				//	printf("<input type=\"text\" class=\"bal-$student->id\" readonly id=\"bal-$student->id\" style=\"width:50px;text-align:right;\" value=\"%s\" name=\".$student->id.'-'.$head->id.'-'.$fcid\"", ($p_due));
			else
				printf("%s", $model->formatInIndianStyle($p_due));
			echo '</td>';
			$s_head[$head->id] = $s_head[$head->id] + $p_due;
		}

		$netfee=(($feeamount+$gextraamount)-($damount+$camount)+$fine);
		$due =  $netfee - $paidamount;

		echo '<td style="text-align:right;">';
		printf("<b>%s</b>",$model->formatInIndianStyle($netfee));
		echo '</td>';
		echo '<td style="text-align:right;">';
		printf("<b>%s</b>",$model->formatInIndianStyle($paidamount));
		echo '</td>';
		echo '<td style="text-align:right;">';
		printf("<b>%s</b>",$model->formatInIndianStyle($due));
		echo '<input type="hidden" name="balance" value="'.$due.'" />';
		echo '</td>';
			echo '<td style="text-align:right;">';
			if($fprec->status=="0")
				printf("<input type=\"text\" class=\"paidnow-$student->id\" readonly id=\"paidnow-$student->id\" style=\"font-size: 14pt; font-weight:bold; color: #000; width:80px;text-align:right;\" value=\"%s\" name=\"paidnow\"",($due));
			else
				printf("%s", $model->formatInIndianStyle($due));
			echo '</td>';
		echo '<td style="text-align:right;">';
		if($fprec->status=="1"){
		}
		else
			echo '<button class="btn btn-small btn-warning" value="Pay" name="pay"> <i class="icon-edit icon-white"></i>PAY</button>';
        		$model->getFeeTransactions($fcid,$cid,$student->id,$trecs);
			foreach($trecs as $trec){
                		$plink = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=fees&controller=fees&task=display&layout=printreceipt&regno='.$student->registerno.'&cid='.$cid.'&gid='.$gid.'&studentid='.$student->id.'&receiptno='.$trec->receiptno.'&fcid='.$fcid.'&Itemid='.$Itemid."&format=pdf&tmpl=component",false);
				echo '<a class="btn btn-small btn-info" href="'.$plink.'">'.$trec->receiptno.'</a>';
			}
?>
	<input type="hidden" id="view" name="view" value="fees" />
	<input type="hidden" id="controller" name="controller" value="fees" />
	<input type="hidden" name="task" id="task" value="savefeetransaction" />
	<input type="hidden" name="Itemid" id="Itemid" value="<?php echo $Itemid; ?>" />
	<input type="hidden" name="caddflag" id="caddflag" value="<?php echo $caddflag; ?>" />
	<input type="hidden" name="receiptno"  value="<?php echo $trec->receiptno; ?>" />
	<input type="hidden" name="cid" value="<?php echo $cid; ?>" />
	<input type="hidden" name="fcid" value="<?php echo $fcid; ?>" />
	<input type="hidden" name="groupbased" id="groupbased" value="<?php echo $groupbased; ?>" />
	<input type="hidden" name="gid" value="<?php echo $gid; ?>" />
	<input type="hidden" name="studentid" id="studentid" value="<?php echo $student->id; ?>" />
	<input type="hidden" name="regno" id="regno" value="<?php echo $student->registerno; ?>" />
	<input type="hidden" name="layout" id="layout" value="feecollectionclasslist" />

	<input type="hidden" name="gid" id="gid" value="<?php echo $gid; ?>" />
	<input type="hidden" name="fine" id="fine" value="<?php echo $fine; ?>" />
	<input type="hidden" name="discount" id="discount" value="<?php echo $damount; ?>" />
	<input type="hidden" name="fmid" id="fmid" value="<?php echo $fmrec->id; ?>" />
	<input type="hidden" name="insflag" value="<?php echo $insflag; ?>" />
	<input type="hidden" name="dc" value="1" />
</form>
<?php
		echo '</td>';

		echo '</tr>';
	}
?>


    </tbody>
  </table>
*  Applicable for groups only.
</div>
</div>


