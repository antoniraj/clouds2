
<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';

        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	$Itemid  = JRequest::getVar('Itemid');
    $staffid  = JRequest::getVar('staffid');
	$iconsDir1 = JURI::base() . 'components/com_cce/images';
	$photoDir = JURI::base() . 'components/com_cce/staffphoto/';
	$loaderDir = JURI::base() . 'components/com_cce/loader/';

   	$model = & $this->getModel('cce');
	$model->getstaff($staffid,$staff_rec);

   	$dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
   	$modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=staff&Itemid='.$masterItemid);

  	$stafflink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=staffs&view=staffs&task=display&courseid='.JRequest::getVar('courseid').'&Itemid='.JRequest::getVar('Itemid'));
   $pdflink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=staffs&view=staffs&layout=pdfprofile&staffid='.$staff_rec->id.'&Itemid='.$masterItemid.'&format=pdf&tmpl=component');
   
	
?>
<?php
        $isModal = JRequest::getVar( 'print' ) == 1; // 'print=1' will only be present in the url of the modal window, not in the presentation of the page
        if( $isModal) {
                $href = '"#" onclick="window.print(); return false;"';
        } else {
                $href = 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no';
                $href = "window.open(this.href,'win2','".$href."'); return false;";
                $href = '"index.php?option=com_cce&view=staffs&controller=staffs&layout=printprofile&staffid='.$staffid.'&tmpl=component&print=1" '.$href;
        }
?>

