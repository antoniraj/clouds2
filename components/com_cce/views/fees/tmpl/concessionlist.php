<?php
        defined('_JEXEC') OR DIE('Access denied..');

        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');
	$Itemid = JRequest::getVar('Itemid');
        $fromdate= JRequest::getVar('fromdate');
	$iconsDir1 = JURI::base() . 'components/com_cce/images';

	$a=explode('-',$fromdate);
	$fdate=$a[2].'-'.$a[1].'-'.$a[0];

   	$model = & $this->getModel('fees');
	$recs= $model->getConcessionList();

	
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
        $pathway->addItem('ConcessionList');
   	
	$execllink = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=fees&task=display&layout=excel-concessionlist&controller=fees&tmpl=component');
	$link1= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=fees&view=fees&task=display&layout=groupconcessionlist&Itemid='.$masterItemid);
?>

<b style="font: bold 15px Georgia, serif;">CONCESSION LIST</b>
<div class="pull-right">
<a class="btn btn-info" href="<?php echo $execllink; ?>"><i class="icon-zoom-in icon-white"></i>  Export to Execl</a>
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
		echo $rec->classname;
		echo '</td>';
		echo '<td>';
		echo $rec->feetitle;
		echo '</td>';
		echo '<td style="text-align:right;">';
		echo '<b style="font-family:Arial;"> &#8377;&nbsp;'.$model->formatInIndianStyle($rec->amount).'</b>';
		$sum=$sum+$rec->amount;
		//echo '<b>'.money_format("%i",$rec->paidamount).'</b>';
		echo '</td>';
		echo '</tr>';	
	}
?>
<tr>
<td>00</td>
<td style="text-align:right;"><b>TOTAL AMOUNT</b></td>
<td></td>
<td></td>
<td style="text-align:right;font: bold 16px verdana, serif;font-family:Arial;"> <b>&#8377;&nbsp; <?php echo $model->formatInIndianStyle($sum); ?> </b></td>
</tr>
</tbody>
</table>            
</div>
</div><!--/span-->
</div><!--/row-->
