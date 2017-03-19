<?php
        defined('_JEXEC') OR DIE('Access denied..');
 

	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	$Itemid  = JRequest::getVar('Itemid');
	$courseid=JRequest::getVar('courseid');

	$iconsDir1 = JURI::base() . 'components/com_cce/images';
    	$co = JRequest::getVar('courseid');
   	$model = & $this->getModel('fees');
   	$dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
   	$modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=fees&Itemid='.$masterItemid);

  	$studentslink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=students&view=students&task=display&Itemid='.$studentsItemid);
	$app =& JFactory::getApplication();
        $pathway =& $app->getPathway(); 
        $pathway->addItem('Home', $dashboardlink);
        $pathway->addItem('Fees',$modulelink);
        $pathway->addItem('Students');

//	$students = $model->getAllStudents();
	$students = $model->getStudents($courseid);
	$courses=$model->getCurrentCourses();

?>

<div class="row-fluid sortable">		
	<div class="box-header well" data-original-title>
		<h2><i class="icon-user"></i> STUDENTS LIST - INSTANT FEE COLLECTION</h2>
		<div style="float:right;margin-top:-5px;">
			<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce&controller=fees&view=fees&courseid='.$courseid.'&task=display&layout=instantcollection&Itemid='.$Itemid); ?>" method="POST" name="adminForm">
					<div class="control-group">
						<div class="controls">
							<select id="selectError" data-rel="chosen" onchange="submit();" name="courseid">
								<option value="">Select a Class</option> 
<?php
foreach($courses as $course) :
							echo "<option value=\"".$course->id."\" ".($course->id == $courseid ? "selected=\"yes\"" : "").">".$course->code."</option>";
endforeach;
?>
							</select>
						</div>
					</div>
			</form>
		</div>
	</div>
