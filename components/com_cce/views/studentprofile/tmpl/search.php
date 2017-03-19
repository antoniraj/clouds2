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
	$photoDir='components/com_cce/studentsphoto/';
	$Itemid = JRequest::getVar('Itemid');
	$namekey = JRequest::getVar('namekey');
	$modelcce = & $this->getModel();
	$st = $modelcce->getallStudent($students);
	$iconsDir1 = JURI::base() . 'components/com_cce/images';

   	$model = & $this->getModel('marks');
$modelcce = & $this->getModel();
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
   	$modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=students&Itemid='.$masterItemid);



?>
<!--
TOP LINKS....DASHBOARD
-->


<table width="100%" cellpadding="10">
        <tr style="border:none;">
                <td style="border:none;" align="left">
        <div style="float:left;">
           <img src="<?php echo $iconsDir.'/search.png'; ?>" alt="" style="width: 64px; height: 64px;" />
        </div>
        <div style="float:left;">
                <div>&nbsp;</div>
                <h1 class="item-page-title">Search Students</h1>
        </div>
                       <div style="float:right;"> <a href="<?php echo $dashboardlink; ?>"><img src="<?php echo $iconsDir1.'/1dashboard.png'; ?>" alt="Dash Board" style="width: 32px; height: 32px;" /></a><br />
			</div>
			<div style="float:right; width:10px;"> &nbsp;</div>
			<div style="float:right;">
                        <a href="<?php echo $modulelink; ?>"><img src="<?php echo $iconsDir1.'/1students.png'; ?>" alt="Master" style="width: 32px; height: 32px;" /></a><br />
			</div>
     

                </td>
        </tr>
</table>

</div>
			<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-user"></i> <strong>Search Students</strong></h2>
						<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
						</div>
					</div>
<div class="box-content">
	
<table class="table table-striped table-bordered  bootstrap-datatable datatable">
		 <thead>


<?php
echo '<tr><th>Reg.No</th><th>Name</th><th>Class</th><th>Photo</th><th width="15%">Operation</th></tr> </thead>';
foreach ($students as $student){
	$this->model->getStudentClass($student->id,$rec);
	$this->model->getStudentPhoto($student->id,$student->registerno);
        $link = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=studentprofile&controller=studentprofile&layout=profile&id='.$student->id);
	echo '<tr>';
	echo '<td style="vertical-align:middle;">'.$student->registerno.'</td>';
	echo '<td>'.$student->firstname.' '.$student->middlename.'</td>';
	echo '<td style="vertical-align:middle;">'.$rec->code.'</td><td>';
	?>
	 <?php
          	$filename=$modelcce->getsiglestudentphoto($studentrec->id,$file);
						        if($file->imagename)
						        {
						        ?>
         <img src="<?php echo  $photoDir.$file->scode.'.'.$file->ext;  ?>"  style="border:1px solid #000; width:70px;height:60px;margin-left:0px;" alt="photo"/>
  
        <?php
							     }
							     else{
							     ?>
        <img src="<?php echo $photoDir.'no-image.gif'; ?>"  style="border:1px solid #000; width:70px;height:60px;margin-left:0px;" alt="photo" />
        <?php 
							} 
			
	echo '</td>';
								echo '<td class="center hidden-phone">';
								 echo '<a class="btn btn-info" href="'.$link.'">';
								 echo '<i class="icon-zoom-in icon-white"></i>  View Profile	</a>';
								 echo '</td>';
	echo '</tr>';
}
echo '</table>';
if(!count($students)) echo "No records were found...";
?>
					</div>
				</div><!--/span-->
			
			</div><!--/row-->
