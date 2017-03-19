
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
   	$studentBirthDays=$model->getallStudent($getall);
   	$dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
   	$library= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=library&Itemid='.$masterItemid);
 	$issuebook= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=library&view=library&task=display&layout=circulation&Itemid='.$masterItemid);

  	$aylink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=academicyears&view=academicyears&task=display&Itemid='.$ayItemid);
	$totalbook = $model->counttotalbooks($this->book->isbn,$tbooks);
	$av = $model->countavailablebooks($this->book->isbn,$available);

?>

<table width="100%" cellpadding="10">
        <tr style="border:none;">
                <td style="border:none;" align="right">
  <div style="float:left;">
           <img src="<?php echo $library1.'/issuebook.png'; ?>" alt="" style="width: 64px; height: 64px;" />
        </div>
        <div style="float:left;">
                <h2></h2>
                <h2></h2>
                <h2></h2>
                <h1 class="item-page-title"> Issue Book </h1>
        </div>

                       <div style="float:right;"> <a href="<?php echo $dashboardlink; ?>"><img src="<?php echo $iconsDir1.'/1dashboard.png'; ?>" alt="Dash Board" style="width: 28px; height: 28px;" /></a><br />
			</div>
			<div style="float:right; width:10px;"> &nbsp;</div>
			<div style="float:right;">
                        <a href="<?php echo $library; ?>"><img src="<?php echo $iconsDir1.'/1library.png'; ?>" alt="Master" style="width: 30px; height: 30px;" /></a><br />
			</div>
			<div style="float:right; width:10px;"> &nbsp;</div>
			<div style="float:right;">
                        <a href="<?php echo $issuebook; ?>"><img src="<?php echo $library1.'/issuebook.png'; ?>" alt="Master" style="width: 28px; height: 28px;" /></a><br />
			</div>
			
                </td>
        </tr>
