
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
	$pathway->addItem('Bonafied Certificate');

	$pdf=JURI::Base()."components/com_cce/fpdf/tc.php?ano=1098&studentname=Sundaram M.&fathername=Mathalai Muthu&nationality=Indian&sex=Male&dob=10-10-2012&religion=Christian";
	$pdf3=JURI::Base()."components/com_cce/fpdf/bonafide.php";


	
	$sno=$stu_rec->ano;
	$cdate=date('d-m-Y');
	if($stu_rec->gender=='F' || $stu_rec->gender=='Female' || $stu_rec->gender=='f' || $stu_rec->gender=='FEMALE' || $stu_rec->gender=='female'){
		$gen='Female';
	}
	if($stu_rec->gender=='M' || $stu_rec->gender=='Male' || $stu_rec->gender=='f' || $stu_rec->gender=='MALE' || $stu_rec->gender=='male'){
		$gen='Male';
	}
	$sname=$stu_rec->firstname.' '.$stu_rec->middlename.' '.$stu_rec->lastname;
	if($model->getStudentClass($studentid,$crec))
		$class=$crec->code;

	if(strlen(trim($stu_rec->pfathername))>2)
                $parentname=$stu_rec->pfathername;
        else if(strlen(trim($stu_rec->mothername))>2)
                $parentname=$stu_rec->mothername;
        else if(strlen(trim($stu_rec->gname))>2)
                $parentname=$stu_rec->gname;
        else $parentname = '';

	$academicyear = $model->getCurrentAcademicyear1();
	$a = split('-',$stu_rec->dob);
	$dob=$a[2].'-'.$a[1].'-'.$a[0];

?>

<style>
input.ss{
background-color:white;
text-align:left;
border:2px;
font-size:110%;
}
</style>
<!--
<A href="javascript: window.open('<?php echo $pdf; ?>','','status=no, target=miniwin;targetfeatures=toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=0,width=600,height=600,'); void('');" )>HELLO</a>
<A href="javascript: window.open('<?php echo $pdf2; ?>','','status=no, target=miniwin;targetfeatures=toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=0,width=600,height=600,'); void('');" )>HELLO1</a>
-->
<form  class="form-horizontal" action="<?php echo $pdf3; ?>"  enctype="multipart/form-data" method="POST" name="addform" id="addform" onSubmit="return checkform()">
<div style="float:right;">
<input class="btn btn-small btn-warning" type="submit" name="print2" value="PRINT" />
<input class="btn btn-small btn-primary" type="submit" name="print1" value="PRINT ALL" />
</div>
<br />
<br />
<br />
<center>
<table border="1" width="75%">
<tr height="90px">
<td align="center">
<table border="0" width="70%">
<tr>
<td align="center" colspan="2">
<?php
	echo '<b><p style="font-size:150%">'.$schoolinfo->schoolname.'</p></b>';
	echo '<b><p style="font-size:120%">'.$schoolinfo->schooladdress.'</p></b>';
?>
<input type="hidden" name="schoolname" value="<?php echo $schoolinfo->schoolname; ?>" />
<input type="hidden" name="schooladdress" value="<?php echo $schoolinfo->schooladdress; ?>" />
</td>
</tr>
</table>
<tr>
<td style="background-color:lightgrey;" align="center">
<table border="0" width="80%">
<tr height="300px" >
<td align="center" valign="top">
<p> </p>
<p> </p>
<br />
	<b><p style="font-size:150%">BONAFIED CERTIFICATE</p></b>
<br />
<table border="0" width="100%">
	<tr>
		<td width="2%"> 1. </td>
		<td width="48%"> Name of the Student</td>
		<td width="2%"> :</td>
		<td width="48%">
			<p style="font-size:130%" ><input type="text" name="sname" class="ss" style="width:300px;" value="<?php echo $sname; ?>" /> 
		</td>
	</tr>
	<tr>
		<td width="2%"> 2. </td>
		<td width="48%"> Gender</td>
		<td width="2%"> :</td>
		<td width="48%">
			<p style="font-size:130%" ><input type="text" name="gen" class="ss" style="width:300px;" value="<?php echo $gen; ?>" /> 
		</td>
	</tr>
	<tr>
		<td width="2%"> 3. </td>
		<td width="48%"> Admission No.</td>
		<td width="2%"> :</td>
		<td width="48%">
			<p style="font-size:130%" ><input type="text" name="ano" class="ss" style="width:300px;" value="<?php echo $sno; ?>" /> 
		</td>
	</tr>
	<tr>
		<td width="2%"> 4. </td>
		<td width="48%"> Class and Section</td>
		<td width="2%"> :</td>
		<td width="48%">
			<p style="font-size:130%" ><input type="text" name="class" class="ss" style="width:300px;" value="<?php echo $class; ?>" /> 
		</td>
	</tr>
	<tr>
		<td width="2%"> 5. </td>
		<td width="48%"> Academic Year</td>
		<td width="2%"> :</td>
		<td width="48%">
			<p style="font-size:130%" ><input type="text" name="academicyear" class="ss" style="width:300px;" value="<?php echo $academicyear; ?>" /> 
		</td>
	</tr>
	<tr>
		<td width="2%"> 6. </td>
		<td width="48%"> Parent Name</td>
		<td width="2%"> :</td>
		<td width="48%">
			<p style="font-size:130%" ><input type="text" name="parentname" class="ss" style="width:300px;" value="<?php echo $parentname; ?>" /> 
		</td>
	</tr>
	<tr>
		<td width="2%"> 7. </td>
		<td width="48%"> Date of Birth</td>
		<td width="2%"> :</td>
		<td width="48%">
			<p style="font-size:130%" ><input type="text" name="dob" class="ss" style="width:300px;" value="<?php echo $dob; ?>" /> 
		</td>
	</tr>
	<tr>
		<td width="2%"> 8. </td>
		<td width="48%"> Cast and Religion</td>
		<td width="2%"> :</td>
		<td width="48%">
			<p style="font-size:130%" ><input type="text" name="casteandreligion" class="ss" style="width:300px;" value="<?php echo $stu_rec->caste.', '.$stu_rec->religion; ?>" /> 
		</td>
	</tr>
</table>
</td>
</tr>
<tr height="50px" valign="bottom"><td align="center"><p style="font-size:120%">This is to certify that the above statements are true according to the school records.</p></td></tr>
<tr height="100px" valign="bottom"><td align="right"><b><p style="font-size:120%">Signature of the Headmaster</p></b></td></tr>
<tr><td align="left"><p style="font-size:120%">Place: <input type="text" name="place" class="ss" style="width:200px;" value="<?php echo $schoolinfo->schooladdress; ?>" /></td></tr>
<tr><td width="10%" align="left"><p style="font-size:120%">Date&nbsp;: <input type="text" name="cdate" class="ss" style="width:200px;" value="<?php echo date('d-m-Y'); ?>" /></td></tr>
</table>


</td>
</tr>
</table>

</td>
</tr>
</table>
</center>
    <!--alert-->

    </form>
  </div>
  <!--report-preview--> 
</div>
