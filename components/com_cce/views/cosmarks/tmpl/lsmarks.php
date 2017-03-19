<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	$Itemid = JRequest::getVar('Itemid');
	$termid = JRequest::getVar('termid');
	$courseid = JRequest::getVar('courseid');
	$iconsDir1 = JURI::base() . 'components/com_cce/images';
	
	$activityid= JRequest::getVar('activityid');
	$arecs=$this->model->getLSActivities();
	$this->model->getLSActivity($activityid,$activity);
	$srecs=$this->model->getStudents($courseid);
	$r=$this->model->getTerm($termid,$trec);
	$r=$this->model->getCourse($courseid,$crec);
	    $dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
        $modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=grades&Itemid='.$masterItemid);
	$showcourses= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=courses&view=showcourses&Itemid='.$masterItemid);
	$entermarkslink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=courses&view=showcourseprofile&courseid='.$courseid.'&Itemid='.$masterItemid);

?>
<table width="100%" cellpadding="10">
        <tr style="border:none;"> <td style="border:none;" align="right">
  <div style="float:left;">
           <img src="<?php echo $iconsDir.'/entermarks.png'; ?>" alt="" style="width: 64px; height: 64px;" />
        </div>
        <div style="float:left;">
                <h2></h2> <h2></h2> 
                <h1 class="item-page-title"><?php echo $crec->code; ?></h1>
        </div>
                       <div style="float:right;"> <a href="<?php echo $dashboardlink; ?>"><img src="<?php echo $iconsDir1.'/1dashboard.png'; ?>" alt="Dash Board" style="width: 32px; height: 32px;" /></a><br /> </div>
                        <div style="float:right; width:10px;"> &nbsp;</div>
                        <div style="float:right;">
                        <a href="<?php echo $modulelink; ?>"><img src="<?php echo $iconsDir1.'/1results.png'; ?>" alt="Master" style="width: 32px; height: 32px;" /></a><br />
                        </div>
                        <div style="float:right; width:10px;"> &nbsp;</div>
                        <div style="float:right;">
                        <a href="<?php echo $showcourses; ?>"><img src="<?php echo $iconsDir1.'/entermarks.png'; ?>" alt="Enter Marks" style="width: 32px; height: 32px;" /></a><br />
                        </div>
                        <div style="float:right; width:10px;"> &nbsp;</div>
                        <div style="float:right;">
                        <a href="<?php echo $entermarkslink; ?>"><img src="<?php echo $iconsDir.'/entermarks.png'; ?>" alt="Enter Marks" style="width: 32px; height: 32px;" /></a><br />
                        </div>
                </td>
        </tr>
</table>
<?php
	echo '<center><h1>'.$crec->code.' - Life Skills</h1><br><h3>['.$trec->term.']</h3></center>';
?>
<br>

<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header well" data-original-title>
						
						<h2><i class="icon-user"></i> <?php echo $activity->activityname.'('.$activity->activitycode.')'; ?></h2>
						<div style="float:right;margin-top:-5px;">
						<form class="form-horizontal" action="index.php" method="POST" name="adminForm">
							<fieldset>
								<div class="control-group">
								<label class="control-label" for="selectError">Select Life Skill</label>
								<div class="controls">
								  <select id="selectError" data-rel="chosen" onchange="submit();" name="activityid">
									<option value="">Select</option> 
								   <?php
					
											  	 foreach($arecs as $arec) :
													echo "<option value=\"".$arec->id."\" ".($arec->id == $activityid ? "selected=\"yes\"" : "").">".$arec->activityname."</option>";
													endforeach;
										?>
								  </select>
							  <input type="hidden" name="controller" value="cosmarks" />
  <input type="hidden" name="view" value="cosmarks" />
  <input type="hidden" name="courseid" value="<?php echo $courseid; ?>" />
   <input type="hidden" name="termid" value="<?php echo $termid; ?>" />
     <input type="hidden" name="courseid" value="<?php echo $courseid; ?>" />
  <input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
    <input type="hidden" name="layout" value="lsmarks" />
    </fieldset>

					</form>				
		</div>

						</div>
<div class="box-content">
		<form action="<?php echo JRoute::_('index.php?option=com_cce&controller=cosmarks&task=savelsmarks'); ?>" method="POST" name="adminForm">

      <table class="table table-striped table-bordered ">
      					<div class="form-actions">
							  <button type="submit" class="btn btn-primary" name="save" value="Save">Save</button>
							</div>
        <thead>
<?php
			echo "<tr><th class=\"list-title\">#</th><th class=\"list-title\">RNo</th><th class=\"list-title\">Student Name</th><th class=\"list-title\">Marks/5</th><th class=\"list-title\">Descriptive Indicators</th></tr></thead>";
		$i=1;
if($activityid) {		
                foreach($srecs as $srec) {
?>
<tbody>
        	<tr>
                <td width="5%" style="vertical-align: top;"><?php echo $i++; ?></td>
                <td width="10%" style="vertical-align: top;"><?php echo $srec->registerno; ?></td>
                <td width="25%" align="left" style="vertical-align: top;"><?php echo $srec->firstname; ?></td>
<?php
		$r = $this->model->getLSCoSMarks($srec->id,$activityid,$courseid,$termid,$data);	

?>			
                <td style="vertical-align: top;" width="5%"><input type="text" name="marks[]" style="width: 40px;" value="<?php echo $data[0]['marks']; ?>" /></td>
		<th width="20%"><textarea name="indicators[]" style="height: 50px;" rows="5" cols="40"><?php echo $data[0]['indicators']; ?></textarea> </th>
		</tr>
		<input type="hidden" name="sid[]" value="<?php echo $srec->id; ?>" />
		<input type="hidden" name="mid[]" value="<?php echo $data[0]['id']; ?>" />
		<input type="hidden" name="rno[]" value="<?php echo $srec->registerno; ?>" />
<?php
		}
}		
		?>
		</tbody>
</table>
							<div class="form-actions">
							  <button type="submit" class="btn btn-primary" name="save" value="Save">Save</button>
							</div>
		<input type="hidden" name="aid" value="<?php echo $activityid; ?>" />
		<input type="hidden" name="termid" value="<?php echo $termid; ?>" />
		<input type="hidden" name="courseid" value="<?php echo $courseid; ?>" />
		<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
		<input type="hidden" name="controller" value="cosmarks" />
		<input type="hidden" name="view" value="cosmarks" />
		<input type="hidden" name="layout" value="lsmarks" />
		<input type="hidden" name="task" value="savelsmarks" />
</form>


					</div>
				</div><!--/span-->
				</div>
