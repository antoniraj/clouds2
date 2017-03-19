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
   	$courses = $model->getCurrentCourses();
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
	$r = $model->getFeeSchedules($fscs);
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

	$app =& JFactory::getApplication();
        $pathway =& $app->getPathway(); 
        $pathway->addItem('Home', $dashboardlink);
        $pathway->addItem('Fees',$modulelink);
        $pathway->addItem('Schedule',$feeschedulelink);
        $pathway->addItem('Class');
?>
<?php
echo '<b style="font: bold 15px Georgia, serif;">FEE COLLECTION CLASS LIST['.$crec->coursename.'-'.$sectionname.'] - '.$frec->name.'-'.$feeamount.'</b>';
?>

<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce&controller=students&courseid='.$this->courseid.'&task=actions&Itemid='.$Itemid); ?>" method="POST" name="adminForm">
<div class="row-fluid sortable">
<div class="box-content">
  <table class="table table-striped table-bordered bootstrap-datatable datatable">
    <thead>
<tr><th width="5%">RNO</th>
<th width="20%">NAME</th>
<th>CAT</th>
<th>FEE</th>
<th>DIS</th>
<th>CON</th>
<th>FINE</th>
<th>NET.FEE</th>
<th>PAID</th>
<th>DUE</th>
</tr>
    </thead>
    <tbody>
<?php
	foreach($students as $student)
	{
		$r = $model->getFeeMaster($fcid,$cid,$student->id,$fprec);
		if($r){
		//	if($fprec->status=="1") continue;
			$paidamount=$fprec->paidamount;
		}else{
			$paidamount=0.0;
		}
		if($fprec->status=="1"){
			$fine = $fprec->fine;
		}else {
			$fine = $ofine;
		}
   		$slink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=fees&view=fees&layout=feesubmission&fcid='.$fcid.'&cid='.$cid.'&studentid='.$student->id.'&fsid='.$fsid.'&Itemid='.$Itemid);
		echo '<tr>';
		echo '<td>';
		echo $student->registerno;
		echo '</td>';
		echo '<td>';
		echo '<a href="'.$slink.'">'.$student->firstname.'</a>';
		echo '</td>';
		echo '<td>';
		$r = $model->getStudentCategory($student->categoryid,$rec);
		if($r){
			echo $rec->categorycode;
		}else{
			echo "---";
		}
		echo '</td>';
		echo '<td align="right">';
        	$model->getFeeCategoryAmountByStudent($fcid,$student->id,$amount);
		printf("%.2f", $amount);
		$feeamount=$amount;
		//printf("%.2f", $feeamount);
		echo '</td>';
		echo '<td align="right">';
		$r = $model->getStudentFeeCategoryDiscounts($student->categoryid,$cid,$fcid,$discount);
		if($r){
			$damount=$feeamount*($discount/100.0);
		}else{
			$damount=0.0;	
		}
		printf("%.2f",$damount);
		echo '</td>';
		echo '<td align="right">';
		$r=$model->getStudentFeeConcession($student->id,$fcid,$cid,$camount);
		if($r){
		}else{
			$camount=0.0;
		}
		echo $camount;
		echo '</td>';
		echo '<td align="right">';
			printf("%.2f", $fine);
		echo '</td>';
		echo '<td align="right">';
		$netfee=($feeamount-($damount+$camount)+$fine);
		printf("%.2f",$netfee);
		echo '</td>';
		echo '<td align="right">';
		echo $paidamount;
		echo '</td>';
		echo '<td align="right">';
		$due =  $netfee - $paidamount;
		printf("%.2f",$due);
		echo '</td>';
	//	echo '<td align="center">';
   	//	$plink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=fees&view=fees&layout=printreceipt&regno='.$student->registerno.'&fcid='.$fcid.'&cid='.$cid.'&studentid='.$student->id.'&fsid='.$fsid.'&Itemid='.$masterItemid.'&format=pdf&tmpl=component');
		//if($fprec->status=="1"){
		//	echo '<a class="btn btn-info" href="'.$plink.'"><i class="icon icon-color icon-pdf icon-white"></i> PDF - '.$fprec->receiptno.'</a>';
	//	}else
	//		echo '---';
	//	echo '</td>';
		echo '</tr>';
	}
?>
    </tbody>
  </table>
</div>
</div>

<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
<input type="hidden" name="task" value="display" />
<input type="hidden" name="controller" value="fees" />
<input type="hidden" name="view" value="fees" />
<input type="hidden" name="layout" value="feestructure" />
</form>

