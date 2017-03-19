
<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	$Itemid  = JRequest::getVar('Itemid');
    $studentid  = JRequest::getVar('id');
	$iconsDir1 = JURI::base() . 'components/com_cce/images';
	$photoDir = JURI::base() . 'components/com_cce/studentsphoto/';
	$loaderDir = JURI::base() . 'components/com_cce/loader/';
	  JFactory::getDocument()->addStyleSheet(JURI::root().'components/com_cce/libraries/charisma/css/bootstrap-cerulean.css');
		  JFactory::getDocument()->addStyleSheet(JURI::root().'components/com_cce/libraries/charisma/css/bootstrap-responsive.css');
		  JFactory::getDocument()->addStyleSheet(JURI::root().'components/com_cce/libraries/charisma/css/charisma-app.css');
		    
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
   $pdflink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=studentprofile&view=studentprofile&layout=profile&regno='.$stu_rec->registerno.'&id='.$stu_rec->id.'&Itemid='.$masterItemid.'&format=pdf&tmpl=component');
	
?>
<?php
	$model2=& $this->getModel('tngradebook');
	$model3=& $this->getModel('nmarks');
	$status=$model->getSchoolInfo($rec);
?>
<center>

                <h1 style="font-size:26px;"><strong><?php echo $rec->schoolname; ?></strong></h1><br>
                <h3><?php echo $rec->schooladdress; ?></h3>
</center>
<br />
<br />

<h3 class="student_title">Personal Details</h3>							
<br>
<table class="studentprofile">
<tr>
<td>
<center>
							<?php
								$filename=$model->getsiglestudentphoto($stu_rec->id,$file);
						        if($file->imagename)
						        {
					     		?>
								<img src="<?php echo  $photoDir.$file->imagename; ?>" id="preview_img" alt="photo" style="width: 110px; height: 100px; border: 1px solid #DFE3EA;" />
							<?php
								}else{ ?>
								<img src="<?php echo $photoDir.'no-image.gif'; ?>" id="preview_img" alt="photo" style="width: 110px; height: 100px; border: 1px solid #ECE5D7;" />
								<?php } ?>
							<br>
						   <h3><?php echo $stu_rec->firstname.''.$stu_rec->middlename.''.$stu_rec->lastname;?></h3>
						</center>
</td>
<td>
	<table class="personal">
	<tr>
	<td class="left">Register No :</td>
	<td><?php echo $stu_rec->registerno; ?></td>
	</tr>
	<tr>
	<td class="left">Admission No :</td>
	<td><?php echo $stu_rec->ano; ?></td></tr>
	<tr>
	<td class="left">Admission Date :</td>
	<td><?php echo JArrayHelper::indianDate($stu_rec->adate); ?></td></tr>
	
	<tr><td class="left">Date of Birth :</td>
	<td><?php echo JArrayHelper::indianDate($stu_rec->dob); ?></td></tr>
	</table>
</td>
<td>
	<table class="personal">
	<tr>
	<td class="left">Gender :</td>
	<td><?php echo $stu_rec->gender; ?></td>
	</tr>
	<tr>
	<td class="left">Blood Group :</td>
	<td><?php echo $stu_rec->bloodgroup; ?></td></tr>
	<tr>
	<td class="left">Birth Place :</td>
	<td><?php echo $stu_rec->birthplace; ?></td></tr>
	
	<tr><td class="left">Mother Tongue :</td>
	<td><?php echo $stu_rec->mothertongue; ?></td></tr>
	</table>
</td>
<td>
	<table class="personal">
	<tr>
	<td class="left">Nationality :</td>
	<?php
			$co_name=$model->getCountryName($stu_rec->nationality);
	?>
	<td><?php echo $co_name; ?></td>
	</tr>
	<tr>
	<td class="left">Community/Caste :</td>
	<td><?php echo $stu_rec->caste; ?></td></tr>
	<tr>
	<td class="left">Religion :</td>
	<td><?php echo $stu_rec->religion; ?></td></tr>
	
	<tr><td class="left">Student Category :</td>
	<?php
		$cid=$model->getStudentCategory($stu_rec->categoryid,$ca_id);
	?>
	<td><?php echo $cid->categoryname; ?></td></tr>
	</table>
</td>
</tr>
</table>

	
 <?php					
		$fco_name=$model->getCountryName($stu_rec->country);
	?>
<!-- Contact Details-->
<h3 class="student_title">Contact Details</h3>							
<br>
<table class="studentprofile">
<tr>
<td>
<table class="personal">
<tr>
<td class="left">Address 1 :</td>
<td><?php echo $stu_rec->addressline1; ?></td></tr>
<tr>
<td class="left">Address 2 :</td>
<td><?php echo $stu_rec->addressline2; ?></td>
</tr>
<tr>
<td class="left">Nationality :</td>

<td><?php echo $fco_name; ?></td>
</tr>

</table>	
</td>
<td>
<table class="personal">
<tr>
<td class="left">State :</td>
<td><?php echo $stu_rec->state; ?></td>
</tr>
<tr>
<td class="left">City :</td>
<td><?php echo $stu_rec->city; ?></td>
</tr>
<tr>
<td class="left">Pin Code :</td>
<td><?php echo $stu_rec->pincode; ?></td>
</tr>
</table>
</td>
</tr>
</table>	
<!-- Contact Details-->

<h3 class="student_title">Parents Details</h3>		
<br>					
<table class="studentprofile">
<tr>
<td>
<table class="personal"><tr>
<th colspan="2" class="heading"> Father's Details</th></tr>
<tr><td class="left">Father Name :</td>
<td><?php echo $stu_rec->pfathername; ?></td>
</tr>
<tr>
<td class="left">Father's Phone :</td>
<td><?php echo $stu_rec->phone; ?></td>
</tr>
<tr>
<td class="left">Father's Mobile :</td>
<td><?php echo $stu_rec->mobile; ?></td>
</tr>
<tr>
<td class="left">Father's Email :</td>
<td><?php echo $stu_rec->email; ?></td>
</tr>
<tr>
<td class="left">Father's Occupation :</td>
<td><?php echo $stu_rec->focc; ?></td>
</tr>
</td>
</tr>
</table>
</td>
<td>
<table class="personal">
<tr>
<th colspan="2" class="heading">Mother's Detials :</th>
</tr>
<tr>
<td class="left">Mother Name :</td>
<td><?php echo $stu_rec->mphone; ?></td>
</tr>
<tr>
<td class="left">Mother's Phone :</td>
<td><?php echo $stu_rec->mphone; ?></td>
</tr>
<tr>
<td class="left">Mother's Mobile :</td>
<td><?php echo $stu_rec->mobile; ?></td>
</tr>
<tr>
<td class="left">Monther's Occupation :</td>
<td><?php echo $stu_rec->mocc; ?></td>
</tr>
</table>
</td>
<td>
<table class="personal">
<tr>
<th colspan="2" class="heading">Gardian's Detials</th>
</tr>
<tr>
<td  class="left">Gardian Name :</td>
<td><?php echo $stu_rec->gname; ?></td>
</tr>
<tr>
<td  class="left">Phone Number :</td>
<td><?php echo $stu_rec->gphone; ?></td>
</tr>
<tr>
<td  class="left">Mobile Number :</td>
<td><?php echo $stu_rec->gmobile; ?></td>
</tr>
<tr>
<td  class="left">Occupation :</td>
<td><?php echo $stu_rec->gocc; ?></td>
</tr>
</table>
</td>
</tr>
</table>	
		<br>
		<Br>
		<Br>
