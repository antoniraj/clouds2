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
        $gid= JRequest::getVar('gid');
	$iconsDir1 = JURI::base() . 'components/com_cce/images';

//	setlocale(LC_ALL, "en_US.UTF-8");
 	setlocale(LC_MONETARY,"en_IN.UTF-8");
   	$model = & $this->getModel('fees');
	$groups = $model->getCurrentGroups();
        $model->getGroupRec($gid,$grec);

	//$heads = array('T1','T2','T3','MF','SPF');
	$hrecs= $model->getGroupFeeHeads();
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

	$link2= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=fees&view=fees&task=display&layout=reportclasswiseexpected&Itemid='.$masterItemid);
?>

<b style="font: bold 15px Georgia, serif;">REPORT ON ADDITIONAL FEE EXPECTED</b>
<div class="pull-right">
	<a class="btn btn-mini btn-info" href="<?php echo $link2; ?>"><i class="icon-edit icon-white"></i> Class Fee</a>
</div>				
<!--
<button class="btn btn-small btn-primary" value="Edit" name="Edit"> <i class="icon-edit icon-white"></i> Edit</button>
<button class="btn btn-small btn-danger"  value="Delete" name="Delete"> <i class="icon-trash icon-white"></i> Delete</button>
</div>	
-->			
</div>				

<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce&controller=fees&view=fees&task=actions&Itemid='.$Itemid); ?>" method="POST" name="adminForm">
	<div class="row-fluid sortable">		
		<div class="box span12">
			<div class="box-content">
				<table class="table table-striped table-bordered bootstrap-datatable datatable">
				<thead>
					<tr>
						<th class="list-title" style="text-align:center;">Sno</th>
						<th class="list-title" style="text-align:center;">Group</th>
						<th class="list-title" style="text-align:center;">Strength</th>
						<?php
							foreach($heads as $head){
								echo '<th class="list-title" style="text-align:center;">'.$head.'</th>';
							}
							foreach($heads as $head){
								echo '<th class="list-title" style="text-align:center;">'.$head.'-[TOT]</th>';
							}
						?>	
						<th class="list-title" style="text-align:center;">NET TOTAL </th>
					</tr>
				</thead>   
				<tbody>
<?php
	//setlocale(LC_MONETARY,"en_IN");
	$i=1;
	$cnsum=0;
	$stcount=0;
	foreach($heads as $head) $csum[$head]=0;
	foreach($groups as $group) {
		foreach($heads as $head){
			$sum[$head]=0;
			$fcs = $model->getGroupFeeCategoriesByHead($head,$group->id);
			foreach($fcs as $fc){
				$precs = $model->getFeeParticulars($fc->id);
				foreach($precs as $prec){	
					$sum[$head]=$sum[$head]+$prec->amount;	
				}
			}	
		}
        	$students = $model->getGroupMembers($group->id);

 //  		$link= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=fees&view=fees&task=display&layout=feedueclasslist&fcid='.$fsrec->fcid.'&cid='.$fsrec->cid.'&fsid='.$fsrec->id.'&Itemid='.$Itemid);
		echo '<tr style="height:30px;">';
		echo '<td>';
		printf("%02d",$i++);
		echo '</td>';
		echo '<td>';
		echo $group->groupname;
		echo '</td>';
		echo '<td style="text-align:center;">';
		$scount= count($students);
		$stcount=$stcount+$scount;
		echo $scount;
		echo '</td>';
		//Display the Fee Head Amount
		foreach($heads as $head){
			echo '<td style="text-align:center;">';
			echo $sum[$head];
			echo '</td>';
		}
	
		//Display Fee Head Total
		$nsum=0;
		foreach($heads as $head){
			echo '<td style="text-align:right;">';
			$tsum = $sum[$head]*$scount;
			$csum[$head] = $csum[$head]+$tsum;
			$nsum = $nsum + $tsum;
			echo formatInIndianStyle($tsum);
			echo '</td>';
		}
/*
		echo '<td style="text-align:right;">';
		$t23sum=($sum['T2']*$scount)+($sum['T3']*$scount);
		$ct23sum=$ct23sum+$t23sum;
//		echo money_format("%i", $t23sum);
		echo formatInIndianStyle($t23sum);
		echo '</td>';
		echo '<td style="text-align:right;">';
		$sacsum = ($sum['MF']+$sum['SPF'])*$scount;
		$csacsum=$csacsum+$sacsum;
		//echo money_format("%i", $sacsum);
		echo formatInIndianStyle($sacsum);
		echo '</td>';
*/
		echo '<td style="text-align:right;">';
		$cnsum=$cnsum+$nsum;
		//echo money_format("%i", $netsum);
		echo formatInIndianStyle($nsum);
		echo '</td>';

		echo '</tr>';	
	}
?>
<tr>
<td>00</td>
<td style="text-align:right;"><b>TOTAL AMOUNT</b></td>
<td style="text-align:right;font: bold 15px verdana, serif;"> <b> <?php echo $stcount; ?> </b></td>
<?php
foreach($heads as $head){
	echo '<td></td>';
}?>
<!-- 
<td style="text-align:right;font: bold 15px verdana, serif;"> <b> <?php echo money_format("%i", $ct1sum); ?> </b></td>
<td style="text-align:right;font: bold 15px verdana, serif;"> <b> <?php echo money_format("%i", $csacsum); ?> </b></td>
<td style="text-align:right;font: bold 15px verdana, serif;"> <b> <?php echo money_format("%i", $cnetsum); ?> </b></td>
-->
<?php
foreach($heads as $head){  ?>
<td style="text-align:right;font: bold 15px verdana, serif;font-family:Arial;"> <b> <?php echo '&#8377;&nbsp;'.formatInIndianStyle($csum[$head]); ?> </b></td>
<?php } ?>
<td style="text-align:right;font: bold 15px verdana, serif;font-family:Arial;"> <b> <?php echo '&#8377;&nbsp;'.formatInIndianStyle($cnsum); ?> </b></td>
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

