<script type="text/javascript">
    function validateEmailaddress() {
    var emailText = document.getElementById('staffemail').value;
    var pattern = /^[a-zA-Z0-9\-_]+(\.[a-zA-Z0-9\-_]+)*@[a-z0-9]+(\-[a-z0-9]+)*(\.[a-z0-9]+(\-[a-z0-9]+)*)*\.[a-z]{2,4}$/;
    if (pattern.test(emailText)) 
    {
        return true;
    } 
    else {
		document.getElementById('staffemail').value="";
        alert('Bad email address: ' + emailText);
        return false;
    }
}
</script>

<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');
	JHTML::script('validate.js', 'components/com_cce/js/');
	$photoDir = JURI::base() . 'components/com_cce/staffphoto/';
	$Itemid = JRequest::getVar('Itemid');

	$iconsDir1 = JURI::base() . 'components/com_cce/images';

   	$model = & $this->getModel('cce');
	$photoDir = JURI::base() . 'components/com_cce/staffphoto/';
	$loaderDir = JURI::base() . 'components/com_cce/loader/';

   	$dashboardItemid = $model->getMenuItemid('manageschool','Dash Board');
   	if($dashboardItemid) ;
   	else{
        	$dashboardItemid = $model->getMenuItemid('topmenu','Manage School');
   	}
	$masterItemid = $model->getMenuItemid('master','Staff Details');
        if($masterItemid) ;
        else{
                $masterItemid = $model->getMenuItemid('topmenu','Manage School');
        }

   	$dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
   	$modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=staff&Itemid='.$masterItemid);
   	$emplink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=staffs&view=staffs&task=display&Itemid='.$masterItemid);

?>
<script type="text/javascript">
    function imageURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#preview_img').attr('src', e.target.result)
                 .width('138px')
                 .height('140px');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    
}
</script>

<form action="index.php" class="form-horizontal" id="imageform" enctype="multipart/form-data" method="POST" name="addform" id="addform" onSubmit="return checkform()">
<div class="row-fluid sortable">
<div class="box span6">
<div class="box-header well" data-original-title>
  <h2><i class="icon-th"></i><b> Staff Details</b></h2>
  <div class="box-icon"> <a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a> <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a> </div>
</div>
<div class="box-content">
<fieldset>
<div class="control-group">
  <label class="control-label" for="focusedInput">Honorific Prefix<span class="mandatory">*</span></label>
  <div class="controls">
    <select id="hprefix"  data-rel="chosen" name="hprefix">
      <option value="">Select</option>
      <?php
									$prefixes = array('Mr.','Mrs.','Miss.','Fr.','Sr.','Shree');
									foreach($prefixes as $hprefix) :
										echo "<option value=\"".$hprefix."\" ".($hprefix== $this->rec->hprefix ? "selected=\"yes\"" : "").">".$hprefix."</option>";
									endforeach;
        								?>
    </select>
  </div>
</div>
<div class="control-group">
  <label class="control-label" for="focusedInput">Staff Code<span class="mandatory">*</span></label>
  <div class="controls">
    <input class="focused" id="focusedInput" type="text"  required="required" name="staffcode" value="<?php echo $this->rec->staffcode; ?>" />
  </div>
</div>
<div class="control-group">
  <label class="control-label" for="focusedInput">First Name<span class="mandatory">*</span></label>
  <div class="controls">
    <input class="focused" id="focusedInput" type="text" required="required" name="firstname" value="<?php echo $this->rec->firstname; ?>" />
  </div>
</div>
<div class="control-group">
  <label class="control-label" for="focusedInput">Middle Name</label>
  <div class="controls">
    <input class="focused" id="focusedInput" type="text" name="middlename" value="<?php echo $this->rec->middlename; ?>" />
  </div>
</div>
<div class="control-group">
  <label class="control-label" for="focusedInput">Last Name</label>
  <div class="controls">
    <input class="focused" id="focusedInput" type="text" name="lastname" value="<?php echo $this->rec->lastname; ?>" />
  </div>
</div>
<div class="control-group">
  <label class="control-label">Date of Joining</label>
  <div class="controls">
    <input type="text" class="datepicker" style="display:block;" id="doj"  onChange="compareDate();" name="doj" value="<?php echo JArrayHelper::indianDate($this->rec->doj); ?>">
  </div>