<div class="container">
  <div class="row-fluid">
    <div class="span7">
      <h1 class="item-page-title"><img src="<?php echo $iconsDir.'/addstudent.png'; ?>" alt="Add Students" style="width: 64px; height: 64px;" /> Staff Profile</h1>
    </div>
    <div class="span5">
      <div class="pull-right controler-menu">  <a title="Students Records" href="<?php echo $stafflink; ?>"><img src="<?php echo $iconsDir.'/students.png'; ?>" alt="Students" /></a> <a href="<?php echo $modulelink; ?>" title="Students"><img src="<?php echo $iconsDir1.'/1staff.png'; ?>" alt="Students" /></a><a title="Dash Board" href="<?php echo $dashboardlink; ?>"><img src="<?php echo $iconsDir1.'/1dashboard.png'; ?>" alt="Dash Board" /></a></div>
    </div>
  </div>
  <div align="right"> <a href=<?php echo $href; ?> ><span title="Print" class="icon32 icon-green icon-print"></span></a></div>
  <div class="report-preview">
    <div class="alert">
      <h2>Personal Details</h2>
    </div>
    <!--alert-->
    
    <form action="index.php" class="form-horizontal" enctype="multipart/form-data" method="POST" name="addform" id="addform" onSubmit="return checkform()">
      <div class="row-fluid">
        <div class="span2" align="center">
          <?php
			$filename=$model->getsiglestaffphoto($staffid,$file);
			if($file->image_name)
			{
			?>
          <img src="<?php echo  $photoDir.trim($file->image_name); ?>" id="preview_img" alt="photo" />
          <?php
							}else{ ?>
          <img src="<?php echo $photoDir.'no-image.gif'; ?>" id="preview_img" alt="photo"/>
          <?php } ?>
          <h2><?php echo $staff_rec->firstname.''.$staff_rec->middlename.''.$staff_rec->lastname;?></h2>
        </div>
        <div class="span10">
          <div class="row-fluid">
            <div class="span4">
              <table width="100%" class="table">
                <tr>
                  <td width="45%" valign="top"><strong>Staff Code</strong></td>
                  <td width="3%" valign="top"><strong>:</strong></td>
                  <td width="52%" valign="top"><label class="txt-label"><?php echo $staff_rec->staffcode; ?></label></td>
                </tr>
                <tr>
                  <td valign="top"><strong>Date Of Joining</strong></td>
                  <td valign="top"><strong>:</strong></td>
                  <td valign="top"><label class="txt-label"><?php echo JArrayHelper::indianDate($staff_rec->doj); ?></label></td>
                </tr>
                <tr>
                  <td valign="top"><strong>Date of Birth</strong></td>
                  <td valign="top"><strong>:</strong></td>
                  <td valign="top"><label class="txt-label"><?php echo JArrayHelper::indianDate($staff_rec->dob); ?></label></td>
                </tr>
                  <tr>
                  <td width="45%" valign="top"><strong>Gender</strong></td>
                  <td width="3%" valign="top"><strong>:</strong></td>
                  <td width="52%" valign="top"><label class="txt-label"><?php echo $staff_rec->gender; ?></label></td>
                </tr>
              </table>
            </div>
            <div class="span4">
              <table width="100%" class="table">
              
             <tr>
                  <td valign="top"><strong>Category</strong></td>
                  <td valign="top"><strong>:</strong></td>
                  <td valign="top"><?php
						$dep_name=$model->getDepartmentName($staff_rec->department);
					?>
                    <label class="txt-label"><?php echo $dep_name; ?></label></td>
                </tr>
                <tr>
                  <td valign="top"><strong>Job Title</strong></td>
                  <td valign="top"><strong>:</strong></td>
                  <td valign="top"><label class="txt-label"><?php echo $staff_rec->jobtitle; ?></label></td>
                </tr>
                <tr>
                  <td valign="top"><strong>Qualificatione</strong></td>
                  <td valign="top"><strong>:</strong></td>
                  <td valign="top"><label class="txt-label"><?php echo $staff_rec->qualification; ?></label></td>
                </tr>
                 <tr>
                  <td valign="top"><strong>Experience Info</strong></td>
                  <td valign="top"><strong>:</strong></td>
                  <td valign="top"><label class="txt-label"><?php echo $staff_rec->experienceinfo; ?></label></td>
                </tr>
              </table>
            </div>
            <div class="span4">
              <table width="100%" class="table">
                <tr>
                  <td width="45%" valign="top"><strong>Nationality</strong></td>
                  <td width="3%" valign="top"><strong>:</strong></td>
                  <td width="52%" valign="top"><?php
                    $co_name=$model->getCountryName($staff_rec->nationality);
				?>
                    <label class="txt-label"><?php echo $co_name; ?></label></td>
                </tr>
                <tr>
                  <td valign="top"><strong>Blood Group</strong></td>
                  <td valign="top"><strong>:</strong></td>
                  <td valign="top"><label class="txt-label"><?php echo $staff_rec->bloodgroup; ?></label></td>
                </tr>
                <tr>
                  <td valign="top"><strong>Religion</strong></td>
                  <td valign="top"><strong>:</strong></td>
                  <td valign="top"><label class="txt-label"><?php echo $staff_rec->religion; ?></label></td>
                </tr>
                <tr>
                  <td valign="top"><strong>Category</strong></td>
                  <td valign="top"><strong>:</strong></td>
                  <td valign="top"><?php
						$cat_name=$model->getCategoryName($staff_rec->category);
					?>
                    <label class="txt-label"><?php echo $cat_name; ?></label></td>
                </tr>
              </table>
            </div>
          </div>
        </div>
      </div>
      <!--/span-->
      <div>&nbsp;</div>
      <!-- Contact Details-->
      <div class="alert">
        <h2>
        Contact Details
        </h2s>
      </div>
      <div class="row-fluid">
        <div class="span4"> <strong>Address 1</strong><br />
          <label class="txt-label"><?php echo $staff_rec->addressline1; ?></label>
        </div>
        <div class="span4"><strong>Address 2</strong><br />
          <label class="txt-label"><?php echo $staff_rec->addressline2; ?></label>
        </div>
        <div class="span4">
          <table width="100%" border="0">
            <tr>
              <td width="35%"><strong>Nationality</strong></td>
              <td width="65%"><?php		
						$fco_name=$model->getCountryName($staff_rec->country);
					?>
                <label class="txt-label"><?php echo $fco_name; ?></label></td>
            </tr>
            <tr>
              <td><strong>State</strong></td>
              <td><label class="txt-label"><?php echo $staff_rec->state; ?></label></td>
            </tr>
            <tr>
              <td><strong>City</strong></td>
              <td><label class="txt-label"><?php echo $staff_rec->city; ?></label></td>
            </tr>
            <tr>
              <td><strong>Pin Code</strong></td>
              <td><label class="txt-label"><?php echo $staff_rec->pincode; ?></label></td>
            </tr>
          </table>
        </div>
      </div>
      <div>&nbsp;</div>
      <!-- Parents Details-->
      <div class="alert">
        <h2>Parents Details</h2>
      </div>
      <div class="row-fluid">
        <div class="span4">
          <table width="100%">
            <tr>
              <td width="45%" valign="top"><strong>Father Name</strong></td>
              <td width="3%" valign="top"><strong>:</strong></td>
              <td width="52%" valign="top"><label class="txt-label"><?php echo $staff_rec->pfathername; ?></label></td>
            </tr>

            <tr>
              <td valign="top"><strong>Father's Mobile</strong></td>
              <td valign="top"><strong>:</strong></td>
              <td valign="top"><label class="txt-label"><?php echo $staff_rec->mobile; ?></label></td>
            </tr>
            <tr>
              <td valign="top"><strong>Father's Email</strong></td>
              <td valign="top"><strong>:</strong></td>
              <td valign="top"><label class="txt-label"><?php echo $staff_rec->email; ?></label></td>
            </tr>
          
          </table>
        </div>
        <div class="span4">
          <table width="100%">
            <tr>
              <td width="45%" valign="top"><strong>Mother Name</strong></td>
              <td width="3%" valign="top"><strong>:</strong></td>
              <td width="52%" valign="top"><label class="txt-label"><?php echo $staff_rec->mothername; ?></label></td>
            </tr>

            <tr>
              <td valign="top"><strong>Mother's Mobile</strong></td>
              <td valign="top"><strong>:</strong></td>
              <td valign="top"><label class="txt-label"><?php echo $staff_rec->mmobile; ?></label></td>
            </tr>
            <tr>
              <td valign="top"><strong>Mother's Email</strong></td>
              <td valign="top"><strong>:</strong></td>
              <td valign="top"><label class="txt-label"><?php echo $staff_rec->memail; ?></label></td>
            </tr>
          
          </table>
        </div>
   
      </div>
    </form>
  </div>
  <!--report-preview--> 
</div>
<!--container--> 
<div>&nbsp;</div>
