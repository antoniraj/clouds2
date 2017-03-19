<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');
	$Itemid=JRequest::getVar('Itemid');

	$iconsDir1 = JURI::base() . 'components/com_cce/images';
   	$model = & $this->getModel('cce');
   	$dashboardItemid = $model->getMenuItemid('manageschool','Dash Board');
   	if($dashboardItemid) ;
   	else{
        	$dashboardItemid = $model->getMenuItemid('topmenu','Manage School');
   	}
	$masterItemid = $model->getMenuItemid('manageschool','Master');
        if($masterItemid) ;
        else{
                $masterItemid = $model->getMenuItemid('topmenu','Manage School');
        }
   	$dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
   	$modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=courses&Itemid='.$masterItemid);
?>

<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce&controller=academicyears&view=academicyears&task=actions&Itemid='.$Itemid); ?>" method="POST" name="adminForm">
<div class="row-fluid sortable">
<div class="box span12">
<div class="box-header well" data-original-title>
<div class="span7">
  <h2><i class="icon-edit"></i>Class Teachers</h2>
</div>
<div class="span3">
<form class="form-horizontal pull-right" action="<?php echo JRoute::_('index.php?option=com_cce&controller=studentstc&view=studentstc&courseid='.$this->courseid.'&task=display&layout=default&Itemid='.$Itemid); ?>" method="POST" name="adminForm">
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
  <input type="hidden" name="controller" value="classteachers" />
  <input type="hidden" name="view" value="classteachers" />
  <input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
  <input type="hidden" name="courseid" value="<?php echo $this->courseid; ?>" />
  <input type="hidden" name="task" value="actions"/>
</form>
</div>
</div>
<div class="box-content">
  <table class="table table-striped table-bordered bootstrap-datatable datatable">
    <thead>
      <tr>
         <th><input type="checkbox" value="" onchange="check()" name="chk[]"></th>
        <th>Staff Code</th>
        <th>Staff Name</th>
      </tr>
    </thead>
    <tbody>
      <?php
					foreach($this->classteachers as $rec) {
                 		?>
      <tr>
        <td><input type="checkbox" name="cid[]" id="cid[]" value="<?php echo $rec->id; ?>" /></td>
        <td><?php 
			$s=$this->model->getStaff($rec->staffid,$staffrecord); 
			echo $staffrecord->staffcode;  
		   ?></td>
        <td><?php echo "$staffrecord->firstname $staffrecord->middlename $staffrecord->lastname"; ?></td>
      </tr>
      <?php
								}
							?>
    </tbody>
  </table>
  <div class="row-fluid">
    <div class="span6">
      <button class="btn btn-small btn-danger"  value="Delete" name="Delete"> <i class="icon-trash"></i> Delete</button>
    </div>
    <div class="span6" align="right">
      <button class="btn btn-small btn-success" name="Add" value="Add"><i class="icon-plus-sign"></i> Add</button>
    </div>
  </div>
</div>
<!--/span-->

</div>
<!--/row-->
<input type="hidden" name="controller" value="classteachers" />
<input type="hidden" name="view" value="classteachers" />
<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
<input type="hidden" name="courseid" value="<?php echo $this->courseid; ?>" />
<input type="hidden" name="task" value="actions"/>
</form>
</div>
