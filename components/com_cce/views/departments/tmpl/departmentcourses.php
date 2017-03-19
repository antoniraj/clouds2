<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');
	JHTML::script('validate.js', 'components/com_cce/js/');
	$Itemid = JRequest::getVar('Itemid');
	$departmentid= JRequest::getVar('departmentid');
	$iconsDir1 = JURI::base() . 'components/com_cce/images';

   	$model = & $this->getModel('cce');

	$courseids = $model->getDepartmentCourses($departmentid);

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

   	$deptItemid = $model->getMenuItemid('master','Departments');
   	if($deptItemid) ;
   	else{
        	$deptItemid = $model->getMenuItemid('topmenu','Manage School');
   	}
   	$dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
   	$modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=courses&Itemid='.$masterItemid);

  	$deptlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=departments&view=departments&task=display&Itemid='.$deptItemid);
	$app =& JFactory::getApplication();
        $pathway =& $app->getPathway(); 
        $pathway->addItem('Home', $dashboardlink);
        $pathway->addItem('Courses',$modulelink);
        $pathway->addItem('Department Courses');



?>

<div class="row-fluid sortable">		
	<div class="box span12">
		<div class="box-header well" data-original-title>
			<h2><i class="icon-edit"></i> Departments Courses</h2>
				<form class="form-horizontal pull-right" action="<?php echo JRoute::_('index.php?option=com_cce&controller=departments&view=departments&task=showDepartmentCourses&layout=departmentcourses&Itemid='.$Itemid); ?>" method="POST" name="adminForm">
					<div class="pull-right">
						<fieldset>
							<select id="selectError" data-rel="chosen" onchange="submit();" name="departmentid">
								<option value="">Select Department</option>
								<?php
								foreach($this->departments as $department) :
								echo "<option value=\"".$department->id."\" ".($department->id == $departmentid ? "selected=\"yes\"" : "").">".$department->departmentname."</option>";
								endforeach;
								?>
							</select>
						</fieldset>
					<input type="hidden" name="controller" value="departments" />
					<input type="hidden" name="view" value="departments" />
					<input type="hidden" name="layout" value="departmentcourses" />
					<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
					<input type="hidden" name="task" value="showDepartmentCourses"/>
				</form>
					</div>
			</div>
		</div>
	</div>

	<div class="box-content">
	     <form action="<?php echo JRoute::_('index.php?option=com_cce&controller=departments&view=departments&task=courselist&layout=courselist&departmentid='.$departmentid.'&Itemid='.$Itemid); ?>" method="POST" name="adminForm">
		<table class="table table-striped table-bordered bootstrap-datatable datatable">
			<thead>
				<tr>
					<th><input type="checkbox" value="" onchange="check()" name="chk[]"></th>
					<th>Course Name</th>
					<th>Section Name</th>
					<th>Code</th>
				</tr>
			</thead>
			<tbody>
			<?php
			foreach($courseids as $rec) {
				if($model->getCourse($rec->courseid,$crec)){
			?>
				<tr>
					<td><input type="checkbox" name="cid[]" id="cid[]" value="<?php echo $rec->courseid; ?>" /></td>
					<td><?php echo $crec->coursename; ?></td>
					<td><?php echo $crec->sectionname; ?></td>
					<td><?php echo $crec->code; ?></td>
				</tr>
			<?php
				}
			}
			?>
			</tbody>
		</table>
		<div class="form-actions">
			<div class="pull-right">
				<button class="btn btn-small btn-success" name="Add" value="Add"><i class="icon-plus-sign icon-white"></i> Assign Courses</button>
				<button class="btn btn-small btn-danger"  value="Delete" name="Delete"> <i class="icon-trash icon-white"></i> Remove Courses</button>
			</div>
		</div>
		<input type="hidden" name="controller" value="departments" />
		<input type="hidden" name="view" value="departments" />
		<input type="hidden" name="departmentid" value="<?php echo $departmentid; ?>" />
		<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
		<input type="hidden" name="layout" value="courselist"/>
		<input type="hidden" name="task" value="courselist"/>
	   </form>


	</div>
</div>

