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
        $courseid= JRequest::getVar('courseid');
	$iconsDir1 = JURI::base() . 'components/com_cce/images';

//	setlocale(LC_ALL, "en_US.UTF-8");
 	setlocale(LC_MONETARY,"en_IN.UTF-8");
   	$model = & $this->getModel('fees');
	$courses = $model->getCurrentCourses();
        $model->getCourse($courseid,$crec);

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
?>

<b style="font: bold 15px Georgia, serif;">REPORT ON EXPECTED FEE STRUCTURE</b>
<!--
<div class="pull-right">
<button class="btn btn-small btn-success" name="Add" value="Add"><i class="icon-plus-sign icon-white"></i> Add</button>
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
						<th class="list-title" style="text-align:center;">Class</th>
						<th class="list-title" style="text-align:center;">Strength</th>
						<?php
							foreach($heads as $head){
								echo '<th class="list-title" style="text-align:center;">'.$head.'</th>';
							}
						?>	
						<th class="list-title" style="text-align:center;">TERM1</th>
						<th class="list-title" style="text-align:center;">TERM2&3</th>
						<th class="list-title" style="text-align:center;">SOCIETY</th>
						<th class="list-title" style="text-align:center;">NET FEE</th>
					</tr>
				</thead>   
				<tbody>
<?php
	//setlocale(LC_MONETARY,"en_IN");
	$i=1;
	$ct1sum=0;
	$ct23sum=0;
	$csacsum=0;
	$cnetsum=0;
	$stcount=0;
	foreach($courses as $course) {
		foreach($heads as $head){
			$sum[$head]=0;
			$fcs = $model->getCourseFeeCategoriesByHead($head,$course->id);
			foreach($fcs as $fc){
				$precs = $model->getFeeParticulars($fc->id);
				foreach($precs as $prec){	
					$sum[$head]=$sum[$head]+$prec->amount;	
				}
			}	
		}
		$students = $model->getStudents($course->id);
 //  		$link= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=fees&view=fees&task=display&layout=feedueclasslist&fcid='.$fsrec->fcid.'&cid='.$fsrec->cid.'&fsid='.$fsrec->id.'&Itemid='.$Itemid);
		echo '<tr style="height:30px;">';
		echo '<td>';
		printf("%02d",$i++);
		echo '</td>';
		echo '<td>';
		echo $course->coursename;
		echo '</td>';
		echo '<td style="text-align:center;">';
		$scount= count($students);
		$stcount=$stcount+$scount;
		echo $scount;
		echo '</td>';
		foreach($heads as $head){
			echo '<td style="text-align:center;">';
			echo $sum[$head];
			echo '</td>';
		}
		echo '<td style="text-align:right;">';
		$t1sum = $sum['T1']*$scount;
		echo formatInIndianStyle($t1sum);
		//money_format("%n", $t1sum);
		$ct1sum=$ct1sum+$t1sum;
		echo '</td>';
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
		echo '<td style="text-align:right;">';
		$netsum = $t1sum+$t23sum+$sacsum;
		$cnetsum=$cnetsum+$netsum;
		//echo money_format("%i", $netsum);
		echo formatInIndianStyle($sacsum);
		echo '</td>';
		echo '</tr>';	
	}
?>
<tr>
<td>00</td>
<td style="text-align:right;"><b>TOTAL AMOUNT</b></td>
<td style="text-align:right;font: bold 15px verdana, serif;"> <b> <?php echo $stcount; ?> </b></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<!-- 
<td style="text-align:right;font: bold 15px verdana, serif;"> <b> <?php echo money_format("%i", $ct1sum); ?> </b></td>
<td style="text-align:right;font: bold 15px verdana, serif;"> <b> <?php echo money_format("%i", $csacsum); ?> </b></td>
<td style="text-align:right;font: bold 15px verdana, serif;"> <b> <?php echo money_format("%i", $cnetsum); ?> </b></td>
-->
<td style="text-align:right;font: bold 15px verdana, serif;font-family:Arial;"> <b> <?php echo '&#8377;&nbsp;'.formatInIndianStyle($ct1sum); ?> </b></td>
<td style="text-align:right;font: bold 15px verdana, serif;font-family:Arial;"> <b> <?php echo '&#8377;&nbsp;'.formatInIndianStyle($ct23sum); ?> </b></td>
<td style="text-align:right;font: bold 15px verdana, serif;font-family:Arial;"> <b> <?php echo '&#8377;&nbsp;'.formatInIndianStyle($csacsum); ?> </b></td>
<td style="text-align:right;font: bold 15px verdana, serif;font-family:Arial;"> <b> <?php echo '&#8377;&nbsp;'.formatInIndianStyle($cnetsum); ?> </b></td>
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

