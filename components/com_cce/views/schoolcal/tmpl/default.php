

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

	$model1 = &$this->getModel('timetable');
	$dayorders = $model1->getAllDays();

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
   	$modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=master&Itemid='.$masterItemid);


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
	else{
		$monthno=date('m');
		$year = date('Y');
		$mdays = days_in_month($a[1],$a[0]);
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
			<h1 class="item-page-title">Academic Year: <?php echo $cy[0]->academicyear; ?></h1>
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


<div class="row-fluid sortable">
<div class="box span12">
<div class="box-header well" data-original-title>
<div class="span5">
  <h2><i class="icon-edit"></i> <strong>School Calendar</strong></h2>
</div>
<div class="span4"><strong><?php echo $date->format('F').' - '.$year; ?></strong></div>
<div class="span3">
<form class="form-horizontal pull-right" action="<?php echo JRoute::_('index.php?option=com_cce&controller=studentstc&view=studentstc&courseid='.$this->courseid.'&task=display&layout=default&Itemid='.$Itemid); ?>" method="POST" name="adminForm">
  <fieldset>
    <div class="control-group">
      <label class="control-label" for="selectError">Select Month</label>
      <div class="controls">
        <select id="selectError" data-rel="chosen" onchange="submit();" name="month">
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
               
                foreach($months as $month) :
				echo "<option value=\"".$month[1]."\" ".($date->format('F') == $month[0] ? "selected=\"yes\"" : "").">".$month[0]."</option>";
				endforeach;
                
        ?>
        </select>
      </div>
    </div>
  </fieldset>
	<input type="hidden" name="controller" value="schoolcal" >
	<input type="hidden" name="view" value="schoolcal" >
	<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" >
	<input type="hidden" name="layout" value="default" >
	<input type="hidden" name="task" value="go" >
</form>
</div>

</div>
<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce&controller=students&courseid='.$this->courseid.'&task=actions&Itemid='.$Itemid); ?>" method="POST" name="adminForm">

<div class="box-content">
					<div class="span12" align="left" style="margin-bottom:10px;">
							  <button type="submit" name="save" value="Save" class="btn btn-small btn-primary">Save</button>
				   </div>
<table class="table table-striped table-bordered">
		 <thead>
		 <tr>
			 <th>S#</th>
			  <th width="10%">DATE</th>
			  <th>DAY</th>
			 <th>PROGRAMME</th>
			<th width="10%">DAYTYPE</th>
			<th width="10%">DAYORDER</th>

		 </tr>
		 </thead>
	
<?php
$i=1;
while($i<=$mdays){
	$s = $this->model->getCalEntry("$year-$monthno-$i",$rec);
	$dte = new DateTime("$year-$monthno-$i");
	echo '<tr><td style="vertical-align: middle;">'.$i."</td>";
	echo '<td style="vertical-align: middle;" align="right">'."$i".'-'."$monthno".'-'."$year"."</td>";
	echo '<td style="vertical-align: middle;">'.$dte->format('D')."</td>";
	
	echo '<td style="vertical-align: middle;"><textarea class="textarea" name="programme[]" style="height: 50px;" rows="5" cols="60">'.$rec[0]['description'].'</textarea></td>';
	echo '<td style="vertical-align: middle;">';
        echo '<select name="daytype[]">';
	if($s){
		?>
		<option value="WD" <?php if($rec[0]['daytype']=="WD") echo 'selected="selected"'; ?>>WD</option>
		<option value="HD" <?php if($rec[0]['daytype']=="HD") echo 'selected="selected"'; ?>>HD</option>
		<option value="HAD" <?php if($rec[0]['daytype']=="HAD") echo 'selected="selected"'; ?>>HAD</option>
	<?php
	}else{
	
	        if($dte->format('D')=='Sun') 
			echo '<option value="HD" selected="true">HD</option>';
        	else 
			echo '<option value="HD">HD</option>';
	        if($dte->format('D')!='Sun') echo '<option value="WD" selected="true">WD</option>';
        	else echo '<option value="WD">WD</option>';
//	        if($dte->format('D')=='Sat') echo '<option value="HAD" selected="true">HAD</option>';
  //      	else echo '<option value="HAD">HAD</option>';
	}
	echo '</select>';
	echo '</td>';

	echo '<td style="vertical-align: middle;">';
        echo '<select name="dayorder[]">';
	$ds=$model1->getDay($rec[0]['dayorder'],$drec);
        if($s){
		if($ds==false) echo '<option value="'.$rec[0]['dayorder'].'">---</option>';
                else echo '<option value="'.$rec[0]['dayorder'].'">'.$drec->code.'</option>';
		foreach($dayorders as $dayorder){
                	echo '<option value="'.$dayorder->id.'">'.$dayorder->code.'</option>';
		}
        }else{
	        if($dte->format('D')=='Sun') echo '<option value="0" selected="true">---</option>';
        	else 
		foreach($dayorders as $dayorder){
                	if(strtolower($dte->format('D'))==strtolower($dayorder->code)) 
				echo '<option value="'.$dayorder->id.'" selected="true">'.$dayorder->code.'</option>';
			else
	 	               	echo '<option value="'.$dayorder->id.'">'.$dayorder->code.'</option>';
		}
        }
	echo '<option value="0">---</option>';
        echo '</select>';
        echo '</td></tr>';

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

		<div class="form-actions">
			<button type="submit" name="save" value="Save" class="btn btn-small btn-primary">Save</button>
				 
		</div>
	<input type="hidden" name="controller" value="schoolcal" >
	<input type="hidden" name="view" value="schoolcal" >
	<input type="hidden" name="layout" value="default" >
	<input type="hidden" name="month" value="<?php echo $monthdate; ?>" >
	<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" >
	<input type="hidden" name="task" value="save" >
</form>
			
			
		</div>
						
	</div><!--/span-->
			
</div><!--/row-->
	 	

