<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');
	JHTML::script('validate.js', 'components/com_cce/js/');
	$Itemid = JRequest::getVar('Itemid');
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

   	$deptItemid = $model->getMenuItemid('master','Departments');
   	if($deptItemid) ;
   	else{
        	$deptItemid = $model->getMenuItemid('topmenu','Manage School');
   	}
   	$dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
   	$modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=master&Itemid='.$masterItemid);

  	$deptlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=departments&view=departments&task=display&Itemid='.$deptItemid);
?>
<!--
TOP LINKS....DASHBOARD
-->

<form action="<?php echo JRoute::_('index.php?option=com_cce&controller=academicyears&view=academicyears&task=actions&Itemid='.$Itemid); ?>" method="POST" name="adminForm">
	<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header well" data-original-title>
						 <h2><i class="icon-edit"></i> Departments</h2>
						<div class="box-icon">
						</div>
					</div>
					<div class="box-content">
						<table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead>
							  <tr>
								  <th><input type="checkbox" onchange="check()" name="chk[]" /></th>
								  <th>Department Name</th>
								  <th>Department Code</th>
							  </tr>
						  </thead>   
						  <tbody>
							  <?php
					foreach($this->departments as $rec) {
                        $link2 = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=academicyears&controller=academicyears&task=setcurrent&Itemid='.$Itemid.'&cid[]='.$rec->id);
						?>
							  
							<tr>
								<td><input type="checkbox" name="cid[]" id="cid[]" value="<?php echo $rec->id; ?>" /> </td>
								<td><?php echo $rec->departmentname; ?></td>
								<td><?php echo $rec->departmentcode; ?></td>
							</tr>
							<?php
								}
							?>
							 </tbody>
					  </table>     
								<div class="form-actions">
						<div class="pull-right">
						<button class="btn btn-small btn-success" name="Add" value="Add"><i class="icon-plus-sign"></i> Add</button>        
						<button class="btn btn-small btn-primary" value="Edit" name="Edit"> <i class="icon-edit"></i> Edit</button>
						<button class="btn btn-small btn-danger"  value="Delete" name="Delete"> <i class="icon-trash"></i> Delete</button>
						</div>
					</div>          
					</div>
				</div><!--/span-->
			
			</div><!--/row-->
				<input type="hidden" name="controller" value="departments" />
				<input type="hidden" name="view" value="departments" />
				<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
				<input type="hidden" name="task" value="actions"/>
				</form>		

	

