<?php
        defined('_JEXEC') OR DIE('Access denied..');



        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');
	$Itemid = JRequest::getVar('Itemid');
        $todate= JRequest::getVar('todate');
	if(!isset($todate)){
		$todate = date('d-m-Y');
	}
        $fromdate= JRequest::getVar('fromdate');
	if(!isset($fromdate)){
		$fromdate = date('01'.'-m-Y');
	}
	$iconsDir1 = JURI::base() . 'components/com_cce/images';

   	$model = & $this->getModel('fees');
	
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
	$execllink = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=fees&task=display&layout=excel-datewisereport&controller=fees&tmpl=component');
?>

<b style="font: bold 15px Georgia, serif;">OVERALL REPORT ON DATEWISE COLLECTION</b>
<div class="pull-right">
<a class="btn btn-info" href="<?php echo $execllink; ?>"><i class="icon-zoom-in icon-white"></i>  Export to Execl</a>
</div>
<div class="pull-right">
<table width="100%" border="0"><tr><td style="width:50%;text-align:right;">
<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce&controller=fees&view=fees&task=display&layout=datewisereport&Itemid='.$Itemid); ?>" method="post" name="adminForm">
	From Date:
	<?php echo JHTML::calendar($fromdate,'fromdate','fromdate','%d-%m-%Y');  ?>
	To Date:
	<?php echo JHTML::calendar($todate,'todate','todate','%d-%m-%Y');  ?>
	<button class="btn btn-small btn-danger" value="go" name="Go"> <i class="icon-edit icon-white"></i>Go</button>
        <input type="hidden" name="view" value="fees" />
        <input type="hidden" name="controller" value="fees" />
        <input type="hidden" name="layout" value="datewisereport" />
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
						<th class="list-title" style="text-align:center;">Sno</th>
						<th class="list-title" style="text-align:center;">DATE</th>
						<th class="list-title" style="text-align:center;">AMOUNT</th>
					</tr>
				</thead>   
				<tbody>
<?php
	setlocale(LC_MONETARY,"en_IN");
	$i=1;
	$gtsum=0;
	$fdate = date('Y-m-d',strtotime($fromdate));
	$tdate = date('Y-m-d',strtotime($todate));
	$model->getDateWiseFeeCollection($fdate,$tdate,$drecs);
	foreach($drecs as  $drec){
                echo '<tr style="height:30px;">';
                echo '<td>';
	                printf("%02d",$i++);
                echo '</td>';
                echo '<td>';
			$a=explode('-',$drec->paiddate);
			$c1date=$a[2].'-'.$a[1].'-'.$a[0];
                	echo $c1date;
                echo '</td>';
                echo '<td style="text-align:right;">';
         	       echo '<b>'.$model->formatInIndianStyle($drec->paidamount).'</b>';
                echo '</td>';
                echo '</tr>';
		$gtsum=$gtsum+$drec->paidamount;
	}
?>
<tr>
<td>00</td>
<td style="text-align:right;"><b>TOTAL AMOUNT</b></td>
<td style="text-align:right;font: bold 15px verdana, serif;font-family:Arial;"> <b> <?php echo '&#8377;&nbsp;'.$model->formatInIndianStyle($gtsum); ?> </b></td>
</tr>
</tbody>
</table>            
</div>
</div><!--/span-->
</div><!--/row-->

