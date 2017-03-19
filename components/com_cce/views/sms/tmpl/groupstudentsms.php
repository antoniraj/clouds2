

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
	$app =& JFactory::getApplication();
        $pathway =& $app->getPathway(); 
        $pathway->addItem('Home', $dashboardlink);
     //   $pathway->addItem('SMS',$modulelink);
        $pathway->addItem('GROUP SMS');

?>

<b style="font: bold 15px Georgia, serif;">SMS MODULE</b>

<?php
        $this->showlinks();
?>

<!-- The following script is used to show the limit in the text area box -->
<script>
$(document).ready(function () {

  $('#smstext').keypress(function (event) {
    var max = 315;
    var len = $(this).val().length;

    if (event.which < 0x20) {
      // e.which < 0x20, then it's not a printable character
      // e.which === 0 - Not a character
      return; // Do nothing
    }

    if (len >= max) {
      event.preventDefault();
    }

  });

  $('#smstext').keyup(function (event) {
    var max = 315;
    var len = $(this).val().length;
    var char = max - len;

    $('#textleft').text(char + ' characters left');

  });

});
</script>




	<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-edit"></i>Group Members</h2>
						
						<div style="float:right;margin-top:-5px;">									
				        	<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce&controller=sms&view=sms&groupid='.$this->groupid.'&task=displaygroupstudents&layout=groupstudentsms&Itemid='.$Itemid); ?>" method="POST" name="adminForm">
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
				        	<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce&controller=sms&view=sms&groupid='.$this->groupid.'&task=sendgroupstudentsms&layout=groupstudentsms&Itemid='.$Itemid); ?>" method="POST" name="adminForm">
						<table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead>
							  <tr>
								  <th><input type="checkbox" checked="true" onchange="check()" name="chk[]" /></th>
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
								<td><input type="checkbox"  checked="true" name="cid[]" value="<?php echo $rec->id; ?>" /> </td>
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
							  <label class="control-label" for="textarea2">Message :<br /> </label>
							  <div class="controls">
								<textarea class="" id="smstext"  style="width:500px;"  name="smstext" rows="3" maxlength="300" ><?php echo $this->rec->smstext; ?></textarea>
<div id="textleft">315 characters left</div>
							  </div>
					 </div>  
                  <div class="form-actions">
							  <button type="submit" class="btn btn-primary">Send Sms</button>
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




