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
	$groupbased= JRequest::getVar('groupbased');
	$accountid= JRequest::getVar('accountid');
        $head= JRequest::getVar('head');
   	$model = & $this->getModel('fees');
	if(! isset($head)){
		 $heads = $model->getClassFeeHeads();
		$head=$heads[0]->description;
	}
	$iconsDir1 = JURI::base() . 'components/com_cce/images';

//	setlocale(LC_ALL, "en_US.UTF-8");
 	setlocale(LC_MONETARY,"en_IN.UTF-8");
	$heads=$model->getFeeCategories_tt();
	
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
        $pathway->addItem('Pending Fee');


?>

<b style="font: bold 15px Georgia, serif;">REPORT ON PENDING FEE</b>

<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce&controller=fees&view=fees&task=actions&Itemid='.$Itemid); ?>" method="POST" name="adminForm">
<div class="pull-right">
    <select id="selectError" data-rel="chosen" onChange="submit();" style="width:230px;" name="accountid">
                <option value="-1">All Accounts</option>
                <?php
                $accounts = $model->getFeeAccounts();
                foreach($accounts as $account) :
                        echo "<option value=\"".$account->id."\" ".($account->id == $accountid ? "selected=\"yes\"" : "").">".$account->title."</option>";
                endforeach;
                ?>
        </select>
</div>

<div class="pull-right">
<?php
$cols=array('success','primary','danger','warning','info');
$n=count($cols);
$ii=0;
foreach($heads as $hh){
   	$link= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=fees&view=fees&task=display&layout=pendingpayment&head='.$hh->description.'&groupbased='.$hh->groupbased.'&Itemid='.$masterItemid);
	echo '<a class="btn btn-mini btn-'.$cols[$ii].'" href="'.$link.'"><i class="icon-edit icon-white"></i>'.$hh->name.'</a>&nbsp;';
	if($ii==($n-1)) $ii=0;
	$ii++;
}
?>
</div>	

	<div class="row-fluid sortable">		
		<div class="box span12">
			<div class="box-content">
				<table class="table table-striped table-bordered bootstrap-datatable datatable">
				<thead>
					<tr>
						<th class="list-title" style="text-align:center;">Sno</th>
						<th class="list-title" style="text-align:center;">Class</th>
						<th class="list-title" style="text-align:center;">Strength</th>
<?php
						echo '<th class="list-title" style="text-align:center;">'.$head.'</th>'; 
						echo '<th class="list-title" style="text-align:center;">Expected</th>'; 
?>
						<th class="list-title" style="text-align:center;">Paid Amount</th>
						<th class="list-title" style="text-align:center;">Fine</th>
						<th class="list-title" style="text-align:center;">Concession</th>
						<th class="list-title" style="text-align:center;">Discounts</th>
						<th class="list-title" style="text-align:center;">Balance</th>
					</tr>
				</thead>   
				<tbody>
