<style type="text/css">
	.TFtable{
		width:100%; 
		border-collapse:collapse; 
		background:#FFF;
	}
	.TFtable td{ 
		padding:7px; border:#4e95f4 1px solid;
	}
	.TFtable th{ 
		background:#E8E8E8;
		padding:8px;
		border:1px solid #919191;
		font-size:14px;
		font-weight:bold;
	}
</style>
<?php
		$filename = date('d-m-Y').".xls";
	header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=hasil-export.xls");
?>
<?php
        defined('_JEXEC') OR DIE('Access denied..');
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	$Itemid  = JRequest::getVar('Itemid');
	$courseid=JRequest::getVar('courseid');

	$iconsDir1 = JURI::base() . 'components/com_cce/images';
   	$model = & $this->getModel('cce');
   	$dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
   	$modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=students&Itemid='.$masterItemid);

  	$studentslink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=students&view=students&task=display&Itemid='.$studentsItemid);


?>


<?php
	$model2=& $this->getModel('tngradebook');
	$model3=& $this->getModel('nmarks');
	$status=$model->getSchoolInfo($rec);
?>
<table>
<tr>
<td colspan="6">
<center>

                <h1 style="font-size:26px;"><strong><?php echo $rec->schoolname; ?></strong></h1>
                <h3><?php echo $rec->schooladdress; ?></h3>
</center>
</td>
</tr>
</table>

<table class="exam" width="100%">
<tr>
<?php if($this->re_type=="class"){ ?>
<td colspan="3"><b><h3>Class:  <?php echo $this->code; ?></h3></b></td>
<?php }else{ ?>
<td colspan="3"><b><h3>Caste:  <?php echo $this->reportkey; ?></h3></b></td>
<?php } ?>
<td colspan="3" align="right"><b><h3>Date:  <?php echo date('d-m-Y')?></h3></b></td></tr>
</tr>
</table> 
<br>
<form action="<?php echo JRoute::_('index.php?option=com_cce&controller=creports&courseid='.$this->courseid.'&task=actions&Itemid='.$Itemid); ?>" method="POST" name="adminForm">


<table width="100%" border="0" cellspacing="5" cellpadding="3" class="TFtable">


<tr>
        <th width="5%"><strong>S.No</strong></th>
        <th width="35%"><strong>Student Name</strong></th>
		<th width="10%"><strong>Gender</strong></th>
	<th width="10%"><strong>Father Name</strong></th>
       
        <th width="20%"><strong>Father Mobile</strong></th>
       
</tr>
        <?php
		if($this->students){
		   $sno=1;
                   foreach($this->students as $rec) {
        ?>
        <tr style="height:25px;">
                 <td>
<?php
		  echo $sno++ ."</td>";
                  echo "<td>$rec->firstname&nbsp;$rec->middlename&nbsp;$rec->lastname</td>";
                 echo "<td>$rec->gender</td>";
                 echo "<td>$rec->pfathername</td>";
                 echo "<td>$rec->mobile</td>";
                 
?>
        </tr>
        <?php 
		  }
		}
	 ?>
</table>
<br />
<br />
<br />
<table>
<tr>
<td colspan="6" align="right"><i>Class Teacher</i>
</td>
</tr>
</table>
