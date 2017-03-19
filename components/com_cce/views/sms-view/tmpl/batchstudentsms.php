<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	$Itemid  = JRequest::getVar('Itemid');
		$courseid  = JRequest::getVar('courseid');
		JHtml::stylesheet('styles.css','./components/com_cce/css/');
        JHTML::script('academicyear.js', 'components/com_cce/js/');
           JHTML::script('validate.js', 'components/com_cce/js/');
        $model = & $this->getModel();
        $iconsDir1 = JURI::base() . 'components/com_cce/images';
        $dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
        $modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=sms&Itemid='.$masterItemid);

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
                <h1 class="item-page-title">STUDENTS BATCH SMS</h1>
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

<br />



<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header well" data-original-title>
						
						<h2><i class="icon-user"></i> Student Batch Sms</h2>
						<div style="float:right;margin-top:-5px;">
												
					<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce&controller=studentstc&view=studentstc&courseid='.$this->courseid.'&task=display&layout=default&Itemid='.$Itemid); ?>" method="POST" name="adminForm">
							<fieldset>
								<div class="control-group">
								<label class="control-label" for="selectError">Select Class</label>
								<div class="controls">
								  <select id="selectError" data-rel="chosen" onchange="submit();" name="courses">
									<option value="se">Select</option> 
								   <?php
					
													foreach($this->courses as $course) :
													echo "<option value=\"".$course->id."\" ".($course->id == $this->courseid ? "selected=\"yes\"" : "").">".$course->code."</option>";
													endforeach;
										?>
								  </select>
							
							  </div>
							</fieldset>
					<input type="hidden" name="controller" value="sms" />
					<input type="hidden" name="view" value="sms" />
					<input type="hidden" name="layout" value="batchstudentsms" />
					<input type="hidden" name="courseid" value="<?php echo $this->courseid; ?>" />
					<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
					<input type="hidden" name="task" value="displaystudents"/>
					</form>
				</div>
						</div>
					</div>
													
<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce&controller=studentstc&view=studentstc&courseid='.$this->courseid.'&task=display&layout=default&Itemid='.$Itemid); ?>" method="POST" name="adminForm">
				
					<div class="box-content">
						<table class="table table-striped table-bordered">
						  <thead>
							  <tr>
								          <th class="sorting_disabled"><input type="checkbox" onchange="check()" name="chk[]" /></th>
								  <th>Reg.No</th>
								  <th>Student Name</th>
								  <th>Gender</th>
								  <th>Mobile No</th>
							  </tr>
						  </thead>   
						  <tbody>
							 <?php
						if($this->students){
							 foreach($this->students as $rec) {
											   $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=studentstc&controller=studentstc&layout=entertc&task=display&sid='.$rec->id.'',false);	
							
								echo '<tr>';
								echo '<td><input type="checkbox" name="cid[]" id="cid[]" value="'.$rec->id.'" /></td>';
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
	
							<div class="control-group">
							  <label class="control-label" for="textarea2">Sms Message</label>
							  <div class="controls">
								<textarea class="cleditor" id="textarea2" rows="3" name="smstext"><?php echo $this->rec->smstext; ?></textarea>
							  </div>
							</div>
					</div>
				</div><!--/span-->
												<div class="form-actions">
								<button type="submit" class="btn btn-primary" name="send" value="Send">Send Sms</button>
							  </div>
			</div><!--/row-->
<br />
<input type="hidden" name="controller" value="sms" />
<input type="hidden" name="view" value="sms" />
<input type="hidden" name="layout" value="batchstudentsms" />
<input type="hidden" name="courseid" value="<?php echo $this->courseid; ?>" />
<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
<input type="hidden" name="task" value="logstudentsbatchsms"/>
<input type="hidden" name="to" value="<?php echo $this->code; ?>"/>
</form>