</table>
				
			<div class="row-fluid sortable">
				<div class="box">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-edit"></i> <strong>Issue Book</strong></h2>
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
							<input type="hidden" name="layout" id="layout" value="issuebook" />	
													
						  </form>
					
						<table class="table table-striped table-bordered">
						  <thead>
							  <tr>
								  <th>Book No</th>
								   <th>Title</th>
									<th>ISBN Code</th>
									<th>Author</th>
									<th>Edition</th>
									<th>Total Copies</th>
									<th>Available Copies</th>
							  </tr>
						  </thead>   
						  <tbody>
							  <tr>
						<?php
						if($this->book)
						{
						    $link = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=circulation&controller=circulation&layout=issuestudent&task=view&bookid='.$this->book->id);
							$st = $model->getbookstatusbyid($this->book->id,$bookstatus);
							echo $bookstatus;
						   $ava_copies=(int)$tbooks->total-(int)$available->available;
							 echo '<td>'.$this->book->bookno.'</td>';
							 echo '<td>'.$this->book->title.'</td>';
							 echo '<td>'.$this->book->isbn.'</td>';
							 echo '<td>'.$this->book->author.'</td>';
							 echo '<td>'.$this->book->edition.'</td>';
							 echo '<td><span class="label label-success">'.$tbooks->total.'</span></td>'; 						
							 if($ava_copies > 0) {
								 echo '<td><span class="label label-warning">'.$ava_copies.'</span></td>'; 
							 }
							 else {
						  	 echo '<td><span class="label label-important">NA</span></td>'; 						 
							 }
							 
						 }
						?>
						</tr>	  
						</tbody>
						</table>
						<br>
						<?php if($this->book) {?>
						<?php if($ava_copies > 0) {?>
							<form action="index.php" class="form-horizontal" method="POST" name="addform" id="addform" onSubmit="return stest()">
					
							<fieldset>
								<div class="span3"></div>
								<div class="span5">
									<br>
								<div class="control-group">
								<label class="control-label" for="appendedInputButton">Roll Number</label>
								<div class="controls">
								  <div class="input-append">
									<input id="appendedInputButton" size="16" name="rollno" type="text" value="<?php echo $this->student->registerno; ?>"><button class="btn" type="submit" value="Go" name="Go">Go!</button>
								  </div>
								</div>
							  </div>
							  <div class="span3"></div>
						
				
							</fieldset>
							<input type="hidden" name="option" value="<?php echo JRequest::getVar('option'); ?>" />
							<input type="hidden" id="bookid" name="bookid" value="<?php echo $this->book->id;  ?>" />
							<input type="hidden" id="view" name="view" value="circulation" />
							<input type="hidden" id="controller" name="controller" value="circulation" />
							<input type="hidden" name="Itemid" id="Itemid" value="<?php echo $Itemid; ?>" />
							<input type="hidden" name="task" id="task" value="searchstudent" />
							<input type="hidden" name="layout" id="layout" value="issuebook" />	
													
						  </form>
						  						<table class="table table-striped table-bordered">
						  <thead>
							  <tr>
								  <th>Name</th>
								   <th>Gender</th>
									<th>Class</th>
									<th>Books Hold</th>
									<th>Fine</th>
							  </tr>
						  </thead>   
						  <tbody>
							  <tr>
						<?php
						if($this->student)
						{
						    $link = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=circulation&controller=circulation&layout=issuestudent&task=view&bookid='.$this->book->id);
							$model->getCourse($this->student->joinedclassid,$class);
						   $ava_copies=(int)$tbooks->total-(int)$available->available;
							 echo '<td>'.$this->student->firstname.'</td>';
							 echo '<td>'.$this->student->gender.'</td>';
							 echo '<td>'.$class->code.'</td>';
							 if($this->bookshold > 0) {
					    		 echo '<td><span class="label label-success">'.$this->bookshold.'</span></td>'; 						
							 }
							 else {
						  	 echo '<td><span class="label label-important">No Books</span></td>'; 						 
							 }
							 	 echo '<td>'.$this->bookshold.'</td>';
						 }
						?>
						</tr>	  
						</tbody>
						</table>
						<?php if($this->student) {?>
					<form action="index.php" class="form-horizontal" method="POST" name="addform" id="addform" onSubmit="return stest()">
				
							<div class="control-group">
							  <label class="control-label" for="date01">Issue Date<span class="mandatory">*</span></label>
							  <div class="controls">
								<input type="text" class="datepicker"  required="required" id="date01" name="issuedate" value="<?php echo JArrayHelper::indianDate($this->rec->issuedate); ?>">
							  </div>
							</div>
							<div class="control-group">
							  <label class="control-label" for="date01">Return Date<span class="mandatory">*</span></label>
							  <div class="controls">
								<input type="text" class="datepicker" required="required" id="date02" name="duedate" value="<?php echo  JArrayHelper::indianDate($this->rec->duedate); ?>">
							  </div>
							</div>
						  	<div class="form-actions" align="right">
							  <button type="submit" class="btn btn-primary" name="Issue" value="Issue"><span class="icon-book icon-white"></span> Issue</button>
							</div>
							<input type="hidden" name="option" value="<?php echo JRequest::getVar('option'); ?>" />
							<input type="hidden" id="bookid" name="bookid" value="<?php echo $this->book->id;  ?>" />
							<input type="hidden" id="studentid" name="studentid" value="<?php echo $this->student->id;  ?>" />
							<input type="hidden" id="bookno" name="bookno" value="<?php echo $this->book->bookno;  ?>" />
							<input type="hidden" id="regno" name="regno" value="<?php echo $this->student->registerno;  ?>" />
							<input type="hidden" id="view" name="view" value="circulation" />
							<input type="hidden" id="controller" name="controller" value="circulation" />
							<input type="hidden" name="Itemid" id="Itemid" value="<?php echo $Itemid; ?>" />
							<input type="hidden" name="task" id="task" value="save" />
							<input type="hidden" name="layout" id="layout" value="issuebook" />	
													
						  </form>
						<?php 
							}						
						}else {
							  	 echo '<div align="center"><span class="label label-important">Not in Stock</span></div>'; 	
							  }
							}
							?>
						
						
					</div>	  <!--/box-->
				</div><!--/span-->
			</div><!--/row-->
