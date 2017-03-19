<?php
        defined('_JEXEC') OR DIE('Access denied..');


        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');
	
	$Itemid = JRequest::getVar('Itemid');
        $fstid = JRequest::getVar('fstid');
        $fcid= JRequest::getVar('fcid');
        $accountid= JRequest::getVar('accountid');
	if(!isset($accountid)) $accountid="-1";


	$iconsDir1 = JURI::base() . 'components/com_cce/images';

//	setlocale(LC_ALL, "en_US.UTF-8");
 	setlocale(LC_MONETARY,"en_IN.UTF-8");
   	$model = & $this->getModel('fees');

	//$heads = array('T1','T2','T3','MF','SPF');
	//$hrecs= $model->getClassFeeHeads();
	
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

	$link2= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=fees&view=fees&task=display&layout=reportgroupwiseexpected&Itemid='.$masterItemid);


	$fsrecs = $model->getFeeStructures();
	$accounts = $model->getFeeAccounts();
	$fcrecs = $model->getFeeCategoriesByStructure($fstid);	
	$courses = $model->getFeeCategoryCourses($fcid);
	$fprecs = $model->getFeeParticulars1($accountid,$fcid);

	$execllink = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=fees&task=display&layout=excel-reportclasswiseexpected&controller=fees&tmpl=component&accountid='.$accountid.'&Itemid='.$Itemid.'&fcid='.$fcid.'&fstid='.$fstid);

?>

<b style="font: bold 15px Georgia, serif;">REPORT ON EXPECTED FEE STRUCTURE</b>


<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce&controller=fees&view=fees&task=actions&Itemid='.$Itemid); ?>" method="POST" name="adminForm">
<div class="pull-right">
  	<select id="selectError2" data-rel="chosen" onChange="submit();" style="width:230px;" name="fcid">
                <option value="-1">Select a Fee Category/Term</option>
                <?php
                foreach($fcrecs as $fcrec) :
                        echo "<option value=\"".$fcrec->id."\" ".($fcrec->id == $fcid ? "selected=\"yes\"" : "").">".$fcrec->name."</option>";
                endforeach;
                ?>
        </select>
</div>				
<input type="hidden" name="view" value="fees" />
<input type="hidden" name="controller" value="fees" />
<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
<input type="hidden" name="task" value="display"/>
<input type="hidden" name="fstid" value="<?php echo $fstid; ?>"/>
<input type="hidden" name="accountid" value="<?php echo $accountid; ?>"/>
<input type="hidden" name="layout" value="reportclasswiseexpected"/>
</form>


<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce&controller=fees&view=fees&task=actions&Itemid='.$Itemid); ?>" method="POST" name="adminForm">
<div class="pull-right">
  	<select id="selectError" data-rel="chosen" onChange="submit();" style="width:230px;" name="accountid">
                <option value="-1">All Accounts</option>
                <?php
                foreach($accounts as $account) :
                        echo "<option value=\"".$account->id."\" ".($account->id == $accountid ? "selected=\"yes\"" : "").">".$account->title."</option>";
                endforeach;
                ?>
        </select>
</div>				
<input type="hidden" name="view" value="fees" />
<input type="hidden" name="controller" value="fees" />
<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
<input type="hidden" name="task" value="display"/>
<input type="hidden" name="fstid" value="<?php echo $fstid; ?>"/>
<input type="hidden" name="fcid" value="<?php echo $fcid; ?>"/>
<input type="hidden" name="layout" value="reportclasswiseexpected"/>
</form>



<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce&controller=fees&view=fees&task=actions&Itemid='.$Itemid); ?>" method="POST" name="adminForm">
<div class="pull-right">
  	<select id="selectError1" data-rel="chosen" onChange="submit();" style="width:230px;" name="fstid">
                <option value="-1">Select a Fee Structure</option>
                <?php
                foreach($fsrecs as $fsrec) :
                        echo "<option value=\"".$fsrec->id."\" ".($fsrec->id == $fstid ? "selected=\"yes\"" : "").">".$fsrec->title."</option>";
                endforeach;
                ?>
        </select>
