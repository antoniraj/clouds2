
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
	$pathway->addItem('Conduct Certificate');

	$pdf=JURI::Base()."components/com_cce/fpdf/tc.php?ano=1098&studentname=Sundaram M.&fathername=Mathalai Muthu&nationality=Indian&sex=Male&dob=10-10-2012&religion=Christian";
	$pdf3=JURI::Base()."components/com_cce/fpdf/conduct.php";


	
	$sno=$stu_rec->ano;
	if(strlen($sno)<1) $sno='???';
	$cdate=date('d-m-Y');
	if($stu_rec->gender=='F' || $stu_rec->gender=='Female' || $stu_rec->gender=='f' || $stu_rec->gender=='FEMALE' || $stu_rec->gender=='female')
	{
		$prefix='Selvi';
		$gen='her';
	}else{
		$prefix='Selvan';
		$gen='his';
	}
	$sname=$stu_rec->firstname.' '.$stu_rec->middlename.' '.$stu_rec->lastname;
	$beginyear=split("-",$stu_rec->adate)[0];
	$endyear=date('Y');
	if(strlen($stu_rec->admittedclass)==0)
		$beginclass='????';
	else
		$beginclass=$stu_rec->admittedclass;
	if($model->getStudentClass($studentid,$crec))
		$endclass=$crec->coursename;
	$conduct='Good';
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
<tr> 
<td align="left" style="font-size:115%"><b>Admission No: <input type="text" name="sno"  style="text-align:left;font-size:115%;width:<?php echo (strlen($sno)*12).'px'; ?>"  value="<?php echo $sno; ?>" /></b></td>
<td align="right" style="font-size:115%"><b>Date: <input type="text" name="cdate" style="text-align:right;font-size:115%;width:<?php echo (strlen($cdate)*12).'px'; ?>" value="<?php echo $cdate; ?>" /></b></td>
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
	<b><p style="font-size:150%">CONDUCT CERTIFICATE</p></b>
<br />
<br />
<br />
<p style="font-size:130%" >This is to certify that <input type="text" name="prefix" class="ss" style="width:<?php echo (strlen($prefix)*12).'px'; ?>" value="<?php echo $prefix; ?>" /> <input class="ss" type="text" name="sname"  style="width:<?php echo (strlen($sname)*12).'px'; ?>" value="<?php echo $sname; ?>" /> was studying in this school </p>

	<p style="font-size:130%"> from <input type="text" class="ss" style="width:<?php echo (strlen($beginyear)*12).'px'; ?>" name="beginyear" value="<?php echo $beginyear; ?>" /> to <input type="text" class="ss" name="endyear" style="width:<?php echo (strlen($endyear)*12).'px'; ?>" value="<?php echo $endyear; ?>" /> in <input type="text" name="beginclass" class="ss"  style="width:<?php echo (strlen($beginclass)*12).'px'; ?>" value="<?php echo $beginclass; ?>" /> STD to <input type="text" class="ss"  style="width:<?php echo (strlen($endclass)*12).'px'; ?>" name="endclass" value="<?php echo $endclass; ?>" /> STD and during this period <input type="text" class="ss"  style="width:<?php echo (strlen($gen)*12).'px'; ?>" name="gen" value="<?php echo $gen; ?>" /> </p>

	<p style="font-size:130%">Conduct and Character was 


<input type="text" class="ss" name="conduct" style="width:<?php echo (strlen($conduct)*25).'px'; ?>" value="<?php echo $conduct; ?>" />. </p>

</td>
</tr>
<tr><td align="right"><b><p style="font-size:120%">Principal</p></b></td></tr>
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