</div>
<div class="control-group">
  <label class="control-label" for="date05">Department</label>
  <div class="controls">
    <select id="department"  data-rel="chosen" name="department">
      <option value="">Select</option>
      <?php
                               
									foreach($this->departments as $department) :
										echo "<option value=\"".$department->id."\" ".($department->id == $this->rec->department ? "selected=\"yes\"" : "").">".$department->departmentname."</option>";
									endforeach;
    						    ?>
    </select>
  </div>
</div>

<div class="control-group">
  <label class="control-label" for="selectError3">Category</label>
  <div class="controls">
    <select id="category"  data-rel="chosen" name="category">
      <option value="">Select</option>

      <?php   

									foreach($this->categories as $category) :
										echo "<option value=\"".$category->id."\" ".($category->id== $this->rec->category ? "selected=\"yes\"" : "").">".$category->categoryname."</option>";
									endforeach;
      								  ?>
    </select>
  </div>
</div>
<div class="control-group">
  <label class="control-label" for="selectError3">Position</label>
  <div class="controls">
    <select id="position"  data-rel="chosen" name="position">
      <option value="">Select</option>
      <?php
										foreach($this->positions as $position) :
										echo "<option value=\"".$position->id."\" ".($position->id== $this->rec->position ? "selected=\"yes\"" : "").">".$position->positionname."</option>";
									endforeach;
      								  ?>
    </select>
  </div>
</div>
<div class="control-group">
  <label class="control-label" for="focusedInput">Grade</label>
  <div class="controls">
    <select id="grade"  data-rel="chosen" name="grade">
      <option value="">Select</option>
      <?php

									foreach($this->grades as $grade) :
										echo "<option value=\"".$grade->id."\" ".($grade->id== $this->rec->gradeid ? "selected=\"yes\"" : "").">".$grade->gradename."</option>";
									endforeach;
      						  ?>
    </select>
  </div>
</div>
<div class="control-group">
  <label class="control-label" for="focusedInput">Job Title</label>
  <div class="controls">
    <input class="focused" id="focusedInput" type="text" name="jobtitle" value="<?php echo $this->rec->jobtitle; ?>" />
  </div>
</div>
<div class="control-group">
  <label class="control-label" for="focusedInput">Qualification</label>
  <div class="controls">
    <input class="focused" id="focusedInput" type="text" name="qualification" value="<?php echo $this->rec->qualification; ?>" />
  </div>
</div>
<div class="control-group">
  <label class="control-label" for="selectError">Experience Info</label>
  <div class="controls">
    <textarea  name="experienceinfo" cols="45" rows="5"><?php echo $this->rec->experienceinfo; ?></textarea>
  </div>
</div>
<div class="control-group">
  <label class="control-label" for="focusedInput">Total Experience</label>
  <div class="controls">
    <input class="focused" id="focusedInput" type="text" name="totalexperience" value="<?php echo $this->rec->totalexperience; ?>" />
  </div>
</div>
<div class="control-group">
  <label class="control-label" for="selectError">Status</label>
  </label>
  <div class="controls">
    <select id="selectError4" data-rel="chosen" id="status" name="status">
    <option value="">Select</option>
    <option value="Active" <?php if($this->rec->status=="Active") echo 'selected="selected"'; ?>>Active</option>
    <option value="Inactive" <?php if($this->rec->status=="Inactive") echo 'selected="selected"'; ?>>Inactive</option>
    </select>
  </div>
</div>
<!--Staff photo-->
<div class="box span11">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-th"></i> Staff's Photo</h2>
						<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
						</div>
					</div>
					<div class="box-content">
                  	<div class="row-fluid">
						<center>
							<?php
								$filename=$model->getsiglestaffphoto($this->rec->id,$file);
						        if($file->image_name)
						        {
					     		?>
								<img src="<?php echo $photoDir.$file->scode.'.'.$file->extention; ?>" id="preview_img" alt="photo" style="width: 150px; height: 130px; border: 1px solid #DFE3EA;border-radius:5px;" />
							<?php
								}else{ ?>
								<img src="<?php echo $photoDir.'no-image.gif'; ?>" id="preview_img" alt="photo" style="width: 150px; height: 130px;border-radius:5px; border: 1px solid #ECE5D7;" />
								<?php } ?>
				           <br>
				           <br>
						   <div id='imageloadstatus' style='display:none'><img src="<?php echo $loaderDir.'loader.gif'; ?>" alt="Uploading...."/></div>
							<div id='imageloadbutton'>
						Please Select an Image <br><input type="file" name="photos[]" class="file" id="photoimg" multiple="true" onchange="imageURL(this)" />
							</div>
						</center>
                    </div>                   
                  </div>
                  
				</div><!--/span-->


