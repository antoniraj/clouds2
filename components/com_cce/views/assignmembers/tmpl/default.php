

<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	$Itemid = JRequest::getVar('Itemid');
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');
	JHTML::script('validate.js', 'components/com_cce/js/');

	$iconsDir1 = JURI::base() . 'components/com_cce/images';

   	$model = & $this->getModel('groups');
    $courseid  = JRequest::getVar('courseid');
   	$dashboardItemid = $model->getMenuItemid('manageschool','Dash Board');
   	if($dashboardItemid) ;
   	else{
        	$dashboardItemid = $model->getMenuItemid('topmenu','Manage School');
   	}
	$masterItemid = $model->getMenuItemid('manageschool','Students Details');
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


?>
				
<div class="row-fluid sortable">		
					<div class="box-header well" data-original-title>
					<h2><i class="icon-edit"></i> Assign Students</h2>
						<div style="float:right;margin-top:-5px;">										
				        	<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce&controller=studentstc&view=studentstc&courseid='.$this->courseid.'&task=display&layout=default&Itemid='.$Itemid); ?>" method="POST" name="adminForm">
							<fieldset>
								<div class="control-group">
								<label class="control-label" for="selectError">Select Course/Class</label>
								<div class="controls">
								  <select id="selectError" data-rel="chosen" onchange="submit();" name="courses">
									<?php
									        foreach($this->courses as $course) :
											echo "<option value=\"".$course->id."\" ".($course->id == $courseid ? "selected=\"yes\"" : "").">".$course->code."</option>";
											endforeach;
											    
												
										?>
								  </select>
								</div>
							  </div>
							</fieldset>
							<input type="hidden" name="controller" value="groupmembers" />
							<input type="hidden" name="groupid" value="<?php echo $this->groupid; ?>" />
							<input type="hidden" id="view" name="view" value="assignmembers" />
							<input type="hidden" id="Itemid" name="Itemid" value="<?php echo $Itemid; ?>" />
							<input type="hidden" name="task" id="task" value="actions" />
						  </form>
					
			</div>
					</div>
				        	<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce&controller=groupmembers&view=groupmembers&courseid='.$this->courseid.'&task=save&layout=default&Itemid='.$Itemid); ?>" method="POST" name="adminForm">
					<div class="box-content">
					    <div style="float:right;"><button class="btn btn-small btn-success" name="Assign" value="Assign"><i class="icon-plus-sign icon-white"></i> Assign</button></div>
					
						<table class="table table-striped table-bordered">
						  <thead>
							  <tr>
								  <th><input type="checkbox" onchange="check()" name="chk[]" /></th>
								  <th>Reg.No</th>
								  <th>Student Name</th>
								  <th>Gender</th>
								  <th>Mobile No</th>
							  </tr>
						  </thead>   
						  <tbody>
							 <?php
					    if($courseid)
					    { 
					    $students = $this->model->getStudents($courseid);
						}
						else{
							 $students = $this->model->getStudents($this->courseid);
						}
						if($students){
							 foreach($students as $rec) {
								$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=studentstc&controller=studentstc&layout=entertc&task=display&sid='.$rec->id.'',false);	
							
								
								?>
								<tr> <td><input type="checkbox" name="cid[]" id="cid[]" value="<?php echo $rec->id; ?>" />
								<?php 
								 echo "<td>$rec->registerno</td>";
								 echo "<td>$rec->firstname&nbsp;$rec->middlename&nbsp;$rec->lastname</td>";
								 echo "<td>$rec->gender</td>";
								 echo "<td>$rec->mobile</td>";
							 ?>
							
								</tr>
							<?php
								}
							}
						
						
							?>
                           	 </tbody>
						 </table>  
					    <div style="float:right;"><button class="btn btn-small btn-success" name="Assign" value="Assign"><i class="icon-plus-sign icon-white"></i> Assign</button></div>
		
							<input type="hidden" name="controller" value="groupmembers" />
							<input type="hidden" name="groupid" value="<?php echo $this->groupid; ?>" />
						   <?php
							if($courseid)
							{
							?>
							<input type="hidden" name="courseid" value="<?php echo $courseid; ?>" />
							<?php
						    }
						    else{
								
							?>
							<input type="hidden" name="courseid" value="<?php echo $this->courseid; ?>" />
							<?php
					     	}
							?>
							<input type="hidden" id="view" name="view" value="assignmembers" />
							<input type="hidden" id="Itemid" name="Itemid" value="<?php echo $Itemid; ?>" />
							<input type="hidden" name="task" id="task" value="save" />
							</form>

					</div>

					
				</div><!--/span-->
				
			</div><!--/row-->



