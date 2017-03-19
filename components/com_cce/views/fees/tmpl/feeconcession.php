<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');
	$Itemid = JRequest::getVar('Itemid');
        $courseid= JRequest::getVar('courseid');
        $fcid= JRequest::getVar('fcid');
	$iconsDir1 = JURI::base() . 'components/com_cce/images';

   	$model = & $this->getModel('fees');
	$courses = $model->getCurrentCourses();
        $model->getCourse($courseid,$crec);
        $model->getFeeCategory($fcid,$frec);
	$students = $model->getStudents($courseid);
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
	$app =& JFactory::getApplication();
        $pathway =& $app->getPathway(); 
        $pathway->addItem('Home', $dashboardlink);
        $pathway->addItem('Fees',$modulelink);
        $pathway->addItem('Fee Concession');

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
			<h1 class="item-page-title" align="left">Fees Concession</h1>
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

<b style="font: bold 15px Georgia, serif;">FEE CONCESSION</b>

<div class="row-fluid sortable">
<div class="box span12">
<div class="box-header well" data-original-title>
<table border="0" width="100%">
<tr><td width="25%">
<fieldset>
<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce&controller=studentstc&view=studentstc&courseid='.$this->courseid.'&task=display&layout=default&Itemid='.$Itemid); ?>" method="POST" name="adminForm">
<label>Select Course/Class </label>
<select id="selectError" data-rel="chosen" onchange="submit();" name="courseid">
<option value="">Select an Option</option>
<?php
foreach($courses as $course) :
echo "<option value=\"".$course->id."\" ".($course->id == $courseid ? "selected=\"yes\"" : "").">".$course->code."</option>";
endforeach;
?>
</select>
<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
<input type="hidden" name="task" value="display" />
<input type="hidden" name="controller" value="fees" />
<input type="hidden" name="view" value="fees" />
<input type="hidden" name="layout" value="feeconcession" />
</form>
</td><td width="20%" style="text-align:left;">
<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce&controller=studentstc&view=studentstc&courseid='.$this->courseid.'&task=display&layout=default&Itemid='.$Itemid); ?>" method="POST" name="adminForm">
<label>Fee Category </label>
<select id="selectError1" data-rel="chosen" name="fcid">
<?php
if($fcid){
$precs = $model->getFeeParticulars($fcid);
$total=0.0;
foreach($precs as $prec){
$total = $total + $prec->amount;
}
echo '<option value="'.$fcid.'">'.$frec->name.'(Rs. '.$total.')</option>';
}
foreach($fcs as $fc){
if($fcid != $fc->id){
$precs = $model->getFeeParticulars($fc->id);
$total=0.0;
foreach($precs as $prec){
$total = $total + $prec->amount;
}
echo '<option value="'.$fc->id.'">'.$fc->name.'(Rs.'.$total.')</option>';
}
}
?>
</select>
</td>
<td width="20%">
<label>Student</label>
<select id="selectError3" data-rel="chosen" name="studentid">
<?php
foreach($students as $student){
echo '<option value="'.$student->id.'">'.$student->firstname.'('.$student->registerno.')</option>';
}
?>
</select>
</td><td width="25%">
<label class="control-label" for="focusedInput">Amount(Rs.):</label>
<input class="focused" id="focusedInput" type="text" name="amount" value="">
</td><td>
<button class="btn btn-small btn-success"  type="submit" name="save" value="Save">Save</button>

<input type="hidden" id="view" name="view" value="fees" />
<input type="hidden" id="controller" name="controller" value="fees" />
<input type="hidden" name="task" id="task" value="savefeeconcession" />
<input type="hidden" name="layout" id="layout" value="feeconcession" />
<input type="hidden" name="Itemid" id="Itemid" value="<?php echo $Itemid; ?>" />
<input type="hidden" name="courseid" id="courseid" value="<?php echo $courseid; ?>" />
        
</form>
</fieldset>

</td></tr></table>






<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce&controller=students&courseid='.$this->courseid.'&task=actions&Itemid='.$Itemid); ?>" method="POST" name="adminForm">


</div>
</div>
<div class="box-content">
  <table class="table table-striped table-bordered">
    <thead>
	<tr>
		<th>Sno</th>
		<th>Reg.No</th>
		<th>Name</th>
		<th>Fee Category</th>
		<th>Concession</th>
		<th>Fee Amount</th>
		<th>Operation</th>
	</tr>
    </thead>
    <tbody>
<?php
	$concessions = $model->getFeeConcession($courseid);
	$i=1;
	foreach($concessions as $con){
		echo '<tr>';
		$r = $model->getStudent($con->studentid,$srec);
		echo '<td>';
		echo $i++;
		echo '</td>';
		echo '<td>';
		echo $srec->registerno;
		echo '</td>';
		echo '<td>';
		echo $srec->firstname;
		echo '</td>';
        	$r=$model->getFeeCategory($con->fcid,$fc);
		if($r){
			$precs = $model->getFeeParticulars($con->fcid);
    	            	$total=0.0;
        	        foreach($precs as $prec){
                		$total = $total + $prec->amount;
                	}
			echo '<td>'.$fc->name.'('.$total.')</td>';
		}else{
			echo '<td>---</td>';
		}
		echo '<td align="right">';
		echo $con->amount;
		echo '</td>';

		echo '<td align="right">';
		$rs=$total-$con->amount;
		printf("%.2f",$rs);
		echo '</td>';
		echo '<td>';
   		$dlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=fees&view=fees&task=deleteconcession&layout=feeconcession&conid='.$con->id.'&courseid='.$courseid.'&Itemid='.$Itemid);
		echo '<a href='.$dlink.'>X</a>';
		echo '</td>';
		echo '</tr>';
	}
?>
    </tbody>
  </table>
</div>
</div>
        <input type="hidden" id="view" name="view" value="fees" />
        <input type="hidden" id="controller" name="controller" value="fees" />
        <input type="hidden" name="task" id="task" value="savefeeconcession" />
        <input type="hidden" name="layout" id="layout" value="feeconcession" />
        <input type="hidden" name="Itemid" id="Itemid" value="<?php echo $Itemid; ?>" />
        <input type="hidden" name="courseid" id="courseid" value="<?php echo $courseid; ?>" />
</form>



