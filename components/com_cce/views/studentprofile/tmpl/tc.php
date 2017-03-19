
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
	$model->getStudent($studentid,$srec);
	$model->getSchoolInfo($schoolinfo);
   	$dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
   	$modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=students&Itemid='.$masterItemid);

  	$studentslink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=students&view=students&task=display&courseid='.JRequest::getVar('courseid').'&Itemid='.JRequest::getVar('Itemid'));
   $pdflink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=studentprofile&view=studentprofile&layout=pdfprofile&regno='.$stu_rec->registerno.'&id='.$stu_rec->id.'&Itemid='.$masterItemid.'&format=pdf&tmpl=component');
   

  	$app =& JFactory::getApplication();
        $pathway =& $app->getPathway();
        $pathway->addItem('Home', $dashboardlink);
        $pathway->addItem('Students',$modulelink);
        $pathway->addItem($this->crec->code,$studentslink);
	$pathway->addItem('Transfer Certificate');

	$pdf=JURI::Base()."components/com_cce/fpdf/tc.php?ano=1098&studentname=Sundaram M.&fathername=Mathalai Muthu&nationality=Indian&sex=Male&dob=10-10-2012&religion=Christian";


	
	$sno='';
 	$tmrcodeno='';
	$marklistno='';
	$admissionno='';
	$schoolname=$schoolinfo->schoolname;
	$schooladdress=$schoolinfo->schooladdress;
	$educationdistrict=$schoolinfo->educationdistrict;
	$revenuedistrict=$schoolinfo->revenuedistrict;

	if(strlen(trim($sno))<1) $sno='     ';
	if(strlen(trim($tmrcodeno))<1) $tmrcodeno='       ';
	if(strlen(trim($marklistno))<1) $marklistno='       ';
	if(strlen(trim($schoolname))<5) $schoolname='                                  ';
	if(strlen(trim($schooladdress))<5) $schooladdress='                                  ';
	if(strlen(trim($revenuedistrict))<5) $revenuedistrict='                                  ';
	if(strlen(trim($educationdistrict))<5) $educationdistrict='                                  ';

	$sname=$srec->firstname.' '.$stu_rec->middlename.' '.$stu_rec->lastname;

	if(strlen(trim($srec->pfathername))>2)
		$parentname=$srec->pfathername; 
	else if(strlen(trim($srec->mothername))>2)
		$parentname=$srec->mothername;
	else if(strlen(trim($srec->gname))>2)
		$parentname=$srec->gname;
	else $parentname = '                         ';

	$nationality=$model->getNationality($srec->nationality);
	$religion=$srec->religion;
	$community = $srec->community;
	$a=split("-",$srec->dob);
	$dob=$a[2].'-'.$a[1].'-'.$a[0];

	$ano = $srec->ano;
	$medium = $srec->medium;
	$firstlanguage = $srec->lang1;

	if(strlen(trim($ano))==0) $admissionno='       ';
	else $admissionno = ($ano);

	if(strlen(trim($sname))==0) $studentname='                         ';
	else $studentname = strtoupper($sname);

	if(strlen(trim($parentname))==0) $parentname='                         ';
	else $parentname = $parentname;

	if(strlen(trim($srec->gender))==0) $sex='     ';
	else $sex = $srec->gender;

	if(strlen(trim($nationality))==0) $nationality='                         ';
	else $nationality = $nationality.'n';

	if(strlen(trim($religion))==0) $religion='              ';

	if(strlen(trim($srec->identificationmark))==0) $idmark1='                                     ';
	else $idmark1 = $srec->identificationmark;
	if(strlen(trim($srec->identificationmark2))==0) $idmark2='                                     ';
	else $idmark2 = $srec->identificationmark2;

	if($sex=='F' || $sex=='Female' || $sex=='f' || $sex=='FEMALE' || $sex=='female')
	{
		$sex='Female';
	}
	if($sex=='M' || $sex=='Male' || $sex=='m' || $sex=='MALE' || $sex=='male')
	{
		$sex='Male';
	}

	$cdate=date('d-m-Y');

	if($model->getStudentClass($studentid,$crec))
		$currentclass=$crec->coursename;

	$isqualified='Yes';
	$dateofleft=$cdate;
	$dateoftc=$cdate;
	$dateoftcapplication=$cdate;
	$conductandcharacter='Good';
	$courseofstudy='                      ';
	$academicyears='';
	$gveducation='---';
	$gveducationmedium='---';
	$veducation='---';
	$part1lang='---';
	$medicalreport='---';
	$scholarship='---';
	
	if(strlen(trim($srec->adate))<3) $adate='              ';
	else{
		$a=split("-",$srec->adate);
		$adate=$a[2].'-'.$a[1].'-'.$a[0];
	}
	if(strlen(trim($srec->admittedclass))<3) $aclass='              ';
	else	$aclass = $srec->admittedclass;
