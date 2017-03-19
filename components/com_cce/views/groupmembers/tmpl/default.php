
<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');
	JHTML::script('validate.js', 'components/com_cce/js/');
	$Itemid=JRequest::getVar('Itemid');

	$iconsDir1 = JURI::base() . 'components/com_cce/images';
    	$groupid=JRequest::getVar('groupid');
     	$courseid=JRequest::getVar('courseid');
   	$model = & $this->getModel('groups');
   	$dashboardItemid = $model->getMenuItemid('manageschool','Dash Board');
   	if($dashboardItemid) ;
   	else{
        	$dashboardItemid = $model->getMenuItemid('topmenu','Manage School');
   	}
	$masterItemid = $model->getMenuItemid('master','Students Details');
        if($masterItemid) ;
        else{
                $masterItemid = $model->getMenuItemid('topmenu','Manage School');
        }

   	$gItemid = $model->getMenuItemid('master','Group Members');
   	if($gItemid) ;
   	else{
        	$gItemid = $model->getMenuItemid('topmenu','Manage School');
   	}
   	$dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
   	$modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=students&Itemid='.$masterItemid);

  	$glink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=groupmembers&view=groupmembers&task=display&Itemid='.$gItemid);


 	$app =& JFactory::getApplication();
        $pathway =& $app->getPathway();
        $pathway->addItem('Home', $dashboardlink);
        $pathway->addItem('Students',$modulelink);
        $pathway->addItem('Groups');

?>
<!--
<div class="pull-right">
<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce&controller=groups&view=groups&task=display&Itemid='.$Itemid); ?>" method="POST" name="adminForm">			
	<button class="btn btn-small btn-success" name="Add" value="Add"><i class="icon-plus-sign icon-white"></i> New Group</button>
</form>
</div>
-->
<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce&controller=groupmembers&view=groupmembers&task=display&groupid='.$groupid.'&Itemid='.$Itemid); ?>" method="POST" name="adminForm">			
	<div class="row-fluid sortable">		
					<div class="box-header well" data-original-title>
						<h2><i class="icon-edit"></i>Group Members</h2>
						
						<div style="float:right;">
												
				  			<fieldset>
								<div class="control-group">
								<label class="control-label" for="selectError">Select Groups</label>
								<div class="controls">
								  <select id="selectError" data-rel="chosen" onchange="submit();" name="groupid">
									        <?php
										    foreach($this->groups as $group) :
											echo "<option value=\"".$group->id."\" ".($group->id == $groupid ? "selected=\"yes\"" : "").">".$group->groupname."</option>";
											endforeach;
											?>
								           <option value="-1" class="btn btn-small btn-warning">Create New Group</option>
							
								  </select>
							</fieldset>
<?php if ($groupid) {  ?>
					<div class="pull-right">
					<button class="btn btn-small btn-success" name="Add" value="Add"><i class="icon-plus-sign icon-white"></i> Allot</button>
					<button class="btn btn-small btn-danger"  value="Delete" name="Delete"> <i class="icon-trash icon-white"></i> Delete</button>
					<input type="hidden" name="controller" value="groupmembers" />
					</div>        <?php } ?>   
					
							  </div>
					
				</div>
			</div>
					<div class="box-content">
						<table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead>
							  <tr>
								  <th><input type="checkbox" onchange="check()" name="chk[]" /></th>
								  <th>Student Rno</th>
								  <th>Student Name</th>
								  <th>Class Name</th>
								  <th>Gender</th>
							  </tr>
						  </thead>   
						  <tbody>
							  <?php
					foreach($this->groupmembers as $rec) {
						
						$rs = $model->getCourseByGroup($rec->id,$groupid,$crec);
						//$rs = $model->getCourse($rec->joinedclassid,$joinedclassid);
                     	?>
							  
							<tr>
								<td><input type="checkbox" name="cid[]" id="cid[]" value="<?php echo $rec->id; ?>" /> </td>
								<td><?php echo $rec->registerno; ?></td>
								<td><?php echo $rec->firstname; $rec->middlename; $rec->lastname; ?></td>
								<td><?php echo $crec->code; ?></td>
								<td><?php echo $rec->gender; ?></td>
							</tr>
							<?php
								}
							?>
							 </tbody>
							 
					  </table>       
					<div class="form-actions">
<?php if ($groupid) {  ?>
					<div class="pull-right">
					<button class="btn btn-small btn-success" name="Add" value="Add"><i class="icon-plus-sign icon-white"></i> Allot</button>
					<button class="btn btn-small btn-danger"  value="Delete" name="Delete"> <i class="icon-trash icon-white"></i> Delete</button>
					<input type="hidden" name="controller" value="groupmembers" />
					</div>        <?php } ?>   
					</div>           
	                 </div>
				</div><!--/span-->
			
			</div><!--/row-->
<input type="hidden" name="view" value="groupmembers" />
<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
<input type="hidden" name="task" value="actions"/>
</form>


