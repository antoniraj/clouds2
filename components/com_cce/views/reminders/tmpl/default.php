<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	$cy = $this->model->getCurrentAcademicYear();
	$ys=explode('-',$cy[0]->academicyear); 
	$monthdate=JRequest::getVar('month');
	$Itemid =JRequest::getVar('Itemid');
	$date = new DateTime($monthdate);

	$iconsDir1 = JURI::base() . 'components/com_cce/images';


        $dashboardItemid = $this->model->getMenuItemid('manageschool','Dash Board');
        if($dashboardItemid) ;
        else{
                $dashboardItemid = $this->model->getMenuItemid('topmenu','Manage School');
        }
        $masterItemid = $this->model->getMenuItemid('manageschool','Master');
        if($masterItemid) ;
        else{
                $masterItemid = $this->model->getMenuItemid('topmenu','Manage School');
        }

   	$dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
   	$modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=news&Itemid='.$masterItemid);


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

<!--
TOP LINKS....DASHBOARD
-->
<table width="100%" cellpadding="10">
        <tr style="border:none;">
                <td style="border:none;" align="left">
		<div style="float:left;">
                       <img src="<?php echo $iconsDir1.'/Calendar.png'; ?>" alt="Cal" style="width: 48px; height: 48px;" />
		</div>
		<div style="float:left;">
			<h1 class="item-page-title">Academic Year:<?php echo $cy[0]->academicyear; ?></h1>
		</div>
                       <div style="float:right;"> <a href="<?php echo $dashboardlink; ?>"><img src="<?php echo $iconsDir1.'/1dashboard.png'; ?>" alt="Dash Board" style="width: 48px; height: 48px;" /></a><br />
                        </div>
                        <div style="float:right; width:10px;"> &nbsp;</div>
                        <div style="float:right;">
                        <a href="<?php echo $modulelink; ?>"><img src="<?php echo $iconsDir1.'/1master.png'; ?>" alt="Master" style="width: 48px; height: 48px;" /></a><br />
                        </div>
                </td>
        </tr>
</table>

<br />
<form action="<?php echo JRoute::_('index.php?option=com_cce'); ?>" method="POST" name="adminForm">
<table style="border:none;" borde="0" width="100%" cellspacing="2" cellpadding="3">
<tr style="border:none;"> <td style="border:none;" align="right">Select Month:
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
	<input type="hidden" name="controller" value="reminders" >
	<input type="hidden" name="view" value="reminders" >
	<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" >
	<input type="hidden" name="layout" value="default" >
	<input type="hidden" name="task" value="go" >

</td>
</tr>
</table>

</form>
<form action="<?php echo JRoute::_('index.php?option=com_cce'); ?>" method="POST" name="adminForm">
<table width="100%" borde="0" style="border:none;" cellspacing="2" cellpadding="3">
    <tr style="border:none;"><td style="border:none;" colspan="4" align="left"><h1 class="item-page-title"><?php echo $date->format('F').'-'.$year; ?></h1></td><td style="border:none;" colspan="2" align="right"><input type="submit" class="button_save" value="Save" name="submit" /></td>
    </tr>
    <tr style="border:none;">
	<th class="list-title" width="5%">S#</th><th class="list-title" width="12%">DATE</th><th width="8%" class="list-title">DAY</th><th class="list-title" width="54%">PROGRAMME</th>
    </tr>
<?php
$i=1;
while($i<=$mdays){
	$s = $this->model->getReminderEntry("$year-$monthno-$i",$rec);
	$dte = new DateTime("$year-$monthno-$i");
	echo '<tr><td style="vertical-align: middle;">'.$i."</td>";
	echo '<td style="vertical-align: middle;" align="right">'."$i".'-'."$monthno".'-'."$year"."</td>";
	echo '<td style="vertical-align: middle;">'.$dte->format('D')."</td>";
	
	echo '<td style="vertical-align: middle;"><textarea class="textarea" name="programme[]" style="height: 20px;" rows="2" cols="40">'.$rec[0]['description'].'</textarea></td>';
        echo '</tr>';

	if($s)
		echo '<input type="hidden" name="calid[]" value="'.$rec[0]['id'].'">';
	else
		echo '<input type="hidden" name="calid[]" value="-1">';
	echo '<input type="hidden" name="cdate[]" value="'.$year.'-'.$monthno.'-'.$i.'">';
	$i++;
}
?>
</table>
<br />
<table style="border:none;">
	<tr style="border:none;"><td style="border:none;" colspan="5" align="right"><input type="submit" name="save" value="Save" class="button_save"></td></tr>
</table>
	<input type="hidden" name="controller" value="reminders" >
	<input type="hidden" name="view" value="reminders" >
	<input type="hidden" name="layout" value="default" >
	<input type="hidden" name="month" value="<?php echo $monthdate; ?>" >
	<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" >
	<input type="hidden" name="task" value="save" >
</form>
