<script type="text/javascript">
function check()
{
     var checkboxes = document.getElementsByTagName('input'), val = null;    
     for (var i = 0; i < checkboxes.length; i++)
     {
         if (checkboxes[i].type == 'checkbox')
         {
             if (val === null) val = checkboxes[i].checked;
             checkboxes[i].checked = val;
         }
     }
 }
</script>
<?php
        defined('_JEXEC') or die('Denied..');
	$app = JFactory::getApplication();
	$iconsdir = JURI::base() . 'components/com_cce/images/64x64';
	$Itemid  = JRequest::getVar('Itemid');
	$iconsDir1 = JURI::base() . 'components/com_cce/images';
	     $library1 = JURI::base() . 'components/com_cce/images/library/';
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');

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

   	$ayItemid = $model->getMenuItemid('master','Academic Years');
   	if($ayItemid) ;
   	else{
        	$ayItemid = $model->getMenuItemid('manageschool','Home');
   	}
   	$dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
   	$library= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=library&Itemid='.$masterItemid);
 	$returnbook= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=library&view=library&task=display&layout=circulation&Itemid='.$masterItemid);

  	$aylink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=academicyears&view=academicyears&task=display&Itemid='.$ayItemid);
	$totalbook = $model->counttotalbooks($this->book->isbn,$tbooks);
	$av = $model->countavailablebooks($this->book->isbn,$available);
?>
<!--
TOP LINKS....DASHBOARD
-->
<table width="100%" cellpadding="10">
        <tr style="border:none;">
                <td style="border:none;" align="right">
  <div style="float:left;">
           <img src="<?php echo $library1.'/returnbook.png'; ?>" alt="" style="width: 64px; height: 64px;" />
        </div>
        <div style="float:left;">
                <h2></h2>
                <h2></h2>
                <h2></h2>
                <h1 class="item-page-title"> Return Book </h1>
        </div>

                       <div style="float:right;"> <a href="<?php echo $dashboardlink; ?>"><img src="<?php echo $iconsDir1.'/1dashboard.png'; ?>" alt="Dash Board" style="width: 28px; height: 28px;" /></a><br />
			</div>
			<div style="float:right; width:10px;"> &nbsp;</div>
			<div style="float:right;">
                        <a href="<?php echo $library; ?>"><img src="<?php echo $iconsDir1.'/1library.png'; ?>" alt="Master" style="width: 30px; height: 30px;" /></a><br />
			</div>
			<div style="float:right; width:10px;"> &nbsp;</div>
			<div style="float:right;">
                        <a href="<?php echo $returnbook; ?>"><img src="<?php echo $library1.'/returnbook.png'; ?>" alt="Master" style="width: 28px; height: 28px;" /></a><br />
			</div>
			
                </td>
        </tr>