</div>				
<input type="hidden" name="view" value="fees" />
<input type="hidden" name="controller" value="fees" />
<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
<input type="hidden" name="task" value="display"/>
<input type="hidden" name="layout" value="reportclasswiseexpected"/>
</form>

<div class="pull-left">
</div>
<div class="pull-right">
<a class="btn btn-info" href="<?php echo $execllink; ?>"><i class="icon-zoom-in icon-white"></i>  Export to Execl</a>
<!--	<a class="btn btn-mini btn-info" href="<?php echo $link2; ?>"><i class="icon-edit icon-white"></i> Group Fee</a>&nbsp;&nbsp;&nbsp;  -->
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
							foreach($fprecs as  $head){
								if($head->groupbased=="1") $gbsym='*';
								else $gbsym='';
								echo '<th class="list-title" style="text-align:center;">'.$head->description.$gbsym.'<br />['.$head->amount.']</th>';
							}
					//		foreach($heads as $head){
					//			echo '<th class="list-title" style="text-align:center;">'.$head.'-[TOT]</th>';
					//		}
						?>	
						<th class="list-title" style="text-align:center;">NET TOTAL </th>
					</tr>
				</thead>   
				<tbody>
<?php
	//setlocale(LC_MONETARY,"en_IN");
	$i=1;
	$cnsum=0;
	$nsum=0;
	$stcount=0;
	foreach($fprecs as $head){
		$csum[$head->id]=0;
		$sum[$head->id]=0;
	}

	foreach($courses as $course) {
		$scount=0;
		$cnsum=0;
		$model->getClassStrength($course->id,$scount);
		$stcount=$stcount+$scount;
		echo '<tr style="height:30px;">';
		echo '<td>';
			printf("%02d",$i++);
		echo '</td>';
		echo '<td>';
			echo $course->code;
		echo '</td>';
		echo '<td style="text-align:center;">';
			echo $scount;
		echo '</td>';
		foreach($fprecs as $head){
			if($head->groupbased=="1"){
				if(!$model->getGroupMembersCountByClass($head->id,$course->id,$scount))
					$scount = 0;
				$fpamount=$head->amount;
			}else{
				if($model->getCourseFeeParticular($accountid,$course->id,$head->id,$fprec)) 
					$fpamount=$fprec->amount;
				else 
					$fpamount=0;
			}
			$sfpamount = $scount * $fpamount;
			//to find col wise sum
			$sum[$head->id]=$sum[$head->id]+($sfpamount);	
			$cnsum = $cnsum + $sfpamount;
			echo '<td style="text-align:right;">';
				echo $model->formatInIndianStyle($sfpamount);
			echo '</td>';
		}
		$nsum=$nsum+$cnsum;
	
		echo '<td style="text-align:right;">';
		//echo money_format("%i", $netsum);
			echo $model->formatInIndianStyle($cnsum);
		echo '</td>';
		echo '</tr>';	
	}
?>
<tr>
<td>00</td>
<td style="text-align:right;"><b>TOTAL AMOUNT</b></td>
<td style="text-align:right;font: bold 15px verdana, serif;"> <b> <?php echo $stcount; ?> </b></td>

<?php
foreach($fprecs as $head){  ?>
	<td style="text-align:right;font: bold 15px verdana, serif;font-family:Arial;"> <b> <?php echo '&#8377;&nbsp;'.$model->formatInIndianStyle($sum[$head->id]); ?> </b></td>
<?php } ?>
<td style="text-align:right;font: bold 15px verdana, serif;font-family:Arial;"> <b> <?php echo '&#8377;&nbsp;'.$model->formatInIndianStyle($nsum); ?> </b></td>
</tr>
</tbody>
</table>            
</div>
</div><!--/span-->
</div><!--/row-->

