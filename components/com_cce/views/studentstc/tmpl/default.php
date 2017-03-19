<?php
        defined('_JEXEC') OR DIE('Access denied..');
 

	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	$Itemid  = JRequest::getVar('Itemid');
	$courseid=JRequest::getVar('courseid');

	$iconsDir1 = JURI::base() . 'components/com_cce/images';
    $co = JRequest::getVar('courseid');
   	$model = & $this->getModel('cce');
   	$dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
   	$modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=students&Itemid='.$masterItemid);

  	$studentslink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=students&view=students&task=display&Itemid='.$studentsItemid);
	$app =& JFactory::getApplication();
        $pathway =& $app->getPathway(); 
        $pathway->addItem('Home', $dashboardlink);
        $pathway->addItem('Students',$modulelink);
        $pathway->addItem('List');

?>

<!--
<table width="100%" cellpadding="10">
        <tr style="border:none;">
                <td style="border:none;" align="left">
        <div style="float:left;">
           <img src="<?php echo $iconsDir1.'/TC.png'; ?>" alt="" style="width: 64px; height: 64px;" />
        </div>
        <div style="float:left">
                <div>&nbsp;</div>
                <h1 class="item-page-title"><?php echo "$this->coursename".' '.$this->section; ?></h1>
        </div>
                       <div style="float:right;"> <a href="<?php echo $dashboardlink; ?>"><img src="<?php echo $iconsDir1.'/1dashboard.png'; ?>" alt="Dash Board" style="width: 32px; height: 32px;" /></a><br />
			</div>
			<div style="float:right; width:10px;"> &nbsp;</div>
			<div style="float:right;">
                        <a href="<?php echo $modulelink; ?>"><img src="<?php echo $iconsDir1.'/1students.png'; ?>" alt="Students" style="width: 32px; height: 32px;" /></a><br />
			</div>
	
                </td>
        </tr>
</table>
-->


<b style="font: bold 15px Georgia, serif;"><?php echo $this->coursename.'-'.$this->section; ?></b>
<div class="row-fluid sortable">		
	<div class="box-header well" data-original-title>
		<h2><i class="icon-user"></i> Students TC</h2>
		<div style="float:right;margin-top:-5px;">
			<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce&controller=studentstc&view=studentstc&courseid='.$this->courseid.'&task=display&layout=default&Itemid='.$Itemid); ?>" method="POST" name="adminForm">
				<fieldset>
					<div class="control-group">
						<label class="control-label" for="selectError">Select Class</label>
						<div class="controls">
							<select id="selectError" data-rel="chosen" onchange="submit();" name="courses">
								<option value="">Select</option> 
<?php
foreach($this->courses as $course) :
							echo "<option value=\"".$course->id."\" ".($course->id == $this->courseid ? "selected=\"yes\"" : "").">".$course->code."</option>";
endforeach;
?>
							</select>

						</div>
					</div>
				</fieldset>
				<input type="hidden" name="controller" value="studentstc" />
				<input type="hidden" name="view" value="studentstc" />
				<input type="hidden" name="courseid" value="<?php echo $this->courseid; ?>" />
				<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
				<input type="hidden" name="task" value="actions"/>
				<input type="hidden" name="layout" id="layout" value="default"/>
			</form>
		</div>
	</div>
</div>
<div class="box-content">
<table class="table table-striped table-bordered bootstrap-datatable datatable">
<thead>
<tr>
<th>Reg.No</th>
<th>Student Name</th>
<th>Gender</th>
<th>Mobile No</th>
<th>Actions</th>
</tr>
</thead>   
<tbody>
<?php
if($this->students){
foreach($this->students as $rec) {
$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=studentstc&controller=studentstc&layout=entertc&task=display&sid='.$rec->id.'',false);	
echo '<tr>';
echo "<td>$rec->registerno</td>";
echo "<td>$rec->firstname&nbsp;$rec->middlename&nbsp;$rec->lastname</td>";
echo "<td>$rec->gender</td>";
echo "<td>$rec->mobile</td>";
echo '<td class="center">';
echo '<a class="btn btn-success" href="'.$redirectTo.'">';
echo '<i class="icon-zoom-in icon-white"></i>  View  </a>';
echo '</td>';
?>
</tr>
<?php
}
}
?>
</tbody>
</table>  
</div>
</div><!--/span-->
</div><!--/row-->
<br />
