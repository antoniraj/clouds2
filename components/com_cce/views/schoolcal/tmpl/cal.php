<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	$cy = $this->model->getCurrentAcademicYear();
	$ys=explode('-',$cy[0]->academicyear); 
	$monthdate=JRequest::getVar('month');
	$Itemid =JRequest::getVar('Itemid');
	$date = new DateTime($monthdate);
	$a=explode('-',$monthdate);
	$yno=$a[0];
	//echo $date->format('F');
	function days_in_month($month, $year)
	{
		// calculate number of days in a month
		return $month == 2 ? ($year % 4 ? 28 : ($year % 100 ? 29 : ($year % 400 ? 28 : 29))) : (($month - 1) % 7 % 2 ? 30 : 31);
	} 
	$mdays=0;
	$monthno=0;
	$year=0;
	if($monthdate){
		$a = explode('-',$monthdate);
		$monthno=$a[1];
		$year = $a[0];
		$mdays = days_in_month($a[1],$a[0]);
	//	$crecs=$this->model->getCal($monthdate,$a[0].'-'.$a[1].'-'.$days);
	//	print_r($crecs);
	}
?>
<h1><center>Academic Year: <?php echo $cy[0]->academicyear; ?></center></h1><hr />
<form action="<?php echo JRoute::_('index.php?option=com_cce'); ?>" method="POST" name="adminForm">
<table style="border:none;" borde="0" width="100%" cellspacing="2" cellpadding="3">
<tr style="border:none;"><td style="border:none;" align="left"><?php echo '<h2>'.$date->format('F').'-'.$yno.'</h2>'; ?></td> <td style="border:none;" align="right">Select Month:
        <select name="month" onChange="submit();">
        <?php
		$months = array('6'=>array("June",$ys[0]."-06-01"),
				'7'=>array('July',$ys[0]."-07-01"),
				'8'=>array('August',$ys[0]."-08-01"),
				'9'=>array('September',$ys[0]."-09-01"),
				'10'=>array('October',$ys[0]."-10-01"),
				'11'=>array('November',$ys[0]."-11-01"),
				'12'=>array('December',$ys[0]."-12-01"),
				'1'=>array('January',$ys[1]."-01-01"),
				'2'=>array('Febraury',$ys[1]."-02-01"),
				'3'=>array('March',$ys[1]."-03-01"),
				'4'=>array('April',$ys[1]."-04-01"),
				'5'=>array('May',$ys[1]."-05-01"),
			  );
                if($monthdate)
                        echo '<option value="'.$monthdate.'">'.$date->format('F').'</option>';
                else
                        echo '<option>--Select month--</option>';
                foreach($months as $month)
                {
                        if($monthdate!= $month[0])
                                echo '<option value="'.$month[1].'">'.$month[0].'</option>';
                }
        ?>
        </select>
	<input type="submit" name="go" value="Go" class="button_go">
	<input type="hidden" name="controller" value="calendar" >
	<input type="hidden" name="view" value="schoolcal" >
	<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" >
	<input type="hidden" name="layout" value="cal" >
	<input type="hidden" name="task" value="go" >

</td>
</tr>
</table>
</form>
<hr />
<table width="100%" borde="0" style="border:none;" cellspacing="2" cellpadding="3">
    <tr style="border:none;">
	<th class="list-title" width="5%">S#</th><th class="list-title" width="12%">DATE</th><th width="8%" class="list-title">DAY</th><th class="list-title" width="59%">PROGRAMME</th><th width="15%" class="list-title">TYPE</th>
    </tr>
<?php
$i=1;
while($i<=$mdays){
	$s = $this->model->getCalEntry("$year-$monthno-$i",$rec);
	$dte = new DateTime("$year-$monthno-$i");
	echo '<tr><td style="vertical-align: middle;">'.$i."</td>";
	echo '<td style="vertical-align: middle;" align="right">'."$i".'-'."$monthno".'-'."$year"."</td>";
	echo '<td style="vertical-align: middle;">'.$dte->format('D')."</td>";
	
	echo '<td style="vertical-align: middle;">'.$rec[0]['description'].'</td>';
	echo '<td style="vertical-align: middle;">';
	if($s){
		echo $rec[0]['daytype'];
	}else{
	        if($dte->format('D')=='Sun') echo 'HD';
	        if($dte->format('D')=='Sat') echo 'HAD';
	        if($dte->format('D')!='Sun' && $dte->format('D')!='Sat') echo 'WD';
		echo '</td></tr>';
	}
	$i++;
}
?>
</table>
