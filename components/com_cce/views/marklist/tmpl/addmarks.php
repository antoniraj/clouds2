<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
        $templateDir = JURI::base() . 'templates/' . $app->getTemplate();
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');
?>
<div>
        <div style="float:left;">
           <img src="<?php echo JURI::root().'templates/'.$app->getTemplate().'/images/64x64/addterm.png'; ?>" alt="" style="width: 64px; height: 64px;" />
        </div>
        <div>
                <div>&nbsp;</div>
                <h1>Add/Edit Activity/Test Marks</h1>
        </div>
</div>
<hr /> <br />
<!-- BACK BUTTON-->
<form action="index.php" method="post" name="backform">
	<div align="right"><input type="submit" name="Back" value="Back" /></div>
	<input type="hidden" name="referer" value="<?php echo base64_encode(@$_SERVER['HTTP_REFERER']); ?>" /> 
	<input type="hidden" name="option" value="com_cce" />
	<input type="hidden" name="controller" value="gradebookmarks" />
	<input type="hidden" name="task" value="back" />
</form>

<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-edit"></i> Add/Edit FA Activity</h2>
						<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
						</div>
					</div>
					<div class="box-content">
						<form action="<?php echo JRoute::_('index.php?option=com_cce&controller=academicyears&view=addacademicyear&task=save&id='.$this->rec->id.'&Itemid='.$Itemid) ?>" class="form-horizontal" method="POST"  name="addform" id="addform" onsubmit="return checkform()">				
						  <fieldset>
						         <div class="control-group">
								<label class="control-label" for="focusedInput">Roll Number</label>
								<div class="controls">
								<?php echo $this->rno; ?>					
								</div>
							  </div>
		                      <div class="control-group">
								<label class="control-label" for="focusedInput">Student Name</label>
								<div class="controls">
								<?php echo $this->firstname; ?>					
								</div>
							  </div>
							
                              <div class="control-group">
								<label class="control-label" for="focusedInput">Assesment Title</label>
								<div class="controls">
									<?php echo $this->atitle; ?> 						
									</div>
							  </div>
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Description</label>
								<div class="controls">
									<input type="text" class="focused" id="focusedInput" name="comments" size="50" maxlength="150" value="<?php echo $this->mrec->comments;  ?>" />
								  </div>
							  </div>
							    <div class="control-group">
								<label class="control-label" for="focusedInput">Marks</label>
								<div class="controls">
						<select name="marks">
     		   		<?php
     	           		if($this->mrec->marks)
                        		echo '<option value="'.$this->mrec->marks.'">'.$this->mrec->marks.'</option>';
                		else
                        		echo '<option>--Select a mark--</option>';
                		for($i=0;$i<=$this->max;$i=$i+0.5)
                		{
                			echo '<option value="'.$i.'">'.$i.'</option>';
                		}
       			 		?>
       			 		</select>			
								  </div>
							  </div>
							    <div class="control-group">
								<label class="control-label" for="focusedInput">Comments</label>
								<div class="controls">
								<input type="text" id="comments" name="comments" size="50" maxlength="150" value="<?php echo $this->mrec->comments;  ?>" />
							
								  </div>
							  </div>
					
		
							<div class="form-actions">
							  <button type="submit" class="btn btn-primary" name="submit" value="submit">Save</button>
							</div>
						  </fieldset>
						  
	<input type="hidden" name="option" value="<?php echo JRequest::getVar('option'); ?>" />
	<input type="hidden" id="id" name="id" value="<?php echo $this->marksid; ?>" />
	<input type="hidden" id="courseid" name="courseid" value="<?php echo $this->courseid; ?>" />
	<input type="hidden" id="subjectid" name="subjectid" value="<?php echo $this->subjectid; ?>" />
	<input type="hidden" id="studentid" name="studentid" value="<?php echo $this->studentid; ?>" />
	<input type="hidden" id="gid" name="gid" value="<?php echo $this->gid; ?>" />
	<input type="hidden" id="sacdid" name="sacdid" value="<?php echo $this->sacdid; ?>" />
	<input type="hidden" id="entryid" name="entryid" value="<?php echo $this->sacdid; ?>" />
	<input type="hidden" id="max" name="max" value="<?php echo $this->max; ?>" />
	<input type="hidden" id="termid" name="termid" value="<?php echo $this->termid; ?>" />
	<input type="hidden" id="view" name="view" value="marklist" />
	<input type="hidden" id="controller" name="controller" value="gradebookmarks" />
	<input type="hidden" name="task" id="task" value="savemarks" />
						</form>   

					</div>
				</div><!--/span-->

			</div><!--/row-->

</form>
