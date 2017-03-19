<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';

        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	$Itemid  = JRequest::getVar('Itemid');
    $studentid  = JRequest::getVar('id');
	$iconsDir1 = JURI::base() . 'components/com_cce/images';
	$photoDir = JURI::base() . 'components/com_cce/studentsphoto/';
	$loaderDir = JURI::base() . 'components/com_cce/loader/';

   	$model = & $this->getModel('cce');
	$model->getStudent($studentid,$stu_rec);
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

   	$studentsItemid = $model->getMenuItemid('master','Students Details');
   	if($studentsItemid) ;
   	else{
        	$studentsItemid = $model->getMenuItemid('manageschool','Dash Board');
   	}
   	$dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
   	$modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=students&Itemid='.$masterItemid);

  	$studentslink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=students&view=students&task=display&courseid='.JRequest::getVar('courseid').'&Itemid='.JRequest::getVar('Itemid'));
   $pdflink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=studentprofile&view=studentprofile&layout=printprofile&regno='.$stu_rec->registerno.'&id='.$stu_rec->id.'&Itemid='.$masterItemid.'&format=pdf&tmpl=component');
   
	
?>
<?php
        $isModal = JRequest::getVar( 'print' ) == 1; // 'print=1' will only be present in the url of the modal window, not in the presentation of the page
        if( $isModal) {
                $href = '"#" onclick="window.print(); return false;"';
        } else {
                $href = 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no';
                $href = "window.open(this.href,'win2','".$href."'); return false;";
                $href = '"index.php?option=com_cce&view=studentprofile&controller=studentprofile&layout=printprofile&id='.$studentid.'&tmpl=component&print=1" '.$href;
        }
?>

<table width="100%" cellpadding="10">
        <tr style="border:none;">
                <td style="border:none;" align="left">
        <div style="float:left;">
           <img src="<?php echo $iconsDir.'/addstudent.png'; ?>" alt="" style="width: 64px; height: 64px;" />
        </div>
        <div style="float:left">
                <div>&nbsp;</div>
                <h1 class="item-page-title">Add/Edit Student Details</h1>
        </div>
                       <div style="float:right;"> <a href="<?php echo $dashboardlink; ?>"><img src="<?php echo $iconsDir1.'/1dashboard.png'; ?>" alt="Dash Board" style="width: 32px; height: 32px;" /></a><br />
			</div>
			<div style="float:right; width:10px;"> &nbsp;</div>
			<div style="float:right;">
                        <a href="<?php echo $modulelink; ?>"><img src="<?php echo $iconsDir1.'/1students.png'; ?>" alt="Students" style="width: 32px; height: 32px;" /></a><br />
			</div>
			<div style="float:right; width:10px;"> &nbsp;</div>
			<div style="float:right;">
                        <a href="<?php echo $studentslink; ?>"><img src="<?php echo $iconsDir.'/students.png'; ?>" alt="Students" style="width: 32px; height: 32px;" /></a><br />
			</div>
                </td>
        </tr>
</table>
<div align="right">
<a href="<?php echo $pdflink; ?>"><span title="Pdf" class="icon32 icon-green icon-pdf"></span></a>
<a href=<?php echo $href; ?> ><span title="Print" class="icon32 icon-green icon-print"></span></a>
</div>

