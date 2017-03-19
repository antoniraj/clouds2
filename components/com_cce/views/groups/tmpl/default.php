<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsdir = JURI::base() . 'components/com_cce/images/64x64';
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');
	JHTML::script('validate.js', 'components/com_cce/js/');
	$Itemid = JRequest::getVar('Itemid');

	$iconsDir1 = JURI::base() . 'components/com_cce/images';

   	$model = & $this->getModel('groups');
    
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

   	$groupItemid = $model->getMenuItemid('master','Student Groups');
   	if($groupItemid) ;
   	else{
        	$groupItemid = $model->getMenuItemid('manageschool','Home');
   	}
   	$dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
   	$modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=master&Itemid='.$masterItemid);

  	$grouplink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=groupmembers&view=groupmembers&task=display&Itemid='.$groupItemid);
        $app =& JFactory::getApplication();
        $pathway =& $app->getPathway();
        $pathway->addItem('Home', $dashboardlink);
        $pathway->addItem('Settings',$modulelink);
        $pathway->addItem('Groups');


?>

<form action="<?php echo JRoute::_('index.php?option=com_cce&controller=academicyears&view=academicyears&task=actions&Itemid='.$Itemid); ?>" method="POST" name="adminForm">
						<div class="pull-right">
						<button class="btn btn-small btn-success" name="Add" value="Add"><i class="icon-plus-sign"></i> Add</button>        
						<button class="btn btn-small btn-primary" value="Edit" name="Edit"> <i class="icon-edit"></i> Edit</button>
						<button class="btn btn-small btn-danger"  value="Delete" name="Delete"> <i class="icon-trash"></i> Delete</button>
						</div>
	<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header well" data-original-title>
							<h2><i class="icon-edit"></i> Academic Groups</h2>
						<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
						</div>
					</div>
					<div class="box-content">
						<table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead>
							  <tr>
								   <th><input type="checkbox" onchange="check()" name="chk[]" /></th>
								  <th>Group Name</th>
								  <th>Group Code</th>
								  <th>Purpose</th>
								  <th>Description</th>
							  </tr>
						  </thead>   
						  <tbody>
							  <?php
					foreach($this->groups as $rec) {
                     	?>
							  
							<tr>
								<td><input type="checkbox" name="cid[]" id="cid[]" value="<?php echo $rec->id; ?>" /> </td>
								<td><?php echo $rec->groupname; ?></td>
								<td><?php echo $rec->groupcode; ?></td>
								<td><?php echo $rec->purpose; ?></td>
								<td><?php echo $rec->description; ?></td>
							</tr>
							<?php
								}
							?>
							 </tbody>
					  </table>     
						<div class="form-actions">
					</div>          
					</div>

				</div><!--/span-->
			
			</div><!--/row-->
			<input type="hidden" name="view" value="groups" />
			<input type="hidden" name="controller" value="groups" />
			<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
			<input type="hidden" name="task" value="actions"/>
	</form>		


