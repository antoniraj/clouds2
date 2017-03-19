
<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	$pdf = JURI::base() . 'components/com_cce/fpdf/tutorial/tuto1.php';

        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	$Itemid  = JRequest::getVar('Itemid');
    	$studentid  = JRequest::getVar('id');
	$iconsDir1 = JURI::base() . 'components/com_cce/images';
	$photoDir = JURI::base() . 'components/com_cce/studentsphoto/';
	$loaderDir = JURI::base() . 'components/com_cce/loader/';
   	$model = & $this->getModel('cce');
	$model->getStudent($studentid,$stu_rec);
   	$dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
   	$modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=students&Itemid='.$masterItemid);

  	$studentslink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=students&view=students&task=display&courseid='.JRequest::getVar('courseid').'&Itemid='.JRequest::getVar('Itemid'));
   $pdflink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=studentprofile&view=studentprofile&layout=pdfprofile&regno='.$stu_rec->registerno.'&id='.$stu_rec->id.'&Itemid='.$masterItemid.'&format=pdf&tmpl=component');
   

  	$app =& JFactory::getApplication();
        $pathway =& $app->getPathway();
        $pathway->addItem('Home', $dashboardlink);
        $pathway->addItem('Students',$modulelink);
        $pathway->addItem($this->crec->code,$studentslink);
	$pathway->addItem('Profile');


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



$pdf=JURI::Base()."components/com_cce/fpdf/tc.php?ano=1098&studentname=Sundaram M.&fathername=Mathalai Muthu&nationality=Indian&sex=Male&dob=10-10-2012&religion=Christian";
$pdf2=JURI::Base()."components/com_cce/fpdf/bonafide.php?ano=1098&gen=m&cdate=".date('d-m-Y')."&studentname=Sundaram M.&yearfrom=2012&yearto=2015&stdfrom=IV&stdto=VI&conduct=Good";
?>


<!-- <A href="javascript: window.open('index2.php/component/cce/?controller=students&task=add&view=addstudent&courseid=2&Itemid=','','status=no, target=miniwin;targetfeatures=toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=0,width=600,height=600,'); void('');" )>HELLO</a>  -->

