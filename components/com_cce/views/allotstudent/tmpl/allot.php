<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
        <title>Libchart line demonstration</title>
        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-15" />
</head>
<body>

<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	$studentphoto = JURI::base() . 'components/com_cce/studentsphoto';
	$Itemid = JRequest::getVar('Itemid');
	$namekey = JRequest::getVar('namekey');
	$students = $this->model->searchStudents($namekey);
	$iconsDir1 = JURI::base() . 'components/com_cce/images';

   	$model = & $this->getModel('marks');

   	$dashboardItemid = $model->getMenuItemid('manageschool','Dash Board');
   	if($dashboardItemid) ;
   	else{
        	$dashboardItemid = $model->getMenuItemid('topmenu','Manage School');
   	}
	$masterItemid = $model->getMenuItemid('master','Students Details');
        if($masterItemid) ;
        else{
                $masterItemid = $model->getMenuItemid('topmenu','Manage School');
        }

   	$dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
   	$busroutelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=transport&Itemid='.$masterItemid);



?>
<!--
TOP LINKS....DASHBOARD
-->

<table width="100%" border="0">
        <tr>
                <td align="left">
        <div style="float:left;">
           <img src="<?php echo $iconsDir.'/transportdetails.png'; ?>" alt="" style="width: 64px; height: 64px;" />
        </div>
        <div style="float:left;">
                <div>&nbsp;</div>
                <h1 class="item-page-title">User Details</h1>
        </div>
                       <div style="float:right;"> <a href="<?php echo $dashboardlink; ?>"><img src="<?php echo $iconsDir1.'/1dashboard.png'; ?>" alt="Dash Board" style="width: 32px; height: 32px;" /></a><br />
			</div>
            <div style="float:right; width:10px;"> &nbsp;</div>
			<div style="float:right;">
                        <a href="<?php echo $busroutelink; ?>"><img src="<?php echo $iconsDir1.'/1transport.png'; ?>" alt="Master" style="width: 32px; height: 32px;" /></a><br />
			</div>
		
	
</td>
</tr>
</table>
<br />
<br />
<form action="" method="POST" name="addform" id="addform">
<div style="float: right;"> 
	<div style="float:right;">
		Enter a portion of the Name:<input type="text" name="namekey" id="namekey" onChange="submit();" value="<?php echo $namekey; ?>" /> <input type="submit" class="button_go" value="Search" name="search" />
	</div>
</div>	
	<input type="hidden" id="Itemid" name="Itemid" value="<?php echo $Itemid; ?>" />
	<input type="hidden" id="controller" name="controller" value="studentprofile" />
	<input type="hidden" id="view" name="view" value="studentprofile" />
	<input type="hidden" name="task" id="task" value="display" />
</form>
<br />
<br />
<br />
<table style="width: 100%;">
<?php
echo '<tr><th class="list-title">Reg.No</th><th class="list-title">Name</th><th class="list-title">Class</th><th class="list-title">Operation</th></tr>';
foreach ($students as $student){
	$this->model->getStudentClass($student->id,$rec);
	$this->model->getStudentPhoto($student->id,$student->registerno);
        $link = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=studentprofile&controller=studentprofile&layout=profile&id='.$student->id);
	echo '<tr style="padding:20px;height:40px;">';
	echo '<td style="vertical-align:middle;">'.$student->registerno.'</td>';
	echo '<td style="vertical-align:middle;"><a href="'.$link.'">'.$student->firstname.'</a></td>';
	echo '<td style="vertical-align:middle;">'.$rec->code.'</td>';
	$assign = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=allotstudent&controller=allotstudent&layout=default&task=display&id='.$student->id.'&name='.$student->firstname.'',false);
	echo '<td><h4 style="color:#30a657;font-weight:bold;"><a href='.$assign.'>Assign</a></h4></td>';
	echo '</tr>';
}
echo '</table>';
if(!count($students)) echo "<br><center><span style='color:#dc3b3b;text-align:center;'>No records were found...</span></center>";
?>
