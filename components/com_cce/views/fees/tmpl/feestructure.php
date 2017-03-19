<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');
	$Itemid = JRequest::getVar('Itemid');
        $courseid= JRequest::getVar('courseid');
	$iconsDir1 = JURI::base() . 'components/com_cce/images';

	setlocale(LC_MONETARY,"en_IN");
   	$model = & $this->getModel('fees');
	$courses = $model->getCurrentCourses();
        $model->getCourse($courseid,$crec);

	$fcs = $model->getCourseFeeCategories($courseid);

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

//Add Fee Category
        $addlink = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=fees&controller=fees&layout=addeditfeecategory&Itemid='.$Itemid);

	$app =& JFactory::getApplication();
        $pathway =& $app->getPathway(); 
        $pathway->addItem('Home', $dashboardlink);
        $pathway->addItem('Fees',$modulelink);
        $pathway->addItem('Fee Structure');

?>
<!--
TOP LINKS....DASHBOARD
<table width="100%" cellpadding="10">
        <tr style="border:none;">
                <td style="border:none;" align="left">
		<div style="float:left">
                        <img src="<?php echo $iconsDir.'/fees.png'; ?>" alt="" style="width: 44px; height: 44px;" />
		</div>
		<div style="float:left">
			<h1 class="item-page-title" align="left">Fees Structure</h1>
		</div>
                       <div style="float:right;"> <a href="<?php echo $dashboardlink; ?>"><img src="<?php echo $iconsDir.'/1dashboard.png'; ?>" alt="Dash Board" style="width: 32px; height: 32px;" /></a><br />
			</div>
			<div style="float:right; width:10px;"> &nbsp;</div>
			<div style="float:right;">
                        <a href="<?php echo $modulelink; ?>"><img src="<?php echo $iconsDir.'/fees.png'; ?>" alt="Fees" style="width: 32px; height: 32px;" /></a><br />
			</div>
                </td>
        </tr>
</table>

-->

<b style="font: bold 15px Georgia, serif;">FEE STRUCTURE</b>
<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce&controller=fees&layout=feestructure&courseid='.$this->courseid.'&task=display&Itemid='.$Itemid); ?>" method="POST" name="adminForm">
<div class="row-fluid sortable">
<div class="box span12">
<div class="box-header well" data-original-title>
<div class="span7">
  <h2><i class="icon-edit"></i> <strong>Fee Structure</strong></h2>
</div>
<div class="span3">
<form class="form-horizontal pull-right" action="<?php echo JRoute::_('index.php?option=com_cce&controller=studentstc&view=studentstc&courseid='.$courseid.'&task=display&layout=default&Itemid='.$Itemid); ?>" method="POST" name="adminForm">
  <fieldset>
    <div class="control-group">
      <label class="control-label" for="selectError">Select Course/Class</label>
      <div class="controls">
        <select id="selectError" data-rel="chosen" onchange="submit();" name="courseid">
			<option value="">Please Select an Option</option>
          <?php
					
		foreach($courses as $course) :
			echo "<option value=\"".$course->id."\" ".($course->id == $courseid ? "selected=\"yes\"" : "").">".$course->code."</option>";
		endforeach;
	?>
        </select>
      </div>
    </div>
  </fieldset>
<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
<input type="hidden" name="task" value="display" />
<input type="hidden" name="controller" value="fees" />
<input type="hidden" name="view" value="fees" />
<input type="hidden" name="layout" value="feestructure" />
</form>
</div>
</div>
<div class="box-content">
  <table class="table table-striped table-bordered">
    <thead>
	<tr>
		<th>Sno</th>
		<th>Category</th>
		<th>Particulars</th>
		<th>Amount</th>
	</tr>
    </thead>
    <tbody>
<?php
	$i=1;
	$gtot=0.0;
	foreach($fcs as $fc){
		echo '<tr>';
		echo '<td>'.$i++.'</td>';
		echo '<td>'.$fc->name.'</td>';
		echo '<td>';
		echo '<table>';
		$precs = $model->getFeeParticulars($fc->id);
		$total=0.0;
		setlocale(LC_MONETARY,"en_IN");
		foreach($precs as $prec){
			echo '<tr style="border:0px;">';
			echo '<td style="border:0px;" width="4%"></td>';
			echo '<td style="border:0px;" width="60%">'.$prec->name.'</td>';
			echo '<td style="border:0px;text-align:right;" width="20%" >';
			echo money_format("%i", $prec->amount);
			echo '</td>';
			echo '<td style="border:0px;" width="16%"></td>';
			$total = $total + $prec->amount;
			echo '</tr>';
		}
		echo '</table>';
		echo '</td>';
		printf('<td style="text-align:right;">');
		echo money_format("%i", $total);
		echo '</td></tr>';
		$gtot=$gtot+$total;
	}
	printf('<tr style="border:2px; solid;"><td colspan="3" align="right"><b>Grand Total</b></div></td>');
	printf('<td style="text-align:right;font-size:18px;"><b>');
	echo money_format("%i", $gtot);
	echo '</b></td></tR>';
?>
    </tbody>
  </table>
</div>
</div>

<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
<input type="hidden" name="task" value="display" />
<input type="hidden" name="controller" value="fees" />
<input type="hidden" name="view" value="fees" />
<input type="hidden" name="layout" value="feestructure" />
</form>

