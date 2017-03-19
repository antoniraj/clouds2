<?php
        defined('_JEXEC') OR DIE('Access denied..');

        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');
	$Itemid = JRequest::getVar('Itemid');
        $fromdate= JRequest::getVar('fromdate');
	if(!isset($fromdate)){
		$fromdate = date('d-m-Y');
	}
	$iconsDir1 = JURI::base() . 'components/com_cce/images';

	$a=explode('-',$fromdate);
	$fdate=$a[2].'-'.$a[1].'-'.$a[0];

   	$model = & $this->getModel('fees');
	$recs= $model->getFeeCollectionDatewise($fdate);

	//$heads = array('T1','T2','T3','MF','SPF');
	$hrecs= $model->getFeeHeads();
	foreach($hrecs as $hrec){
		$heads[] = $hrec->description;
	}
	
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
        $pathway->addItem('Home', $dashboardlink);
        $pathway->addItem('Fees',$modulelink);
        $pathway->addItem('Reports');

	$execllink = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=fees&task=excel-dailycollection&controller=fees&tmpl=component&layout=excel-dailycollection&fromdate='.$fdate);
?>

<b style="font: bold 15px Georgia, serif;">FEE COLLECTION ON EACH DATE</b>
<div class="pull-right">
<table width="100%" border="0"><tr><td style="width:50%;text-align:left;">
<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce&controller=fees&view=fees&task=display&layout=dailycollection&Itemid='.$Itemid); ?>" method="post" name="adminForm">
	Select Date:
	<?php echo JHTML::calendar($fromdate,'fromdate','fromdate','%d-%m-%Y');  ?>
	<button class="btn btn-small btn-danger" value="go" name="Go"> <i class="icon-edit icon-white"></i>Go</button>
	<a class="btn btn-info" href="<?php echo $execllink; ?>"><i class="icon-zoom-in icon-white"></i>  Export to Execl</a>
        <input type="hidden" name="view" value="fees" />
        <input type="hidden" name="controller" value="fees" />
        <input type="hidden" name="layout" value="dailycollection" />
        <input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
        <input type="hidden" name="task" value="display"/>
</form>
</td>
</tr>
</table>
</div>				

	<div class="row-fluid sortable">		
		<div class="box span12">
			<div class="box-content">
				<table class="table table-striped table-bordered bootstrap-datatable datatable">
				<thead>
					<tr>
						<th class="list-title" style="text-align:center;">SNO</th>
						<th class="list-title" style="text-align:center;">STUDENT NAME</th>
						<th class="list-title" style="text-align:center;">CLASS</th>
						<th class="list-title" style="text-align:center;">FEEHEAD</th>
						<th class="list-title" style="text-align:center;">RECEIPTNO</th>
						<th class="list-title" style="text-align:center;">AMOUNT</th>
					</tr>
				</thead>   
				<tbody>
<?php
	setlocale(LC_MONETARY,"en_IN");
	$i=1;
	$sum=0;
	foreach($recs as $rec) {
		echo '<tr style="height:30px;">';
		echo '<td>';
		printf("%02d",$i++);
		echo '</td>';
		echo '<td>';
		echo $rec->studentname;
		echo '</td>';
		echo '<td>';
		echo $rec->coursename;
		echo '</td>';
		echo '<td>';
		echo $rec->feetitle;
		echo '</td>';
		echo '<td style="text-align:center;">';
		echo $rec->receiptno;
		echo '</td>';
		echo '<td style="text-align:right;">';
		echo '<b style="font-family:Arial;"> &#8377;&nbsp;'.$model->formatInIndianStyle($rec->paidamount).'</b>';
		//echo '<b>'.money_format("%i",$rec->paidamount).'</b>';
		echo '</td>';
		$sum=$sum+$rec->paidamount;
		echo '</tr>';	
	}
?>
<tr>
<td>00</td>
<td style="text-align:right;"><b>TOTAL AMOUNT</b></td>
<td></td>
<td></td>
<td></td>
<td style="text-align:right;font: bold 16px verdana, serif;font-family:Arial;"> <b>&#8377;&nbsp; <?php echo $model->formatInIndianStyle($sum); ?> </b></td>
<td></td>
</tr>
</tbody>
</table>            
</div>
</div><!--/span-->
</div><!--/row-->