<br>
<div class="alert alert-block">
<h3>Personal Details</h3>							
</div>
<form action="index.php" class="form-horizontal" id="imageform" enctype="multipart/form-data" method="POST" name="addform" id="addform" onSubmit="return checkform()">

			<div class="row-fluid sortable">
				<div class="span2">
					<?php
							$filename=$model->getsiglestudentphoto($stu_rec->id,$file);
							if($file->imagename)
							{
							?>
							<img src="<?php echo  $photoDir.$file->imagename; ?>" id="preview_img" alt="photo" style="width: 120px; border: 1px solid #DFE3EA;" />
						<?php
							}else{ ?>
							<img src="<?php echo $photoDir.'no-image.gif'; ?>" id="preview_img" alt="photo" style="width: 120px; border: 1px solid #ECE5D7;" />
							<?php } ?>
			
					   <h2><?php echo $stu_rec->firstname.''.$stu_rec->middlename.''.$stu_rec->lastname;?></h2>
				</div>
				<div class="span10">
					<div class="row-fluid">
						<div class="span4">
							<table width="100%">
								<tr>
									<td valign="top"> Register No</td>
									<td valign="top"> <strong>:</strong></td>
									<td valign="top"><?php echo $stu_rec->registerno; ?></td>
								</tr>

								<tr>
									<td valign="top">Admission No </td>
									<td valign="top"> <strong>:</strong></td>
									<td valign="top"><?php echo $stu_rec->ano; ?></td>
								</tr>
								
								<tr>
									<td valign="top">Admission Date </td>
									<td valign="top"> <strong>:</strong></td>
									<td valign="top"><?php echo JArrayHelper::indianDate($stu_rec->adate); ?></td>
								</tr>
								<tr>
									<td valign="top">Date of Birth</td>
									<td valign="top"> <strong>:</strong></td>
									<td valign="top"><?php echo JArrayHelper::indianDate($stu_rec->dob); ?></td>
								</tr>

							</table>
						</div>
						<div class="span4"></div>
						<div class="span4"></div>
					</div>
					
					</div>
				
					
			<div class="span1"></div>
			<div class="span2">
							 
							
							 <div class="control-group">
								<label class="control-label" for="selectError3">Gender :</label>
								<div class="controls">
											<label class="stu_profile"><?php echo $stu_rec->gender; ?></label>
								</div>
							  </div>
							   <div class="control-group">
								<label class="control-label" for="selectError3">Blood Group :</label>
								<div class="controls">
											<label class="stu_profile"><?php echo $stu_rec->bloodgroup; ?></label>
	
								</div>
							  </div>
							  
							   <div class="control-group">
								<label class="control-label" for="focusedInput">Birth Place :</label>
								<div class="controls">
											<label class="stu_profile"><?php echo $stu_rec->birthplace; ?></label>
	
									</div>
							  </div>
							  
							   <div class="control-group">
								<label class="control-label" for="focusedInput">Mother Tongue :</label>
								<div class="controls">
									<label class="stu_profile"><?php echo $stu_rec->mothertongue; ?></label>
	
									</div>
							  </div>
							   
		</div>
		<div class="span1"></div>
		<div class="span2">
		 <div class="control-group">
								<label class="control-label" for="selectError">Nationality :</label>
								<div class="controls">
								   
									<?php
									$co_name=$model->getCountryName($stu_rec->nationality);
									?>
						    	<label class="stu_profile"><?php echo $co_name; ?></label>
								</div>
							  </div>
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Community/Caste :</label>
								<div class="controls">
									<label class="stu_profile"><?php echo $stu_rec->caste; ?></label>
								</div>
							  </div> 
							<div class="control-group">
								<label class="control-label" for="selectError">Religion :</label></label>
								<div class="controls">
								<label class="stu_profile"><?php echo $stu_rec->religion; ?></label>
								</div>
							  </div>
							   <div class="control-group">
								<label class="control-label" for="selectError3">Student Category :</label>
								<div class="controls">
								  
									<?php
									$cid=$model->getStudentCategory($stu_rec->categoryid,$ca_id);
									
									?>
								<label class="stu_profile"><?php echo $ca_id->categoryname; ?></label>
								</div>
							  </div>
							 
		
		</div>
							 
							  
				</div><!--/span-->

