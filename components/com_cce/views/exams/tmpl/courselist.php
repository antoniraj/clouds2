<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
        $iconsDir = JURI::base() . 'components/com_cce/images/64x64';
        JHtml::stylesheet('styles.css','./components/com_cce/css/');
        JHTML::script('academicyear.js', 'components/com_cce/js/');
        JHTML::script('validate.js', 'components/com_cce/js/');

        $Itemid = JRequest::getVar('Itemid');
        $cbid= JRequest::getVar('cbid');


        $iconsDir1 = JURI::base() . 'components/com_cce/images';

        $model = & $this->getModel('exams');
	$courses = $model->getCurrentCourses();

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
        $fcItemid = $model->getMenuItemid('manageschool','Fee Category');
        if($fcItemid) ;
        else{
                $fcItemid = $model->getMenuItemid('topmenu','Manage School');
        }
        $dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
        $modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=courses&Itemid='.$masterItemid);
        $fclink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=departments&view=departments&task=showdepartmentcourses&layout=departmentcourses&departmentid='.$departmentid.'&Itemid='.$Itemid);

?>

<form class="form-horizontal" action="<?php echo JRoute::_('index.php'); ?>" method="POST" name="adminForm">
	<div class="row-fluid sortable">		
		<div class="box span12">
			<div class="box-header well" data-original-title>
				<h2><i class="icon-edit"></i> <strong>Assign Courses</strong></h2>
				<div class="box-icon">
					<button class="btn btn-small btn-success" name="Add" value="Assign"><i class="icon-plus-sign icon-white"></i> Assign</button>
				</div>

			</div>
			<div class="box-content">
			<table class="table table-striped table-bordered bootstrap-datatable datatable">
				<thead>
					  <tr>
						  <th  class="sorting_disabled"><input type="checkbox" value="" onchange="check()" name="chk[]"></th>
						  <th>Code</th>
						  <th>Course Name</th>
					  </tr>			
				</thead>   
				<tbody>
			        <?php
				if($courses){
		                   foreach($courses as $rec) {   ?>
				<tr>
	                 		<td><input type="checkbox" name="cid[]" id="cid[]" value="<?php echo $rec->id; ?>" /> </td>
		                 	<td><?php echo $rec->code; ?></td>
        		         	<td><?php echo $rec->coursename; ?></td>
       				 </tr>
			        <?php 
				  }
				}
				?>
				</tbody>
			</table>  
			<div class="form-actions" align="right">
				<button class="btn btn-small btn-success" name="Add" value="Assign"><i class="icon-plus-sign icon-white"></i> Assign</button>
			</div>          
			</div>
		</div>
	</div>
	<input type="hidden" name="controller" value="exams" />
	<input type="hidden" id="view" name="view" value="exams" />
	<input type="hidden" id="Itemid" name="Itemid" value="<?php echo $Itemid; ?>" />
	<input type="hidden" name="task" id="task" value="assigncourses" />
	<input type="hidden" name="layout" id="layout" value="coursebooks" />
	<input type="hidden" name="cbid" value="<?php echo $cbid; ?>" />
</form>
