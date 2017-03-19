<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	$Itemid = JRequest::getVar('Itemid');
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');
	JHTML::script('validate.js', 'components/com_cce/js/');
	$iconsDir1 = JURI::base() . 'components/com_cce/images';
    
   	$model = & $this->getModel('managesubjects');

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

   	$subItemid = $model->getMenuItemid('master','Manage Subjects');
   	if($subItemid) ;
   	else{
        	$subItemid = $model->getMenuItemid('topmenu','Manage School');
   	}
   	$dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
   	$modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=master&Itemid='.$masterItemid);

  	$sublink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=manageschool&view=manageschool&task=display&Itemid='.$subItemid);
	$app =& JFactory::getApplication();
        $pathway =& $app->getPathway(); 
        $pathway->addItem('Home', $dashboardlink);
        $pathway->addItem('Master Settings',$modulelink);
        $pathway->addItem('Manage Subjects');


?>

<form action="<?php echo JRoute::_('index.php?option=com_cce&controller=academicyears&view=academicyears&task=actions&Itemid='.$Itemid); ?>" method="POST" name="adminForm">
	<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-edit"></i> Manage Subjects</h2>
						<div class="pull-right">
						<button class="btn btn-small btn-success" name="Add" value="Add"><i class="icon-plus-sign"></i> Add</button>        
						<button class="btn btn-small btn-primary" value="Edit" name="Edit"> <i class="icon-edit"></i> Edit</button>
						<button class="btn btn-small btn-danger"  value="Delete" name="Delete"> <i class="icon-trash"></i> Delete</button>
						</div>
					</div>
					<div class="box-content">
						<table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead>
							  <tr>
								 <th class="sorting_disabled"><input type="checkbox" onchange="check()" name="chk[]" /></th>
								  <th>Subject Title</th>
								  <th>Subject Code</th>
								  <th>Subject Type</th>
								  <th>Acronym</th>
								  <th>Periods/Week</th>
								  <th>Period Duration</th>
								  <th>Passmark</th>
								  <th>Max.Marks</th>
							  </tr>
						  </thead>   
						  <tbody>
							  <?php
					foreach($this->subjects as $rec) {
                     	?>
							  
							<tr>
								<td><input type="checkbox" name="cid[]" id="cid[]" value="<?php echo $rec->id; ?>" /> </td>
								<td><?php echo $rec->subjecttitle; ?></td>
								<td><?php echo $rec->subjectcode; ?></td>
								<td><?php echo $rec->subjecttype; ?></td>
								<td><?php echo $rec->acronym; ?></td>
								<td><?php echo $rec->credits; ?></td>
								<td><?php echo $rec->sessionduration; ?></td>
								<td><?php echo $rec->passmark; ?></td>
								<td><?php echo $rec->marks; ?></td>
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
					<input type="hidden" name="controller" value="managesubjects" />
				<input type="hidden" name="view" value="managesubjects" />
				<input type="hidden" name="aid" value="<?php echo $this->cay[0]->id; ?>" />
				<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
				<input type="hidden" name="task" value="action"/>
	</form>		


