

<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	$Itemid  = JRequest::getVar('Itemid');
		JHtml::stylesheet('styles.css','./components/com_cce/css/');
        JHTML::script('academicyear.js', 'components/com_cce/js/');
        JHTML::script('validate.js', 'components/com_cce/js/');
        $model = & $this->getModel();
        $iconsDir1 = JURI::base() . 'components/com_cce/images';
        $dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
        $modulelink = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=sms&Itemid='.$masterItemid);
?>

<!-- TOP LINKS....DASHBOARD -->
<table width="100%" cellpadding="10">
        <tr style="border:none;">
                <td style="border:none;" align="right">
  <div style="float:left;">
           <img src="<?php echo $iconsDir.'/smsqueue.png'; ?>" alt="" style="width: 64px; height: 64px;" />
        </div>
        <div style="float:left;">
                <h2></h2>
                <h1 class="item-page-title">STUDENTS GROUP SMS</h1>
        </div>

                       <div style="float:right;"> <a href="<?php echo $dashboardlink; ?>"><img src="<?php echo $iconsDir1.'/1dashboard.png'; ?>" alt="Dash Board" style="width: 48px; height: 48px;" /></a><br />
                        </div>
                        <div style="float:right; width:10px;"> &nbsp;</div>
                        <div style="float:right;">
                        <a href="<?php echo $modulelink; ?>"><img src="<?php echo $iconsDir1.'/1sms.png'; ?>" alt="Bulk SMS" style="width: 48px; height: 48px;" /></a><br />
                        </div>
                </td>
        </tr>
</table>



	<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-edit"></i>Group Members</h2>
						
						<div style="float:right;margin-top:-5px;">									
				        	<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce&controller=studentstc&view=studentstc&courseid='.$this->courseid.'&task=display&layout=default&Itemid='.$Itemid); ?>" method="POST" name="adminForm">
							<fieldset>
								<div class="control-group">
								<label class="control-label" for="selectError">Select Class</label>
								<div class="controls">
								  <select id="selectError" data-rel="chosen"  onChange="submit();" name="groups">
								           <option vlaue=""> Select</option>
									        <?php
   
										    foreach($this->groups as $group) :
											echo "<option value=\"".$group->id."\" ".($group->id == $this->groupid ? "selected=\"yes\"" : "").">".$group->groupname."</option>";
											endforeach;
										    
							
											?>
							
								  </select>
								<input type="hidden" name="controller" value="sms" />
								<input type="hidden" name="view" value="sms" />
								<input type="hidden" name="layout" value="groupstudentsms" />
								<input type="hidden" name="groupid" value="<?php echo $this->groupid; ?>" />
								<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
								<input type="hidden" name="task" value="displaygroupstudents"/>
											  </form>
				
							  </div>
							</fieldset>


					
				</div>
			</div>
					</div>
					<div class="box-content">
						<form class="form-horizontal" id ="cbexample" action="index.php" method="POST" name="adminForm">
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
					foreach($this->students as $rec) {
						
						$rs = $model->getCourse($rec->joinedclassid,$joinedclassid);
                     	?>
							  
							<tr>
								<td><input type="checkbox"  name="cid[]" value="<?php echo $rec->id; ?>" /> </td>
								<td><?php echo $rec->registerno; ?></td>
								<td><?php echo $rec->firstname; $rec->middlename; $rec->lastname; ?></td>
								<td><?php echo $joinedclassid->code; ?></td>
								<td><?php echo $rec->gender; ?></td>
							</tr>
							<?php
								}
							?>
							 </tbody>
					  </table>  
					  <div class="control-group">
							  <label class="control-label" for="textarea2">Message : </label>
							  <div class="controls">
								<textarea class="cleditor" id="textarea2" name="smstext" rows="3"><?php echo $this->rec->smstext; ?></textarea>
							  </div>
					 </div>  
                  <div class="form-actions">
							  <button type="submit" class="btn btn-primary">Send Sms</button>
							  <button type="reset" class="btn">Cancel</button>
					</div>      							 
				<input type="hidden" name="controller" value="sms" />
				<input type="hidden" name="view" value="sms" />
				<input type="hidden" name="layout" value="groupstudentsms" />
				<input type="hidden" name="groupid" value="<?php echo $this->groupid; ?>" />
				<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
				<input type="hidden" name="task" value="sendgroupstudentsms"/>
				</form>
      
					</div>
               
	              
				</div><!--/span-->
			
			</div><!--/row-->