?>

<style>
input.ss{
background-color:white;
text-align:left;
border:2px;
font-size:110%;
}
</style>
<form  class="form-horizontal" action="<?php echo $pdf; ?>"  enctype="multipart/form-data" method="POST" name="addform" id="addform" onSubmit="return checkform()">
<div style="float:right;">
<input class="btn btn-small btn-warning" type="submit" name="print2" value="PRINT" />
<!-- <input class="btn btn-small btn-primary" type="submit" name="print1" value="PRINT ALL" /> -->
</div>
<br />
<br />
<center>
<table border="1" width="85%">    <!-- Main Table with border lines-->


 <tr height="90px">
 <td align="center">

  <table border="0" width="80%" cellpadding="10">  <!-- Inner Table for headings --> 
   <tr>
     <td align="center" colspan="2">
<?php
	
	echo '<b><p style="font-size:150%">'.$schoolinfo->board.'</p></b>';
	echo '<b><p style="font-size:200%">TRANSFER CERTIFICATE</p></b>';
	echo '<b><p style="font-size:120%">(Recognised by the Director of School Education)</p></b>';
?>
     </td>
   </tr>
  </table>
 </td>
 </tr>

 <tr> 
  <td>
   <table border="0" width="100%" cellpadding="2"> <!-- Inner table for id numbers with 2 rows 3 cols-->
    <tr> 
      <td colspan="3" align="left" style="font-size:100%"><b>
        Serial No. 
	<input type="text" name="sno"  style="text-align:left;font-size:100%;width:<?php echo (strlen($sno)*12).'px'; ?>"  value="<?php echo $sno; ?>" />
      </td>
    </tr>
    <tr> 
     <td align="left" style="font-size:100%">
      <b>
	TMR Code No.
	<input type="text" name="tmrcodeno"  style="text-align:left;font-size:100%;width:<?php echo (strlen($tmrcodeno)*12).'px'; ?>"  value="<?php echo $tmrcodeno; ?>" />
      </b>
     </td>
     <td align="right" style="font-size:100%">
      <b>
	Mark List No.
	<input type="text" name="marklistno" style="text-align:right;font-size:100%;width:<?php echo (strlen($marklistno)*12).'px'; ?>" value="<?php echo $marklistno; ?>" />
      </b>
     </td>
     <td align="right" style="font-size:115%">
      <b>
       Admission No.
       <input type="text" name="admissionno" style="text-align:right;font-size:115%;width:<?php echo (strlen($admissionno)*12).'px'; ?>" value="<?php echo $admissionno; ?>" />
      </b>
     </td>
    </tr>
   </table>
  </td>
 </tr>


 <tr> <!-- Main Body -->
  <td style="background-color:lightgrey;" align="center">
   <table border="0" width="98%">
    <tr>
     <td width="3%" align="left">1.</td>
     <td colspan="2" width="45%" align="left">Name of the School</td>
     <td width="2%" align="center">:</td>
     <td width="50%" align="left"><b><input type="text" name="schoolname" class="ss" style="width:<?php echo (strlen($schoolname)*12).'px'; ?>" value="<?php echo $schoolname; ?>" /></b></td>
    </tr>
    <tr>
     <td width="3%" align="left"></td>
     <td width="2%" align="left">a) </td>
     <td width="43%" align="left">Name of the Education District</td>
     <td width="2%" align="center">:</td>
     <td width="50%" align="left"><b><input type="text" name="educationdistrict" class="ss" style="width:300px;" value="<?php echo $educationdistrict; ?>" /></b></td>
    </tr>
    <tr>
     <td width="3%" align="left"></td>
     <td width="2%" align="left">b) </td>
     <td width="43%" align="left">Name of the Revenue District</td>
     <td width="2%" align="center">:</td>
     <td width="50%" align="left"><b><input type="text" name="revenuedistrict" class="ss" style="width:300px;" value="<?php echo $revenuedistrict; ?>" /></b></td>
    </tr>
    <tr>
     <td width="3%" align="left">2.</td>
     <td colspan="2" width="45%" align="left">Name of the pupil (in Block Letters)</td>
     <td width="2%" align="center">:</td>
     <td width="50%" align="left"><b><input type="text" name="studentname" style="font-size: 12pt;text-align:left;width:300px;" class="ss" value="<?php echo $studentname; ?>" /></b></td>
    </tr>
    <tr>
     <td width="3%" align="left">3.</td>
     <td colspan="2" width="45%" align="left">Name of the Father or Mother of the pupil</td>
     <td width="2%" align="center">:</td>
     <td width="50%" align="left"><b><input type="text" name="parentname" class="ss" style="width:300px;" value="<?php echo $parentname; ?>" /></b></td>
    </tr>
    <tr>
     <td width="3%" align="left">4.</td>
     <td colspan="2" width="45%" align="left">Nationality and Religion</td>
     <td width="2%" align="center">:</td>
     <td width="50%" align="left"><b><input type="text" name="nationality" class="ss" style="width:100px;" value="<?php echo $nationality; ?>" />-<input type="text" name="religion" class="ss" style="width:188px;" value="<?php echo $religion; ?>" /></b></td>
    </tr>
    <tr>
     <td width="3%" align="left">5.</td>
     <td colspan="2" width="45%" align="left">Community</td>
     <td width="2%" align="center">:</td>
     <td width="50%" align="left"><b><input type="text" name="community" class="ss" style="width:300px;" value="<?php echo $community; ?>" /></b></td>
    </tr>
    <tr>
     <td width="3%" align="left">6.</td>
     <td colspan="2" width="45%" align="left">Sex</td>
     <td width="2%" align="center">:</td>
     <td width="50%" align="left"><b><input type="text" name="sex" class="ss" style="width:300px;" value="<?php echo $sex; ?>" /></b></td>
    </tr>
    <tr>
     <td width="3%" align="left">7.</td>
     <td colspan="2" width="45%" align="left">Date of Birth as entered in the admission Register</td>
     <td width="2%" align="center">:</td>
     <td width="50%" align="left"><b><input type="text" name="dob" class="ss" style="width:300px;" value="<?php echo $dob; ?>" /></b></td>
    </tr>
    <tr>
     <td width="3%" align="left"></td>
     <td width="2%" align="left"> </td>
     <td width="43%" align="left">in figures and words</td>
     <td width="2%" align="center">:</td>
     <td width="50%" align="left"><b><input type="text" name="dobinwords" class="ss" style="width:300px;" value="<?php echo $dobinwords; ?>" /></b></td>
    </tr>
    <tr>
     <td width="3%" align="left">8.</td>
     <td colspan="2" width="45%" align="left">Personal Marks of Identification</td>
     <td width="2%" align="center"></td>
     <td width="50%" align="left"></td>
    </tr>
    <tr>
     <td width="3%" align="left"></td>
     <td width="2%" align="left">a) </td>
     <td width="43%" align="left">Identification Mark 1</td>
     <td width="2%" align="center">:</td>
     <td width="50%" align="left"><b><input type="text" name="idmark1" class="ss" style="width:300px;" value="<?php echo trim($idmark1); ?>" /></b></td>
    </tr>
    <tr>
     <td width="3%" align="left"></td>
     <td width="2%" align="left">b) </td>
     <td width="43%" align="left">Identification Mark 2</td>
     <td width="2%" align="center">:</td>
     <td width="50%" align="left"><b><input type="text" name="idmark2" class="ss" style="width:300px;" value="<?php echo trim($idmark2); ?>" /></b></td>
    </tr>
    <tr valign="top">
     <td width="3%" align="left">9.</td>
     <td colspan="2" width="45%" align="left">Date of admission and standard in which admitted<br />(the year to be entered in words)</td>
     <td width="2%" align="center">:</td>
     <td width="50%" align="left"><b><input type="text" name="adate" class="ss" style="width:100px;" value="<?php echo trim($adate); ?>" />-<input type="text" name="aclass" class="ss" style="width:188px;" value="<?php echo trim($aclass); ?>" /><br /><input type="text" name="adatewords" class="ss" style="width:300px;" value="<?php echo trim($adatewords); ?>" /></b></td>
    </tr>
    <tr valign="top">
     <td width="3%" align="left">10.</td>
     <td width="2%" align="left">a) </td>
     <td width="43%" align="left">Standard in which the pupil was studying at<br /> the time of leaving (in words)</td>
     <td width="2%" align="center">:</td>
     <td width="50%" align="left"><b><input type="text" name="currentclass" class="ss" style="width:300px;" value="<?php echo $currentclass; ?>" /></b></td>
    </tr>
    <tr valign="top">
     <td width="3%" align="left"></td>
     <td width="2%" align="left">b) </td>
     <td width="43%" align="left">The course offered i.e. General Education<br /> or Vocational Education</td>
     <td width="2%" align="center">:</td>
     <td width="50%" align="left"><b><input type="text" name="gveducation" class="ss" style="width:300px;" value="<?php echo $gveducation; ?>" /></b></td>
    </tr>
    <tr valign="top">
     <td width="3%" align="left"></td>
     <td width="2%" align="left">c) </td>
     <td width="43%" align="left">In the case of General Education the subject<br /> offered under Part III Group A Medium of Instruction</td>
     <td width="2%" align="center">:</td>
     <td width="50%" align="left"><b><input type="text" name="gveducationmedium" class="ss" style="width:300px;" value="<?php echo $gveducationmedium; ?>" /></b></td>
    </tr>
    <tr valign="top">
     <td width="3%" align="left"></td>
     <td width="2%" align="left">d) </td>
     <td width="43%" align="left">In the case of Vocational Education, the <br /> Vocational subject Part III Group B <br />and the related subject offered under Part III Group A</td>
     <td width="2%" align="center">:</td>
     <td width="50%" align="left"><b><input type="text" name="veducation" class="ss" style="width:300px;" value="<?php echo $veducation; ?>" /></b></td>
    </tr>
    <tr valign="top">
     <td width="3%" align="left"></td>
     <td width="2%" align="left">e) </td>
     <td width="43%" align="left">Language offered under Part I</td>
     <td width="2%" align="center">:</td>
     <td width="50%" align="left"><b><input type="text" name="part1lang" class="ss" style="width:300px;" value="<?php echo $part1lang; ?>" /></b></td>
    </tr>
    <tr valign="top">
     <td width="3%" align="left"></td>
     <td width="2%" align="left">f) </td>
     <td width="43%" align="left">Medium of Study</td>
     <td width="2%" align="center">:</td>
     <td width="50%" align="left"><b><input type="text" name="medium" class="ss" style="width:300px;" value="<?php echo $medium; ?>" /></b></td>
    </tr>
    <tr>
     <td width="3%" align="left">11.</td>
     <td colspan="2" width="45%" align="left">Whether qualified for promotion to higher standard</td>
     <td width="2%" align="center">:</td>
     <td width="50%" align="left"><b><input type="text" name="isqualified" class="ss" style="width:300px;" value="<?php echo trim($isqualified); ?>" /></b></td>
    </tr>
    <tr>
     <td width="3%" align="left" valign="top">12.</td>
     <td colspan="2" width="45%" align="left" valign="top">Whether the pupil was in receipt of any scholarship<br /> (Nature of Scholarship to be specified)</td>
     <td width="2%" align="center">:</td>
     <td width="50%" align="left"><b><input type="text" name="scholarship" class="ss" style="width:300px;" value="<?php echo trim($scholarship); ?>" /></b></td>
    </tr>
    <tr>
     <td width="3%" align="left" valign="top">13.</td>
     <td colspan="2" width="45%" align="left" valign="top">Whether the pupil has undergone Medical<br /> Inspection during the last academic year<br /> (first of repeat to be specified)</td>
     <td width="2%" align="center">:</td>
     <td width="50%" align="left"><b><input type="text" name="medicalreport" class="ss" style="width:300px;" value="<?php echo trim($medicalreport); ?>" /></b></td>
    </tr>
    <tr>
     <td width="3%" align="left">14.</td>
     <td colspan="2" width="45%" align="left">Date of which the pupil actually left the school</td>
     <td width="2%" align="center">:</td>
     <td width="50%" align="left"><b><input type="text" name="dateofleft" class="ss" style="width:300px;" value="<?php echo trim($dateofleft); ?>" /></b></td>
    </tr>
    <tr>
     <td width="3%" align="left">15.</td>
     <td colspan="2" width="45%" align="left">The pupil's conduct and character</td>
     <td width="2%" align="center">:</td>
     <td width="50%" align="left"><b><input type="text" name="conductandcharacter" class="ss" style="width:300px;" value="<?php echo trim($conductandcharacter); ?>" /></b></td>
    </tr>
    <tr>
     <td width="3%" align="left" valign="top">16.</td>
     <td colspan="2" width="45%" align="left" valign="top">Date on which application for Transfer Certificate<br /> was made on behalf of the pupil by the parent<br />or guardian</td>
     <td width="2%" align="center">:</td>
     <td width="50%" align="left"><b><input type="text" name="dateoftcapplication" class="ss" style="width:300px;" value="<?php echo trim($dateoftcapplication); ?>" /></b></td>
    </tr>
    <tr>
     <td width="3%" align="left">17.</td>
     <td colspan="2" width="45%" align="left">Date of the Transfer Certificate</td>
     <td width="2%" align="center">:</td>
     <td width="50%" align="left"><b><input type="text" name="dateoftc" class="ss" style="width:300px;" value="<?php echo trim($dateoftc); ?>" /></b></td>
    </tr>
    <tr>
     <td width="3%" align="left">18.</td>
     <td colspan="2" width="45%" align="left">Course of Study</td>
     <td width="2%" align="center">:</td>
     <td width="50%" align="left"><b><input type="text" name="courseofstudy" class="ss" style="width:300px;" value="<?php echo trim($courseofstudy); ?>" /></b></td>
    </tr>
    <tr>
     <td width="100%" align="left" colspan="5">
   	<table border="1" width="100%">
         <tr>
          <td width="40%" align="center">Name of the School</td>
          <td width="15%" align="center">Academic Year (s)</td>
          <td width="15%" align="center">Standards(s) Studied</td>
          <td width="15%" align="center">First Language</td>
          <td width="15%" align="center">Medium of Instruction</td>
        </tr>
        <tr>
          <td><?php echo $schoolname.'<br />'.$schooladdress; ?></td>
          <td> <textarea class=""  style="width:150px;" id="" rows="2" cols="10" name="academicyears" maxlength=""><?php echo $academicyears; ?></textarea></td>
          <td> <textarea class=""  style="width:150px;" id="" rows="2" cols="10" name="standards" maxlength=""><?php echo $standards; ?></textarea></td>
          <td> <textarea class=""  style="width:150px;" id="" rows="2" cols="10" name="firstlanguage" maxlength=""><?php echo $firstlanguage; ?></textarea></td>
          <td> <textarea class=""  style="width:150px;" id="" rows="2" cols="10" name="medium" maxlength=""><?php echo $medium; ?></textarea></td>
        </tr>
       </table>
      </td>
    </tr>
    <tr height="70px" valign="bottom">
     <td width="3%" align="left">19.</td>
     <td colspan="2" width="45%" align="left">Signature of the Headmaster with date and school seal</td>
     <td width="2%" align="center"></td>
     <td width="50%" align="left"></td>
    </tr>

   </td>
  </table>
  </td>
</tr>
<tr>
  <td style="background-color:lightgrey;" align="center">
   <table border="0" width="98%">
    <tr>
     <td align="left">
      Note: Erasures and Unauthenticated or Fraudelent alterations in the Certificate will lead to its cancellation.
     </td>
    </tr>
    <tr height="50px" valign="bottom">
     <td align="center">
      <p style="font-size: 12pt;">DECLARATION BY THE PARENT OR GUARDIAN</p>
     </td>
    <tr>
     <td align="center">
      <p style="font-size: 10pt;">I hereby declare that the particulars recorded against items 2 to 7 are correct and that no change will be demanded by me in furture.</p>
     </td>
    </tr>
    <tr height="50px" valign="bottom">
     <td align="right">Signature of the Parent/Guardian
     </td>
    </tr>
   </table>
  </td>
</tr>
</table>


