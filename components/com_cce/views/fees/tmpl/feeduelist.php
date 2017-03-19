<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');
	$Itemid = JRequest::getVar('Itemid');
	$iconsDir1 = JURI::base() . 'components/com_cce/images';

   	$model = & $this->getModel('fees');

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


	$app =& JFactory::getApplication();
        $pathway =& $app->getPathway(); 
   	$dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
   	$modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=fees&Itemid='.$masterItemid);
        $pathway->addItem('Home', $dashboardlink);
        $pathway->addItem('Fees',$modulelink);
        $pathway->addItem('Due List');

?>
<b style="font: bold 15px Georgia, serif;">REPORT ON DEFAULTERS BASED ON SCHEDULE</b>

<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce&controller=fees&view=fees&task=actions&Itemid='.$Itemid); ?>" method="POST" name="adminForm">
	<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-content">
						<table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead>
							  <tr>
	<th class="list-title">Sno</th>
	<th class="list-title">Last Date</th>
	<th class="list-title">Fee Category</th>
	<th class="list-title">Class</th>
	<th class="list-title">Late Fee</th>
	<th class="list-title">Defaulters</th>
							  </tr>
						  </thead>   
						  <tbody>
<?php
	$terminationDate = new DateTime('today');
	$i=1;
	foreach($fscs as $fsrec) {
		if($fsrec->gid>0)
   			$link= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=fees&view=fees&task=display&layout=feeduegrouplist&fcid='.$fsrec->fcid.'&gid='.$fsrec->gid.'&fsid='.$fsrec->id.'&Itemid='.$Itemid);
		else
   			$link= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=fees&view=fees&task=display&layout=feedueclasslist&fcid='.$fsrec->fcid.'&cid='.$fsrec->cid.'&fsid='.$fsrec->id.'&Itemid='.$Itemid);
		echo '<tr style="height:30px;">';
		echo '<td>';
		echo $i++;
		echo '</td>';
		echo '<td>';
		echo $fsrec->fdate;
		echo '</td>';
		$r = $model->getFeeCategory($fsrec->fcid,$frec);
		echo '<td>';
		echo $frec->name;
		echo '</td>';
		if($fsrec->gid>0)
			$r = $model->getGroupRec($fsrec->gid,$crec);
		else
			$r = $model->getCourse($fsrec->cid,$crec);
		echo '<td>';
		if($fsrec->gid>0)
			echo $crec->groupcode;
		else
			echo $crec->code;
		echo '</td>';
		echo '<td>';
		echo $fsrec->fine;
		echo '</td>';
		echo '<td align="center">';
		if($fsrec->gid>0)
			$s = $model->getFeeMasterDueList1($fsrec->fcid,$fsrec->gid,$srecs);
		else
			$s = $model->getFeeMasterDueList($fsrec->fcid,$fsrec->cid,$srecs);
		if($s){
			$todaysDate = new DateTime($fsrec->fdate);
			$span = $terminationDate->diff($todaysDate);
			if($span->invert)
				echo '<a class="btn btn-mini btn-danger" href="'.$link.'"><i class="" icon-white"></i>'.count($srecs).'</a>';
			else
				echo '<a class="btn btn-mini btn-primary" href="'.$link.'"><i class="" icon-white"></i>'.count($srecs).'</a>';
		}else{
			echo "--";
		}
		echo '</td>';
		echo '</tr>';	
	}
?>
							 </tbody>
					  </table>            
					</div>
                     
			
				</div><!--/span-->
			
			</div><!--/row-->
						
<input type="hidden" name="view" value="academicyears" />
<input type="hidden" name="controller" value="academicyears" />
<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
<input type="hidden" name="task" value="actions"/>
</form>

