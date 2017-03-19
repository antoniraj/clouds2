
<?php
        defined('_JEXEC') OR DIE('Access denied..');

        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('students.js', 'components/com_cce/js/');
	JHTML::script('validate.js', 'components/com_cce/js/');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	$Itemid  = JRequest::getVar('Itemid');
    $courseid  = JRequest::getVar('courseid');
	$iconsDir1 = JURI::base() . 'components/com_cce/images';
	$photoDir = JURI::base() . 'components/com_cce/studentsphoto/';
	$loaderDir = JURI::base() . 'components/com_cce/loader/';
   	$model = & $this->getModel('cce');
   	$dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
   	$modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=students&courseid='.$courseid.'&Itemid='.$masterItemid);

  	$studentslink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=students&view=students&task=display&courseid='.JRequest::getVar('courseid').'&Itemid='.JRequest::getVar('Itemid'));

 	$app =& JFactory::getApplication();
        $pathway =& $app->getPathway();
        $pathway->addItem('Home', $dashboardlink);
        $pathway->addItem('Students',$modulelink);
        $pathway->addItem($this->crec->code,$studentslink);
	if($this->rec->id) 
        	$pathway->addItem('Edit Student');
	else
        	$pathway->addItem('Add Student');
        
        

?>

 <script>
       document.getElementById("imageform").onsubmit = function() {
          document.getElementById("loadingMessage").visibilty = "visible";
          return true;
       };
    </script>