<!-- <A href="javascript: window.open('http://localhost/~maradnus/stantv2/components/com_cce/fpdf/tutorial/tuto1.php?x=1','','status=no, target=miniwin;targetfeatures=toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=0,width=600,height=600,'); void('');" )>HELLO</a> -->
<A href="javascript: window.open('<?php echo $pdf; ?>','','status=no, target=miniwin;targetfeatures=toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=0,width=600,height=600,'); void('');" )>HELLO</a>
<A href="javascript: window.open('<?php echo $pdf2; ?>','','status=no, target=miniwin;targetfeatures=toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=0,width=600,height=600,'); void('');" )>HELLO1</a>
<!-- <a href="<?php  echo $pdf; ?>">XXXX</a> -->
  <div align="right"><a href="<?php echo $pdflink; ?>"><span title="Pdf" class="icon32 icon-green icon-pdf"></span></a> <a href=<?php echo $href; ?> ><span title="Print" class="icon32 icon-green icon-print"></span></a></div>
  <div class="report-preview">
    <div class="alert">
      <h2>Personal Details</h2>
    </div>
    <!--alert-->
    
    <form action="index.php" class="form-horizontal" enctype="multipart/form-data" method="POST" name="addform" id="addform" onSubmit="return checkform()">
      <div class="row-fluid">
        <div class="span2" align="center">
          <?php
			$filename=$model->getsiglestudentphoto($stu_rec->id,$file);
			if($file->imagename)
			{
			?>
          <img src="<?php echo  $photoDir.$file->imagename; ?>" id="preview_img" alt="photo" />
          <?php
							}else{ ?>
          <img src="<?php echo $photoDir.'no-image.gif'; ?>" id="preview_img" alt="photo"/>
          <?php } ?>
          <h2><?php echo $stu_rec->firstname.''.$stu_rec->middlename.''.$stu_rec->lastname;?></h2>
        </div>
        <div class="span10">
          <div class="row-fluid">
            <div class="span4">
              <table width="100%" class="table">
                <tr>
                  <td width="45%" valign="top"><strong>Register No</strong></td>
                  <td width="3%" valign="top"><strong>:</strong></td>
                  <td width="52%" valign="top"><label class="txt-label"><?php echo $stu_rec->registerno; ?></label></td>
                </tr>
                <tr>
                  <td valign="top"><strong>Admission No</strong></td>
                  <td valign="top"><strong>:</strong></td>
                  <td valign="top"><label class="txt-label"><?php echo $stu_rec->ano; ?></label></td>
                </tr>
                <tr>
                  <td valign="top"><strong>Admission Date</strong></td>
                  <td valign="top"><strong>:</strong></td>
                  <td valign="top"><label class="txt-label"><?php echo JArrayHelper::indianDate($stu_rec->adate); ?></label></td>
                </tr>
                <tr>
                  <td valign="top"><strong>Date of Birth</strong></td>
                  <td valign="top"><strong>:</strong></td>
                  <td valign="top"><label class="txt-label"><?php echo JArrayHelper::indianDate($stu_rec->dob); ?></label></td>
                </tr>
              </table>
            </div>
            <div class="span4">
              <table width="100%" class="table">
                <tr>
                  <td width="45%" valign="top"><strong>Gender</strong></td>
                  <td width="3%" valign="top"><strong>:</strong></td>
                  <td width="52%" valign="top"><label class="txt-label"><?php echo $stu_rec->gender; ?></label></td>
                </tr>
                <tr>
                  <td valign="top"><strong>Blood Group</strong></td>
                  <td valign="top"><strong>:</strong></td>
                  <td valign="top"><label class="txt-label"><?php echo $stu_rec->bloodgroup; ?></label></td>
                </tr>
                <tr>
                  <td valign="top"><strong>Birth Place</strong></td>
                  <td valign="top"><strong>:</strong></td>
                  <td valign="top"><label class="txt-label"><?php echo $stu_rec->birthplace; ?></label></td>
                </tr>
                <tr>
                  <td valign="top"><strong>Mother Tongue</strong></td>
                  <td valign="top"><strong>:</strong></td>
                  <td valign="top"><label class="txt-label"><?php echo $stu_rec->mothertongue; ?></label></td>
                </tr>
              </table>
            </div>
            <div class="span4">
              <table width="100%" class="table">
                <tr>
                  <td width="45%" valign="top"><strong>Nationality</strong></td>
                  <td width="3%" valign="top"><strong>:</strong></td>
                  <td width="52%" valign="top"><?php
                    $co_name=$model->getCountryName($stu_rec->nationality);
				?>
                    <label class="txt-label"><?php echo $co_name; ?></label></td>
                </tr>
                <tr>
                  <td valign="top"><strong>Community / Caste</strong></td>
                  <td valign="top"><strong>:</strong></td>
                  <td valign="top"><label class="txt-label"><?php echo $stu_rec->caste; ?></label></td>
                </tr>
                <tr>
                  <td valign="top"><strong>Religion</strong></td>
                  <td valign="top"><strong>:</strong></td>
                  <td valign="top"><label class="txt-label"><?php echo $stu_rec->religion; ?></label></td>
                </tr>
                <tr>
                  <td valign="top"><strong>Student Category</strong></td>
                  <td valign="top"><strong>:</strong></td>
                  <td valign="top"><?php
						$cid=$model->getStudentCategory($stu_rec->categoryid,$ca_id);
					?>
                    <label class="txt-label"><?php echo $ca_id->categoryname; ?></label></td>
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
          <label class="txt-label"><?php echo $stu_rec->addressline1; ?></label>
        </div>
        <div class="span4"><strong>Address 2</strong><br />
          <label class="txt-label"><?php echo $stu_rec->addressline2; ?></label>
        </div>
        <div class="span4">
          <table width="100%" border="0">
            <tr>
              <td width="35%"><strong>Nationality</strong></td>
              <td width="65%"><?php		
						$fco_name=$model->getCountryName($stu_rec->country);
					?>
                <label class="txt-label"><?php echo $fco_name; ?></label></td>
            </tr>
            <tr>
              <td><strong>State</strong></td>
              <td><label class="txt-label"><?php echo $stu_rec->state; ?></label></td>
            </tr>
            <tr>
              <td><strong>City</strong></td>
              <td><label class="txt-label"><?php echo $stu_rec->city; ?></label></td>
            </tr>
            <tr>
              <td><strong>Pin Code</strong></td>
              <td><label class="txt-label"><?php echo $stu_rec->pincode; ?></label></td>
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
              <td width="52%" valign="top"><label class="txt-label"><?php echo $stu_rec->pfathername; ?></label></td>
            </tr>
            <tr>
              <td valign="top"><strong>Father's Phone</strong></td>
              <td valign="top"><strong>:</strong></td>
              <td valign="top"><label class="txt-label"><?php echo $stu_rec->phone; ?></label></td>
            </tr>
            <tr>
              <td valign="top"><strong>Father's Mobile</strong></td>
              <td valign="top"><strong>:</strong></td>
              <td valign="top"><label class="txt-label"><?php echo $stu_rec->mobile; ?></label></td>
            </tr>
            <tr>
              <td valign="top"><strong>Father's Email</strong></td>
              <td valign="top"><strong>:</strong></td>
              <td valign="top"><label class="txt-label"><?php echo $stu_rec->email; ?></label></td>
            </tr>
            <tr>
              <td valign="top"><strong>Father's Occupation</strong></td>
              <td valign="top"><strong>:</strong></td>
              <td valign="top"><label class="txt-label"><?php echo $stu_rec->focc; ?></label></td>
            </tr>
          </table>
        </div>
        <div class="span4">
          <table width="100%">
            <tr>
              <td width="45%" valign="top"><strong>Mother Name</strong></td>
              <td width="3%" valign="top"><strong>:</strong></td>
              <td width="52%" valign="top"><label class="txt-label"><?php echo $stu_rec->mothername; ?></label></td>
            </tr>
            <tr>
              <td valign="top"><strong>Mother's Phone</strong></td>
              <td valign="top"><strong>:</strong></td>
              <td valign="top"><label class="txt-label"><?php echo $stu_rec->mphone; ?></label></td>
            </tr>
            <tr>
              <td valign="top"><strong>Mother's Mobile</strong></td>
              <td valign="top"><strong>:</strong></td>
              <td valign="top"><label class="txt-label"><?php echo $stu_rec->mmobile; ?></label></td>
            </tr>
            <tr>
              <td valign="top"><strong>Mother's Email</strong></td>
              <td valign="top"><strong>:</strong></td>
              <td valign="top"><label class="txt-label"><?php echo $stu_rec->memail; ?></label></td>
            </tr>
            <tr>
              <td valign="top"><strong>Mother's Occupation</strong></td>
              <td valign="top"><strong>:</strong></td>
              <td valign="top"><label class="txt-label"><?php echo $stu_rec->mocc; ?></label></td>
            </tr>
          </table>
        </div>
        <div class="span4">
          <table width="100%">
            <tr>
              <td width="45%" valign="top"><strong>Gardian Name</strong></td>
              <td width="3%" valign="top"><strong>:</strong></td>
              <td width="52%" valign="top"><label class="txt-label"><?php echo $stu_rec->gname; ?></label></td>
            </tr>
            <tr>
              <td valign="top"><strong>Gardian's Phone No</strong></td>
              <td valign="top"><strong>:</strong></td>
              <td valign="top"><label class="txt-label"><?php echo $stu_rec->gphone; ?></label></td>
            </tr>
            <tr>
              <td valign="top"><strong>Gardian's Mobile</strong></td>
              <td valign="top"><strong>:</strong></td>
              <td valign="top"><label class="txt-label"><?php echo $stu_rec->gmobile; ?></label></td>
            </tr>
            <tr>
              <td valign="top"><strong>Gardian's Occupation</strong></td>
              <td valign="top"><strong>:</strong></td>
              <td valign="top"><label class="txt-label"><?php echo $stu_rec->gocc; ?></label></td>
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
