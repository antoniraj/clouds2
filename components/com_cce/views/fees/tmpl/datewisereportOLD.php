<?php
        defined('_JEXEC') OR DIE('Access denied..');

function formatInIndianStyle($num){
     $pos = strpos((string)$num, ".");
     if ($pos === false) {
        $decimalpart="00";
     }
     if (!($pos === false)) {
        $decimalpart= substr($num, $pos+1, 2); $num = substr($num,0,$pos);
     }

     if(strlen($num)>3 & strlen($num) <= 12){
         $last3digits = substr($num, -3 );
         $numexceptlastdigits = substr($num, 0, -3 );
         $formatted = makeComma($numexceptlastdigits);
         $stringtoreturn = $formatted.",".$last3digits.".".$decimalpart ;
     }elseif(strlen($num)<=3){
        $stringtoreturn = $num.".".$decimalpart ;
     }elseif(strlen($num)>12){
        $stringtoreturn = number_format($num, 2);
     }

     if(substr($stringtoreturn,0,2)=="-,"){
        $stringtoreturn = "-".substr($stringtoreturn,2 );
     }

     return $stringtoreturn;
 }

 function makeComma($input){
     if(strlen($input)<=2)
     { return $input; }
     $length=substr($input,0,strlen($input)-2);
     $formatted_input = makeComma($length).",".substr($input,-2);
     return $formatted_input;
 }


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



	$hrecs= $model->getFeeHeads();
	foreach($hrecs as $hrec){
		$heads[] = $hrec->description;
	}
	
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
?>

<b style="font: bold 15px Georgia, serif;">OVERALL REPORT ON DATEWISE COLLECTION</b>
<div class="pull-right">
<table width="100%" border="0"><tr><td style="width:50%;text-align:right;">
<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce&controller=fees&view=fees&task=display&layout=dailycollection&Itemid='.$Itemid); ?>" method="post" name="adminForm">
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

<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce&controller=fees&view=fees&task=actions&Itemid='.$Itemid); ?>" method="POST" name="adminForm">
	<div class="row-fluid sortable">		
		<div class="box span12">
			<div class="box-content">
				<table class="table table-striped table-bordered bootstrap-datatable datatable">
				<thead>
					<tr>
						<th class="list-title" style="text-align:center;">Sno</th>
						<th class="list-title" style="text-align:center;">DATE</th>
						<?php
							$j=0;
							foreach($heads as $head){
								$hsum[$j]=0;
								$j++;
								echo '<th class="list-title" style="text-align:center;">'.$head.'</th>';
							}
						?>	
						<th class="list-title" style="text-align:center;">TOTAL</th>
					</tr>
				</thead>   
				<tbody>
<?php
	setlocale(LC_MONETARY,"en_IN");
	$i=1;
	$gtsum=0;
	$hn=count($heads);

	$a=explode('-',$fromdate);
	$fdate=$a[2].'-'.$a[1].'-'.$a[0];
	$a=explode('-',$todate);
	$tdate=$a[2].'-'.$a[1].'-'.$a[0];
	$ftime = strtotime($fdate);
	$ttime = strtotime($tdate);
	$cdate=$fdate;
	while($ftime <= $ttime) { 
                echo '<tr style="height:30px;">';
                echo '<td>';
                printf("%02d",$i++);
                echo '</td>';
                echo '<td>';
		$a=explode('-',$cdate);
		$c1date=$a[2].'-'.$a[1].'-'.$a[0];
                echo $c1date;
                echo '</td>';
                $tsum=0;
                $j=0;
                foreach($heads as $head){
                	echo '<td style="text-align:right;">';
			$model->getDatewiseCollection($head,$cdate,$paidamount);
                        echo formatInIndianStyle($paidamount);
                        $hsum[$j]=$hsum[$j]+$paidamount;
                        $tsum=$tsum+$paidamount;
                        $j++;
                        echo '</td>';
                }
                echo '<td style="text-align:right;">';
                echo '<b>'.formatInIndianStyle($tsum).'</b>';
                echo '</td>';
                echo '</tr>';
		$gtsum=$gtsum+$tsum;
		$cdate = date('Y-m-d',strtotime($cdate." +1 day"));
		$ftime = strtotime($cdate);
	}
?>
<tr>
<td>00</td>
<td style="text-align:right;"><b>TOTAL AMOUNT</b></td>
<?php
	for($j=0;$j<$hn;$j++){
		echo '<td style="text-align:right;font: bold 15px verdana, serif;font-family:Arial;"> <b>&#8377;&nbsp;'.formatInIndianStyle($hsum[$j]); '</b></td>';
	}
?>
<td style="text-align:right;font: bold 15px verdana, serif;font-family:Arial;"> <b> <?php echo '&#8377;&nbsp;'.formatInIndianStyle($gtsum); ?> </b></td>
</tr>
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