<form action="index.php" class="form-horizontal" id="imageform" enctype="multipart/form-data" method="POST" name="addform" id="addform" onSubmit="return checkform()">

			<div class="row-fluid sortable">
				<div class="box span6">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-th"></i> Personal Details</h2>
						<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
						</div>
					</div>
					<div class="box-content">
					
						<fieldset>
							 <div class="control-group">
								<label class="control-label" for="focusedInput">Register No<span class="mandatory">*</span></label>
								<div class="controls">
								<?php if($this->rec->id) { ?>
									<input class="disabled" id="disabledInput" type="text"  value="<?php echo $this->rec->registerno; ?>" disabled="">
									<input type="hidden"  name="registerno" value="<?php echo $this->rec->registerno; ?>" />
								<?php }else { ?>
								  <input class="focused" id="focusedInput" type="text" required="required" name="registerno" value="<?php echo $this->rec->registerno; ?>" />
								<?php } ?>
								</div>
							  </div>
							   <div class="control-group">
								<label class="control-label" for="focusedInput">Admission No</label>
								<div class="controls">
								  <input class="focused" id="focusedInput" type="text"  name="ano" value="<?php echo $this->rec->ano; ?>" />
								</div>
							  </div>
							  <div class="control-group">
							  <label class="control-label" for="date01">Admission Date</label>
							  <div class="controls">
								<input type="text" class="datepicker" id="date01" name="adate" value="<?php echo JArrayHelper::indianDate($this->rec->adate); ?>">
							  </div>
							</div>
							  <div class="control-group">
							  <label class="control-label" for="date01">Admitted Class</label>
							  <div class="controls">
								  <input class="focused" id="focusedInput" type="text" required="required" name="admittedclass" value="<?php echo $this->rec->admittedclass; ?>" />
							  </div>
							</div>
							   <div class="control-group">
								<label class="control-label" for="focusedInput">First Name <span class="mandatory">*</span></label>
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
							  <label class="control-label" for="date05">Date of Birth</label>
							  <div class="controls">
								<input type="text" class="datepicker" onChange="compareDate();" id="dob" name="dob" value="<?php echo JArrayHelper::indianDate($this->rec->dob); ?>">
							  </div>
							</div>
							
							 <div class="control-group">
								<label class="control-label" for="selectError3">Gender <span class="mandatory">*</span></label>
								<div class="controls">
									<input type="radio" name="gender" id="optionsRadios1" value="Male" <?php echo ($this->rec->gender== 'Male' || $this->rec->gender=='M') ?  "checked" : "" ;  ?>>
									Male
									<input type="radio" name="gender" id="optionsRadios2" value="Female" <?php echo ($this->rec->gender == 'Female'|| $this->rec->gender='F') ?  "checked" : "" ;  ?>>
									Female
									
								</div>
							  </div>
							   <div class="control-group">
								<label class="control-label" for="selectError3">Blood Group</label>
								<div class="controls">
								 <select id="selectError5" data-rel="chosen" editable="true" name="bloodgroup">
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
								<label class="control-label" for="focusedInput">Birth Place</label>
								<div class="controls">
								  <input class="focused" id="focusedInput" type="text" name="birthplace" value="<?php echo $this->rec->birthplace; ?>" />
								</div>
							  </div>
							  
							   <div class="control-group">
								<label class="control-label" for="focusedInput">Mother Tongue</label>
								<div class="controls">
								  <input class="focused" id="focusedInput" type="text" name="mothertongue" value="<?php echo $this->rec->mothertongue; ?>" />
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
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Caste</label>
								<div class="controls">
								  <input class="focused" id="focusedInput" type="text" name="caste" value="<?php echo $this->rec->caste; ?>" />
								</div>
							  </div> 
							  <div class="control-group">
                                                                <label class="control-label" for="focusedInput">Community</label>
                                                                <div class="controls">
                                                                  <input class="focused" id="focusedInput" type="text" name="community" value="<?php echo $this->rec->community; ?>" />
                                                                </div>
                                                          </div>

							   <div class="control-group">
                                                                <label class="control-label" for="focusedInput">Student as</label>
                                                                <div class="controls">
 									<select id="selectError555555" data-rel="chosen" name="studentas">
                                                                        	<option value="">Select</option>
                                                                  		<option value="Dayscholar" <?php if($this->rec->studentas=='Dayscholar') echo 'selected="selected"'; ?>>Dayscholar</option>
                                                                  		<option value="Hostler" <?php if($this->rec->studentas=='Hostler') echo 'selected="selected"'; ?>>Hostler</option>
									</select>

                                                                </div>
                                                          </div>

							 <div class="control-group">
                                                                <label class="control-label" for="focusedInput">Medium</label>
                                                                <div class="controls">
                                                                  <input class="focused" id="focusedInput" type="text" name="medium" value="<?php echo $this->rec->medium; ?>" />
                                                                </div>
                                                          </div>
							 <div class="control-group">
                                                                <label class="control-label" for="focusedInput">First Language</label>
                                                                <div class="controls">
                                                                  <input class="focused" id="focusedInput" type="text" name="lang1" value="<?php echo $this->rec->lang1; ?>" />
                                                                </div>
                                                          </div>
							 <div class="control-group">
                                                                <label class="control-label" for="focusedInput">Second Language</label>
                                                                <div class="controls">
                                                                  <input class="focused" id="focusedInput" type="text" name="lang2" value="<?php echo $this->rec->lang2; ?>" />
                                                                </div>
                                                          </div>
							 <div class="control-group">
                                                                <label class="control-label" for="focusedInput">Third Language</label>
                                                                <div class="controls">
                                                                  <input class="focused" id="focusedInput" type="text" name="lang3" value="<?php echo $this->rec->lang3; ?>" />
                                                                </div>
                                                          </div>

							<div class="control-group">
								<label class="control-label" for="selectError">Religion</label></label>
								<div class="controls">
								  <select id="selectError2" data-rel="chosen" name="religion">	
								<?php if($this->rec->religion) { 
									echo '<option value="'.$this->rec->religion.'" selected >'.$this->rec->religion.'</option>';
								}else{
									echo '<option value="">Select</option>';
								}
								?>
								  <option value="Christianity" <?php if($this->rec->religion=="Christianity") echo 'selected="selected"'; ?>>Christianity</option>
								  <option value="Hinduism" <?php if($this->rec->religion=="Hinduism") echo 'selected="selected"'; ?>>Hinduism</option>
								  <option value="Islam" <?php if($this->rec->religion=="Islam") echo 'selected="selected"'; ?>>Islam</option>
								  <option value="Buddhism" <?php if($this->rec->religion=="Buddhism") echo 'selected="selected"'; ?>>Buddhism</option>
								  <option value="Jainism" <?php if($this->rec->bloodgroup=="Jainism") echo 'selected="selected"'; ?>>Jainism</option>
								  <option value="African Traditional & Diasporic" <?php if($this->rec->religion=="African Traditional & Diasporic") echo 'selected="selected"'; ?>>African Traditional & Diasporic</option>
								  <option value="Agnostic" <?php if($this->rec->religion=="Agnostic") echo 'selected="selected"'; ?>>Agnostic</option>
								  <option value="Atheist" <?php if($this->rec->religion=="Atheist") echo 'selected="selected"'; ?>>Atheist</option>
								  <option value="Bahai" <?php if($this->rec->religion=="Bahai") echo 'selected="selected"'; ?>>Baha'i</option>
								  <option value="Cao Dai" <?php if($this->rec->religion=="Cao Dai") echo 'selected="selected"'; ?>>Cao Dai</option>
								  <option value="Chinese traditional religion" <?php if($this->rec->religion=="Chinese traditional religion") echo 'selected="selected"'; ?>>Chinese traditional religion</option>
								  <option value="Juche" <?php if($this->rec->religion=="Juche") echo 'selected="selected"'; ?>>Juche</option>
								  <option value="Judaism" <?php if($this->rec->religion=="Judaism") echo 'selected="selected"'; ?>>Judaism</option>
								  <option value="Neo-Paganism" <?php if($this->rec->religion=="Neo-Paganism") echo 'selected="selected"'; ?>>Neo-Paganism</option>
								  <option value="Nonreligious" <?php if($this->rec->religion=="Nonreligious") echo 'selected="selected"'; ?>>Nonreligious</option>
								  <option value="Rastafarianism" <?php if($this->rec->religion=="Rastafarianism") echo 'selected="selected"'; ?>>Rastafarianism</option>
								  <option value="Secular" <?php if($this->rec->religion=="Secular") echo 'selected="selected"'; ?>>Secular</option>
								  <option value="Shinto" <?php if($this->rec->religion=="Shinto") echo 'selected="selected"'; ?>>Shinto</option>
								  <option value="Sikhism" <?php if($this->rec->religion=="Sikhism") echo 'selected="selected"'; ?>>Sikhism</option>
								  <option value="Spiritism" <?php if($this->rec->religion=="Spiritism") echo 'selected="selected"'; ?>>Spiritism</option>
								  <option value="Tenrikyo" <?php if($this->rec->religion=="Tenrikyo") echo 'selected="selected"'; ?>>Tenrikyo</option>
								  <option value="Unitarian-Universalism" <?php if($this->rec->religion=="Unitarian-Universalism") echo 'selected="selected"'; ?>>Unitarian-Universalism</option>
								  <option value="Zoroastrianism" <?php if($this->rec->religion=="Zoroastrianism") echo 'selected="selected"'; ?>>Zoroastrianism</option>
								  <option value="primal-indigenous" <?php if($this->rec->religion=="primal-indigenous") echo 'selected="selected"'; ?>>primal-indigenous</option>
								  <option value="Other" <?php if($this->rec->religion=="Other") echo 'selected="selected"'; ?>>Other</option>
								  </select>
								</div>
							  </div>
							   <div class="control-group">
								<label class="control-label" for="selectError3">Student Category <span class="mandatory">*</span></label>
								<div class="controls">
								  <select name="categoryid">
									  <option value="">Select</option>
									<?php
									foreach($this->cats as $cat) :
										echo "<option value=\"".$cat->id."\" ".($cat->id == $this->rec->categoryid ? "selected=\"yes\"" : "").">".$cat->categoryname."</option>";
									endforeach;
									?>
								</select>
								</div>
							  </div>
							 
							 <div class="control-group">
                                                                <label class="control-label" for="focusedInput">Aadhar No</label>
                                                                <div class="controls">
                                                                  <input class="focused" id="focusedInput" type="text" name="aadharno" value="<?php echo $this->rec->aadharno; ?>" />
                                                                </div>
                                                          </div>
							 <div class="control-group">
                                                                <label class="control-label" for="focusedInput">Identification Mark-1</label>
                                                                <div class="controls">
                                                                  <input class="focused" id="focusedInput" type="text" style="width:80%;" name="idmark" value="<?php echo $this->rec->identificationmark; ?>" />
                                                                </div>
                                                          </div>
							 <div class="control-group">
                                                                <label class="control-label" for="focusedInput">Identification Mark-2</label>
                                                                <div class="controls">
                                                                  <input class="focused" id="focusedInput" type="text" style="width:80%;" name="idmark2" value="<?php echo $this->rec->identificationmark2; ?>" />
                                                                </div>
                                                          </div>
							 <div class="control-group">
                                                                <label class="control-label" for="focusedInput">Mode of Transport</label>
                                                                <div class="controls">
									
								<select name="modeoftransport" style="width: 200px; float: left;" onchange="this.nextElementSibling.value=this.value">
								<?php if($this->rec->modeoftransport) { 
									echo '<option value="'.$this->rec->modeoftransport.'" selected >'.$this->rec->modeoftransport.'</option>';
								}else{
									echo '<option value="">Select</option>';
								}
								?>
								    <option>Van</option>
								    <option>Auto</option>
								    <option>Cycle</option>
								    <option>Bus</option>
								    <option>Train</option>
								    <option>School Bus</option>
								    <option>School Van</option>
								    <option>With Parents</option>
								</select>
								<input class="focused" name="modeoftransport" value="<?php echo $this->rec->modeoftransport; ?>" style="width: 180px; margin-left: -195px; margin-top: 1px; border: none; float: left;"/>

								</select>
                                                                </div>
                                                          </div>
							 <div class="control-group">
                                                                <label class="control-label" for="focusedInput">Passport No</label>
                                                                <div class="controls">
                                                                  <input class="focused" id="focusedInput" type="text" style="width:80%;" name="passportno" value="<?php echo $this->rec->passportno; ?>" />
                                                                </div>
                                                          </div>
							 <div class="control-group">
                                                                <label class="control-label" for="focusedInput">If Differently abled, Type of Disability</label>
                                                                <div class="controls">
                                                                  <input class="focused" id="focusedInput" type="text" style="width:80%;" name="disability" value="<?php echo $this->rec->disability; ?>" />
                                                                </div>
                                                          </div>
							 <div class="control-group">
                                                                <label class="control-label" for="focusedInput">If belongs to Disadvantaged Group</label>
                                                                <div class="controls">
                                                                  <input class="focused" id="focusedInput" type="text" style="width:80%;" name="disadvantagedgroup" value="<?php echo $this->rec->disadvantagedgroup; ?>" />
                                                                </div>
                                                          </div>
					</div>
				</div><!--/span-->
				
				<div class="box span6">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-th"></i> Student's Photo</h2>
						<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
						</div>
					</div>
					<div class="box-content">
                  	<div class="row-fluid">
						<center>
							<?php
