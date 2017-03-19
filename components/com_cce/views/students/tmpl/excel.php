<?php
        
defined('_JEXEC') OR DIE('Access denied..');

      header("Content-type: application/octet-stream");
      header("Pragma: no-cache");
      header("Expires: 0");


	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');
	JHTML::script('validate.js', 'components/com_cce/js/');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	$loader = JURI::base() . 'components/com_cce/loader/';
	$Itemid  = JRequest::getVar('Itemid');

	$iconsDir1 = JURI::base() . 'components/com_cce/images';
   	$photoDir = JURI::base() . 'components/com_cce/studentsphoto/';
   	$model = & $this->getModel('cce');
	$courseid = JRequest::getVar('courseid');
   	$dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
   	$modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=students&Itemid='.$masterItemid);

  	$studentslink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=students&view=students&task=display&Itemid='.$studentsItemid);
	$execllink = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=students&task=excel&controller=students&tmpl=component&layout=excel&courseid='.$this->courseid);

	$model->getSchoolInfo($screc);
    if(!$courseid)
    {
    $cstatus=$model->getCourse($this->courseid,$re);
	}
	else{
	 $cstatus=$model->getCourse($courseid,$re);	
	}
      header("Content-Disposition: attachment; filename=".$re->code.".xls");
?>


<table><tr><td colspan="55"><h2><?php echo $screc->schoolname.'-'.$screc->schooladdress.'<br />Class: '.$re->code.'<br />'; ?>   Students Information</h2></td></tr><tr><td colspan="55"></td></tr></table>
<table border="1">
    		<thead>
		      <tr bgcolor="#A4A4A4"> 
		        <th bgcolor="#A4A4A4" height="100">Reg.No</th>
		        <th>Admis.No</th>
		        <th>Admis.Date</th>
		        <th>Admit.Class</th>
		        <th>First Name</th>
		        <th>Middle Name</th>
		        <th>Last Name</th>
		        <th>DateOfBirth</th>
		        <th>Gender</th>
		        <th>BG</th>
		        <th>Place of Birth</th>
		        <th>Nationality</th>
		        <th>Mother Tongue</th>
		        <th>Caste</th>
		        <th>Religion</th>
		        <th>AddressLine1</th>
		        <th>AddressLine2</th>
		        <th>City</th>
		        <th>State</th>
		        <th>PIN</th>
		        <th>Country</th>
		        <th>Father Name</th>
		        <th>Father Phone</th>
		        <th>Father Mobile</th>
		        <th>Father EMail</th>
		        <th>Father Occupation</th>
		        <th>Mother Name</th>
		        <th>Mother Phone</th>
		        <th>Mother Mobile</th>
		        <th>Mother EMail</th>
		        <th>Mother Occupation</th>
		        <th>Gaurdian Name</th>
		        <th>Gaurdian Phone</th>
		        <th>Gaurdian Mobile</th>
		        <th>Gaurdian Occupation</th>
		        <th>SMS To</th>
		        <th>Identification1</th>
		        <th>Identification2</th>
		        <th>Aadhar No</th>
		        <th>Catid</th>
		        <th>Medium</th>
		        <th>Lang1</th>
		        <th>Lang2</th>
		        <th>Lang3</th>
		        <th>StudentAs</th>
		        <th>Community</th>
		        <th>ModeofTransport</th>
		        <th>PassportNo</th>
		        <th>Disability</th>
		        <th>DisadvantagedGroup</th>
		        <th>Father's DOB</th>
		        <th>Father's Income</th>
		        <th>Mother's DOB</th>
		        <th>Mother's Income</th>
		        <th>Emergency No</th>
		      </tr>
	    	</thead>
		<tbody>
	      <?php
		if($this->students){
			foreach($this->students as $rec) {
		?>
		<tr>
			<?php 
echo "<td>$rec->registerno</td>";
echo "<td>$rec->ano</td>";
$a = explode("-",$rec->adate);
$adate=$a[2].'-'.$a[1].'-'.$a[0];
echo "<td>$adate</td>";
echo "<td>$rec->admittedclass</td>";
echo "<td>$rec->firstname</td>";
echo "<td>$rec->middlename</td>";
echo "<td>$rec->lastname</td>";
$a = explode("-",$rec->dob);
$dob=$a[2].'-'.$a[1].'-'.$a[0];
echo "<td>$dob</td>";
echo "<td>$rec->gender</td>";
echo "<td>$rec->bloodgroup</td>";
echo "<td>$rec->birthplace</td>";
echo "<td>$rec->nationality</td>";
echo "<td>$rec->mothertongue</td>";
echo "<td>$rec->caste</td>";
echo "<td>$rec->religion</td>";
echo "<td>$rec->addressline1</td>";
echo "<td>$rec->addressline2</td>";
echo "<td>$rec->city</td>";
echo "<td>$rec->state</td>";
echo "<td>$rec->pincode</td>";
echo "<td>$rec->country</td>";
echo "<td>$rec->fathername</td>";
echo "<td>$rec->phone</td>";
echo "<td>$rec->mobile</td>";
echo "<td>$rec->email</td>";
echo "<td>$rec->focc</td>";
echo "<td>$rec->mothername</td>";
echo "<td>$rec->mphone</td>";
echo "<td>$rec->mmobile</td>";
echo "<td>$rec->memail</td>";
echo "<td>$rec->mocc</td>";
echo "<td>$rec->gname</td>";
echo "<td>$rec->gphone</td>";
echo "<td>$rec->gmobile</td>";
echo "<td>$rec->gocc</td>";
echo "<td>$rec->smsto</td>";
echo "<td>$rec->idmark</td>";
echo "<td>$rec->idmark2</td>";
echo "<td>$rec->aadharno</td>";
echo "<td>$rec->catid</td>";
echo "<td>$rec->medium</td>";
echo "<td>$rec->lang1</td>";
echo "<td>$rec->lang2</td>";
echo "<td>$rec->lang3</td>";
echo "<td>$rec->studentas</td>";
echo "<td>$rec->community</td>";
echo "<td>$rec->modeoftransport</td>";
echo "<td>$rec->passportno</td>";
echo "<td>$rec->disability</td>";
echo "<td>$rec->disadvantagedgroup</td>";
$a = explode("-",$rec->fdob);
$fdob=$a[2].'-'.$a[1].'-'.$a[0];
echo "<td>$fdob</td>";
echo "<td>$rec->fincome</td>";
$a = explode("-",$rec->mdob);
$mdob=$a[2].'-'.$a[1].'-'.$a[0];
echo "<td>$mdob</td>";
echo "<td>$rec->mincome</td>";
echo "<td>$rec->emergency</td>";
				?>
      </tr>
      <?php
								}
							}
							?>
    </tbody>
  </table>