<?php
	//setlocale(LC_MONETARY,"en_IN");
	$i=1;
	$exsum=0;
	$acsum=0;
	$cosum=0;
	$fsum=0;
	$disum=0;
	$basum=0;
	$stcount=0;

	if($groupbased=="1"){
	$groups= $model->getCurrentGroups();
	foreach($groups as $grec) {
			$hsum=0;
			$fcs = $model->getGroupFeeCategoriesByHead($head,$grec->id);
			foreach($fcs as $fc){
				//$precs = $model->getFeeParticulars($fc->id);
				$precs = $model->getFeeParticulars1($accountid,$fc->id);
				foreach($precs as $prec){	
					$hsum=$hsum+$prec->amount;	
				}
			}	
		$students = $model->getGroupMembers($grec->id);
                echo '<tr style="height:30px;">';
                echo '<td>';
                printf("%02d",$i++);
                echo '</td>';
                echo '<td>';
                echo $grec->groupname;
                echo '</td>';
                echo '<td style="text-align:center;">';
                $scount= count($students);
                $stcount=$stcount+$scount;
                echo $scount;
                echo '</td>';
                echo '<td style="text-align:center;">';
                echo $hsum;
                echo '</td>';
                echo '<td style="text-align:right;">';
                $t1sum = $hsum*$scount;
                $exsum=$exsum+$t1sum;
                echo formatInIndianStyle($t1sum);
                //money_format("%n", $t1sum);
                echo '</td>';

                $arec=$model->getAmountByGroupHead($grec->id,$head);
                echo '<td style="text-align:right;">';
//              echo money_format("%i", $t23sum);
                echo formatInIndianStyle($arec->paidamount);
                $acsum=$acsum+$arec->paidamount;
                echo '</td>';


                echo '<td style="text-align:right;">';
		echo $arec->fine;
                echo '</td>';

                echo '<td style="text-align:right;">';
                //echo money_format("%i", $sacsum);
                echo formatInIndianStyle($arec->concession);
                $cosum=$cosum+$arec->concession;
                $fsum=$fsum+$arec->fine;
                echo '</td>';
                echo '<td style="text-align:right;">';
                //echo money_format("%i", $netsum);
                echo formatInIndianStyle($arec->discount);
                $disum=$disum+$arec->discount;
                echo '</td>';
                echo '<td style="text-align:right;">';
                //echo money_format("%i", $netsum);
                $bal=$t1sum-($arec->paidamount+$arec->concession+$arec->discount - $arec->fine);
                echo formatInIndianStyle($bal);
                $basum=$basum+$bal;
                echo '</td>';
                echo '</tr>';
		}

	}else{
	$courses = $model->getCurrentCourses();
	foreach($courses as $course) {
			$hsum=0;
			$fcs = $model->getCourseFeeCategoriesByHead($head,$course->id);
			foreach($fcs as $fc){
				//$precs = $model->getFeeParticulars($fc->id);
				$precs = $model->getFeeParticulars1($accountid,$fc->id);
				foreach($precs as $prec){	
					$hsum=$hsum+$prec->amount;	
				}
			}	
		$students = $model->getStudents($course->id);
 //  		$link= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=fees&view=fees&task=display&layout=feedueclasslist&fcid='.$fsrec->fcid.'&cid='.$fsrec->cid.'&fsid='.$fsrec->id.'&Itemid='.$Itemid);
		echo '<tr style="height:30px;">';
		echo '<td>';
		printf("%02d",$i++);
		echo '</td>';
		echo '<td>';
		echo $course->code;
		echo '</td>';
		echo '<td style="text-align:center;">';
		$scount= count($students);
		$stcount=$stcount+$scount;
		echo $scount;
		echo '</td>';
		echo '<td style="text-align:center;">';
		echo $hsum;
		echo '</td>';
		echo '<td style="text-align:right;">';
		$t1sum = $hsum*$scount;
		$exsum=$exsum+$t1sum;
		echo formatInIndianStyle($t1sum);
		//money_format("%n", $t1sum);
		echo '</td>';

		$arec=$model->getAmountByClassHead($course->id,$head);
		echo '<td style="text-align:right;">';
//		echo money_format("%i", $t23sum);
		echo formatInIndianStyle($arec->paidamount);
		$acsum=$acsum+$arec->paidamount;
		echo '</td>';
		echo '<td style="text-align:right;">';
		echo $arec->fine;
		echo '</td>';
		echo '<td style="text-align:right;">';
		//echo money_format("%i", $sacsum);
		echo formatInIndianStyle($arec->concession);
		$cosum=$cosum+$arec->concession;
                $fsum=$fsum+$arec->fine;
		echo '</td>';
		echo '<td style="text-align:right;">';
		//echo money_format("%i", $netsum);
		echo formatInIndianStyle($arec->discount);
		$disum=$disum+$arec->discount;
		echo '</td>';
		echo '<td style="text-align:right;">';
		//echo money_format("%i", $netsum);
		$bal=$t1sum-($arec->paidamount+$arec->concession+$arec->discount-$arec->fine);
		echo formatInIndianStyle($bal);
		$basum=$basum+$bal;
		echo '</td>';
		echo '</tr>';	
	}
	}
?>
<tr>
<td>00</td>
<td style="text-align:right;"><b>TOTAL AMOUNT</b></td>
<td style="text-align:right;font: bold 15px verdana, serif;"> <b> <?php echo $stcount; ?> </b></td>
<td></td>
<!-- 
<td style="text-align:right;font: bold 15px verdana, serif;"> <b> <?php echo money_format("%i", $ct1sum); ?> </b></td>
<td style="text-align:right;font: bold 15px verdana, serif;"> <b> <?php echo money_format("%i", $csacsum); ?> </b></td>
<td style="text-align:right;font: bold 15px verdana, serif;"> <b> <?php echo money_format("%i", $cnetsum); ?> </b></td>
-->
<td style="text-align:right;font: bold 15px verdana, serif;font-family:Arial;"> <b> <?php echo '&#8377;&nbsp;'.formatInIndianStyle($exsum); ?> </b></td>
<td style="text-align:right;font: bold 15px verdana, serif;font-family:Arial;"> <b> <?php echo '&#8377;&nbsp;'.formatInIndianStyle($acsum); ?> </b></td>
<td style="text-align:right;font: bold 15px verdana, serif;font-family:Arial;"> <b> <?php echo '&#8377;&nbsp;'.formatInIndianStyle($fsum); ?> </b></td>
<td style="text-align:right;font: bold 15px verdana, serif;font-family:Arial;"> <b> <?php echo '&#8377;&nbsp;'.formatInIndianStyle($cosum); ?> </b></td>
<td style="text-align:right;font: bold 15px verdana, serif;font-family:Arial;"> <b> <?php echo '&#8377;&nbsp;'.formatInIndianStyle($disum); ?> </b></td>
<td style="text-align:right;font: bold 15px verdana, serif;font-family:Arial;"> <b> <?php echo '&#8377;&nbsp;'.formatInIndianStyle($basum); ?> </b></td>
</tr>
</tbody>
</table>            
</div>
</div><!--/span-->
</div><!--/row-->
<input type="hidden" name="view" value="fees" />
<input type="hidden" name="controller" value="fees" />
<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
<input type="hidden" name="task" value="display"/>
<input type="hidden" name="head" value="<?php echo $head; ?>"/>
<input type="hidden" name="layout" value="pendingpayment"/>
</form>