</div>
<div class="box-content">
<table class="table table-striped table-bordered bootstrap-datatable datatable">
<thead>
<tr>
<th>Reg.No</th>
<th>Student Name</th>
<th>Class</th>
<th align="center">Regular Fee</th>
</tr>
</thead>   
<tbody>
<?php
//$fcrecst=$model->getFeeCategories_t();
if($students){
foreach($students as $rec) {
$cobj=$model->getClassByStudent($rec->id);
echo '<tr>';
echo "<td>$rec->registerno</td>";
echo "<td>$rec->firstname&nbsp;$rec->middlename&nbsp;$rec->lastname</td>";
echo "<td>$cobj->code</td>";
echo '<td style="text-align:right;">';
echo '<table width="100%" border="0"><tr>';

	$fcrecs = $model->getFeeCategoriesByStudent($rec->id);

	$fcgrecs = $model->getGroupFeeCategoriesByStudent($rec->id);  //TO be removed

	$per=100/(count($fcrecs)+count($fcgrecs));


//TO BE REMOVED
	foreach($fcgrecs as $fcgrec){
echo '<td width='.$per.'%>';
	   //if($fcrec->groupbased=="1"){
		$gids = $model->getGroupIDs($rec->id,$fcgrec->id);

		foreach($gids as $grec){
			$pays=$model->getPaymentStatus1($rec->id,$fcgrec->id,$grec->gid);
			if($pays=="0"){
				$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=fees&controller=fees&layout=feesubmission&insflag=1&task=display&cid='.$cobj->id.'&gid='.$grec->gid.'&fcid='.$fcgrec->id.'&groupbased='.$fcgrec->groupbased.'&studentid='.$rec->id.'',false);	
				echo '<a class="btn btn-success" href="'.$redirectTo.'">';
				echo '<i class="icon-edit icon-white"></i>'.$fcgrec->name.'</a>';
			}else{
        		$r=$model->getFeeTransactions1($fcgrec->id,$cobj->id,$rec->id,$grec->gid,$trecs);
			if($r) {
				foreach($trecs as $trec){
?>
					<div "float:left;">
					   <form action="<?php echo JRoute::_('index.php'); ?>" method="POST" name="adminForm">
				                <button class="btn btn-small btn-warning"  value="Print" name="Print"> <i class="icon-print icon-white"></i><?php echo $fcgrec->name.'['.$trec->receiptno.']'; ?></button>
				                <input type="hidden" id="view" name="view" value="fees" />
				                <input type="hidden" id="controller" name="controller" value="fees" />
				                <input type="hidden" name="task" id="task" value="printfeereceipt" />
				                <input type="hidden" name="layout" id="layout" value="instantcollection" />
				                <input type="hidden" name="Itemid" id="Itemid" value="<?php echo $Itemid; ?>" />
				                <input type="hidden" name="cid" id="cid" value="<?php echo $cobj->id; ?>" />
				                <input type="hidden" name="balance" id="balance" value="<?php echo $due; ?>" />
				                <input type="hidden" name="fine" id="fine" value="<?php echo $fine; ?>" />
				                <input type="hidden" name="concession" id="concession" value="<?php echo $camount; ?>" />
				                <input type="hidden" name="discount" id="discount" value="<?php echo $damount; ?>" />
				                <input type="hidden" name="receiptno" id="receiptno" value="<?php echo $trec->receiptno; ?>" />
				                <input type="hidden" name="fcid" id="fcid" value="<?php echo $fcgrec->id; ?>" />
				                <input type="hidden" name="groupbased" id="groupbased" value="<?php echo $fcgrec->groupbased; ?>" />
				                <input type="hidden" name="gid" id="gid" value="<?php echo $grec->gid; ?>" />
				                <input type="hidden" name="studentid" id="studentid" value="<?php echo $rec->id; ?>" />
				                <input type="hidden" name="regno" id="regno" value="<?php echo $rec->registerno; ?>" />
				           </form> 
					</div>
				<?php
				}
			}else{  
				echo "-"; 
			}
		}
	      }
		}  

//
//











	foreach($fcrecs as $fcrec){
	   //}else{
								
		$pays=$model->getPaymentStatus($rec->id,$fcrec->id); //STUDENTID, FCID
		if($pays=="0"){
			$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=fees&controller=fees&layout=feesubmission&insflag=1&task=display&cid='.$cobj->id.'&fcid='.$fcrec->id.'&groupbased='.$fcrec->groupbased.'&studentid='.$rec->id.'',false);	
			echo '<a class="btn btn-success" href="'.$redirectTo.'">';
			echo '<i class="icon-edit icon-white"></i>'.$fcrec->name.'</a>';
		}else{ 
        		$r=$model->getFeeTransactions($fcrec->id,$cobj->id,$rec->id,$trecs);
			if($r) 
				foreach($trecs as $trec){
?>
					<div "float:left;">
					   <form action="<?php echo JRoute::_('index.php'); ?>" method="POST" name="adminForm">
				                <button class="btn btn-small btn-warning"  value="Print" name="Print"> <i class="icon-print icon-white"></i><?php echo $fcrec->name.'['.$trec->receiptno.']'; ?></button>
				                <input type="hidden" id="view" name="view" value="fees" />
				                <input type="hidden" id="controller" name="controller" value="fees" />
				                <input type="hidden" name="task" id="task" value="printfeereceipt" />
				                <input type="hidden" name="layout" id="layout" value="instantcollection" />
				                <input type="hidden" name="Itemid" id="Itemid" value="<?php echo $Itemid; ?>" />
				                <input type="hidden" name="cid" id="cid" value="<?php echo $cobj->id; ?>" />
				                <input type="hidden" name="balance" id="balance" value="<?php echo $due; ?>" />
				                <input type="hidden" name="fine" id="fine" value="<?php echo $fine; ?>" />
				                <input type="hidden" name="concession" id="concession" value="<?php echo $camount; ?>" />
				                <input type="hidden" name="discount" id="discount" value="<?php echo $damount; ?>" />
				                <input type="hidden" name="receiptno" id="receiptno" value="<?php echo $trec->receiptno; ?>" />
				                <input type="hidden" name="fcid" id="fcid" value="<?php echo $fcrec->id; ?>" />
				                <input type="hidden" name="groupbased" id="groupbased" value="<?php echo $fcrec->groupbased; ?>" />
				                <input type="hidden" name="studentid" id="studentid" value="<?php echo $rec->id; ?>" />
				                <input type="hidden" name="regno" id="regno" value="<?php echo $rec->registerno; ?>" />
				           </form> 
					</div>
				<?php
			}
			else{  
				echo "-"; 
			}
		}
	    echo '</td>';
	}
echo '</tr></table>';
echo '</td>';
/*
echo '<td style="text-align:right;">';
echo '<table width="100%" border="0"><tr>';
$gcrecs = $model->getGroupFeeCategoriesByStudent($rec->id);
$cobj=$model->getClassByStudent($rec->id);
	$per=100/count($gcrecs);
	foreach($gcrecs as $gcrec){
echo '<td width='.$per.'%>';
		$pays=$model->getPaymentStatus($rec->id,$gcrec->id);
		if($pays=="0"){
			$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=fees&controller=fees&layout=feesubmission&insflag=1&task=display&cid='.$cobj->id.'&fcid='.$gcrec->id.'&studentid='.$rec->id.'',false);	
			echo '<a class="btn btn-success" href="'.$redirectTo.'">';
			echo '<i class="icon-edit icon-white"></i>'.$gcrec->name.'</a>';
		}else{ 
        		$r=$model->getFeeTransactions($gcrec->id,$cobj->id,$rec->id,$trecs);
			if($r) 
				foreach($trecs as $trec){
?>
					<div style="float:left;">
					   <form action="<?php echo JRoute::_('index.php'); ?>" method="POST" name="adminForm">
				                <button class="btn btn-small btn-warning"  value="Print" name="Print"> <i class="icon-edit icon-white"></i><?php echo $trec->receiptno; ?></button>
				                <input type="hidden" id="view" name="view" value="fees" />
				                <input type="hidden" id="controller" name="controller" value="fees" />
				                <input type="hidden" name="task" id="task" value="printfeereceipt" />
				                <input type="hidden" name="layout" id="layout" value="instantcollection" />
				                <input type="hidden" name="Itemid" id="Itemid" value="<?php echo $Itemid; ?>" />
				                <input type="hidden" name="cid" id="cid" value="<?php echo $cobj->id; ?>" />
				                <input type="hidden" name="balance" id="balance" value="<?php echo $due; ?>" />
				                <input type="hidden" name="fine" id="fine" value="<?php echo $fine; ?>" />
				                <input type="hidden" name="concession" id="concession" value="<?php echo $camount; ?>" />
				                <input type="hidden" name="discount" id="discount" value="<?php echo $damount; ?>" />
				                <input type="hidden" name="receiptno" id="receiptno" value="<?php echo $trec->receiptno; ?>" />
				                <input type="hidden" name="fcid" id="fcid" value="<?php echo $fcrec->id; ?>" />
				                <input type="hidden" name="studentid" id="studentid" value="<?php echo $rec->id; ?>" />
				                <input type="hidden" name="regno" id="regno" value="<?php echo $rec->registerno; ?>" />
				           </form> 
					</div>
				<?php
			}
			else{  
				echo "-"; 
			}
		}
		echo '</td>';
	}
echo '</tr></table>';
echo '</td>'; */
?>
</tr>
<?php
}
}
?>
</tbody>
</table>  
</div>
</div><!--/span-->
</div><!--/row-->
<br />
