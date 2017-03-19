<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');
	$Itemid = JRequest::getVar('Itemid');
	$courseid= JRequest::getVar('courses');
	$pcourseid= JRequest::getVar('pcourses');
	$npcourseid= JRequest::getVar('npcourses');
	
	$iconsDir1 = JURI::base() . 'components/com_cce/images';

   	$model = & $this->getModel('promotion');

	$courses = $model->getCurrentCourses();
	
	$r = $model->getThisAcademicYear($cay);
	
	$r = $model->getNextAcademicYear($nay);
	$ncourses = $model->getCourses($nay->id);

	$students = $model->getStudents($courseid);

	$r=$model->getPromotionStatus($courseid,$pst);

   	$dashboardItemid = $model->getMenuItemid('manageschool','Dash Board');
   	if($dashboardItemid) ;
   	else{
        	$dashboardItemid = $model->getMenuItemid('topmenu','Manage School');
   	}
	$masterItemid = $model->getMenuItemid('manageschool','promotion');
        if($masterItemid) ;
        else{
                $masterItemid = $model->getMenuItemid('topmenu','Manage School');
        }
   	$dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
   	$modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=grades&Itemid='.$masterItemid);

?>

<div class="row-fluid sortable">
<div class="box span12">
<div class="box-header well" data-original-title>
<div class="span7">
  <h2><i class="icon-edit"></i>
<?php
echo $cay->academicyear.' TO '.$nay->academicyear;
?>
</h2>
</div>

<div class="span3">
<form class="form-horizontal pull-right" action="<?php echo JRoute::_('index.php?option=com_cce&controller=promotion&view=promotion&courseid='.$courseid.'&task=display&layout=promotion&Itemid='.$Itemid); ?>" method="POST" name="adminForm">
  <fieldset>
    <div class="control-group">
      <label class="control-label" for="selectError">Select Current Class</label>
      <div class="controls">
        <select id="selectError" data-rel="chosen" onchange="submit();" name="courses">
          <?php
		if(!$courseid) echo '<option value="-1">--Select--</option>';
                foreach($courses as $course) :
                echo "<option value=\"".$course->id."\" ".($course->id == $courseid ? "selected=\"yes\"" : "").">".$course->code."</option>";
                endforeach;                                                             ?>
        </select>
      </div>
    </div>
  </fieldset>
  <input type="hidden" name="controller" value="promotion" />
  <input type="hidden" name="view" value="promotion" />
  <input type="hidden" name="courseid" value="<?php echo $courseid; ?>" />
  <input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
</form>
</div>
</div>

<form class="form-horizontal pull-right" action="<?php echo JRoute::_('index.php?option=com_cce&controller=promotion&view=promotion&courseid='.$courseid.'&task=promoteandtransfer&layout=promotion&Itemid='.$Itemid); ?>" method="POST" name="adminForm">
<?php
	if(!$pst){
?>

Promoted To: <select id="" data-rel="chosen"  name="pcourses">
          <?php
		if(!$pcourseid) echo '<option value="-1">--Select--</option>';
                foreach($ncourses as $ncourse) :
                echo "<option value=\"".$ncourse->id."\" ".($ncourse->id == $pcourseid ? "selected=\"yes\"" : "").">".$ncourse->code."</option>";
                endforeach;                                                             ?>
        </select>
Not Promoted To: <select id="" data-rel="chosen"  name="npcourses">
          <?php
		if(!$npcourseid) echo '<option value="-1">--Select--</option>';
                foreach($ncourses as $ncourse) :
                echo "<option value=\"".$ncourse->id."\" ".($ncourse->id == $npcourseid ? "selected=\"yes\"" : "").">".$ncourse->code."</option>";
                endforeach;                                                             ?>
        </select>
<?php
}
?>
</div>
<br>
<div class="box-content">
  <table class="table table-striped table-bordered bootstrap-datatable">
    <thead>
      <tr>
        <th>Reg.No</th>
        <th>Student Name</th>
        <th>Gender</th>
        <th>Status</th>
<?php
if($pst)
	echo '<th>Class</th>';
?>
      </tr>
    </thead>
    <tbody>
<?php
	if($students){
		foreach($students as $srec) {
			echo '<tr>';
				echo "<td>$srec->registerno</td>";
				echo "<td>$srec->firstname&nbsp;$rec->middlename&nbsp;$rec->lastname</td>";
				echo "<td >$srec->gender</td>";
				if($pst=='1'){
					$rr = $model->getPromotionByStudent($courseid,$srec->id,$ssrec);
					if($ssrec->status=='1')
						echo '<td>Promoted</td>';
					else if($ssrec->status=='0')
						echo '<td>Not Promoted</td>';
					else
						echo '<td>--</td>';
					
					$r = $model->getCourse($ssrec->newcid,$ncrec);
					echo '<td>'.$ncrec->code.'</td>';
				}
				else {
?>
				<td>
					<select name="status[]">
						<option value="<?php echo $srec->id.':1'; ?>">Promoted</option>
						<option value="<?php echo $srec->id.':0'; ?>">Not Promoted</option>
					</select>
				</td>
<?php
				}
			echo '</tr>';
		}
	}
?>
    </tbody>
    </table>
</div>
</div>
<?php
	if($pst=="1"){
?>
  <div class="form-actions"align="left">
    <button class="btn btn-small btn-success" name="command" value="Restart"><i class="icon-plus-sign"></i> Restart</button>
  </div>
<?php
	}
?>
<?php
	if(!$pst){
?>
  <div class="form-actions" align="right">
    <button class="btn btn-small btn-success" name="command" value="Promote"><i class="icon-plus-sign"></i> Promote</button>
  </div>
<?php
}
?>

<input type="hidden" name="controller" value="promotion" />
<input type="hidden" name="view" value="promotion" />
<input type="hidden" name="courseid" value="<?php echo $courseid; ?>" />
<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
<input type="hidden" name="task" value="promoteandtransfer"/>
</form>
                        
</div>
</div>