</div>

</div>
<!--/span--> 

<!-- personal details-->

<div class="box span6">
<div class="box-header well" data-original-title>
  <h2><i class="icon-th"></i><b>Personal Details</b></h2>
  <div class="box-icon"> <a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a> <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a> </div>
</div>
<div class="box-content">
<fieldset>
<div class="control-group">
  <label class="control-label" for="date05">Date of Birth<span class="mandatory">*</span></label>
  <div class="controls">
    <input type="text" class="datepicker" id="dob" onChange="compareDate();" name="dob" value="<?php echo JArrayHelper::indianDate($this->rec->dob); ?>">
  </div>
</div>
 <div class="control-group">
								<label class="control-label" for="selectError3">Gender <span class="mandatory">*</span></label>
								<div class="controls">
									<input type="radio" name="gender" id="optionsRadios1" value="Male" <?php echo ($this->rec->gender== 'Male') ?  "checked" : "" ;  ?>>
									Male
									<input type="radio" name="gender" id="optionsRadios2" value="Female" <?php echo ($this->rec->gender == 'Female') ?  "checked" : "" ;  ?>>
									Female
									
				</div>
	  </div>
<div class="control-group">
  <label class="control-label" for="selectError3">Marital Status</label>
  <div class="controls">
    <select id="maritalstatus" data-rel="chosen" name="maritalstatus">
      <option value="">Select</option>
      <option value="Single" <?php if($this->rec->maritalstatus=="Single") echo 'selected="selected"'; ?>>Single</option>
      <option value="Married" <?php if($this->rec->maritalstatus=="Married") echo 'selected="selected"'; ?>>Married</option>
      <option value="Divorced" <?php if($this->rec->maritalstatus=="Divorced") echo 'selected="selected"'; ?>>Divorced</option>
    </select>
  </div>
</div>
<div class="control-group">
  <label class="control-label" for="focusedInput">Father Name</label>
  <div class="controls">
    <input class="focused" id="focusedInput" type="text" name="fathername" value="<?php echo $this->rec->fathername; ?>" />
  </div>
</div>
<div class="control-group">
  <label class="control-label" for="focusedInput">Mother Name</label>
  <div class="controls">
    <input class="focused" id="focusedInput" type="text" name="fathername" value="<?php echo $this->rec->mothername; ?>" />
  </div>
</div>
<div class="control-group">
  <label class="control-label" for="selectError3">Blood Group</label>
  <div class="controls">
    <select id="selectError5" data-rel="chosen" name="bloodgroup">
      <option value="">Select</option>
      <option value="A+" <?php if($this->rec->bloodgroup=="A+") echo 'selected="selected"'; ?>>A+</option>
      <option value="A-" <?php if($this->rec->bloodgroup=="A-") echo 'selected="selected"'; ?>>A-</option>
      <option value="B+" <?php if($this->rec->bloodgroup=="B+") echo 'selected="selected"'; ?>>B+</option>
      <option value="B-" <?php if($this->rec->bloodgroup=="B-") echo 'selected="selected"'; ?>>B-</option>
      <option value="O+" <?php if($this->rec->bloodgroup=="O+") echo 'selected="selected"'; ?>>O+</option>
      <option value="O-" <?php if($this->rec->bloodgroup=="O-") echo 'selected="selected"'; ?>>O-</option>
      <option value="AB+" <?php if($this->rec->bloodgroup=="AB+") echo 'selected="selected"'; ?>>AB+</option>
      <option value="AB-" <?php if($this->rec->bloodgroup=="AB-") echo 'selected="selected"'; ?>>AB-</option>
    </select>
  </div>
</div>
  <div class="control-group">
								<label class="control-label" for="selectError">Nationality</label>
								<div class="controls">
								    <select id="selectError1" data-rel="chosen" name="nationality">
									 <option value="">Select</option>
									<?php
									foreach($this->countries as $country) :
										echo "<option value=\"".$country->id."\" ".($country->id == $this->rec->nationality ? "selected=\"yes\"" : "").">".$country->countryname."</option>";
									endforeach;
									?>
								</select>
								</div>
							  </div>

</div>
</div>
<!--/span-->

<!-- Contact Details-->