//								   $deletephoto = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=addstudent&controller=students&task=redirect&layout=default&cid='.$courseid.'&sid='.$this->rec->id.'&Itemid='.$Itemid);
       
								$filename=$model->getsiglestudentphoto($this->rec->id,$file);
						        if($file->imagename)
						        {
					     		?>
								<img src="<?php echo  $photoDir.trim($file->imagename); ?>" id="preview_img" alt="photo" style="width: 150px; height: 130px; border: 1px solid #DFE3EA;border-radius:10px;" />
							<!--	<a title="Delete photo" data-rel="tooltip" href="<?php echo $deletephoto; ?>"><img src="<?php echo $iconsDir.'/delete.png'; ?>" alt="Delete Student photo" style="width: 20px; height: 20px;" /></a>  -->
	
							<?php
								}else{ ?>
								<img src="<?php echo $photoDir.'no-image.gif'; ?>" id="preview_img" alt="photo" style="width: 150px; height: 130px;border-radius:10px; border: 1px solid #ECE5D7;" />
								<?php } ?>
				           <br>
				           <br>
						   <div id='imageloadstatus' style='display:none'><img src="<?php echo $loaderDir.'loader.gif'; ?>" alt="Uploading...."/></div>
							<div id='imageloadbutton'>
						 Select an Image <br><input type="file" name="photos[]" class="file" id="photoimg"  multiple="true" onchange="imageURL(this)" />
							</div>
						</center>
                    </div>                   
                  </div>
                  
				</div><!--/span-->
		        <div class="box span6">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-th"></i> Contact Details</h2>
						<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
						</div>
					</div>
					<div class="box-content">
                  	<div class="row-fluid">
                       	<div class="control-group">
							  <label class="control-label" for="fileInput">Address Line 1</label>
							  <div class="controls">
								<input type="text" name="addressline1" style="width:80%;" value="<?php echo $this->rec->addressline1;  ?>" />
							  </div>
						</div> 
							<div class="control-group">
							  <label class="control-label" for="fileInput">Address Line 2</label>
							  <div class="controls">
								<input type="text" name="addressline2" style="width:80%;" value="<?php echo $this->rec->addressline2;  ?>" />
							  </div>
						</div> 
						<div class="control-group">
								<label class="control-label" for="selectError">Country</label>
								<div class="controls">
								    <select id="selectError6" data-rel="chosen" name="country">
									  <option value="">Select</option>
									<?php
									foreach($this->countries as $country) :
										echo "<option value=\"".$country->id."\" ".($country->id == $this->rec->nationality ? "selected=\"yes\"" : "").">".$country->countryname."</option>";
									endforeach;
									?>
								</select>
								</div>
							  </div>
						<div class="control-group">
								<label class="control-label" for="selectError">State</label></label>
								<div class="controls">
								  <select id="selectError4" data-rel="chosen" name="state">	
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
								  <input class="focused" id="pincode" onChange="validatePinCode();" type="text" name="pincode" value="<?php echo $this->rec->pincode; ?>" />
								</div>
							  </div>

				                    </div>          
                             
                          				<div class="control-group">
								<label class="control-label" for="focusedInput">Father Name</label>
								<div class="controls">
								  <input class="focused" id="focusedInput" type="text" name="fathername" value="<?php echo $this->rec->pfathername; ?>" />
								</div>
							  </div>
							  <div class="control-group">
							  <label class="control-label" for="date01">Father's Date of Birth</label>
							  <div class="controls">
								<input type="text" class="datepicker" id="date04" name="fdob" value="<?php echo JArrayHelper::indianDate($this->rec->fdob); ?>">
							  </div>
							</div>
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Father's Phone</label>
								<div class="controls">
								  <input class="focused" id="focusedInput" type="text" name="phone" value="<?php echo $this->rec->phone; ?>" />
								</div>
							  </div>
							   <div class="control-group">
								<label class="control-label" for="focusedInput">Father's Mobile<span class="mandatory">*</span></label>
								<div class="controls">
								  <input class="focused" id="focusedInput"  type="text"  name="mobile" value="<?php echo $this->rec->mobile; ?>" />
								</div>
							  </div>  
							    <div class="control-group">
								<label class="control-label" for="prependedInput">Father's Email</label>
								<div class="controls">
								  <div class="input-prepend">
									<span class="add-on">@</span><input id="prependedInput" size="16" name="email" type="text" value="<?php echo $this->rec->email; ?>">
								  </div>
								  <p class="help-block">example@gmail.com</p>
								</div>
							  </div>
							   <div class="control-group">
								<label class="control-label" for="focusedInput">Father's Occupation</label>
								<div class="controls">
								  <input class="focused" id="focusedInput" type="text" name="focc" value="<?php echo $this->rec->focc; ?>" />
								</div>
							 </div>
							<div class="control-group">
								<label class="control-label" for="focusedInput">Father's Income</label>
								<div class="controls">
								  <input class="focused" id="focusedInput" type="text" name="fincome" value="<?php echo $this->rec->fincome; ?>" />
								</div>
							 </div>
							<div class="control-group">
								<label class="control-label" for="focusedInput">Mother Name</label>
								<div class="controls">
								  <input class="focused" id="focusedInput" type="text" name="mothername" value="<?php echo $this->rec->mothername; ?>" />
								</div>
							 </div>
							  <label class="control-label" for="date01">Mother's Date of Birth</label>
							  <div class="controls">
								<input type="text" class="datepicker" id="date05" name="mdob" value="<?php echo JArrayHelper::indianDate($this->rec->mdob); ?>">
							  </div>
							</div>
							  <div class="control-group">
							<div class="control-group">
								<label class="control-label" for="focusedInput">Mother's Phone</label>
								<div class="controls">
								  <input class="focused" id="focusedInput" type="text" name="mphone" value="<?php echo $this->rec->mphone; ?>" />
								</div>
							 </div>
							<div class="control-group">
								<label class="control-label" for="focusedInput">Mother's Mobile</label>
								<div class="controls">
								  <input class="focused" id="focusedInput" type="text" name="mmobile" value="<?php echo $this->rec->mmobile; ?>" />
								</div>
							 </div>
							 <div class="control-group">
								<label class="control-label" for="focusedInput">Monther's Occupation</label>
								<div class="controls">
								  <input class="focused" id="focusedInput" type="text" name="mocc" value="<?php echo $this->rec->mocc; ?>" />
								</div>
							 </div>
							<div class="control-group">
								<label class="control-label" for="focusedInput">Mother's Income</label>
								<div class="controls">
								  <input class="focused" id="focusedInput" type="text" name="mincome" value="<?php echo $this->rec->mincome; ?>" />
								</div>
							 </div>
                         <div class="control-group">
								<label class="control-label" for="focusedInput">Gardian Name</label>
								<div class="controls">
								  <input class="focused" id="focusedInput" type="text" name="gname" value="<?php echo $this->rec->gname; ?>" />
								</div>
							  </div>
							
							<div class="control-group">
								<label class="control-label" for="focusedInput">Phone Number</label>
								<div class="controls">
								  <input class="focused" id="focusedInput" type="text" name="gphone" value="<?php echo $this->rec->gphone; ?>" />
								</div>
							 </div>
							<div class="control-group">
								<label class="control-label" for="focusedInput">Mobile Number</label>
								<div class="controls">
								  <input class="focused" id="focusedInput" type="text" name="gmobile" value="<?php echo $this->rec->gmobile; ?>" />
								</div>
							 </div>
							 <div class="control-group">
								<label class="control-label" for="focusedInput">Occupation</label>
								<div class="controls">
								  <input class="focused" id="focusedInput" type="text" name="gocc" value="<?php echo $this->rec->gocc; ?>" />
								</div>
							 </div>
                                                         <div class="control-group">
                                                                <label class="control-label" for="focusedInput">SMS To</label>
                                                                <div class="controls">
                                                                 <select id="selectError9" data-rel="chosen" name="smsto">
                                                                        <option value="F" <?php if($this->rec->smsto=="F") echo 'selected="selected"'; ?>>Father</option>
                                                                        <option value="M" <?php if($this->rec->smsto=="M") echo 'selected="selected"'; ?>>Mother</option>
                                                                        <option value="G" <?php if($this->rec->smsto=="G") echo 'selected="selected"'; ?>>Gaurdian</option>
                                                                </select>
                                                                </div>
                                                         </div>
                                                         <div class="control-group">
                                                                <label class="control-label" for="focusedInput">Emergency Contact</label>
                                                                <div class="controls">
                                                                 <select id="selectError19" data-rel="chosen" name="emergency">
                                                                        <option value="F" <?php if($this->rec->emergency=="F") echo 'selected="selected"'; ?>>Father's Mobile</option>
                                                                        <option value="M" <?php if($this->rec->emergency=="M") echo 'selected="selected"'; ?>>Mother's Mobile</option>
                                                                        <option value="G" <?php if($this->rec->emergency=="G") echo 'selected="selected"'; ?>>Gaurdian's Mobile</option>
                                                                </select>
                                                                </div>
                                                         </div>

                    </div>
                  </div>

				</div><!--/span-->
			</div><!--/row-->
			
			  
<div class="form-actions">
<button type="submit" class="btn btn-primary" name="submit">Save</button>
</div>

	<input type="hidden" name="option" value="<?php echo JRequest::getVar('option'); ?>" />
	<input type="hidden" id="id" name="id" value="<?php echo $this->rec->id; ?>" />
	<input type="hidden" id="courseid" name="courseid" value="<?php echo $this->rec->joinedclassid; ?>" />
	<input type="hidden" id="controller" name="controller" value="students" />
	<input type="hidden" id="view" name="view" value="addstudent" />
	<input type="hidden" name="task" id="task" value="save" />
	<input type="hidden" name="Itemid" id="Itemid" value="<?php echo $Itemid; ?>" />
</form>



