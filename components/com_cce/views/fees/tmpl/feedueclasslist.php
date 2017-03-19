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
<CENTER><b style="font: bold 18px verdana, serif;">LIST OF DEFAULTERS [<?php echo  $crec->coursename.'-'.$crec->sectionname; ?>]</b></CENTER>
<CENTER><b style="font: bold 14px verdana, serif;"><?php echo  $frec->name; ?></b></CENTER>

<div class="pull-right">
<a class="btn btn-info" href="<?php echo $execllink; ?>"><i class="icon-zoom-in icon-white"></i>  Export to Execl</a>
</div>

<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce&controller=students&courseid='.$this->courseid.'&task=actions&Itemid='.$Itemid); ?>" method="POST" name="adminForm">
<div class="row-fluid sortable">
<div class="box span12">
<div class="box-content">
  <table class="table table-striped table-bordered bootstrap-datatable datatable">
    <thead>
<tr><th style="text-align:center;" width="5%">RNO</th>
<th style="text-align:center;" width="20%">NAME</th>
<?php
$s_head=array();
foreach( $fprecs as $head){
	$s_head[$head->id]=0;
	if($head->groupbased=="1") $gb="*";
	else $gb='';
	echo '<th style="text-align:center;">'.$head->description.$gb.'<br />'.$head->amount.'</th>';
}
?>
<th style="text-align:center;">CON</th>
<th style="text-align:center;">NET.FEE</th>
<th style="text-align:center;">PAID</th>
<th style="text-align:center;">DUE</th>
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
			echo '<td style="text-align:right;">';
				printf("%s", $model->formatInIndianStyle($p_due));
			echo '</td>';
			$s_head[$head->id] = $s_head[$head->id] + $p_due;
		}

		$netfee=(($feeamount+$gextraamount)-($damount+$camount)+$fine);
		$due =  $netfee - $paidamount;

		echo '<td style="text-align:right;">';
		printf("%s",$model->formatInIndianStyle($camount));
		echo '</td>';
		echo '<td style="text-align:right;">';
		printf("<b>%s</b>",$model->formatInIndianStyle($netfee));
		echo '</td>';
		echo '<td style="text-align:right;">';
		printf("<b>%s</b>",$model->formatInIndianStyle($paidamount));
		echo '</td>';
		echo '<td style="text-align:right;">';
		printf("<b>%s</b>",$model->formatInIndianStyle($due));
		echo '</td>';
		echo '</tr>';
		$s_camount	=	$s_camount + $camount;
		$s_netfee 	=	$s_netfee + $netfee;
		$s_paidamount	=	$s_paidamount + $paidamount;
		$s_due		=	$s_due + $due;
		} 
	}

		echo '<tr>';
		echo '<td>';
		echo '</td>';
		echo '<td style="text-align:right;;font: bold 17px verdana, serif;font-family:Arial;">';
			echo '<b>TOTAL AMOUNT</b>';
		echo '</td>';
		foreach($fprecs as $head){
			echo '<td style="text-align:right;;font: bold 17px verdana, serif;font-family:Arial;">';
				printf("<b>%s</b>",$model->formatInIndianStyle( $s_head[$head->id]));
			echo '</td>';
		}

		echo '<td style="text-align:right;;font: bold 17px verdana, serif;font-family:Arial;">';
			printf("<b>%s</b>",$model->formatInIndianStyle($s_camount));
		echo '</td>';
		echo '<td style="text-align:right;;font: bold 17px verdana, serif;font-family:Arial;">';
		printf("<b>%s</b>",$model->formatInIndianStyle($s_netfee));
		echo '</td>';
		echo '<td style="text-align:right;;font: bold 17px verdana, serif;font-family:Arial;">';
		printf("<b>%s</b>",$model->formatInIndianStyle($s_paidamount));
		echo '</td>';
		echo '<td style="text-align:right;;font: bold 17px verdana, serif;font-family:Arial;">';
		printf("<b>%s</b>",$model->formatInIndianStyle($s_due));
		echo '</td>';
		echo '</tr>';
?>
    </tbody>
  </table>
*  Applicable for groups only.
</div>
</div>

<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
<input type="hidden" name="task" value="display" />
<input type="hidden" name="controller" value="fees" />
<input type="hidden" name="view" value="fees" />
<input type="hidden" name="layout" value="feestructure" />
</form>