<div class="box span6">
<div class="box-header well" data-original-title>
  <h2><i class="icon-th"></i> <b>Contact Details</b></h2>
  <div class="box-icon"> <a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a> <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a> </div>
</div>
<div class="box-content">
<fieldset><div class="control-group">
		 			 <label class="control-label" for="fileInput">Address 1</label>
							  <div class="controls">
								<textarea name="addressline1"><?php echo $this->rec->addressline1;  ?></textarea>
							  </div>
						</div> 
							<div class="control-group">
							  <label class="control-label" for="fileInput">Address 2</label>
							  <div class="controls">
								<textarea name="addressline2"><?php echo $this->rec->addressline2;  ?></textarea>
							  </div>
						</div> 
                        
                        <div class="control-group">
								<label class="control-label" for="selectError">Country</label>
								<div class="controls">
								    <select id="selectError6" data-rel="chosen" name="country">
									  <option value="">Select</option>
									<?php
									foreach($this->countries as $country) :
										echo "<option value=\"".$country->id."\" ".($country->id == $this->rec->country ? "selected=\"yes\"" : "").">".$country->countryname."</option>";
									endforeach;
									?>
								</select>
								</div>
							  </div>
						<div class="control-group">
								<label class="control-label" for="selectError">State</label></label>
								<div class="controls">
								  <select id="selectError8" data-rel="chosen" name="state">	
									  <option value="">Select</option>
									<option value='Andaman and Nicobar Islands' <?php if($this->rec->state=="Andaman and Nicobar Islands") echo 'selected="selected"'; ?>>Andaman and Nicobar Islands</option>
									<option value='Andhra Pradesh' <?php if($this->rec->state=="Andhra Pradesh") echo 'selected="selected"'; ?>>Andhra Pradesh</option>
									<option value='Arunachal Pradesh' <?php if($this->rec->state=="Arunachal Pradesh") echo 'selected="selected"'; ?>>Arunachal Pradesh</option>
									<option value='Assam' <?php if($this->rec->state=="Assam") echo 'selected="selected"'; ?>>Assam</option>
									<option value='Bihar' <?php if($this->rec->state=="Bihar") echo 'selected="selected"'; ?>>Bihar</option>
									<option value='Chandigarh' <?php if($this->rec->state=="Chandigarh") echo 'selected="selected"'; ?>>Chandigarh</option>
									<option value='Chhattisgarh' <?php if($this->rec->state=="Chhattisgarh") echo 'selected="selected"'; ?>>Chhattisgarh</option>
									<option value='Dadra and Nagar Haveli' <?php if($this->rec->state=="Dadra and Nagar Haveli") echo 'selected="selected"'; ?>>Dadra and Nagar Haveli</option>
									<option value='Daman and Diu' <?php if($this->rec->state=="Daman and Diu") echo 'selected="selected"'; ?>>Daman and Diu</option>
									<option value='Delhi' <?php if($this->rec->state=="Delhi") echo 'selected="selected"'; ?>>Delhi</option>
									<option value='Goa' <?php if($this->rec->state=="Goa") echo 'selected="selected"'; ?>>Goa</option>
									<option value='Gujarat' <?php if($this->rec->state=="Gujarat") echo 'selected="selected"'; ?>>Gujarat</option>
									<option value='Haryana' <?php if($this->rec->state=="Haryana") echo 'selected="selected"'; ?>>Haryana</option>
									<option value='Himachal Pradesh' <?php if($this->rec->state=="Himachal Pradesh") echo 'selected="selected"'; ?>>Himachal Pradesh</option>
									<option value='Jammu and Kashmir' <?php if($this->rec->state=="Jammu and Kashmir") echo 'selected="selected"'; ?>>Jammu and Kashmir</option>
									<option value='Jharkhand' <?php if($this->rec->state=="Jharkhand") echo 'selected="selected"'; ?>>Jharkhand</option>
									<option value='Karnataka' <?php if($this->rec->state=="Karnataka") echo 'selected="selected"'; ?>>Karnataka</option>
									<option value='Kerala' <?php if($this->rec->state=="Kerala") echo 'selected="selected"'; ?>>Kerala</option>
									<option value='Lakshadweep' <?php if($this->rec->state=="Lakshadweep") echo 'selected="selected"'; ?>>Lakshadweep</option>
									<option value='Madhya Pradesh' <?php if($this->rec->state=="Madhya Pradesh") echo 'selected="selected"'; ?>>Madhya Pradesh</option>
									<option value='Maharashtra' <?php if($this->rec->state=="Maharashtra") echo 'selected="selected"'; ?>>Maharashtra</option>
									<option value='Manipur' <?php if($this->rec->state=="Manipur") echo 'selected="selected"'; ?>>Manipur</option>
									<option value='Meghalaya' <?php if($this->rec->state=="Meghalaya") echo 'selected="selected"'; ?>>Meghalaya</option>
									<option value='Mizoram' <?php if($this->rec->state=="Mizoram") echo 'selected="selected"'; ?>>Mizoram</option>
									<option value='Mizoram' <?php if($this->rec->state=="Mizoram") echo 'selected="selected"'; ?>>Nagaland</option>
									<option value='Odisha' <?php if($this->rec->state=="Odisha") echo 'selected="selected"'; ?>>Odisha</option>
									<option value='Puducherry' <?php if($this->rec->state=="Puducherry") echo 'selected="selected"'; ?>>Puducherry</option>
									<option value='Punjab' <?php if($this->rec->state=="Punjab") echo 'selected="selected"'; ?>>Punjab</option>
									<option value='Rajasthan' <?php if($this->rec->state=="Rajasthan") echo 'selected="selected"'; ?>>Rajasthan</option>
									<option value='Sikkim' <?php if($this->rec->state=="Sikkim") echo 'selected="selected"'; ?>>Sikkim</option>
									<option value='Tamil Nadu' <?php if($this->rec->state=="Tamil Nadu") echo 'selected="selected"'; ?>>Tamil Nadu</option>
									<option value='Tripura' <?php if($this->rec->state=="Tripura") echo 'selected="selected"'; ?>>Tripura</option>
									<option value='Uttar Pradesh' <?php if($this->rec->state=="Uttar Pradesh") echo 'selected="selected"'; ?>>Uttar Pradesh</option>
									<option value='Uttarakhand' <?php if($this->rec->state=="Uttarakhand") echo 'selected="selected"'; ?>>Uttarakhand</option>
									<option value='West Bengal' <?php if($this->rec->state=="West Bengal") echo 'selected="selected"'; ?>>West Bengal</option>
								 </select>
								</div>
							  </div>
					            <div class="control-group">
								<label class="control-label" for="focusedInput">City</label>
								<div class="controls">
								  <input class="focused" id="focusedInput" type="text" name="city" value="<?php echo $this->rec->city; ?>" />
								</div>
							  </div>
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Pin Code</label>
								<div class="controls">
								  <input class="focused" id="pincode" type="text" onChange="validatePinCode();" name="pincode" value="<?php echo $this->rec->pincode; ?>" />
								</div>
							  </div>
                              
                               <div class="control-group">
								<label class="control-label" for="focusedInput">Phone</label>
								<div class="controls">
								  <input class="focused" id="focusedInput" type="text" name="phone" value="<?php echo $this->rec->phone; ?>" />
								</div>
							  </div>
							   <div class="control-group">
								<label class="control-label" for="focusedInput">Mobile<span class="mandatory">*</span></label>
								<div class="controls">
								  <input class="focused" id="focusedInput" type="text" required="required" name="mobile" value="<?php echo $this->rec->mobile; ?>" />
								</div>
							  </div>  
							    <div class="control-group">
								<label class="control-label" for="email">Email</label>
								<div class="controls">
								  <div class="input-prepend">
									<span class="add-on">@</span><input required="required" onChange="validateEmailaddress();" size="16" name="email" id="staffemail"  type="text" value="<?php echo $this->rec->email; ?>">
								  </div>
								  <p class="help-block">example@gmail.com</p>
								</div>
							  </div>
                        
                        
                        
</fieldset>
</div>
</div>
<!--/span-->



</div><!--/row-->
			
			  
<div class="form-actions">
<button type="submit" class="btn btn-primary" name="submit">Save</button>
</div>

<input type="hidden" name="option" value="<?php echo JRequest::getVar('option'); ?>" />
<input type="hidden" id="id" name="id" value="<?php echo $this->rec->id; ?>" />
<input type="hidden" id="view" name="view" value="addstaff" />
<input type="hidden" id="controller" name="controller" value="staffs" />
<input type="hidden" id="Itemid" name="Itemid" value="<?php echo $Itemid; ?>" />
<input type="hidden" name="task" id="task" value="save" />
</form>