</table>
			<form action="index.php" class="form-horizontal" method="POST" name="addform" id="addform" onSubmit="return stest()">
	
				
			<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-edit"></i> <strong>Return Book</strong></h2>
						<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
						</div>
					</div>
					<div class="box-content">
							<form action="index.php" class="form-horizontal" method="POST" name="addform" id="addform" onSubmit="return stest()">
					
							<fieldset>
								<div class="span3"></div>
								<div class="span5">
									<br>
								<div class="control-group">
								<label class="control-label" for="appendedInputButton">Book Number</label>
								<div class="controls">
								  <div class="input-append">
									<input id="appendedInputButton" size="16" name="key" type="text" value="<?php echo $this->book->bookno; ?>"><button class="btn" type="submit" value="Go" name="Go">Go!</button>
								  </div>
								</div>
							  </div>
							  <div class="span3"></div>
						
				
							</fieldset>
							<input type="hidden" name="option" value="<?php echo JRequest::getVar('option'); ?>" />
							<input type="hidden" id="id" name="id" value="<?php echo $this->rec->id; ?>" />
							<input type="hidden" id="cid" name="cid" value="<?php echo $this->rec->aid; ?>" />
							<input type="hidden" id="view" name="view" value="circulation" />
							<input type="hidden" id="controller" name="controller" value="circulation" />
							<input type="hidden" name="Itemid" id="Itemid" value="<?php echo $Itemid; ?>" />
							<input type="hidden" name="task" id="task" value="Go" />
							<input type="hidden" name="layout" id="layout" value="returnbook" />	
													
						  </form>
					
					</div>
				<?php if($this->book)
				{
				?>
					
				<div class="row-fluid sortable">
					<div class="span1"></div>
				<div class="box span5">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-edit"></i> Book Details</h2>
						<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
						</div>
					</div>
					<div class="box-content">
							<fieldset>
							   
							    <div class="control-group">
								<label class="control-label" for="focusedInput">Book No</label>
								<div class="controls">
								  <input class="disabled" id="focusedInput" name="bookno" disabled="" type="text" value="<?php echo $this->book->bookno; ?>">
								</div>
							  </div>
							    <div class="control-group">
								<label class="control-label" for="focusedInput">Title</label>
								<div class="controls">
								  <input class="disabled" id="focusedInput" disabled="" type="text" value="<?php echo $this->book->title; ?>">
								</div>
							  </div>
							   <div class="control-group">
								<label class="control-label" for="focusedInput">ISBN</label>
								<div class="controls">
								  <input class="disabled" id="focusedInput" disabled="" type="text" value="<?php echo $this->book->isbn; ?>">
								</div>
							  </div>
							 
							   <div class="control-group">
								<label class="control-label" for="focusedInput">Author</label>
								<div class="controls">
								  <input class="disabled" id="focusedInput" disabled="" type="text" value="<?php echo $this->book->author; ?>">
								</div>
							  </div>
							    <div class="control-group">
								<label class="control-label" for="focusedInput">Total Copies</label>
								<div class="controls">
								  <input class="disabled" id="focusedInput" disabled="" type="text" value="<?php echo $tbooks->total; ?>">
								</div>
							  </div>
							   <div class="control-group">
								<label class="control-label" for="focusedInput">Available Copies</label>
								<div class="controls">
								  <input class="disabled" id="focusedInput" disabled="" type="text" value="<?php echo (int)$tbooks->total-(int)$available->available; ?>">
								</div>
							  </div>
						
							    <div class="control-group">
							  <label class="control-label" for="date01">Issued Date</label>
							  <div class="controls">
								<input type="text" class="datepicker" disabled="" name="issuedate" id="date01" required="required" value="<?php echo JArrayHelper::indianDate1($this->issue->issuedate); ?>">
							  </div>
							</div>
							<div class="control-group">
							  <label class="control-label" for="date02">Issued due Date</label>
							  <div class="controls">
								<input type="text" class="datepicker" disabled="" name="duedate" id="date02" required="required"  value="<?php echo  JArrayHelper::indianDate1($this->issue->duedate); ?>">
							  </div>
							</div>
								<?php if($this->status==2)
							{
								?>
							  <div class="control-group">
							  <label class="control-label" for="date01">Renewal Date</label>
							  <div class="controls">
								<input type="text" class="datepicker" disabled="" name="renewaldate" id="date01" required="required" value="<?php echo JArrayHelper::indianDate1($this->renewed->renewaldate); ?>">
							  </div>
							</div>
							<div class="control-group">
							  <label class="control-label" for="date02">Renewal due Date</label>
							  <div class="controls">
								<input type="text" class="datepicker" disabled="" name="renewalduedate" id="date02" required="required"  value="<?php echo  JArrayHelper::indianDate1($this->renewed->duedate); ?>">
							  </div>
							</div>
							  <?php }
							  ?>
							
							</fieldset>
					</div>
				</div><!--/span-->
	
								<div class="box span5">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-edit"></i> Student Details</h2>
						<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
						</div>
					</div>
					<div class="box-content">
							<fieldset>

							    <div class="control-group">
								<label class="control-label" for="focusedInput">Register No</label>
								<div class="controls">
								  <input class="disabled" id="focusedInput" name="regno" disabled="" type="text" value="<?php echo $this->student->registerno; ?>">
								</div>
							  </div>
							  <?php if($this->student)
							  { ?>
				             <div class="control-group">
								<label class="control-label" for="focusedInput">Name</label>
								<div class="controls">
								  <input class="disabled" id="focusedInput" disabled="" type="text" value="<?php echo $this->student->firstname.' '.$this->student->middlename; ?>">
								</div>
							  </div>
							   <div class="control-group">
								<label class="control-label" for="focusedInput">Gender</label>
								<div class="controls">
								  <input class="disabled" id="focusedInput" disabled="" type="text" value="<?php echo $this->student->gender; ?>">
								</div>
							  </div>
							   <div class="control-group">
								   <?php
								   $model->getStudentClass($this->student->id,$studentclass);
								   ?>
								<label class="control-label" for="focusedInput">Class</label>
								<div class="controls">
								  <input class="disabled" id="focusedInput" disabled="" type="text" value="<?php echo $studentclass->code; ?>">
								</div>
							  </div>
							   <div class="control-group">
								<label class="control-label" for="focusedInput">Books Hold</label>
								<div class="controls">
								  <input class="disabled" id="focusedInput" disabled="" type="text" value="<?php echo $this->bookshold; ?>">
								</div>
							  </div>
							  <br>
							  <br>
							  
							  	<div class="control-group">
							  <label class="control-label" for="date03">Return Date</label>
							  <div class="controls">
								<input type="text" class="datepicker"  name="returndate" id="date03" required="required"  value="">
							  </div>
							</div>
							  
							  <?php } ?>
							</fieldset>
					</div>
				</div><!--/span-->


			</div><!--/row-->
					

				<div class="form-actions">
					<div class="span12" align="right">
							  <button type="submit" name="save" value="save" class="btn btn-primary">Return Book</button>
							  <button type="reset" class="btn">Cancel</button>
				   </div>
				</div>
							<input type="hidden" name="option" value="<?php echo JRequest::getVar('option'); ?>" />
							<input type="hidden" id="borrowid" name="borrowid" value="<?php echo $this->borrowid; ?>" />
							<input type="hidden" id="status" name="status" value="<?php echo $this->status; ?>" />
							<input type="hidden" id="bookno" name="bookno" value="<?php echo $this->book->bookno; ?>" />
							<input type="hidden" id="view" name="view" value="circulation" />
							<input type="hidden" id="controller" name="controller" value="circulation" />
							<input type="hidden" name="Itemid" id="Itemid" value="<?php echo $Itemid; ?>" />
							<input type="hidden" name="task" id="task" value="save" />
							<input type="hidden" name="layout" id="layout" value="returnbook" />	
						</form>
				
			<?php
			}
				?>	
					
				</div><!--/span-->
			
			</div><!--/row-->
			