<!-- Contact Details-->
<div class="alert alert-block">
<h3>Contact Details</h3>							
</div>		
			<div class="row-fluid sortable">	
		       <div class="span3">
                       	<div class="control-group">
							  <label class="control-label" for="fileInput">Address 1 :</label>
							  <div class="controls">
								  <label class="stu_profile"><?php echo $stu_rec->addressline1; ?></label>
							
							  </div>
						</div> 
							<div class="control-group">
							  <label class="control-label" for="fileInput">Address 2 :</label>
							  <div class="controls">
								  <label class="stu_profile"><?php echo $stu_rec->addressline2; ?></label>
							  </div>
						</div>
			</div>
			<div class="span1"></div> 
			<div class="span2">
						<div class="control-group">
								<label class="control-label" for="selectError">Nationality :</label>
								<div class="controls">
								    <?php
						
									$fco_name=$model->getCountryName($stu_rec->country);
									?>
						    	<label class="stu_profile"><?php echo $fco_name; ?></label>
								</div>
							  </div>
						<div class="control-group">
								<label class="control-label" for="selectError">State :</label></label>
								<div class="controls">
								   <label class="stu_profile"><?php echo $stu_rec->state; ?></label>
								</div>
							  </div>
					            <div class="control-group">
								<label class="control-label" for="focusedInput">City :</label>
								<div class="controls">
								  <label class="stu_profile"><?php echo $stu_rec->city; ?></label>
								  </div>
							  </div>
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Pin Code :</label>
								<div class="controls">
							  <label class="stu_profile"><?php echo $stu_rec->pincode; ?></label>
									</div>
							  </div>

                 </div>
                 </div>
<!-- Contact Details-->
<div class="alert alert-block">
<h3>Parents Details</h3>							
</div>		
		
<div class="row-fluid sortable">
				<div class="span2">
                          <div class="control-group">
								<label class="control-label" for="focusedInput">Father Name :</label>
								<div class="controls">
								 <label class="stu_profile"><?php echo $stu_rec->pfathername; ?></label>
								</div>
							  </div>
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Father's Phone :</label>
								<div class="controls">
								 <label class="stu_profile"><?php echo $stu_rec->phone; ?></label>
								</div>
							  </div>
							   <div class="control-group">
								<label class="control-label" for="focusedInput">Father's Mobile :</label>
								<div class="controls">
									 <label class="stu_profile"><?php echo $stu_rec->mobile; ?></label>
									</div>
							  </div>  
							    <div class="control-group">
								<label class="control-label" for="prependedInput">Father's Email :</label>
								<div class="controls">
								
									 <label class="stu_profile"><?php echo $stu_rec->email; ?></label>
			
								</div>
							  </div>
							   <div class="control-group">
								<label class="control-label" for="focusedInput">Father's Occupation</label>
								<div class="controls">
										
									 <label class="stu_profile"><?php echo $stu_rec->focc; ?></label>
									</div>
							 </div>
			</div>
			<div class="span1"></div>
			<div class="span2">
							<div class="control-group">
								<label class="control-label" for="focusedInput">Mother Name :</label>
								<div class="controls">
										 <label class="stu_profile"><?php echo $stu_rec->mothername; ?></label>
							
									</div>
							 </div>
							<div class="control-group">
								<label class="control-label" for="focusedInput">Mother's Phone :</label>
								<div class="controls">
												 <label class="stu_profile"><?php echo $stu_rec->mphone; ?></label>
								</div>
							 </div>
							<div class="control-group">
								<label class="control-label" for="focusedInput">Mother's Mobile :</label>
								<div class="controls">
									<label class="stu_profile"><?php echo $stu_rec->mmobile; ?></label>
								</div>
							 </div>
							 <div class="control-group">
								<label class="control-label" for="focusedInput">Monther's Occupation :</label>
								<div class="controls">
									<label class="stu_profile"><?php echo $stu_rec->mocc; ?></label>
								</div>
							 </div>
				</div>
			<div class="span1"></div>
			<div class="span2">
				 <div class="control-group">
								<label class="control-label" for="focusedInput">Gardian Name :</label>
								<div class="controls">
									<label class="stu_profile"><?php echo $stu_rec->gname; ?></label>
								</div>
							  </div>
							
							<div class="control-group">
								<label class="control-label" for="focusedInput">Phone Number :</label>
								<div class="controls">
										<label class="stu_profile"><?php echo $stu_rec->gphone; ?></label>
								</div>
							 </div>
							<div class="control-group">
								<label class="control-label" for="focusedInput">Mobile Number :</label>
								<div class="controls">
										<label class="stu_profile"><?php echo $stu_rec->gmobile; ?></label>
								</div>
							 </div>
							 <div class="control-group">
								<label class="control-label" for="focusedInput">Occupation :</label>
								<div class="controls">
										<label class="stu_profile"><?php echo $stu_rec->gocc; ?></label>
								</div>
							 </div>
			</div>
             </div>                   

			  
</form>



